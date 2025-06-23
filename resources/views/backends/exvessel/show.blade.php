@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partials.css_form')
<!-- Add Image Modal -->
<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('exvessel.image.store', ['exVessel' => $exVessel->id ]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="ex_vessel_id" value="{{ $exVessel->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">Add Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <x-form.file name="image" label="Upload Image" required />
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Image</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <!-- Page header -->
        <div class="border-bottom pb-4 mb-4 ">
            <h3 class="mb-0 fw-bold">{{ $title }}</h3>
        </div>
    </div>
</div>
<div class="row">
        <!-- card -->
        <div class="col-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Image</h5>
                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addImageModal">Add Image</button>
                </div>
                <div class="card-body">
                    @foreach($exVessel->images as $item)
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @php
                                        $path = 'storage/upload_files/images/';
                                        $dir = 'exvessel/';
                                        $thumbPath = $item->uri
                                            ? url($path . $dir . 'small/' . $item->uri)
                                            : url('assets/backend/images/png/no_image.png');

                                        $originalPath = $item->uri
                                            ? url($path . $dir . 'large/' . $item->uri)
                                            : '#';
                                    @endphp
                                    <a href="{{ $originalPath }}" target="_blank">
                                        <img src="{{ $thumbPath }}" alt="{{ $item->name }}" class="img-fluid rounded-start">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->is_default == true ? 'default' : '' }}</h5>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-grid gap-2 d-md-block">
                                            @if($item->is_default == false)
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#setDefaultModal"
                                                    onclick="document.getElementById('setDefaultImageId').value = '{{ $item->id }}'" title="Set Default">
                                                    <i data-feather="check" class="nav-icon me-2 icon-xxs"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-danger btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#deleteImageModal"
                                                onclick="document.getElementById('deleteImageId').value = '{{ $item->id }}'" title="Delete">
                                                <i data-feather="x" class="nav-icon me-2 icon-xxs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Set Default Modal -->
                        <div class="modal fade" id="setDefaultModal" tabindex="-1" aria-labelledby="setDefaultModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('exvessel.image.set_default', ['exVessel' => $exVessel->id, 'exVesselImage' => $item->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="patch">
                                    <input type="hidden" name="ex_vessel_id" value="{{ $exVessel->id }}">
                                    <input type="hidden" name="image_id" id="setDefaultImageId">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Set as Default</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to set this image as default?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Set Default</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Delete Image Modal -->
                        <div class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('exvessel.image.delete', ['exVessel' => $exVessel->id, 'exVesselImage' => $item->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="image_id" id="deleteImageId">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this image?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ $exVessel->title }}
                    <a href="{{ route('exvessel') }}" class="btn btn-primary btn-sm">
                        <i data-feather="arrow-left" class="nav-icon me-2 icon-xxs"></i> back
                    </a>
                </div>
                <div class="card-body">
                    {!! $exVessel->description !!}
                </div>
            </div>
        </div>
</div>
@endsection
@push('scripts')
@include('layouts.backend.partials.script_form')
<script>
</script>
@include('layouts.backend.partials.script_form_index')
@endpush
