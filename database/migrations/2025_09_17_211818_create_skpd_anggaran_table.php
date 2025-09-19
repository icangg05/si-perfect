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
    Schema::create('skpd_anggaran', function (Blueprint $table) {
      $table->id();
      $table->foreignId('skpd_id')->constrained('skpd')->cascadeOnDelete();
      $table->tinyInteger('bulan_anggaran');
      $table->year('tahun_anggaran');
      $table->string('jenis_pengadaan');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('skpd_anggaran');
  }
};
