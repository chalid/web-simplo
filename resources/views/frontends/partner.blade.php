@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
    <main class="partners" id="partners" >
        <section class="title-page">
            <div class="title-area">
                <div class="container">
                    <h3 data-aos="fade-right">
                        Our
                        <span>Partners</span>
                    </h3>
                </div>
            </div>
        </section>
        <section class="partner-thumbnails">
            <div class="container">
                <div class="row no-gutters">
                    @foreach($partners as $item)
                        <div class="col-4 col-md-3">
                            <div class="partner-wrapper">
                                <div class="image-area" data-aos="zoom-in">
                                    <img src="{{ url('storage/upload_files/images/partner/web-smaller') . '/' . $item->image }}" alt="{{ $item->title }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection