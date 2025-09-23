<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('skpd', function (Blueprint $table) {
      $table->id();
      $table->string('nama')->unique();
      $table->string('singkatan')->unique();
      $table->text('alamat')->nullable();
      $table->string('pimpinan_skpd')->nullable();
      $table->string('nip_pimpinan')->nullable();
      $table->string('pangkat_pimpinan')->nullable();
      $table->string('golongan_pimpinan')->nullable();
      $table->enum('jenis_kelamin_pimpinan', ['L', 'P'])->nullable();
      $table->string('kontak_pimpinan')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('skpd');
  }
};
