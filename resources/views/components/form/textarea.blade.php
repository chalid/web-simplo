{{-- resources/views/layouts/components/form/textarea.blade.php --}}
@props([
    'name',
    'label',
    'value' => '',
    'class' => 'form-control',
    'required' => false,
    'rich' => false // new prop
])

<div class="row mb-3">
    <label for="{{ $name }}" class="col-sm-4 col-form-label">{{ $label }}</label>
    <div class="col-sm-8">
        <textarea 
            name="{{ $name }}" 
            id="{{ $name }}" 
            class="{{ $class }} {{ $rich ? 'ckeditor' : '' }}" 
            {{ $required ? 'required' : '' }}
        >{!! old($name, $value) !!}</textarea>
    </div>
</div>
