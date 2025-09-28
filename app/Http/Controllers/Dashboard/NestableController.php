<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NestableController extends Controller
{
  public function updateOrder(Request $request)
  {
    $order = $request->input('order');

    if (!$order || !is_array($order)) {
      return response()->json(['status' => 'error', 'message' => 'Payload invalid'], 422);
    }

    DB::transaction(function () use ($order) {
      $counter = 0;
      $this->saveOrderFlatten($order, null, 1, $counter);
    });

    return response()->json(['status' => 'success']);
  }

  /**
   * Traversal preorder untuk menyimpan parent, level, dan urutan global.
   * @param array $items
   * @param int|null $parentId
   * @param int $level
   * @param int &$counter  (passed by reference)
   */
  private function saveOrderFlatten(array $items, $parentId, int $level, int &$counter)
  {
    foreach ($items as $item) {
      // safety: pastikan ada id
      if (!isset($item['id'])) continue;

      $counter++; // next global urutan
      $id = (int) $item['id'];

      KategoriLaporan::where('id', $id)->update([
        'parent' => $parentId === null ? null : $parentId,
        'level'  => $level,
        'urutan' => $counter,
      ]);

      if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0) {
        // rekursif ke anak — tetap membawa $counter oleh referensi
        $this->saveOrderFlatten($item['children'], $id, $level + 1, $counter);
      }
    }
  }


  /**
   * Store kategori
   */
  public function storeKategori(Request $request, $skpd_anggaran_id)
  {
    DB::transaction(function () use ($request, $skpd_anggaran_id) {
      // Naikkan semua urutan lama +1
      KategoriLaporan::where('skpd_anggaran_id', $skpd_anggaran_id)
        ->increment('urutan');

      // Insert data baru di urutan 1
      KategoriLaporan::create([
        'skpd_anggaran_id' => $skpd_anggaran_id,
        'nama'             => ucfirst($request->nama_kategori),
        'parent'           => null,
        'level'            => 1,
        'urutan'           => 1,
      ]);
    });

    alert()->success('Sukses!', 'Kategori berhasil ditambahkan.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back()->with('active_tab', 'struktur-anggaran');
  }

  /**
   * Store kategori
   */
  public function updateKategori(Request $request, $id)
  {
    $kategori_laporan = KategoriLaporan::findOrFail($id);
    $kategori_laporan->update(['nama' => ucfirst($request->nama_kategori_edit)]);

    alert()->success('Sukses!', 'Kategori berhasil diperbarui.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back()->with('active_tab', 'struktur-anggaran');
  }

  /**
   * Destroy kategori
   */
  public function destroyKategori($id)
  {
    $kategori_laporan = KategoriLaporan::findOrFail($id);

    $kategori_laporan->deleteWithChildren();

    alert()->success('Sukses!', 'Kategori berhasil ditambahkan.')
      ->showConfirmButton('Ok', '#1D3D62');

    return redirect()->back()->with('active_tab', 'struktur-anggaran');
  }
}
