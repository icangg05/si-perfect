<div class="row mb-3">
	<label for="{{ $key }}" class="col-sm-2 col-form-label">{{ $label }}</label>
	<div class="col-sm-10">
		<select id="{{ $key }}" class="form-select" name="{{ $key }}">
			<option value="">{{ $placeholder ?? 'Pilih' }}...</option>
			@foreach ($data as $item)
				<option @selected(($value ?? '') == $item['value']) value="{{ $item['value'] }}">{{ $item['label'] }}</option>
			@endforeach
		</select>
		@error($key)
			<div class="form-text text-danger">{{ $message }}</div>
		@enderror
	</div>
</div>
