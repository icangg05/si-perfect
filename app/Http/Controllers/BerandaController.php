<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\SKPDAnggaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
    $skpd_anggaran = SKPDAnggaran::with([
      'kategori_laporan' => function ($query) {
        $query->orderBy('urutan');
      },
      'kategori_laporan.laporan',
      'skpd',
    ])->findOrFail($skpd_anggaran_id);

    $skpd_singkatan  = $skpd_anggaran->skpd->singkatan;
    $jenis_pengadaan = $skpd_anggaran->jenis_pengadaan;
    $bulan_anggaran  = Carbon::create()->month($skpd_anggaran->bulan_anggaran)->translatedFormat('F');
    $tahun_anggaran  = $skpd_anggaran->tahun_anggaran;

    $file_name = strtoupper("LAP REALISASI {$jenis_pengadaan} {$bulan_anggaran} {$skpd_singkatan} {$tahun_anggaran}.xlsx");
    // Hilangkan karakter yang tidak valid untuk nama file
    $file_name = preg_replace('/[\/\\\\]/', '-', $file_name);

    return Excel::download(new LaporanExport($skpd_anggaran), $file_name);
  }


  /**
   * Migrate
   */
  public function migrate()
  {
    try {
      Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
      ]);

      return response()->json([
        'status'  => 'success',
        'message' => 'Database berhasil di-migrate dan di-seed ulang.'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status'  => 'error',
        'message' => $e->getMessage()
      ], 500);
    }
  }
}
