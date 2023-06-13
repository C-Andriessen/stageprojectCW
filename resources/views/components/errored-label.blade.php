@props(['value', 'field'])

<label {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ $value ?? $slot }}
    @error($field)
    <span class="text-danger">
        {{ $message }}
    </span>
    @enderror
</label>