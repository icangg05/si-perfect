<div class="modal fade" id="modalDeleteKategori" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title d-flex align-items-center gap-1">
					<i class="material-icons">warning</i>
					<span id="modalDeleteTitle">Konfirmasi Hapus</span>
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="modalDeleteForm" method="POST" action="#">
				@csrf
				@method('DELETE')

				<div class="modal-body">
					<div class="alert alert-warning" role="alert">
						<strong>Peringatan!</strong>
						Item ini akan <u>terhapus permanen</u> beserta seluruh anaknya.
						Penghapusan juga mencakup:
						<ul class="mb-0">
							<li>Item: <span id="modalDeleteItemName">Nama Item</span></li>
							<li>Seluruh anak (sub-kategori) dari item ini</li>
							<li>Seluruh item anggaran yang terkait dengan kategori ini</li>
						</ul>
					</div>

					<div class="mb-3">
						<label for="confirmDelete" class="form-label">
							Untuk melanjutkan, ketik <code>HAPUS</code> pada kotak di bawah:
						</label>
						<input type="text" class="form-control" id="confirmDeleteKategori"
							placeholder="Ketik HAPUS untuk konfirmasi"
							autocomplete="off">
						<small class="text-muted">Tombol hapus baru aktif jika teks sesuai.</small>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
					<button type="submit" id="btnConfirmDeleteKategori" class="btn btn-danger" disabled>
						<i class="material-icons">delete</i> Hapus
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
