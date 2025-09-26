<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SKPDAnggaran extends Model
{
  protected $table   = 'skpd_anggaran';
  protected $guarded = [];

  /**
   * Set relation table
   */
  public function skpd()
  {
    return $this->belongsTo(SKPD::class, 'skpd_id');
  }

  public function kategori_laporan()
  {
    return $this->hasMany(KategoriLaporan::class, 'skpd_anggaran_id');
  }

  /**
   * Mendapatkan semua laporan melalui KategoriLaporan.
   */
  public function laporan(): HasManyThrough
  {
    return $this->hasManyThrough(
      Laporan::class,         // 1. Model tujuan akhir
      KategoriLaporan::class, // 2. Model perantara

      // Kunci Relasi:
      'skpd_anggaran_id',     // 3. Foreign key di tabel 'kategori_laporan'
      'kategori_laporan_id',  // 4. Foreign key di tabel 'laporan'
      'id',                   // 5. Primary key di tabel 'skpd_anggaran' (model ini)
      'id'                    // 6. Primary key di tabel 'kategori_laporan'
    );
  }
}
