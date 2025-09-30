<!DOCTYPE html>
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

	<!-- Styles -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
		rel="stylesheet">
	<link
		href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
		rel="stylesheet">
	<link href="{{ asset('') }}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ asset('') }}/assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
	<link href="{{ asset('') }}/assets/plugins/pace/pace.css" rel="stylesheet">


	<!-- Theme Styles -->
	<link href="{{ asset('') }}/assets/css/main.min.css" rel="stylesheet">
	<link href="{{ asset('') }}/assets/css/horizontal-menu/horizontal-menu.css" rel="stylesheet">
	<link href="{{ asset('') }}/assets/css/custom.css" rel="stylesheet">

	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}/img/logo-kendari.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}/img/logo-kendari.png" />

	<!-- AOS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
	<div class="app horizontal-menu app-error align-content-stretch d-flex flex-wrap">
		<div class="app-error-info" data-aos="fade-up" data-aos-duration="1000">
			<h5> Oops! {{ $exception->getStatusCode() ?? '500' }}</h5>
			<span>{{ $exception->getMessage() ?: 'Terjadi kesalahan pada sistem. Kami akan segera memperbaikinya.' }}</span>
			<a href="{{ Auth::check() ? route('dashboard') : route('beranda') }}" class="btn btn-dark" data-aos="zoom-in"
				data-aos-delay="200"> {{ Auth::check() ? 'Go to Dashboard' : 'Go to Home' }} </a>
		</div>
		<div class="app-error-background" data-aos="fade-in" data-aos-delay="500"></div>
	</div>

	<!-- Javascripts -->
	<script src="{{ asset('') }}/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/pace/pace.min.js"></script>
	<script src="{{ asset('') }}/assets/js/main.min.js"></script>
	<script src="{{ asset('') }}/assets/js/custom.js"></script>

	<!-- AOS Init -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>
</body>

</html>
