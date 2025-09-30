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
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class LaporanExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
  protected $skpd_anggaran;

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


  public function __construct($skpd_anggaran)
  {
    $this->skpd_anggaran = $skpd_anggaran;

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

    // Simpan index subtotal kategori untuk dipakai di TOTAL RUPIAH
    $subtotalRows = [];

    // Loop item anggaran
    foreach ($this->skpd_anggaran->kategori_laporan as $kategori) {
      $rows[] = ['', $kategori->nama];

      // Sebelum loop laporan
      $startRow = count($rows) + 11; // data mulai baris 11 + 1 header + 1 kategori

      // Loop item anggaran perkategori
      foreach ($kategori->laporan as $i => $laporan) {
        $rowIndex = count($rows) + 11; // 11 karena data dimulai di row 11
        $rows[] = [
          $i + 1,
          $laporan->nama_pekerjaan,
          $laporan->pagu,
          $laporan->no_kontrak,
          $laporan->tgl_mulai_kontrak ? Carbon::create($laporan->tgl_mulai_kontrak)->translatedFormat('d-m-Y') : null,
          $laporan->tgl_berakhir_kontrak ? Carbon::create($laporan->tgl_berakhir_kontrak)->translatedFormat('d-m-Y') : null,
          $laporan->nilai_kontrak_tender,
          $laporan->realisasi_tender,
          $laporan->nilai_kontrak_penunjukkan_langsung,
          $laporan->realisasi_penunjukkan_langsung,
          $laporan->nilai_kontrak_swakelola,
          $laporan->realisasi_swakelola,
          $laporan->nilai_kontrak_epurchasing,
          $laporan->realisasi_epurchasing,
          $laporan->nilai_kontrak_pengadaan_langsung,
          $laporan->realisasi_pengadaan_langsung,
          "=SUM(H{$rowIndex},J{$rowIndex},L{$rowIndex},N{$rowIndex},P{$rowIndex})",
          "=IFERROR(Q{$rowIndex}/C{$rowIndex},0)",
          format_persen($laporan->presentasi_realisasi_fisik) ?: '0',
          $laporan->sumber_dana ?: '-',
          $laporan->keterangan ?: '-'
        ];

        // Setelah loop laporan → baris subtotal
        if ($i == count($kategori->laporan) - 1) {
          $endRow = count($rows) + 10; // baris terakhir data laporan
          $rows[] = [
            'SUBTOTAL',
            '',
            "=SUM(C{$startRow}:C{$endRow})",
            '',
            '',
            '',
            "=SUM(G{$startRow}:G{$endRow})",
            "=SUM(H{$startRow}:H{$endRow})",
            "=SUM(I{$startRow}:I{$endRow})",
            "=SUM(J{$startRow}:J{$endRow})",
            "=SUM(K{$startRow}:K{$endRow})",
            "=SUM(L{$startRow}:L{$endRow})",
            "=SUM(M{$startRow}:M{$endRow})",
            "=SUM(N{$startRow}:N{$endRow})",
            "=SUM(O{$startRow}:O{$endRow})",
            "=SUM(P{$startRow}:P{$endRow})",
            "=SUM(Q{$startRow}:Q{$endRow})",
            "=IFERROR(Q" . (count($rows) + 11) . "/C" . (count($rows) + 11) . ",0)",
            "=AVERAGE(S{$startRow}:S{$endRow})",
          ];

          // Simpan index baris subtotal
          $subtotalRows[] = count($rows) + 10;
        }
      }
    }

    /**
     * ====================
     * Baris TOTAL RUPIAH
     * ====================
     */
    $rows[] = [
      'TOTAL RUPIAH',
      '',
      "=SUM(" . implode(',', array_map(fn($r) => "C{$r}", $subtotalRows)) . ")",
      '',
      '',
      '',
      "=SUM(" . implode(',', array_map(fn($r) => "G{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "H{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "I{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "J{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "K{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "L{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "M{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "N{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "O{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "P{$r}", $subtotalRows)) . ")",
      "=SUM(" . implode(',', array_map(fn($r) => "Q{$r}", $subtotalRows)) . ")",
      "=IFERROR(Q" . (count($rows) + 11) . "/C" . (count($rows) + 11) . ",0)",
      "=AVERAGE(" . implode(',', array_map(fn($r) => "S{$r}", $subtotalRows)) . ")"
    ];

    return $rows;
  }


  public function headings(): array
  {
    // Untuk urutan di bawah heading table
    $ascNumber = [];
    for ($i = 1; $i <= 21; $i++) {
      $ascNumber[] = "($i)";
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
      ['', 'NAMA SKPD                 : ' . strtoupper($this->nama_skpd)],
      ['', 'TAHUN ANGGARAN    : ' . $this->tahun_anggaran],
      ['', 'JENIS PENGADAAN    : ' . strtoupper($this->jenis_pengadaan)],
      [],
      // Header table
      ['No.', 'NAMA PEKERJAAN', 'PAGU (Rp)', 'NO. KONTRAK', 'TANGGAL KONTRAK', '', 'JENIS PAKET', '', '', '', '', '', '', '', '', '', 'TOTAL REALISASI ANGGARAN', 'PRESENTASI REALISASI', '', 'SUMBER DANA (APBD/ DAK/ DID)', 'KET'],
      ['', '', '', '', '', '', 'TENDER', '', 'PENUNJUKKAN LANGSUNG', '', 'SWAKELOLA', '', 'E-PURCHASING', '', 'PENGADAAN LANGSUNG', ''],
      ['', '', '', '', 'MULAI', 'BERAKHIR', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', 'NILAI KONTRAK (Rp)', 'REALISASI (Rp)', '', 'KEUANGAN (%)', 'FISIK (%)'],
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
    $sheet->mergeCells('A1:U1');

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
    $sheet->getStyle('B3:B5')->getFont()->setBold(true);

    /**
     * Atur lebar kolom
     */
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(35);
    $sheet->getColumnDimension('C')->setWidth(16);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(11);
    $sheet->getColumnDimension('F')->setWidth(11);

    foreach (range('G', 'P') as $i => $col) {
      $sheet->getColumnDimension($col)->setWidth($i % 2 === 0 ? 14 : 15.5);
    }

    $sheet->getColumnDimension('Q')->setWidth(16);
    $sheet->getColumnDimension('R')->setWidth(8);
    $sheet->getColumnDimension('S')->setWidth(8);
    $sheet->getColumnDimension('T')->setWidth(10.4);
    $sheet->getColumnDimension('U')->setWidth(15);


    /**
     * Merge header tabel
     */
    $mergeMap = [
      'A7:A9',
      'B7:B9',
      'C7:C9',
      'D7:D9',
      'E7:F8',
      'G7:P7',
      'G8:H8',
      'I8:J8',
      'K8:L8',
      'M8:N8',
      'O8:P8',
      'Q7:Q9',
      'R7:S8',
      'T7:T9',
      'U7:U9',
    ];
    foreach ($mergeMap as $range) {
      $sheet->mergeCells($range);
    }


    /**
     * Styling header table
     */
    $length_column = $sheet->getHighestColumn();
    $sheet->getStyle("A7:{$length_column}10")->applyFromArray([
      'font' => ['bold' => true],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'wrapText'   => true,
      ],
    ]);


    /**
     * Styling urutan nomor header 1-22
     */
    $sheet->getStyle("A10:{$length_column}10")->applyFromArray([
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
    $start_data_row = 11;
    $length_row     = $sheet->getHighestRow();

    $sheet->getStyle("A7:{$length_column}{$length_row}")->applyFromArray([
      'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      ],
      'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
      ],
    ]);

    // Kolom yang harus center horizontal
    foreach (['D', 'E', 'F', 'A', 'R', 'S', 'T', 'U'] as $col) {
      $sheet->getStyle("{$col}{$start_data_row}:{$col}{$length_row}")
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    // Kolom format persen kolom (R, S)
    $sheet->getStyle("R{$start_data_row}:S{$length_row}")
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_0);

    // Kolom format ribuan
    $sheet->getStyle("C{$start_data_row}:C{$length_row}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');
    $sheet->getStyle("G{$start_data_row}:Q{$length_row}")
      ->getNumberFormat()
      ->setFormatCode('#,##0');


    /**
     * =====================================================
     * Styling baris subtotal per kategori & bold untuk judul
     * =====================================================
     */
    // Inisialisasi penghitung baris. Header Anda selesai di baris 10, jadi kita mulai dari 10.
    $currentRow = 10;

    // Loop utama untuk Kategori
    foreach ($this->skpd_anggaran->kategori_laporan as $kategori) {
      // Pindah ke baris selanjutnya untuk judul KATEGORI
      $currentRow++;

      // Dapatkan warna dari config. Default ke transparan jika tidak ada.
      $rgbaColor = config('app.xcolor_level_' . $kategori->level, 'rgba(255, 255, 255, 0)');
      $argbColor = 'FFFFFFFF'; // Fallback ke warna putih solid jika format salah

      // Konversi warna RGBA dari config ke format ARGB yang dikenali PhpSpreadsheet
      if (sscanf($rgbaColor, "rgba(%d, %d, %d, %f)", $r, $g, $b, $a) >= 3) {
        // Konversi alpha (0-1) ke alpha (0-255) lalu ke hex
        $alpha = isset($a) ? (int)round($a * 255) : 255; // Default ke solid jika alpha tidak ada
        $alphaHex = str_pad(dechex($alpha), 2, '0', STR_PAD_LEFT);

        // Konversi R, G, B ke hex
        $redHex   = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
        $greenHex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
        $blueHex  = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

        // Gabungkan menjadi format AARRGGBB
        $argbColor = strtoupper($alphaHex . $redHex . $greenHex . $blueHex);
      }

      // Terapkan styling untuk baris kategori (background & bold)
      $sheet->mergeCells("B{$currentRow}:C{$currentRow}");
      $sheet->getStyle("B{$currentRow}")->getFont()->setBold(true);
      $sheet->getStyle("A{$currentRow}:{$length_column}$currentRow")->applyFromArray([
        'fill' => [
          'fillType' => Fill::FILL_SOLID,
          'startColor' => ['argb' => $argbColor],
        ],
      ]);
      // panggil helper auto-height
      $this->autoHeightForMerged($sheet, 'B', 'C', $currentRow);

      // Hitung jumlah laporan dalam kategori ini
      $jumlahLaporan = count($kategori->laporan);

      // Jika ada laporan di dalam kategori ini
      if ($jumlahLaporan > 0) {
        // Lewati semua baris data laporan
        $currentRow += $jumlahLaporan;

        // Pindah ke baris selanjutnya, yaitu baris SUBTOTAL
        $currentRow++;

        // Terapkan styling untuk baris subtotal
        $subtotalRowRange = "A{$currentRow}:{$length_column}{$currentRow}";
        $sheet->getStyle($subtotalRowRange)->getFont()->setBold(true);
        $sheet->getRowDimension($currentRow)->setRowHeight(20);
        $sheet->mergeCells("A{$currentRow}:B{$currentRow}");
      }
    }

    // Styling baris terakhir total keseluruhan
    $sheet->getStyle("A{$length_row}:{$length_column}{$length_row}")->getFont()->setBold(true);
    $sheet->mergeCells("A{$length_row}:B{$length_row}");
    $sheet->getRowDimension($length_row)->setRowHeight(25);

    $sheet->setSelectedCell('A1');

    return [];
  }


  /**
   * AUTO HEGITH FOR MERGED
   */
  protected function autoHeightForMerged(Worksheet $sheet, string $startCol, string $endCol, int $row, int $lineHeightPt = 14): void
  {
    // Ambil semua kolom dalam range merge
    $mergedCols = range($startCol, $endCol);

    // Hitung total lebar kolom (approx)
    $totalWidth = 0;
    foreach ($mergedCols as $col) {
      $totalWidth += (float) $sheet->getColumnDimension($col)->getWidth();
    }

    // Ambil teks cell (hanya top-left cell yang dianggap)
    $cellText = (string) $sheet->getCell("{$startCol}{$row}")->getValue();
    $cellText = trim($cellText);

    // Estimasi jumlah karakter per baris
    $charsPerLine = max(1, (int) round($totalWidth * 1.0)); // faktor bisa diubah

    // Hitung jumlah baris hasil wordwrap
    $lines = 0;
    foreach (explode("\n", $cellText) as $part) {
      $part = trim($part);
      if ($part === '') {
        $lines += 1;
        continue;
      }
      $wrapped = wordwrap($part, $charsPerLine, "\n", true);
      $lines += max(1, substr_count($wrapped, "\n") + 1);
    }

    // Minimal 1 baris
    $lines = max(1, $lines);

    // Atur tinggi row
    $sheet->getRowDimension($row)->setRowHeight($lines * $lineHeightPt);
  }


  public function title(): string
  {
    return $this->bulan_anggaran;
  }
}
