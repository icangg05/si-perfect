<li class="dd-item" data-id="{{ $item->id }}">
	<div class="dd-handle">{{ $item->nama }}</div>

	{{-- Cek apakah item ini memiliki anak (children) --}}
	@if (isset($item->children) && count($item->children) > 0)
		<ol class="dd-list">
			{{-- Jika punya anak, loop lagi dan panggil partial view ini kembali (rekursif) --}}
			@foreach ($item->children as $child)
				@include('components.kategori_item', ['item' => $child])
			@endforeach
		</ol>
	@endif
</li>
