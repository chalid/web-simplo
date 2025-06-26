<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\About;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use Str;
use ImageHelper;

class AboutController extends Controller
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
        $routeAjax      = 'about.get_data';
        $title          = 'List About Us';

        return view('backends.about.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = 'Tambah About';
        return view('backends.about.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'vision'        => 'required',
            'mission'       => 'required',
            'history'       => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'        => 'title wajib diisi',
            'description.required'  => 'description wajib diisi',
            'vision.required'       => 'vision wajib diisi',
            'mission.required'      => 'mission wajib diisi',
            'history.required'      => 'history wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('about.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->is_active == true) {
                About::where('is_active', true)->update(['is_active' => false]);
            }

            $about                      = new About();
            $about->title               = $request->title;
            $about->description         = $request->description;
            $about->vision              = $request->vision;
            $about->mission             = $request->mission;
            $about->history             = $request->history;
            $about->is_active           = $request->is_active;
            $about->meta_title          = $request->title;
            $about->meta_tag            = $request->title;
            $about->meta_description    = Str::limit(strip_tags($request->description), 150);
            $about->meta_keywords       = implode(',', explode(' ', Str::lower($request->title)));
            $about->meta_author         = auth()->check() ? auth()->user()->name : 'Admin';
            $about->meta_image          = $request->image ?? null;
            $about->meta_canonical      = url()->current();
            $about->meta_robots         = 'index, follow';
            $about->slug                = Str::slug($request->title);
            $about->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('about')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'about',['small-thumb', 'meta', 'large']);

                $about->image         = $image;
                $about->meta_image    = $image ?? null;
                $about->update();
            }
            return redirect()->route('about')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(About $about)
    {
        $title  = 'Edit About';
        return view('backends.about.edit', compact('title', 'about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, About $about)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'vision'        => 'required',
            'mission'       => 'required',
            'history'       => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'        => 'title wajib diisi',
            'description.required'  => 'description wajib diisi',
            'vision.required'       => 'vision wajib diisi',
            'mission.required'      => 'mission wajib diisi',
            'history.required'      => 'history wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('about.edit', $about->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->is_active == true) {
                About::where('is_active', true)->update(['is_active' => false]);
            }

            $about->title               = $request->title;
            $about->description         = $request->description;
            $about->vision              = $request->vision;
            $about->mission             = $request->mission;
            $about->history             = $request->history;
            $about->is_active           = $request->is_active;
            $about->meta_title          = $request->title;
            $about->meta_tag            = $request->title;
            $about->meta_description    = Str::limit(strip_tags($request->description), 150);
            $about->meta_keywords       = implode(',', explode(' ', Str::lower($request->title)));
            $about->meta_author         = auth()->check() ? auth()->user()->name : 'Admin';
            $about->meta_image          = $request->image ?? null;
            $about->meta_canonical      = route('web_about');
            $about->meta_robots         = 'index, follow';
            $about->slug                = Str::slug($request->title);
            $about->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('about')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {

                $deleteImage        = ImageHelper::deleteFileExists($about->image,'about',['small-thumb', 'meta', 'large', 'original']);
                
                $file               = $request->file('image');

                $image              = ImageHelper::uploadImage($file,'about',['small-thumb', 'meta', 'large']);

                $about->image      = $image;
                $about->meta_image = $image ?? null;
                $about->update();
            }
            return redirect()->route('about')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $deleteImage = ImageHelper::deleteFileExists($about->image,'about',['small-thumb', 'meta', 'large', 'original']);
            
            $about->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('about')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('about')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $abouts             = About::get(); // eager load roles
            $routeEdit          = 'about.edit';
            $routeDestroy       = 'about.delete';
            $routePermission    = 'about.permission';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';

            return DataTables::of($abouts)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'about/';
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
                ->addColumn('action', function ($abouts) use ($routeEdit, $routeDestroy, $routePermission, $iconEdit, $iconDestroy, $iconPermission) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit about')){
                        $btn_action .=  '<a title="Edit about data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['about' => $abouts->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $abouts->is_active ? '<i class="bi bi-x-circle"></i>&nbsp;' : '<i class="bi bi-check-circle"></i>&nbsp;';
                        $modalId = 'modalToggleStatus' . $abouts->id;
                        $valueActive = $abouts->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('about.active', ['about' => $abouts->id]) . '" method="POST">
                                            <input type="hidden" name="_method" value="patch">
                                            <input type="hidden" name="is_active" value="' . $valueActive . '">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <a title="Change Status" class="btn btn-info btn-sm btn-icon" href="#" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">' . $statusIcon . '</a>&nbsp;
                                            <div class="modal fade" id="' . $modalId . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="' . $modalId . 'Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="' . $modalId . 'Label">Ubah Status</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($abouts->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete about')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['about' => $abouts->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $abouts->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $abouts->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $abouts->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $abouts->id . '">Hapus Data</h1>
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
            ->rawColumns(['abouts', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, About $about)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->is_active == true) {
                About::where('is_active', true)->update(['is_active' => false]);
            }

            $about->is_active           = $request->is_active;
            $about->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('about')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('about')->with('success', 'Berhasil terkirim');
        }
    }
}
