<li class="dd-item" data-id="{{ $item->id }}">
	<div class="dd-handle" style="cursor: default">
		<span>{{ $item->nama }}</span>
	</div>

	<div class="d-inline-flex gap-1 align-items-center" style="position: absolute; right: 2px; top: 2px">
		<!-- tombol edit (contoh) -->
		<button type="button" type="button" style="border: none" class="border"
			data-bs-toggle="modal"
			data-bs-target="#modalEditKategori"
			data-route="{{ route('dashboard.update-kategori', $item->id) }}"
			data-name="{{ $item->nama }}">
			<i class="material-icons text-warning" style="font-size: 17px;">edit</i>
		</button>

		<!-- tombol delete: buka single modal, kirim data-route dan data-name -->
		<button type="submit" style="border: none;"
			class="border"
			data-bs-toggle="modal"
			data-bs-target="#modalDeleteKategori"
			data-route="{{ route('dashboard.destroy-kategori', $item->id) }}"
			data-name="{{ $item->nama }}">
			<i class="material-icons text-danger" style="font-size: 17px">delete</i>
		</button>
	</div>

	@if (isset($item->children) && count($item->children) > 0)
		<ol class="dd-list">
			@foreach ($item->children as $child)
				@include('components.kategori_item', ['item' => $child])
			@endforeach
		</ol>
	@endif
</li>
