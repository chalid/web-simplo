@extends('layouts.backend.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/sweetalert2.min.css') }}">
<style>
    #myToast {
        --bs-toast-zindex: 1090;
        --bs-toast-padding-x: 0.75rem;
        --bs-toast-padding-y: 0.5rem;
        --bs-toast-spacing: 1.5rem;
        --bs-toast-max-width: 350px;
        --bs-toast-font-size: 0.875rem;
        --bs-toast-color: ;
        --bs-toast-bg: rgba(var(--bs-body-bg-rgb), 0.85);
        --bs-toast-border-width: var(--bs-border-width);
        --bs-toast-border-color: var(--bs-border-color-translucent);
        --bs-toast-border-radius: var(--bs-border-radius);
        --bs-toast-box-shadow: var(--bs-box-shadow);
        --bs-toast-header-color: var(--bs-secondary-color);
        --bs-toast-header-bg: rgba(var(--bs-body-bg-rgb), 0.85);
        --bs-toast-header-border-color: var(--bs-border-color-translucent);
        width: var(--bs-toast-max-width);
        max-width: 100%;
        font-size: var(--bs-toast-font-size);
        color: var(--bs-toast-color);
        pointer-events: auto;
        background-color: var(--bs-toast-bg);
        background-clip: padding-box;
        border: var(--bs-toast-border-width) solid var(--bs-toast-border-color);
        box-shadow: var(--bs-toast-box-shadow);
        border-radius: var(--bs-toast-border-radius);
    }

    #myToast .toast-header{
        display: flex;
        align-items: center;
        padding: var(--bs-toast-padding-y) var(--bs-toast-padding-x);
        color: var(--bs-toast-header-color);
        background-color: var(--bs-toast-header-bg);
        background-clip: padding-box;
        border-bottom: var(--bs-toast-border-width) solid var(--bs-toast-header-border-color);
        border-top-left-radius: calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));
        border-top-right-radius: calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));
    }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <!-- Page header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h3 class="mb-0 ">{{ $title }}</h3>
            <a href="{{ route('user') }}" class="btn btn-danger">
                <i data-feather="arrow-left" class="nav-icon me-2 icon-xs"></i> Back
            </a>
        </div>
    </div>
</div>
<!-- row -->
<div class="row">
    @if ($permissions && $permissions->count() > 0)
        @foreach($permissions as $permission)
            <!-- col -->
            <div class="col-lg-6 mb-5">
                <!-- card -->
                <div class="card h-100">
                    <!-- card body -->
                    <!-- card header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $permission->name }} </h3>
                        <div class="form-check form-switch">
                            <input type="checkbox" data-url="{{ route('user.permission.store',['user'=>$user,'permission'=>$permission]) }}" {!! ($user->hasPermissionTo($permission->id)) ? 'checked':'' !!} name="roleParent" class="form-check-input roleParentChange roleList" id="flexSwitchCheckChecked">
                        </div>
                    </div>
                    <!-- row -->
                    <!-- table -->
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            @if ($permission->children && $permission->children->count() > 0)
                            <table class="table text-nowrap mb-0 table-centered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60%">Permission name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @foreach($permission->children as $child)
                                <tbody>
                                    <tr>
                                        <td width="60%">{{ $child->name }}</td>
                                        <td style="text-align:center">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" {!! ($user->hasPermissionTo($child->id)) ? 'checked':'' !!} data-url="{{ route('user.permission.store',['user'=>$user,'permission'=>$child->id]) }}" name="" class="roleChildrenChange form-check-input" id="flexSwitchCheckChecked">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/backend/js/sweetalert2.all.min.js') }}"></script>
<script>
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function () {
        $('.roleParentChange').on('change', function (e) {
            var _this = $(this);
            var link = $(this).data('url');

            var isChecked = $(this).is(':checked');

            if (isChecked === true) {
                $.post(link, {state:isChecked}, function (data) {
                    console.log(data.status);
                    if(data.status == true) {
                        var blocked = _this.closest('.card').find('.roleList');

                        $.notify({
                            title: "Sukses:",
                            message: "Permission berhasil disimpan ke Role"
                        },{
                            clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                            placement: {
                                from: "top",
                                align: "end"
                            }, // Position of the toast on the screen
                            type: "success", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                            style: "toast",
                        });
                    } else {
                        $.notify({
                            title: "Gagal:",
                            message: "Permission gagal disimpan ke Role"
                        },{
                            clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                            placement: {
                                from: "top",
                                align: "end"
                            }, // Position of the toast on the screen
                            type: "danger", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                            style: "toast",
                        });
                        // _this.attr('checked',false);
                    }
                },"json");
            } else {
                swal.fire({
                    title: 'Hapus data?',
                    text: 'Apakah Anda yakin untuk hapus data ini ?',
                    allowOutsideClick: true,
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then(function(result){
                    if (result.value) {
                        $.post(link, {state:isChecked}, function (data) {
                            if(data.status == true) {
                                var blocked = _this.closest('.card').find('.roleList');
                                console.log(blocked);
                                $.notify({
                                    title: "Sukses:",
                                    message: "Permission berhasil dihapus dari Role"
                                },{
                                    clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                                    placement: {
                                        from: "top",
                                        align: "end"
                                    }, // Position of the toast on the screen
                                    type: "success", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                                    style: "toast",
                                });
                            } else {
                                $.notify({
                                    title: "Gagal:",
                                    message: "Permission gagal dihapus dari Role"
                                },{
                                    clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                                    placement: {
                                        from: "top",
                                        align: "end"
                                    }, // Position of the toast on the screen
                                    type: "danger", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                                    style: "toast",
                                });
                            }
                        },"json");
                    }
                });
            }
        });

        $('.roleChildrenChange').on('change', function (e) {
            var _this = $(this);
            var _link = $(this).data('url');

            var isChecked = $(this).is(':checked');

            if (isChecked == true) {
                $.post(_link, {state:isChecked}, function (data) {
                    if (data.status == true) {
                        $.notify({
                            title: "Sukses:",
                            message: "Permission berhasil disimpan ke Role"
                        },{
                            clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                            placement: {
                                from: "top",
                                align: "end"
                            }, // Position of the toast on the screen
                            type: "success", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                            style: "toast",
                        });
                    } else {
                        $.notify({
                            title: "Gagal:",
                            message: "Permission gagal disimpan ke Role"
                        },{
                            clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                            placement: {
                                from: "top",
                                align: "end"
                            }, // Position of the toast on the screen
                            type: "danger", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                            style: "toast",
                        });
                    }
                }, 'json');
            } else {
                swal.fire({
                    title: 'Hapus data?',
                    text: 'Apakah Anda yakin untuk hapus data ini ?',
                    allowOutsideClick: true,
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then(function(result){
                    if (result.value) {
                        $.post(_link, {state:isChecked}, function (data) {
                            if(data.status == true) {
                                var blocked = _this.closest('.card').find('.roleList');
                                $.notify({
                                    title: "Sukses:",
                                    message: "Permission berhasil dihapus dari Role"
                                },{
                                    clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                                    placement: {
                                        from: "top",
                                        align: "end"
                                    }, // Position of the toast on the screen
                                    type: "success", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                                    style: "toast",
                                });
                            } else {
                                $.notify({
                                    title: "Gagal:",
                                    message: "Permission gagal dihapus dari Role"
                                },{
                                    clickToHide: true,// Duration for the toast to be displayed (in milliseconds)
                                    placement: {
                                        from: "top",
                                        align: "end"
                                    }, // Position of the toast on the screen
                                    type: "danger", // Bootstrap Toast type (e.g., "success", "info", "warning", "danger")
                                    style: "toast",
                                });
                            }
                        },"json");
                    }
                });
            }
        });

        //add a new style 'foo'
        $.notify.addStyle('toast', {
        html: 
            "<div id='myToast' class='toast hide' role='alert' aria-live='assertive' aria-atomic='true'>" +
                "<div class='toast-header'>" +
                    "<strong class='me-auto'><div class='title' data-notify-html='title'/></strong>" +
                    "<button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close' data-notify-text='button'></button>" +
                "</div>" +
                "<div class='toast-body'>" +
                    "<div class='message' data-notify-html='message'/>" +
                "</div>" +
            "</div>"
        });
    });
</script>
@endpush
