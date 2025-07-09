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
                    <li class="breadcrumb-item">
                        <a href="{{ route('web_product') }}">
                            Produk
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('web_product', $product->category->slug) }}">
                            {{ $product->category->title }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="product-detail">
        <div class="container">
            <div class="title-page" data-aos="fade-in">
                <h3 class="font-text-bold">{{ $product->title }}</h3>
            </div>
            <div class="product-inside">
                <div class="info-top">
                    @php
                        // 1. decide the list of images to show
                        $displayImages = $product->images->take($product->youtube_id ? 5 : 6);

                        // 2. helper URLs for the video (null‑safe)
                        $ytEmbed = $product->youtube_embed_url;      // https://www.youtube.com/embed/{id}
                        $ytThumb = $product->youtube_thumbnail;      // https://img.youtube.com/vi/{id}/hqdefault.jpg
                    @endphp

                    <div class="image-top">
                        <div class="row no-gutters">

                            {{-- ========== PRIMARY SLIDER (main) ========== --}}
                            <div class="col-md-10 col-lg-11">
                                <div class="image-primary">
                                    <div class="primary-slider">
                                        <div class="swiper-container" id="primarySwiper">
                                            <div class="swiper-wrapper">

                                                {{-- ▶ 1) Video slide (if any) --}}
                                                @if ($ytEmbed)
                                                    <div class="swiper-slide">
                                                        <div class="image-area" data-aos="zoom-in">
                                                            <figure class="ratio ratio-16x9">
                                                                <iframe src="{{ $ytEmbed }}" allowfullscreen></iframe>
                                                            </figure>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- ▶ 2) Image slides --}}
                                                @foreach ($displayImages as $img)
                                                    <div class="swiper-slide">
                                                        <div class="image-area" data-aos="zoom-in">
                                                            <figure>
                                                                <img src="{{ url('storage/upload_files/images/product/meta') . '/' . $img->uri }}" alt="{{ $product->title }}">
                                                            </figure>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>

                                            {{-- arrows / dots --}}
                                            <div class="swiper-custom-arrow swiper-button-prev"></div>
                                            <div class="swiper-custom-arrow swiper-button-next"></div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========== THUMBNAIL SLIDER (left column) ========== --}}
                            <div class="col-md-2 col-lg-1 order-md-first">
                                <div class="image-thumb">
                                    <div class="thumb-slider">
                                        <div class="swiper-container" id="thumbSwiper">
                                            <div class="swiper-wrapper">

                                                {{-- video thumb first (if any) --}}
                                                @if ($ytThumb)
                                                    <div class="swiper-slide">
                                                        <div class="image-area" data-aos="zoom-in">
                                                            <figure>
                                                                <img src="{{ $ytThumb }}" alt="video thumb">
                                                            </figure>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- image thumbs --}}
                                                @foreach ($displayImages as $img)
                                                    <div class="swiper-slide">
                                                        <div class="image-area" data-aos="zoom-in">
                                                            <figure>
                                                                <img src="{{ url('storage/upload_files/images/product/small') . '/' . $img->uri }}" alt="">
                                                            </figure>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="info-bottom">
                    <div class="info-tab">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-5 col-lg-4">
                                <div class="share-detail">
                                    <ul class="share-area flat" data-aos="fade-in">
                                        <li class="share-label" data-aos="zoom-in">
                                            <span>Share :</span>
                                        </li>
                                        @php
                                            $shareUrl   = urlencode( url()->current() );        // full URL of this page
                                            $shareTitle = urlencode( $product->title ?? config('app.name') );
                                        @endphp
                                        <li class="linkedin" data-aos="zoom-in">
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        </li>
                                        <li class="facebook" data-aos="zoom-in">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="twitter" data-aos="zoom-in">
                                            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank">
                                                <i class="icon-custom"></i>
                                            </a>
                                        </li>
                                        <li class="whatsapp" data-aos="zoom-in">
                                            <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </li>
                                        <li class="link" data-aos="zoom-in">
                                            <button id="copyLink"
                                                    class="btn btn-sm rounded-circle text-white"
                                                    style="background:#0d6efd"
                                                    data-bs-toggle="tooltip" data-bs-title="Copy link">
                                                <i class="fa fa-link"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-8 order-md-first">
                            <!-- ============================ Navigasi Tab ============================ -->
                                <div class="tab-area custom-tabs" data-aos="zoom-in">
                                    <ul class="nav nav-pills" id="spec-detail-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="font-text-bold nav-link active" id="pills-description-tab" data-toggle="pill" data-target="#tab-description" type="button" role="tab" aria-controls="tab-description" aria-selected="true">Deskripsi</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="font-text-bold nav-link" id="pills-feature-tab" data-toggle="pill" data-target="#tab-feature" type="button" role="tab" aria-controls="tab-feature" aria-selected="false">Fitur</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="font-text-bold nav-link" id="pills-spec-tab" data-toggle="pill" data-target="#tab-spec" type="button" role="tab" aria-controls="tab-spec" aria-selected="false">Spesifikasi</button>
                                        </li>
                                    </ul>
                                </div>
                            <!-- ============================ End Navigasi Tab ============================ -->
                            </div>
                        </div>
                        <div class="tab-area custom-tabs">
                            <!-- ============================ Isi Konten Tab ============================ -->
                            <div class="tab-content" id="spec-detail-tabContent" data-aos="zoom-in">
                                <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="pills-description-tab">
                                    <h5 class="font-text-bold subtitle-tab">Deskripsi</h5>
                                    <div class="tab-inside">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-feature" role="tabpanel" aria-labelledby="pills-feature-tab">
                                    <h5 class="font-text-bold subtitle-tab">Fitur</h5>
                                    <div class="tab-inside">
                                        {!! $product->feature !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-spec" role="tabpanel" aria-labelledby="pills-spec-tab">
                                    <h5 class="font-text-bold subtitle-tab">Spesifikasi</h5>
                                    <div class="tab-inside">
                                        {!! $product->spesification !!}
                                    </div>
                                </div>
                            </div>
                            <!-- ============================ End Isi Konten Tab ============================ -->
                        </div>
                    </div>
                    <div class="button-area" data-aos="fade-in">
                        <a href="{{ Route('web_contact') }}" class="button font-text-bold">Pesan Sekarang</a>
                        <a href="{{ url('storage/upload_files/documents/product/ori') . '/' . $product->brochure }}" class="button secondary font-text-bold" target="_blank">Download Brosur</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('copyLink').addEventListener('click', function () {
        navigator.clipboard.writeText(@json(url()->current()))
            .then(() => {
                const tip = bootstrap.Tooltip.getOrCreateInstance(this);
                tip.hide(); this.dataset.bsTitle = 'Copied!';
                tip.show();
                setTimeout(() => { tip.hide(); this.dataset.bsTitle = 'Copy link'; }, 1200);
            });
    });
</script>
@endpush