@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partials.css_form')
<style>
    td.details-control {
        background: url('../assets/backend/images/icons/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../assets/backend/images/icons/details_close.png') no-repeat center center;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <!-- Page header -->
        <div class="border-bottom pb-4 mb-4 ">
            <h3 class="mb-0 fw-bold">{{ $title }}</h3>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPermissionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addPermissionLabel">Anda ingin menambah data?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('permission.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <x-form.select name="parent_id" label="Parent" :options="$permission" />
                    <x-form.input name="name" label="Permission name" :required="true" />
                    <x-form.select name="guard_name" label="Guard" :options="['web' => 'WEB', 'api' => 'API']" :required="true" />
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
                    <table class="table table-bordered table-hover table-striped user">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama</th>
                                <th>Guard</th>
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
            $(this).find('#parent_id').select2({
                theme: "bootstrap-5",
                dropdownParent: $(this)  // Use the current modal as the dropdown parent
            });
        });
    });
    $(function() {
        function format ( d ) {
            // `d` is the original data object for the row
            // var htmlShow = '<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" style="padding-left:50px;">';
            var htmlShow = '';
            $.each(d.children, function(i, item) {
                htmlShow += '<tr>' +
                    '<td>&nbsp;</td>' +
                    '<td>' + item.name + '</td>' +
                    '<td>' + item.guard_name + '</td>' +
                    '<td><div class="btn-group">'+ item.action +'</div></td></tr>';
            });
            return $(htmlShow);
        }

        var t = $('.user').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route($routeAjax) }}',
            columns: [
                {
                    className:      'details-control',
                    orderable:      false,
                    searchable: false,
                    data:           'viewdetail',
                    defaultContent: ''
                },
                {data: 'name', name: 'name', orderable:true, searchable: true},
                {data: 'guard_name', name: 'guard_name', orderable:false, searchable: false},
                {data: 'action'},
            ],
            "drawCallback": function(settings) {
            },
            pageLength: 10,
        });

        // Add event listener for opening and closing details
        $('.user tbody').on('click', 'td.details-control', function () {
            var tr = $(this).parents('tr');
            var row = t.row( tr );
    
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );

        // Check permission before initializing DataTable Buttons
        checkPermission('Can add permission', function(hasPermission) {
            if (hasPermission || isSuperAdmin()) {
                // Add the "Tambah Data" button if the user has permission or is a Super Admin
                new DataTable.Buttons(t, {
                    buttons: [
                        {
                            text: 'Tambah Data',
                            action: function (e, dt, node, config) {
                                $('#addPermission').modal('show');
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
