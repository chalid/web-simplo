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
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
        <section class="about">
            <div class="container">
                <div class="title-page" data-aos="fade-in">
                    <h3 class="font-text-bold">About Us</h3>
                </div>
                <div class="about-inside">
                    <div class="content-area">
                        <div class="image-area" data-aos="fade-in">
                            <figure>
                                <img src="{{ url('storage/upload_files/images/about/large/' . $about->image) }}" alt="{{ $about->meta_tag }}">
                            </figure>
                        </div>
                        <div class="article-area" data-aos="fade-in">
                            <div class="article-row">
                                <div class="article-group">
                                    <article>
                                        {!! $about->description !!}
                                    </article>
                                </div>
                            </div>
                            <div class="article-row row no-gutters">
                                <div class="col-md-6">
                                    <div class="article-group">
                                        <div class="title-detail" data-aos="fade-in">
                                            <h5 class="font-text-bold">Visi</h5>
                                        </div>
                                        <article data-aos="fade-in">
                                            {!! $about->vision !!}
                                        </article>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="article-group">
                                        <div class="title-detail" data-aos="fade-in">
                                            <h5 class="font-text-bold">Misi</h5>
                                        </div>
                                        <article data-aos="fade-in">
                                            {!! $about->mission !!}
                                        </article>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="article-group">
                                        <div class="title-detail" data-aos="fade-in">
                                            <h5 class="font-text-bold">Sejarah</h5>
                                        </div>
                                        <article data-aos="fade-in">
                                            {!! $about->history !!}
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection