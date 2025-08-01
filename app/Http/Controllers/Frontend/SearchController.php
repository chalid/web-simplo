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

    // In your SearchController.php
    public function suggest(Request $request)
    {
        try {
            $q = trim($request->input('q', ''));
            
            if (strlen($q) < 2) {
                return response()->json([]);
            }

            // Initialize empty collections
            $products = collect();
            $articles = collect();

            // Only query if needed
            if (strlen($q) >= 2) {
                $products = Product::where('title', 'like', "%$q%")
                    ->where('is_active', true)
                    ->limit(5)
                    ->get()
                    ->map(function($item) {
                        return [
                            'title' => $item->title,
                            'url' => route('web_product.show', $item->slug),
                            'type' => 'Product'
                        ];
                    });

                $articles = Article::where('title', 'like', "%$q%")
                    ->where('is_active', true)
                    ->limit(5)
                    ->get()
                    ->map(function($item) {
                        return [
                            'title' => $item->title,
                            'url' => route('web_article.show', $item->slug),
                            'type' => 'Article'
                        ];
                    });
            }

            // Merge as arrays, not collections
            $results = $products->toArray();
            $results = array_merge($results, $articles->toArray());

            return response()->json($results, 200, [
                'Content-Type' => 'application/json'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Search service unavailable',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
