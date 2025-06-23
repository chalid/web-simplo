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
                <form action="{{ route('client.update', $client->id) }}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PATCH')
                    <x-form.input name="name" label="Client Name" :value="$client->name" :required="true" />
                    <x-form.input name="phone" label="Phone" :value="$client->phone" :required="true" />
                    <x-form.input name="email" label="email" :value="$client->email" :required="true" />
                    <x-form.select name="is_active" label="Is Active" :options="[1 => 'Active', 0 => 'In Active']" :selected="$client->is_active ?? ''" :required="true"/>
                    <x-form.file name="image" label="Client Image" />
                    <div class="col-12">
                        <a href="{{ route('client') }}" class="btn btn-danger">
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
