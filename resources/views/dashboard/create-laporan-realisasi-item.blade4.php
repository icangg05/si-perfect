<x-layouts.dashboard>
	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-start">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">summarize</i> Laporan Realisasi</h1>
					<span>
						Pada halaman ini Anda dapat menambahkan beberapa item anggaran baru untuk SKPD periode
						<strong>{{ $skpd_anggaran->tahun_anggaran }}</strong>,
						dengan jenis pengadaan <strong>{{ $skpd_anggaran->jenis_pengadaan }}</strong>
						pada bulan <strong>
							{{ \Carbon\Carbon::create()->month($skpd_anggaran->bulan_anggaran)->translatedFormat('F') }}</strong>.
					</span>
				</div>
				<div class="page-description-actions text-nowrap">
					<a href="{{ url()->current() }}" class="btn btn-info btn-style-light">
						<i class="material-icons-outlined">refresh</i> Refresh
					</a>
					<a href="{{ route('dashboard.laporan-realisasi-item', $skpd_anggaran->id) }}"
						class="btn btn-warning btn-style-light">
						<i class="material-icons">keyboard_backspace</i> Kembali
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header pb-4 d-flex justify-content-between align-items-center">
					<h5 class="card-title">Form Tambah Item Anggaran</h5>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<form action="{{ route('dashboard.store-item-anggaran', $skpd_anggaran->id) }}" method="POST">
				@csrf
				<div class="accordion" id="accordionForm">
					@foreach ($kategori_laporan as $i => $kategori)
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading_{{ $i }}">
								<button class="accordion-button d-flex align-items-center gap-2 {{ $i != 0 ? 'collapsed' : '' }}"
									type="button"
									data-bs-toggle="collapse"
									data-bs-target="#collapse_{{ $i }}"
									aria-expanded="{{ $i == 0 ? 'true' : 'false' }}"
									aria-controls="collapse_{{ $i }}">
									<span># {{ $i + 1 }}.</span><span>{{ $kategori->nama }}</span>
								</button>
							</h2>
							<div id="collapse_{{ $i }}" class="accordion-collapse collapse {{ $i == 0 ? 'show' : '' }}"
								aria-labelledby="heading_{{ $i }}" data-bs-parent="#accordionForm">
								<div class="accordion-body py-4">

									{{-- Container tiap row item --}}
									<div id="formRows_{{ $i }}">
										<div class="form-row border rounded p-3 mb-3 bg-light">
											<h6 class="mb-3">📂 Sub Kategori</h6>
											<div class="row">
												@foreach ($kategori->sub_kategori_laporan as $sub_kategori)
													@php
														$radioId = "item_{$kategori->id}_{$i}_0_{$sub_kategori->id}";
													@endphp
													<div class="col-md-6">
														<div class="form-check bg-white py-2 border rounded" style="padding-left: 35px;">
															<input class="form-check-input"
																type="radio"
																name="items[{{ $i }}][0][sub_kategori_laporan_id]"
																id="{{ $radioId }}"
																value="{{ $sub_kategori->id }}"
																@if ($loop->first) checked @endif>
															<label class="form-check-label" for="{{ $radioId }}">
																{{ $sub_kategori->nama }}
															</label>
														</div>
													</div>
												@endforeach
											</div>

											<hr>

											{{-- Informasi Dasar --}}
											<h6 class="mb-3">📌 Informasi Dasar</h6>
											<div class="row g-3">
												<div class="col-md-2">
													<label class="form-label">No.</label>
													<input type="number"
														class="form-control form-control-sm"
														name="items[{{ $i }}][0][no]"
														placeholder="Contoh : 1"
														required>
												</div>
												<div class="col-md-6">
													<label class="form-label">Nama Pekerjaan</label>
													<input type="text" class="form-control form-control-sm"
														name="items[{{ $i }}][0][nama_pekerjaan]" placeholder="Masukkan nama pekerjaan...">
												</div>
												<div class="col-md-4">
													<label class="form-label">Pagu Anggaran</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][pagu]" placeholder="0">
												</div>
											</div>

											<hr>

											{{-- Informasi Kontrak --}}
											<h6 class="mb-3">📑 Informasi Kontrak</h6>
											<div class="row g-3">
												<div class="col-md-4">
													<label class="form-label">No. Kontrak</label>
													<input type="text" class="form-control form-control-sm"
														name="items[{{ $i }}][0][no_kontrak]" placeholder="Masukkan nomor kontrak...">
												</div>
												<div class="col-md-4">
													<label class="form-label">Tanggal Mulai</label>
													<input type="date" class="form-control form-control-sm"
														name="items[{{ $i }}][0][tgl_mulai_kontrak]">
												</div>
												<div class="col-md-4">
													<label class="form-label">Tanggal Berakhir</label>
													<input type="date" class="form-control form-control-sm"
														name="items[{{ $i }}][0][tgl_berakhir_kontrak]">
												</div>
											</div>

											<hr>

											{{-- Nilai & Realisasi --}}
											<h6 class="mb-3">💰 Nilai & Realisasi</h6>
											<div class="row g-3">
												<div class="col-md-6">
													<label class="form-label">Nilai Kontrak Tender</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][nilai_kontrak_tender]" placeholder="0">
												</div>
												<div class="col-md-6">
													<label class="form-label">Realisasi Tender</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][realisasi_tender]" placeholder="0">
												</div>

												<div class="col-md-6">
													<label class="form-label">Nilai Kontrak Penunjukkan Langsung</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][nilai_kontrak_penunjukkan_langsung]" placeholder="0">
												</div>
												<div class="col-md-6">
													<label class="form-label">Realisasi Penunjukkan Langsung</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][realisasi_penunjukkan_langsung]" placeholder="0">
												</div>

												<div class="col-md-6">
													<label class="form-label">Nilai Kontrak Swakelola</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][nilai_kontrak_swakelola]" placeholder="0">
												</div>
												<div class="col-md-6">
													<label class="form-label">Realisasi Swakelola</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][realisasi_swakelola]" placeholder="0">
												</div>

												<div class="col-md-6">
													<label class="form-label">Nilai Kontrak e-Purchasing</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][nilai_kontrak_epurchasing]" placeholder="0">
												</div>
												<div class="col-md-6">
													<label class="form-label">Realisasi e-Purchasing</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][realisasi_epurchasing]" placeholder="0">
												</div>

												<div class="col-md-6">
													<label class="form-label">Nilai Kontrak Pengadaan Langsung</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][nilai_kontrak_pengadaan_langsung]" placeholder="0">
												</div>
												<div class="col-md-6">
													<label class="form-label">Realisasi Pengadaan Langsung</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][realisasi_pengadaan_langsung]" placeholder="0">
												</div>
											</div>

											<hr>

											{{-- Informasi Lainnya --}}
											<h6 class="mb-3">📝 Informasi Lainnya</h6>
											<div class="row g-3">
												<div class="col-md-4">
													<label class="form-label">Presentasi Realisasi Fisik (%)</label>
													<input type="number" class="form-control form-control-sm"
														name="items[{{ $i }}][0][presentasi_realisasi_fisik]" step="0.1"
														max="100"
														placeholder="0-100">
												</div>
												<div class="col-md-4">
													<label class="form-label">Sumber Dana</label>
													<input type="text" class="form-control form-control-sm"
														name="items[{{ $i }}][0][sumber_dana]" placeholder="APBD, DAK, dll">
												</div>
												<div class="col-md-4">
													<label class="form-label">Keterangan</label>
													<input type="text" class="form-control form-control-sm"
														name="items[{{ $i }}][0][keterangan]" placeholder="Opsional">
												</div>
											</div>

											<div class="mt-3 text-end">
												<button type="button" class="btn btn-danger btn-sm removeRow">
													<i class="material-icons">delete</i> Hapus Item
												</button>
											</div>
										</div>
									</div>

									<div class="text-end mt-2">
										<button type="button" class="btn btn-primary addRow" data-target="formRows_{{ $i }}">
											<i class="material-icons">add</i> Tambah Item
										</button>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<div class="d-flex justify-content-end mt-4">
					<button type="submit" class="btn btn-primary">
						<i class="material-icons">save</i> Simpan Semua
					</button>
				</div>
			</form>
		</div>
	</div>
</x-layouts.dashboard>
