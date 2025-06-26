@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
@php
    use Illuminate\Support\Str;
@endphp
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
                    <li class="breadcrumb-item active" aria-current="page">Berita dan Artikel</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="news">
        <div class="container">
            <div class="title-page with-share" data-aos="fade-in">
                <h3 class="font-text-bold">Berita dan Artikel</h3>
            </div>
            <div class="news-inside">
                <div class="row no-gutters">
                    <div class="col-md-4 col-lg-3">
                        <div class="sidebar-news" data-aos="zoom-in">
                            <div class="sidebar-category">
                                <div class="sidebar-group">
                                    <h5 class="font-text-bold">
                                        <span>Kategori</span>
                                    </h5>
                                    <ul class="sidebar-list">
                                        <li>
                                            <a href="{{ route('web_article') }}" class="{{ request('category') ? '' : 'active' }}">
                                                <span>All Articles</span>
                                                <span class="icon fa fa-angle-right"></span>
                                            </a>
                                        </li>
                                        @foreach($categories as $cat)
                                            <li>
                                                <a href="{{ route('web_article', ['category' => $cat->id]) }}" class="{{ request('category') == $cat->id ? 'active' : '' }}">
                                                    <span>{{ $cat->name }}</span>
                                                    <span class="icon fa fa-angle-right"></span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="sidebar-group">
                                    <h5 class="font-text-bold">
                                        <span>Recent Posts</span>
                                    </h5>
                                    <ul class="sidebar-list">
                                        @foreach ($recentArticles as $recent)
                                            <li>
                                                <a href="{{ route('web_article.show', $recent->slug) }}">
                                                    <span class="text-ellipsis overflow-hidden line-clamp-2">{{ $recent->title }}</span>
                                                    <span class="icon fa fa-angle-right"></span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="content-area">
                            <div class="content-wrapper">
                                <div class="row no-gutters">
                                    @foreach ($articles as $item)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="thumbnail-info model-2" data-aos="zoom-in">
                                                <div class="thumbnail-wrapper">
                                                    <div class="image-area">
                                                        <figure>
                                                            <img src="{{ url('storage/upload_files/images/article/small') . '/' . $item->image }}" alt="{{ $item->title }}">
                                                        </figure>
                                                    </div>
                                                    <div class="info-area">
                                                        <span class="category-label text-ellipsis overflow-hidden line-clamp-1">{{ $item->created_at->format('d F Y') }}</span>
                                                        <p class="font-text-bold text-ellipsis overflow-hidden line-clamp-2">{{ $item->title }}</p>
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
                            <div class="paging-area">
                                @if ($articles->hasPages()) 
                                    <nav class="Product navigation">
                                        <ul class="pagination justify-content-center">
                                            {{-- Previous Page Link --}}
                                            @if ($articles->onFirstPage()) 
                                                <li class="page-item disabled" data-aos="zoom-in">
                                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i></a>
                                                </li>
                                            @else
                                                <li class="page-item" data-aos="zoom-in">
                                                    <a class="page-link" href="{{ $articles->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                                                </li>
                                            @endif
    
                                            {{-- Pagination Elements --}}
                                            @foreach ($articles->links()->elements as $element)
                                                @if (is_array($element))
                                                    @foreach ($element as $page => $url)
                                                        @if ($page == $articles->currentPage())
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
                                            @if ($articles->hasMorePages())
                                                <li class="page-item" data-aos="zoom-in">
                                                    <a class="page-link" href="{{ $articles->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
