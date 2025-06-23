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
                <form action="{{ route('permission.update', $permission->id) }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PATCH')
                    <x-form.select name="parent_id" label="Parent" :options="$permissionList" :selected="$permission->parent_id ?? ''" :required="true"/>
                    <x-form.input name="name" label="Permission name" :value="$permission->name" :required="true" />
                    <x-form.select name="guard_name" label="Guard" :options="['web' => 'WEB', 'api' => 'API']" :selected="$permission->guard_name ?? ''" :required="true"/>
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
@include('layouts.backend.partials.script_form')
<script>
    $(document).ready(function() {
        $("#parent_id").select2({
            theme: "bootstrap-5",
        });
    });
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
