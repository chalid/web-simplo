@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
<main class="product" id="product" >
    <section class="title-page">
        <div class="title-area">
            <div class="container">
                <h3 data-aos="fade-right">
                    Our
                    <span>Products</span>
                </h3>
            </div>
        </div>
    </section>
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('info'))
        <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            Please check the form below for errors
        </div>
    @endif
    <section class="product-thumbnails">
        <div class="container">
            <div class="row no-gutters justify-content-center">
                <div class="col-md-10">
                    <div class="row no-gutters justify-content-center">
                        @foreach ($products as $item)
                            <div class="col-md-6" data-aos="zoom-in">
                                <div class="product-wrapper">
                                    <div class="product-area">
                                        <div class="image-area shadow">
                                            <div class="image-slider">
                                                @foreach ($item->images as $ijo)
                                                    <div class="slider">
                                                        <div class="image-wrapper selector" data-exthumbimage="{{ url('storage/upload_files/images/product/large') . '/' . $ijo->uri }}" data-src="{{ url('storage/upload_files/images/product/large') . '/' . $ijo->uri }}">
                                                            <img src="{{ url('storage/upload_files/images/product/small') . '/' . $ijo->uri }}" alt="{{ $item->title }}">
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
                                                @endforeach
                                            </div>
                                        </div>
                                        <ul class="tag">
                                            <li>
                                                <span>{{ $item->category->name }}</span>
                                            </li>
                                        </ul>
                                        <div class="desc-area">
                                            <h5>{{ $item->title }}</h5>
                                            <p>{!! $item->description !!}</p>
                                        </div>
                                        <ul class="button-area flat">
                                            <li>
                                                <button class="button outline selector-button">Lihat Foto</button>
                                            </li>
                                            <li>
                                                <button class="button" data-toggle="modal" data-target="#modal-product" data-product="{{ $item->title }}" data-name="{{ $item->title }} - {{ $item->code_no }}">Hubungi Kami</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @if ($products->hasPages())
                <nav class="pagination-area">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="page-item disabled" data-aos="zoom-in">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @else
                            <li class="page-item" data-aos="zoom-in">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @foreach ($products->links()->elements as $element)
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $products->currentPage())
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
                        @if ($products->hasMorePages())
                            <li class="page-item" data-aos="zoom-in">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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
    <!-- POPUP -->
    <div class="modal fade" id="modal-product" tabindex="-1" role="dialog" aria-labelledby="modal-product-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-product-title">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('web_add_question') }}" method="POST" class="form" id="form-message">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="name" class="col-form-label">Name *</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="email" class="col-form-label">Email Address *</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="phone" class="col-form-label">Phone Number *</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="08xxxxxxxxx" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="productName" class="col-form-label">Product Name *</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="productShow" name="product" readonly>
                                    <input type="hidden" class="form-control" id="productName" name="product_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="message" class="col-form-label">Message *</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="message" name="message" placeholder="Message" row="2" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button outline" data-dismiss="modal">Close</button>
                        <button type="submit" value="Submit" class="button submit-form">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END POPUP -->
</main>
@endsection