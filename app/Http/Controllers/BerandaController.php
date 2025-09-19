<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BerandaController extends Controller
{
  /**
   * INDEX
   */
  public function index()
  {
    return view('welcome');
  }


  /**
   * EXPORT
   */
  public function export()
  {
    return Excel::download(new UsersExport, 'LAP Realisasi Barjas Juli DISHUB 2025.xlsx');

    // // 1. Generate Excel dari UsersExport
    // $export = new UsersExport();
    // $excel  = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

    // // 2. Simpan ke file sementara
    // $tempFile = storage_path('app/temp_export.xlsx');
    // file_put_contents($tempFile, $excel);

    // // 3. Load Excel pakai PhpSpreadsheet
    // $spreadsheet = IOFactory::load($tempFile);

    // // 4. Convert ke PDF dengan MPDF
    // $pdfFile = storage_path('app/LAP_RELASI_BARJAS_JULI_DISHUB_2025.pdf');
    // $writer  = IOFactory::createWriter($spreadsheet, 'Mpdf');
    // $writer->save($pdfFile);

    // // 5. Return sebagai download
    // return response()->download($pdfFile)->deleteFileAfterSend(true);
  }
}
