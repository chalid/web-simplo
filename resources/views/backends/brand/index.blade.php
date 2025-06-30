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
                    <table class="table table-bordered table-hover table-striped brand">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Product Category</th>
                                <th>Is Active</th>
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
<!-- Modal -->
<div class="modal fade" id="addBrand" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBrandLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBrandLabel">Anda ingin menambah data?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('brand.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <x-form.input name="title" label="Title name" :value="old('title')" :required="true" />
                    <x-form.select name="product_category_id" label="Product Category" :options="$productCategories" :selected="old('product_category_id')" :required="true"/>
                    <x-form.select name="is_active" label="Is Active" :options="[1 => 'Active', 0 => 'In Active']" :selected="old('is_active')" :required="true"/>
                    <x-form.file name="image" label="Brand Image" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('layouts.backend.partials.script_form')
<script>
    $(function() {
        var t = $('.brand').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route($routeAjax) }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name', orderable:true, searchable: true},
                {data: 'phone', name: 'phone', orderable:true, searchable: true},
                {data: 'email', name: 'email', orderable:true, searchable: true},
                {data: 'is_active', name: 'is_active', orderable:true, searchable: false},
                {data: 'image', name: 'image', orderable:false, searchable: false},
                {data: 'action'},
            ],
            "drawCallback": function(settings) {
            },
            pageLength: 10,
        });

        // Check permission before initializing DataTable Buttons
        checkPermission('Can add partner', function(hasPermission) {
            if (hasPermission || isSuperAdmin()) {
                // Add the "Tambah Data" button if the user has permission or is a Super Admin
                new DataTable.Buttons(t, {
                    buttons: [
                        {
                            text: 'Tambah Data',
                            action: function (e, dt, node, config) {
                                $('#addBrand').modal('show');
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
