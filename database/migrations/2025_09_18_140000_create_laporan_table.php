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
    Schema::create('laporan', function (Blueprint $table) {
      $table->id();
      $table->foreignId('skpd_anggaran_id')->constrained('skpd_anggaran')->cascadeOnDelete();
      $table->foreignId('sub_kategori_laporan_id')->nullable()->constrained('sub_kategori_laporan')->nullOnDelete();
      $table->unsignedInteger('no');
      $table->string('nama_pekerjaan', 100);
      $table->unsignedBigInteger('pagu');
      $table->string('no_kontrak', 100)->nullable();
      $table->date('tgl_mulai_kontrak')->nullable();
      $table->date('tgl_berakhir_kontrak')->nullable();
      $table->unsignedBigInteger('nilai_kontrak_tender')->nullable();
      $table->unsignedBigInteger('realisasi_tender')->nullable();
      $table->unsignedBigInteger('nilai_kontrak_penunjukkan_langsung')->nullable();
      $table->unsignedBigInteger('realisasi_penunjukkan_langsung')->nullable();
      $table->unsignedBigInteger('nilai_kontrak_swakelola')->nullable();
      $table->unsignedBigInteger('realisasi_swakelola')->nullable();
      $table->unsignedBigInteger('nilai_kontrak_epurchasing')->nullable();
      $table->unsignedBigInteger('realisasi_epurchasing')->nullable();
      $table->unsignedBigInteger('nilai_kontrak_pengadaan_langsung')->nullable();
      $table->unsignedBigInteger('realisasi_pengadaan_langsung')->nullable();
      $table->float('presentasi_realisasi_fisik')->nullable();
      $table->string('sumber_dana', 50)->nullable();
      $table->string('keterangan', 191)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('laporan');
  }
};
