<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Product;
use App\Models\Backends\ProductCategory;
use App\Models\Backends\ProductImage;
use App\Models\Backends\Sequence;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class ProductController extends Controller
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
        $routeAjax      = 'product.get_data';
        $title          = 'List Product';

        return view('backends.product.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title              = 'Tambah Product';
        $productCategories  = ProductCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Produk')->sortKeys();
        return view('backends.product.create', compact('title', 'productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required',
            'description'           => 'required',
            'product_category_id'   => 'required',
            'is_active'             => 'required|boolean',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'                => 'title wajib diisi',
            'description.required'          => 'description wajib diisi',
            'product_category_id.required'  => 'kategori produk wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
            'image.required'                => 'Hanya gambar',
            'image.mimes'                   => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'                     => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $category = ProductCategory::findOrFail($request->product_category_id);
            $skey = $category->code;
            $format = '%05d';

            // Fetch or create new sequence
            $sequence = Sequence::firstOrNew(['skey' => $skey]);

            // Increment and save
            $sequence->sequence = ($sequence->sequence ?? 0) + 1;
            $sequence->save();

            // Format the sequence
            $seq = sprintf($format, $sequence->sequence);

            $product                        = new Product();
            $product->title                 = $request->title;
            $product->description           = $request->description;
            $product->is_active             = $request->is_active;
            $product->product_category_id   = $request->product_category_id;
            $product->code_no               = $skey . $seq;
            $product->meta_title            = $request->title;
            $product->meta_description      = Str::limit(strip_tags($request->description), 150);
            $product->meta_keywords         = implode(',', explode(' ', Str::lower($request->title)));
            $product->meta_author           = auth()->check() ? auth()->user()->name : 'Admin';
            $product->meta_image            = null;
            $product->meta_canonical        = url()->current();
            $product->meta_robots           = 'index, follow';
            $product->slug                  = Str::slug($request->title);
            $product->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('product.create')->with('error', $e->getMessage())->withInput();
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'product',['small-thumb', 'small','normal', 'meta', 'large']);

                $product->image         = $image;
                $product->meta_image    = $image ?? null;
                $product->update();

                $productImage               = new ProductImage();
                $productImage->product_id   = $product->id;
                $productImage->uri          = $image;
                $productImage->is_default   = true;
                $productImage->save();
            }
            return redirect()->route('product')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $title          = 'Detail Product';
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        return view('backends.product.show', compact('title', 'product', 'confirmDelete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $title              = 'Edit Product';
        $productCategories  = ProductCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Produk')->sortKeys();
        return view('backends.product.edit', compact('title', 'product', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required',
            'description'           => 'required',
            'product_category_id'   => 'required',
            'is_active'             => 'required|boolean',
        ], [
            'title.required'                => 'title wajib diisi',
            'description.required'          => 'description wajib diisi',
            'product_category_id.required'  => 'kategori produk wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.edit', $product->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $product->title                 = $request->title;
            $product->description           = $request->description;
            $product->product_category_id   = $request->product_category_id;
            $product->is_active             = $request->is_active;
            $product->meta_title            = $request->title;
            $product->meta_description      = Str::limit(strip_tags($request->description), 150);
            $product->meta_keywords         = implode(',', explode(' ', Str::lower($request->title)));
            $product->meta_author           = auth()->check() ? auth()->user()->name : 'Admin';
            $product->meta_canonical        = url()->current();
            $product->meta_robots           = 'index, follow';
            $product->slug                  = Str::slug($request->title);
            $product->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            foreach($product->images as $image){
                $deleteImage = ImageHelper::deleteFileExists($image->uri,'product',['small-thumb', 'small','normal', 'meta', 'large', 'ori']);
            }
            $product->images->each->delete();

            $product->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $products           = Product::with('category'); // eager load roles
            $routeEdit          = 'product.edit';
            $routeDestroy       = 'product.delete';
            $routePermission    = 'product.permission';
            $routeShow          = 'product.show';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';
            $iconShow           = '<i class="bi bi-eye"></i>';

            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'product/';
                    $thumbPath = $item->image
                        ? url($path . $dir . 'small-thumb/' . $item->image)
                        : url('assets/backend/images/png/no_image.png');

                    $originalPath = $item->image
                        ? url($path . $dir . 'large/' . $item->image)
                        : '#';

                    return '<a href="' . $originalPath . '" target="_blank">
                                <img src="' . $thumbPath . '" alt="' . e($item->name) . '" title="' . e($item->name) . '" height="50">
                            </a>';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->category->name ?? '-';
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
                ->addColumn('action', function ($products) use ($routeEdit, $routeDestroy, $routePermission, $routeShow, $iconEdit, $iconDestroy, $iconPermission, $iconShow) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can show product')){
                        $btn_action .=  '<a title="Show product data" class="btn btn-primary btn-sm btn-icon" href="' . route($routeShow, ['product' => $products->id]) . '">' . $iconShow . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can edit product')){
                        $btn_action .=  '<a title="Edit product data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['product' => $products->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $products->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $products->id;
                        $valueActive = $products->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('product.active', ['product' => $products->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($products->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete product')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['product' => $products->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $products->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $products->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $products->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $products->id . '">Hapus Data</h1>
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
            ->rawColumns(['products', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Product $product)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $product->is_active           = $request->is_active;
            $product->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product')->with('success', 'Berhasil terkirim');
        }
    }

    public function imageAdd(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'image.required'    => 'Hanya gambar',
            'image.mimes'       => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'         => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.show', $product->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }
        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'product',['small-thumb', 'small','normal', 'meta', 'large']);

                $product->image         = $image;
                $product->meta_image    = $image ?? null;
                $product->update();

                $oldProductImage            = ProductImage::where('product_id', $product->id)->where('is_default', true)->update(['is_default' => false]);

                $productImage              = new ProductImage();
                $productImage->product_id  = $product->id;
                $productImage->uri         = $image;
                $productImage->is_default  = true;
                $productImage->save();
            }

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product.show', $product->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product.show', $product->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageSetDefault(Request $request, Product $product, ProductImage $productImage)
    {
        $productImage = ProductImage::find($request->image_id);

        DB::beginTransaction();
        $success_trans = false;

        try {

            $product->image             = $productImage->uri;
            $product->meta_image        = $productImage->uri ?? null;
            $product->update();

            $oldProductImage            = ProductImage::where('product_id', $product->id)->where('is_default', true)->update(['is_default' => false]);

            $productImage->is_default  = true;
            $productImage->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product.show', $product->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product.show', $product->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageDelete(Request $request, Product $product, ProductImage $productImage)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $productImage = ProductImage::find($request->image_id);

            $product->image             = null;
            $product->meta_image        = null;
            $product->update();

            $deleteImage = ImageHelper::deleteFileExists($productImage->uri,'product',['small-thumb', 'small','normal', 'meta', 'large', 'ori']);
            $productImage->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('product.show', $product->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('product.show', $product->id)->with('success', 'Berhasil terkirim');
        }
    }
}
