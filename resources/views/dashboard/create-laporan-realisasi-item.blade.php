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
		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-4 d-flex justify-content-between align-items-center">
					<h5 class="card-title d-flex align-items-center gap-2 mb-2 mb-md-0">
						Form Tambah Item Anggaran
						<span style="color: rgb(155, 155, 155);">—</span>
						<span style="font-weight: 400; font-size: .9rem">
							{{ $skpd_anggaran->skpd->nama }}
						</span>
					</h5>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<form action="{{ route('dashboard.store-item-anggaran', $skpd_anggaran->id) }}" method="POST">
				@csrf
				<div class="accordion" id="accordionForm">
					<div class="accordion-item">
						<h2 class="accordion-header" id="heading">
							<button class="accordion-button d-flex align-items-center gap-2"
								type="button"
								data-bs-toggle="collapse"
								data-bs-target="#collapse"
								aria-expanded="true"
								aria-controls="collapse">
								{{ $skpd_anggaran->jenis_pengadaan }}
							</button>
						</h2>
						<div id="collapse" class="accordion-collapse collapse show"
							aria-labelledby="heading" data-bs-parent="#accordionForm">
							<div class="accordion-body py-4">

								{{-- Container tiap row item --}}
								<div id="formRows">
									<div class="form-row border rounded p-3 mb-3 bg-light">
										<h6 class="mb-3">📂 Kategori</h6>
										<select name="kategori_laporan_id[]"
											class="form-select kategoriSelect" required>
											<option value="">-- Pilih Kategori --</option>
											@foreach ($kategori_laporan as $kategori)
												<option value="{{ $kategori->id }}">
													{{ $kategori->nama }}
												</option>
											@endforeach
										</select>

										<hr>

										{{-- Informasi Dasar --}}
										<h6 class="mb-3">📌 Informasi Dasar</h6>
										<div class="row g-3">
											<div class="col-md-8">
												<label class="form-label">Nama Pekerjaan</label>
												<input type="text" class="form-control form-control-sm"
													name="nama_pekerjaan[]" placeholder="Masukkan nama pekerjaan..." required>
											</div>
											<div class="col-md-4">
												<label class="form-label">Pagu Anggaran</label>
												<input type="number" class="form-control form-control-sm"
													name="pagu[]" placeholder="0" required>
											</div>
										</div>

										<hr>

										{{-- Informasi Kontrak --}}
										<h6 class="mb-3">📑 Informasi Kontrak</h6>
										<div class="row g-3">
											<div class="col-md-4">
												<label class="form-label">No. Kontrak</label>
												<input type="text" class="form-control form-control-sm"
													name="no_kontrak[]" placeholder="Masukkan nomor kontrak...">
											</div>
											<div class="col-md-4">
												<label class="form-label">Tanggal Mulai</label>
												<input type="text" onfocus="(this.type='date')" placeholder="Pilih tanggal mulai"
													class="form-control form-control-sm"
													name="tgl_mulai_kontrak[]">
											</div>
											<div class="col-md-4">
												<label class="form-label">Tanggal Berakhir</label>
												<input type="text" onfocus="(this.type='date')" placeholder="Pilih tanggal berakhir"
													class="form-control form-control-sm"
													name="tgl_berakhir_kontrak[]">
											</div>
										</div>

										<hr>

										{{-- Nilai & Realisasi --}}
										<h6 class="mb-3">💰 Nilai & Realisasi</h6>
										<div class="row g-3">
											<div class="col-md-6">
												<label class="form-label">Nilai Kontrak Tender</label>
												<input type="number" class="form-control form-control-sm"
													name="nilai_kontrak_tender[]" placeholder="0">
											</div>
											<div class="col-md-6">
												<label class="form-label">Realisasi Tender</label>
												<input type="number" class="form-control form-control-sm"
													name="realisasi_tender[]" placeholder="0">
											</div>

											<div class="col-md-6">
												<label class="form-label">Nilai Kontrak Penunjukkan Langsung</label>
												<input type="number" class="form-control form-control-sm"
													name="nilai_kontrak_penunjukkan_langsung[]" placeholder="0">
											</div>
											<div class="col-md-6">
												<label class="form-label">Realisasi Penunjukkan Langsung</label>
												<input type="number" class="form-control form-control-sm"
													name="realisasi_penunjukkan_langsung[]" placeholder="0">
											</div>

											<div class="col-md-6">
												<label class="form-label">Nilai Kontrak Swakelola</label>
												<input type="number" class="form-control form-control-sm"
													name="nilai_kontrak_swakelola[]" placeholder="0">
											</div>
											<div class="col-md-6">
												<label class="form-label">Realisasi Swakelola</label>
												<input type="number" class="form-control form-control-sm"
													name="realisasi_swakelola[]" placeholder="0">
											</div>

											<div class="col-md-6">
												<label class="form-label">Nilai Kontrak e-Purchasing</label>
												<input type="number" class="form-control form-control-sm"
													name="nilai_kontrak_epurchasing[]" placeholder="0">
											</div>
											<div class="col-md-6">
												<label class="form-label">Realisasi e-Purchasing</label>
												<input type="number" class="form-control form-control-sm"
													name="realisasi_epurchasing[]" placeholder="0">
											</div>

											<div class="col-md-6">
												<label class="form-label">Nilai Kontrak Pengadaan Langsung</label>
												<input type="number" class="form-control form-control-sm"
													name="nilai_kontrak_pengadaan_langsung[]" placeholder="0">
											</div>
											<div class="col-md-6">
												<label class="form-label">Realisasi Pengadaan Langsung</label>
												<input type="number" class="form-control form-control-sm"
													name="realisasi_pengadaan_langsung[]" placeholder="0">
											</div>
										</div>

										<hr>

										{{-- Informasi Lainnya --}}
										<h6 class="mb-3">📝 Informasi Lainnya</h6>
										<div class="row g-3">
											<div class="col-md-4">
												<label class="form-label">Presentasi Realisasi Fisik (%)</label>
												<input type="number" class="form-control form-control-sm"
													name="presentasi_realisasi_fisik[]" step="0.1"
													max="100"
													placeholder="0-100" required>
											</div>
											<div class="col-md-4">
												<label class="form-label">Sumber Dana</label>
												<input type="text" class="form-control form-control-sm"
													name="sumber_dana[]" placeholder="APBD, DAK, dll">
											</div>
											<div class="col-md-4">
												<label class="form-label">Keterangan</label>
												<input type="text" class="form-control form-control-sm"
													name="keterangan[]" placeholder="Opsional">
											</div>
										</div>

										<div class="mt-3 text-end">
											<button type="button" class="btn btn-danger btn-sm removeRow">
												<i class="material-icons">delete</i> Hapus Item
											</button>
										</div>
									</div>
								</div>

								<hr>

								<div class="text-end mt-2">
									<button type="button" class="btn btn-info btn-style-light addRow" style="font-weight: 500">
										<i class="material-icons">add</i> Tambah Item
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-end mt-4">
					<button type="submit" class="btn btn-primary">
						<i class="material-icons">save</i> Simpan Semua
					</button>
				</div>
			</form>
		</div>
	</div>

	@push('script')
		<script>
			$(document).ready(function() {
				// $('.kategoriSelect').select2({
				// 	placeholder: '-- Pilih Kategori --',
				// 	allowClear: true,
				// });
				// $('#filterForm select').on('change', function() {
				// 	$('#filterForm').submit();
				// });
			});
		</script>
	@endpush
</x-layouts.dashboard>
