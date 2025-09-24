<x-layouts.dashboard>
	<div class="modal fade my-scrollbar" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateTitle"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl"> {{-- pakai modal-xl biar muat --}}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalCreateTitle">Tambah Data SKPD</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"
						aria-label="Close"></button>
				</div>

				<form action="{{ route('dashboard.skpd.store') }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="card">
							<div class="card-header text-center text-decoration-underline">
								Form Tambah SKPD
							</div>
							<hr>
							<div class="card-body">

								<div class="row">
									{{-- Kolom Kiri: Data SKPD --}}
									<div class="col-lg-6">
										<h6 class="mb-3 text-decoration-underline">Data SKPD</h6>

										<div class="mb-3">
											<label for="nama" class="form-label">Nama SKPD <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama SKPD"
												value="{{ old('nama') }}" required>
										</div>

										<div class="mb-3">
											<label for="singkatan" class="form-label">Singkatan <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="singkatan" name="singkatan" placeholder="Singkatan"
												value="{{ old('singkatan') }}" required>
										</div>

										<div class="mb-3">
											<label for="alamat" class="form-label">Alamat <span>*</span></label>
											<textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{ old('alamat') }}</textarea>
										</div>

										<hr class="my-4">

										<h6 class="mb-3 text-decoration-underline">Kepala SKPD</h6>

										<div class="mb-3">
											<label for="pimpinan_skpd" class="form-label">Nama Pimpinan <span>*</span></label>
											<input type="text" class="form-control" id="pimpinan_skpd" name="pimpinan_skpd"
												placeholder="Kepala SKPD" value="{{ old('pimpinan_skpd') }}">
										</div>

										<div class="mb-3">
											<label for="nip_pimpinan" class="form-label">NIP <span>*</span></label>
											<input type="text" class="form-control" id="nip_pimpinan" name="nip_pimpinan" placeholder="NIP"
												value="{{ old('nip_pimpinan') }}">
										</div>

										<div class="row mb-3">
											<label class="form-label">Pangkat / Golongan <span>*</span></label>
											<div class="col">
												<input type="text" class="form-control" id="pangkat_pimpinan" name="pangkat_pimpinan"
													placeholder="Pangkat" value="{{ old('pangkat_pimpinan') }}">
											</div>
											<div class="col">
												<input type="text" class="form-control" id="golongan_pimpinan" name="golongan_pimpinan"
													placeholder="Golongan" value="{{ old('golongan_pimpinan') }}">
											</div>
										</div>

										<div class="mb-3">
											<label for="jenis_kelamin_pimpinan" class="form-label">Jenis Kelamin <span>*</span></label>
											<select class="form-select" id="jenis_kelamin_pimpinan" name="jenis_kelamin_pimpinan">
												<option value="">-- Pilih --</option>
												<option value="L" {{ old('jenis_kelamin_pimpinan') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
												<option value="P" {{ old('jenis_kelamin_pimpinan') == 'P' ? 'selected' : '' }}>Perempuan</option>
											</select>
										</div>

										<div class="mb-3">
											<label for="kontak_pimpinan" class="form-label">Kontak <span>*</span></label>
											<input type="text" class="form-control" id="kontak_pimpinan" name="kontak_pimpinan"
												placeholder="08xx-xxxx-xxxx" value="{{ old('kontak_pimpinan') }}">
										</div>
									</div>

									{{-- Kolom Kanan: Data Login User --}}
									<div class="col-lg-6">
										<h6 class="mb-3 text-decoration-underline">Data Login User</h6>

										<div class="mb-3">
											<label for="name" class="form-label">Nama User <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="name" name="name" placeholder="Nama User"
												value="{{ old('name') }}" required>
										</div>

										<div class="mb-3">
											<label for="username" class="form-label">Username <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="username" name="username" placeholder="Username"
												value="{{ old('username') }}" required>
										</div>

										<div class="mb-3">
											<label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
											<input type="email" class="form-control" id="email" name="email"
												placeholder="example@siperfect.com" value="{{ old('email') }}" required>
										</div>

										<div class="mb-3">
											<label for="password" class="form-label">Password</label>
											<input type="text" class="form-control" id="password" name="password" readonly>
											<small class="text-muted">Password akan otomatis mengikuti Username</small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Tutup
						</button>
						<button type="submit" class="btn btn-primary">
							<i class="material-icons">save_alt</i> Simpan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@push('script')
		<script>
			$(document).ready(function() {
				$('#username').on('input', function() {
					let val = $(this).val();

					// ubah ke huruf kecil
					val = val.toLowerCase();

					// ganti "-" jadi "_"
					val = val.replace(/-/g, '_');

					// hapus spasi
					val = val.replace(/\s+/g, '');

					// set ke password
					$('#password').val(val);
          $('#username').val(val);
				});
			});
		</script>
	@endpush


	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-start">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">corporate_fare</i> Data SKPD</h1>
					<span>Halaman ini menampilkan daftar semua Satuan Kerja Perangkat Daerah (SKPD).</span>
				</div>
				<div class="page-description-actions">
					<a href="{{ url()->current() }}" class="btn btn-info btn-style-light">
						<i class="material-icons-outlined">refresh</i> Refresh</a>
					<a href="#" class="btn btn-warning btn-style-light" data-bs-toggle="modal"
						data-bs-target="#modalCreate"><i class="material-icons">add</i>Buat</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div
					class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
					<h5 class="card-title d-flex align-items-center gap-2 mb-2 mb-md-0">
						Daftar SKPD
						<span style="color: rgb(155, 155, 155);">—</span>
						<span style="font-weight: 400; font-size: .9rem">
							Total: {{ $skpd->total() }} Data
						</span>
					</h5>

					<form action="{{ url()->current() }}" method="GET" class="d-flex flex-md-nowrap flex-wrap"
						style="gap: .5rem">
						{{-- Input pencarian --}}
						<input type="text" name="search" class="form-control" placeholder="Cari data..."
							value="{{ request('search') }}" @if (request('search')) autofocus @endif>
						<button type="submit"
							class="btn btn-sm btn-primary d-flex align-items-center justify-content-center">
							<i class="material-icons" style="font-size:18px; padding-left: 8px">search</i>
						</button>
					</form>
				</div>

				<div class="card-body">
					<p class="card-description">Gunakan tabel di bawah ini untuk melihat dan mencari data SKPD.</p>
					<div class="example-container">
						<div class="example-content table-responsive my-scrollbar">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">No</th>
										<th scope="col">Nama SKPD</th>
										<th scope="col">Kepala SKPD</th>
										<th scope="col">Alamat</th>
										<th scope="col">Aksi</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($skpd as $item)
										<tr>
											<th scope="row">{{ $loop->iteration + $skpd->firstItem() - 1 }}.</th>
											<td>
												{{ $item->nama }}
												<br>
												<span class="text-muted">{{ $item->singkatan }}</span>
											</td>
											<td>{{ $item->pimpinan_skpd ?? '-' }}</td>
											<td>{{ $item->alamat ?? '-' }}</td>
											<td>
												<a href="{{ route('dashboard.edit-skpd', $item->id) }}"
													class="btn btn-sm btn-primary text-nowrap">
													<span class="material-icons" style="font-size: 18px; vertical-align: middle;">visibility</span>
													Lihat
												</a>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="4" class="text-center text-muted">Tidak ada
												data ditemukan.</td>
										</tr>
									@endforelse
								</tbody>
							</table>
							{{-- pagination --}}
							{{ $skpd->withQueryString()->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layouts.dashboard>
