<?php

if (! function_exists('format_ribuan')) {
  function format_ribuan($value)
  {
    if ($value == null || !$value)
      return;
    return number_format($value, 0, ',', '.');
  }
}

if (! function_exists('format_persen')) {
  function format_persen($value, $as_blade = false)
  {
    if ($value == null || !$value)
      return;

    if ($as_blade) {
      // Jika as_blade true, format sebagai persentase dengan satu desimal
      // lalu tambahkan simbol persen
      $percentage = round($value * 100, 1);
      return $percentage . '%';
    }

    // Jika as_blade false, kembalikan nilai desimal
    // Bulatkan ke 3 angka di belakang koma untuk akurasi
    return round($value, 3);
  }
}

if (! function_exists('mdd')) {
  function mdd($data)
  {
    return response()->json($data);
  }
}
