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
            <div class="card-header">{{ __('Ganti Kata Sandi') }}</div>
            <div class="card-body">
                <form class="row g-3 needs-validation" method="POST" action="{{ route('home.update_password') }}" novalidate>
                    @csrf
                    @method('PATCH')
                    <x-form.password name="current_password" label="Kata Sandi Sekarang" :value="old('current_password')" :required="true"/>
                    <x-form.password name="password" label="Kata Sandi Baru" :value="old('password')" :required="true"/>
                    <x-form.password name="password_confirmation" label="Ulangi Kata Sandi Baru" :value="old('password_confirmation')" :required="true"/>
                    <div class="col-12">
                        <a href="{{ route('home') }}" class="btn btn btn-outline-danger">
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
