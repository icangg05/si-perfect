<?php

namespace Database\Seeders;

use App\Models\SKPD;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SKPDSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $data = [[
      'nama'                   => 'DINAS PERHUBUNGAN',
      'alamat'                 => null,
      'pimpinan_skpd'          => 'PAMINUDDIN, SE., M.Si.',
      'nip_pimpinan'           => '196909101993121001',
      'pangkat_pimpinan'       => 'Pembina Utama Muda',
      'golongan_pimpinan'      => 'IV/c',
      'jenis_kelamin_pimpinan' => 'L',
      'kontak_pimpinan'        => '081341770730',
    ]];

    foreach ($data as $item) {
      SKPD::create($item);
    }
  }
}
