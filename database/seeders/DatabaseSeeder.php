<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      SKPDSeeder::class,
      UserSeeder::class,
      SKPDAnggaranSeeder::class,
      KategoriLaporanSeeder::class,
      LaporanSeeder::class,
    ]);
  }
}
