<?php

if (! function_exists('format_ribuan')) {
  function format_ribuan($value)
  {
    if ($value == null || !$value)
      return;
    return number_format($value, 0, ',', '.');
  }
}

if (! function_exists('mdd')) {
  function mdd($data)
  {
    return response()->json($data);
  }
}
