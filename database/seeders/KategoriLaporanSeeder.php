<?php

namespace Database\Seeders;

use App\Models\KategoriLaporan;
use App\Models\SubKategoriLaporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriLaporanSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Kategori 1
    $data1 = KategoriLaporan::create([
      'nama' => 'Paket Penyedia',
    ]);
    $sub_1 = SubKategoriLaporan::create([
      'kategori_laporan_id' => $data1->id,
      'nama'                => 'Paket Penyedia Terumumkan',
    ]);


    // Kategori 2
    $data2 = KategoriLaporan::create([
      'nama' => 'Paket Swakelola',
    ]);
    $sub_1 = SubKategoriLaporan::create([
      'kategori_laporan_id' => $data2->id,
      'nama'                => 'Paket Swakelola Terumumkan',
    ]);
  }
}
