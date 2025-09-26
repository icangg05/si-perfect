<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
  protected $table   = 'laporan';
  protected $guarded = [];

  public function skpd_anggaran()
  {
    return $this->belongsTo(SKPDAnggaran::class, 'skpd_anggaran_id');
  }

  public function kategori_laporan()
  {
    return $this->belongsTo(KategoriLaporan::class, 'kategori_laporan_id');
  }
}
