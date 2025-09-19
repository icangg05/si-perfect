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
							<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
										data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
										aria-selected="true">Item Anggaran</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
										data-bs-target="#pills-profile" type="button" role="tab"
										aria-controls="pills-profile" aria-selected="false">Data Utama</button>
								</li>
							</ul>
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade active show" id="pills-home" role="tabpanel"
									aria-labelledby="pills-home-tab">
									<div class="mt-4 table-responsive my-scrollbar">
										<table class="table table-bordered table-hover">
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
													$no_kategori = 1;
												@endphp

												@foreach ($grouped as $kategori => $subKategoris)
													<tr>
														<th></th>
														<th></th>
														<th class="text-nowrap">{{ $no_kategori . '. ' . $kategori }}</th>
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
															<th class="text-nowrap">{{ $no_kategori . '.' . $no_sub_kategori . ' ' . $subKategori }}</th>
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
															@endphp

															<tr>
																<td class="text-center">{{ $index + 1 }}</td>
																<td class="text-center">{{ $item->no }}</td>
																<td>{{ $item->nama_pekerjaan }}</td>
																<td class="text-end">{{ format_ribuan($item->pagu) }}</td>
																<td>{{ $item->no_kontrak }}</td>
																<td>{{ $item->tanggal_mulai_kontrak }}</td>
																<td>{{ $item->tanggal_berakhir_kontrak }}</td>
																<td class="text-end">{{ format_ribuan($item->nilai_kontrak_tender) }}</td>
																<td class="text-end">{{ format_ribuan($item->realisasi_tender) }}</td>
																<td class="text-end">{{ format_ribuan($item->nilai_kontrak_penunjukkan_langsung) }}</td>
																<td class="text-end">{{ format_ribuan($item->realisasi_penunjukkan_langsung) }}</td>
																<td class="text-end">{{ format_ribuan($item->nilai_kontrak_swakelola) }}</td>
																<td class="text-end">{{ format_ribuan($item->realisasi_swakelola) }}</td>
																<td class="text-end">{{ format_ribuan($item->nilai_kontrak_epurchasing) }}</td>
																<td class="text-end">{{ format_ribuan($item->realisasi_epurchasing) }}</td>
																<td class="text-end">{{ format_ribuan($item->nilai_kontrak_pengadaan_langsung) }}</td>
																<td class="text-end">{{ format_ribuan($item->realisasi_pengadaan_langsung) }}</td>
																<td class="text-end">{{ format_ribuan($total_realisasi_anggaran) }}</td>
																<td class="text-center">
																	{{ $item->pagu > 0 ? floor(($total_realisasi_anggaran / $item->pagu) * 1000) / 10 . '%' : '0%' }}
																</td>
																<td class="text-center">{{ floor($item->presentasi_realisasi_fisik * 1000) / 10 }}%</td>
																<td class="text-center">{{ $item->sumber_dana ?? '-' }}</td>
																<td class="text-center">{{ $item->keterangan ?? '-' }}</td>
																<td>
																	<a href="{{ route('dashboard.laporan-realisasi-item', $item->id) }}"
																		class="btn btn-sm btn-warning text-nowrap">
																		<span class="material-icons" style="font-size: 18px; vertical-align: middle;">edit_square</span>
																	</a>
																</td>
															</tr>
														@endforeach

														{{-- Jumlah per sub kategori --}}
														<tr>
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
															<th class="text-center">{{ floor(0.99 * 1000) / 10 }}%</th>
															<th class="text-center">{{ floor(0.99 * 1000) / 10 }}%</th>
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
												<tr>
													<th></th>
													<th colspan="2" class="text-center">TOTAL RUPIAH</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th></th>
													<th></th>
													<th></th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-end">{{ format_ribuan(0) ?? 0 }}</th>
													<th class="text-center">{{ floor(0 * 1000) / 10 }}%</th>
													<th class="text-center">{{ floor(0 * 1000) / 10 }}%</th>
													<th></th>
													<th></th>
													<th></th>
												</tr>
												{{-- @php
													$no_kategori = 1;
												@endphp
												@foreach ($grouped as $key => $item)
													<tr>
														<th></th>
														<th></th>
														<th class="text-nowrap">{{ "$no_kategori. $key" }}</th>
														@for ($i = 0; $i < 20; $i++)
															<th></th>
														@endfor
													</tr>
													@php
														$no_sub_kategori = 1;
													@endphp
													@foreach ($item as $key2 => $item2)
														<tr>
															<th></th>
															<th></th>
															<th class="text-nowrap">{{ "$no_kategori.$no_sub_kategori $key2" }}</th>
															@for ($i = 0; $i < 20; $i++)
																<th></th>
															@endfor
														</tr>
                            @php
                                $total_realisasi_anggaran_perkategori = 0;
                            @endphp
														@foreach ($item2 as $key3 => $item3)
															<tr>
																<td class="text-center">{{ $key3 + 1 }}</td>
																<td class="text-center">{{ $item3->no }}</td>
																<td>{{ $item3->nama_pekerjaan }}</td>
																<td class="text-end">{{ format_ribuan($item3->pagu) }}</td>
																<td>{{ $item3->no_kontrak }}</td>
																<td>{{ $item3->tanggal_mulai_kontrak }}</td>
																<td>{{ $item3->tanggal_berakhir_kontrak }}</td>
																<td class="text-end">{{ format_ribuan($item3->nilai_kontrak_tender) }}</td>
																<td class="text-end">{{ format_ribuan($item3->realisasi_tender) }}</td>
																<td class="text-end">{{ format_ribuan($item3->nilai_kontrak_penunjukkan_langsung) }}</td>
																<td class="text-end">{{ format_ribuan($item3->realisasi_penunjukkan_langsung) }}</td>
																<td class="text-end">{{ format_ribuan($item3->nilai_kontrak_swakelola) }}</td>
																<td class="text-end">{{ format_ribuan($item3->realisasi_swakelola) }}</td>
																<td class="text-end">{{ format_ribuan($item3->nilai_kontrak_epurchasing) }}</td>
																<td class="text-end">{{ format_ribuan($item3->realisasi_epurchasing) }}</td>
																<td class="text-end">{{ format_ribuan($item3->nilai_kontrak_pengadaan_langsung) }}</td>
																<td class="text-end">{{ format_ribuan($item3->realisasi_pengadaan_langsung) }}</td>
																@php
																	$total_realisasi_anggaran =
                                    $item3->realisasi_tender +
                                    $item3->realisasi_penunjukkan_langsung +
                                    $item3->nilai_kontrak_swakelola +
                                    $item3->realisasi_epurchasing +
                                    $item3->realisasi_pengadaan_langsung;
                                  // $total_realisasi_anggaran = 123;
                                  $total_realisasi_anggaran_perkategori += $total_realisasi_anggaran;

																	$total_pagu                               = $item2->sum('pagu');
																	$total_nilai_kontrak_tender               = $item2->sum('nilai_kontrak_tender');
																	$total_realisasi_tender                   = $item2->sum('realisasi_tender');
																	$total_nilai_kontrak_penunjukkan_langsung = $item2->sum('nilai_kontrak_penunjukkan_langsung');
																	$total_realisasi_penunjukkan_langsung     = $item2->sum('realisasi_penunjukkan_langsung');
																	$total_nilai_kontrak_swakelola            = $item2->sum('nilai_kontrak_swakelola');
																	$total_realisasi_swakelola                = $item2->sum('realisasi_swakelola');
																	$total_nilai_kontrak_epurchasing          = $item2->sum('nilai_kontrak_epurchasing');
																	$total_realisasi_epurchasing              = $item2->sum('realisasi_epurchasing');
																	$total_nilai_kontrak_pengadaan_langsung   = $item2->sum('nilai_kontrak_pengadaan_langsung');
																	$total_realisasi_pengadaan_langsung       = $item2->sum('realisasi_pengadaan_langsung');
																@endphp
																<td class="text-end">{{ format_ribuan($total_realisasi_anggaran) }}</td>
																<td class="text-center">{{ floor(($total_realisasi_anggaran / $item3->pagu) * 100 * 10) / 10 }}%</td>
																<td class="text-center">{{ floor($item3->presentasi_realisasi_fisik * 100 * 10) / 10 }}%</td>
																<td class="text-center">{{ $item3->sumber_dana ?? '-' }}</td>
																<td class="text-center">{{ $item3->keterangan ?? '-' }}</td>
																<td>
																	<a href="{{ route('dashboard.laporan-realisasi-item', $item3->id) }}"
																		class="btn btn-sm btn-warning text-nowrap">
																		<span class="material-icons" style="font-size: 18px; vertical-align: middle;">edit_square</span>
																	</a>
																</td>
															</tr>
															@if ($key3 + 1 == count($item2))
																<tr>
																	<th></th>
																	<th colspan="2" class="text-center">JUMLAH</th>
																	<th class="text-end">{{ format_ribuan($total_pagu) }}</th>
                                  <th></th><th></th><th></th>
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
																</tr>
															@endif
														@endforeach
														@php
															$no_sub_kategori;
														@endphp
													@endforeach
													@php
														$no_kategori++;
													@endphp
												@endforeach --}}
												{{-- <tr>
                          <th></th>
                          <th></th>
													<th class="text-nowrap">1. Paket Penyedia</th>
													@for ($i = 0; $i < 20; $i++)
														<th></th>
													@endfor
												</tr>
												<tr>
                          <th></th>
                          <th></th>
													<th class="text-nowrap">1.1 Paket Penyedia Tambahan</th>
													@for ($i = 0; $i < 20; $i++)
														<th></th>
													@endfor
												</tr>
												@forelse ($skpd_anggaran->laporan as $item)
													<tr>
														<th scope="row" class="text-center">{{ $loop->iteration }}</th>
														<td class="text-center">{{ $item->no }}</td>
														<td>{{ $item->nama_pekerjaan }}</td>
														<td class="text-end">{{ format_ribuan($item->pagu) }}</td>
														<td>{{ $item->no_kontrak }}</td>
														<td>{{ $item->tanggal_mulai_kontrak }}</td>
														<td>{{ $item->tanggal_berakhir_kontrak }}</td>
														<td class="text-end">{{ format_ribuan($item->nilai_kontrak_tender) }}</td>
														<td class="text-end">{{ format_ribuan($item->realisasi_tender) }}</td>
														<td class="text-end">{{ format_ribuan($item->nilai_kontrak_penunjukkan_langsung) }}</td>
														<td class="text-end">{{ format_ribuan($item->realisasi_penunjukkan_langsung) }}</td>
														<td class="text-end">{{ format_ribuan($item->nilai_kontrak_swakelola) }}</td>
														<td class="text-end">{{ format_ribuan($item->realisasi_swakelola) }}</td>
														<td class="text-end">{{ format_ribuan($item->nilai_kontrak_epurchasing) }}</td>
														<td class="text-end">{{ format_ribuan($item->realisasi_epurchasing) }}</td>
														<td class="text-end">{{ format_ribuan($item->nilai_kontrak_pengadaan_langsung) }}</td>
														<td class="text-end">{{ format_ribuan($item->realisasi_pengadaan_langsung) }}</td>
														@php
															$total_realisasi_anggaran =
                                $item->realisasi_tender +
                                $item->realisasi_penunjukkan_langsung +
                                $item->nilai_kontrak_swakelola +
                                $item->realisasi_epurchasing +
                                $item->realisasi_pengadaan_langsung;
														@endphp
														<td class="text-end">{{ format_ribuan($total_realisasi_anggaran) }}</td>
														<td class="text-center">{{ floor(($total_realisasi_anggaran / $item->pagu) * 100 * 10) / 10 }}%</td>
														<td class="text-center">{{ floor($item->presentasi_realisasi_fisik * 100 * 10) / 10 }}%</td>
                            <td class="text-center">{{ $item->sumber_dana ?? '-' }}</td>
                            <td class="text-center">{{ $item->keterangan ?? '-' }}</td>
														<td>
															<a href="{{ route('dashboard.laporan-realisasi-item', $item->id) }}"
																class="btn btn-sm btn-warning text-nowrap">
																<span class="material-icons" style="font-size: 18px; vertical-align: middle;">edit_square</span>
															</a>
														</td>
													</tr>
												@empty
													<tr>
														<td colspan="6" class="text-center text-muted">Tidak ada data ditemukan.</td>
													</tr>
												@endforelse --}}
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
									<p>Formulir detail data anggaran untuk jenis pengadaan ini akan ditampilkan di sini.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layouts.dashboard>
