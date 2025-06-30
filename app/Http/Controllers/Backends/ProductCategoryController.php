<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\ProductCategory;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use Str;
use ImageHelper;

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
        $parents        = ProductCategory::where('parent_id', 0)->pluck('title', 'id')->put(0, 'Sebagai Parent')->sortKeys();

        return view('backends.product_category.index', compact(['confirmDelete','routeAjax','title', 'parents']));
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
            'title'     => 'required',
            'is_active' => 'required',
        ], [
            'title.required'        => 'title wajib diisi',
            'is_active.required'    => 'is_active wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product-category')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $productCategory                    = new ProductCategory();
            $productCategory->title             = $request->title;
            $productCategory->parent_id         = $request->parent_id;
            $productCategory->is_active         = $request->is_active;
            $productCategory->meta_tag          = $request->title;
            $productCategory->meta_image        = null;
            $productCategory->slug              = Str::slug($request->title);
            $productCategory->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('product-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'product_category',['small-thumb', 'meta', 'category']);

                $productCategory->image         = $image;
                $productCategory->meta_image    = $image ?? null;
                $productCategory->update();
            }
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
        $title      = 'Edit Product Category';
        $parents    = ProductCategory::where('parent_id', 0)->pluck('title', 'id')->put(0, 'Sebagai Parent')->sortKeys();

        return view('backends.product_category.edit', compact(['productCategory', 'title', 'parents']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $productCategory->title             = $request->title;
            $productCategory->parent_id         = $request->parent_id;
            $productCategory->is_active         = $request->is_active;
            $productCategory->slug              = Str::slug($request->title);
            $productCategory->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product-category.edit', $productCategory->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {

                $deleteImage        = ImageHelper::deleteFileExists($productCategory->image,'about',['small-thumb', 'meta', 'category', 'ori']);
                
                $file               = $request->file('image');

                $image              = ImageHelper::uploadImage($file,'product_category',['small-thumb', 'meta', 'category']);

                $productCategory->image      = $image;
                $productCategory->meta_image = $image ?? null;
                $productCategory->update();
            }
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
            $deleteImage = ImageHelper::deleteFileExists($productCategory->image,'product_category',['small-thumb', 'meta', 'category', 'ori']);
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
            $productCategories  = ProductCategory::with('children')->where('parent_id',0)->get();

            $routeEdit          = 'product-category.edit';
            $routeDestroy       = 'product-category.delete';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';

            return DataTables::of($productCategories)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->addColumn('action', function ($productCategories) use ($routeEdit,$routeDestroy,$iconEdit,$iconDestroy) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit product category')){
                        $btn_action .=  '<a title="Edit Data" class="btn btn-warning btn-sm" href="'. route($routeEdit, ['productCategory' => $productCategories->id]) . '">' . $iconEdit . '</a>&nbsp;';
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
                                                            <button type="submit" class="btn btn-success">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    $btn_action .=  '</div>';
                    return $btn_action;
                })
            ->rawColumns(['action'])
            ->editColumn('children', function ($productCategories) use($routeDestroy, $iconDestroy){
                $children    = $productCategories->children;
                $newChildren = [];
                if (is_object($productCategories->children) && $productCategories->children->count() > 0) {
                    foreach ($productCategories->children as $item) {
                        $action = '';
                        if(Auth::user()->can('Can edit product category')){
                            $action .= "<a href='" . route('product-category.edit', ['productCategory' => $item->id]) . "' class='btn btn-warning btn-sm' title='Edit'>
                                          <i class='bi bi-pencil'></i>
                                        </a>&nbsp";
                        }
                        if(Auth::user()->can('Can delete product category')){
                            $action .= '<form action="' . route($routeDestroy, ['productCategory' => $item->id]) . '" method="POST">' .
                                        '<input type="hidden" name="_method" value="DELETE">' . // Add this line to specify the PATCH method
                                        '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $item->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $item->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $item->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $item->id . '">Hapus Data</h1>
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
                        $item['action'] = $action;
                        $newChildren[]  = $item;
                    }
                }
    
                return $newChildren;
            })->escapeColumns([])->setRowClass(function ($newProductCategories) {
                if ($newProductCategories->children && $newProductCategories->children()->count() > 0) return 'has-child';
                else return '';})
            ->make(true);
        }
    }
}
