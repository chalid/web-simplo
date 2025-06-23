@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
<main class="article-detail-page" id="article-detail-page" >
    <section class="title-page">
        <div class="title-area">
            <div class="container">
                <h3 data-aos="fade-right">
                    Our
                    <span>Article's</span>
                </h3>
            </div>
        </div>
    </section>
    <section class="article-news-detail">
        <div class="container">
            <div class="article-area">
                <div class="row no-gutters">
                    <div class="col-md-4 col-lg-3">
                        <div class="sidebar-news" data-aos="zoom-in">
                            <div class="sidebar-category">
                                <div class="sidebar-group">
                                    <h5>
                                        <span>Kategori</span>
                                    </h5>
                                    <ul class="sidebar-list">
                                        @foreach($categories as $cat)
                                            <li>
                                                <a href="{{ route('web_article', ['category' => $cat->id]) }}" class="{{ $article->article_category_id == $cat->id ? 'active' : '' }}">
                                                    <span>{{ $cat->name }}</span>
                                                    <span class="icon fa fa-angle-right"></span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="sidebar-group">
                                    <h5>
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
                                <h5>{{ $article->title }}</h5>
                            </div>
                            <div class="content-detail">
                                <div class="image-area" data-aos="fade-in">
                                    <figure class="image-wrapper selector" data-exthumbimage="{{ url('storage/upload_files/images/article/small/' . $article->image) }}" data-src="{{ url('storage/upload_files/images/article/small/' . $article->image) }}">
                                        <img src="{{ url('storage/upload_files/images/article/large/' . $article->image) }}" alt="{{ $article->title }}">
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
                                    </figure>
                                </div>
                                <div class="article-area" data-aos="fade-in">
                                    <article>
                                        {!! $article->description !!}
                                    </article>
                                </div>
                                <div class="gallery-area">
                                    <div class="title-detail" data-aos="fade-in">
                                        <h5>Gallery</h5>
                                    </div>
                                    <div class="row no-gutters">
                                        @foreach($article->images as $item)
                                            <div class="col-md-6">
                                                <div class="gallery-wrapper" data-aos="zoom-in">
                                                    <figure class="image-wrapper selector" data-exthumbimage="{{ url('storage/upload_files/images/article/small/' . $item->uri) }}" data-src="{{ url('storage/upload_files/images/article/small/' . $item->uri) }}">
                                                        <img src="{{ url('storage/upload_files/images/article/large/' . $item->uri) }}" alt="{{ $article->title }}">
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
                                                    </figure>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
</main>
@endsection