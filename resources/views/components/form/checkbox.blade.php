{{-- resources/views/layouts/components/form/checkbox.blade.php --}}
@props(['name', 'label', 'options', 'checked' => [], 'required' => false])

<div class="row mb-3">
    <label class="col-sm-4 col-form-label">{{ $label }}</label>
    <div class="col-sm-8">
        @foreach($options as $value => $text)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $name }}[]" id="{{ $name }}_{{ $value }}" value="{{ $value }}" @checked(collect(old($name, $checked))->contains($value)) {{ $required ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $name }}_{{ $value }}">{{ $text }}</label>
            </div>
        @endforeach
    </div>
</div>