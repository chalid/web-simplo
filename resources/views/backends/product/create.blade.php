@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partials.css_form')
<div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <!-- Page header -->
        <div class="border-bottom pb-4 mb-4 ">
            <h3 class="mb-0 fw-bold">{{ $title }}</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <!-- card -->
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>
            <div class="card-body">
                <form class="row g-3 needs-validation" method="POST" action="{{ route('product.store') }}" novalidate enctype="multipart/form-data">
                    @csrf
                    <x-form.input name="title" label="Title name" :value="old('title')" :required="true" />
                    <x-form.textarea name="description" label="Deskripsi" :value="old('description')" />
                    <x-form.textarea name="feature" label="Fitur" :value="old('feature')" />
                    <x-form.textarea name="specification" label="Spesifikasi" :value="old('specification')" />
                    <div class="row mb-3">
                        <label for="product_category_id" class="col-sm-4 col-form-label">{{ __('Product Category') }}</label>
                        <div class="col-sm-8">
                            <select id="product_category_id" class="form-control select2" name="product_category_id">
                                <option value="">— Choose category —</option>
        
                                @foreach ($categories as $parent)
                                    {{-- show the parent ONLY as a header --}}
                                    @if($parent->children->count())
                                        <optgroup label="{{ $parent->title }}">
                                            @foreach ($parent->children as $child)
                                                <option value="{{ $child->id }}">{{ $child->title }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <x-form.select name="brand_id" label="Brand" :options="$brands" :selected="old('brand_id')" :required="true"/>
                    <div class="row mb-3">
                        <label for="brochure" class="col-sm-4 col-form-label">Brosur</label>
                        <div class="col-sm-8">
                            <input type="file" name="brochure" id="brochure" class="form-control"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-sm-4 col-form-label">{{ __('Product Image') }}</label>
                        <div class="col-sm-8">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <div class="form-text text-danger" id="basic-addon4">Size 1720px x 1143px.</div>
                        </div>
                    </div>
                    <x-form.input name="youtube_url" label="Youtube Url" :value="old('youtube_url')"/>
                    <x-form.select name="is_active" label="Is Active" :options="[1 => 'Active', 0 => 'In Active']" :selected="old('is_active')" :required="true"/>
                    <div class="col-12">
                        <a href="{{ route('product') }}" class="btn btn-danger">
                        <i data-feather="arrow-left" class="nav-icon me-2 icon-xs"></i>Kembali</a>
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('layouts.backend.partials.script_form')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        'use strict';

        /* ------------------------------------------------------------------
        BOOTSTRAP 5 custom validation
        ------------------------------------------------------------------ */
        document.querySelectorAll('.needs-validation').forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        /* ------------------------------------------------------------------
        CKEditor — shared config + loop
        ------------------------------------------------------------------ */
        const ckConfig = {
            // Remove every upload route
            removeDialogTabs : 'image:Upload;link:upload',
            removePlugins    : 'uploadimage,uploadfile,uploadwidget,uploadbrowser',
            language         : 'en-en',
            // Keep inline styles if you need them
            allowedContent   : true
        };

        ['description', 'feature', 'specification']   // ← make sure the IDs match!
            .forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    CKEDITOR.replace(el, ckConfig);
                }
            });

        /* ------------------------------------------------------------------
        Select2
        ------------------------------------------------------------------ */
        if (window.jQuery && $.fn.select2) {
            $('.select2').select2({
                placeholder : 'Choose category',
                allowClear  : true,
                theme: "bootstrap-5",
                width       : '100%'        // full‑width inside Bootstrap form‑control
            });
        } else {
            console.warn('Select2 or jQuery not found ‑‑ the Select2 widget was not initialised.');
        }
    });
</script>
@endpush