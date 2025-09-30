<x-layouts.dashboard>
	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-center">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">dashboard</i> Dashboard</h1>
				</div>
				<div class="page-description-actions d-flex flex-md-row flex-column align-items-start align-items-md-center gap-1">
					<form class="mt-4 mt-md-0 d-flex flex-md-row flex-column gap-1" action="{{ url()->current() }}" method="get" id="filterForm">
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
									<span id="total-pagu" class="text-primary fw-bolder fs-3"></span>
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
										<span id="realisasi-fisik"></span>
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
						<h5 class="card-title d-flex flex-column flex-md-row justify-content-between">
							<div class="d-flex gap-1 flex-row flex-md-column" style="font-size: 14px; font-weight: 400; line-height: 18px">
								<span class="text-muted">Total</span>
								<span class="text-muted">Realisasi</span>
							</div>
							<span id="total-jenis-paket" class="mt-2 mt-md-0 badge badge-primary badge-style-light"
								style="font-size: 1.4rem"></span>
						</h5>
					</div>
					<div class="card-body">
						<ul class="widget-list-content list-unstyled">
							<li class="widget-list-item widget-list-item-green">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">gavel</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Tender</a>
									<span id="tender" style="opacity: .95" class="text-dark widget-list-item-description-subtitle"></span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-blue">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">person_search</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Penunjukkan Langsung</a>
									<span id="penunjukkan-langsung" style="opacity: .95"
										class="text-dark widget-list-item-description-subtitle"></span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-purple">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">handyman</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Swakelola</a>
									<span id="swakelola" style="opacity: .95" class="text-dark widget-list-item-description-subtitle"></span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-yellow">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">shopping_cart</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">e-Purchasing</a>
									<span id="epurchasing" style="opacity: .95" class="text-dark widget-list-item-description-subtitle"></span>
								</span>
							</li>

							<li class="widget-list-item widget-list-item-red">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">assignment</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">Pengadaan Langsung</a>
									<span id="pengadaan-langsung" style="opacity: .95"
										class="text-dark widget-list-item-description-subtitle"></span>
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


		<script>
			function countUp(selector, endVal, options = {}) {
				const settings = $.extend({
					startVal: 0,
					duration: 2000, // ms
					decimalPlaces: 0,
					separator: '.',
					decimal: ',',
					prefix: '',
					suffix: '',
					easing: true
				}, options);

				const $el = $(selector);
				const startTime = performance.now();

				function formatNumber(num) {
					let strNum = num.toFixed(settings.decimalPlaces);

					// Hilangkan trailing zero desimal dinamis
					if (settings.decimalPlaces > 0) {
						strNum = parseFloat(strNum).toString();
					}

					let parts = strNum.split('.');
					let intPart = parts[0];
					let decPart = parts.length > 1 ? settings.decimal + parts[1] : '';

					// Tambah separator ribuan
					intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, settings.separator);

					return settings.prefix + intPart + decPart + settings.suffix;
				}

				function easeOutCubic(t) {
					return 1 - Math.pow(1 - t, 3);
				}

				function animate(now) {
					let progress = Math.min((now - startTime) / settings.duration, 1);
					if (settings.easing) {
						progress = easeOutCubic(progress);
					}
					const current = settings.startVal + (endVal - settings.startVal) * progress;
					$el.text(formatNumber(current));

					if (progress < 1) {
						requestAnimationFrame(animate);
					}
				}

				requestAnimationFrame(animate);
			}

			// Contoh penggunaan
			$(function() {
				countUp('#realisasi-fisik', {{ $realisasi_fisik }}, {
					decimalPlaces: 1,
					suffix: '%',
					duration: 2000,
				});
				countUp('#total-pagu', {{ $total_pagu }}, {
					decimalPlaces: 0,
					prefix: 'Rp ',
					duration: 2000,
				});
				countUp('#total-jenis-paket', {{ $total_jenis_paket }}, {
					decimalPlaces: 0,
					prefix: 'Rp ',
					duration: 2000,
				});

				countUp('#tender', {{ $tender }}, {
					decimalPlaces: 0,
					prefix: 'Rp ',
					duration: 2000,
				});
				countUp('#penunjukkan-langsung', {{ $penunjukkan_langsung }}, {
					decimalPlaces: 0,
					prefix: 'Rp ',
					duration: 2000,
				});
				countUp('#swakelola', {{ $swakelola }}, {
					decimalPlaces: 0,
					prefix: 'Rp ',
					duration: 2000,
				});
				countUp('#epurchasing', {{ $epurchasing }}, {
					decimalPlaces: 0,
					prefix: 'Rp ',
					duration: 2000,
				});
				countUp('#pengadaan-langsung', {{ $pengadaan_langsung }}, {
					decimalPlaces: 0,
					prefix: 'Rp ',
					duration: 2000,
				});
			});
		</script>
	@endpush

</x-layouts.dashboard>
