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
  public function sub_kategori_laporan()
  {
    return $this->hasMany(SubKategoriLaporan::class, 'kategori_laporan_id');
  }
}
