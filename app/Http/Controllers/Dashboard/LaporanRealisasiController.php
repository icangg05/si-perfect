<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SKPDAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanRealisasiController extends Controller
{
  /**
   * Handle show view laporan realisasi
   */
  public function index(Request $request)
  {
    $query = SKPDAnggaran::with('skpd');

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

    // 📊 Pagination dengan query string supaya filter tidak hilang
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
}
