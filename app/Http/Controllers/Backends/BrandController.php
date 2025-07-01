<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Brand;
use App\Models\Backends\ProductCategory;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class BrandController extends Controller
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
        $confirmDelete      = 'Yakin ingin menghapus data ini?';
        $routeAjax          = 'brand.get_data';
        $title              = 'List Brand';
        $productCategories  = ProductCategory::where('parent_id', 0)->pluck('title', 'id')->put(0, 'Pilih Kategori Produk')->sortKeys();

        return view('backends.brand.index', compact(['confirmDelete','routeAjax','title', 'productCategories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            'product_category_id'   => 'required',
            'is_active'             => 'required|boolean',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'name.required'                 => 'Name wajib diisi',
            'product_category_id.required'  => 'Product category wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
            'image.required'                => 'Hanya gambar',
            'image.mimes'                   => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'                     => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('brand')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $brand                      = new Brand();
            $brand->name                = $request->name;
            $brand->product_category_id = $request->product_category_id;
            $brand->is_active           = $request->is_active;
            $brand->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('brand')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'brand',['small-thumb', 'brand']);

                $brand->image         = $image;
                $brand->update();
            }
            return redirect()->route('brand')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        $title              = 'Edit Brand';
        $productCategories  = ProductCategory::where('parent_id', 0)->pluck('title', 'id')->put(0, 'Pilih Kategori Produk')->sortKeys();
        return view('backends.brand.edit', compact('title', 'brand', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            'product_category_id'   => 'required',
            'is_active'             => 'required|boolean',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'name.required'                 => 'Name wajib diisi',
            'product_category_id.required'  => 'Product category wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
            'image.required'                => 'Hanya gambar',
            'image.mimes'                   => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'                     => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('brand')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $brand->name                = $request->name;
            $brand->product_category_id = $request->product_category_id;
            $brand->is_active           = $request->is_active;
            $brand->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('brand')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {

                $deleteImage        = ImageHelper::deleteFileExists($brand->image,'brand',['small-thumb', 'brand', 'ori']);
                
                $file               = $request->file('image');

                $image              = ImageHelper::uploadImage($file,'brand',['small-thumb', 'brand']);

                $brand->image      = $image;
                $brand->update();
            }
            return redirect()->route('brand')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            
            $deleteImage = ImageHelper::deleteFileExists($brand->image,'brand',['small-thumb', 'brand', 'ori']);

            $brand->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('brand')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('brand')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $brands             = Brand::with('category'); // eager load roles
            $routeEdit          = 'brand.edit';
            $routeDestroy       = 'brand.delete';
            $routePermission    = 'brand.permission';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';
            $productCategories  = ProductCategory::where('parent_id', 0)->pluck('title', 'id')->put(0, 'Pilih Kategori Produk')->sortKeys();

            return DataTables::of($brands)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'brand/';
                    $thumbPath = $item->image
                        ? url($path . $dir . 'small-thumb/' . $item->image)
                        : url('assets/backend/images/png/no_image.png');

                    $originalPath = $item->image
                        ? url($path . $dir . 'brand/' . $item->image)
                        : '#';

                    return '<a href="' . $originalPath . '" target="_blank">
                                <img src="' . $thumbPath . '" alt="' . e($item->name) . '" title="' . e($item->name) . '" height="50">
                            </a>';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->category->title ?? '-';
                })
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->orderColumn('category_name', function ($query, $order) {
                    $query->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
                        ->orderBy('product_categories.name', $order);
                })
                ->addColumn('action', function ($brands) use ($routeEdit, $routeDestroy, $routePermission, $iconEdit, $iconDestroy, $iconPermission, $productCategories) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit brand')){
                        $btn_action .=  '<a title="Edit product data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['brand' => $brands->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $brands->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $brands->id;
                        $valueActive = $brands->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('brand.active', ['brand' => $brands->id]) . '" method="POST">
                                            <input type="hidden" name="_method" value="patch">
                                            <input type="hidden" name="is_active" value="' . $valueActive . '">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <a title="Change Status" class="btn btn-info btn-sm btn-icon" href="#" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">' . $statusIcon . '</a>
                                            <div class="modal fade" id="' . $modalId . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="' . $modalId . 'Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="' . $modalId . 'Label">Ubah Status</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($brands->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Ya, Ubah</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete brand')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['brand' => $brands->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $brands->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $brands->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $brands->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $brands->id . '">Hapus Data</h1>
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
            ->rawColumns(['brands', 'image', 'action', 'category_name']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Brand $brand)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $brand->is_active           = $request->is_active;
            $brand->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('brand')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('brand')->with('success', 'Berhasil terkirim');
        }
    }
}
