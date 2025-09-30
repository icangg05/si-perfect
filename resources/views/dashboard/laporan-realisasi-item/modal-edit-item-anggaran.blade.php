<div class="modal fade" id="modalEditItemAnggaran" tabindex="-1" aria-labelledby="modalEditItemAnggaranTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalEditItemAnggaranTitle">Edit Item Anggaran</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="formEditItemAnggaran" action="" method="POST">
				@csrf
				@method('patch')
				<div class="modal-body">
					<!-- Nama Kegiatan Anggaran (hanya teks) -->
					<div class="mb-3">
						<label class="form-label">Nama Kegiatan</label>
						<p class="form-control-plaintext fw-bold" id="nama_kegiatan_edit_item_anggaran">-</p>
					</div>

					<!-- Pilih Kategori Anggaran -->
					<div class="mb-3">
						<label for="kategori_laporan_id" class="form-label">Kategori Anggaran</label>
						<select class="form-select" id="kategori_laporan_id" name="kategori_laporan_id" required>
							<option value="">-- Pilih Kategori --</option>
							@foreach ($skpd_anggaran->kategori_laporan as $kategori)
								<option value="{{ $kategori->id }}">
									{{-- {{ $kategori->nama }} --}}
									{!! str_repeat('—', ($kategori->level - 1) * 2) !!} {{ $kategori->nama }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
						Kembali
					</button>
					<button id="btnSimpanEditItemAnggaran" type="submit" class="btn btn-primary">
						<i class="material-icons">save_alt</i> Simpan
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
