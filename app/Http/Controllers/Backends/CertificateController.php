<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Certificate;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class CertificateController extends Controller
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
        $routeAjax      = 'certificate.get_data';
        $title          = 'List Certificate';

        return view('backends.certificate.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = 'Tambah Certificate';
        return view('backends.certificate.create', compact('title'));
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
            return redirect()->route('certificate.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $certificate                    = new Certificate();
            $certificate->title             = $request->title;
            $certificate->description       = $request->description;
            $certificate->is_active         = $request->is_active;
            $certificate->meta_title        = $request->title;
            $certificate->meta_description  = Str::limit(strip_tags($request->description), 150);
            $certificate->meta_keywords     = implode(',', explode(' ', Str::lower($request->title)));
            $certificate->meta_author       = auth()->check() ? auth()->user()->name : 'Admin';
            $certificate->meta_image        = null;
            $certificate->meta_canonical    = url()->current();
            $certificate->meta_robots       = 'index, follow';
            $certificate->slug              = Str::slug($request->title);
            $certificate->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('certificate')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'certificate',['small-thumb', 'small','normal', 'meta', 'large']);

                $certificate->image         = $image;
                $certificate->meta_image    = $image ?? null;
                $certificate->update();
            }
            return redirect()->route('certificate')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        $title  = 'Edit Certificate';
        return view('backends.certificate.edit', compact('title', 'certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
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
            return redirect()->route('certificate.edit', $certificate->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $certificate->title               = $request->title;
            $certificate->description         = $request->description;
            $certificate->is_active           = $request->is_active;
            $certificate->meta_title          = $request->title;
            $certificate->meta_description    = Str::limit(strip_tags($request->description), 150);
            $certificate->meta_keywords       = implode(',', explode(' ', Str::lower($request->title)));
            $certificate->meta_author         = auth()->check() ? auth()->user()->name : 'Admin';
            $certificate->meta_canonical      = url()->current();
            $certificate->meta_robots         = 'index, follow';
            $certificate->slug                = Str::slug($request->title);
            $certificate->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('certificate')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {

                $deleteImage        = ImageHelper::deleteFileExists($certificate->image,'certificate',['small-thumb', 'small','normal', 'meta', 'large']);
                
                $file               = $request->file('image');

                $image              = ImageHelper::uploadImage($file,'certificate',['small-thumb', 'small','normal', 'meta', 'large']);

                $certificate->image      = $image;
                $certificate->meta_image = $image ?? null;
                $certificate->update();
            }
            return redirect()->route('certificate')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            
            $deleteImage = ImageHelper::deleteFileExists($certificate->image,'certificate',['small-thumb', 'small','normal', 'meta', 'large']);

            $certificate->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('certificate')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('certificate')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $certificates       = Certificate::get(); // eager load roles
            $routeEdit          = 'certificate.edit';
            $routeDestroy       = 'certificate.delete';
            $routePermission    = 'certificate.permission';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';

            return DataTables::of($certificates)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'certificate/';
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
                ->addColumn('action', function ($certificates) use ($routeEdit, $routeDestroy, $routePermission, $iconEdit, $iconDestroy, $iconPermission) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit certificate')){
                        $btn_action .=  '<a title="Edit certificate data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['certificate' => $certificates->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $certificates->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $certificates->id;
                        $valueActive = $certificates->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('certificate.active', ['certificate' => $certificates->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($certificates->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete certificate')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['certificate' => $certificates->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $certificates->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $certificates->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $certificates->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $certificates->id . '">Hapus Data</h1>
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
            ->rawColumns(['certificates', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Certificate $certificate)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $certificate->is_active           = $request->is_active;
            $certificate->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('certificate')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('certificate')->with('success', 'Berhasil terkirim');
        }
    }
}
