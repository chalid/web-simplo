@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="page-content">
    <section class="hero-banner">
        <div class="slider-area">
            <div class="swiper-container">
                <div class="swiper-custom-arrow swiper-button-next"></div>
                <div class="swiper-custom-arrow swiper-button-prev"></div>
                <div class="swiper-wrapper">
                    @foreach($banners as $item)
                    <div class="swiper-slide">
                        <div class="content-swipe">
                            <div class="hero-image">
                                <figure data-aos="fade-in">
                                    <img src="{{ url('storage/upload_files/images/banner/large') . '/' . $item->image }}" alt="{{ $item->meta_tag }}">
                                </figure>
                            </div>
                            <div class="hero-desc">
                                <div class="desc-wrapper" data-aos="fade-right" data-aos-delay="600">
                                    <h4 class="font-text-bold">{{ $item->title }}</h4>
                                    <p>
                                        {{ $item->description }}
                                    </p>
                                    @if($item->link)
                                        <div class="button-area">
                                            <a href="{{ $item->link }}" class="button outline font-text-bold">Learn More</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <section class="product-slider">
        <div class="title-section">
            <div class="container">
                <h3 class="font-text-light" data-aos="zoom-in">Gateway Controller & One Platform Customisation to Secure Your Business</h3>
            </div>
        </div>
        <div class="slider-area">
            <div class="image-slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($studyCases as $studyCase)
                            <div class="swiper-slide">
                                <div class="content-swipe">
                                    <div class="image-area">
                                        <figure data-aos="fade-in">
                                            <img src="{{ url('storage/upload_files/images/study_case_banner/normal') . '/' . $studyCase->image }}" alt="{{ $studyCase->meta_tag }}">
                                        </figure>
                                    </div>
                                    <div class="desc-area">
                                        <div class="desc-wrapper" data-aos="fade-in" data-aos-delay="600">
                                            <h4 class="font-text-bold">{{ $studyCase->title }}</h4>
                                            <p class="show-desktop">
                                                {!! $studyCase->description !!}
                                            </p>
                                            <div class="button-area">
                                                <a href="{{ $studyCase->slug }}" class="button outline font-text-bold">Learn More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="nav-slider" data-aos="fade-in" data-aos-delay="600">
                <div class="container">
                    <div class="slider-area">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($studyCases as $studyCase)
                                <div class="swiper-slide">
                                    <div class="icon-wrapper">
                                        <div class="content-swipe">
                                            <div class="icon-area">
                                                <!-- ========== Kalo mau pake icon image ========== -->
                                                <!-- <div class="icon-product" style="background-image: url('assets/img/icon/icon-infrastructure.png');"></div> -->
                                                <!-- ========== <div class="icon-product fa fa-cogs"></div> ========== -->
                                                <!-- ========== End icon image ========== -->
                                                <div class="icon-product"
                                                    style="background-image: url('{{ asset('storage/upload_files/images/study_case_icon/thumb2/'.$studyCase->icon) }}');">
                                                </div>
                                            </div>
                                            <div class="desc-area">
                                                <h6>{{ $studyCase->title }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="brands-slider">
        <div class="title-section">
            <div class="container">
                <h3 class="font-text-light" data-aos="zoom-in">
                    Seamless Integration with Leading 
                    <strong>Global Security Brands</strong>
                </h3>
            </div>
        </div>
        <div class="slider-area">
            <div class="image-slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($brands as $brand)
                            <div class="swiper-slide">
                                <div class="content-swipe" data-aos="zoom-in">
                                    <div class="image-area">
                                        <figure>
                                            <img src="{{ url('storage/upload_files/images/brand/brand') . '/' . $brand->image }}" alt="{{ $brand->name }}">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <div class="info-area">
            <div class="container">
                <p class="font-text-light" data-aos="zoom-in">With our gateway controller, businesses can unify existing and new security infrastructures into a single, customizable.</p>
            </div>
        </div>
    </section>
    <section class="facility">
        <div class="title-section">
            <div class="container">
                <h3 class="font-text-light" data-aos="zoom-in">
                    <strong>On-Premise & Fully Customizable</strong>
                    The Future of Integrated Security & Facility Management 
                </h3>
            </div>
        </div>
        <div class="facility-area">
            <div class="container">
                <div class="facility-wrapper">
                    <div class="row no-gutters">
                        @foreach($productCategories as $productCategory)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="thumbnail-info" data-aos="zoom-in">
                                    <div class="thumbnail-wrapper">
                                        <div class="image-area">
                                            <figure>
                                                <img src="{{ url('storage/upload_files/images/product_category/category') . '/' . $productCategory->image }}" alt="{{ $productCategory->meta_tag }}">
                                            </figure>
                                        </div>
                                        <div class="info-area">
                                            <p class="text-ellipsis overflow-hidden line-clamp-2">{{ $productCategory->title }}</p>
                                        </div>
                                        <a href="#" class="click-area"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="news-list">
        <div class="container">
            <div class="news-area">
                <div class="row no-gutters">
                    @foreach($articles as $article)
                        <div class="col-md-6">
                            <div class="news-wrapper" data-aos="zoom-in">
                                <div class="news-date">
                                    <h4 class="font-text-black">
                                        {{ $article->created_at->format('j') }}
                                        <small>{{ $article->created_at->format('M') }}</small>
                                    </h4>
                                </div>
                                <div class="news-title">
                                    <h5 class="text-ellipsis overflow-hidden line-clamp-2">
                                        <a href="{{ route('web_article.show',$article->slug) }}">{{ $article->title }}</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="section-contact">
        <div class="container">
            <div class="title-section">
                <h3 class="font-text-light" data-aos="zoom-in">
                    <strong>Looking for the best of security solution?</strong>
                </h3>
            </div>
            <div class="info-area">
                <div class="info-text" data-aos="zoom-in">
                    <h5 class="font-text-light">The gateway controller that seamlessly integrates your physical security systems for maximum efficiency and control!</h5>
                </div>
                <div class="button-area" data-aos="zoom-in">
                    <a href="{{ route('web_contact') }}" class="button font-text-bold">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="floating-button inquiry-button">
    <div class="button-wrapper">
        <a href="#" class="button-inside">
            <span class="arrow"></span>
            <strong>?</strong>
            <small>Inquiry</small>
        </a>
    </div>
</div>
<div class="floating-button back-top">
    <div class="button-wrapper">
        <a href="#main" class="button-inside is-scroll">
            <span class="icon-arrow"></span>
        </a>
    </div>
</div>
@endsection
@push('script')
@endpush