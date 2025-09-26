@php
	$no_kategori = 1;
	$presentasi_realisasi_keuangan_keseluruhan = 0;
	$presentasi_realisasi_fisik_keseluruhan = 0;
	$total_realisasi_keseluruhan = 0;
@endphp

@foreach ($grouped as $kategori => $subKategoris)
	<tr>
		<th></th>
		<th></th>
		<th class="text-nowrap">
			{{ $no_kategori . '. ' }}&nbsp;&nbsp;&nbsp;{{ $kategori }}
		</th>
		@for ($i = 0; $i < 20; $i++)
			<th></th>
		@endfor
	</tr>

	@php
		$no_sub_kategori = 1;
		$total_realisasi_anggaran_perkategori = 0;
	@endphp

	@foreach ($subKategoris as $subKategori => $items)
		<tr>
			<th></th>
			<th></th>
			<th class="text-nowrap">{{ $no_kategori . '.' . $no_sub_kategori . '. ' . $subKategori }}</th>
			@for ($i = 0; $i < 20; $i++)
				<th></th>
			@endfor
		</tr>

		@php
			// hitung total untuk sub kategori
			$total_pagu = $items->sum('pagu');
			$total_nilai_kontrak_tender = $items->sum('nilai_kontrak_tender');
			$total_realisasi_tender = $items->sum('realisasi_tender');
			$total_nilai_kontrak_penunjukkan_langsung = $items->sum('nilai_kontrak_penunjukkan_langsung');
			$total_realisasi_penunjukkan_langsung = $items->sum('realisasi_penunjukkan_langsung');
			$total_nilai_kontrak_swakelola = $items->sum('nilai_kontrak_swakelola');
			$total_realisasi_swakelola = $items->sum('realisasi_swakelola');
			$total_nilai_kontrak_epurchasing = $items->sum('nilai_kontrak_epurchasing');
			$total_realisasi_epurchasing = $items->sum('realisasi_epurchasing');
			$total_nilai_kontrak_pengadaan_langsung = $items->sum('nilai_kontrak_pengadaan_langsung');
			$total_realisasi_pengadaan_langsung = $items->sum('realisasi_pengadaan_langsung');

			// tambahkan ke presentasi realisasi fisik keseluruhan dan total keseluruhan
			$presentasi_realisasi_fisik_keseluruhan += $items->sum('presentasi_realisasi_fisik') / count($items);
		@endphp

		@foreach ($items as $index => $item)
			@php
				$total_realisasi_anggaran =
				    $item->realisasi_tender +
				    $item->realisasi_penunjukkan_langsung +
				    $item->realisasi_swakelola +
				    $item->realisasi_epurchasing +
				    $item->realisasi_pengadaan_langsung;

				// tambahkan ke total per kategori
				$total_realisasi_anggaran_perkategori += $total_realisasi_anggaran;
				$no_asc = $index + 1;
			@endphp

			<tr data-id="{{ $item->id }}">
				@php
					$rowError = session('row_id') == $item->id;
				@endphp
				<form action="{{ route('dashboard.update-item-anggaran', $item->id) }}" method="post">
					@csrf
					<!-- Kolom urut dpa -->
					<td class="text-center">{{ $no_asc }}</td>

					<!-- Kolom no -->
					<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
						{{ $item->no }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="no" value="{{ old('no', $item->no) }}" min="1"
							class="forms-input no text-end">
					</td>

					<!-- Kolom nama pekerjaan -->
					<td class="view-mode {{ $rowError ? 'd-none' : '' }}">
						{{ $item->nama_pekerjaan }}</td>
					<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
						<input type="text" name="nama_pekerjaan"
							value="{{ old('nama_pekerjaan', $item->nama_pekerjaan) }}" maxlength="100"
							class="forms-input text">
					</td>

					<!-- Kolom pagu -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->pagu) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="pagu" value="{{ old('pagu', $item->pagu) }}" min="500"
							class="forms-input rupiah text-end">
					</td>

					<!-- Kolom no kontrak -->
					<td class="view-mode {{ $rowError ? 'd-none' : '' }}">
						{{ $item->no_kontrak }}</td>
					<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
						<input type="text" name="no_kontrak" value="{{ old('no_kontrak', $item->no_kontrak) }}"
							class="forms-input no-kontrak">
					</td>

					<!-- Kolom tgl mulai kontrak -->
					<td class="view-mode text-nowrap {{ $rowError ? 'd-none' : '' }}">
						{{ $item->tgl_mulai_kontrak ? Carbon\Carbon::create($item->tgl_mulai_kontrak)->translatedFormat('d-m-Y') : null }}
					</td>
					<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
						<input type="date" name="tgl_mulai_kontrak"
							value="{{ old('tgl_mulai_kontrak', $item->tgl_mulai_kontrak) }}" class="forms-input tanggal">
					</td>

					<!-- Kolom tgl berakhir kontrak -->
					<td class="view-mode text-nowrap {{ $rowError ? 'd-none' : '' }}">
						{{ $item->tgl_berakhir_kontrak ? Carbon\Carbon::create($item->tgl_berakhir_kontrak)->translatedFormat('d-m-Y') : null }}
					</td>
					<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
						<input type="date" name="tgl_berakhir_kontrak"
							value="{{ old('tgl_berakhir_kontrak', $item->tgl_berakhir_kontrak) }}"
							class="forms-input tanggal">
					</td>

					<!-- Kolom nilai kontrak tender -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->nilai_kontrak_tender) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="nilai_kontrak_tender"
							value="{{ old('nilai_kontrak_tender', $item->nilai_kontrak_tender) }}" min="500"
							class="forms-input rupiah text-end">
					</td>

					<!-- Kolom realisasi tender -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->realisasi_tender) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="realisasi_tender"
							value="{{ old('realisasi_tender', $item->realisasi_tender) }}" min="500"
							class="forms-input rupiah text-end">
					</td>

					<!-- Kolom nilai kontrak penunjukkan langsung -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->nilai_kontrak_penunjukkan_langsung) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="nilai_kontrak_penunjukkan_langsung"
							value="{{ old('nilai_kontrak_penunjukkan_langsung', $item->nilai_kontrak_penunjukkan_langsung) }}"
							min="500" class="forms-input rupiah text-end">
					</td>

					<!-- Kolom realisasi penunjukkan langsung -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->realisasi_penunjukkan_langsung) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="realisasi_penunjukkan_langsung"
							value="{{ old('realisasi_penunjukkan_langsung', $item->realisasi_penunjukkan_langsung) }}"
							min="500" class="forms-input rupiah text-end">
					</td>

					<!-- Kolom nilai kontrak swakelola -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->nilai_kontrak_swakelola) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="nilai_kontrak_swakelola"
							value="{{ old('nilai_kontrak_swakelola', $item->nilai_kontrak_swakelola) }}" min="500"
							class="forms-input rupiah text-end">
					</td>

					<!-- Kolom realisasi swakelola -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->realisasi_swakelola) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="realisasi_swakelola"
							value="{{ old('realisasi_swakelola', $item->realisasi_swakelola) }}" min="500"
							class="forms-input rupiah text-end">
					</td>

					<!-- Kolom nilai kontrak epurchasing -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->nilai_kontrak_epurchasing) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="nilai_kontrak_epurchasing"
							value="{{ old('nilai_kontrak_epurchasing', $item->nilai_kontrak_epurchasing) }}" min="500"
							class="forms-input rupiah text-end">
					</td>

					<!-- Kolom realisasi epurchasing -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->realisasi_epurchasing) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="realisasi_epurchasing"
							value="{{ old('realisasi_epurchasing', $item->realisasi_epurchasing) }}" min="500"
							class="forms-input rupiah text-end">
					</td>

					<!-- Kolom nilai kontrak pengadaan langsung -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->nilai_kontrak_pengadaan_langsung) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="nilai_kontrak_pengadaan_langsung"
							value="{{ old('nilai_kontrak_pengadaan_langsung', $item->nilai_kontrak_pengadaan_langsung) }}"
							min="500" class="forms-input rupiah text-end">
					</td>

					<!-- Kolom realiasi pengadaan langsung -->
					<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
						{{ format_ribuan($item->realisasi_pengadaan_langsung) }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="realisasi_pengadaan_langsung"
							value="{{ old('realisasi_pengadaan_langsung', $item->realisasi_pengadaan_langsung) }}"
							min="500" class="forms-input rupiah text-end">
					</td>

					<!-- Kolom total realisasi keuangan -->
					<td class="text-end">{{ format_ribuan($total_realisasi_anggaran) }}</td>
					<td class="text-center">
						{{ format_persen($total_realisasi_anggaran / max($item->pagu, 1), true) ?? '0%' }}
					</td>

					<!-- Kolom presentasi realisasi fisik -->
					<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
						{{ format_persen($item->presentasi_realisasi_fisik, true) ?? '0%' }}</td>
					<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
						<input type="number" name="presentasi_realisasi_fisik"
							value="{{ old('presentasi_realisasi_fisik', $item->presentasi_realisasi_fisik * 100) }}"
							min="0" step="0.1" class="forms-input no text-end">
					</td>

					<!-- Kolom sumber dana -->
					<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
						{{ $item->sumber_dana ?? '-' }}</td>
					<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
						<input type="text" name="sumber_dana" value="{{ old('sumber_dana', $item->sumber_dana) }}"
							maxlength="50" class="forms-input dana">
					</td>

					<!-- Kolom keterangan -->
					<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
						{{ $item->keterangan ?? '-' }}</td>
					<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
						<input type="text" name="keterangan" value="{{ old('keterangan', $item->keterangan) }}"
							maxlength="191" class="forms-input no-kontrak">
					</td>
				</form>

				<!-- Tombol aksi -->
				<td class="text-nowrap" style="scale:.8">
					<button type="button" class="btn btn-sm btn-warning btn-edit {{ $rowError ? 'd-none' : '' }}">
						<span class="material-icons" style="font-size:18px;vertical-align:middle;">edit_square</span>
					</button>
					<button type="button" class="btn btn-sm btn-success btn-save {{ $rowError ? '' : 'd-none' }}">
						<span class="material-icons" style="font-size:18px;vertical-align:middle;">check</span>
					</button>
					<button type="button" class="btn btn-sm btn-secondary btn-cancel {{ $rowError ? '' : 'd-none' }}">
						<span class="material-icons" style="font-size:18px;vertical-align:middle;">close</span>
					</button>
					<a href="{{ route('dashboard.delete-item-anggaran', $item->id) }}"
						class="btn btn-sm btn-danger btn-delete" data-confirm-delete>
						<span class="material-icons" style="font-size:18px;vertical-align:middle;">delete</span>
					</a>
				</td>
			</tr>
		@endforeach

		@php
			// tambahkan ke presentasi realisasi fisik keseluruhan dan total realisasi keluruhan
			$presentasi_realisasi_keuangan_keseluruhan += $total_realisasi_anggaran_perkategori / $total_pagu;
			$total_realisasi_keseluruhan += $total_realisasi_anggaran_perkategori;
		@endphp

		{{-- Jumlah per sub kategori --}}
		<tr class="col-total">
			<th></th>
			<th colspan="2" class="text-center">JUMLAH</th>
			<th class="text-end">{{ format_ribuan($total_pagu) ?? 0 }}</th>
			<th></th>
			<th></th>
			<th></th>
			<th class="text-end">{{ format_ribuan($total_nilai_kontrak_tender) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_realisasi_tender) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_nilai_kontrak_penunjukkan_langsung) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_realisasi_penunjukkan_langsung) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_nilai_kontrak_swakelola) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_realisasi_swakelola) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_nilai_kontrak_epurchasing) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_realisasi_epurchasing) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_nilai_kontrak_pengadaan_langsung) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_realisasi_pengadaan_langsung) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_realisasi_anggaran_perkategori) ?? 0 }}</th>
			<th class="text-center">
				{{ format_persen($total_realisasi_anggaran_perkategori / max($total_pagu, 1), true) ?? '0%' }}</th>
			<th class="text-center">
				{{ format_persen($items->sum('presentasi_realisasi_fisik') / count($items), true) ?? '0%' }}</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>

		@php
			$no_sub_kategori++;
		@endphp
	@endforeach

	@php
		$no_kategori++;
	@endphp
@endforeach
