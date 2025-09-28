<div class="modal fade" id="modalDeleteLaporan" tabindex="-1" aria-labelledby="modalDeleteTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title d-flex align-items-center gap-1" id="modalDeleteTitle">
					<i class="material-icons">warning</i> <span>Konfirmasi Hapus</span>
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form action="{{ route('dashboard.laporan-realisasi.destroy', $skpd_anggaran->id) }}" method="POST">
				@csrf
				@method('delete')
				<div class="modal-body">

					<div class="alert alert-warning" role="alert">
						<strong>Peringatan!</strong>
						Laporan realisasi akan <u>terhapus permanen</u> dan tidak dapat dikembalikan.
						Penghapusan juga mencakup:
						<ul class="mb-0">
							<li>Seluruh item anggaran yang tercatat di dalamnya</li>
							<li>Data pendukung yang berhubungan dengan laporan realisasi</li>
						</ul>
					</div>

					<div class="mb-3">
						<label for="confirmDelete" class="form-label">
							Untuk melanjutkan, ketik <code>HAPUS</code> pada kotak di bawah:
						</label>
						<input type="text" class="form-control" id="confirmDelete"
							placeholder="Ketik HAPUS untuk konfirmasi" required autocomplete="off">
						<small class="text-muted">Tombol hapus baru aktif jika teks sesuai.</small>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">
						Batal
					</button>
					<button type="submit" id="btnConfirmDelete" class="btn btn-danger" disabled>
						<i class="material-icons">delete</i> Hapus
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
