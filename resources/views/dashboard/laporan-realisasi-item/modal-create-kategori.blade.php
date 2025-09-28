<div class="modal fade" id="modalCreateKategori" tabindex="-1" aria-labelledby="modalCreateKategoriTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalCreateKategoriTitle">Tambah Kategori</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form action="{{ route('dashboard.store-kategori', $skpd_anggaran->id) }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="nama_kategori" class="form-label">Nama Kategori</label>
						<textarea type="text" class="form-control" id="nama_kategori" name="nama_kategori"
						 placeholder="Masukkan nama kategori..." required>{{ old('nama_kategori') }}</textarea>
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
