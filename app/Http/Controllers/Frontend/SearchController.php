<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backends\Product;
use App\Models\Backends\Article;
use App\Models\Backends\ProductCategory;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim($request->query('q'));
        $products = Product::when($q, fn ($b) =>
                        $b->where('title', 'like', "%{$q}%"))
                    ->paginate(12)
                    ->withQueryString();

        // sidebar still needs the tree
        $menuRoots = ProductCategory::with('children')
                    ->where('parent_id', null)
                    ->orderBy('title')
                    ->get();

        /* nothing is “active” on a global search */
        $activeCat = null;

        return view('frontends.product', compact(
            'products',   // reuse the same template
            'menuRoots',
            'activeCat'
        ))->with([
            'title' => 'Search results',
            'body'  => 'search-page',
        ]);
    }

    public function suggest(Request $request)
    {
        $q = trim($request->query('q'));
        \Log::debug('Search query received:', ['query' => $q]);
        
        if (empty($q)) {
            return response()->json([]);
        }

        $productResults = Product::where('title', 'like', "%{$q}%")
                            ->where('is_active', true)
                            ->take(5)
                            ->get()
                            ->map(function($item) {
                                return [
                                    'title' => $item->title,
                                    'url' => route('web_product.show', $item->slug),
                                    'type' => 'Product'
                                ];
                            });

        $articleResults = Article::where('title', 'like', "%{$q}%")
                            ->where('is_active', true)
                            ->take(5)
                            ->get()
                            ->map(function($item) {
                                return [
                                    'title' => $item->title,
                                    'url' => route('web_article.show', $item->slug),
                                    'type' => 'Article'
                                ];
                            });

        $results = $productResults->merge($articleResults)->take(8);

        return response()->json($results);
    }
}
