<div class="row mb-3">
	<label for="{{ $key }}" class="col-sm-2 col-form-label">{{ $label }}</label>
	<div class="col-sm-10">
		<textarea class="form-control" id="{{ $key }}" placeholder="{{ $placeholder ?? '' }}"
		 value="{{ old($key, $value ?? '') }}" @readonly($readonly ?? false) name="{{ $key }}">{{ old($key, $value ?? '') }}</textarea>
		@error($key)
			<div class="form-text text-danger">{{ $message }}</div>
		@enderror
	</div>
</div>
