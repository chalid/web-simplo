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
                <form action="{{ route('study-case.update', $studyCase->id) }}" method="POST" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <x-form.input name="title" label="Title name" :value="$studyCase->title" :required="true" />
                    <x-form.textarea name="description" label="Description" :value="old('description', $studyCase->description)"  :rich="true" />
                    <div class="row mb-3">
                        <label for="image" class="col-sm-4 col-form-label">{{ __('Study Case Banner') }}</label>
                        <div class="col-sm-8">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <div class="form-text text-danger" id="basic-addon4">Size 1074px x 805px.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="images" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <img src="{{ url('storage/upload_files/images/study_case_banner/small-thumb/' . $studyCase->image) }}" alt="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="icon" class="col-sm-4 col-form-label">{{ __('Study Case Icon') }}</label>
                        <div class="col-sm-8">
                            <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
                            <div class="form-text text-danger" id="basic-addon4">Size 22px x 18px.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="images" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <img src="{{ url('storage/upload_files/images/study_case_icon/ori/' . $studyCase->icon) }}" alt="">
                        </div>
                    </div>
                    <x-form.input name="uri" label="Link" :value="$studyCase->uri"/>
                    <x-form.select name="is_active" label="Is Active" :options="[1 => 'Active', 0 => 'In Active']" :selected="$studyCase->is_active ?? ''" :required="true"/>
                    <div class="col-12">
                        <a href="{{ route('study-case') }}" class="btn btn-danger">
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

    // Dynamically apply CKEditor to textareas with class "ckeditor"
    document.querySelectorAll('textarea.ckeditor').forEach(function (textarea) {
        if (!textarea.id) return; // CKEditor needs an ID
        CKEDITOR.replace(textarea.id, {
            // Disable upload tabs from dialogs
            removeDialogTabs: 'image:Upload;link:upload',

            // Remove upload plugins completely
            removePlugins: 'uploadimage,uploadfile,uploadwidget,uploadbrowser',

            // Optional: Remove toolbar buttons if you want to hide image tools entirely
            // toolbar: [
            //     ['Bold', 'Italic', 'Underline', 'Link', 'Unlink', 'NumberedList', 'BulletedList'] // No image button
            // ],

            // Keep the rest of your config
            language: 'en-en'
        });
    });

    CKEDITOR.config.allowedContent = true;
</script>
@endpush
