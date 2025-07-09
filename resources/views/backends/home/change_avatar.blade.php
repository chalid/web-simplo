@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partials.css_form')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/dashui/libs/bootstrap-icons/font/bootstrap-icons.css') }}">
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
            <div class="card-header">{{ __('Ganti Foto') }}</div>
            <div class="card-body">
                <form class="row g-3 needs-validation" method="POST" action="{{ route('home.update_avatar') }}" novalidate files="true" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="col-sm-4 text-center">
                            @if(Auth::user()->avatar)
                                <img alt="avatar" src="{{ asset('storage/upload_files/images/avatar/avatar/' . Auth::user()->avatar) }}">
                            @else
                                <img src="{{ asset('assets/backend/images/png/no_image.png') }}" class="rounded" alt="..." width="100px">
                            @endif
                        </div>
                        <div class="col-sm-8">
                            <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*" capture="environment">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" charset="utf8" src="{{ asset('assets/helper/js/resize_image.js') }}"></script>
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
</script>
@endpush
