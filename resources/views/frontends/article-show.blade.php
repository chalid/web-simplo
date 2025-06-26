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
                        <a href="{{ route('web_article') }}">
                            Berita dan Artikel
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="news-detail">
        <div class="container">
            <div class="title-page" data-aos="fade-in">
                <h3 class="font-text-bold">Berita dan Artikel</h3>
            </div>
            <div class="news-detail-inside">
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
                                        @foreach($recent_articles as $recent)
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
                            <div class="title-detail" data-aos="fade-in">
                                <h6>{{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}</h6>
                                <h5 class="font-text-bold">{{ $article->title }}</h5>
                            </div>
                            <div class="content-detail">
                                <div class="image-area" data-aos="fade-in">
                                    <figure>
                                        <img src="{{ url('storage/upload_files/images/article/normal') . '/' . $article->image }}" alt="{{ $article->meta_slug }}">
                                    </figure>
                                </div>
                                <div class="article-area" data-aos="fade-in">
                                    <article>
                                        {!! $article->description !!}
                                    </article>
                                </div>
                            </div>
                            <div class="history-post">
                                @if($previous)
                                    <div class="post-list" data-aos="zoom-in">
                                        <div class="post-wrapper">
                                            <h6>Previous Article</h6>
                                            <h5 class="text-ellipsis line-clamp-2">{{ $previous->title }}</h5>
                                            <a href="{{ route('web_article.show', $previous->slug) }}" class="click-area"></a>
                                        </div>
                                    </div>
                                @endif
                                @if($next)
                                    <div class="post-list" data-aos="zoom-in">
                                        <div class="post-wrapper">
                                            <h6>Next Article</h6>
                                            <h5 class="text-ellipsis line-clamp-2">{{ $next->title }}</h5>
                                            <a href="{{ route('web_article.show', $next->slug) }}" class="click-area"></a>
                                        </div>
                                    </div>
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