<x-layouts.dashboard>
	<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteTitle"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title d-flex align-items-center gap-1" id="modalDeleteTitle">
						<i class="material-icons">warning</i> <span>Konfirmasi Hapus</span>
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<form action="{{ route('dashboard.destroy-skpd', $skpd->id) }}" method="POST">
					@csrf
					@method('delete')
					<div class="modal-body">

						<div class="alert alert-warning" role="alert">
							<strong>Peringatan!</strong>
							Seluruh data yang terkait dengan <b>SKPD ini</b> akan
							<u>terhapus permanen</u> dan tidak dapat dikembalikan.
							Penghapusan ini juga mencakup:
							<ul class="mb-0">
								<li>Seluruh <b>laporan realisasi</b> yang pernah dicatat oleh SKPD ini</li>
								<li>Data turunan lain yang berhubungan dengan SKPD ini</li>
							</ul>
						</div>

						<div class="mb-3">
							<label for="confirmDelete" class="form-label">
								Untuk melanjutkan, ketik <code>HAPUS</code> pada kotak di bawah:
							</label>
							<input type="text" class="form-control" id="confirmDelete"
								placeholder="Ketik HAPUS untuk konfirmasi" required autocomplete="off">
							<small class="text-muted">Tombol hapus baru aktif jika teks sesuai.</small>
						</div>

					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">
							Batal
						</button>
						<button type="submit" id="btnConfirmDelete" class="btn btn-danger" disabled>
							<i class="material-icons">delete</i> Hapus
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="page-description page-description-tabbed">
				<div class="d-flex align-items-start justify-content-between flex-column flex-md-row">
					<h1><i class="material-icons h3">corporate_fare</i> Data SKPD</h1>
					<div class="page-description-actions">
						<button class="btn btn-danger btn-style-light" data-bs-toggle="modal" href="#modalDelete" role="button">
							<i class="material-icons-outlined">delete</i> Hapus</button>
						<span class="mx-2 border-start"></span> {{-- pembatas --}}
						<a href="{{ url()->current() }}" class="btn btn-info btn-style-light">
							<i class="material-icons-outlined">refresh</i> Refresh</a>
						<a href="{{ route('dashboard.skpd') }}" class="btn btn-warning btn-style-light">
							<i class="material-icons">keyboard_backspace</i> Kembali
						</a>
					</div>

				</div>

				@php
					$activeTab =
					    session('active_tab') ??
					    ($errors->hasAny(['current_password', 'new_password', 'new_password_confirmation']) ? 'security' : 'account');
				@endphp
				<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link {{ $activeTab === 'account' ? 'active' : '' }}"
							id="account-tab" data-bs-toggle="tab" data-bs-target="#account"
							type="button" role="tab" aria-selected="{{ $activeTab === 'account' ? 'true' : 'false' }}">
							Data Akun
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link {{ $activeTab === 'security' ? 'active' : '' }}"
							id="security-tab" data-bs-toggle="tab" data-bs-target="#security"
							type="button" role="tab" aria-selected="{{ $activeTab === 'security' ? 'true' : 'false' }}">
							Keamanan
						</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade {{ $activeTab === 'account' ? 'show active' : '' }}" id="account" role="tabpanel">
					<div class="row">
						<div class="col-lg-7">
							<div class="card">
								<div class="card-header text-decoration-underline">
									Data SKPD
								</div>
								<div class="card-body">
									<form action="{{ route('dashboard.update-skpd-admin', $skpd->id) }}" method="POST">
										@csrf
										@method('patch')
										<x-forms.input-group label="Nama SKPD" key="nama" placeholder="Nama SKPD"
											:value="$skpd->nama" />
										<x-forms.input-group label="Singkatan" key="singkatan" placeholder="Singkatan"
											:value="$skpd->singkatan" />
										<x-forms.textarea-group label="Alamat" key="alamat" placeholder="Alamat" :value="$skpd->alamat" />
										<hr style="margin: 24px 0">
										<x-forms.input-group label="Kepala SKPD" key="pimpinan_skpd" placeholder="Kepala SKPD" :value="$skpd->pimpinan_skpd" />
										<x-forms.input-group label="NIP" key="nip_pimpinan" placeholder="NIP" :value="$skpd->nip_pimpinan" />
										<x-forms.input-group label="Pangkat" key="pangkat_pimpinan" placeholder="Pangkat" :value="$skpd->pangkat_pimpinan" />
										<x-forms.input-group label="golongan" key="golongan_pimpinan" placeholder="Golongan" :value="$skpd->golongan_pimpinan" />
										<x-forms.select-input-group label="Jenis Kelamin" key="jenis_kelamin_pimpinan"
											:value="$skpd->jenis_kelamin_pimpinan"
											:data="[['label' => 'Laki-Laki', 'value' => 'L'], ['label' => 'Perempuan', 'value' => 'P']]" />
										<x-forms.input-group label="Kontak" key="kontak_pimpinan" placeholder="08xx-xxxx-xxxx" :value="$skpd->kontak_pimpinan" />
										<div class="row">
											<div class="col">
												<button type="submit" class="btn btn-primary m-t-sm">
													<i class="material-icons">save_alt</i> Simpan</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="card">
								<div class="card-header text-decoration-underline">
									Data Login User
								</div>
								<div class="card-body">
									<form action="{{ route('dashboard.update-user-admin', $skpd->users->id) }}" method="post">
										@csrf
										@method('patch')
										<div class="row">
											<div class="col">
												<label for="name" class="form-label">Nama User</label>
												<input type="text" class="form-control" id="name" aria-describedby="nameHelp"
													placeholder="Nama User" name="name" value="{{ old('name', $skpd->users->name) }}">
												@error('name')
													<div class="form-text text-danger">{{ $message }}</div>
												@enderror
											</div>
										</div>
										<div class="row m-t-lg">
											<div class="col">
												<label for="username" class="form-label">Username</label>
												<input type="text" class="form-control" id="username" aria-describedby="usernameHelp"
													placeholder="Username" name="username" value="{{ old('username', $skpd->users->username) }}">
												@error('username')
													<div class="form-text text-danger">{{ $message }}</div>
												@enderror
											</div>
										</div>
										<div class="row m-t-lg mb-3">
											<div class="col">
												<label for="email" class="form-label">Alamat Email</label>
												<input type="email" class="form-control" id="email" aria-describedby="settingsEmailHelp"
													placeholder="example@siperfect.com" name="email" value="{{ old('email', $skpd->users->email) }}">
												@error('email')
													<div class="form-text text-danger">{{ $message }}</div>
												@enderror
											</div>
										</div>
										<div class="row">
											<div class="col">
												<button type="submit" class="btn btn-primary m-t-sm">
													<i class="material-icons">save_alt</i> Simpan</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade {{ $activeTab === 'security' ? 'show active' : '' }}" id="security" role="tabpanel">
					<div class="card">
						<div class="card-body">
							<div class="settings-security-two-factor">
								<h5>Reset Password</h5>
								<p>
									Fitur ini akan mengatur ulang (reset) password kembali ke nilai default,
									yaitu sama dengan <strong>username</strong> Anda. Lakukan ini hanya jika lupa password saat ini dan
									ingin mengembalikannya ke pengaturan awal.
								</p>
							</div>

							<div class="row">
								<div class="col-md-9">
									{{-- Pesan Peringatan --}}
									<div class="alert alert-warning d-flex align-items-center mt-4" role="alert">
										<span class="material-icons-outlined me-2">warning</span>
										<div>
											<strong>Perhatian!</strong> Setelah direset, password lama tidak akan bisa digunakan lagi.
										</div>
									</div>

									{{-- Informasi Username --}}
									<div class="mb-4">
										<p class="mb-1">Password akan direset menjadi:</p>
										<div class="fs-5 fw-bold bg-light p-3 rounded text-center" style="font-family: monospace; color: #d63384;">
											{{ strtolower(str_replace(' ', '', $skpd->users->username)) }}
										</div>
									</div>

									{{-- Form untuk Aksi Reset --}}
									<form action="{{ route('dashboard.reset-password', $skpd->users->id) }}" method="post">
										@csrf
										@method('PATCH')
										<div class="row m-t-lg">
											<div class="col">
												<button type="submit" class="btn btn-danger m-t-sm" onclick="return confirm('Lanjutkan untuk reset password?')">
													<i class="material-icons">lock_reset</i> Ya, Reset Password
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layouts.dashboard>
