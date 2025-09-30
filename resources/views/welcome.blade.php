<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- SEO Meta Tags -->
	<meta name="description"
		content="SI-PERFECT adalah Sistem Informasi Pelaporan Efektif, Cepat, dan Tepat untuk mendukung digitalisasi proses pelaporan di Kota Kendari.">
	<meta name="keywords"
		content="SI-PERFECT, Sistem Informasi, Pelaporan, Kota Kendari, digitalisasi laporan, aplikasi pelaporan">
	<meta name="author" content="Pemerintah Kota Kendari">
	<meta name="robots" content="index, follow">

	<!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
	<meta property="og:title" content="SI-PERFECT - Sistem Informasi Pelaporan Efektif, Cepat, dan Tepat">
	<meta property="og:description" content="Solusi praktis pelaporan modern berbasis web untuk Pemerintah Kota Kendari.">
	<meta property="og:image" content="{{ asset('img/hero-right.webp') }}">
	<meta property="og:url" content="{{ url()->current() }}">
	<meta property="og:type" content="website">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="SI-PERFECT - Sistem Informasi Pelaporan">
	<meta name="twitter:description"
		content="Sistem Informasi Pelaporan Efektif, Cepat, dan Tepat untuk mendukung digitalisasi proses pelaporan.">
	<meta name="twitter:image" content="{{ asset('img/hero-right.webp') }}">

	<title>{{ config('app.name') }}</title>

	<!-- Styles / Scripts -->
	@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	@endif

	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}/img/logo-kendari.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}/img/logo-kendari.png" />

	<!-- AOS CSS -->
	<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="font-poppins antialiased text-gray-800 overflow-x-hidden">
	<!-- Navbar -->
	<header class="bg-primary text-white" data-aos="fade-down" data-aos-duration="800">
		<div class="container flex items-center justify-between py-3">
			@include('app-logo')
			<nav class="hidden md:flex space-x-8 text-[15px]">
				<a href="#" class="transition duration-300 hover:text-secondary">Beranda</a>
				<a href="#tentang" class="transition duration-300 hover:text-secondary">Tentang</a>
				<a href="#fitur" class="transition duration-300 hover:text-secondary">Fitur</a>
				<a href="#keunggulan" class="transition duration-300 hover:text-secondary">Keunggulan</a>
			</nav>
			<a href="{{ route('login') }}" class="btn-warning hidden lg:inline" data-aos="zoom-in" data-aos-delay="200">Masuk ke
				Aplikasi</a>
		</div>
	</header>

	<!-- Hero Section -->
	<section class="relative bg-gray-200">
		<img src="{{ asset('img/bg-hero.webp') }}" alt="Background"
			class="absolute inset-0 w-full h-full object-cover opacity-90">
		<div class="relative container py-10 lg:py-30 flex flex-col md:flex-row items-center">
			<div class="flex-1 space-y-6" data-aos="fade-right" data-aos-duration="1000">
				<h1 class="text-2xl md:text-5xl font-medium leading-tight">
					Solusi praktis <span class="font-bold">Pelaporan Modern</span>
				</h1>
				<p class="text-sm lg:text-lg">SI-PERFECT (Sistem Informasi Pelaporan Efektif, Cepat, dan Tepat)</p>
				<div class="space-x-1 lg:space-x-4">
					<a href="#tentang" class="btn-primary" data-aos="fade-up" data-aos-delay="200">Pelajari Lebih Lanjut</a>
					<a href="{{ route('login') }}" class="btn-warning" data-aos="fade-up" data-aos-delay="400">Masuk ke Aplikasi</a>
				</div>
			</div>
			<div class="flex-1 mt-10 md:mt-0 flex justify-center" data-aos="zoom-in" data-aos-duration="1000">
				<img src="{{ asset('img/hero-right.webp') }}" alt="Dashboard" class="w-[85%]">
			</div>
		</div>
	</section>

	<!-- Keunggulan -->
	<section class="bg-white py-8 lg:py-6">
		<div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-10">
			<div class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="100">
				<div>
					<h3 class="text-xl lg:text-[22px] font-bold text-primary">Efektif</h3>
					<p class="text-sm lg:text-base">Mengurangi pekerjaan manual yang berulang</p>
				</div>
				<img src="{{ asset('img/icon-1.svg') }}" alt="icon-1" class="ml-1 w-7 lg:w-10">
			</div>
			<div class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="300">
				<div>
					<h3 class="text-xl lg:text-[22px] font-bold text-primary">Cepat</h3>
					<p class="text-sm lg:text-base">Akses mudah melalui PC maupun smartphone</p>
				</div>
				<img src="{{ asset('img/icon-2.svg') }}" alt="icon-1" class="ml-1 w-7 lg:w-10">
			</div>
			<div class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="500">
				<div>
					<h3 class="text-xl lg:text-[22px] font-bold text-primary">Tepat</h3>
					<p class="text-sm lg:text-base">Data tersimpan aman dan akurat dalam basis data</p>
				</div>
				<img src="{{ asset('img/icon-3.svg') }}" alt="icon-1" class="ml-1 w-7 lg:w-10">
			</div>
		</div>
	</section>

	<!-- Tentang -->
	<section id="tentang" class="bg-primary text-white">
		<div class="container grid grid-cols-2 gap-8">
			<div class="py-14 lg:py-28 flex flex-col space-y-6 col-span-2 lg:col-span-1" data-aos="fade-right"
				data-aos-duration="1000">
				<h2 class="text-2xl lg:text-4xl font-bold text-secondary">Tentang</h2>
				<p class="leading-relaxed font-extralight text-sm lg:text-base"> SI-PERFECT adalah aplikasi pencatatan laporan
					berbasis web untuk mendukung
					Bagian Administrasi Pembangunan Setda Kota Kendari dalam digitalisasi proses pelaporan.</p>
				<p class="leading-relaxed font-extralight text-sm lg:text-base"> Dengan berbasis website, SI-PERFECT dapat diakses
					dengan mudah melalui
					komputer maupun smartphone, menyimpan data secara terpusat, dan menjaga konsistensi laporan. </p>
			</div>
			<div class="hidden lg:block relative col-span-2 lg:col-span-1" data-aos="zoom-in" data-aos-duration="1000">
				<div class="absolute bottom-0">
					<img src="{{ asset('img/walikota.webp') }}" alt="Wakil Kota Kendari" class="w-full">
				</div>
				<div class="absolute flex items-center gap-4 bottom-2.5 -translate-x-1/2 left-1/2">
					<button class="btn-warning text-center leading-4.5" data-aos="flip-up" data-aos-delay="200">
						<span class="text-nowrap font-semibold">dr. Hj. SISKA KARINA IMRAN, SKM</span>
						<span class="text-nowrap">Wali Kota Kendari</span>
					</button>
					<button class="btn-warning text-center leading-4.5" data-aos="flip-up" data-aos-delay="400">
						<span class="text-nowrap font-semibold">SUDIRMAN</span>
						<span class="text-nowrap">Wakil Wali Kota Kendari</span>
					</button>
				</div>
			</div>
		</div>
	</section>

	<!-- Solusi Input -->
	<section id="fitur" class="bg-gray-50">
		<div class="container">
			<div class="py-10 lg:py-13 grid grid-cols-2 gap-10 items-center">
				<div class="col-span-2 lg:col-span-1" data-aos="fade-right" data-aos-duration="1000">
					<h2 class="text-2xl lg:text-3xl">
						Solusi penginputan laporan yang <span class="text-primary font-semibold">Efektif, Cepat, dan Tepat</span>
					</h2>
					<p class="mt-4 text-sm lg:text-base text-gray-600">SI-PERFECT hadir sebagai solusi praktis pelaporan di era modern
						dengan aplikasi
						berbasis website.</p>
					<div class="mt-8">
						<div class="grid grid-cols-2 gap-7">
							<div class="col-span-3 lg:col-span-1" data-aos="fade-up" data-aos-delay="100">
								<div class="flex gap-3">
									<img class="size-8 lg:size-12" src="{{ asset('img/solusi-1.png') }}" alt="icon">
									<p class="font-medium text-sm lg:text-base">Tampilan sederhana dan professional</p>
								</div>
							</div>
							<div class="col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-delay="200">
								<div class="flex gap-3">
									<img class="size-8 lg:size-12" src="{{ asset('img/solusi-2.png') }}" alt="icon">
									<p class="font-medium text-sm lg:text-base">Laporan langsung tersimpan dan terdokumentasi</p>
								</div>
							</div>
							<div class="col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-delay="300">
								<div class="flex gap-3">
									<img class="size-8 lg:size-12" src="{{ asset('img/solusi-3.png') }}" alt="icon">
									<p class="font-medium text-sm lg:text-base">Akses mudah dari pc maupun smartphone</p>
								</div>
							</div>
							<div class="col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-delay="400">
								<div class="flex gap-3">
									<img class="size-8 lg:size-12" src="{{ asset('img/solusi-4.png') }}" alt="icon">
									<p class="font-medium text-sm lg:text-base">Data aman tersimpan di cloud</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-span-2 lg:col-span-1" data-aos="zoom-in" data-aos-duration="1000">
					<img src="{{ asset('img/solusi-right.webp') }}" alt="image">
				</div>
			</div>

			<!-- Input dengan mudah -->
			<div id="keunggulan" class="scroll-m-10 grid grid-cols-1 md:grid-cols-2 gap-8 mt-3 lg:mt-4 mb-20">
				<div class="bg-white p-8 shadow rounded text-center" data-aos="flip-left" data-aos-duration="1000">
					<h3 class="font-bold text-lg lg:text-xl text-primary">Input dengan Mudah</h3>
					<p class="mt-2 text-gray-600 text-sm lg:text-base">Form input sederhana dan user-friendly</p>
					<div class="mt-6">
						<img src="{{ asset('img/img-solusi-1.webp') }}" alt="img" class="rounded-3xl">
					</div>
				</div>
				<div class="bg-white p-8 shadow rounded text-center" data-aos="flip-right" data-aos-duration="1000">
					<h3 class="font-bold text-lg lg:text-xl text-primary">Output Cepat dan Tepat</h3>
					<p class="mt-2 text-gray-600 text-sm lg:text-base">Hasilkan output laporan dengan sekali klik</p>
					<div class="mt-6">
						<img src="{{ asset('img/img-solusi-2.webp') }}" alt="img" class="rounded-3xl">
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Login CTA -->
	<section class="bg-primary text-white">
		<div class="container">
			<div class="grid grid-cols-2 gap-0 lg:gap-24 items-center">
				<div class="col-span-2 lg:col-span-1">
					<img src="{{ asset('img/login-cta.webp') }}" alt="hp">
					<div class="bg-secondary w-full h-1"></div>
				</div>
				<div class="py-10 lg:py-0 col-span-2 lg:col-span-1">
					<h2 class="mb-3 text-3xl lg:text-5xl font-light leading-9 lg:leading-14">
						Login ke <br>
						<span class="text-secondary font-bold">SI-</span><span class="font-bold">PERFECT</span>
					</h2>
					<p class="mb-9 lg:mb-12 font-extralight">Sistem Informasi Pelaporan Efektif, Cepat, dan Tepat</p>
					<a href="{{ route('login') }}"class="btn-warning">
						Masuk ke Aplikasi
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="bg-white border-t py-6 text-xs lg:text-sm text-gray-600">
		<div class="container flex flex-col lg:flex-row items-center gap-6 lg:gap-24">
			@include('app-logo')
			<div>
				<p>Alamat : Jl. Drs. H. Abdullah Silondae No.8 Lantai 9, Gedung Menara Balai Kota
					Kendari Pondambea, Kec. Kadia,
					Kota Kendari, Sulawesi Tenggara 93111</p>
			</div>
			<div>
				<p>Copyright © 2025 All Rights Reserved</p>
			</div>
		</div>
	</footer>

	<!-- AOS JS -->
	<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
	<script>
		AOS.init({
			once: true,
			offset: 80,
			duration: 800,
		});
	</script>
</body>

</html>
