<x-layouts.auth>
	<form action="{{ route('authenticate') }}" method="post">
		@csrf
		<p class="auth-description">Please sign-in to your account and continue to the dashboard.<br>Don't have an account?
			<a href="sign-up.html">Sign Up</a>
		</p>

		<div class="auth-credentials m-b-xxl">
			<label for="username" class="form-label">Username</label>
			<input type="text" class="form-control m-b-md" id="username" aria-describedby="username"
				placeholder="Username" value="{{ old('username') }}" name="username" autofocus>
			@error('username')
				<p class="text-danger" style="margin-top: -12px; font-size: .85rem">{{ $message }}</p>
			@enderror

			<label for="password" class="form-label">Password</label>
			<input type="password" class="form-control" id="password" aria-describedby="password"
				placeholder="Passowrd" name="password">
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
</x-layouts.auth>
