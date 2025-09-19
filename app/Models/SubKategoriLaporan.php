<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubKategoriLaporan extends Model
{
  protected $table   = 'sub_kategori_laporan';
  protected $guarded = [];

  public $timestamps = false;

  /**
   * Set relation table
   */
  public function kategori_laporan()
  {
    return $this->belongsTo(KategoriLaporan::class, 'kategori_laporan_id');
  }
}
