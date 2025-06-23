@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
<main class="project-gallery" id="project-gallery" >
    <section class="title-page">
        <div class="title-area">
            <div class="container">
                <h4 data-aos="fade-right">
                    <small>{{ $project->category->name }}</small>
                    <span>{{ $project->title }}</span>
                </h4>
            </div>
        </div>
    </section>
    <section class="gallery">
        <div class="container">
            <div class="video-source" style="display:none;">
                <div id="video1" style="display:none;">
                    <video class="lg-video-object lg-html5" controls="" preload="none">
                        <source src="{{ asset('assets/frontend/assets/video/movie.mp4') }}" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                </div>
            </div>
            <div class="row no-gutters">
                @foreach($project->images as $item)
                    <div class="col-6 col-md-4">
                        <div class="gallery-wrapper">
                            <div class="image-area shadow selector" data-exthumbimage="{{ url('storage/upload_files/images/project/small') . '/' . $item->uri }}" data-src="{{ url('storage/upload_files/images/project/small') . '/' . $item->uri }}" data-aos="zoom-in">
                                <img src="{{ url('storage/upload_files/images/project/large') . '/' . $item->uri }}" alt="{{ $project->title }}">
                                <div class="overlay-bg">
                                    <div class="hover-icon">
                                        <span class="icon"></span>
                                    </div>
                                </div>
                                <div class="overlay-mobile show-mobile">
                                    <div class="icon">
                                        <span class="fa fa-search-plus"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection