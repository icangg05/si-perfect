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
      ->withCount('laporan');

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
    $skpd_anggaran = $query->paginate(10)->withQueryString();

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
    $skpd_anggaran = SKPDAnggaran::with('laporan.sub_kategori_laporan.kategori_laporan')->findOrFail($id);

    // Group laporan berdasarkan kategori_laporan
    $grouped = $skpd_anggaran->laporan
      ->groupBy(function ($laporan) {
        return $laporan->sub_kategori_laporan->kategori_laporan->nama ?? 'Tanpa Kategori';
      })
      ->map(function ($laporans) {
        return $laporans->groupBy(function ($laporan) {
          return $laporan->sub_kategori_laporan->nama ?? 'Tanpa Sub Kategori';
        });
      });

    $title = 'Hapus data!';
    $text  = "Hapus item anggaran?";
    confirmDelete($title, $text);

    return view('dashboard.laporan-realisasi-item', compact('skpd_anggaran', 'grouped'));
  }


  /**
   * Handle show view create laporan item
   */
  public function createLaporanItem($id)
  {
    $skpd_anggaran    = SKPDAnggaran::findOrFail($id);
    $kategori_laporan = KategoriLaporan::with('sub_kategori_laporan')
      ->whereHas('sub_kategori_laporan')
      ->orderBy('id')
      ->get();

    $kategori = $kategori_laporan->firstWhere('id', request('kategori') ?? $kategori_laporan->first()->id);
    abort_if(!$kategori, 404);


    return view('dashboard.create-laporan-realisasi-item', compact('skpd_anggaran', 'kategori_laporan', 'kategori'));
  }


  /**
   * Handle store new laporan item
   */
  public function storeLaporanItem(Request $request, $id)
  {
    $request->validate([
      'sub_kategori_laporan_id'   => 'required|array',
      'no'                        => 'required|array',
      'nama_pekerjaan'            => 'required|array',
      'pagu'                      => 'required|array',
    ]);

    // Looping semua row item
    foreach ($request->no as $index => $no) {
      Laporan::create([
        'skpd_anggaran_id'                   => $id,
        'sub_kategori_laporan_id'            => $request->sub_kategori_laporan_id[$index] ?? null,
        'no'                                 => $no,
        'nama_pekerjaan'                     => $request->nama_pekerjaan[$index] ?? null,
        'pagu'                               => $request->pagu[$index] ?? null,
        'no_kontrak'                         => $request->no_kontrak[$index] ?? null,
        'tgl_mulai_kontrak'                  => $request->tgl_mulai_kontrak[$index] ?? null,
        'tgl_berakhir_kontrak'               => $request->tgl_berakhir_kontrak[$index] ?? null,
        'nilai_kontrak_tender'               => $request->nilai_kontrak_tender[$index] ?? null,
        'realisasi_tender'                   => $request->realisasi_tender[$index] ?? null,
        'nilai_kontrak_penunjukkan_langsung' => $request->nilai_kontrak_penunjukkan_langsung[$index] ?? null,
        'realisasi_penunjukkan_langsung'     => $request->realisasi_penunjukkan_langsung[$index] ?? null,
        'nilai_kontrak_swakelola'            => $request->nilai_kontrak_swakelola[$index] ?? null,
        'realisasi_swakelola'                => $request->realisasi_swakelola[$index] ?? null,
        'nilai_kontrak_epurchasing'          => $request->nilai_kontrak_epurchasing[$index] ?? null,
        'realisasi_epurchasing'              => $request->realisasi_epurchasing[$index] ?? null,
        'nilai_kontrak_pengadaan_langsung'   => $request->nilai_kontrak_pengadaan_langsung[$index] ?? null,
        'realisasi_pengadaan_langsung'       => $request->realisasi_pengadaan_langsung[$index] ?? null,
        'presentasi_realisasi_fisik'         => $request->presentasi_realisasi_fisik[$index] ? $request->presentasi_realisasi_fisik[$index] / 100 : null,
        'sumber_dana'                        => $request->sumber_dana[$index] ?? null,
        'keterangan'                         => $request->keterangan[$index] ?? null,
      ]);
    }


    alert()->success('Sukses!', 'Item anggaran berhasil ditambahkan.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->route('dashboard.laporan-realisasi-item', $id);
  }


  /**
   * Handle update main data laporan
   */
  public function updateDataLaporan(Request $request, $id)
  {
    $request->validate([
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
      'no'                   => ['required', 'numeric', 'min:1'],
      'nama_pekerjaan'       => ['required', 'max:100'],
      'no_kontrak'           => ['nullable', 'max:100'],
      'tgl_mulai_kontrak'    => ['nullable', 'date', 'before_or_equal:tgl_berakhir_kontrak'],
      'tgl_berakhir_kontrak' => ['nullable', 'date', 'after_or_equal:tgl_mulai_kontrak'],
      'sumber_dana'          => ['nullable', 'max:50'],
      'keterangan'           => ['nullable', 'max:191'],
      'pagu'                 => ['required', 'numeric', 'min:500'],
    ], [
      'no.required'                         => 'No. wajib diisi.',
      'no.min'                              => 'No. minimal 1.',
      'nama_pekerjaan.required'             => 'Nama pekerjaan wajib diisi.',
      'nama_pekerjaan.max'                  => 'Nama pekerjaan maksimal 255 karakter.',
      'tgl_mulai_kontrak.before_or_equal'   => 'Tanggal mulai kontrak harus sebelum atau sama dengan tanggal berakhir.',
      'tgl_berakhir_kontrak.after_or_equal' => 'Tanggal berakhir kontrak harus setelah atau sama dengan tanggal mulai.',
    ]);

    $validator->after(function ($validator) use ($request) {
      if ((
        $request->nilai_kontrak_tender + $request->realisasi_tender +
        $request->nilai_kontrak_penunjukkan_langsung + $request->realisasi_penunjukkan_langsung +
        $request->nilai_kontrak_swakelola + $request->realisasi_swakelola +
        $request->nilai_kontrak_epuchasing + $request->realisasi_epuchasing +
        $request->nilai_kontrak_pengadaan_langsung + $request->realisasi_pengadaan_langsung
      ) > $request->pagu) {
        $validator->errors()->add('pagu', 'Jumlah nilai kontrak dan realisasi tidak boleh melebihi pagu.');
      }
    });

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput()->with('row_id', $id);
    }


    // Update item anggaran
    $item_anggaran = Laporan::findOrFail($id);
    $data          = $request->all();

    $data['presentasi_realisasi_fisik'] = $request->presentasi_realisasi_fisik / 100;
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
}
