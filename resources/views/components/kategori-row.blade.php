@props(['skpd_anggaran', 'kategori', 'allKategori', 'nomor'])

<!-- 1. Render baris untuk KATEGORI itu sendiri (misal: "1. Paket Penyedia") -->
<tr>
	<th></th>
	{{-- Tambahkan padding-left dinamis berdasarkan level kategori untuk membuat inden --}}
	<th class="fw-bold" style="position: relative">
		<span class="font-arimo" style="position: absolute; left: 1;">{{ $nomor }}</span>
		<span class="font-arimo" style="padding-left: 26px">{{ $kategori->nama }}</span>
	</th>
	{{-- Buat 20 kolom kosong sisanya agar sejajar --}}
	@for ($i = 0; $i < 20; $i++)
		<th></th>
	@endfor
</tr>

<!-- 2. Render baris untuk setiap LAPORAN di bawah kategori ini -->
@php
  // Inisialisasi sub total
	$total_realisasi_perkategori = 0;
	$realisasi_fisik_perkategori = 0;


  // Inisialisasi data keseluruhan
  $pagu_keseluruhan                           = 0;
  $nilai_tender_keseluruhan                   = 0;
  $realisasi_tender_keseluruhan               = 0;
  $nilai_penunjukkan_langsung_keseluruhan     = 0;
  $realisasi_penunjukkan_langsung_keseluruhan = 0;
  $nilai_swakelola_keseluruhan                = 0;
  $realisasi_swakelola_keseluruhan            = 0;
  $nilai_epurchasing_keseluruhan              = 0;
  $realisasi_epurchasing_keseluruhan          = 0;
  $nilai_pengadaan_langsung_keseluruhan       = 0;
  $realisasi_pengadaan_langsung_keseluruhan   = 0;

  $total_realisasi_keseluruhan    = 0;
  $realisasi_keuangan_keseluruhan = 0;
  $realisasi_fisik_keseluruhan    = 0;
@endphp
@foreach ($kategori->laporan as $laporan)
	@php
		$rowError                 = session('row_id') == $laporan->id;
		$pagu                     = 0;
		$tender                   = 0;
		$penunjukkan_langsung     = 0;
		$swakelola                = 0;
		$epurchasing              = 0;
		$pengadaan_langsung       = 0;
		$total_realisasi_perbaris = 0;

		$pagu                 = $laporan->pagu;
		$tender               = $laporan->nilai_kontrak_tender + $laporan->realisasi_tender;
		$penunjukkan_langsung = $laporan->nilai_kontrak_penunjukkan_langsung + $laporan->realisasi_penunjukkan_langsung;
		$swakelola            = $laporan->nilai_kontrak_swakelola + $laporan->realisasi_swakelola;
		$epurchasing          = $laporan->nilai_kontrak_epurchasing + $laporan->realisasi_epurchasing;
		$pengadaan_langsung   = $laporan->nilai_kontrak_pengadaan_langsung + $laporan->realisasi_pengadaan_langsung;

		$total_jenis_paket            = $tender + $penunjukkan_langsung + $swakelola + $epurchasing + $pengadaan_langsung;
		$total_realisasi_perbaris    += $total_jenis_paket;
		$realisasi_keuangan_perbaris  = $total_jenis_paket / max($pagu, 1);

    // Jumlah baris perkategori
		$total_realisasi_perkategori += $total_jenis_paket;
		$realisasi_fisik_perkategori += format_persen($laporan->presentasi_realisasi_fisik);
	@endphp
	<tr>
		<form action="{{ route('dashboard.update-item-anggaran', $laporan->id) }}" method="post">
			@csrf
			@method('patch')
			<!-- No -->
			<td class="text-center">{{ $loop->iteration }}</td>

			<!-- Nama pekerjaan -->
			<td class="view-mode {{ $rowError ? 'd-none' : '' }}" style="min-width: 255px">
				{{ $laporan->nama_pekerjaan }}</td>
			<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
				<input type="text" name="nama_pekerjaan"
					value="{{ old('nama_pekerjaan', $laporan->nama_pekerjaan) }}" maxlength="100"
					class="forms-input text">
			</td>

			<!-- Pagu -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->pagu) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="pagu" value="{{ old('pagu', $laporan->pagu) }}" min="500"
					class="forms-input rupiah text-end">
			</td>

			<!-- No kontrak -->
			<td class="view-mode {{ $rowError ? 'd-none' : '' }}">
				{{ $laporan->no_kontrak }}</td>
			<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
				<input type="text" name="no_kontrak" value="{{ old('no_kontrak', $laporan->no_kontrak) }}"
					class="forms-input no-kontrak">
			</td>

			<!-- Tgl mulai kontrak -->
			<td class="view-mode text-nowrap {{ $rowError ? 'd-none' : '' }}">
				{{ $laporan->tgl_mulai_kontrak ? Carbon\Carbon::create($laporan->tgl_mulai_kontrak)->translatedFormat('d-m-Y') : null }}
			</td>
			<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
				<input type="date" name="tgl_mulai_kontrak"
					value="{{ old('tgl_mulai_kontrak', $laporan->tgl_mulai_kontrak) }}" class="forms-input tanggal">
			</td>

			<!-- Tgl berakhir kontrak -->
			<td class="view-mode text-nowrap {{ $rowError ? 'd-none' : '' }}">
				{{ $laporan->tgl_berakhir_kontrak ? Carbon\Carbon::create($laporan->tgl_berakhir_kontrak)->translatedFormat('d-m-Y') : null }}
			</td>
			<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
				<input type="date" name="tgl_berakhir_kontrak"
					value="{{ old('tgl_berakhir_kontrak', $laporan->tgl_berakhir_kontrak) }}"
					class="forms-input tanggal">
			</td>

			<!-- Nilai kontrak tender -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->nilai_kontrak_tender) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="nilai_kontrak_tender"
					value="{{ old('nilai_kontrak_tender', $laporan->nilai_kontrak_tender) }}" min="500"
					class="forms-input rupiah text-end">
			</td>

			<!-- Realisasi tender -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->realisasi_tender) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="realisasi_tender"
					value="{{ old('realisasi_tender', $laporan->realisasi_tender) }}" min="500"
					class="forms-input rupiah text-end">
			</td>

			<!-- Nilai kontrak penunjukkan langsung -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->nilai_kontrak_penunjukkan_langsung) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="nilai_kontrak_penunjukkan_langsung"
					value="{{ old('nilai_kontrak_penunjukkan_langsung', $laporan->nilai_kontrak_penunjukkan_langsung) }}"
					min="500" class="forms-input rupiah text-end">
			</td>

			<!-- Realisasi penunjukkan langsung -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->realisasi_penunjukkan_langsung) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="realisasi_penunjukkan_langsung"
					value="{{ old('realisasi_penunjukkan_langsung', $laporan->realisasi_penunjukkan_langsung) }}"
					min="500" class="forms-input rupiah text-end">
			</td>

			<!-- Nilai kontrak swakelola -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->nilai_kontrak_swakelola) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="nilai_kontrak_swakelola"
					value="{{ old('nilai_kontrak_swakelola', $laporan->nilai_kontrak_swakelola) }}" min="500"
					class="forms-input rupiah text-end">
			</td>

			<!-- Realisasi swakelola -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->realisasi_swakelola) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="realisasi_swakelola"
					value="{{ old('realisasi_swakelola', $laporan->realisasi_swakelola) }}" min="500"
					class="forms-input rupiah text-end">
			</td>

			<!-- Nilai kontrak epurchasing -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->nilai_kontrak_epurchasing) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="nilai_kontrak_epurchasing"
					value="{{ old('nilai_kontrak_epurchasing', $laporan->nilai_kontrak_epurchasing) }}" min="500"
					class="forms-input rupiah text-end">
			</td>

			<!-- Realisasi epurchasing -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->realisasi_epurchasing) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="realisasi_epurchasing"
					value="{{ old('realisasi_epurchasing', $laporan->realisasi_epurchasing) }}" min="500"
					class="forms-input rupiah text-end">
			</td>

			<!-- Nilai kontrak pengadaan langsung -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->nilai_kontrak_pengadaan_langsung) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="nilai_kontrak_pengadaan_langsung"
					value="{{ old('nilai_kontrak_pengadaan_langsung', $laporan->nilai_kontrak_pengadaan_langsung) }}"
					min="500" class="forms-input rupiah text-end">
			</td>

			<!-- Realisasi pengadaan langsung -->
			<td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
				{{ format_ribuan($laporan->realisasi_pengadaan_langsung) }}</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="realisasi_pengadaan_langsung"
					value="{{ old('realisasi_pengadaan_langsung', $laporan->realisasi_pengadaan_langsung) }}"
					min="500" class="forms-input rupiah text-end">
			</td>

			<!-- Total realisasi keuangan -->
			<td class="text-end">
				{{ format_ribuan($total_realisasi_perbaris) }}
			</td>

			<!-- Presentasi realisasi keuangan -->
			<td class="text-center">
				{{ format_persen($realisasi_keuangan_perbaris, true) ?? '0%' }}
			</td>

			<!-- Presentasi realisasi fisik -->
			<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
				{{ format_persen($laporan->presentasi_realisasi_fisik, true) ?? '0%' }}
			</td>
			<td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
				<input type="number" name="presentasi_realisasi_fisik"
					value="{{ old('presentasi_realisasi_fisik', $laporan->presentasi_realisasi_fisik * 100) }}"
					min="0" step="0.1" class="forms-input no text-end">
			</td>

			<!-- Sumber dana -->
			<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
				{{ $laporan->sumber_dana ?? '-' }}</td>
			<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
				<input type="text" name="sumber_dana" value="{{ old('sumber_dana', $laporan->sumber_dana) }}"
					maxlength="50" class="forms-input dana">
			</td>

			<!-- Keterangan -->
			<td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
				{{ $laporan->keterangan ?? '-' }}</td>
			<td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
				<input type="text" name="keterangan" value="{{ old('keterangan', $laporan->keterangan) }}"
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
			<a href="{{ route('dashboard.delete-item-anggaran', $laporan->id) }}"
				class="btn btn-sm btn-danger btn-delete" data-confirm-delete>
				<span class="material-icons" style="font-size:18px;vertical-align:middle;">delete</span>
			</a>
		</td>
	</tr>

	@if (count($kategori->laporan) === $loop->iteration)
		@php
			// hitung total untuk per kategori
			$total_pagu_perkategori                   = $kategori->laporan->sum('pagu');
			$total_nilai_kontrak_tender               = $kategori->laporan->sum('nilai_kontrak_tender');
			$total_realisasi_tender                   = $kategori->laporan->sum('realisasi_tender');
			$total_nilai_kontrak_penunjukkan_langsung = $kategori->laporan->sum('nilai_kontrak_penunjukkan_langsung');
			$total_realisasi_penunjukkan_langsung     = $kategori->laporan->sum('realisasi_penunjukkan_langsung');
			$total_nilai_kontrak_swakelola            = $kategori->laporan->sum('nilai_kontrak_swakelola');
			$total_realisasi_swakelola                = $kategori->laporan->sum('realisasi_swakelola');
			$total_nilai_kontrak_epurchasing          = $kategori->laporan->sum('nilai_kontrak_epurchasing');
			$total_realisasi_epurchasing              = $kategori->laporan->sum('realisasi_epurchasing');
			$total_nilai_kontrak_pengadaan_langsung   = $kategori->laporan->sum('nilai_kontrak_pengadaan_langsung');
			$total_realisasi_pengadaan_langsung       = $kategori->laporan->sum('realisasi_pengadaan_langsung');

      $total_realisasi_keseluruhan +=
        $total_nilai_kontrak_tender + $total_realisasi_tender +
        $total_nilai_kontrak_penunjukkan_langsung + $total_realisasi_penunjukkan_langsung +
        $total_nilai_kontrak_swakelola + $total_realisasi_swakelola +
        $total_nilai_kontrak_epurchasing + $total_realisasi_epurchasing +
        $total_nilai_kontrak_pengadaan_langsung + $total_realisasi_pengadaan_langsung;
      $realisasi_keuangan_keseluruhan += $total_realisasi_perkategori / max($total_pagu_perkategori, 1);
      $realisasi_fisik_keseluruhan    += $realisasi_fisik_perkategori / max(count($kategori->laporan), 1);
		@endphp
		<tr class="col-total">
			<th colspan="2" class="text-center">SUB TOTAL</th>
			<th class="text-end">{{ format_ribuan($total_pagu_perkategori) ?? 0 }}</th>
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
			<th class="text-end">{{ format_ribuan($total_realisasi_perkategori) ?? 0 }}</th>
			<th class="text-center">
				{{ format_persen($total_realisasi_perkategori / max($total_pagu_perkategori, 1), true) ?? '0%' }}
			</th>
			<th class="text-center">
				{{ format_persen($realisasi_fisik_perkategori / max(count($kategori->laporan), 1), true) ?? '0%' }}
			</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	@endif

	<!-- Total rupiah -->
	@if ($loop->last)
		<tr class="col-total total-rupiah">
			<th colspan="2" class="text-center">TOTAL RUPIAH</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('pagu')) ?? 0 }}</th>
			<th></th>
			<th></th>
			<th></th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('nilai_kontrak_tender')) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('realisasi_tender')) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('nilai_kontrak_penunjukkan_langsung')) ?? 0 }}
			</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('realisasi_penunjukkan_langsung')) ?? 0 }}
			</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('nilai_kontrak_swakelola')) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('realisasi_swakelola')) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('nilai_kontrak_epurchasing')) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('realisasi_epurchasing')) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('nilai_kontrak_pengadaan_langsung')) ?? 0 }}
			</th>
			<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan()->sum('realisasi_pengadaan_langsung')) ?? 0 }}</th>
			<th class="text-end">{{ format_ribuan($total_realisasi_keseluruhan) ?? 0 }}</th>
			<th class="text-center">
				{{ format_persen($realisasi_keuangan_keseluruhan, true) ?? '0%' }}
			</th>
			<th class="text-center">
				{{ format_persen($realisasi_fisik_keseluruhan, true) ?? '0%' }}
			</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	@endif
@endforeach


<!-- 3. Panggil Diri Sendiri (Rekursif) Untuk Anaknya -->
@php
	$children = $allKategori->where('parent', $kategori->id);
@endphp

@foreach ($children as $child)
	<x-kategori-row :skpd_anggaran="$skpd_anggaran" :kategori="$child" :allKategori="$allKategori" :nomor="$nomor . $loop->iteration . '.'" />
@endforeach
