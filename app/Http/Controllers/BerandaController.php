<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\SKPDAnggaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BerandaController extends Controller
{
  /**
   * INDEX
   */
  public function index()
  {
    return view('welcome');
  }


  /**
   * EXPORT
   */
  public function export($skpd_anggaran_id)
  {
    $skpd_anggaran = SKPDAnggaran::with(['skpd', 'laporan.sub_kategori_laporan.kategori_laporan'])->findOrFail($skpd_anggaran_id);

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

    $skpd_singkatan  = $skpd_anggaran->skpd->singkatan;
    $jenis_pengadaan = $skpd_anggaran->jenis_pengadaan;
    $bulan_anggaran  = Carbon::create()->month($skpd_anggaran->bulan_anggaran)->translatedFormat('F');
    $tahun_anggaran  = $skpd_anggaran->tahun_anggaran;

    $file_name = strtoupper("LAP REALISASI {$jenis_pengadaan} {$bulan_anggaran} {$skpd_singkatan} {$tahun_anggaran}.xlsx");

    return Excel::download(new UsersExport($skpd_anggaran, $grouped), $file_name);
  }
}
