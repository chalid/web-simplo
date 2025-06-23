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
<div class="modal fade" id="addSysparam" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addSysparamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addSysparamLabel">Anda ingin menambah data?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sysparam.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="sgroup" class="col-sm-4 col-form-label">sgroup</label>
                        <div class="col-sm-8">
                            <input type="text" name="sgroup" class="form-control" id="sgroup" value="" required>
                            <div class="invalid-feedback">Harap isi sgroup</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="skey" class="col-sm-4 col-form-label">skey</label>
                        <div class="col-sm-8">
                            <input type="text" name="skey" class="form-control" id="skey" value="" required>
                            <div class="invalid-feedback">Harap isi skey</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="svalue" class="col-sm-4 col-form-label">svalue</label>
                        <div class="col-sm-8">
                            <input type="text" name="svalue" class="form-control" id="svalue" value="" required>
                            <div class="invalid-feedback">Harap isi svalue</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lvalue" class="col-sm-4 col-form-label">lvalue</label>
                        <div class="col-sm-8">
                            <input type="text" name="lvalue" class="form-control" id="lvalue" value="">
                        </div>
                    </div>
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
                    <table class="table table-bordered table-hover table-striped sysparam">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sgroup</th>
                                <th>Skey</th>
                                <th>Svalue</th>
                                <th>Lvalue</th>
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
    $(function() {
        var t = $('.sysparam').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route($routeAjax) }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'sgroup', name: 'sgroup', orderable:true, searchable: true},
                {data: 'skey', name: 'skey', orderable:true, searchable: true},
                {data: 'svalue', name: 'svalue', orderable:true, searchable: true},
                {data: 'lvalue', name: 'lvalue', orderable:false, searchable: false},
                {data: 'action'},
            ],
            "drawCallback": function(settings) {
            },
            pageLength: 10,
        });

        // Check permission before initializing DataTable Buttons
        checkPermission('Can add sysparam', function(hasPermission) {
            if (hasPermission || isSuperAdmin()) {
                // Add the "Tambah Data" button if the user has permission or is a Super Admin
                new DataTable.Buttons(t, {
                    buttons: [
                        {
                            text: 'Tambah Data',
                            action: function (e, dt, node, config) {
                                $('#addSysparam').modal('show');
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
