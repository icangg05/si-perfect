<?php

namespace Database\Seeders;

use App\Models\SKPDAnggaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SKPDAnggaranSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $data = [[
      'skpd_id'         => 1,
      'bulan_anggaran'  => 8,
      'tahun_anggaran'  => 2025,
      'jenis_pengadaan' => 'KONSTRUKSI, KONSULTANSI, BARANG DAN JASA LAINNYA'
    ]];

    foreach ($data as $item) {
      SKPDAnggaran::create($item);
    }
  }
}
