@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
    <main class="story" id="story" >
        <section class="title-page">
            <div class="title-area">
                <div class="container">
                    <h3 data-aos="fade-right">
                        Our
                        <span>Story</span>
                    </h3>
                </div>
            </div>
        </section>
        <section class="content-detail editable">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-6">
                        <article data-aos="fade-right" data-aos-delay="50">
                            {!! $about->description !!}							
                        </article>
                    </div>
                </div>
            </div>
        </section>
        @if($certificates->count() != 0)
            <section class="certificate">
                <div class="container">
                    <div class="title-section">
                        <h3 data-aos="fade-right">
                            Our
                            <span>Certificate's</span>
                        </h3>
                    </div>
                    <div class="wrapper content-detail-page">
                        <div class="row awards-list">
                            @foreach ($certificates as $item)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="certificate-image shadow selector" data-exthumbimage="{{ url('storage/upload_files/images/certificate/original') . '/' .$item->image }}" data-src="{{ url('storage/upload_files/images/certificate/original') . '/' .$item->image }}" data-aos="zoom-in">
                                        <div class="frame">
                                            <img src="{{ asset('assets/frontend/assets/img/certificates/frame.png') }}" alt="">
                                        </div>
                                        <div class="wrapper-image">
                                            <img src="{{ url('storage/upload_files/images/certificate/original') . '/' . $item->image }}" alt="{{ $item->meta_title }}">
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
                </div>
            </section>
        @endif
    </main>
@endsection