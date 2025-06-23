<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\ArticleImage;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;

class ArticleImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleImage $articleImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArticleImage $articleImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleImage $articleImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleImage $articleImage)
    {
        //
    }
}
