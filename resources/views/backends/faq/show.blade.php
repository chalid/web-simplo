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
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ $faq->title }}
                    <a href="{{ route('faq') }}" class="btn btn-primary btn-sm">
                        <i data-feather="arrow-left" class="nav-icon me-2 icon-xxs"></i> back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="position" class="col-sm-4 col-form-label">Position</label>
                        <div class="col-sm-8">
                            <p>{{ $faq->position }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="question" class="col-sm-4 col-form-label">Question</label>
                        <div class="col-sm-8">
                            <p>{!! $faq->question !!}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="answer" class="col-sm-4 col-form-label">Answer</label>
                        <div class="col-sm-8">
                            <p>{!! $faq->answer !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
@push('scripts')
@endpush
