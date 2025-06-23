@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
<main class="project" id="project" >
    <section class="title-page">
        <div class="title-area">
            <div class="container">
                <h3 data-aos="fade-right">
                    Our
                    <span>Projects</span>
                </h3>
            </div>
        </div>
    </section>
    <section class="filter-project">
        <div class="container">
            <div class="container-mix">
                <div class="row no-gutters">
                    @foreach ($projects as $item)
                        <div class="col-md-6 mix">
                            <div class="project-wrapper" data-aos="zoom-in">
                                <div class="project">
                                    <div class="image-area shadow">
                                        <img src="{{ url('storage/upload_files/images/project/small') . '/' . $item->image }}" alt="{{ $item->title }}">
                                    </div>
                                    <ul class="tag">
                                        <li>
                                            <span>{{ $item->category->name }}</span>
                                        </li>
                                    </ul>
                                    <div class="desc-area">
                                        <h5>{{ $item->title }}</h5>
                                    </div>
                                    <a href="{{ route('web_project.show', ['slug' => $item->slug]) }}" class="link"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($projects->hasPages())
                <nav class="pagination-area">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($projects->onFirstPage())
                            <li class="page-item disabled" data-aos="zoom-in">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @else
                            <li class="page-item" data-aos="zoom-in">
                                <a class="page-link" href="{{ $projects->previousPageUrl() }}" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-left"></i></a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @foreach ($projects->links()->elements as $element)
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $projects->currentPage())
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
                        @if ($projects->hasMorePages())
                            <li class="page-item" data-aos="zoom-in">
                                <a class="page-link" href="{{ $projects->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
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