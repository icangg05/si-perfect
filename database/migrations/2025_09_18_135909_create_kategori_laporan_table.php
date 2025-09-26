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
    Schema::create('kategori_laporan', function (Blueprint $table) {
      $table->id();
      $table->foreignId('skpd_anggaran_id')->constrained('skpd_anggaran')->cascadeOnDelete();
      $table->string('nama');
      $table->integer('parent')->nullable();
      $table->integer('level');
      $table->integer('urutan');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kategori_laporan');
  }
};
