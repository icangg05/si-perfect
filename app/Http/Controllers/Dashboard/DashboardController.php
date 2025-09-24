<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  /**
   * Handle show view dashboard.
   */
  public function index()
  {
    return view('dashboard.dashboard');
  }
}
