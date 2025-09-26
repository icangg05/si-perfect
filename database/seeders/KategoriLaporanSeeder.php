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
    $data = [
      [
        'id'               => 1,
        'skpd_anggaran_id' => 1,
        'nama'             => 'Paket Penyedia',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 1,
      ],
      [
        'id'               => 2,
        'skpd_anggaran_id' => 1,
        'nama'             => 'Paket Swakelola',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 3,
      ],
      [
        'id'               => 3,
        'skpd_anggaran_id' => 1,
        'nama'             => 'Paket Penyedia Terumumkan',
        'parent'           => 1,
        'level'            => 2,
        'urutan'           => 2,
      ],
      [
        'id'               => 4,
        'skpd_anggaran_id' => 1,
        'nama'             => 'Paket Swakelola Terumumkan',
        'parent'           => 2,
        'level'            => 2,
        'urutan'           => 4,
      ],
    ];

    foreach ($data as $item) {
      KategoriLaporan::create($item);
    }
  }
}
