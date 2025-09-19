<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Admin
    User::create([
      'skpd_id'  => null,
      'name'     => 'Administrator',
      'username' => 'admin',
      'email'    => 'admin@gmail.com',
      'password' => Hash::make('admin'),
      'role'     => 'admin',
    ]);

    // skpd
    User::create([
      'skpd_id'  => 1,
      'name'     => 'Dishub',
      'username' => 'dishub',
      'email'    => 'dishub@gmail.com',
      'password' => Hash::make('dishub'),
      'role'     => 'skpd',
    ]);
  }
}
