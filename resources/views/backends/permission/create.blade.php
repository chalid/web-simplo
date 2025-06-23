@extends('layouts.app')
@section('content')
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
            <div class="card-header">{{ $title }}</div>
            <div class="card-body">
                <form class="row g-3 needs-validation" method="POST" action="{{ route('permission.store') }}" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <label for="parent" class="col-sm-2 col-form-label">Parent</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="parent_id" id="parent">
                                @foreach($permissionList as $item)
                                    <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '-- Silahkan Pilih --' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Permission name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="guard_name" class="col-sm-2 col-form-label">Guard</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="guard_name" id="guard_name" required>
                                <option value="">-- Silahkan Pilih --</option>
                                <option value="web">{{ 'WEB' }}</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid state.
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('permission') }}" class="btn btn-danger">
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
