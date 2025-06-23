<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\ProductCategory;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;

class ProductCategoryController extends Controller
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
        $routeAjax      = 'product-category.get_data';
        $title          = 'List Product Category';

        return view('backends.product_category.index', compact(['confirmDelete','routeAjax','title']));
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
            'code'          => 'required',
        ], [
            'name.required'         => 'name wajib diisi',
            'description.required'  => 'description wajib diisi',
            'code.required'         => 'code wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product-category')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $productCategory                = new ProductCategory();
            $productCategory->name          = $request->name;
            $productCategory->description   = $request->description;
            $productCategory->code          = $request->code;
            $productCategory->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('product-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product-category')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $productCategory->name          = $request->name;
            $productCategory->description   = $request->description;
            $productCategory->code          = $request->code;
            $productCategory->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product-category')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $productCategory->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product-category')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $productCategories  = ProductCategory::get();

            $routeEdit          = 'product-category.update';
            $routeDestroy       = 'product-category.delete';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';

            return DataTables::of($productCategories)
                ->addIndexColumn()
                ->addColumn('action', function ($productCategories) use ($routeEdit,$routeDestroy,$iconEdit,$iconDestroy) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit product category')){
                        $btn_action .=  '<form action="' . route($routeEdit, ['productCategory' => $productCategories->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="PATCH">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-warning btn-sm" title="Edit Data" href="" data-bs-target="#staticBackdrop' . $productCategories->id . '">' . $iconEdit . '</a>' .
                                            '<div class="modal fade" id="staticBackdrop' . $productCategories->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel' . $productCategories->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel' . $productCategories->id . '">Edit Data</h1>
                                                            <button type="button" class="btn-close clear-form" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-4 col-form-label">Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="name" class="form-control" id="name" value="' . $productCategories->name . '" required>
                                                                    <div class="invalid-feedback">Harap isi sgroup</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="description" class="col-sm-4 col-form-label">description</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="description" class="form-control" id="description" value="' . $productCategories->description . '" required>
                                                                    <div class="invalid-feedback">Harap isi description</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="code" class="col-sm-4 col-form-label">code</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="code" class="form-control" id="code" value="' . $productCategories->code . '" required>
                                                                    <div class="invalid-feedback">Harap isi code</div>
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
                    if(Auth::user()->can('Can delete product category')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['productCategory' => $productCategories->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="DELETE">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $productCategories->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $productCategories->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $productCategories->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $productCategories->id . '">Hapus Data</h1>
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
