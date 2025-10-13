<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SKPD;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SKPDController extends Controller
{
  /**
   * Handle show view skpd
   */
  public function index(Request $request)
  {
    $query = SKPD::orderBy('nama');

    if ($request->search)
      $query = $query->where('nama', 'like', "%{$request->search}%")
        ->orWhere('singkatan', 'like', "%{$request->search}%");

    $skpd = $query->paginate(15);

    return view('dashboard.skpd', compact('skpd'));
  }


  /**
   * Handle show view edit skpd
   */
  public function edit($id)
  {
    $skpd = SKPD::with('users')->findOrFail($id);

    return view('dashboard.form-skpd', compact('skpd'));
  }


  /**
   * Handle show view edit skpd
   */
  public function store(Request $request)
  {
    $skpd = SKPD::create([
      'nama'                   => $request->nama,
      'singkatan'              => $request->singkatan,
      'alamat'                 => $request->alamat,
      'pimpinan_skpd'          => $request->pimpinan_skpd,
      'nip_pimpinan'           => $request->nip_pimpinan,
      'pangkat_pimpinan'       => $request->pangkat_pimpinan,
      'golongan_pimpinan'      => $request->golongan_pimpinan,
      'jenis_kelamin_pimpinan' => $request->jenis_kelamin_pimpinan,
      'kontak_pimpinan'        => $request->kontak_pimpinan,
    ]);

    $username = Str::replace('-', '_', Str::lower($request->username));

    $userData = [
      'name'      => $request->name,
      'username'  => $username,
      'email'     => $request->email,
      'password'  => Hash::make($request->password),
      'skpd_id'   => $skpd->id,
    ];

    User::create($userData);

    alert()->success('Sukses!', 'Data SKPD berhasil ditambahkan.')->showConfirmButton('Ok', '#1D3D62');
    return redirect()->route('dashboard.edit-skpd', $skpd->id)->with('success', 'Data SKPD berhasil ditambahkan.');
  }


  /**
   * Handle update skpd
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'nama'                   => ['required', 'string', 'max:255'],
      'singkatan'              => ['required', 'string', 'max:255'],
      'alamat'                 => ['nullable', 'string', 'max:225'],
      'pimpinan_skpd'          => ['required', 'string', 'max:255'],
      'nip_pimpinan'           => ['nullable', 'string', 'min:18', 'max:18'],
      'pangkat_pimpinan'       => ['nullable', 'string', 'max:100'],
      'golongan_pimpinan'      => ['nullable', 'string', 'max:50'],
      'jenis_kelamin_pimpinan' => ['nullable'],
      'kontak_pimpinan'        => ['nullable', 'string', 'max:50'],
    ], [
      'nama.required'          => 'Nama SKPD wajib diisi.',
      'singkatan.required'     => 'Singkatan SKPD wajib diisi.',
      'pimpinan_skpd.required' => 'Nama pimpinan wajib diisi.',
      'nip_pimpinan.min'       => 'Nip minimal 18 digit.',
      'nip_pimpinan.max'       => 'Nip maksimal 18 digit.',
    ]);

    // Cari data SKPD
    $skpd = SKPD::findOrFail($id);

    // Update data SKPD
    $skpd->nama                   = $request->nama;
    $skpd->singkatan              = $request->singkatan;
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
   * Handle update user skpd
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
    $user->username = strtolower(str_replace(' ', '', $request->username));
    $user->email    = $request->email;

    $user->save();

    alert()->success('Sukses!', 'Data user berhasil diperbarui.')->showConfirmButton('Ok', '#1D3D62');;
    return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
  }


  /**
   * Handle reset password user skpd
   */
  public function resetPassword($id)
  {
    $user = User::findOrFail($id);
    abort_if(!$user, 404);

    $user->update([
      'password' => Hash::make(strtolower(str_replace(' ', '', $user->username)))
    ]);

    alert()->success('Sukses!', 'Password berhasil direset.')->showConfirmButton('Ok', '#1D3D62');
    return redirect()->back()->with('success', 'Password berhasil direset.')->with('active_tab', 'security');
  }


  /**
   * Handle delete skpd
   */
  public function delete($id)
  {
    $skpd = SKPD::findOrFail($id);
    $skpd->delete();

    alert()->success('Sukses!', 'SKPD berhasil dihapus.')->showConfirmButton('Ok', '#1D3D62');;
    return redirect()->route('dashboard.skpd')->with('success', 'SKPD berhasil dihapus');
  }
}
