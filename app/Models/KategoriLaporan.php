<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriLaporan extends Model
{
  protected $table   = 'kategori_laporan';
  protected $guarded = [];

  public $timestamps = false;

  /**
   * Set relation table
   */
  public function skpd_anggaran()
  {
    return $this->belongsTo(SKPDAnggaran::class, 'skpd_anggaran_id');
  }

  public function laporan()
  {
    return $this->hasMany(Laporan::class, 'kategori_laporan_id');
  }

  public function children()
  {
    return $this->hasMany(KategoriLaporan::class, 'parent')->orderBy('urutan');
  }

  public function parent()
  {
    return $this->belongsTo(KategoriLaporan::class, 'parent');
  }
}
