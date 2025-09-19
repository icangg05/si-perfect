<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

  public function laporan()
  {
    return $this->hasMany(Laporan::class, 'skpd_anggaran_id');
  }

  public function sub_kategori_laporan()
  {
    return $this->belongsTo(SubKategoriLaporan::class ,'sub_kategori_laporan_id');
  }
}
