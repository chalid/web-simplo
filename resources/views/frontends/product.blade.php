@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
<div class="page-content">
    <div class="breadcrumb-page" data-aos="fade-in">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('web_index')}}">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Produk Kami</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="product">
        <div class="container">
            <div class="title-page" data-aos="fade-in">
                <h3 class="font-text-bold">{{ $activeCat ? $activeCat->name : 'Semua Produk' }}</h3>
            </div>
            <div class="product-inside">
                <div class="row no-gutters">
                    <div class="col-md-4 col-lg-3">
                        <div class="sidebar-area" data-aos="zoom-in">
                            <div class="sidebar-category">
                                <div class="sidebar-head show-desktop"><h5><span>Kategori</span></h5></div>
                                <div class="sidebar-head show-mobile collapse-button">
                                    <h5><span>Kategori</span><span class="icon fa fa-angle-down"></span></h5>
                                </div>
                                <div class="sidebar-body">
                                    {{-- ================== BEGIN INLINE CATEGORY TREE ================== --}}
                                    @php
                                        // helper so we can call it recursively
                                        $printTree = function ($nodes, $activeCat) use (&$printTree) {
                                            echo '<ul class="sidebar-list">';

                                            foreach ($nodes as $node) {
                                                $isActive = $activeCat && $activeCat->id === $node->id;
                                                $hasChild = $node->children->isNotEmpty();

                                                echo '<li>';
                                                echo    '<a href="'.route('web_product', ['cat'=>$node->slug]).'"'.
                                                            ($isActive ? ' class="active"' : '').'>';
                                                echo        '<span>'.$node->title.'</span>';
                                                if ($hasChild) {
                                                    echo    '<span class="icon fa fa-angle-right"></span>';
                                                }
                                                echo    '</a>';

                                                if ($hasChild) {
                                                    // recurse
                                                    $printTree($node->children, $activeCat);
                                                }
                                                echo '</li>';
                                            }

                                            echo '</ul>';
                                        };
                                    @endphp

                                    {{-- kick off the tree (pass $activeCat even if it’s null) --}}
                                    {!! $printTree($menuRoots, $activeCat ?? null) !!}
                                    {{-- ================== END INLINE CATEGORY TREE ==================== --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="content-area">
                            <div class="content-wrapper">
                                <div class="row no-gutters">
                                    @forelse($products as $product)
                                        <div class="col-md-6 col-lg-4" data-aos="zoom-in">
                                            <div class="thumbnail-info model-2 square-image">
                                                <div class="thumbnail-wrapper">
                                                    <div class="image-area">
                                                        <figure><img src="{{ url('storage/upload_files/images/product/small') . '/' . $product->image }}" alt="{{ $product->meta_tag }}"></figure>
                                                    </div>
                                                    <div class="info-area">
                                                        <span class="category-label">{{ $product->category->title }}</span>
                                                        <p class="font-text-bold">{{ $product->title }}</p>
                                                    </div>
                                                    <a href="{{ route('web_product.show', $product->slug) }}" class="click-area"></a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p>Tidak ada produk.</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="paging-area mt-4">{{ $products->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection