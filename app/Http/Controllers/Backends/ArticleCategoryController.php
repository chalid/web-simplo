<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\ArticleCategory;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;

class ArticleCategoryController extends Controller
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
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        $routeAjax      = 'article-category.get_data';
        $title          = 'List Article Category';

        return view('backends.article_category.index', compact(['confirmDelete','routeAjax','title']));
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
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'description'   => 'required',
        ], [
            'name.required'         => 'name wajib diisi',
            'description.required'  => 'description wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('article-category')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $articleCategory                = new ArticleCategory();
            $articleCategory->name          = $request->name;
            $articleCategory->description   = $request->description;
            $articleCategory->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('article-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('article-category')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleCategory $articleCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArticleCategory $articleCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleCategory $articleCategory)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $articleCategory->name          = $request->name;
            $articleCategory->description   = $request->description;
            $articleCategory->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('article-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('article-category')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $articleCategory->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('article-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('article-category')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $articleCategories  = ArticleCategory::get();

            $routeEdit          = 'article-category.update';
            $routeDestroy       = 'article-category.delete';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';

            return DataTables::of($articleCategories)
                ->addIndexColumn()
                ->addColumn('action', function ($articleCategories) use ($routeEdit,$routeDestroy,$iconEdit,$iconDestroy) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit article category')){
                        $btn_action .=  '<form action="' . route($routeEdit, ['articleCategory' => $articleCategories->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="PATCH">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-warning btn-sm" title="Edit Data" href="" data-bs-target="#staticBackdrop' . $articleCategories->id . '">' . $iconEdit . '</a>' .
                                            '<div class="modal fade" id="staticBackdrop' . $articleCategories->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel' . $articleCategories->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel' . $articleCategories->id . '">Edit Data</h1>
                                                            <button type="button" class="btn-close clear-form" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-4 col-form-label">Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="name" class="form-control" id="name" value="' . $articleCategories->name . '" required>
                                                                    <div class="invalid-feedback">Harap isi sgroup</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="description" class="col-sm-4 col-form-label">description</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="description" class="form-control" id="description" value="' . $articleCategories->description . '" required>
                                                                    <div class="invalid-feedback">Harap isi description</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger clear-form" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete article category')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['articleCategory' => $articleCategories->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="DELETE">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $articleCategories->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $articleCategories->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $articleCategories->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $articleCategories->id . '">Hapus Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 row">
                                                                <p>Anda yakin ingin menghapus data ini</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-success">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    $btn_action .=  '</div>';

                    return $btn_action;
                })
            ->rawColumns(['action']) // to html
            ->make(true);
        }
    }
}
