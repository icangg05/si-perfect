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
}
