<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Vision;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class VisionController extends Controller
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
        $routeAjax      = 'vision.get_data';
        $title          = 'List Vision';

        return view('backends.vision.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = 'Tambah Vision';
        return view('backends.vision.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'        => 'title wajib diisi',
            'description.required'  => 'description wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vision.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $vision                    = new Vision();
            $vision->title             = $request->title;
            $vision->description       = $request->description;
            $vision->is_active         = $request->is_active;
            $vision->meta_title        = $request->title;
            $vision->meta_description  = Str::limit(strip_tags($request->description), 150);
            $vision->meta_keywords     = implode(',', explode(' ', Str::lower($request->title)));
            $vision->meta_author       = auth()->check() ? auth()->user()->name : 'Admin';
            $vision->meta_image        = null;
            $vision->meta_canonical    = url()->current();
            $vision->meta_robots       = 'index, follow';
            $vision->slug              = Str::slug($request->title);
            $vision->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('vision')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'vision',['small-thumb', 'small','normal', 'meta', 'large']);

                $vision->image         = $image;
                $vision->meta_image    = $image ?? null;
                $vision->update();
            }
            return redirect()->route('vision')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vision $vision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vision $vision)
    {
        $title  = 'Edit Vision';
        return view('backends.vision.edit', compact('title', 'vision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vision $vision)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'        => 'title wajib diisi',
            'description.required'  => 'description wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vision.edit', $vision->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $vision->title               = $request->title;
            $vision->description         = $request->description;
            $vision->is_active           = $request->is_active;
            $vision->meta_title          = $request->title;
            $vision->meta_description    = Str::limit(strip_tags($request->description), 150);
            $vision->meta_keywords       = implode(',', explode(' ', Str::lower($request->title)));
            $vision->meta_author         = auth()->check() ? auth()->user()->name : 'Admin';
            $vision->meta_canonical      = url()->current();
            $vision->meta_robots         = 'index, follow';
            $vision->slug                = Str::slug($request->title);
            $vision->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('vision')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {

                $deleteImage        = ImageHelper::deleteFileExists($vision->image,'vision',['small-thumb', 'small','normal', 'meta', 'large']);
                
                $file               = $request->file('image');

                $image              = ImageHelper::uploadImage($file,'vision',['small-thumb', 'small','normal', 'meta', 'large']);

                $vision->image      = $image;
                $vision->meta_image = $image ?? null;
                $vision->update();
            }
            return redirect()->route('vision')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vision $vision)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            
            $deleteImage = ImageHelper::deleteFileExists($vision->image,'vision',['small-thumb', 'small','normal', 'meta', 'large']);

            $vision->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('vision')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('vision')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $visions            = Vision::get(); // eager load roles
            $routeEdit          = 'vision.edit';
            $routeDestroy       = 'vision.delete';
            $routePermission    = 'vision.permission';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';

            return DataTables::of($visions)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'vision/';
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
                ->addColumn('action', function ($visions) use ($routeEdit, $routeDestroy, $routePermission, $iconEdit, $iconDestroy, $iconPermission) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit vision')){
                        $btn_action .=  '<a title="Edit vision data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['vision' => $visions->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $visions->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $visions->id;
                        $valueActive = $visions->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('vision.active', ['vision' => $visions->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($visions->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete vision')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['vision' => $visions->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $visions->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $visions->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $visions->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $visions->id . '">Hapus Data</h1>
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
            ->rawColumns(['visions', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Vision $vision)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $vision->is_active           = $request->is_active;
            $vision->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('vision')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('vision')->with('success', 'Berhasil terkirim');
        }
    }
}
