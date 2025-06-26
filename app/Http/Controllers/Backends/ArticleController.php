<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Article;
use App\Models\Backends\ArticleCategory;
use App\Models\Backends\ArticleImage;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class ArticleController extends Controller
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
        $routeAjax      = 'article.get_data';
        $title          = 'List Article';

        return view('backends.article.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title              = 'Tambah Article';
        $articleCategories  = ArticleCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Article')->sortKeys();
        return view('backends.article.create', compact('title', 'articleCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required',
            'description'           => 'required',
            'article_category_id'   => 'required',
            'is_active'             => 'required|boolean',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'                => 'title wajib diisi',
            'description.required'          => 'description wajib diisi',
            'article_category_id.required'  => 'kategori article wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
            'image.required'                => 'Hanya gambar',
            'image.mimes'                   => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'                     => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('article.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $article                        = new Article();
            $article->title                 = $request->title;
            $article->description           = $request->description;
            $article->is_active             = $request->is_active;
            $article->article_category_id   = $request->article_category_id;
            $article->meta_title            = $request->title;
            $article->meta_description      = Str::limit(strip_tags($request->description), 150);
            $article->meta_keywords         = implode(',', explode(' ', Str::lower($request->title)));
            $article->meta_author           = auth()->check() ? auth()->user()->name : 'Admin';
            $article->meta_image            = null;
            $article->meta_canonical        = route('web_article.show', Str::slug($request->title));
            $article->meta_robots           = 'index, follow';
            $article->slug                  = Str::slug($request->title);
            $article->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('article')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'article',['small-thumb', 'small','normal', 'meta']);

                $article->image         = $image;
                $article->meta_image    = $image ?? null;
                $article->update();
            }
            return redirect()->route('article')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        $titleImage     = 'Image Article';
        $title          = 'Detail Article';
        return view('backends.article.show', compact('title', 'article', 'titleImage', 'confirmDelete'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $title              = 'Edit Article';
        $articleCategories  = ArticleCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Article')->sortKeys();
        return view('backends.article.edit', compact('title', 'article', 'articleCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required',
            'description'           => 'required',
            'article_category_id'   => 'required',
            'is_active'             => 'required|boolean',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'                => 'title wajib diisi',
            'description.required'          => 'description wajib diisi',
            'article_category_id.required'  => 'kategori article wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('article.edit', $article->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $article->title                 = $request->title;
            $article->description           = $request->description;
            $article->is_active             = $request->is_active;
            $article->article_category_id   = $request->article_category_id;
            $article->meta_title            = $request->title;
            $article->meta_description      = Str::limit(strip_tags($request->description), 150);
            $article->meta_keywords         = implode(',', explode(' ', Str::lower($request->title)));
            $article->meta_author           = auth()->check() ? auth()->user()->name : 'Admin';
            $article->meta_canonical        = route('web_article.show', Str::slug($request->title));
            $article->meta_robots           = 'index, follow';
            $article->slug                  = Str::slug($request->title);
            $article->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('article')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'article',['small-thumb', 'small','normal', 'meta']);

                $article->image         = $image;
                $article->meta_image    = $image ?? null;
                $article->update();
            }
            return redirect()->route('article')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            
            foreach($article->images as $image){
                $deleteImage = ImageHelper::deleteFileExists($image->uri,'article',['small-thumb', 'small','normal', 'meta', 'original']);
            }
            $article->images->each->delete();

            $article->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('article')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('article')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $articles           = Article::with('category'); // eager load roles
            $routeEdit          = 'article.edit';
            $routeDestroy       = 'article.delete';
            $routePermission    = 'article.permission';
            $routeShow          = 'article.show';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';
            $iconShow           = '<i class="bi bi-eye"></i>';

            return DataTables::of($articles)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
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
                    $query->join('article_categories', 'articles.article_category_id', '=', 'article_categories.id')
                        ->orderBy('article_categories.name', $order);
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'article/';
                    $thumbPath = $item->image
                        ? url($path . $dir . 'small-thumb/' . $item->image)
                        : url('assets/backend/images/png/no_image.png');

                    $originalPath = $item->image
                        ? url($path . $dir . 'normal/' . $item->image)
                        : '#';

                    return '<a href="' . $originalPath . '" target="_blank">
                                <img src="' . $thumbPath . '" alt="' . e($item->name) . '" title="' . e($item->name) . '" height="50">
                            </a>';
                })
                ->addColumn('action', function ($articles) use ($routeEdit, $routeDestroy, $routePermission, $routeShow, $iconEdit, $iconDestroy, $iconPermission, $iconShow) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can show article')){
                        $btn_action .=  '<a title="Show article data" class="btn btn-primary btn-sm btn-icon" href="' . route($routeShow, ['article' => $articles->id]) . '">' . $iconShow . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can edit article')){
                        $btn_action .=  '<a title="Edit article data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['article' => $articles->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $articles->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $articles->id;
                        $valueActive = $articles->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('article.active', ['article' => $articles->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($articles->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete article')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['article' => $articles->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $articles->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $articles->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $articles->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $articles->id . '">Hapus Data</h1>
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
            ->rawColumns(['articles', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Article $article)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $article->is_active           = $request->is_active;
            $article->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('article')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('article')->with('success', 'Berhasil terkirim');
        }
    }

    public function imageAdd(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'image.required'    => 'Hanya gambar',
            'image.mimes'       => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'         => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('article.show', $article->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }
        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'article',['small-thumb', 'small','normal', 'meta']);

                $article->image         = $image;
                $article->meta_image    = $image ?? null;
                $article->update();
            }

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('article.show', $article->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('article.show', $article->id)->with('success', 'Berhasil terkirim');
        }
    }
}