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
  protected $skpd_anggaran;
  protected $grouped;

  protected $countRowPaketPenyelia  = null;
  protected $countRowPaketSwakelola = null;

  protected $jenis_pengadaan = null;
  protected $tahun_anggaran  = null;
  protected $bulan_anggaran  = null;

  protected $nama_skpd   = null;
  protected $singkatan   = null;
  protected $tgl_cetak   = null;
  protected $kepala_spkd = null;
  protected $pangkat     = null;
  protected $golongan    = null;
  protected $nip         = null;

  public function __construct($skpd_anggaran, $grouped)
  {
    $this->skpd_anggaran = $skpd_anggaran;
    $this->grouped       = $grouped;

    $this->tahun_anggaran  = $skpd_anggaran->tahun_anggaran;
    $this->bulan_anggaran  = Carbon::create()->month($skpd_anggaran->bulan_anggaran)->translatedFormat('F');
    $this->jenis_pengadaan = $skpd_anggaran->jenis_pengadaan;

    $this->nama_skpd   = $skpd_anggaran->skpd->nama;
    $this->singkatan   = $skpd_anggaran->skpd->singkatan;
    $this->tgl_cetak   = Carbon::createFromFormat('Y-m-d', '2025-08-05')->translatedFormat('j F Y');
    $this->kepala_spkd = $skpd_anggaran->skpd->pimpinan_skpd;
    $this->pangkat     = $skpd_anggaran->skpd->pangkat_pimpinan;
    $this->golongan    = $skpd_anggaran->skpd->golongan_pimpinan;
    $this->nip         = $skpd_anggaran->skpd->nip_pimpinan;
  }

  public function array(): array
  {
    $rows = [];

    $no_kategori                               = 1;
    $presentasi_realisasi_keuangan_keseluruhan = 0;
    $presentasi_realisasi_fisik_keseluruhan    = 0;
    $total_realisasi_keseluruhan               = 0;

    // Loop grouped as kategori
    foreach ($this->grouped as $kategori => $sub_kategoris) {
      $rows[] = ['', '', "{$no_kategori}.    {$kategori}"];

      // Loop sub_kategoris
      $no_sub_kategori                      = 1;
      $total_realisasi_anggaran_perkategori = 0;

      foreach ($sub_kategoris as $sub_kategori => $items) {
        $rows[] = ['', '', "{$no_kategori}.{$no_sub_kategori}. {$sub_kategori}"];


        // hitung total per sub kategori
        $total_pagu                               = $items->sum('pagu');
        $total_nilai_kontrak_tender               = $items->sum('nilai_kontrak_tender');
        $total_realisasi_tender                   = $items->sum('realisasi_tender');
        $total_nilai_kontrak_penunjukkan_langsung = $items->sum('nilai_kontrak_penunjukkan_langsung');
        $total_realisasi_penunjukkan_langsung     = $items->sum('realisasi_penunjukkan_langsung');
        $total_nilai_kontrak_swakelola            = $items->sum('nilai_kontrak_swakelola');
        $total_realisasi_swakelola                = $items->sum('realisasi_swakelola');
        $total_nilai_kontrak_epurchasing          = $items->sum('nilai_kontrak_epurchasing');
        $total_realisasi_epurchasing              = $items->sum('realisasi_epurchasing');
        $total_nilai_kontrak_pengadaan_langsung   = $items->sum('nilai_kontrak_pengadaan_langsung');
        $total_realisasi_pengadaan_langsung       = $items->sum('realisasi_pengadaan_langsung');

        // tambahkan ke presentasi realisasi fisik keseluruhan
        $presentasi_realisasi_fisik_keseluruhan    += $items->sum('presentasi_realisasi_fisik') / count($items);


        // Loop items (item data laporan)
        foreach ($items as $index => $item) {
          $no_asc = $index + 1;

          $total_realisasi_anggaran =
            $item->realisasi_tender +
            $item->realisasi_penunjukkan_langsung +
            $item->realisasi_swakelola +
            $item->realisasi_epurchasing +
            $item->realisasi_pengadaan_langsung;

          // Tambahkan ke total per kategori
          $total_realisasi_anggaran_perkategori += $total_realisasi_anggaran;

          $tgl_mulai_kontrak    = $item->tgl_mulai_kontrak ? Carbon::create($item->tgl_mulai_kontrak)->translatedFormat('d-m-Y') : null;
          $tgl_berakhir_kontrak = $item->tgl_berakhir_kontrak ? Carbon::create($item->tgl_berakhir_kontrak)->translatedFormat('d-m-Y') : null;

          $rows[] = [
            $no_asc,
            $item->no,
            $item->nama_pekerjaan,
            $item->pagu,
            $item->no_kontrak,
            $tgl_mulai_kontrak,
            $tgl_berakhir_kontrak,
            $item->nilai_kontrak_tender,
            $item->realisasi_tender,
            $item->nilai_kontrak_penunjukkan_langsung,
            $item->realisasi_penunjukkan,
            $item->nilai_kontrak_swakelola,
            $item->realisasi_swakelola,
            $item->nilai_kontrak_epurchasing,
            $item->realisasi_epurchasing,
            $item->nilai_kontrak_pengadaan_langsung,
            $item->realisasi_pengadaan_langsung,
            $total_realisasi_anggaran,
            format_persen($total_realisasi_anggaran / max($item->pagu, 1)) ?: '0',
            format_persen($item->presentasi_realisasi_fisik) ?: '0',
            $item->sumber_dana ?: '-',
            $item->keterangan ?: '-',
          ];
        }


        // tambahkan ke presentasi realisasi fisik keseluruhan dan total realisasi keluruhan
        $presentasi_realisasi_keuangan_keseluruhan += $total_realisasi_anggaran_perkategori / $total_pagu;
        $total_realisasi_keseluruhan               += $total_realisasi_anggaran_perkategori;


        // Jumlah per sub kategori
        $rows[] = [
          '',
          'JUMLAH',
          '',
          $total_pagu ?: '0',
          '',
          '',
          '',
          $total_nilai_kontrak_tender ?: '0',
          $total_realisasi_tender ?: '0',
          $total_nilai_kontrak_penunjukkan_langsung ?: '0',
          $total_realisasi_penunjukkan_langsung ?: '0',
          $total_nilai_kontrak_swakelola ?: '0',
          $total_realisasi_swakelola ?: '0',
          $total_nilai_kontrak_epurchasing ?: '0',
          $total_realisasi_epurchasing ?: '0',
          $total_nilai_kontrak_pengadaan_langsung ?: '0',
          $total_realisasi_pengadaan_langsung ?: '0',
          $total_realisasi_anggaran_perkategori ?: '0',
          format_persen($total_realisasi_anggaran_perkategori / max($total_pagu, 1)) ?: '0',
          format_persen($items->sum('presentasi_realisasi_fisik') / count($items)) ?: '0',
        ];

        // Increment no_sub_kategori
        $no_sub_kategori++;
      }

      // Increment no_kategori
      $no_kategori++;
    }


    // Total jumlah keseluruhan
    $rows[] = [
      '',
      'TOTAL RUPIAH',
      '',
      $this->skpd_anggaran->laporan->sum('pagu') ?: '0',
      '',
      '',
      '',
      $this->skpd_anggaran->laporan->sum('nilai_kontrak_tender') ?: '0',
      $this->skpd_anggaran->laporan->sum('realisasi_tender') ?: '0',
      $this->skpd_anggaran->laporan->sum('nilai_kontrak_penunjukkan_langsung') ?: '0',
      $this->skpd_anggaran->laporan->sum('realisasi_penunjukkan_langsung') ?: '0',
      $this->skpd_anggaran->laporan->sum('nilai_kontrak_swakelola') ?: '0',
      $this->skpd_anggaran->laporan->sum('realisasi_swakelola') ?: '0',
      $this->skpd_anggaran->laporan->sum('nilai_kontrak_epurchasing') ?: '0',
      $this->skpd_anggaran->laporan->sum('realisasi_epurchasing') ?: '0',
      $this->skpd_anggaran->laporan->sum('nilai_kontrak_pengadaan_langsung') ?: '0',
      $this->skpd_anggaran->laporan->sum('realisasi_pengadaan_langsung') ?: '0',
      $total_realisasi_keseluruhan ?: '0',
      format_persen($presentasi_realisasi_keuangan_keseluruhan / max(count($this->grouped), 1)) ?: '0',
      format_persen($presentasi_realisasi_fisik_keseluruhan / max(count($this->grouped), 1)) ?: '0',
    ];


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
      ['LAPORAN REALISASI FISIK DAN KEUANGAN T.A. ' . $this->tahun_anggaran],
      [],
      // Nama dinas, tahun, jenis pengadaan
      ['', '', 'NAMA SKPD                 : ' . strtoupper($this->nama_skpd)],
      ['', '', 'TAHUN ANGGARAN    : ' . $this->tahun_anggaran],
      ['', '', 'JENIS PENGADAAN    : ' . strtoupper($this->jenis_pengadaan)],
      [],
      // Header table
      ['Urut DPA', 'No.', 'NAMA PEKERJAAN', 'PAGU (Rp)', 'NO. KONTRAK', 'TANGGAL KONTRAK', '', 'JENIS PAKET', '', '', '', '', '', '', '', '', '', 'TOTAL REALISASI ANGGARAN', 'PRESENTASI REALISASI', '', 'SUMBER DANA (APBD/ DAK/ DID)', 'KET'],
      ['', '', '', '', '', '', '', 'TENDER', '', 'PENUNJUKKAN LANGSUNG', '', 'SWAKELOLA', '', 'E-PURCHASING', '', 'PENGADAAN LANGSUNG', ''],
      ['', '', '', '', '', 'MULAI', 'BERAKHIR', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', '', 'KEUANGAN (%)', 'FISIK (%)'],
      $ascNumber,
    ];
  }


  public function styles(Worksheet $sheet)
  {
    // Set paper size ke F4 (folio) + landscape
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

    // Bold untuk info nama dinas/jenis pengadaan/tahun
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
     * Styling header table
     */
    $sheet->getStyle("A7:V10")->applyFromArray([
      'font' => ['bold' => true],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'wrapText'   => true,
      ],
    ]);


    /**
     * Styling urutan nomor header 1-22
     */
    $sheet->getStyle("A10:V10")->applyFromArray([
      'font' => [
        'bold'   => false,
        'size'   => 9,
        'italic' => true,
      ],
    ]);


    /**
     * Border all row-column
     * Menghitung item berdasarkan nama kategori
     */
    $jumlah_perkategori = $this->skpd_anggaran->laporan->countBy(function ($laporan) {
      return $laporan->sub_kategori_laporan->kategori_laporan->nama ?? 'Tanpa Kategori';
    });

    $additional_row = count($jumlah_perkategori) * 3;
    $start_data_row = 11;
    $length_row     = $jumlah_perkategori->sum() + $start_data_row + $additional_row;

    $sheet->getStyle("A7:V{$length_row}")->applyFromArray([
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
      ],
    ]);

    // Kolom yang harus center horizontal
    foreach (['A', 'B', 'S', 'T', 'U', 'V'] as $col) {
      $sheet->getStyle("{$col}{$start_data_row}:{$col}{$length_row}")
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    // Kolom format persen kolom (S, T)
    $sheet->getStyle("S{$start_data_row}:T{$length_row}")
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_0);

    // Kolom format ribuan
    $sheet->getStyle("D{$start_data_row}:D{$length_row}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');
    $sheet->getStyle("H{$start_data_row}:R{$length_row}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');


    /**
     * Styling baris jumlah per kategori & bold untuk judul
     */
    // Inisialisasi penghitung baris. Header Anda selesai di baris 10, jadi kita mulai dari 10.
    $currentRow = 10;

    // Loop utama untuk Kategori
    foreach ($this->grouped as $sub_kategoris) {

      // Pindah ke baris selanjutnya untuk menulis judul KATEGORI UTAMA
      $currentRow++;
      // Terapkan BOLD untuk Kategori Utama (cth: "1. Paket Penyedia")
      $sheet->getStyle("C{$currentRow}")->getFont()->setBold(true);

      // Loop untuk Sub-Kategori
      foreach ($sub_kategoris as $items) {

        // Pindah ke baris selanjutnya untuk menulis judul SUB-KATEGORI
        $currentRow++;
        // Terapkan BOLD untuk Sub-Kategori (cth: "1.1. Paket Penyedia Terumumkan")
        $sheet->getStyle("C{$currentRow}")->getFont()->setBold(true);

        // Lewati semua baris data item
        $currentRow += $items->count();

        // Pindah ke baris "JUMLAH"
        $currentRow++;
        $sheet->mergeCells("B{$currentRow}:C{$currentRow}");
        $sheet->getStyle("B{$currentRow}:T{$currentRow}")->getFont()->setBold(true);
        $sheet->getRowDimension($currentRow)->setRowHeight(20);
      }
    }

    // Styling baris terakhir total keseluruhan
    $sheet->getStyle("A{$length_row}:V{$length_row}")->applyFromArray([
      'font' => ['bold'   => true],
    ]);
    $sheet->mergeCells("B{$length_row}:C{$length_row}");
    $sheet->getRowDimension($length_row)->setRowHeight(25);


    return [];
  }


  public function title(): string
  {
    return $this->bulan_anggaran;
  }
}
