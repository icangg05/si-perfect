<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
  protected $table   = 'laporan';
  protected $guarded = [];

  public function setAttribute($key, $value)
  {
    $moneyFields = [
      'pagu',
      'nilai_kontrak_tender',
      'realisasi_tender',
      'nilai_kontrak_penunjukkan_langsung',
      'realisasi_penunjukkan_langsung',
      'nilai_kontrak_swakelola',
      'realisasi_swakelola',
      'nilai_kontrak_epurchasing',
      'realisasi_epurchasing',
      'nilai_kontrak_pengadaan_langsung',
      'realisasi_pengadaan_langsung',
    ];

    if (in_array($key, $moneyFields) && !is_null($value)) {
      $value = (int) str_replace('.', '', $value);
    }

    return parent::setAttribute($key, $value);
  }


  public function skpd_anggaran()
  {
    return $this->belongsTo(SKPDAnggaran::class, 'skpd_anggaran_id');
  }

  public function kategori_laporan()
  {
    return $this->belongsTo(KategoriLaporan::class, 'kategori_laporan_id');
  }
}
