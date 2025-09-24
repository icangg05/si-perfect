<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPD extends Model
{
  protected $table   = 'skpd';
  protected $guarded = [];

  /**
   * Set relation table
   */
  public function users()
  {
    return $this->hasOne(User::class, 'skpd_id');
  }

  public function anggaran()
  {
    return $this->hasMany(SKPDAnggaran::class, 'skpd_id');
  }
}
