<?php

use App\Http\Controllers\Authenticate\LoginController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LaporanRealisasiController;
use App\Http\Controllers\Dashboard\PengaturanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::middleware('guest')->group(function () {
  Route::get('/login', [LoginController::class, 'index'])->name('login');
  Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});


Route::middleware('auth')->group(function () {
  Route::post('/export/{skpd_anggaran_id}', [BerandaController::class, 'export'])->name('export');
  Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('dashboard.pengaturan');
  Route::post('/pengaturan/{id}/update-user', [PengaturanController::class, 'updateUser'])->name('dashboard.update-user');
  Route::post('/pengaturan/{id}/update-skpd', [PengaturanController::class, 'updateSKPD'])->name('dashboard.update-skpd');
  Route::post('/pengaturan/{id}/update-password', [PengaturanController::class, 'updatePassword'])->name('dashboard.update-password');

  Route::get('/laporan-realisasi', [LaporanRealisasiController::class, 'index'])->name('dashboard.laporan-realisasi');
  Route::post('/laporan-realisasi', [LaporanRealisasiController::class, 'buatLaporan'])->name('dashboard.laporan-realisasi.store');
  Route::get('/laporan-realisasi/{id}', [LaporanRealisasiController::class, 'buatLaporanItem'])->name('dashboard.laporan-realisasi-item');
  Route::get('/laporan-realisasi/{id}/create', [LaporanRealisasiController::class, 'createLaporanItem'])->name('dashboard.create-item-anggaran');
  Route::post('/laporan-realisasi/{id}/store', [LaporanRealisasiController::class, 'storeLaporanItem'])->name('dashboard.store-item-anggaran');
  Route::patch('/laporan-realisasi/{id}', [LaporanRealisasiController::class, 'updateDataLaporan'])->name('dashboard.update-data-laporan');
  Route::post('/update-item-anggaran/{id}', [LaporanRealisasiController::class, 'updateLaporanItem'])->name('dashboard.update-item-anggaran');
  Route::delete('/delete-item-anggaran/{id}', [LaporanRealisasiController::class, 'deleteLaporanItem'])->name('dashboard.delete-item-anggaran');
});
