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
                <form action="{{ route('product.update', $product->id) }}" method="POST" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <x-form.input name="title" label="Title name" :value="$product->title" :required="true" />
                    <x-form.textarea name="description" label="Description" :value="old('description', $product->description)" :rich="true"/>
                    <x-form.textarea name="feature" label="Fitur" :value="old('feature', $product->description)" :rich="true"/>
                    <x-form.textarea name="specification" label="Spesifikasi" :value="old('specification', $product->description)" :rich="true"/>
                    <div class="row mb-3">
                        <label for="product_category_id" class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8">
                            <select id="product_category_id"
                                    name="product_category_id"
                                    class="form-control select2">
                                <option value="">— Choose category —</option>
                                @foreach($categories as $parent)
                                    @if($parent->children->isNotEmpty())
                                        {{-- Parent WITH kids → header --}}
                                        <optgroup label="{{ $parent->title }}">
                                            @foreach($parent->children as $child)
                                                <option value="{{ $child->id }}"
                                                        @selected(old('product_category_id', $product->product_category_id) == $child->id)>
                                                    {{ $child->title }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        {{-- Parent WITHOUT kids → selectable --}}
                                        <option value="{{ $parent->id }}"
                                                @selected(old('product_category_id', $product->product_category_id) == $parent->id)>
                                            {{ $parent->title }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <x-form.select name="brand_id" label="Brand" :options="$brands" :selected="$product->brand_id ?? ''" :required="true"/>
                    <div class="row mb-3">
                        <label for="brochure" class="col-sm-4 col-form-label">Brosur</label>
                        <div class="col-sm-8">
                            <input type="file" name="brochure" id="brochure" class="form-control"/>
                        </div>
                    </div>
                    @if($product->brochure)
                    <div class="row mb-3">
                        <label for="brochure" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <a href="{{ url('storage/upload_files/documents/product/ori/' . $product->brochure) }}"><i class="bi bi-file-earmark-pdf-fill text-danger"></i></a>
                        </div>
                    </div>
                    @endif
                    <x-form.file name="image" label="Product Picture" />
                    <div class="row mb-3">
                        <label for="images" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <img src="{{ url('storage/upload_files/images/product/small-thumb/' . $product->image) }}" alt="">
                        </div>
                    </div>
                    <x-form.select name="is_active" label="Is Active" :options="[1 => 'Active', 0 => 'In Active']" :selected="$product->is_active ?? ''" :required="true"/>
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
