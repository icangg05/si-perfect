<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\SKPD;
use App\Models\SKPDAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class DashboardController extends Controller
{
  /**
   * Menampilkan halaman dashboard.
   *
   * @param Request $request
   * @return View
   */
  public function index(Request $request): View
  {
    // 1. Tentukan tahun anggaran dan ID SKPD yang akan ditampilkan.
    // Jika tidak ada request tahun, gunakan tahun saat ini.
    $tahun = $request->input('tahun', now()->year);

    // Jika user adalah 'skpd', gunakan ID-nya. Jika admin, ambil dari request.
    $skpdId = Auth::user()->role === 'skpd' ? Auth::user()->skpd->id : $request->input('skpd');

    // 2. Buat kueri dasar untuk mengambil data Anggaran SKPD.
    // Ini adalah langkah efisiensi utama: kalkulasi SUM dilakukan oleh database, bukan oleh PHP.
    $query = SKPDAnggaran::where('tahun_anggaran', $tahun)
      ->with([
        'laporan' => fn($query) => $query->select(
          'skpd_anggaran_id',
          // Meminta database untuk langsung menjumlahkan (SUM) kolom-kolom berikut.
          DB::raw('SUM(pagu) as total_pagu'),
          DB::raw('SUM(realisasi_tender) as total_tender'),
          DB::raw('SUM(realisasi_penunjukkan_langsung) as total_penunjukkan_langsung'),
          DB::raw('SUM(realisasi_swakelola) as total_swakelola'),
          DB::raw('SUM(realisasi_epurchasing) as total_epurchasing'),
          DB::raw('SUM(realisasi_pengadaan_langsung) as total_pengadaan_langsung')
        )->groupBy('skpd_anggaran_id')
      ]);

    // 3. Terapkan filter berdasarkan SKPD jika ada yang dipilih (oleh admin).
    // Jika $skpdId ada isinya, maka kueri akan difilter.
    if ($skpdId) {
      $query->where('skpd_id', $skpdId);
    }

    // 4. Eksekusi kueri dan kumpulkan hasil kalkulasinya dari database.
    $anggaranData = $query->get();

    // Panggil fungsi privat untuk menjumlahkan semua hasil dari $anggaranData.
    $data = $this->calculateTotals($anggaranData);

    // 5. Hitung metrik akhir berdasarkan total yang sudah didapat.
    $total_jenis_paket = $data['tender']
      + $data['penunjukkan_langsung']
      + $data['swakelola']
      + $data['epurchasing']
      + $data['pengadaan_langsung'];

    // Cek agar tidak terjadi pembagian dengan nol jika total pagu adalah 0.
    $realisasi_fisik = ($data['total_pagu'] > 0) ? ($total_jenis_paket / $data['total_pagu']) : 0;

    // 6. Siapkan semua data yang akan dikirim ke Blade view.
    $viewData = array_merge($data, [
      'skpd' => $skpdId ? SKPD::with('users')->find($skpdId) : null,
      'all_skpd' => SKPD::orderBy('nama')->pluck('singkatan', 'id'),
      'total_jenis_paket' => $total_jenis_paket,
      'realisasi_fisik' => $realisasi_fisik,
    ]);

    return view('dashboard.dashboard', $viewData);
  }

  /**
   * Menghitung dan menjumlahkan total dari koleksi data Anggaran SKPD.
   * Fungsi ini bertugas untuk mengagregasi hasil kueri.
   *
   * @param \Illuminate\Database\Eloquent\Collection $anggaranData
   * @return array
   */
  private function calculateTotals(\Illuminate\Database\Eloquent\Collection $anggaranData): array
  {
    // Siapkan array penampung dengan nilai awal 0.
    $totals = [
      'total_pagu' => 0,
      'tender' => 0,
      'penunjukkan_langsung' => 0,
      'swakelola' => 0,
      'epurchasing' => 0,
      'pengadaan_langsung' => 0,
    ];

    // Lakukan perulangan pada hasil kueri untuk mengakumulasi totalnya.
    foreach ($anggaranData as $item) {
      // Pastikan relasi 'laporan' ada isinya sebelum diakses.
      if ($laporan = $item->laporan->first()) {
        $totals['total_pagu'] += $laporan->total_pagu;
        $totals['tender'] += $laporan->total_tender;
        $totals['penunjukkan_langsung'] += $laporan->total_penunjukkan_langsung;
        $totals['swakelola'] += $laporan->total_swakelola;
        $totals['epurchasing'] += $laporan->total_epurchasing;
        $totals['pengadaan_langsung'] += $laporan->total_pengadaan_langsung;
      }
    }

    return $totals;
  }
}
