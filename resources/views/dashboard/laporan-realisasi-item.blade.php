<x-layouts.dashboard>
	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-start">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">summarize</i> Laporan Realisasi</h1>
					<span>
						Detail laporan realisasi anggaran berdasarkan SKPD untuk periode
						<strong>{{ $skpd_anggaran->bulan }}</strong>
						<strong>{{ $skpd_anggaran->tahun_anggaran }}</strong>.
					</span>
				</div>
				<div class="page-description-actions">
					<a href="{{ url()->current() }}" class="btn btn-info btn-style-light">
						<i class="material-icons-outlined">refresh</i> Refresh</a>
					<a href="{{ route('dashboard.laporan-realisasi') }}" class="btn btn-warning btn-style-light">
						<i class="material-icons">keyboard_backspace</i> Kembali
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
    @if ($errors->any())
      <div class="col-md-12">
        <div class="alert alert-custom" role="alert">
          <div class="custom-alert-icon icon-danger"><i class="material-icons-outlined h1">error</i></div>
          <div class="alert-content">
            <span class="alert-title">Terjadi kesalahan</span>
            <ul class="alert-text">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    @endif
		<div class="col">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">{{ $skpd_anggaran->jenis_pengadaan }}</h5>
				</div>
				<div class="card-body">
					<p class="card-description">
						Detail data laporan realisasi untuk jenis pengadaan
						<strong>{{ $skpd_anggaran->jenis_pengadaan }}</strong>
						pada bulan
						<strong>{{ Carbon\Carbon::create()->month($skpd_anggaran->bulan_anggaran)->translatedFormat('F') }}</strong>
						tahun <strong>{{ $skpd_anggaran->tahun_anggaran }}</strong>.
						Silakan pilih tab untuk melihat item anggaran maupun data anggaran yang terkait.
					</p>
					<div class="example-container">
						<div class="example-content">
              @php
                $activeTab =
                  session('active_tab') ??
                  ($errors->hasAny(['jenis_pengadaan', 'bulan_anggaran', 'tahun_anggaran']) ? 'data-utama' : 'item-anggaran');
              @endphp
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link {{ $activeTab === 'item-anggaran' ? 'active' : '' }}" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#item-anggaran" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">Item Anggaran</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link {{ $activeTab === 'data-utama' ? 'active' : '' }}" id="pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#data-utama" type="button" role="tab"
                    aria-controls="pills-profile" aria-selected="false">Data Utama</button>
                </li>
              </ul>
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade {{ $activeTab === 'item-anggaran' ? 'active show' : '' }}" id="item-anggaran" role="tabpanel"
									aria-labelledby="pills-home-tab">
                  <div class="mt-4">
                    <a href="{{ route('dashboard.create-item-anggaran', $skpd_anggaran->id) }}" class="btn btn-primary btn-sm" style="font-size: .9rem">
                      <i class="material-icons" style="font-size: 1.1rem">add</i> Tambah Item</a>
                    <a href="{{ route('export') }}" class="btn btn-success btn-sm" style="font-size: .9rem">
                      <i class="material-icons" style="font-size: 1.1rem">description</i> Export</a>
                  </div>

									<div class="mt-3 table-responsive my-scrollbar">
										<table class="table table-sm table-bordered table-hover my-table font-arimo">
											<thead class="text-center align-middle">
												<tr>
													<th scope="col" rowspan="3">Urut DPA</th>
													<th scope="col" rowspan="3">NO.</th>
													<th scope="col" rowspan="3">NAMA PEKERJAAN</th>
													<th scope="col" rowspan="3">PAGU (Rp)</th>
													<th scope="col" rowspan="3">NO. KONTRAK</th>
													<th scope="col" rowspan="2" colspan="2">TANGGAL KONTRAK</th>
													<th scope="col" colspan="10">JENIS PAKET</th>
													<th scope="col" rowspan="3">TOTAL REALISASI ANGGARAN</th>
													<th scope="col" rowspan="2" colspan="2">PRESENTASI REALISASI</th>
													<th scope="col" rowspan="3">SUMBER DANA (APBD/ DAK/ DID)</th>
													<th scope="col" rowspan="3">KET</th>
													<th scope="col" rowspan="3">AKSI</th>
												</tr>
												<tr>
													<th colspan="2">TENDER</th>
													<th colspan="2">PENUNJUKKAN LANGSUNG</th>
													<th colspan="2">SWAKELOLA</th>
													<th colspan="2">E-PURCHASING</th>
													<th colspan="2">PENGADAAN LANGSUNG</th>
												</tr>
												<tr>
													<th>MULAI</th>
													<th>BERAKHIR</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>NILAI KONTRAK (Rp)</th>
													<th>REALISASI (Rp)</th>
													<th>KEUANGAN (%)</th>
													<th>FISIK (%)</th>
												</tr>
											</thead>
											<tbody>
												@php
                          $no_kategori                               = 1;
                          $presentasi_realisasi_keuangan_keseluruhan = 0;
                          $presentasi_realisasi_fisik_keseluruhan    = 0;
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
                            $no_sub_kategori                        = 1;
                            $total_realisasi_anggaran_perkategori   = 0;
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
															$total_pagu                               = $items->sum('pagu');
															$total_nilai_kontrak_tender               = $items->sum('nilai_kontrak_tender');
															$total_realisasi_tender                   = $items->sum('realisasi_tender');
															$total_nilai_kontrak_penunjukkan_langsung = $items->sum('nilai_kontrak_penunjukkan_langsung');
															$total_realisasi_penunjukkan_langsung     = $items->sum('realisasi_penunjukkan_langsung');
															$total_nilai_kontrak_swakelola            = $items->sum('nilai_kontrak_swakelola');
															$total_realisasi_swakelola                = $items->sum('realisasi_swakelola');
															$total_nilai_kontrak_epurchasing          = $items->sum('nilai_kontrak_epurchasing');
															$total_realisasi_epurchasing              = $items->sum('realisasi_epurchasing');
															$total_nilai_kontrak_pengadaan_langsung   = $items->sum('nilai_kontrak_pengadaan_langsung');
															$total_realisasi_pengadaan_langsung       = $items->sum('realisasi_pengadaan_langsung');
                                // tambahkan ke presentasi realisasi fisik keseluruhan
                              $presentasi_realisasi_fisik_keseluruhan    += $items->sum('presentasi_realisasi_fisik') / count($items);
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
                                $no_asc                                = $index + 1;
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
                                    <input type="number" name="no" value="{{ old('no', $item->no) }}" min="1" class="forms-input no text-end">
                                  </td>

                                  <!-- Kolom nama pekerjaan -->
                                  <td class="view-mode {{ $rowError ? 'd-none' : '' }}">
                                    {{ $item->nama_pekerjaan }}</td>
                                  <td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
                                    <input type="text" name="nama_pekerjaan" value="{{ old('nama_pekerjaan', $item->nama_pekerjaan) }}" maxlength="100" class="forms-input text">
                                  </td>

                                  <!-- Kolom pagu -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->pagu) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="pagu" value="{{ old('pagu', $item->pagu) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom no kontrak -->
                                  <td class="view-mode {{ $rowError ? 'd-none' : '' }}">
                                    {{ $item->no_kontrak }}</td>
                                  <td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
                                    <input type="text" name="no_kontrak" value="{{ old('no_kontrak', $item->no_kontrak) }}" class="forms-input no-kontrak">
                                  </td>

                                  <!-- Kolom tgl mulai kontrak -->
                                  <td class="view-mode text-nowrap {{ $rowError ? 'd-none' : '' }}">
                                    {{ $item->tgl_mulai_kontrak ? Carbon\Carbon::create($item->tgl_mulai_kontrak)->translatedFormat('d-m-Y') : null }}</td>
                                  <td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
                                    <input type="date" name="tgl_mulai_kontrak" value="{{ old('tgl_mulai_kontrak', $item->tgl_mulai_kontrak) }}" class="forms-input tanggal">
                                  </td>

                                  <!-- Kolom tgl berakhir kontrak -->
                                  <td class="view-mode text-nowrap {{ $rowError ? 'd-none' : '' }}">
                                    {{ $item->tgl_berakhir_kontrak ? Carbon\Carbon::create($item->tgl_berakhir_kontrak)->translatedFormat('d-m-Y') : null }}</td>
                                  <td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
                                    <input type="date" name="tgl_berakhir_kontrak" value="{{ old('tgl_berakhir_kontrak', $item->tgl_berakhir_kontrak) }}" class="forms-input tanggal">
                                  </td>

                                  <!-- Kolom nilai kontrak tender -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->nilai_kontrak_tender) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="nilai_kontrak_tender" value="{{ old('nilai_kontrak_tender', $item->nilai_kontrak_tender) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom realisasi tender -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->realisasi_tender) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="realisasi_tender" value="{{ old('realisasi_tender', $item->realisasi_tender) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom nilai kontrak penunjukkan langsung -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->nilai_kontrak_penunjukkan_langsung) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="nilai_kontrak_penunjukkan_langsung" value="{{ old('nilai_kontrak_penunjukkan_langsung', $item->nilai_kontrak_penunjukkan_langsung) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom realisasi penunjukkan langsung -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->realisasi_penunjukkan_langsung) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="realisasi_penunjukkan_langsung" value="{{ old('realisasi_penunjukkan_langsung', $item->realisasi_penunjukkan_langsung) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom nilai kontrak swakelola -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->nilai_kontrak_swakelola) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="nilai_kontrak_swakelola" value="{{ old('nilai_kontrak_swakelola', $item->nilai_kontrak_swakelola) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom realisasi swakelola -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->realisasi_swakelola) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="realisasi_swakelola" value="{{ old('realisasi_swakelola', $item->realisasi_swakelola) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom nilai kontrak epurchasing -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->nilai_kontrak_epurchasing) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="nilai_kontrak_epurchasing" value="{{ old('nilai_kontrak_epurchasing', $item->nilai_kontrak_epurchasing) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom realisasi epurchasing -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->realisasi_epurchasing) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="realisasi_epurchasing" value="{{ old('realisasi_epurchasing', $item->realisasi_epurchasing) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom nilai kontrak pengadaan langsung -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->nilai_kontrak_pengadaan_langsung) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="nilai_kontrak_pengadaan_langsung" value="{{ old('nilai_kontrak_pengadaan_langsung', $item->nilai_kontrak_pengadaan_langsung) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom realiasi pengadaan langsung -->
                                  <td class="view-mode text-end {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_ribuan($item->realisasi_pengadaan_langsung) }}</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="realisasi_pengadaan_langsung" value="{{ old('realisasi_pengadaan_langsung', $item->realisasi_pengadaan_langsung) }}" min="500" class="forms-input rupiah text-end">
                                  </td>

                                  <!-- Kolom total realisasi keuangan -->
                                  <td class="text-end">{{ format_ribuan($total_realisasi_anggaran) }}</td>
                                  <td class="text-center">
                                    {{ format_persen($total_realisasi_anggaran / max($item->pagu, 1)) ?? 0 }}%
                                  </td>

                                  <!-- Kolom presentasi realisasi fisik -->
                                  <td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
                                    {{ format_persen($item->presentasi_realisasi_fisik) ?? 0 }}%</td>
                                  <td class="edit-mode text-end {{ $rowError ? '' : 'd-none' }}">
                                    <input type="number" name="presentasi_realisasi_fisik" value="{{ old('presentasi_realisasi_fisik', $item->presentasi_realisasi_fisik * 100) }}" min="0" step="0.1" class="forms-input no text-end">
                                  </td>

                                  <!-- Kolom sumber dana -->
                                  <td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
                                    {{ $item->sumber_dana ?? '-' }}</td>
                                  <td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
                                    <input type="text" name="sumber_dana" value="{{ old('sumber_dana', $item->sumber_dana) }}" maxlength="50" class="forms-input dana">
                                  </td>

                                  <!-- Kolom keterangan -->
                                  <td class="view-mode text-center {{ $rowError ? 'd-none' : '' }}">
                                    {{ $item->keterangan ?? '-' }}</td>
                                  <td class="edit-mode {{ $rowError ? '' : 'd-none' }}">
                                    <input type="text" name="keterangan" value="{{ old('keterangan', $item->keterangan) }}" maxlength="191" class="forms-input no-kontrak">
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
                                  <a href="{{ route('dashboard.delete-item-anggaran', $item->id) }}" class="btn btn-sm btn-danger btn-delete" data-confirm-delete>
                                    <span class="material-icons" style="font-size:18px;vertical-align:middle;">delete</span>
                                  </a>
                                </td>
                              </tr>
														@endforeach

                            @php
                              // tambahkan ke presentasi realisasi fisik keseluruhan
                              $presentasi_realisasi_keuangan_keseluruhan += $total_realisasi_anggaran_perkategori / $total_pagu;
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
															<th class="text-center">{{ format_persen($total_realisasi_anggaran_perkategori / $total_pagu) }}%</th>
															<th class="text-center">{{ format_persen($items->sum('presentasi_realisasi_fisik') / count($items)) }}%</th>
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

												{{-- Total jumlah keseluruhan --}}
												<tr class="col-total">
													<th></th>
													<th colspan="2" class="text-center">TOTAL RUPIAH</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('pagu')) ?? 0 }}</th>
													<th></th>
													<th></th>
													<th></th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_tender')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_tender')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_penunjukkan_langsung')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_penunjukkan_langsung')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_swakelola')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_swakelola')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_epurchasing')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_epurchasing')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('nilai_kontrak_pengadaan_langsung')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('realisasi_pengadaan_langsung')) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan($skpd_anggaran->laporan->sum('pagu')) ?? 0 }}</th>
													<th class="text-center">{{ format_persen($presentasi_realisasi_keuangan_keseluruhan / max(count($grouped), 1)) ?? 0 }}%</th>
													<th class="text-center">{{ format_persen($presentasi_realisasi_fisik_keseluruhan / max(count($grouped), 1)) ?? 0 }}%</th>
													<th></th>
													<th></th>
													<th></th>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade {{ $activeTab === 'data-utama' ? 'active show' : '' }}" id="data-utama" role="tabpanel" aria-labelledby="pills-profile-tab">
                  <div class="mt-4">
                    <form action="{{ route('dashboard.update-data-laporan', $skpd_anggaran->id) }}" method="post">
                      @csrf
                      @method('patch')
                      <div class="row">
                        <div class="col-md-8">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="mb-3">
                                <label for="jenis_pengadaan" class="form-label">Jenis Pengadaan</label>
                                <input type="text" class="form-control" id="jenis_pengadaan" aria-describedby="jenis_pengadaanHelp"
                                  placeholder="Masukkan jenis pengadaan..." name="jenis_pengadaan" value="{{ old('jenis_pengadaan', $skpd_anggaran->jenis_pengadaan) }}">
                                {{-- @error('jenis_pengadaan')
                                  <div class="form-text text-danger">{{ $message }}</div>
                                @enderror --}}
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-3">
                                <label for="bulan_anggaran" class="form-label">Bulan</label>
                                <select name="bulan_anggaran" class="form-select">
                                  <option value="">-- Pilih Bulan --</option>
                                  @foreach (range(1, 12) as $i)
                                    <option value="{{ $i }}" {{ old('bulan_anggaran', $skpd_anggaran->bulan_anggaran) == $i ? 'selected' : '' }}>
                                      {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                  @endforeach
                                </select>
                                {{-- @error('bulan_anggaran')
                                  <div class="form-text text-danger">{{ $message }}</div>
                                @enderror --}}
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-3">
                                <label for="tahun_anggaran" class="form-label">Tahun Anggaran</label>
                                <input type="text" class="form-control" id="tahun_anggaran" aria-describedby="tahun_anggaranHelp"
                                  placeholder="Masukkan tahun anggaran..." maxlength="4" name="tahun_anggaran" value="{{ old('tahun_anggaran', $skpd_anggaran->tahun_anggaran) }}">
                                {{-- @error('tahun_anggaran')
                                  <div class="form-text text-danger">{{ $message }}</div>
                                @enderror --}}
                              </div>
                            </div>
                          </div>
                          <div class="row m-t-sm">
                            <div class="col">
                              <button type="submit" class="btn btn-primary">
                                <i class="material-icons">save_alt</i> Simpan</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layouts.dashboard>
