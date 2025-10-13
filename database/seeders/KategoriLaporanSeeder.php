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
      [
        'id'               => 5,
        'skpd_anggaran_id' => 2,
        'nama'             => 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 1,
      ],
      [
        'id'               => 6,
        'skpd_anggaran_id' => 2,
        'nama'             => 'Kegiatan Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah',
        'parent'           => 5,
        'level'            => 2,
        'urutan'           => 2,
      ],
      [
        'id'               => 7,
        'skpd_anggaran_id' => 2,
        'nama'             => 'Administrasi Keuangan Perangkat Daerah',
        'parent'           => 5,
        'level'            => 2,
        'urutan'           => 3,
      ],
      [
        'id'               => 8,
        'skpd_anggaran_id' => 2,
        'nama'             => 'Administrasi Kepegawaian Perangkat Daerah',
        'parent'           => 5,
        'level'            => 2,
        'urutan'           => 4,
      ],
      [
        'id'               => 9,
        'skpd_anggaran_id' => 2,
        'nama'             => 'PROGRAM PEMBINAAN PERPUSTAKAAN',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 5,
      ],
      [
        'id'               => 10,
        'skpd_anggaran_id' => 2,
        'nama'             => 'Pengelolaan Perpustakaan Tingkat Daerah Kabupaten/Kota',
        'parent'           => 9,
        'level'            => 2,
        'urutan'           => 6,
      ],
      [
        'id'               => 11,
        'skpd_anggaran_id' => 2,
        'nama'             => 'Pembudayaan Gemar Membaca Tingkat Daerah Kabupaten/Kota',
        'parent'           => 9,
        'level'            => 2,
        'urutan'           => 7,
      ],
      [
        'id'               => 13,
        'skpd_anggaran_id' => 3,
        'nama'             => 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 1,
      ],
      [
        'id'               => 14,
        'skpd_anggaran_id' => 3,
        'nama'             => 'Administrasi Keuangan Perangkat Daerah Kode: 2.09...',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 4,
      ],
      [
        'id'               => 15,
        'skpd_anggaran_id' => 3,
        'nama'             => 'Penyusunan Dokumen Perencanaan Perangkat Daerah',
        'parent'           => 13,
        'level'            => 2,
        'urutan'           => 2,
      ],
      [
        'id'               => 16,
        'skpd_anggaran_id' => 3,
        'nama'             => 'Koordinasi dan Penyusunan Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja',
        'parent'           => 13,
        'level'            => 2,
        'urutan'           => 3,
      ],
      [
        'id'               => 17,
        'skpd_anggaran_id' => 3,
        'nama'             => 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi',
        'parent'           => 14,
        'level'            => 2,
        'urutan'           => 5,
      ],
      [
        'id'               => 18,
        'skpd_anggaran_id' => 3,
        'nama'             => 'Koordinasi dan Penyusunan Laporan Keuangan Bulanan dan Semesteran',
        'parent'           => 14,
        'level'            => 2,
        'urutan'           => 6,
      ],
      [
        'id'               => 19,
        'skpd_anggaran_id' => 4,
        'nama'             => 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 2,
      ],
      [
        'id'               => 20,
        'skpd_anggaran_id' => 4,
        'nama'             => 'Penyusunan Dokumen Perencanaan Perangkat Daerah',
        'parent'           => 19,
        'level'            => 2,
        'urutan'           => 2,
      ],
      [
        'id'               => 21,
        'skpd_anggaran_id' => 4,
        'nama'             => 'Koordinasi dan Penyusunan Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja',
        'parent'           => 19,
        'level'            => 2,
        'urutan'           => 3,
      ],
      [
        'id'               => 23,
        'skpd_anggaran_id' => 4,
        'nama'             => 'PROGRAM PENGELOLAAN PENDIDIKAN',
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 4,
      ],
      [
        'id'               => 24,
        'skpd_anggaran_id' => 4,
        'nama'             => 'Pembangunan Perpustakaan Sekolah',
        'parent'           => 23,
        'level'            => 2,
        'urutan'           => 5,
      ],
      [
        'id'               => 25,
        'skpd_anggaran_id' => 4,
        'nama'             => 'Pembangunan Sarana, Prasarana dan Utilitas Sekolah',
        'parent'           => 23,
        'level'            => 2,
        'urutan'           => 6,
      ],
      [
        'id'               => 26,
        'skpd_anggaran_id' => 4,
        'nama'             => 'Rehabilitasi Sedang/Berat Perpustakaan Sekolah',
        'parent'           => 23,
        'level'            => 2,
        'urutan'           => 7,
      ],
    ];

    foreach ($data as $item) {
      KategoriLaporan::create($item);
    }
  }
}
