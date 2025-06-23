@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<main class="index" id="index" >
    <section class="cover">
        <div class="container-fluid">
            <div class="cover-area" data-aos="fade-in">
                <div class="cover-content" id="cover-content">
                    @foreach($banners as $item)
                        <div class="cover-list">
                            <div class="wrapper">
                                <div class="overlay"></div>
                                <div class="image-area">
                                    <img src="{{ url('storage/upload_files/images/banner/normal') . '/' . $item->image }}" alt="{{ $item->title }}">
                                </div>
                                <div class="desc-area" data-aos="fade-in" data-aos-delay="600">
                                    <h3>{{ $item->title }}</h3>
                                    <h5>{{ $item->description }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="article-slider">
        <div class="container">
            <div class="title-section">
                <h3 data-aos="fade-right">
                    Latest
                    <span>Article</span>
                </h3>
                <div class="link-cta" data-aos="fade-right" data-aos-delay="300">
                    <a href="{{ route('web_article') }}" class="cta">
                        <span>View All</span>
                        <i class="icon-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="article-section">
            <div class="slider-area">
                @foreach($articles as $item)
                    <div class="slider-list">
                        <div class="thumbnail-news" data-aos="zoom-in">
                            <div class="thumbnail-wrapper">
                                <div class="image-area">
                                    <figure>
                                        <img src="{{ url('storage/upload_files/images/article/small') . '/' . $item->image }}" alt="{{ $item->title }}">
                                    </figure>
                                </div>
                                <div class="info-area">
                                    <span class="category-label text-ellipsis line-clamp-1">{{ $item->created_at->format('d F Y') }}</span>
                                    <p class="text-ellipsis line-clamp-2">{{ $item->title }}</p>
                                    <p class="desc-info">
                                        {!! Str::limit(strip_tags($item->description), 80, ' [read more]') !!}
                                    </p>
                                </div>
                                <a href="{{ route('web_article.show', $item->slug) }}" class="click-area"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="about-info">
        <div class="container">
            <div class="about-info-slider">
                @foreach($visions as $item)
                    <div class="about-info-list">
                        <div class="info" data-aos="zoom-in">
                            <div class="image-area">
                                <img src="{{ url('storage/upload_files/images/vision/small') . '/' . $item->image }}" alt="{{ $item->title }}">
                            </div>
                            <div class="desc-area">
                                <h4>{{ $item->title }}</h4>
                                <p>{{ $item->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="business-info">
        <div class="container">
            @foreach($mottos as $item)
                @if($loop->iteration == 2)
                    <div class="row no-gutters thumbnail-info right-style align-items-center">
                        <div class="image-area col-lg-8 order-lg-last">
                            <div class="gallery-image shadow" data-aos="fade-left">
                                <img src="{{ url('storage/upload_files/images/motto/large') . '/' . $item->image }}" alt="{{ $item->title }}">
                            </div>
                        </div>
                        <div class="info-thumb col-lg-4 order-lg-first">
                            <div class="wrapper">
                                <div class="title-area">
                                    <h3 data-aos="fade-right">
                                        {{ $item->title }}
                                    </h3>
                                </div>
                                <div class="desc-area" data-aos="fade-right" data-aos-delay="100">
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row no-gutters thumbnail-info align-items-center">
                        <div class="image-area col-lg-8">
                            <div class="gallery-image shadow" data-aos="fade-right">
                                <img src="{{ url('storage/upload_files/images/motto/large') . '/' . $item->image }}" alt="{{ $item->title }}">
                            </div>
                        </div>
                        <div class="info-thumb col-lg-4">
                            <div class="wrapper">
                                <div class="title-area">
                                    <h3 data-aos="fade-left">
                                        {{ $item->title }}
                                    </h3>
                                </div>
                                <div class="desc-area" data-aos="fade-left" data-aos-delay="100">
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
    <section class="project-info">
        <div class="container">
            <div class="title-section">
                <h3 data-aos="fade-right">
                    Our
                    <span>Projects</span>
                </h3>
                <div class="link-cta" data-aos="fade-right" data-aos-delay="300">
                    <a href="{{ route('web_project') }}" class="cta">
                        <span>View All</span>
                        <i class="icon-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="project-slider" data-aos="zoom-in" data-aos-delay="600">
                <div class="project-area">
                    @foreach($projects as $item)
                        <div class="project-list">
                            <div class="project-wrapper">
                                <div class="project">
                                    <div class="image-area shadow">
                                        <img src="{{ url('storage/upload_files/images/project/small') . '/' . $item->image }}" alt="{{ $item->title }}">
                                    </div>
                                    <ul class="tag">
                                        <li>
                                            <a href="#">{{  $item->category->name }}</a>
                                        </li>
                                    </ul>
                                    <div class="desc-area">
                                        <h5>{{  $item->title }}</h5>
                                    </div>
                                </div>
                                <a href="{{ route('web_project.show', ['slug' => $item->slug]) }}" class="link"></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="project-nav">
                    <div class="wrapper">
                        @foreach($projects as $item)
                            <div class="nav-wrapper" data-aos="fade-up">
                                <div class="photos" style="background-image: url('{{ url('storage/upload_files/images/project/small-thumb/' . $item->image) }}');"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="logo-slider partner-slider">
        <div class="container">
            <div class="title-section">
                <h3 data-aos="fade-right">
                    Our
                    <span>Partners</span>
                </h3>
                <div class="link-cta" data-aos="fade-right" data-aos-delay="300">
                    <a href="{{ route('web_partner') }}" class="cta">
                        <span>View All</span>
                        <i class="icon-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="slider-area">
            <div class="slider-row">
                @foreach($partners as $item)
                    <div class="slider-list">
                        <div class="box-slider" data-aos="zoom-in" data-aos-delay="600">
                            <div class="image-area">
                                <figure>
                                    <img src="{{ url('storage/upload_files/images/partner/small-thumb') . '/' . $item->image }}" alt="{{ $item->title }}">
                                </figure>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="logo-slider client-slider">
        <div class="container">
            <div class="title-section">
                <h3 data-aos="fade-right">
                    Our
                    <span>Clients</span>
                </h3>
                <div class="link-cta" data-aos="fade-right" data-aos-delay="300">
                    <a href="{{ route('web_client') }}" class="cta">
                        <span>View All</span>
                        <i class="icon-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="slider-area">
            <div class="slider-row">
                @foreach($clients as $item)
                    <div class="slider-list">
                        <div class="box-slider" data-aos="zoom-in" data-aos-delay="600">
                            <div class="image-area">
                                <figure>
                                    <img src="{{ url('storage/upload_files/images/client/small-thumb') . '/' . $item->image }}" alt="{{ $item->title }}">
                                </figure>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection
@push('script')
@endpush