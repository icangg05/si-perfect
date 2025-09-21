<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="SI PERFECT">
	<meta name="keywords" content="siperfect,si-perfect,pelaporan">
	<meta name="author" content="ilmifaizan">
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title -->
	<title>Dashboard - {{ config('app.name') }}</title>


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

	{{-- Custon fonts --}}
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap"
		rel="stylesheet">

	<!-- Theme Styles -->
	<link href="{{ asset('') }}/assets/css/main.css" rel="stylesheet">
	<link href="{{ asset('') }}/assets/css/horizontal-menu/horizontal-menu.css" rel="stylesheet">
	<link href="{{ asset('') }}/assets/css/custom.css" rel="stylesheet">

	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}/assets/images/neptune.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}/assets/images/neptune.png" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
				<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
				<![endif]-->
</head>

<body>
	@include('sweetalert::alert')

	<div class="app horizontal-menu align-content-stretch d-flex flex-wrap">
		<div class="app-container">
			<div class="search container">
				<form>
					<input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
				</form>
				<a href="#" class="toggle-search"><i class="material-icons">close</i></a>
			</div>
			<div class="app-header">
				<nav class="navbar navbar-light navbar-expand-lg container">
					<div class="container-fluid">
						<div class="navbar-nav" id="navbarNav">
							<div class="logo">
								<a href="index.html">Neptune</a>
							</div>
							<ul class="navbar-nav">
								<li class="nav-item">
									<a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">last_page</i></a>
								</li>
								<li class="nav-item dropdown hidden-on-mobile">
									<a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button"
										data-bs-toggle="dropdown" aria-expanded="false">
										<i class="material-icons">add</i>
									</a>
									<ul class="dropdown-menu" aria-labelledby="addDropdownLink">
										<li><a class="dropdown-item" href="#">New Workspace</a></li>
										<li><a class="dropdown-item" href="#">New Board</a></li>
										<li><a class="dropdown-item" href="#">Create Project</a></li>
									</ul>
								</li>
								<li class="nav-item dropdown hidden-on-mobile">
									<a class="nav-link dropdown-toggle" href="#" id="exploreDropdownLink" role="button"
										data-bs-toggle="dropdown" aria-expanded="false">
										<i class="material-icons-outlined">explore</i>
									</a>
									<ul class="dropdown-menu dropdown-lg large-items-menu" aria-labelledby="exploreDropdownLink">
										<li>
											<h6 class="dropdown-header">Repositories</h6>
										</li>
										<li>
											<a class="dropdown-item" href="#">
												<h5 class="dropdown-item-title">
													Neptune iOS
													<span class="badge badge-warning">1.0.2</span>
													<span class="hidden-helper-text">switch<i class="material-icons">keyboard_arrow_right</i></span>
												</h5>
												<span class="dropdown-item-description">Lorem Ipsum is simply dummy text of the printing and typesetting
													industry.</span>
											</a>
										</li>
										<li>
											<a class="dropdown-item" href="#">
												<h5 class="dropdown-item-title">
													Neptune Android
													<span class="badge badge-info">dev</span>
													<span class="hidden-helper-text">switch<i class="material-icons">keyboard_arrow_right</i></span>
												</h5>
												<span class="dropdown-item-description">Lorem Ipsum is simply dummy text of the printing and typesetting
													industry.</span>
											</a>
										</li>
										<li class="dropdown-btn-item d-grid">
											<button class="btn btn-primary">Create new repository</button>
										</li>
									</ul>
								</li>
							</ul>

						</div>
						<div class="d-flex">
							<ul class="navbar-nav">
								<li class="nav-item hidden-on-mobile">
									<a class="nav-link active" href="#">Applications</a>
								</li>
								<li class="nav-item hidden-on-mobile">
									<a class="nav-link" href="#">Reports</a>
								</li>
								<li class="nav-item hidden-on-mobile">
									<a class="nav-link" href="#">Projects</a>
								</li>
								<li class="nav-item">
									<a class="nav-link toggle-search" href="#"><i class="material-icons">search</i></a>
								</li>
								<li class="nav-item hidden-on-mobile">
									<a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown"
										data-bs-toggle="dropdown"><img src="../../assets/images/flags/us.png" alt=""></a>
									<ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
										<li><a class="dropdown-item" href="#"><img src="../../assets/images/flags/germany.png"
													alt="">German</a></li>
										<li><a class="dropdown-item" href="#"><img src="../../assets/images/flags/italy.png"
													alt="">Italian</a></li>
										<li><a class="dropdown-item" href="#"><img src="../../assets/images/flags/china.png"
													alt="">Chinese</a></li>
									</ul>
								</li>
								{{-- <li class="nav-item hidden-on-mobile">
									<a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#"
										data-bs-toggle="dropdown">4</a>
									<div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
										<h6 class="dropdown-header">Notifications</h6>
										<div class="notifications-dropdown-list">
											<a href="#">
												<div class="notifications-dropdown-item">
													<div class="notifications-dropdown-item-image">
														<span class="notifications-badge bg-info text-white">
															<i class="material-icons-outlined">campaign</i>
														</span>
													</div>
													<div class="notifications-dropdown-item-text">
														<p class="bold-notifications-text">Donec tempus nisi sed erat vestibulum, eu suscipit ex laoreet</p>
														<small>19:00</small>
													</div>
												</div>
											</a>
											<a href="#">
												<div class="notifications-dropdown-item">
													<div class="notifications-dropdown-item-image">
														<span class="notifications-badge bg-danger text-white">
															<i class="material-icons-outlined">bolt</i>
														</span>
													</div>
													<div class="notifications-dropdown-item-text">
														<p class="bold-notifications-text">Quisque ligula dui, tincidunt nec pharetra eu, fringilla quis mauris
														</p>
														<small>18:00</small>
													</div>
												</div>
											</a>
											<a href="#">
												<div class="notifications-dropdown-item">
													<div class="notifications-dropdown-item-image">
														<span class="notifications-badge bg-success text-white">
															<i class="material-icons-outlined">alternate_email</i>
														</span>
													</div>
													<div class="notifications-dropdown-item-text">
														<p>Nulla id libero mattis justo euismod congue in et metus</p>
														<small>yesterday</small>
													</div>
												</div>
											</a>
											<a href="#">
												<div class="notifications-dropdown-item">
													<div class="notifications-dropdown-item-image">
														<span class="notifications-badge">
															<img src="../../assets/images/avatars/avatar.png" alt="">
														</span>
													</div>
													<div class="notifications-dropdown-item-text">
														<p>Praesent sodales lobortis velit ac pellentesque</p>
														<small>yesterday</small>
													</div>
												</div>
											</a>
											<a href="#">
												<div class="notifications-dropdown-item">
													<div class="notifications-dropdown-item-image">
														<span class="notifications-badge">
															<img src="../../assets/images/avatars/avatar.png" alt="">
														</span>
													</div>
													<div class="notifications-dropdown-item-text">
														<p>Praesent lacinia ante eget tristique mattis. Nam sollicitudin velit sit amet auctor porta</p>
														<small>yesterday</small>
													</div>
												</div>
											</a>
										</div>
									</div>
								</li> --}}
							</ul>
						</div>
					</div>
				</nav>
			</div>

			<div class="app-menu">
				<div class="container">
					<ul class="menu-list">
						<li>
							<a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>
								<i class="material-icons size-icon-nav">dashboard</i> Dashboard</a>
						</li>
						<li>
							<a href="{{ route('dashboard.laporan-realisasi') }}" @class(['active' => request()->is('laporan-realisasi*')])>
								<i class="material-icons size-icon-nav">summarize</i> Laporan Realisasi</a>
						</li>
						<li>
							<a href="{{ route('dashboard.pengaturan') }}" @class(['active' => request()->routeIs('dashboard.pengaturan')])>
								<i class="material-icons size-icon-nav">settings</i> Pengaturan</a>
						</li>

						@if (auth()->user()->role == 'admin')
							<li>
								<a href="#">
									<i class="material-icons size-icon-nav">dataset</i> Master Data<i
										class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
								<ul class="sub-menu">
									<li>
										<a href="mailbox.html">Mailbox<span class="badge rounded-pill badge-danger float-end">87</span></a>
									</li>
									<li>
										<a href="file-manager.html">File Manager</a>
									</li>
									<li>
										<a href="calendar.html">Calendar<span class="badge rounded-pill badge-success float-end">14</span></a>
									</li>
									<li>
										<a href="todo.html">Todo</a>
									</li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
			<div class="app-content">
				<div class="content-wrapper">
					<div class="container">
						{{ $slot }}
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Javascripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

	<script src="{{ asset('') }}/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/pace/pace.min.js"></script>
	<script src="{{ asset('') }}/assets/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="{{ asset('') }}/assets/js/main.min.js"></script>
	<script src="{{ asset('') }}/assets/js/custom.js"></script>
	<script src="{{ asset('') }}/assets/js/pages/dashboard.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
