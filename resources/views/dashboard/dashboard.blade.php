@php
	$tender = 40864760;
	$penunjukkan_langsung = 229329459;
	$swakelola = 288467000;
	$epurchasing = 164457459;
	$pengadaan_langsung = 10691342;

	$total_jenis_paket = $tender + $penunjukkan_langsung + $swakelola + $epurchasing + $pengadaan_langsung;

	$pagu = 2663907526;
	$realisasi_fisik = 0.4986;

@endphp

<x-layouts.dashboard>
	<div class="row">
		<div class="col">
			<div class="page-description d-flex align-items-center">
				<div class="page-description-content flex-grow-1">
					<h1><i class="material-icons h3">dashboard</i> Dashboard</h1>
				</div>
				<div class="page-description-actions">
					<a href="{{ route('logout') }}" class="btn btn-danger btn-style-light"><i class="material-icons">logout</i>Logout</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-8">
			<div class="row">
				{{-- Total pagu --}}
				<div class="col-xl-6">
					<div class="card widget widget-info-navigation">
						<div class="card-body">
							<div class="widget-info-navigation-container">
								<div class="widget-info-navigation-content">
									<span class="text-muted">Total Pagu</span><br>
									<span class="text-primary fw-bolder fs-3">Rp {{ format_ribuan($pagu) }}</span>
								</div>
								<div class="widget-info-navigation-action">
									<a href="#" class="btn btn-light btn-rounded"><i class="material-icons no-m">arrow_right_alt</i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- Realisasi fisik --}}
				<div class="col-xl-6">
					<div class="card widget widget-info-navigation">
						<div class="card-body">
							<div class="widget-info-navigation-container">
								<div class="widget-info-navigation-content">
									<span class="text-muted">Realisasi Fisik</span><br>
									<span class="text-primary fw-bolder fs-3">{{ format_persen($realisasi_fisik, true) }}</span>
								</div>
								<div class="widget-info-navigation-action">
									<a href="#" class="btn btn-light btn-rounded"><i class="material-icons no-m">arrow_right_alt</i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- Data SKPD --}}
				<div class="col-xl-6">
					<div class="card widget widget-info-navigation shadow-sm border-0">
						<div class="card-body">
							<div class="d-flex align-items-start">
								<!-- Avatar -->
								<div class="avatar avatar-rounded me-3 border">
									<div class="avatar-title bg-light text-dark fw-bold">
										PS
									</div>
								</div>

								<!-- Info -->
								<div class="flex-grow-1">
									<h5 class="mb-1 fw-bold text-dark">
										{{ Auth::user()->skpd->pimpinan_skpd ?? '-' }}
									</h5>
									<p class="mb-3 text-muted fst-italic">
										{{ Auth::user()->skpd->nama }}
									</p>
								</div>
							</div>

							<ul class="mt-2 ps-3 list-unstyled mb-0">
								<li class="mb-2">
									<i class="material-icons me-2 align-middle fs-6 text-muted">badge</i>
									<span class="fw-semibold text-muted">NIP:</span>
									{{ Auth::user()->skpd->nip_pimpinan ?? '-' }}
								</li>
								<li class="mb-2">
									<i class="material-icons me-2 align-middle fs-6 text-muted">military_tech</i>
									<span class="fw-semibold text-muted">Pangkat:</span>
									{{ Auth::user()->skpd->pangkat_pimpinan ?? '-' }}
								</li>
								<li class="mb-2">
									<i class="material-icons me-2 align-middle fs-6 text-muted">layers</i>
									<span class="fw-semibold text-muted">Golongan:</span>
									{{ Auth::user()->skpd->golongan_pimpinan ?? '-' }}
								</li>
								<li class="mb-2">
									<i class="material-icons me-2 align-middle fs-6 text-muted">phone</i>
									<span class="fw-semibold text-muted">Kontak:</span>
									{{ Auth::user()->skpd->kontak_pimpinan ?? '-' }}
								</li>
								<li>
									<i class="material-icons me-2 align-middle fs-6 text-muted">email</i>
									<span class="fw-semibold text-muted">Email:</span>
									{{ Auth::user()->email ?? '-' }}
								</li>
							</ul>
						</div>

						<!-- Footer -->
						<div class="card-footer text-center bg-light border-0">
							<a href="{{ route('dashboard.pengaturan') }}"
								class="btn btn-outline-primary rounded-pill fw-semibold text-uppercase">
								<i class="material-icons align-middle me-1 fs-5">account_circle</i>
								Data Akun
							</a>
						</div>
					</div>
				</div>
				{{-- Grafik --}}
				<div class="col-xl-6">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Grafik Anggaran</h5>
						</div>
						<div class="card-body" style="position: relative;">
							<div id="apex1" style="min-height: 365px;">
								<div id="apexcharts4eu7nfop" class="apexcharts-canvas apexcharts4eu7nfop apexcharts-theme-light"
									style="width: 258px; height: 350px;"><svg id="SvgjsSvg2714" width="258" height="350"
										xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
										xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS"
										transform="translate(0, 0)" style="background: transparent;">
										<g id="SvgjsG2716" class="apexcharts-inner apexcharts-graphical"
											transform="translate(45.35227394104004, 50.272727966308594)">
											<defs id="SvgjsDefs2715">
												<clipPath id="gridRectMask4eu7nfop">
													<rect id="SvgjsRect2723" width="199.97158908843994" height="268.5461797218323" x="-4.5" y="-2.5"
														rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
														fill="#fff"></rect>
												</clipPath>
												<clipPath id="gridRectMarkerMask4eu7nfop">
													<rect id="SvgjsRect2724" width="194.97158908843994" height="267.5461797218323" x="-2" y="-2"
														rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
														fill="#fff"></rect>
												</clipPath>
											</defs>
											<line id="SvgjsLine2722" x1="0" y1="0" x2="0" y2="263.5461797218323"
												stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="0" y="0" width="1"
												height="263.5461797218323" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
											<g id="SvgjsG2730" class="apexcharts-xaxis" transform="translate(0, 0)">
												<g id="SvgjsG2731" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text
														id="SvgjsText2733" font-family="Helvetica, Arial, sans-serif" x="0" y="292.5461797218323"
														text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2734">Jan</tspan>
														<title>Jan</title>
													</text><text id="SvgjsText2736" font-family="Helvetica, Arial, sans-serif" x="23.871448636054993"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2737">Feb</tspan>
														<title>Feb</title>
													</text><text id="SvgjsText2739" font-family="Helvetica, Arial, sans-serif" x="47.742897272109985"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2740">Mar</tspan>
														<title>Mar</title>
													</text><text id="SvgjsText2742" font-family="Helvetica, Arial, sans-serif" x="71.61434590816498"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2743">Apr</tspan>
														<title>Apr</title>
													</text><text id="SvgjsText2745" font-family="Helvetica, Arial, sans-serif" x="95.48579454421997"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2746">May</tspan>
														<title>May</title>
													</text><text id="SvgjsText2748" font-family="Helvetica, Arial, sans-serif" x="119.35724318027496"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2749">Jun</tspan>
														<title>Jun</title>
													</text><text id="SvgjsText2751" font-family="Helvetica, Arial, sans-serif" x="143.22869181632996"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2752">Jul</tspan>
														<title>Jul</title>
													</text><text id="SvgjsText2754" font-family="Helvetica, Arial, sans-serif" x="167.10014045238495"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2755">Aug</tspan>
														<title>Aug</title>
													</text><text id="SvgjsText2757" font-family="Helvetica, Arial, sans-serif" x="190.97158908843994"
														y="292.5461797218323" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400"
														fill="rgba(94, 96, 110, .5)" class="apexcharts-text apexcharts-xaxis-label "
														style="font-family: Helvetica, Arial, sans-serif;">
														<tspan id="SvgjsTspan2758">Sep</tspan>
														<title>Sep</title>
													</text></g>
												<line id="SvgjsLine2759" x1="0" y1="264.5461797218323" x2="190.97158908843994"
													y2="264.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" stroke-width="1"></line>
											</g>
											<g id="SvgjsG2774" class="apexcharts-grid">
												<g id="SvgjsG2775" class="apexcharts-gridlines-horizontal">
													<line id="SvgjsLine2786" x1="0" y1="0" x2="190.97158908843994" y2="0"
														stroke="rgba(94, 96, 110, .5)" stroke-dasharray="4" class="apexcharts-gridline"></line>
													<line id="SvgjsLine2787" x1="0" y1="52.709235944366455" x2="190.97158908843994"
														y2="52.709235944366455" stroke="rgba(94, 96, 110, .5)" stroke-dasharray="4"
														class="apexcharts-gridline"></line>
													<line id="SvgjsLine2788" x1="0" y1="105.41847188873291" x2="190.97158908843994"
														y2="105.41847188873291" stroke="rgba(94, 96, 110, .5)" stroke-dasharray="4"
														class="apexcharts-gridline"></line>
													<line id="SvgjsLine2789" x1="0" y1="158.12770783309935" x2="190.97158908843994"
														y2="158.12770783309935" stroke="rgba(94, 96, 110, .5)" stroke-dasharray="4"
														class="apexcharts-gridline"></line>
													<line id="SvgjsLine2790" x1="0" y1="210.83694377746582" x2="190.97158908843994"
														y2="210.83694377746582" stroke="rgba(94, 96, 110, .5)" stroke-dasharray="4"
														class="apexcharts-gridline"></line>
													<line id="SvgjsLine2791" x1="0" y1="263.5461797218323" x2="190.97158908843994"
														y2="263.5461797218323" stroke="rgba(94, 96, 110, .5)" stroke-dasharray="4"
														class="apexcharts-gridline"></line>
												</g>
												<g id="SvgjsG2776" class="apexcharts-gridlines-vertical"></g>
												<line id="SvgjsLine2777" x1="0" y1="264.5461797218323" x2="0" y2="270.5461797218323"
													stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2778" x1="23.871448636054993" y1="264.5461797218323" x2="23.871448636054993"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2779" x1="47.742897272109985" y1="264.5461797218323" x2="47.742897272109985"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2780" x1="71.61434590816498" y1="264.5461797218323" x2="71.61434590816498"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2781" x1="95.48579454421997" y1="264.5461797218323" x2="95.48579454421997"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2782" x1="119.35724318027496" y1="264.5461797218323" x2="119.35724318027496"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2783" x1="143.22869181632996" y1="264.5461797218323" x2="143.22869181632996"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2784" x1="167.10014045238495" y1="264.5461797218323" x2="167.10014045238495"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<line id="SvgjsLine2785" x1="190.97158908843994" y1="264.5461797218323" x2="190.97158908843994"
													y2="270.5461797218323" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
												<rect id="SvgjsRect2792" width="190.97158908843994" height="52.709235944366455" x="0" y="0"
													rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none" stroke-dasharray="0"
													fill="#f3f3f3" clip-path="url(#gridRectMask4eu7nfop)" class="apexcharts-grid-row"></rect>
												<rect id="SvgjsRect2793" width="190.97158908843994" height="52.709235944366455" x="0"
													y="52.709235944366455" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none"
													stroke-dasharray="0" fill="transparent" clip-path="url(#gridRectMask4eu7nfop)"
													class="apexcharts-grid-row"></rect>
												<rect id="SvgjsRect2794" width="190.97158908843994" height="52.709235944366455" x="0"
													y="105.41847188873291" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none"
													stroke-dasharray="0" fill="#f3f3f3" clip-path="url(#gridRectMask4eu7nfop)" class="apexcharts-grid-row">
												</rect>
												<rect id="SvgjsRect2795" width="190.97158908843994" height="52.709235944366455" x="0"
													y="158.12770783309935" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none"
													stroke-dasharray="0" fill="transparent" clip-path="url(#gridRectMask4eu7nfop)"
													class="apexcharts-grid-row"></rect>
												<rect id="SvgjsRect2796" width="190.97158908843994" height="52.709235944366455" x="0"
													y="210.83694377746582" rx="0" ry="0" opacity="0.5" stroke-width="0" stroke="none"
													stroke-dasharray="0" fill="#f3f3f3" clip-path="url(#gridRectMask4eu7nfop)" class="apexcharts-grid-row">
												</rect>
												<line id="SvgjsLine2798" x1="0" y1="263.5461797218323" x2="190.97158908843994"
													y2="263.5461797218323" stroke="transparent" stroke-dasharray="0"></line>
												<line id="SvgjsLine2797" x1="0" y1="1" x2="0" y2="263.5461797218323"
													stroke="transparent" stroke-dasharray="0"></line>
											</g>
											<g id="SvgjsG2725" class="apexcharts-line-series apexcharts-plot-series">
												<g id="SvgjsG2726" class="apexcharts-series" seriesName="Desktops" data:longestSeries="true"
													rel="1" data:realIndex="0">
													<path id="SvgjsPath2729"
														d="M 0 245.97643440704346L 23.871448636054993 191.51022393119814L 47.742897272109985 202.05207112007142L 71.61434590816498 173.9404786164093L 95.48579454421997 177.4544276793671L 119.35724318027496 154.6137587701416L 143.22869181632996 142.31493704978942L 167.10014045238495 103.66149735725404L 190.97158908843994 3.5139490629577494"
														fill="none" fill-opacity="1" stroke="rgba(0,143,251,0.85)" stroke-opacity="1"
														stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-line" index="0"
														clip-path="url(#gridRectMask4eu7nfop)"
														pathTo="M 0 245.97643440704346L 23.871448636054993 191.51022393119814L 47.742897272109985 202.05207112007142L 71.61434590816498 173.9404786164093L 95.48579454421997 177.4544276793671L 119.35724318027496 154.6137587701416L 143.22869181632996 142.31493704978942L 167.10014045238495 103.66149735725404L 190.97158908843994 3.5139490629577494"
														pathFrom="M -1 263.5461797218323L -1 263.5461797218323L 23.871448636054993 263.5461797218323L 47.742897272109985 263.5461797218323L 71.61434590816498 263.5461797218323L 95.48579454421997 263.5461797218323L 119.35724318027496 263.5461797218323L 143.22869181632996 263.5461797218323L 167.10014045238495 263.5461797218323L 190.97158908843994 263.5461797218323">
													</path>
													<g id="SvgjsG2727" class="apexcharts-series-markers-wrap" data:realIndex="0">
														<g class="apexcharts-series-markers">
															<circle id="SvgjsCircle2804" r="0" cx="0" cy="0"
																class="apexcharts-marker wh2mey75n no-pointer-events" stroke="#ffffff" fill="#008ffb"
																fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
														</g>
													</g>
												</g>
												<g id="SvgjsG2728" class="apexcharts-datalabels" data:realIndex="0"></g>
											</g>
											<line id="SvgjsLine2799" x1="0" y1="0" x2="190.97158908843994" y2="0"
												stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line>
											<line id="SvgjsLine2800" x1="0" y1="0" x2="190.97158908843994" y2="0"
												stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line>
											<g id="SvgjsG2801" class="apexcharts-yaxis-annotations"></g>
											<g id="SvgjsG2802" class="apexcharts-xaxis-annotations"></g>
											<g id="SvgjsG2803" class="apexcharts-point-annotations"></g>
										</g><text id="SvgjsText2718" font-family="Helvetica, Arial, sans-serif" x="10" y="16.5" text-anchor="start"
											dominant-baseline="auto" font-size="14px" font-weight="900" fill="#373d3f" class="apexcharts-title-text"
											style="font-family: Helvetica, Arial, sans-serif; opacity: 1;">Product Trends by Month</text>
										<rect id="SvgjsRect2721" width="0" height="0" x="0" y="0" rx="0" ry="0"
											opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
										<g id="SvgjsG2760" class="apexcharts-yaxis" rel="0" transform="translate(15.352273941040039, 0)">
											<g id="SvgjsG2761" class="apexcharts-yaxis-texts-g"><text id="SvgjsText2762"
													font-family="Helvetica, Arial, sans-serif" x="20" y="51.772727966308594" text-anchor="end"
													dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f"
													class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
													<tspan id="SvgjsTspan2763">150</tspan>
												</text><text id="SvgjsText2764" font-family="Helvetica, Arial, sans-serif" x="20" y="104.48196391067505"
													text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f"
													class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
													<tspan id="SvgjsTspan2765">120</tspan>
												</text><text id="SvgjsText2766" font-family="Helvetica, Arial, sans-serif" x="20" y="157.1911998550415"
													text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f"
													class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
													<tspan id="SvgjsTspan2767">90</tspan>
												</text><text id="SvgjsText2768" font-family="Helvetica, Arial, sans-serif" x="20" y="209.90043579940794"
													text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f"
													class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
													<tspan id="SvgjsTspan2769">60</tspan>
												</text><text id="SvgjsText2770" font-family="Helvetica, Arial, sans-serif" x="20" y="262.6096717437744"
													text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f"
													class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
													<tspan id="SvgjsTspan2771">30</tspan>
												</text><text id="SvgjsText2772" font-family="Helvetica, Arial, sans-serif" x="20" y="315.3189076881409"
													text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f"
													class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
													<tspan id="SvgjsTspan2773">0</tspan>
												</text></g>
										</g>
										<g id="SvgjsG2717" class="apexcharts-annotations"></g>
									</svg>
									<div class="apexcharts-legend" style="max-height: 175px;"></div>
									<div class="apexcharts-tooltip apexcharts-theme-light">
										<div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
										</div>
										<div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker"
												style="background-color: rgb(0, 143, 251);"></span>
											<div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
												<div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span
														class="apexcharts-tooltip-text-value"></span></div>
												<div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span
														class="apexcharts-tooltip-text-z-value"></span></div>
											</div>
										</div>
									</div>
									<div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light">
										<div class="apexcharts-xaxistooltip-text"
											style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
									</div>
									<div
										class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
										<div class="apexcharts-yaxistooltip-text"></div>
									</div>
									<div class="apexcharts-toolbar" style="top: 0px; right: 3px;">
										<div class="apexcharts-menu-icon" title="Menu"><svg xmlns="http://www.w3.org/2000/svg" width="24"
												height="24" viewBox="0 0 24 24">
												<path fill="none" d="M0 0h24v24H0V0z"></path>
												<path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
											</svg></div>
										<div class="apexcharts-menu">
											<div class="apexcharts-menu-item exportSVG" title="Download SVG">Download SVG</div>
											<div class="apexcharts-menu-item exportPNG" title="Download PNG">Download PNG</div>
											<div class="apexcharts-menu-item exportCSV" title="Download CSV">Download CSV</div>
										</div>
									</div>
								</div>
							</div>
							<div class="resize-triggers">
								<div class="expand-trigger">
									<div style="width: 319px; height: 398px;"></div>
								</div>
								<div class="contract-trigger"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			{{-- Jenis paket --}}
			<div class="col-xl-12">
				<div class="card widget widget-list">
					<div class="card-header">
						<h5 class="card-title">
							Jenis Paket
							<span class="badge badge-success badge-style-light" style="font-size: 1.3rem">Rp
								{{ format_ribuan($total_jenis_paket) }}</span>
						</h5>
					</div>
					<div class="card-body">
						<ul class="widget-list-content list-unstyled">
							<li class="widget-list-item widget-list-item-green">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">article</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">
										Tender
									</a>
									<span class="widget-list-item-description-subtitle">
										Rp {{ format_ribuan($tender) }}
									</span>
								</span>
							</li>
							<li class="widget-list-item widget-list-item-blue">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">verified_user</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">
										Penunjukkan Langsung
									</a>
									<span class="widget-list-item-description-subtitle">
										Rp {{ format_ribuan($penunjukkan_langsung) }}
									</span>
								</span>
							</li>
							<li class="widget-list-item widget-list-item-purple">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">watch_later</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">
										Swakelola
									</a>
									<span class="widget-list-item-description-subtitle">
										Rp {{ format_ribuan($swakelola) }}
									</span>
								</span>
							</li>
							<li class="widget-list-item widget-list-item-yellow">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">extension</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">
										e-Purchasing
									</a>
									<span class="widget-list-item-description-subtitle">
										Rp {{ format_ribuan($epurchasing) }}
									</span>
								</span>
							</li>
							<li class="widget-list-item widget-list-item-red">
								<span class="widget-list-item-icon"><i class="material-icons-outlined">invert_colors</i></span>
								<span class="widget-list-item-description">
									<a href="#" class="widget-list-item-description-title">
										Pengadaan Langsung
									</a>
									<span class="widget-list-item-description-subtitle">
										Rp {{ format_ribuan($pengadaan_langsung) }}
									</span>
								</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layouts.dashboard>
