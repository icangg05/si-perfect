@push('script')
	<script src="{{ asset('assets/js/jquery.nestable.js') }}"></script>
	<script>
		$(document).ready(function() {

			$('#bulan_anggaran').select2({
				placeholder: '-- Pilih Bulan --',
				allowClear: false,
				width: '100%',
				minimumResultsForSearch: Infinity
			});
		});
	</script>

	<script>
		$(document).ready(function() {
			var $loading = $("#loading").hide();
			// init nestable
			$('#nestable').nestable({
				group: 1
			}).on('change', function(e) {
				$loading.fadeIn(200);
				var order = $('#nestable').nestable('serialize');

				// langsung kirim ke backend tiap ada perubahan
				$.ajax({
					url: "{{ route('kategori.updateOrder') }}",
					type: "POST",
					data: {
						order: order,
						_token: "{{ csrf_token() }}"
					},
					success: function(res) {
						if (res.status === 'success') {
							// console.log("Urutan berhasil diperbarui");
						} else {
							console.warn("Gagal menyimpan urutan!");
						}
					},
					error: function(xhr) {
						console.error("Error:", xhr.responseText);
					},
					complete: function() {
						$loading.fadeOut(400);
					}
				});
			});
		});
	</script>

	<!-- Modal edit kategori -->
	<script>
		$(function() {
			var $modal = $('#modalEditKategori');
			var $form = $modal.find('#formEditKategori');
			var $textarea = $modal.find('#nama_kategori_edit');

			// Saat modal ditampilkan
			$modal.on('show.bs.modal', function(event) {
				var $button = $(event.relatedTarget); // tombol yg memicu modal
				var actionRoute = $button.data('route') || '#';
				var nama = $button.data('name') || '';

				// Set action form dan isi textarea
				$form.attr('action', actionRoute);
				$textarea.val(nama);
			});

			// Saat modal ditutup (reset biar bersih)
			$modal.on('hidden.bs.modal', function() {
				$form.attr('action', '#');
				$textarea.val('');
			});
		});
	</script>

	<!-- Modal delete kategori -->
	<script>
		$(function() {
			var $modal = $('#modalDeleteKategori');
			var $form = $modal.find('#modalDeleteForm');
			var $itemName = $modal.find('#modalDeleteItemName');
			var $inputConfirm = $modal.find('#confirmDeleteKategori');
			var $btnConfirm = $modal.find('#btnConfirmDeleteKategori');

			// Aktif/nonaktif tombol sesuai input
			$inputConfirm.on('input', function() {
				$btnConfirm.prop('disabled', $(this).val().trim() !== 'HAPUS');
			});

			// Saat modal ditampilkan
			$modal.on('show.bs.modal', function(event) {
				var $button = $(event.relatedTarget); // tombol yg memicu modal
				var actionRoute = $button.data('route') || '#';
				var name = $button.data('name') || '';

				$form.attr('action', actionRoute);
				$itemName.text(name);

				// reset input
				$inputConfirm.val('');
				$btnConfirm.prop('disabled', true);
			});

			// Saat modal ditutup
			$modal.on('hidden.bs.modal', function() {
				$inputConfirm.val('');
				$btnConfirm.prop('disabled', true);
			});
		});
	</script>


	<!-- Modal edit item anggaran -->
	<script>
		$(function() {
			var $modal = $('#modalEditItemAnggaran');
			var $form = $modal.find('#formEditItemAnggaran');
			var $itemName = $modal.find('#nama_kegiatan_edit_item_anggaran');
			var $select = $modal.find('#kategori_laporan_id');

			// Saat modal ditampilkan
			$modal.on('show.bs.modal', function(event) {
				var $button = $(event.relatedTarget);
				var actionRoute = $button.data('route') || '#';
				var nama = $button.data('nama') || '';
				var kategoriId = $button.data('kategori') || '';

				// Set action form
				$form.attr('action', actionRoute);

				// Set nama kegiatan
				$itemName.text(nama);

				// Set kategori terpilih
				$select.val(kategoriId).trigger('change');
			});
		});
	</script>
@endpush
