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
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="faq">
        <div class="container">
            <div class="title-page with-share" data-aos="fade-in">
                <h3 class="font-text-bold">Frequently Asked Questions</h3>
            </div>
            <div class="faq-inside">
                <div class="row no-gutters">
                    <div class="col-md-4 col-lg-3">
                        <div class="sidebar-news" data-aos="zoom-in">
                            <div class="sidebar-category">
                                <div class="sidebar-group">
                                    <h5 class="font-text-bold">
                                        <span>Kategori</span>
                                    </h5>
                                    <ul class="sidebar-list">
                                        @forelse($categories ?? [] as $cat)
                                            <li>
                                                <a href="{{ route('web_faq', $cat->slug) }}"
                                                    class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                                    <span>{{ $cat->name }}</span>
                                                    <span class="icon fa fa-angle-right"></span>
                                                </a>
                                            </li>
                                        @empty
                                            <li>
                                                <a href="#">
                                                    <p>Tidak ada kategori.</p>
                                                </a>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="faq-area">
                            <div class="title-detail" data-aos="fade-in">
                                <h5 class="font-text-bold">{{ $category?->name ?? 'Pilih Kategori' }}</h5>
                            </div>
                            <div class="faq-content" data-aos="fade-in">
                                <div class="accordion custom-accordion" id="accordionExample">
                                    @if(isset($category) && $category?->faqs?->isNotEmpty())
                                    <div class="accordion-list">
                                        <div class="accordion-head" id="heading{{ $faq->position }}">
                                            <h5 class="toggle-collapse" data-toggle="collapse" data-target="#collapse{{ $faq->position }}" aria-expanded="true" aria-controls="collapse{{ $faq->position }}">
                                                {!! $faq->question !!}
                                            </h5>
                                        </div>
                                        <div id="collapse{{ $faq->position }}" class="collapse show" aria-labelledby="heading{{ $faq->position }}" data-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p>
                                                    {!! $faq->answer !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="accordion-list">
                                        <div>
                                            <div class="alert alert-info">
                                                Tidak ada FAQ tersedia. Silakan pilih kategori.
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
