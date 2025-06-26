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
                <form class="row g-3 needs-validation" method="POST" action="{{ route('about.store') }}" novalidate enctype="multipart/form-data">
                    @csrf
                    <x-form.input name="title" label="Title name" :value="old('title')" :required="true" />
                    <x-form.textarea name="description" label="Description" :value="old('description')" />
                    <x-form.textarea name="vision" label="Vision" :value="old('vision')" />
                    <x-form.textarea name="mission" label="Mission" :value="old('mission')" />
                    <x-form.textarea name="history" label="History" :value="old('history')" />
                    <x-form.select name="is_active" label="Is Active" :options="[1 => 'Active', 0 => 'In Active']" :selected="old('is_active')" :required="true"/>
                    <x-form.file name="image" label="About Image" />
                    <div class="col-12">
                        <a href="{{ route('about') }}" class="btn btn-danger">
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
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
        })
    })();

    const ckConfig = {
        removeDialogTabs: 'image:Upload;link:upload',
        removePlugins: 'uploadimage,uploadfile,uploadwidget,uploadbrowser',
        language: 'en-en',
    };

    CKEDITOR.config.allowedContent = true;

    const names = ['description', 'vision', 'mission', 'history'];

    names.forEach(name => {
        const el = document.querySelector(`textarea[name="${name}"]`);
        if (el && !CKEDITOR.instances[el.name]) {
            CKEDITOR.replace(el.name, ckConfig);
        }
    });
</script>
@endpush
