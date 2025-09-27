<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NestableController extends Controller
{
  // public function updateOrder(Request $request)
  // {
  //   $order = $request->input('order');

  //   if (!$order) {
  //     return response()->json(['status' => 'error', 'message' => 'Data kosong']);
  //   }

  //   $this->saveOrder($order, null, 0);

  //   return response()->json(['status' => 'success']);
  // }

  // private function saveOrder($items, $parentId, $level)
  // {
  //   foreach ($items as $i => $item) {
  //     KategoriLaporan::where('id', $item['id'])->update([
  //       'parent' => $parentId,
  //       'level' => $level,
  //       'urutan' => $i + 1,
  //     ]);

  //     if (isset($item['children']) && is_array($item['children'])) {
  //       $this->saveOrder($item['children'], $item['id'], $level + 1);
  //     }
  //   }
  // }

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
}
