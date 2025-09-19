<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class UsersExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
  protected $countRowPaketPenyelia  = null;
  protected $countRowPaketSwakelola = null;

  protected $tahun_anggaran   = null;
  protected $jenis_pengadaaan = null;

  protected $nama_skpd   = null;
  protected $tgl_cetak   = null;
  protected $kepala_spkd = null;
  protected $pangkat     = null;
  protected $golongan    = null;
  protected $nip         = null;

  public function __construct()
  {
    $this->tahun_anggaran   = 2025;
    $this->jenis_pengadaaan = 'KONSTRUKSI, KONSULTANSI, BARANG DAN JASA LAINNYA';

    $this->nama_skpd   = 'DINAS PERHUBUNGAN';
    $this->tgl_cetak   = Carbon::createFromFormat('Y-m-d', '2025-08-05')->translatedFormat('j F Y');
    $this->kepala_spkd = 'PAMINUDDIN, SE., M.Si.';
    $this->pangkat     = 'Pembina Utama Muda';
    $this->golongan    = 'IV/c';
    $this->nip         = '19690910 199312 1 001';
  }

  public function array(): array
  {
    $dataPaketPenyelia            = Laporan::where('kategori', 'paket-penyelia')->get();
    $dataPaketSwakelola           = Laporan::where('kategori', 'paket-swakelola')->get();
    $this->countRowPaketPenyelia  = $dataPaketPenyelia->count();
    $this->countRowPaketSwakelola = $dataPaketSwakelola->count();

    /**
     * =======================
     * 1. Paket Penyelia
     * =======================
     */
    $rows = $dataPaketPenyelia->map(function ($row, $index) {
      $totalRealisasiAnggaran =
        $row->realisasi_tender +
        $row->realisasi_penunjukkan_langsung +
        $row->realisasi_swakelola +
        $row->realisasi_epurchasing +
        $row->realisasi_pengadaan_langsung;

      $presentasiRealisasiKeuangan = $row->pagu > 0
        ? $totalRealisasiAnggaran / $row->pagu
        : 0;

      return [
        $index + 1,                                // urut_dpa (A)
        $row->no,                                  // B
        $row->nama_pekerjaan,                      // C
        $row->pagu,                                // D
        $row->no_kontrak,                          // E
        $row->tgl_mulai_kontrak,                   // F
        $row->tgl_berakhir_kontrak,                // G
        $row->nilai_kontrak_tender,                // H
        $row->realisasi_tender,                    // I
        $row->nilai_kontrak_penunjukkan_langsung,  // J
        $row->realisasi_penunjukkan_langsung,      // K
        $row->nilai_kontrak_swakelola,             // L
        $row->realisasi_swakelola,                 // M
        $row->nilai_kontrak_epurchasing,           // N
        $row->realisasi_epurchasing,               // O
        $row->nilai_kontrak_pengadaan_langsung,    // P
        $row->realisasi_pengadaan_langsung,        // Q
        $totalRealisasiAnggaran,                   // R
        $presentasiRealisasiKeuangan ?: '0',       // S
        $row->presentasi_realisasi_fisik ?: '0',   // T
        $row->sumber_dana ?? '-',                  // U
        $row->keterangan ?? '-',                   // V
      ];
    })->toArray();

    // Hitung total kolom data penyelia
    $totalPaguPenyelia               = $dataPaketPenyelia->sum('pagu');
    $totalTenderPenyelia             = $dataPaketPenyelia->sum('nilai_kontrak_tender');
    $totalRealisasiTenderPenyelia    = $dataPaketPenyelia->sum('realisasi_tender');
    $totalPLPenyelia                 = $dataPaketPenyelia->sum('nilai_kontrak_penunjukkan_langsung');
    $totalRealisasiPLPenyelia      = $dataPaketPenyelia->sum('realisasi_penunjukkan_langsung');
    $totalSwakelolaPenyelia          = $dataPaketPenyelia->sum('nilai_kontrak_swakelola');
    $totalRealisasiSwakelolaPenyelia = $dataPaketPenyelia->sum('realisasi_swakelola');
    $totalEpurPenyelia               = $dataPaketPenyelia->sum('nilai_kontrak_epurchasing');
    $totalRealisasiEpurPenyelia      = $dataPaketPenyelia->sum('realisasi_epurchasing');
    $totalPLangsungPenyelia          = $dataPaketPenyelia->sum('nilai_kontrak_pengadaan_langsung');
    $totalRealisasiPLangsungPenyelia = $dataPaketPenyelia->sum('realisasi_pengadaan_langsung');
    $totalRealisasiAnggaranPenyelia  = $totalRealisasiTenderPenyelia + $totalRealisasiPLPenyelia + $totalRealisasiSwakelolaPenyelia + $totalRealisasiEpurPenyelia + $totalRealisasiPLangsungPenyelia;

    // Hitung rata-rata presentasi_realisasi_fisik
    $values = $dataPaketPenyelia->pluck('presentasi_realisasi_fisik')->map(fn($v) => (float) $v);
    $averageRealisasiFisik = $values->count() > 0 ? $values->avg() : 0;

    // tambah baris total
    $rows[] = [
      '',                                // A
      'JUMLAH',                          // B
      '',                                // C
      $totalPaguPenyelia ?: '0', // D
      '',
      '',
      '',                              // E–G
      $totalTenderPenyelia ?: '0',             // H
      $totalRealisasiTenderPenyelia ?: '0',    // I
      $totalPLPenyelia ?: '0',                 // J
      $totalRealisasiPLPenyelia ?: '0',        // K
      $totalSwakelolaPenyelia ?: '0',          // L
      $totalRealisasiSwakelolaPenyelia ?: '0', // M
      $totalEpurPenyelia ?: '0',               // N
      $totalRealisasiEpurPenyelia ?: '0',      // O
      $totalPLangsungPenyelia ?: '0',          // P
      $totalRealisasiPLangsungPenyelia ?: '0', // Q
      $totalRealisasiAnggaranPenyelia ?: '0',  // R
      $totalPaguPenyelia > 0 ? $totalRealisasiAnggaranPenyelia / $totalPaguPenyelia : '0',   // S (persentase keuangan)
      $averageRealisasiFisik > 0 ? $averageRealisasiFisik : '0',     // T (rata2 fisik)
      '',                                                            // U
    ];


    // =======================
    // 2. Paket Swakelola
    // =======================
    $rows[] = ['', '', '2.   Paket Swakelola'];
    $rows[] = ['', '', '2.1 Paket Swakelola Terumumkan'];

    $rowsSwakelola = $dataPaketSwakelola->map(function ($row, $index) {
      $totalRealisasiAnggaranSwakelola =
        $row->realisasi_tender +
        $row->realisasi_penunjukkan_langsung +
        $row->realisasi_swakelola +
        $row->realisasi_epurchasing +
        $row->realisasi_pengadaan_langsung;

      $presentasiRealisasiKeuangan = $row->pagu > 0
        ? $totalRealisasiAnggaranSwakelola / $row->pagu
        : 0;

      return [
        $index + 1,
        $row->no,
        $row->nama_pekerjaan,
        $row->pagu,
        $row->no_kontrak,
        $row->tgl_mulai_kontrak,
        $row->tgl_berakhir_kontrak,
        $row->nilai_kontrak_tender,
        $row->realisasi_tender,
        $row->nilai_kontrak_penunjukkan_langsung,
        $row->realisasi_penunjukkan_langsung,
        $row->nilai_kontrak_swakelola,
        $row->realisasi_swakelola,
        $row->nilai_kontrak_epurchasing,
        $row->realisasi_epurchasing,
        $row->nilai_kontrak_pengadaan_langsung,
        $row->realisasi_pengadaan_langsung,
        $totalRealisasiAnggaranSwakelola,
        $presentasiRealisasiKeuangan ?: '0',
        $row->presentasi_realisasi_fisik ?: '0',
        $row->sumber_dana ?? '-',
        $row->keterangan ?? '-',
      ];
    })->toArray();

    $rows = array_merge($rows, $rowsSwakelola);

    // --- hitung total swakelola ---
    $totalPaguSwakelola         = $dataPaketSwakelola->sum('pagu');
    $totalTenderSwa             = $dataPaketSwakelola->sum('nilai_kontrak_tender');
    $totalRealisasiTenderSwa    = $dataPaketSwakelola->sum('realisasi_tender');
    $totalPLSwa                 = $dataPaketSwakelola->sum('nilai_kontrak_penunjukkan_langsung');
    $totalRealisasiPLSwa        = $dataPaketSwakelola->sum('realisasi_penunjukkan_langsung');
    $totalSwa                   = $dataPaketSwakelola->sum('nilai_kontrak_swakelola');
    $totalRealisasiSwa          = $dataPaketSwakelola->sum('realisasi_swakelola');
    $totalEpurSwa               = $dataPaketSwakelola->sum('nilai_kontrak_epurchasing');
    $totalRealisasiEpurSwa      = $dataPaketSwakelola->sum('realisasi_epurchasing');
    $totalPLangsungSwa          = $dataPaketSwakelola->sum('nilai_kontrak_pengadaan_langsung');
    $totalRealisasiPLangsungSwa = $dataPaketSwakelola->sum('realisasi_pengadaan_langsung');
    $totalRealisasiAnggaranSwa  = $totalRealisasiTenderSwa + $totalRealisasiPLSwa + $totalRealisasiSwa + $totalRealisasiEpurSwa + $totalRealisasiPLangsungSwa;

    $valuesSwa = $dataPaketSwakelola->pluck('presentasi_realisasi_fisik')->map(fn($v) => (float) $v);
    $averageRealisasiFisikSwa = $valuesSwa->count() > 0 ? $valuesSwa->avg() : 0;

    $rows[] = [
      '',
      'JUMLAH',
      '',
      $totalPaguSwakelola ?: '0',
      '',
      '',
      '',
      $totalTenderSwa ?: '0',
      $totalRealisasiTenderSwa ?: '0',
      $totalPLSwa ?: '0',
      $totalRealisasiPLSwa ?: '0',
      $totalSwa ?: '0',
      $totalRealisasiSwa ?: '0',
      $totalEpurSwa ?: '0',
      $totalRealisasiEpurSwa ?: '0',
      $totalPLangsungSwa ?: '0',
      $totalRealisasiPLangsungSwa ?: '0',
      $totalRealisasiAnggaranSwa ?: '0',
      $totalPaguSwakelola > 0 ? $totalRealisasiAnggaranSwa / $totalPaguSwakelola : '0',
      $averageRealisasiFisikSwa > 0 ? $averageRealisasiFisikSwa : '0',
      '',
    ];

    /**
     * Total baris paket penyelia + paket swakelola
     */
    // tambah baris total
    $rows[] = [
      '',                                // A
      'TOTAL RUPIAH ',                   // B
      '',                                // C
      $totalPaguPenyelia + $totalPaguSwakelola ?: '0', // D
      '',
      '',
      '',                              // E–G
      $totalTenderPenyelia + $totalTenderSwa ?: '0',             // H
      $totalRealisasiTenderPenyelia + $totalRealisasiTenderSwa ?: '0',    // I
      $totalPLPenyelia + $totalPLSwa ?: '0',                 // J
      $totalRealisasiPLPenyelia + $totalRealisasiPLSwa ?: '0',        // K
      $totalSwakelolaPenyelia + $totalSwa ?: '0',          // L
      $totalRealisasiSwakelolaPenyelia + $totalRealisasiSwa ?: '0', // M
      $totalEpurPenyelia + $totalEpurSwa ?: '0',               // N
      $totalRealisasiEpurPenyelia + $totalRealisasiEpurSwa ?: '0',      // O
      $totalPLangsungPenyelia + $totalRealisasiPLangsungSwa ?: '0',          // P
      $totalRealisasiPLangsungPenyelia + $totalRealisasiPLangsungSwa ?: '0', // Q
      $totalRealisasiAnggaranPenyelia + $totalRealisasiAnggaranSwa ?: '0',  // R
      ($totalRealisasiAnggaranPenyelia + $totalRealisasiAnggaranSwa) / ($totalPaguPenyelia + $totalPaguSwakelola) ?: '0',   // S (persentase keuangan)
      ($averageRealisasiFisik + $averageRealisasiFisikSwa) / 2 ?: '0',     // T (rata2 fisik)
      '',                                                            // U
    ];


    // Data TTD Kepala SKPD
    $rows[] = [''];
    $rows[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',  "KENDARI, $this->tgl_cetak"];
    $rows[] = [''];
    $rows[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',  "KEPALA $this->nama_skpd"];
    $rows[] = [''];
    $rows[] = [''];
    $rows[] = [''];
    $rows[] = [''];
    $rows[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $this->kepala_spkd];
    $rows[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', "$this->pangkat, Gol $this->golongan"];
    $rows[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', "NIP. $this->nip"];

    return $rows;
  }


  public function headings(): array
  {
    // Untuk urutan di bawah heading table
    $ascNumber = [];
    for ($i = 1; $i <= 22; $i++) {
      if ($i === 1) {
        $ascNumber[] = "(2)";
      } elseif ($i === 2) {
        $ascNumber[] = "(1)";
      } else {
        $ascNumber[] = "($i)";
      }
    }
    /**
     * Tiap item di dalam return adalah 1 baris
     * Tiap sub item dalam array adalah kolom
     */
    return [
      // Judul besar
      ['LAPORAN REALISASI FISIK DAN KEUANGAN T.A. ' .  $this->tahun_anggaran],
      [],
      // Nama dinas, tahun, jenis pengadaan
      ['', '', 'NAMA SKPD                 : ' . $this->nama_skpd],
      ['', '', 'TAHUN ANGGARAN    : ' . $this->tahun_anggaran],
      ['', '', 'JENIS PENGADAAN    : ' . $this->jenis_pengadaaan],
      [],
      // Header table
      ['Urut DPA', 'No.', 'NAMA PEKERJAAN', 'PAGU (Rp)', 'NO. KONTRAK', 'TANGGAL KONTRAK', '', 'JENIS PAKET', '', '', '', '', '', '', '', '', '', 'TOTAL REALISASI ANGGARAN', 'PRESENTASI REALISASI', '', 'SUMBER DANA (APBD/ DAK/ DID)', 'KET'],
      ['', '', '', '', '', '', '', 'TENDER', '', 'PENUNJUKKAN LANGSUNG', '', 'SWAKELOLA', '', 'E-PURCHASING', '', 'PENGADAAN LANGSUNG', ''],
      ['', '', '', '', '', 'MULAI', 'BERAKHIR', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', '', 'KEUANGAN (%)', 'FISIK (%)'],
      $ascNumber,
      ['', '', '1.    Paket Penyedia'],
      ['', '', '1.1. Paket Penyedia Terumumkan'],
      // 'SUMBER DANA (APBD/ DAK/ DID)'
    ];
  }


  public function styles(Worksheet $sheet)
  {
    // set paper size ke F4 (folio) + landscape + margins + center horizontally
    $sheet->getPageSetup()
      ->setPaperSize(PageSetup::PAPERSIZE_FOLIO)
      ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

    // Auto-fit area agar pas di satu halaman lebar
    $sheet->getPageSetup()->setFitToWidth(1);
    $sheet->getPageSetup()->setFitToHeight(0); // 0 artinya bebas ke bawah

    // Atur margin (dalam satuan inch)
    $sheet->getPageMargins()->setTop(0.3);
    $sheet->getPageMargins()->setRight(0.3);
    $sheet->getPageMargins()->setLeft(0.3);
    $sheet->getPageMargins()->setBottom(0.3);

    // Freeze panes
    $sheet->freezePane('A11');

    // Set halaman center secara horizontal
    $sheet->getPageSetup()->setHorizontalCentered(true);


    // Set height baris A
    $sheet->getRowDimension(2)->setRowHeight(10);
    $sheet->getRowDimension(6)->setRowHeight(10);

    // Default font
    $sheet->getParent()->getDefaultStyle()->getFont()
      ->setName('Arial Narrow')
      ->setSize(11);

    // Merge cell untuk judul
    $sheet->mergeCells('A1:V1');

    // Style judul
    $sheet->getStyle('A1')->applyFromArray([
      'font' => [
        'bold'      => true,
        'size'      => 15,
        'underline' => 'single',
      ],
      'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ]);

    // Bold untuk info dinas/anggaran/pengadaan
    $sheet->getStyle('C3:C5')->getFont()->setBold(true);

    /**
     * Atur lebar kolom
     */
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(5);
    $sheet->getColumnDimension('C')->setWidth(35);
    $sheet->getColumnDimension('D')->setWidth(16);
    $sheet->getColumnDimension('E')->setWidth(15);
    $sheet->getColumnDimension('F')->setWidth(11);
    $sheet->getColumnDimension('G')->setWidth(11);

    foreach (range('H', 'Q') as $i => $col) {
      $sheet->getColumnDimension($col)->setWidth($i % 2 === 0 ? 14 : 15.5);
    }

    $sheet->getColumnDimension('R')->setWidth(16);
    $sheet->getColumnDimension('S')->setWidth(8);
    $sheet->getColumnDimension('T')->setWidth(8);
    $sheet->getColumnDimension('U')->setWidth(10.4);
    $sheet->getColumnDimension('v')->setWidth(15);

    /**
     * Merge header tabel
     */
    $mergeMap = [
      'A7:A9',
      'B7:B9',
      'C7:C9',
      'D7:D9',
      'E7:E9',
      'F7:G8',
      'H7:Q7',
      'H8:I8',
      'J8:K8',
      'L8:M8',
      'N8:O8',
      'P8:Q8',
      'R7:R9',
      'S7:T8',
      'U7:U9',
      'V7:V9',
    ];
    foreach ($mergeMap as $range) {
      $sheet->mergeCells($range);
    }

    /**
     * Style header tabel
     */
    $startRowPaketPenyelia = 13;
    $lastRowPaketPenyelia  = $startRowPaketPenyelia + $this->countRowPaketPenyelia;

    $sheet->getStyle("A7:V10")->applyFromArray([
      'font' => ['bold' => true],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER,
        'wrapText'   => true,
      ],
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
    ]);

    // Angka baris ke-10 (italic, kecil)
    $sheet->getStyle("A10:V10")->applyFromArray([
      'font' => [
        'bold'   => false,
        'size'   => 9,
        'italic' => true,
      ],
    ]);


    // Bold + border untuk baris 1. Paket Penyelia
    $sheet->getStyle("A11:V12")->applyFromArray([
      'font' => ['bold' => true],
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'alignment' => [
        'vertical'   => Alignment::VERTICAL_CENTER,
        'horizontal' => Alignment::HORIZONTAL_LEFT,
      ],
    ]);


    /**
     * Isi data
     * Border & vertical center untuk semua data
     */
    $sheet->getStyle("A{$startRowPaketPenyelia}:V{$lastRowPaketPenyelia}")->applyFromArray([
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
    ]);

    // Font Calibri kolom yang memuat angka (D, H-R)
    $sheet->getStyle("D{$startRowPaketPenyelia}:D{$lastRowPaketPenyelia}")
      ->getFont()
      ->setName('Calibri');
    $sheet->getStyle("H{$startRowPaketPenyelia}:R{$lastRowPaketPenyelia}")
      ->getFont()
      ->setName('Calibri');
    // Set format ribuan
    $sheet->getStyle("D{$startRowPaketPenyelia}:D{$lastRowPaketPenyelia}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');
    $sheet->getStyle("H{$startRowPaketPenyelia}:R{$lastRowPaketPenyelia}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');

    // Format persen kolom (S, T)
    $sheet->getStyle("S{$startRowPaketPenyelia}:T{$lastRowPaketPenyelia}")
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_0);


    // Kolom yang harus center horizontal
    foreach (['A', 'B', 'S', 'T', 'U', 'V'] as $col) {
      $sheet->getStyle("{$col}{$startRowPaketPenyelia}:{$col}{$lastRowPaketPenyelia}")
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    // Kolom yang harus wrap text
    foreach (['C', 'U', 'V'] as $col) {
      $sheet->getStyle("{$col}{$startRowPaketPenyelia}:{$col}{$lastRowPaketPenyelia}")
        ->getAlignment()->setWrapText(true);
    }

    // Style baris jumlah anggaran 1. Paket Penyelia
    $sheet->getRowDimension($lastRowPaketPenyelia)->setRowHeight(25);
    $sheet->getStyle("A{$lastRowPaketPenyelia}:V{$lastRowPaketPenyelia}")->applyFromArray([
      'font' => ['bold' => true],
    ]);
    $sheet->getStyle("B{$lastRowPaketPenyelia}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->mergeCells("B{$lastRowPaketPenyelia}:C{$lastRowPaketPenyelia}");


    /**
     * =======================
     * 2. Paket Swakelola
     * =======================
     */
    $startRowPaketSwakelola = $lastRowPaketPenyelia + 1;
    $lastRowPaketSwakelola  = $startRowPaketSwakelola + $this->countRowPaketSwakelola + 2;
    $sheet->getStyle("A{$startRowPaketSwakelola}:V" . $startRowPaketSwakelola + 1)->applyFromArray([
      'font' => ['bold' => true],
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'alignment' => [
        'vertical'   => Alignment::VERTICAL_CENTER,
        'horizontal' => Alignment::HORIZONTAL_LEFT,
      ],
    ]);

    $sheet->getStyle("A{$startRowPaketSwakelola}:V{$lastRowPaketSwakelola}")->applyFromArray([
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
    ]);

    // Font Calibri kolom yang memuat angka (D, H-R)
    $sheet->getStyle("D{$startRowPaketSwakelola}:D{$lastRowPaketSwakelola}")
      ->getFont()
      ->setName('Calibri');
    $sheet->getStyle("H{$startRowPaketSwakelola}:R{$lastRowPaketSwakelola}")
      ->getFont()
      ->setName('Calibri');
    // Set format ribuan
    $sheet->getStyle("D{$startRowPaketSwakelola}:D{$lastRowPaketSwakelola}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');
    $sheet->getStyle("H{$startRowPaketSwakelola}:R{$lastRowPaketSwakelola}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');

    // Format persen kolom (S, T)
    $sheet->getStyle("S{$startRowPaketSwakelola}:T{$lastRowPaketSwakelola}")
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_0);

    // Kolom yang harus center horizontal
    foreach (['A', 'B', 'S', 'T', 'U', 'V'] as $col) {
      $sheet->getStyle("{$col}{$startRowPaketSwakelola}:{$col}{$lastRowPaketSwakelola}")
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }
    // Kolom yang harus wrap text
    foreach (['C', 'U', 'V'] as $col) {
      $sheet->getStyle("{$col}{$startRowPaketSwakelola}:{$col}{$lastRowPaketSwakelola}")
        ->getAlignment()->setWrapText(true);
    }

    // Style baris jumlah anggaran 2. Paket Swakelola
    $sheet->getRowDimension($lastRowPaketSwakelola)->setRowHeight(25);
    $sheet->getStyle("A{$lastRowPaketSwakelola}:V{$lastRowPaketSwakelola}")->applyFromArray([
      'font' => ['bold' => true],
    ]);
    $sheet->getStyle("B{$lastRowPaketSwakelola}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->mergeCells("B{$lastRowPaketSwakelola}:C{$lastRowPaketSwakelola}");


    // Style total keseluruhan
    $rowTotalKeseluruhan = $lastRowPaketSwakelola + 1;
    $sheet->getRowDimension($rowTotalKeseluruhan)->setRowHeight(25);
    $sheet->getStyle("A{$rowTotalKeseluruhan}:V{$rowTotalKeseluruhan}")->applyFromArray([
      'font' => ['bold' => true],
    ]);
    $sheet->getStyle("B{$rowTotalKeseluruhan}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->mergeCells("B{$rowTotalKeseluruhan}:C{$rowTotalKeseluruhan}");

    // Format persen kolom (S, T)
    $sheet->getStyle("S{$rowTotalKeseluruhan}:T{$rowTotalKeseluruhan}")
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_0);

    // Kolom yang harus center horizontal
    foreach (['S', 'T'] as $col) {
      $sheet->getStyle("{$col}{$rowTotalKeseluruhan}:{$col}{$rowTotalKeseluruhan}")
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    $sheet->getStyle("A{$rowTotalKeseluruhan}:V{$rowTotalKeseluruhan}")->applyFromArray([
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
    ]);

    // Font Calibri kolom yang memuat angka (D, H-R)
    $sheet->getStyle("D{$rowTotalKeseluruhan}:D{$rowTotalKeseluruhan}")
      ->getFont()
      ->setName('Calibri');
    $sheet->getStyle("H{$rowTotalKeseluruhan}:R{$rowTotalKeseluruhan}")
      ->getFont()
      ->setName('Calibri');
    // Set format ribuan
    $sheet->getStyle("D{$rowTotalKeseluruhan}:D{$rowTotalKeseluruhan}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');
    $sheet->getStyle("H{$rowTotalKeseluruhan}:R{$rowTotalKeseluruhan}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');


    /**
     * Style TTD Kepala SKPD
     */
    $rowTanggal         = $rowTotalKeseluruhan + 2;
    $rowNamaSKPD        = $rowTotalKeseluruhan + 4;
    $rowKepalaSKPD      = $rowTotalKeseluruhan + 9;
    $rowPangkatGolongan = $rowTotalKeseluruhan + 10;
    $rowNIP             = $rowTotalKeseluruhan + 11;
    // Merge
    $mergeMapTTD = [
      "R$rowTanggal:V$rowTanggal",
      "R$rowNamaSKPD:V$rowNamaSKPD",
      "R$rowKepalaSKPD:V$rowKepalaSKPD",
      "R$rowPangkatGolongan:V$rowPangkatGolongan",
      "R$rowNIP:V$rowNIP",
    ];
    foreach ($mergeMapTTD as $range) {
      $sheet->mergeCells($range);
    }

    // Styling row Tanggal, Nama SKPD, Kepala SKPD (Bold)
    $sheet->getStyle("R{$rowTanggal}:V{$rowKepalaSKPD}")
      ->applyFromArray([
        'font' => [
          'bold' => true,
          'size' => 15,
        ],
        'alignment' => [
          'vertical'   => Alignment::VERTICAL_CENTER,
          'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
      ]);

    // Styling row Pangkat/Golongan & NIP (Normal, tidak bold)
    $sheet->getStyle("R{$rowPangkatGolongan}:V{$rowNIP}")
      ->applyFromArray([
        'font' => [
          'bold' => false,
          'size' => 15,
        ],
        'alignment' => [
          'vertical'   => Alignment::VERTICAL_CENTER,
          'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
      ]);
    $sheet->getRowDimension($rowTanggal - 1)->setRowHeight(21);
    $sheet->getRowDimension($rowNamaSKPD - 1)->setRowHeight(7);
    $sheet->getStyle("R{$rowKepalaSKPD}:V{$rowKepalaSKPD}")->applyFromArray(['font' => ['underline' => 'single']]);


    return [];
  }


  public function title(): string
  {
    return 'Juli';
  }
}
