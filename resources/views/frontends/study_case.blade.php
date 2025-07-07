@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
    <div class="page-content">
        <div class="breadcrumb-page" data-aos="fade-in">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('web_index') }}">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Study Case</li>
                    </ol>
                </nav>
            </div>
        </div>
        <section class="about">
            <div class="container">
                <div class="title-page" data-aos="fade-in">
                    <h3 class="font-text-bold">{{ $studyCase->title }}</h3>
                </div>
                <div class="about-inside">
                    <div class="content-area">
                        <div class="image-area" data-aos="fade-in">
                            <figure>
                                <img src="{{ url('storage/upload_files/images/study_case_banner/normal/' . $studyCase->image) }}" alt="{{ $studyCase->meta_tag }}">
                            </figure>
                        </div>
                        <div class="article-area" data-aos="fade-in">
                            <div class="article-row">
                                <div class="article-group">
                                    <article>
                                        {!! $studyCase->description !!}
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection