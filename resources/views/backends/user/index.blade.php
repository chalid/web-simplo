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
<!-- Modal -->
<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUserLabel">Anda ingin menambah data?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <x-form.input name="name" label="Name" :required="true" />
                    <x-form.email name="email" label="Email" :required="true"/>
                    <x-form.password name="password" label="Password" :required="true"/>
                    <x-form.select name="role" label="role" :options="$roles" :selected="$selectedRoles ?? []" multiple :required="true"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <!-- card -->
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped users">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('layouts.backend.partials.script_form')
<script>
    $(document).ready(function() {
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('#role').select2({
                theme: "bootstrap-5",
                dropdownParent: $(this)  // Use the current modal as the dropdown parent
            });
        });
    });
    $(function() {
        $('.js-example-basic-multiple').select2();
        var t = $('.users').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route($routeAjax) }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name', orderable:true, searchable: true},
                {data: 'email', name: 'email', orderable:true, searchable: true},
                { data: 'roles', name: 'roles.name', orderable: false, searchable: false },
                {data: 'action'},
            ],
            "drawCallback": function(settings) {
            },
            pageLength: 10,
        });

        // Check permission before initializing DataTable Buttons
        checkPermission('Can add user', function(hasPermission) {
            if (hasPermission || isSuperAdmin()) {
                // Add the "Tambah Data" button if the user has permission or is a Super Admin
                new DataTable.Buttons(t, {
                    buttons: [
                        {
                            text: 'Tambah Data',
                            action: function (e, dt, node, config) {
                                $('#addUser').modal('show');
                            }
                        }
                    ]
                });
            } else {
                // Remove the button if the user doesn't have permission and is not a Super Admin
                $('.dt-buttons').hide();
            }
            // Move the buttons container after checking permission
            t.buttons(0, null).container().prependTo(t.table().container());
        });
    });
</script>
@include('layouts.backend.partials.script_form_index')
@endpush