<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Admin Dashboard Template">
	<meta name="keywords" content="admin,dashboard">
	<meta name="author" content="stacks">
	<!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title -->
	<title>Login - {{ config('app.name') }}</title>

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

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
				<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
				<![endif]-->
</head>

<body>
	<div class="app horizontal-menu app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
		<div class="app-auth-background">
		</div>
		<div class="app-auth-container">
			<a href="{{ route('beranda') }}" class="d-flex align-items-center gap-2"
				style="text-decoration: none; color: rgb(58, 58, 58); font-weight: bold; font-size: 2rem">
				<img src="{{ asset('img/logo-kendari.png') }}" alt="logo" style="width: 70px">
				<p style="margin-top: 15px">
					<span style="color: #F4AB1E">SI-</span>PERFECT
				</p>
			</a>
			{{ $slot }}
		</div>
	</div>

	<!-- Javascripts -->
	<script src="{{ asset('') }}/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/pace/pace.min.js"></script>
	<script src="{{ asset('') }}/assets/js/main.min.js"></script>
	<script src="{{ asset('') }}/assets/js/custom.js"></script>
  @stack('script')
</body>

</html>
