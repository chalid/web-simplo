{{-- resources/views/layouts/components/form/password.blade.php --}}
@props(['name', 'label', 'class' => 'form-control', 'required' => false])

<div class="row mb-3">
    <label for="{{ $name }}" class="col-sm-4 col-form-label">{{ $label }}</label>
    <div class="col-sm-8">
        <input type="password" name="{{ $name }}" id="{{ $name }}" class="{{ $class }}" {{ $required ? 'required' : '' }}>
    </div>
</div>