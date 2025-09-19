<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SKPD;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
  /**
   * Handle show view pengaturan.
   */
  public function index()
  {
    $skpd = Auth::user()->skpd;

    return view('dashboard.pengaturan', compact('skpd'));
  }


  /**
   * Handle update data user login
   */
  public function updateUser(Request $request, $id)
  {
    $request->validate([
      'name'     => ['required'],
      'username' => ['required'],
      'email'    => ['required', 'email'],
    ], [
      'name.required'     => 'Nama wajib diisi.',
      'username.required' => 'Username wajib diisi.',
      'email.required'    => 'Email wajib diisi.',
      'email.email'       => 'Format email tidak valid.',
    ]);

    // Cari user
    $user = User::findOrFail($id);

    // Update data
    $user->name     = $request->name;
    $user->username = $request->username;
    $user->email    = $request->email;

    $user->save();

    alert()->success('Sukses!', 'Data user berhasil diperbarui.')->showConfirmButton('Ok', '#1D3D62');;
    return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
  }

  /**
   * Handle update data skpd
   */
  public function updateSKPD(Request $request, $id)
  {
    $request->validate([
      'alamat'                 => ['nullable', 'string'],
      'pimpinan_skpd'          => ['required', 'string', 'max:255'],
      'nip_pimpinan'           => ['nullable', 'string', 'max:18'],
      'pangkat_pimpinan'       => ['nullable', 'string', 'max:100'],
      'golongan_pimpinan'      => ['nullable', 'string', 'max:50'],
      'jenis_kelamin_pimpinan' => ['nullable'],
      'kontak_pimpinan'        => ['nullable', 'string', 'max:50'],
    ], [
      'nama.required'          => 'Nama SKPD wajib diisi.',
      'pimpinan_skpd.required' => 'Nama pimpinan wajib diisi.',
    ]);

    // Cari data SKPD
    $skpd = SKPD::findOrFail($id);

    // Update data SKPD
    $skpd->alamat                 = $request->alamat;
    $skpd->pimpinan_skpd          = $request->pimpinan_skpd;
    $skpd->nip_pimpinan           = $request->nip_pimpinan;
    $skpd->pangkat_pimpinan       = $request->pangkat_pimpinan;
    $skpd->golongan_pimpinan      = $request->golongan_pimpinan;
    $skpd->jenis_kelamin_pimpinan = $request->jenis_kelamin_pimpinan;
    $skpd->kontak_pimpinan        = $request->kontak_pimpinan;

    $skpd->save();

    alert()->success('Sukses!', 'Data SKPD berhasil diperbarui.')->showConfirmButton('Ok', '#1D3D62');
    return redirect()->back()->with('success', 'Data SKPD berhasil diperbarui.');
  }


  /**
   * Handle update user password
   */
  public function updatePassword(Request $request, $id)
  {
    // Validasi input
    $request->validate([
      'current_password'      => ['required'],
      'new_password'          => ['required', 'min:8', 'confirmed'],
      // 'confirmed' otomatis cek dengan field new_password_confirmation
    ], [
      'current_password.required' => 'Password lama wajib diisi.',
      'new_password.required'     => 'Password baru wajib diisi.',
      'new_password.min'          => 'Password baru minimal 8 karakter.',
      'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
    ]);

    // Cari user berdasarkan ID
    $user = User::findOrFail($id);

    // Cek apakah password lama sesuai
    if (!Hash::check($request->current_password, $user->password)) {
      return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
    }

    // Update password baru
    $user->password = Hash::make($request->new_password);
    $user->save();

    alert()->success('Sukses!', 'Password berhasil diperbarui.')->showConfirmButton('Ok', '#1D3D62');
    return redirect()->back()->with('success', 'Password berhasil diperbarui.')->with('active_tab', 'security');
  }
}
