<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backends\Product;
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
                    ->where('parent_id', 0)
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
}
