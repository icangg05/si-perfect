<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan;
use App\Models\Laporan;
use App\Models\SKPDAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LaporanRealisasiController extends Controller
{
  /**
   * Handle show view laporan realisasi
   */
  public function index(Request $request)
  {
    $query = SKPDAnggaran::with('skpd')
      ->orderBy('tahun_anggaran', 'desc')
      ->orderBy('bulan_anggaran', 'desc')
      ->withCount('laporan');

    // Tampilkan semua data jika admin
    if (Auth::user()->role != 'admin')
      $query = $query->where('skpd_id', Auth::user()->skpd->id);

    // Pencarian umum
    if ($request->filled('search')) {
      $search = $request->search;

      $query->where(function ($q) use ($search) {
        $q->where('tahun_anggaran', 'like', "%{$search}%")
          ->orWhere('bulan_anggaran', 'like', "%{$search}%")
          ->orWhere('jenis_pengadaan', 'like', "%{$search}%");

        // Cari berdasarkan SKPD hanya untuk admin
        if (Auth::user()?->role === 'admin') {
          $q->orWhereHas('skpd', function ($skpdQuery) use ($search) {
            $skpdQuery->where('nama', 'like', "%{$search}%");
          });
        }
      });
    }

    // Filter bulan
    if ($request->filled('bulan')) {
      $query->where('bulan_anggaran', $request->bulan);
    }

    // Pagination dengan query string supaya filter tidak hilang
    $skpd_anggaran = $query->paginate(15)->withQueryString();

    return view('dashboard.laporan-realisasi', compact('skpd_anggaran'));
  }


  /**
   * Handle create laporan realisasi
   */
  public function buatLaporan(Request $request)
  {
    // Validasi input
    $request->validate([
      'skpd_id'         => ['required', 'exists:skpd,id'],
      'jenis_pengadaan' => ['required', 'string', 'max:255'],
      'tahun_anggaran'  => ['required', 'integer', 'digits:4'],
      'bulan_anggaran'  => ['required', 'integer', 'between:1,12'],
    ], [
      'skpd_id.required'         => 'SKPD wajib dipilih.',
      'skpd_id.exists'           => 'SKPD tidak valid.',
      'jenis_pengadaan.required' => 'Jenis pengadaan wajib diisi.',
      'tahun_anggaran.required'  => 'Tahun anggaran wajib diisi.',
      'bulan_anggaran.required'  => 'Bulan anggaran wajib dipilih.',
    ]);

    // Simpan data
    SKPDAnggaran::create([
      'skpd_id'         => $request->skpd_id,
      'jenis_pengadaan' => $request->jenis_pengadaan,
      'tahun_anggaran'  => $request->tahun_anggaran,
      'bulan_anggaran'  => $request->bulan_anggaran,
    ]);

    // Notifikasi sukses
    alert()->success('Sukses!', 'Laporan realisasi berhasil ditambahkan.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back();
  }


  /**
   * Handle show view item laporan
   */
  public function buatLaporanItem($id)
  {
    $skpd_anggaran = SKPDAnggaran::with([
      'kategori_laporan' => function ($query) {
        $query->orderBy('urutan');
      },
      'kategori_laporan.laporan',
      'skpd',
    ])->findOrFail($id);


    // 1. Ambil semua kategori dari database untuk SKPD tertentu
    $kategori = KategoriLaporan::where('skpd_anggaran_id', $skpd_anggaran->id)
      ->orderBy('urutan', 'asc')
      ->get();

    // 2. Ubah koleksi flat menjadi struktur pohon (tree)
    $kategoriTree = $this->buildTree($kategori);

    abort_if(Auth::user()->role != 'admin' && $skpd_anggaran->skpd_id != Auth::user()->skpd->id, 404);


    $title = 'Hapus data!';
    $text  = "Hapus item anggaran?";
    confirmDelete($title, $text);

    // SKPD Anggaran untuk pilih struktur anggaran
    $skpd_anggaran_list = SKPDAnggaran::where('skpd_id', $skpd_anggaran->skpd_id)
      ->where('id', '!=', $skpd_anggaran->id)
      ->whereHas('kategori_laporan')
      ->orderBy('bulan_anggaran', 'asc')
      ->orderBy('tahun_anggaran', 'asc')
      ->get();

    return view('dashboard.laporan-realisasi-item.index', compact(
      'skpd_anggaran',
      'kategoriTree',
      'skpd_anggaran_list'
    ));
  }


  /**
   * Handle salin struktur anggaran
   */
  public function salinStrukturAnggaran(Request $request)
  {
    $kategoriLama = KategoriLaporan::where('skpd_anggaran_id', $request->skpd_anggaran_id_template)
      ->orderBy('level')
      ->orderBy('urutan')
      ->get();

    // mapping: id_lama => id_baru
    $idMapping = [];

    foreach ($kategoriLama as $item) {

      // Tentukan parent baru (mapping dari parent lama)
      $parentBaru = $item->parent ? ($idMapping[$item->parent] ?? null) : null;

      // Buat data baru
      $baru = KategoriLaporan::create([
        'skpd_anggaran_id' => $request->skpd_anggaran_id,
        'nama'             => $item->nama,
        'parent'           => $parentBaru,
        'level'            => $item->level,
        'urutan'           => $item->urutan,
      ]);

      // Simpan mapping ID lama → baru
      $idMapping[$item->id] = $baru->id;
    }


    alert()->success('Sukses!', 'Struktur anggaran berhasil disalin.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back()->with('active_tab', 'struktur-anggaran');
  }



  /**
   * Fungsi rekursif untuk membangun struktur pohon.
   *
   * @param \Illuminate\Database\Eloquent\Collection $elements
   * @param int|null $parentId
   * @return array
   */
  private function buildTree($elements, $parentId = null)
  {
    $branch = [];

    foreach ($elements as $element) {
      // Periksa apakah 'parent' dari elemen saat ini cocok dengan parentId yang dicari
      // Untuk item root, $parentId adalah null (atau 0, sesuaikan dengan data Anda)
      if ($element->parent == $parentId) {
        // Cari anak (children) dari elemen saat ini
        $children = $this->buildTree($elements, $element->id);

        if ($children) {
          // Jika ada anak, tambahkan ke properti 'children'
          $element->children = $children;
        }

        $branch[] = $element;
      }
    }

    return $branch;
  }


  /**
   * Handle show view create laporan item
   */
  public function createLaporanItem($id)
  {
    $skpd_anggaran = SKPDAnggaran::with('skpd')->findOrFail($id);
    abort_if(Auth::user()->role != 'admin' && $skpd_anggaran->skpd_id != Auth::user()->skpd->id, 404);
    $kategori_laporan = KategoriLaporan::where('skpd_anggaran_id', $skpd_anggaran->id)
      ->orderBy('urutan')
      ->get();

    return view('dashboard.create-laporan-realisasi-item', compact('skpd_anggaran', 'kategori_laporan'));
  }


  /**
   * Handle store new laporan item
   */
  public function storeLaporanItem(Request $request, $id)
  {
    // dd($request->all());
    $request->validate([
      'kategori_laporan_id' => 'required|array',
      'nama_pekerjaan'      => 'required|array',
      'pagu'                => 'required|array',
    ]);

    // Looping semua row item
    for ($i = 0; $i < count($request->kategori_laporan_id); $i++) {
      // dd((int) str_replace('.', '', $request->pagu[$i]));
      Laporan::create([
        'kategori_laporan_id'                => $request->kategori_laporan_id[$i] ?? null,
        'nama_pekerjaan'                     => $request->nama_pekerjaan[$i] ?? null,
        'pagu'                               => $request->pagu[$i] ?? null,
        'no_kontrak'                         => $request->no_kontrak[$i] ?? null,
        'tgl_mulai_kontrak'                  => $request->tgl_mulai_kontrak[$i] ?? null,
        'tgl_berakhir_kontrak'               => $request->tgl_berakhir_kontrak[$i] ?? null,
        'nilai_kontrak_tender'               => $request->nilai_kontrak_tender[$i] ?? null,
        'realisasi_tender'                   => $request->realisasi_tender[$i] ?? null,
        'nilai_kontrak_penunjukkan_langsung' => $request->nilai_kontrak_penunjukkan_langsung[$i] ?? null,
        'realisasi_penunjukkan_langsung'     => $request->realisasi_penunjukkan_langsung[$i] ?? null,
        'nilai_kontrak_swakelola'            => $request->nilai_kontrak_swakelola[$i] ?? null,
        'realisasi_swakelola'                => $request->realisasi_swakelola[$i] ?? null,
        'nilai_kontrak_epurchasing'          => $request->nilai_kontrak_epurchasing[$i] ?? null,
        'realisasi_epurchasing'              => $request->realisasi_epurchasing[$i] ?? null,
        'nilai_kontrak_pengadaan_langsung'   => $request->nilai_kontrak_pengadaan_langsung[$i] ?? null,
        'realisasi_pengadaan_langsung'       => $request->realisasi_pengadaan_langsung[$i] ?? null,
        'presentasi_realisasi_fisik'         => $request->presentasi_realisasi_fisik[$i] ? format_persen($request->presentasi_realisasi_fisik[$i] / 100) : null,
        'sumber_dana'                        => $request->sumber_dana[$i] ?? null,
        'keterangan'                         => $request->keterangan[$i] ?? null,
      ]);
    }


    alert()->success('Sukses!', 'Item anggaran berhasil ditambahkan.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->route('dashboard.laporan-realisasi-item', $id);
  }


  /**
   * Handle delete laporan realisasi
   */
  public function destroyLaporan($id)
  {
    $skpd_anggaran    = SKPDAnggaran::findOrFail($id);
    $skpd_anggaran->delete();

    alert()->success('Sukses!', 'Laporan realisasi berhasil dihapus.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->route('dashboard.laporan-realisasi');
  }


  /**
   * Handle update main data laporan
   */
  public function updateDataLaporan(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'jenis_pengadaan' => ['required'],
      'bulan_anggaran'  => ['required', 'numeric', 'between:1,12'],
      'tahun_anggaran'  => ['required', 'numeric', 'digits:4'],
    ], [
      'jenis_pengadaan.required' => 'Jenis pengadaan wajib diisi.',
      'bulan_anggaran.required'  => 'Bulan wajib diisi.',
      'bulan_anggaran.numeric'   => 'Bulan harus angka.',
      'bulan_anggaran.between'   => 'Bulan harus antara 1 - 12.',
      'tahun_anggaran.required'  => 'Tahun wajib diisi.',
      'tahun_anggaran.numeric'   => 'Tahun harus angka.',
      'tahun_anggaran.digits'    => 'Tahun harus terdiri dari 4 digit.',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput()->with('active_tab', 'data-utama');
    }

    $skpd_anggaran = SKPDAnggaran::findOrFail($id);
    $skpd_anggaran->update($request->all());


    alert()->success('Sukses!', 'Data utama anggaran berhasil diperbarui.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back()->with('active_tab', 'data-utama');
  }

  /**
   * Handle update item anggaran
   */
  public function updateLaporanItem(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'nama_pekerjaan'             => ['required', 'max:100'],
      'no_kontrak'                 => ['nullable', 'max:100'],
      'tgl_mulai_kontrak'          => ['nullable', 'date', 'before_or_equal:tgl_berakhir_kontrak'],
      'tgl_berakhir_kontrak'       => ['nullable', 'date', 'after_or_equal:tgl_mulai_kontrak'],
      'sumber_dana'                => ['nullable', 'max:50'],
      'keterangan'                 => ['nullable', 'max:191'],
      'pagu'                       => ['required'],
      'presentasi_realisasi_fisik' => ['required'],
    ], [
      'nama_pekerjaan.required'             => 'Nama pekerjaan wajib diisi.',
      'nama_pekerjaan.max'                  => 'Nama pekerjaan maksimal 255 karakter.',
      'tgl_mulai_kontrak.before_or_equal'   => 'Tanggal mulai kontrak harus sebelum atau sama dengan tanggal berakhir.',
      'tgl_berakhir_kontrak.after_or_equal' => 'Tanggal berakhir kontrak harus setelah atau sama dengan tanggal mulai.',
      'presentasi_realisasi_fisik'          => 'Presentasi realisasi fisik wajib diisi.'
    ]);

    $validator->after(function ($validator) use ($request) {
      if ((
        (int) str_replace('.', '', $request->realisasi_tender) +
        (int) str_replace('.', '', $request->realisasi_penunjukkan_langsung) +
        (int) str_replace('.', '', $request->realisasi_swakelola) +
        (int) str_replace('.', '', $request->realisasi_epurchasing) +
        (int) str_replace('.', '', $request->realisasi_pengadaan_langsung)
      ) > (int) str_replace('.', '', $request->pagu)) {
        $validator->errors()->add('pagu', 'Jumlah nilai realisasi tidak boleh melebihi pagu.');
      }
    });

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput()->with('row_id', $id);
    }


    // Update item anggaran
    $item_anggaran = Laporan::findOrFail($id);
    $data          = $request->all();

    $data['presentasi_realisasi_fisik'] = format_persen($request->presentasi_realisasi_fisik / 100);
    $item_anggaran->update($data);


    alert()->success('Sukses!', 'Item anggaran berhasil diperbarui.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back();
  }


  /**
   * Handle delete item angggaran
   */
  public function deleteLaporanItem($id)
  {
    $item_anggaran = Laporan::findOrFail($id);
    $item_anggaran->delete();

    alert()->success('Sukses!', 'Item anggaran berhasil dihapus.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back();
  }


  /**
   * Handle edit kategori item anggaran
   */
  public function editKategoriItem(Request $request, $id)
  {
    $laporan = Laporan::findOrFail($id);
    $laporan->update([
      'kategori_laporan_id' => $request->kategori_laporan_id,
    ]);

    alert()->success('Sukses!', 'Kategori item anggaran berhasil diperbarui.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back();
  }
}
