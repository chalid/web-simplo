@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partials.css_form')
<div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <!-- Page header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h3 class="mb-0">{{ $title }}</h3>
            <a href="{{ route('user') }}" class="btn btn-danger">
                <i data-feather="arrow-left" class="nav-icon me-2 icon-xs"></i> Back
            </a>
        </div>
    </div>
</div>
<div class="row">
    <!-- start edit username & email -->
    <div class="col-lg-6 mb-5">
        <!-- card -->
        <div class="card h-100">
            <!-- card body -->
            <!-- card header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ __('Edit Name & Email') }}</h3>
            </div>
            <!-- row -->
            <!-- table -->
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <x-form.input name="name" label="Name" :value="$user->name" :required="true" />
                    <x-form.email name="email" label="Email" :value="$user->email" :required="true"/>
                    <div class="col-12">
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit username & password -->
    <!-- start edit user password -->
    <div class="col-lg-6 mb-5">
        <!-- card -->
        <div class="card h-100">
            <!-- card body -->
            <!-- card header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ __('Edit User password') }}</h3>
            </div>
            <!-- row -->
            <!-- table -->
            <div class="card-body">
                <form action="{{ route('user.update_password', $user->id) }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <x-form.password name="current_password" label="Current Password" :required="true"/>
                    <x-form.password name="password" label="New Password" :required="true"/>
                    <x-form.password name="password_confirmation" label="Retype Password" :required="true"/>
                    <div class="col-12">
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit user password -->
    <!-- start edit user avatar -->
    <div class="col-lg-6 mb-5">
        <!-- card -->
        <div class="card h-100">
            <!-- card body -->
            <!-- card header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ __('Edit User role') }}</h3>
            </div>
            <!-- row -->
            <!-- table -->
            <div class="card-body">
                <form action="{{ route('user.update_role', $user->id) }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <x-form.select name="role" label="role" :options="$roles" :selected="$user->getRoleNames() ?? []" multiple :required="true"/>
                    <div class="col-12">
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit user avatar -->
</div>
@endsection
@push('scripts')
@include('layouts.backend.partials.script_form')
<script>
    $('.role').select2();
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
