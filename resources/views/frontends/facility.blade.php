@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
    <main class="Facility" id="Facility" >
        <section class="title-page">
            <div class="title-area">
                <div class="container">
                    <h3 data-aos="fade-right">
                        Our
                        <span>Facilities</span>
                    </h3>
                </div>
            </div>
        </section>
        <section class="facility-detail">
            <div class="container">
                <div class="facility-thumbnails">
                    @foreach($facilities as $item)
                        <!-- MODEL LIST 2 -->
                        <div class="facility-list-thumbnails" data-aos="fade-up">
                            <div class="row no-gutters align-items-start">
                                <div class="col-md-5">
                                    <div class="image-area">
                                        <div class="image-slider">
                                            @foreach($item->images as $ijo)
                                                <div class="slider">
                                                    <div class="image-wrapper selector" data-exthumbimage="{{ url('storage/upload_files/images/facility/small') . '/' . $ijo->uri }}" data-src="{{ url('storage/upload_files/images/facility/small') . '/' . $ijo->uri }}">
                                                        <img src="{{ url('storage/upload_files/images/facility/large') . '/' . $ijo->uri }}" alt="{{ $item->title }}">
                                                        <div class="overlay-bg">
                                                            <div class="hover-icon">
                                                                <span class="icon"></span>
                                                            </div>
                                                        </div>
                                                        <div class="icon-gallery">
                                                            <i class="far fa-images"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="facility-list">
                                        <h5>{{ $item->title }}</h5>
                                        <p>{!! $item->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($facilities->hasPages())
                    <nav class="pagination-area">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($facilities->onFirstPage())
                                <li class="page-item disabled" data-aos="zoom-in">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @else
                                <li class="page-item" data-aos="zoom-in">
                                    <a class="page-link" href="{{ $facilities->previousPageUrl() }}" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @endif
                            {{-- Pagination Elements --}}
                            @foreach ($facilities->links()->elements as $element)
                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $facilities->currentPage())
                                            <li class="page-item active" data-aos="zoom-in">
                                                <a class="page-link" href="#">{{ $page }}</a>
                                            </li>
                                        @else
                                            <li class="page-item" data-aos="zoom-in">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            {{-- Next Page Link --}}
                            @if ($facilities->hasMorePages())
                                <li class="page-item" data-aos="zoom-in">
                                    <a class="page-link" href="{{ $facilities->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled" data-aos="zoom-in">
                                    <a class="page-link" href="#"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </section>
    </main>
@endsection