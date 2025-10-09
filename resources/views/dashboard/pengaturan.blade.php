<x-layouts.dashboard>
	<div class="row">
		<div class="col">
			<div class="page-description page-description-tabbed">
				<h1><i class="material-icons h3">settings</i> Pengaturan</h1>

				@php
					$activeTab =
					    session('active_tab') ??
					    ($errors->hasAny(['current_password', 'new_password', 'new_password_confirmation']) ? 'security' : 'account');
				@endphp
				{{-- <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button"
							role="tab" aria-controls="hoaccountme" aria-selected="true">Data Akun</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button"
							role="tab" aria-controls="security" aria-selected="false">Keamanan</button>
					</li>
				</ul> --}}
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
						@if (auth()->user()->role != 'admin')
							<div class="col-lg-7">
								<div class="card">
									<div class="card-header text-decoration-underline">
										Data SKPD
									</div>
									<div class="card-body">
										<form action="{{ route('dashboard.update-skpd', $skpd->id) }}" method="POST">
											@csrf
											<x-forms.input-group label="Nama SKPD" key="nama" placeholder="Nama SKPD" :readonly="true"
												:value="$skpd->nama" />
											<x-forms.input-group label="Singkatan" key="singkatan" placeholder="Singkatan" :readonly="true"
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
						@endif
						<div class="col-lg-{{ auth()->user()->role != 'admin' ? '5' : '7' }}">
							<div class="card">
								<div class="card-header text-decoration-underline">
									Data Login User
								</div>
								<div class="card-body">
									<form action="{{ route('dashboard.update-user', auth()->id()) }}" method="post">
										@csrf
										<div class="row">
											<div class="col">
												<label for="name" class="form-label">Nama User</label>
												<input type="text" class="form-control" id="name" aria-describedby="nameHelp"
													placeholder="Nama User" name="name" value="{{ old('name', auth()->user()->name) }}">
												@error('name')
													<div class="form-text text-danger">{{ $message }}</div>
												@enderror
											</div>
										</div>
										<div class="row m-t-lg">
											<div class="col">
												<label for="username" class="form-label">Username</label>
												<input type="text" class="form-control" id="username" aria-describedby="usernameHelp"
													placeholder="Username" name="username" value="{{ old('username', auth()->user()->username) }}">
												@error('username')
													<div class="form-text text-danger">{{ $message }}</div>
												@enderror
											</div>
										</div>
										<div class="row m-t-lg mb-3">
											<div class="col">
												<label for="email" class="form-label">Alamat Email</label>
												<input type="email" class="form-control" id="email" aria-describedby="settingsEmailHelp"
													placeholder="example@siperfect.com" name="email" value="{{ old('email', auth()->user()->email) }}">
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
								<h5>Ubah Password</h5>
								<span>Demi keamanan akun Anda, gunakan password yang kuat dan unik. Password yang aman sebaiknya terdiri
									dari:</span>
								<ul>
									<li>Minimal 8 karakter</li>
									<li>Kombinasi huruf besar (A–Z), huruf kecil (a–z)</li>
									<li>Angka (0–9)</li>
									<li>Simbol khusus (misalnya: @, #, $, %)</li>
								</ul>
							</div>

							<form action="{{ route('dashboard.update-password', auth()->id()) }}" method="post">
								@csrf
								<div class="row m-t-xxl">
									<div class="col-md-6">
										<label for="current_password" class="form-label">Password Lama</label>
										<div class="position-relative">
											<input id="current_password" type="password" class="form-control" aria-describedby="current_password"
												placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" name="current_password"
												autocomplete="off">
											<span id="toggle_current_password"
												class="material-icons position-absolute end-0 top-50 translate-middle-y me-3"
												style="cursor: pointer; color: #6c757d; font-size: 1.5rem">visibility_off</span>
										</div>
										<div id="current_password" class="form-text">Jangan membagikan kata sandi kepada siapa pun.</div>
										@error('current_password')
											<div class="form-text text-danger">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="row m-t-xxl">
									<div class="col-md-6">
										<label for="new_password" class="form-label">Password Baru</label>
										<div class="position-relative">
											<input id="new_password" type="password" class="form-control" aria-describedby="new_password"
												placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" name="new_password"
												autocomplete="off">
											<span id="toggle_new_password"
												class="material-icons position-absolute end-0 top-50 translate-middle-y me-3"
												style="cursor: pointer; color: #6c757d; font-size: 1.5rem">visibility_off</span>
										</div>
										@error('new_password')
											<div class="form-text text-danger">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="row m-t-xxl">
									<div class="col-md-6">
										<label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
										<div class="position-relative">
											<input id="new_password_confirmation" type="password" class="form-control" aria-describedby="new_password_confirmation"
												placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" name="new_password_confirmation"
												autocomplete="off">
											<span id="toggle_new_password_confirmation"
												class="material-icons position-absolute end-0 top-50 translate-middle-y me-3"
												style="cursor: pointer; color: #6c757d; font-size: 1.5rem">visibility_off</span>
										</div>
										@error('new_password_confirmation')
											<div class="form-text text-danger">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="row m-t-lg">
									<div class="col">
										<button type="submit" class="btn btn-primary m-t-sm">
											<i class="material-icons">lock</i> Ubah Password</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	@push('script')
		<script>
			$(document).ready(function() {
				$('#toggle_current_password').on('click', function() {
					const passwordField = $('#current_password');
					const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
					passwordField.attr('type', type);

					// Ganti ikon
					const icon = $(this);
					icon.text(type === 'password' ? 'visibility_off' : 'visibility');
				});


        $('#toggle_new_password').on('click', function() {
					const passwordField = $('#new_password');
					const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
					passwordField.attr('type', type);

					// Ganti ikon
					const icon = $(this);
					icon.text(type === 'password' ? 'visibility_off' : 'visibility');
				});


        $('#toggle_new_password_confirmation').on('click', function() {
					const passwordField = $('#new_password_confirmation');
					const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
					passwordField.attr('type', type);

					// Ganti ikon
					const icon = $(this);
					icon.text(type === 'password' ? 'visibility_off' : 'visibility');
				});
			});
		</script>
	@endpush
</x-layouts.dashboard>
