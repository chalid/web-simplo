{{-- resources/views/layouts/components/form/file.blade.php --}}
@props(['name', 'label', 'class' => 'form-control', 'required' => false, 'accept'])

<div class="row mb-3">
    <label for="{{ $name }}" class="col-sm-4 col-form-label">{{ $label }}</label>
    <div class="col-sm-8">
        <input type="file" name="{{ $name }}" id="{{ $name }}" class="{{ $class }}" accept="{{ $accept ?? 'image/*' }}" {{ $required ? 'required' : '' }}>
    </div>
</div>