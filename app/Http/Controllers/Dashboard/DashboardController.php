<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan;
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
    $query = SKPDAnggaran::where('tahun_anggaran', $tahun)
      // Gunakan withSum pada relasi 'jalan pintas' yang baru kita buat
      ->withSum('laporan as total_pagu', 'pagu')

      ->withSum('laporan as nilai_kontrak_tender', 'nilai_kontrak_tender')
      ->withSum('laporan as realisasi_tender', 'realisasi_tender')

      ->withSum('laporan as nilai_kontrak_penunjukkan_langsung', 'nilai_kontrak_penunjukkan_langsung')
      ->withSum('laporan as realisasi_penunjukkan_langsung', 'realisasi_penunjukkan_langsung')

      ->withSum('laporan as nilai_kontrak_swakelola', 'nilai_kontrak_swakelola')
      ->withSum('laporan as realisasi_swakelola', 'realisasi_swakelola')

      ->withSum('laporan as nilai_kontrak_epurchasing', 'nilai_kontrak_epurchasing')
      ->withSum('laporan as realisasi_epurchasing', 'realisasi_epurchasing')

      ->withSum('laporan as nilai_kontrak_pengadaan_langsung', 'nilai_kontrak_pengadaan_langsung')
      ->withSum('laporan as realisasi_pengadaan_langsung', 'realisasi_pengadaan_langsung')

      ->withAvg('laporan as presentasi_realisasi_fisik', 'presentasi_realisasi_fisik');


    // 3. Terapkan filter berdasarkan SKPD jika ada yang dipilih (oleh admin).
    if ($skpdId) {
      $query->where('skpd_id', $skpdId);
    }

    // 4. Eksekusi kueri dan kumpulkan hasil kalkulasinya dari database.
    $anggaranData = $query->get();

    // Kalkulasi total menjadi sangat sederhana
    $total_pagu           = $anggaranData->sum('total_pagu');
    $tender               = $anggaranData->sum('nilai_kontrak_tender') + $anggaranData->sum('realisasi_tender');
    $penunjukkan_langsung = $anggaranData->sum('nilai_kontrak_penunjukkan_langsung') + $anggaranData->sum('realisasi_penunjukkan_langsung');
    $swakelola            = $anggaranData->sum('nilai_kontrak_swakelola') + $anggaranData->sum('realisasi_swakelola');
    $epurchasing          = $anggaranData->sum('nilai_kontrak_epurchasing') + $anggaranData->sum('realisasi_epurchasing');
    $pengadaan_langsung   = $anggaranData->sum('nilai_kontrak_pengadaan_langsung') + $anggaranData->sum('realisasi_pengadaan_langsung');

    $all_skpd = SKPD::orderBy('nama')->pluck('singkatan', 'id');

    $total_jenis_paket = $tender + $penunjukkan_langsung + $swakelola + $epurchasing + $pengadaan_langsung;
    $realisasi_fisik   = format_persen($anggaranData->sum('presentasi_realisasi_fisik'));

    if (Auth::user()->role == 'admin' && !request('skpd'))
      $realisasi_fisik = $realisasi_fisik / max(count($all_skpd), 1);

    return view('dashboard.dashboard', [
      'total_pagu'           => $total_pagu,
      'tender'               => $tender,
      'penunjukkan_langsung' => $penunjukkan_langsung,
      'swakelola'            => $swakelola,
      'epurchasing'          => $epurchasing,
      'pengadaan_langsung'   => $pengadaan_langsung,
      'skpd'                 => $skpdId ? SKPD::with('users')->find($skpdId) : null,
      'all_skpd'             => $all_skpd,
      'total_jenis_paket'    => $total_jenis_paket,
      'realisasi_fisik'      => $realisasi_fisik,
    ]);
  }
}
