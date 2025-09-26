<x-layouts.dashboard>
	<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateTitle"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalCreateTitle">Buat Laporan Realisasi</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<form action="{{ route('dashboard.laporan-realisasi.store') }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="mb-3">
							@php
								$users = App\Models\User::with('skpd')->where('role', 'skpd')->get();
							@endphp
							<label for="skpd_id" class="form-label">SKPD</label>
							<select class="form-select" id="skpd_id" name="skpd_id" required @disabled(auth()->user()->role == 'skpd')>
								<option value=""></option>
								@foreach ($users as $u)
									<option @selected($u->skpd->nama == auth()->user()->skpd?->nama) value="{{ $u->skpd->id }}">{{ $u->skpd->singkatan }}</option>
								@endforeach
							</select>

							@if (auth()->user()->role == 'skpd')
								<input type="hidden" name="skpd_id" value="{{ auth()->user()->skpd->id }}">
							@endif
						</div>

						<div class="mb-3">
							<label for="jenis_pengadaan" class="form-label">Jenis Pengadaan</label>
							<input type="text" class="form-control" id="jenis_pengadaan" name="jenis_pengadaan"
								placeholder="Masukkan jenis pengadaan..." required>
						</div>

						<div class="mb-3">
							<label for="tahun_anggaran" class="form-label">Tahun Anggaran</label>
							<input type="number" class="form-control" id="tahun_anggaran" name="tahun_anggaran"
								min="2000" max="2100" value="{{ date('Y') }}" required>
						</div>

						<div class="mb-3">
							<label for="bulan_anggaran" class="form-label">Bulan</label>
							<select class="form-select" id="bulan_anggaran" name="bulan_anggaran" required>
								<option value=""></option>
								@php
									$months = [
									    1 => 'Januari',
									    2 => 'Februari',
									    3 => 'Maret',
									    4 => 'April',
									    5 => 'Mei',
									    6 => 'Juni',
									    7 => 'Juli',
									    8 => 'Agustus',
									    9 => 'September',
									    10 => 'Oktober',
									    11 => 'November',
									    12 => 'Desember',
									];
								@endphp
								@foreach ($months as $num => $month)
									<option value="{{ $num }}">{{ $month }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Kembali
						</button>
						<button type="submit" class="btn btn-primary">
							<i class="material-icons">save_alt</i> Simpan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-start">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">summarize</i> Laporan Realisasi</h1>
					<span>Halaman ini menampilkan data laporan realisasi anggaran berdasarkan SKPD, bulan, dan tahun anggaran.</span>
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
						Laporan Realisasi
						<span style="color: rgb(155, 155, 155);">—</span>
						<span style="font-weight: 400; font-size: .9rem">
							{{ auth()->user()->role == 'admin'
							    ? 'Bagian Administrasi Pembangunan Setda Kota Kendari'
							    : auth()->user()->skpd->nama }}
						</span>
					</h5>

					<form action="{{ url()->current() }}" method="GET" class="d-flex flex-md-nowrap flex-wrap"
						style="gap: .5rem">
						{{-- Input pencarian --}}
						<input type="text" name="search" class="form-control" placeholder="Cari data..."
							value="{{ request('search') }}" @if (request('search')) autofocus @endif>

						{{-- Filter bulan --}}
						<select name="bulan" id="bulanFilter" class="form-select">
							<option value="">-- Semua Bulan --</option>
							@foreach (range(1, 12) as $i)
								<option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
									{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
								</option>
							@endforeach
						</select>

						<button type="submit"
							class="btn btn-sm btn-primary d-flex align-items-center justify-content-center">
							<i class="material-icons" style="font-size:18px; padding-left: 8px">search</i>
						</button>
					</form>
				</div>


				<div class="card-body">
					<p class="card-description">Gunakan tabel di bawah ini untuk melihat, mencari, atau mengekspor data laporan
						realisasi anggaran.</p>
					<div class="example-container">
						<div class="example-content table-responsive my-scrollbar">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">No</th>
										<th scope="col">Jenis Pengadaan</th>
										@if (auth()->user()->role == 'admin')
											<th scope="col">SKPD</th>
										@endif
										<th scope="col">Bulan</th>
										<th scope="col">Tahun Anggaran</th>
										<th scope="col">Aksi</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($skpd_anggaran as $item)
										<tr>
											<th scope="row">{{ $loop->iteration + $skpd_anggaran->firstItem() - 1 }}.</th>
											<td>{{ $item->jenis_pengadaan }}</td>
											@if (auth()->user()->role == 'admin')
												<td>{{ $item->skpd->nama }}</td>
											@endif
											<td>{{ Carbon\Carbon::create()->month($item->bulan_anggaran)->translatedFormat('F') }}</td>
											<td>{{ $item->tahun_anggaran }}</td>
											<td>
												<a href="{{ route('dashboard.laporan-realisasi-item', $item->id) }}"
													class="btn btn-sm btn-primary text-nowrap">
													<span class="material-icons" style="font-size: 18px; vertical-align: middle;">visibility</span>
													Lihat
												</a>

												<form class="d-inline" action="{{ route('export', $item->id) }}" method="post">
													@csrf
													<button type="submit"
														class="btn btn-sm btn-success text-nowrap {{ $item->laporan_count == 0 ? 'disabled' : '' }}">
														<span class="material-icons" style="font-size: 18px; vertical-align: middle;">description</span>
														Export
													</button>
												</form>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="{{ auth()->user()->role == 'admin' ? '6' : '5' }}" class="text-center text-muted">Tidak ada
												data ditemukan.</td>
										</tr>
									@endforelse
								</tbody>
							</table>
							{{-- pagination --}}
							{{ $skpd_anggaran->withQueryString()->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('script')
		<script>
			$(document).ready(function() {

				$('#skpd_id').select2({
					placeholder: '-- Pilih SKPD --',
					allowClear: false,
					dropdownParent: $('#modalCreate'),
					width: '100%',
				});
				$('#bulan_anggaran').select2({
					placeholder: '-- Pilih Bulan --',
					allowClear: false,
					dropdownParent: $('#modalCreate'),
					width: '100%',
					minimumResultsForSearch: Infinity
				});
				$('#bulanFilter').select2({
					placeholder: '-- Semua Bulan --',
					allowClear: true,
					width: '100%',
					minimumResultsForSearch: Infinity
				});
			});
		</script>
	@endpush
</x-layouts.dashboard>
