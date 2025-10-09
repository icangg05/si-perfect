<x-layouts.auth>
	<form action="{{ route('authenticate') }}" method="post">
		@csrf
		<p class="auth-description">
			Silakan masukkan username dan password pada form di bawah ini untuk melanjutkan.
		</p>

		<div class="auth-credentials m-b-xxl">
			<label for="username" class="form-label">Username</label>
			<input type="text" class="form-control m-b-md" id="username" aria-describedby="username"
				placeholder="Username" value="{{ old('username') }}" name="username" autofocus>
			@error('username')
				<p class="text-danger" style="margin-top: -12px; font-size: .85rem">{{ $message }}</p>
			@enderror

			<label for="password" class="form-label">Password</label>
			<div class="position-relative">
				<input type="password" class="form-control pe-5" id="password" aria-describedby="password"
					placeholder="Password" name="password" autocomplete="off">
				<span id="togglePassword"
					class="material-icons position-absolute end-0 top-50 translate-middle-y me-3"
					style="cursor: pointer; color: #6c757d; font-size: 1.5rem">visibility_off</span>
			</div>
			@error('password')
				<p class="text-danger" style="margin-top: 8px; font-size: .85rem">{{ $message }}</p>
			@enderror
		</div>

		<div class="auth-submit">
			<button type="submit" class="btn btn-primary">Login</button>
			{{-- <a href="#" class="auth-forgot-password float-end">Forgot password?</a> --}}
		</div>
		<div class="divider"></div>
		<div class="auth-alts">
			{{-- <a href="#" class="auth-alts-google"></a>
		<a href="#" class="auth-alts-facebook"></a>
		<a href="#" class="auth-alts-twitter"></a> --}}
			<p class="auth-description text-center">2025 © Bagian Administrasi Pembangunan Setda Kota Kendari</p>
		</div>
	</form>

	@push('script')
		<script>
			$(document).ready(function() {
				$('#togglePassword').on('click', function() {
					const passwordField = $('#password');
					const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
					passwordField.attr('type', type);

					// Ganti ikon
					const icon = $(this);
					icon.text(type === 'password' ? 'visibility_off' : 'visibility');
				});
			});
		</script>
	@endpush
</x-layouts.auth>
