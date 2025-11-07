<x-layouts.dashboard>
	@include('dashboard.laporan-realisasi-item.modal-create-kategori')
	@include('dashboard.laporan-realisasi-item.modal-edit-kategori')
	@include('dashboard.laporan-realisasi-item.modal-delete-kategori')
	@include('dashboard.laporan-realisasi-item.modal-pilih-struktur-anggaran')

	@include('dashboard.laporan-realisasi-item.modal-delete-laporan')
	@include('dashboard.laporan-realisasi-item.modal-edit-item-anggaran')
	@include('dashboard.laporan-realisasi-item.script')

	<!-- Baris utama -->
	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-start">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">summarize</i> Laporan Realisasi</h1>
					<span>
						Detail laporan realisasi anggaran berdasarkan SKPD untuk periode
						<strong>{{ $skpd_anggaran->bulan }}</strong>
						<strong>{{ $skpd_anggaran->tahun_anggaran }}</strong>.
					</span>
				</div>
				<div
					class="page-description-actions d-flex align-items-md-start align-items-md-center gap-0 gap-md-3 flex-column flex-md-row">
					<div>
						<button class="mt-4 mt-md-0 me-2 btn btn-danger btn-style-light" data-bs-toggle="modal" href="#modalDeleteLaporan"
							role="button">
							<i class="material-icons-outlined">delete</i> Hapus</button>
						<a href="{{ url()->current() }}" class="btn btn-info btn-style-light">
							<i class="material-icons-outlined">refresh</i> Refresh</a>
					</div>
					<a href="{{ route('dashboard.laporan-realisasi') }}" class="btn btn-warning btn-style-light">
						<i class="material-icons">keyboard_backspace</i> Kembali
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		@if ($errors->any())
			<div class="col-md-12">
				<div class="alert alert-custom" role="alert">
					<div class="custom-alert-icon icon-danger"><i class="material-icons-outlined h1">error</i></div>
					<div class="alert-content">
						<span class="alert-title">Terjadi kesalahan</span>
						<ul class="alert-text">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif
		<div class="col">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title d-flex align-items-center gap-2 mb-2 mb-md-0">
						{{ $skpd_anggaran->jenis_pengadaan }}
						<span style="color: rgb(155, 155, 155);">—</span>
						<span style="font-weight: 400; font-size: .9rem">
							{{ $skpd_anggaran->skpd->nama }}
						</span>
					</h5>
				</div>
				<div class="card-body">
					<p class="card-description">
						Detail data laporan realisasi untuk jenis pengadaan
						<strong>{{ $skpd_anggaran->jenis_pengadaan }}</strong>
						pada bulan
						<strong>{{ Carbon\Carbon::create()->month($skpd_anggaran->bulan_anggaran)->translatedFormat('F') }}</strong>
						tahun <strong>{{ $skpd_anggaran->tahun_anggaran }}</strong>.
						Silakan pilih tab untuk melihat item anggaran maupun data anggaran yang terkait.
					</p>
					<div class="example-container">
						<div class="example-content">
							@php
								$activeTab = session('active_tab') ?? 'item-anggaran';
							@endphp
							<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link {{ $activeTab === 'item-anggaran' ? 'active' : '' }}" id="pills-home-tab"
										data-bs-toggle="pill"
										data-bs-target="#item-anggaran" type="button" role="tab" aria-controls="pills-home"
										aria-selected="true">Item Anggaran</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link {{ $activeTab === 'struktur-anggaran' ? 'active' : '' }}" id="pills-home-tab"
										data-bs-toggle="pill"
										data-bs-target="#struktur-anggaran" type="button" role="tab" aria-controls="pills-home"
										aria-selected="true">Struktur Anggaran</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link {{ $activeTab === 'data-utama' ? 'active' : '' }}" id="pills-profile-tab"
										data-bs-toggle="pill"
										data-bs-target="#data-utama" type="button" role="tab"
										aria-controls="pills-profile" aria-selected="false">Data Utama</button>
								</li>
							</ul>
							<div class="tab-content" id="pills-tabContent">
								<!-- Item anggaran -->
								<div class="tab-pane fade {{ $activeTab === 'item-anggaran' ? 'active show' : '' }}" id="item-anggaran"
									role="tabpanel"
									aria-labelledby="pills-home-tab">
									<div class="mt-4">
										@if (count($skpd_anggaran->kategori_laporan) > 0)
											<a href="{{ route('dashboard.create-item-anggaran', $skpd_anggaran->id) }}" class="btn btn-primary btn-sm"
												style="font-size: .9rem">
												<i class="material-icons" style="font-size: 1.1rem">add</i> Tambah Item
											</a>
										@else
											<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
												title="Buat struktur anggaran terlebih dahulu.">
												<i class="material-icons" style="font-size: 1.1rem">add</i> Tambah Item
											</button>
										@endif
										<form class="d-inline" action="{{ route('export', $skpd_anggaran->id) }}" method="post">
											@csrf
											<button @disabled($skpd_anggaran->laporan->count() == 0) type="submit" class="btn btn-success btn-sm"
												style="font-size: .9rem">
												<i class="material-icons" style="font-size: 1.1rem">description</i> Export</button>
										</form>
									</div>

									<div class="mt-3 table-responsive my-scrollbar">
										<table class="table table-sm table-bordered table-hover my-table font-arimo">
											<thead class="text-center align-middle">
												<tr>
													<th scope="col" rowspan="3">NO.</th>
													<th scope="col" rowspan="3">NAMA PEKERJAAN</th>
													<th scope="col" rowspan="3">PAGU (Rp)</th>
													<th scope="col" rowspan="3">NO. KONTRAK</th>
													<th scope="col" rowspan="2" colspan="2">TANGGAL KONTRAK</th>
													<th scope="col" colspan="10">JENIS PAKET</th>
													<th scope="col" rowspan="3">TOTAL REALISASI ANGGARAN</th>
													<th scope="col" rowspan="2" colspan="2">PRESENTASI REALISASI</th>
													<th scope="col" rowspan="3">SUMBER DANA (APBD/ DAK/ DID)</th>
													<th scope="col" rowspan="3">KET</th>
													<th scope="col" rowspan="3">AKSI</th>
												</tr>
												<tr>
													<th colspan="2">TENDER</th>
													<th colspan="2">PENUNJUKKAN LANGSUNG</th>
													<th colspan="2">SWAKELOLA</th>
													<th colspan="2">E-PURCHASING</th>
													<th colspan="2">PENGADAAN LANGSUNG</th>
												</tr>
												<tr>
													<th>MULAI</th>
													<th>BERAKHIR</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>KEUANGAN (%)</th>
													<th>FISIK (%)</th>
												</tr>
											</thead>
											<tbody>
												<!-- Loop item anggaran -->
												@if (count($skpd_anggaran->kategori_laporan) > 0)
													@php
														$total_realisasi_keseluruhan = 0;
														$realisasi_fisik_keseluruhan = 0;
													@endphp
													@foreach ($skpd_anggaran->kategori_laporan as $kategori)
														<tr style="background: {{ config('app.color_level_' . $kategori->level) ?? 'transparent' }}">
															<th></th>
															<th colspan="2" class="fw-bold" style="position: relative">
																<span class="font-arimo">{{ $kategori->nama }}</span>
															</th>
															@for ($i = 0; $i < 19; $i++)
																<th></th>
															@endfor
														</tr>

														<!-- Total perkategori -->
														@php
															$total_pagu_perkategori = 0;
															$total_nilai_tender_perkategori = 0;
															$total_realisasi_tender_perkategori = 0;
															$total_nilai_penunjukkan_langsung_perkategori = 0;
															$total_realisasi_penunjukkan_langsung_perkategori = 0;
															$total_nilai_swakelola_perkategori = 0;
															$total_realisasi_swakelola_perkategori = 0;
															$total_nilai_epurchasing_perkategori = 0;
															$total_realisasi_epurchasing_perkategori = 0;
															$total_nilai_pengadaan_langsung_perkategori = 0;
															$total_realisasi_pengadaan_langsung_perkategori = 0;

															$total_realisasi_anggaran_perkategori = 0;
															$realisasi_fisik_perkategori = 0;
														@endphp

														<!-- Baris item anggaran -->
														@if (count($kategori->laporan) > 0)
															@foreach ($kategori->laporan as $laporan)
																@php
																	$rowError = session('row_id') == $laporan->id;
																	$total_realisasi_anggaran_perbaris = 0;
																	$realisasi_keuangan_perbaris = 0;

																	// Jumlah nilai untuk perbaris
																	$total_realisasi_anggaran_perbaris +=
																	    // $laporan->nilai_kontrak_tender +
																	    $laporan->realisasi_tender +
																	    // $laporan->nilai_kontrak_penunjukkan_langsung +
																	    $laporan->realisasi_penunjukkan_langsung +
																	    // $laporan->nilai_kontrak_swakelola +
																	    $laporan->realisasi_swakelola +
																	    // $laporan->nilai_kontrak_epurchasing +
																	    $laporan->realisasi_epurchasing +
																	    // $laporan->nilai_kontrak_pengadaan_langsung +
																	    $laporan->realisasi_pengadaan_langsung;
																	$realisasi_keuangan_perbaris = $total_realisasi_anggaran_perbaris / max($laporan->pagu, 1);

																	// Jumlah nilai untuk baris subtotal
																	$total_pagu_perkategori += $laporan->pagu;
																	$total_nilai_tender_perkategori += $laporan->nilai_kontrak_tender;
																	$total_realisasi_tender_perkategori += $laporan->realisasi_tender;
																	$total_nilai_penunjukkan_langsung_perkategori += $laporan->nilai_kontrak_penunjukkan_langsung;
																	$total_realisasi_penunjukkan_langsung_perkategori += $laporan->realisasi_penunjukkan_langsung;
																	$total_nilai_swakelola_perkategori += $laporan->nilai_kontrak_swakelola;
																	$total_realisasi_swakelola_perkategori += $laporan->realisasi_swakelola;
																	$total_nilai_epurchasing_perkategori += $laporan->nilai_kontrak_epurchasing;
																	$total_realisasi_epurchasing_perkategori += $laporan->realisasi_epurchasing;
																	$total_nilai_pengadaan_langsung_perkategori += $laporan->nilai_kontrak_pengadaan_langsung;
																	$total_realisasi_pengadaan_langsung_perkategori += $laporan->realisasi_pengadaan_langsung;

																	$total_realisasi_anggaran_perkategori += $total_realisasi_anggaran_perbaris;
																	$realisasi_fisik_perkategori += format_persen($laporan->presentasi_realisasi_fisik);

																	// Jumlah nilai baris keseluruhan
																	$total_realisasi_keseluruhan += $total_realisasi_anggaran_perbaris;
																@endphp
																<tr>
																	<form action="{{ route('dashboard.update-item-anggaran', $laporan->id) }}" method="post">
																		@csrf
																		@method('patch')
																		<!-- No -->
																		<td class="text-center">{{ $loop->iteration }}</td>

																		<!-- Nama pekerjaan -->
																		<td class="view-mode {{ $rowError ? 'd-none' : '' }}" style="min-width: 255px">
																			{{ $laporan->nama_pekerjaan }}</td>
																		<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="nama_pekerjaan"
																				value="{{ old('nama_pekerjaan', $laporan->nama_pekerjaan) }}" maxlength="100"
																				class="forms-input text">
																		</td>

																		<!-- Pagu -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->pagu) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="pagu"
																				value="{{ old('pagu', number_format($laporan->pagu ?? 0, 0, ',', '.')) }}" min="500"
																				class="forms-input rupiah text-end">
																		</td>

																		<!-- No kontrak -->
																		<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
																			{{ $laporan->no_kontrak }}</td>
																		<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="no_kontrak" value="{{ old('no_kontrak', $laporan->no_kontrak) }}"
																				class="forms-input no-kontrak">
																		</td>

																		<!-- Tgl mulai kontrak -->
																		<td class="view-mode text-center text-nowrap {{ $rowError ? 'd-none' : '' }}">
																			{{ $laporan->tgl_mulai_kontrak ? Carbon\Carbon::create($laporan->tgl_mulai_kontrak)->translatedFormat('d-m-Y') : null }}
																		</td>
																		<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
																			<input type="date" name="tgl_mulai_kontrak"
																				value="{{ old('tgl_mulai_kontrak', $laporan->tgl_mulai_kontrak) }}" class="forms-input tanggal">
																		</td>

																		<!-- Tgl berakhir kontrak -->
																		<td class="view-mode text-center text-nowrap {{ $rowError ? 'd-none' : '' }}">
																			{{ $laporan->tgl_berakhir_kontrak ? Carbon\Carbon::create($laporan->tgl_berakhir_kontrak)->translatedFormat('d-m-Y') : null }}
																		</td>
																		<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
																			<input type="date" name="tgl_berakhir_kontrak"
																				value="{{ old('tgl_berakhir_kontrak', $laporan->tgl_berakhir_kontrak) }}"
																				class="forms-input tanggal">
																		</td>

																		<!-- Nilai kontrak tender -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->nilai_kontrak_tender) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="nilai_kontrak_tender"
																				value="{{ old('nilai_kontrak_tender', number_format($laporan->nilai_kontrak_tender ?? 0, 0, ',', '.')) }}"
																				min="500"
																				class="forms-input rupiah text-end">
																		</td>

																		<!-- Realisasi tender -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->realisasi_tender) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="realisasi_tender"
																				value="{{ old('realisasi_tender', number_format($laporan->realisasi_tender ?? 0, 0, ',', '.')) }}"
																				min="500"
																				class="forms-input rupiah text-end">
																		</td>

																		<!-- Nilai kontrak penunjukkan langsung -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->nilai_kontrak_penunjukkan_langsung) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="nilai_kontrak_penunjukkan_langsung"
																				value="{{ old('nilai_kontrak_penunjukkan_langsung', number_format($laporan->nilai_kontrak_penunjukkan_langsung ?? 0, 0, ',', '.')) }}"
																				min="500" class="forms-input rupiah text-end">
																		</td>

																		<!-- Realisasi penunjukkan langsung -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->realisasi_penunjukkan_langsung) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="realisasi_penunjukkan_langsung"
																				value="{{ old('realisasi_penunjukkan_langsung', number_format($laporan->realisasi_penunjukkan_langsung ?? 0, 0, ',', '.')) }}"
																				min="500" class="forms-input rupiah text-end">
																		</td>

																		<!-- Nilai kontrak swakelola -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->nilai_kontrak_swakelola) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="nilai_kontrak_swakelola"
																				value="{{ old('nilai_kontrak_swakelola', number_format($laporan->nilai_kontrak_swakelola ?? 0, 0, ',', '.')) }}"
																				min="500"
																				class="forms-input rupiah text-end">
																		</td>

																		<!-- Realisasi swakelola -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->realisasi_swakelola) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="realisasi_swakelola"
																				value="{{ old('realisasi_swakelola', number_format($laporan->realisasi_swakelola ?? 0, 0, ',', '.')) }}"
																				min="500"
																				class="forms-input rupiah text-end">
																		</td>

																		<!-- Nilai kontrak epurchasing -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->nilai_kontrak_epurchasing) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="nilai_kontrak_epurchasing"
																				value="{{ old('nilai_kontrak_epurchasing', number_format($laporan->nilai_kontrak_epurchasing ?? 0, 0, ',', '.')) }}"
																				min="500"
																				class="forms-input rupiah text-end">
																		</td>

																		<!-- Realisasi epurchasing -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->realisasi_epurchasing) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="realisasi_epurchasing"
																				value="{{ old('realisasi_epurchasing', number_format($laporan->realisasi_epurchasing ?? 0, 0, ',', '.')) }}"
																				min="500"
																				class="forms-input rupiah text-end">
																		</td>

																		<!-- Nilai kontrak pengadaan langsung -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->nilai_kontrak_pengadaan_langsung) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="nilai_kontrak_pengadaan_langsung"
																				value="{{ old('nilai_kontrak_pengadaan_langsung', number_format($laporan->nilai_kontrak_pengadaan_langsung ?? 0, 0, ',', '.')) }}"
																				min="500" class="forms-input rupiah text-end">
																		</td>

																		<!-- Realisasi pengadaan langsung -->
																		<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
																			{{ format_ribuan($laporan->realisasi_pengadaan_langsung) }}</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="realisasi_pengadaan_langsung"
																				value="{{ old('realisasi_pengadaan_langsung', number_format($laporan->realisasi_pengadaan_langsung ?? 0, 0, ',', '.')) }}"
																				min="500" class="forms-input rupiah text-end">
																		</td>

																		<!-- Total realisasi anggaran -->
																		<td class="text-end">
																			{{ format_ribuan($total_realisasi_anggaran_perbaris) }}
																		</td>

																		<!-- Presentasi realisasi keuangan -->
																		<td class="text-center">
																			{{ format_persen($realisasi_keuangan_perbaris, true) ?? '0%' }}
																		</td>

																		<!-- Presentasi realisasi fisik -->
																		<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
																			{{ format_persen($laporan->presentasi_realisasi_fisik, true) ?? '0%' }}
																		</td>
																		<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
																			<input type="number" name="presentasi_realisasi_fisik"
																				value="{{ old('presentasi_realisasi_fisik', $laporan->presentasi_realisasi_fisik * 100) }}"
																				min="0" step="0.1" class="forms-input no text-end">
																		</td>

																		<!-- Sumber dana -->
																		<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
																			{{ $laporan->sumber_dana ?? '-' }}</td>
																		<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="sumber_dana" value="{{ old('sumber_dana', $laporan->sumber_dana) }}"
																				maxlength="50" class="forms-input dana">
																		</td>

																		<!-- Keterangan -->
																		<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
																			{{ $laporan->keterangan ?? '-' }}</td>
																		<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
																			<input type="text" name="keterangan" value="{{ old('keterangan', $laporan->keterangan) }}"
																				maxlength="191" class="forms-input no-kontrak">
																		</td>
																	</form>

																	<!-- Tombol aksi -->
																	<td class="text-nowrap" style="scale:.8">
																		<button type="button" class="btn btn-sm btn-warning btn-edit {{ $rowError ? 'd-none' : '' }}">
																			<span class="material-icons" style="font-size:18px;vertical-align:middle;">edit_square</span>
																		</button>
																		<button type="button" class="btn btn-sm btn-success btn-save {{ $rowError ? '' : 'd-none' }}">
																			<span class="material-icons" style="font-size:18px;vertical-align:middle;">check</span>
																		</button>
																		<button type="button"
																			class="btn btn-sm btn-secondary btn-cancel {{ $rowError ? '' : 'd-none' }}">
																			<span class="material-icons" style="font-size:18px;vertical-align:middle;">close</span>
																		</button>
																		<a href="{{ route('dashboard.delete-item-anggaran', $laporan->id) }}"
																			class="btn btn-sm btn-danger btn-delete" data-confirm-delete>
																			<span class="material-icons" style="font-size:18px;vertical-align:middle;">delete</span>
																		</a>
																		<button type="button" class="btn btn-sm btn-info"
																			data-bs-toggle="modal"
																			data-bs-target="#modalEditItemAnggaran"
																			data-route="{{ route('dashboard.update-kategori-item-anggaran', $laporan->id) }}"
																			data-nama="{{ $laporan->nama_pekerjaan }}"
																			data-kategori="{{ $laporan->kategori_laporan_id }}">
																			<span class="material-icons" style="font-size:18px;vertical-align:middle;">folder</span>
																		</button>
																	</td>
																</tr>

																<!-- Baris sub total -->
																@if ($loop->iteration == count($kategori->laporan))
																	<tr class="col-total">
																		<th colspan="2" class="text-center">SUBTOTAL</th>
																		<th class="text-end">{{ format_ribuan($total_pagu_perkategori) ?? 0 }}</th>
																		<th></th>
																		<th></th>
																		<th></th>
																		<th class="text-end">{{ format_ribuan($total_nilai_tender_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_realisasi_tender_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_nilai_penunjukkan_langsung_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_realisasi_penunjukkan_langsung_perkategori) ?? 0 }}
																		</th>
																		<th class="text-end">{{ format_ribuan($total_nilai_swakelola_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_realisasi_swakelola_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_nilai_epurchasing_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_realisasi_epurchasing_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_nilai_pengadaan_langsung_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_realisasi_pengadaan_langsung_perkategori) ?? 0 }}</th>
																		<th class="text-end">{{ format_ribuan($total_realisasi_anggaran_perkategori) ?? 0 }}</th>
																		<th class="text-center">
																			{{ format_persen($total_realisasi_anggaran_perkategori / max($total_pagu_perkategori, 1), true) ?? '0%' }}
																		</th>
																		<th class="text-center">
																			{{ format_persen($realisasi_fisik_perkategori / max(count($kategori->laporan), 1), true) ?? '0%' }}
																		</th>
																		<th></th>
																		<th></th>
																		<th></th>
																	</tr>
																	@php
																		$realisasi_fisik_keseluruhan += format_persen(
																		    $realisasi_fisik_perkategori / max(count($kategori->laporan), 1),
																		);
																	@endphp
																@endif
															@endforeach
														@endif
													@endforeach

													<!-- Total rupiah keseluruhan -->
													<tr class="col-total">
														<th colspan="2" class="text-center">TOTAL RUPIAH</th>
														<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('pagu')) ?? 0 }}</th>
														<th></th>
														<th></th>
														<th></th>
														<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_tender')) ?? 0 }}
														</th>
														<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_tender')) ?? 0 }}</th>
														<th class="text-end">
															{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_penunjukkan_langsung')) ?? 0 }}</th>
														<th class="text-end">
															{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_penunjukkan_langsung')) ?? 0 }}</th>
														<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_swakelola')) ?? 0 }}
														</th>
														<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_swakelola')) ?? 0 }}</th>
														<th class="text-end">
															{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_epurchasing')) ?? 0 }}
														</th>
														<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_epurchasing')) ?? 0 }}
														</th>
														<th class="text-end">
															{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_pengadaan_langsung')) ?? 0 }}</th>
														<th class="text-end">
															{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_pengadaan_langsung')) ?? 0 }}</th>
														<th class="text-end">{{ format_ribuan($total_realisasi_keseluruhan) ?? 0 }}</th>
														<th class="text-center">
															{{ format_persen($total_realisasi_keseluruhan / max($skpd_anggaran->laporan->sum('pagu'), 1), true) ?? '0%' }}
														</th>
														<th class="text-center">
															@php
																$kategori_count = $skpd_anggaran->kategori_laporan
																    ->filter(function ($kategori) {
																        return $kategori->laporan && $kategori->laporan->count() > 0;
																    })
																    ->count();
															@endphp
															{{ format_persen($realisasi_fisik_keseluruhan / max($kategori_count, 1), true) ?? '0%' }}
														</th>
														<th></th>
														<th></th>
														<th></th>
													</tr>
												@endif
											</tbody>
										</table>
									</div>
								</div>
								<!-- Struktur anggaran -->
								<div class="tab-pane fade {{ $activeTab === 'struktur-anggaran' ? 'active show' : '' }}"
									id="struktur-anggaran"
									role="tabpanel" aria-labelledby="pills-profile-tab">
									<div class="mt-4">
										<div class="row">
											<div
												class="col-md-10 relative d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
												<div class="alert alert-primary alert-style-light d-flex align-items-center" role="alert">
													<span class="material-icons me-1">swap_vert</span>
													<div>
														Silakan <strong>drag & drop</strong> kategori untuk mengubah urutan atau hierarki.
													</div>
												</div>
												<div>
													<div id="loading" class="me-1 spinner-border spinner-border-sm text-info"
														role="status">
														<span class="visually-hidden">Loading...</span>
													</div>
													<button type="button" class="btn btn-warning btn-sm btn-style-light" data-bs-toggle="modal"
														data-bs-target="#modalCreateKategori">
														<i class="material-icons">add</i> Tambah Kategori
													</button>
												</div>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-10">
												<!-- kode asli -->
												<div class="dd" id="nestable" style="width: 100%">
													<ol class="dd-list">
														<!-- Loop hanya untuk item level pertama (root) -->
														@forelse ($kategoriTree as $item)
															<!-- Panggil partial view untuk setiap item -->
															@include('components.kategori_item', ['item' => $item])
														@empty
															<p class="text-muted text-center">Belum ada data. Klik tambah untuk membuat kategori baru, atau salin
																format laporan dari periode lainnya.</p>
															<div class="text-center">
																<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
																	data-bs-target="#modalPilihStrukturAnggaran">
																	<i class="material-icons">schema</i> Pilih Struktur Anggaran
																</button>
															</div>
														@endforelse
													</ol>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Data utama -->
								<div class="tab-pane fade {{ $activeTab === 'data-utama' ? 'active show' : '' }}" id="data-utama"
									role="tabpanel" aria-labelledby="pills-profile-tab">
									<div class="mt-4">
										<form action="{{ route('dashboard.update-data-laporan', $skpd_anggaran->id) }}" method="post">
											@csrf
											@method('patch')
											<div class="row">
												<div class="col-md-8">
													<div class="row">
														<div class="col-md-12">
															<div class="mb-3">
																<label for="jenis_pengadaan" class="form-label">Jenis Pengadaan</label>
																<input type="text" class="form-control" id="jenis_pengadaan"
																	aria-describedby="jenis_pengadaanHelp"
																	placeholder="Masukkan jenis pengadaan..." name="jenis_pengadaan"
																	value="{{ old('jenis_pengadaan', $skpd_anggaran->jenis_pengadaan) }}">
															</div>
														</div>
														<div class="col-md-6">
															<div class="mb-3">
																<label for="bulan_anggaran" class="form-label">Bulan</label>
																<select name="bulan_anggaran" id="bulan_anggaran" class="form-select">
																	<option value="">-- Pilih Bulan --</option>
																	@foreach (range(1, 12) as $i)
																		<option value="{{ $i }}"
																			{{ old('bulan_anggaran', $skpd_anggaran->bulan_anggaran) == $i ? 'selected' : '' }}>
																			{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
																		</option>
																	@endforeach
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="mb-3">
																<label for="tahun_anggaran" class="form-label">Tahun Anggaran</label>
																<input type="text" class="form-control" id="tahun_anggaran" aria-describedby="tahun_anggaranHelp"
																	placeholder="Masukkan tahun anggaran..." maxlength="4" name="tahun_anggaran"
																	value="{{ old('tahun_anggaran', $skpd_anggaran->tahun_anggaran) }}">
															</div>
														</div>
													</div>
													<div class="row m-t-sm">
														<div class="col">
															<button type="submit" class="btn btn-primary">
																<i class="material-icons">save_alt</i> Simpan</button>
														</div>
													</div>
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
	</div>

</x-layouts.dashboard>
