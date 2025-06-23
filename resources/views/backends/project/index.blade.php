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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped project">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Is Active</th>
                                <th>Category</th>
                                <th>Image</th>
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
        var t = $('.project').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route($routeAjax) }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'title', name: 'title', orderable:true, searchable: true},
                {data: 'description', name: 'description', orderable:true, searchable: true},
                {data: 'is_active', name: 'is_active', orderable:true, searchable: false},
                {data: 'category_name'},
                {data: 'image', name: 'image', orderable:false, searchable: false},
                {data: 'action'},
            ],
            "drawCallback": function(settings) {
            },
            pageLength: 10,
        });

        // Check permission before initializing DataTable Buttons
        checkPermission('Can add project', function(hasPermission) {
            if (hasPermission || isSuperAdmin()) {
                // Add the "Tambah Data" button if the user has permission or is a Super Admin
                new DataTable.Buttons(t, {
                    buttons: [
                        {
                            text: 'Tambah Data',
                            action: function (e, dt, node, config) {
                                // Redirect to a Laravel route named 'new-data'
                                var routeUrl = '{{ route("project.create") }}';
                                window.location.href = routeUrl;
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
