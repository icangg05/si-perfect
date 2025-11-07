<div class="modal fade" id="modalPilihStrukturAnggaran" tabindex="-1" aria-labelledby="modalPilihStrukturAnggaranTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalPilihStrukturAnggaranTitle">Pilih Struktur Anggaran</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form action="{{ route('dashboard.salin-struktur-anggaran') }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="nama_kategori" class="form-label">Jenis Pengadaan | Bulan | Tahun Anggaran</label>
						<select id="selectStruktur" class="form-select" name="skpd_anggaran_id_template" required>
							<option value="">-- Pilih struktur anggaran --</option>
							@foreach ($skpd_anggaran_list as $item)
								<option value="{{ $item->id }}">
									{{ $item->jenis_pengadaan }} |
									{{ \Carbon\Carbon::create()->month($item->bulan_anggaran)->translatedFormat('F') }} |
									{{ $item->tahun_anggaran }}
								</option>
							@endforeach
						</select>
						<input type="hidden" name="skpd_anggaran_id" value="{{ $skpd_anggaran->id }}">
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
						Kembali
					</button>
					<button type="submit" class="btn btn-primary">
						<i class="material-icons">save_alt</i> Terapkan
					</button>
				</div>
			</form>
		</div>
	</div>
	@push('script')
		<script>
			$(document).ready(function() {

				$('#selectStruktur').select2({
					placeholder: '-- Pilih struktur anggaran --',
					allowClear: true,
					dropdownParent: $('#modalPilihStrukturAnggaran'),
					width: '100%',
				});
			});
		</script>
	@endpush
</div>
