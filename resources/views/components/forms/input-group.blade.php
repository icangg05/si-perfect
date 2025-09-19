<div class="row mb-3">
	<label for="{{ $key }}" class="col-sm-2 col-form-label">{{ $label }}</label>
	<div class="col-sm-10">
		<input type="{{ $type ?? 'text' }}" class="form-control" id="{{ $key }}" placeholder="{{ $placeholder ?? '' }}"
			value="{{ old("$key", $value ?? '') }}" name="{{ $key }}" @readonly($readonly ?? false)>
		@error($key)
			<div class="form-text text-danger">{{ $message }}</div>
		@enderror
	</div>
</div>
