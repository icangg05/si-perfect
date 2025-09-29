<x-layouts.dashboard>
	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-center">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">dashboard</i> Dashboard</h1>
				</div>
				<div class="page-description-actions d-flex align-items-center gap-1">
					<form class="d-flex flex-md-row flex-column gap-1" action="{{ url()->current() }}" method="get" id="filterForm">
						@can('admin')
							<select name="skpd" id="skpdSelect" class="form-select">
								<option value="">-- Semua SKPD --</option>
								@foreach ($all_skpd as $key => $item)
									<option value="{{ $key }}" {{ request('skpd') == $key ? 'selected' : '' }}>
										{{ $item }}
									</option>
								@endforeach
							</select>
						@endcan

						<select name="tahun" id="tahunSelect" class="form-select">
							@for ($i = date('Y'); $i >= date('Y') - 3; $i--)
								<option value="{{ $i }}" {{ (request('tahun') ?? date('Y')) == $i ? 'selected' : '' }}>
									{{ $i }}
								</option>
							@endfor
						</select>
					</form>

					<span class="mx-2 border-start"></span>

					<a href="{{ route('logout') }}" class="btn btn-danger btn-style-light text-nowrap"><i
							class="material-icons">logout</i>Logout</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-8">
			<div class="row">
				{{-- Total pagu --}}
				<div class="col-xl-{{ Auth::user()->role == 'skpd' || request('skpd') ? '6' : '12' }}">
					<div class="card widget widget-info-navigation">
						<div class="card-body">
							<div class="widget-info-navigation-container">
								<div class="widget-info-navigation-content">
									<span class="text-muted">Total Pagu</span><br>
									<span class="text-primary fw-bolder fs-3">
										Rp <count-up>{{ $total_pagu ?? 0 }}</count-up>
									</span>
								</div>
								<div class="widget-info-navigation-action">
									<a href="#" class="btn btn-light btn-rounded"><i class="material-icons no-m">account_balance</i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- Realisasi fisik --}}
				<div class="col-xl-{{ Auth::user()->role == 'skpd' || request('skpd') ? '6' : '12' }}">
					<div class="card widget widget-info-navigation">
						<div class="card-body">
							<div class="widget-info-navigation-container">
								<div class="widget-info-navigation-content">
									<span class="text-muted">Realisasi Fisik</span><br>
									<span class="text-primary fw-bolder fs-3">
										<count-up>
											{{ round($realisasi_fisik ?? 0, 3) * 100 }}
										</count-up>
										%
									</span>
								</div>
								<div class="widget-info-navigation-action">
									<a href="#" class="btn btn-light btn-rounded"><i class="material-icons no-m">trending_up</i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- Data SKPD --}}
				@if (Auth::user()->role == 'skpd' || request('skpd'))
					<div class="col-xl-12">
						<div class="card widget widget-info-navigation shadow-sm border-0">
							<div class="card-body">
								<div class="d-flex">
									<!-- Avatar -->
									@php
										$name = Auth::user()->name; // contoh: "Pemda Sultra"
										$words = explode(' ', $skpd->pimpinan_skpd ?? 'Kepala SKPD');
										$initials = '';

										if (count($words) >= 2) {
										    $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
										} else {
										    $initials = strtoupper(substr($words[0], 0, 2)); // kalau cuma 1 kata
										}
									@endphp
									<div class="avatar avatar-rounded me-3 border">
										<div class="avatar-title bg-light text-dark fw-bold">

											{{ $initials }}
										</div>
									</div>

									<!-- Info -->
									<div class="flex-grow-1 mt-2">
										<h5 class="mb-1 fw-bold text-dark">
											{{ $skpd->pimpinan_skpd ?? 'Kepala SKPD' }}
										</h5>
										<p class="mb-3 text-muted fst-italic">
											{{ $skpd->nama }}
										</p>
									</div>
								</div>

								<ul class="mt-2 ps-3 list-unstyled mb-0">
									<li class="mb-2">
										<i class="material-icons me-2 align-middle fs-6 text-muted">badge</i>
										<span class="fw-semibold text-muted">NIP:</span>
										{{ $skpd->nip_pimpinan ? format_nip($skpd->nip_pimpinan) : '-' }}
									</li>
									<li class="mb-2">
										<i class="material-icons me-2 align-middle fs-6 text-muted">military_tech</i>
										<span class="fw-semibold text-muted">Pangkat:</span>
										{{ $skpd->pangkat_pimpinan ?? '-' }}
									</li>
									<li class="mb-2">
										<i class="material-icons me-2 align-middle fs-6 text-muted">layers</i>
										<span class="fw-semibold text-muted">Golongan:</span>
										{{ $skpd->golongan_pimpinan ?? '-' }}
									</li>
									<li class="mb-2">
										<i class="material-icons me-2 align-middle fs-6 text-muted">phone</i>
										<span class="fw-semibold text-muted">Kontak:</span>
										{{ $skpd->kontak_pimpinan ?? '-' }}
									</li>
									<li>
										<i class="material-icons me-2 align-middle fs-6 text-muted">email</i>
										<span class="fw-semibold text-muted">Email:</span>
										{{ $skpd->users->email ?? '-' }}
									</li>
								</ul>
							</div>

							<!-- Footer -->
							<div class="card-footer text-center bg-light border-0">
								<a
									href="{{ Auth::user()->role == 'admin' ? route('dashboard.edit-skpd', $skpd->id) : route('dashboard.pengaturan') }}"
									class="btn btn-outline-primary rounded-pill fw-semibold text-uppercase">
									<i class="material-icons align-middle me-1 fs-5">account_circle</i>
									Data Akun
								</a>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
		<div class="col-xl-4">
			{{-- Jenis paket --}}
			<div class="col-xl-12">
				<div class="card widget widget-list">
					<div class="card-header">
						<h5 class="card-title">
							<span class="text-muted">Jenis Paket</span>
							<span class="badge badge-primary badge-style-light" style="font-size: 1.3rem">
								Rp <count-up>{{ $total_jenis_paket ?? 0 }}</count-up>
							</span>
						</h5>
					</div>
					<div class="card-body">
						<ul class="widget-list-content list-unstyled">
							<li class="widget-list-item widget-list-item-green">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">gavel</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Tender</a>
									<span style="opacity: .95" class="text-dark widget-list-item-description-subtitle">
										Rp <count-up>{{ $tender ?? 0 }}</count-up>
									</span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-blue">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">person_search</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Penunjukkan Langsung</a>
									<span style="opacity: .95" class="text-dark widget-list-item-description-subtitle">
										Rp <count-up>{{ $penunjukkan_langsung ?? 0 }}</count-up>
									</span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-purple">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">handyman</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Swakelola</a>
									<span style="opacity: .95" class="text-dark widget-list-item-description-subtitle">
										Rp <count-up>{{ $swakelola ?? 0 }}</count-up>
									</span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-yellow">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">shopping_cart</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">e-Purchasing</a>
									<span style="opacity: .95" class="text-dark widget-list-item-description-subtitle">
										Rp <count-up>{{ $epurchasing ?? 0 }}</count-up>
									</span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-red">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">assignment</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Pengadaan Langsung</a>
									<span style="opacity: .95" class="text-dark widget-list-item-description-subtitle">
										Rp <count-up>{{ $pengadaan_langsung ?? 0 }}</count-up>
									</span>
								</span>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>

	@push('script')
		<script>
			$(document).ready(function() {
				$('#skpdSelect').select2({
					placeholder: '-- Semua SKPD --',
					allowClear: true,
					width: '230px',
				});
				$('#tahunSelect').select2({
					allowClear: true,
					width: '200px',
					minimumResultsForSearch: Infinity
				});
				$('#filterForm select').on('change', function() {
					$('#filterForm').submit();
				});
			});
		</script>
	@endpush
</x-layouts.dashboard>
