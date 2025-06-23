@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
    <main class="contact" id="contact" >
        <section class="map-contact">
            <div class="map" data-aos="fade-in">
                <div id="map-header"></div>
                <!-- <div id="map-canvas"></div> -->
                <iframe width="2560" height="1600" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=arjayamarine&key=AIzaSyC41txvb55lPFJ_4QpudYNx0qMojfgu8Rw" allowfullscreen></iframe>
                <div id="map-footer"></div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC41txvb55lPFJ_4QpudYNx0qMojfgu8Rw"></script>
@endsection