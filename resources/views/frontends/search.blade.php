@extends('layouts.frontend.app')
@section('title', 'Search: '.$q)
@section('content')
<div class="container py-5">
    <h4 class="mb-4">Search results for “{{ $q }}”</h4>

    <div class="row row-cols-2 row-cols-md-4 g-4">
        @forelse ($products as $product)
            <div class="col" data-aos="zoom-in">
                <a href="{{ route('web_product.show', $product->slug) }}"
                   class="card h-100 text-dark text-decoration-none">
                    <img src="{{ $product->thumb_url }}" class="card-img-top" alt="">
                    <div class="card-body small text-center">{{ $product->name }}</div>
                </a>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>

    {{ $products->links() }}
</div>
@endsection
