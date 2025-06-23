{{-- resources/views/layouts/components/form/radio.blade.php --}}
@props(['name', 'label', 'options', 'checked' => null, 'required' => false])

<div class="row mb-3">
    <label class="col-sm-4 col-form-label">{{ $label }}</label>
    <div class="col-sm-8">
        @foreach($options as $value => $text)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $name }}_{{ $value }}" value="{{ $value }}" @checked(old($name, $checked) == $value) {{ $required ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $name }}_{{ $value }}">{{ $text }}</label>
            </div>
        @endforeach
    </div>
</div>