{{-- resources/views/layouts/components/form/datetime.blade.php --}}
@props(['name', 'label', 'value' => '', 'class' => 'form-control', 'required' => false])

<div class="row mb-3">
    <label for="{{ $name }}" class="col-sm-4 col-form-label">{{ $label }}</label>
    <div class="col-sm-8">
        <input type="datetime-local" name="{{ $name }}" id="{{ $name }}" class="{{ $class }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}>
    </div>
</div>