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
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ $product->title }}
                    <a href="{{ route('product') }}" class="btn btn-primary btn-sm">
                        <i data-feather="arrow-left" class="nav-icon me-2 icon-xxs"></i> back
                    </a>
                </div>
                <div class="card-body">
                    {!! $product->description !!}
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
