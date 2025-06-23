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
                    <table class="table table-bordered table-hover table-striped customer">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Product</th>
                                <th>Message</th>
                                <th>Is Active</th>
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
        var t = $('.customer').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route($routeAjax) }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name', orderable:true, searchable: true},
                {data: 'phone', name: 'phone', orderable:true, searchable: true},
                {data: 'email', name: 'email', orderable:true, searchable: true},
                {data: 'product_name', name: 'product_name', orderable:true, searchable: true},
                {data: 'message', name: 'message', orderable:true, searchable: true},
                {data: 'is_active', name: 'is_active', orderable:true, searchable: false},
                {data: 'action'},
            ],
            "drawCallback": function(settings) {
            },
            pageLength: 10,
        });
    });
</script>
@include('layouts.backend.partials.script_form_index')
@endpush
