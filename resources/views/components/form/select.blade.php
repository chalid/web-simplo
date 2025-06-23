{{-- resources/views/layouts/components/form/select.blade.php --}}
@props(['name', 'label', 'options', 'selected' => null, 'multiple' => false, 'class' => 'form-control', 'required' => false])

@php
    $selectedValues = collect(old($name, $selected))->all();
@endphp

<div class="row mb-3">
    <label for="{{ $name }}" class="col-sm-4 col-form-label">{{ $label }}</label>
    <div class="col-sm-8">
        <select name="{{ $name }}{{ $multiple ? '[]' : '' }}" id="{{ $name }}" class="{{ $class }}" {{ $multiple ? 'multiple' : '' }} {{ $required ? 'required' : '' }}>
            @foreach($options as $value => $text)
                <option value="{{ $value }}" @selected(in_array($value, $selectedValues))>
                    {{ $text }}
                </option>
            @endforeach
        </select>
    </div>
</div>