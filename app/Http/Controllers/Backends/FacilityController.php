<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Facility;
use App\Models\Backends\FacilityImage;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class FacilityController extends Controller
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
        $routeAjax      = 'facility.get_data';
        $title          = 'List Facility';

        return view('backends.facility.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = 'Tambah Facility';
        return view('backends.facility.create', compact('title'));
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
            return redirect()->route('facility.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $facility                    = new Facility();
            $facility->title             = $request->title;
            $facility->description       = $request->description;
            $facility->is_active         = $request->is_active;
            $facility->meta_title        = $request->title;
            $facility->meta_description  = Str::limit(strip_tags($request->description), 150);
            $facility->meta_keywords     = implode(',', explode(' ', Str::lower($request->title)));
            $facility->meta_author       = auth()->check() ? auth()->user()->name : 'Admin';
            $facility->meta_image        = null;
            $facility->meta_canonical    = url()->current();
            $facility->meta_robots       = 'index, follow';
            $facility->slug              = Str::slug($request->title);
            $facility->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('facility')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'facility',['small-thumb', 'small','normal', 'meta', 'large']);

                $facility->image         = $image;
                $facility->meta_image    = $image ?? null;
                $facility->update();

                $facilityImage              = new FacilityImage();
                $facilityImage->facility_id = $facility->id;
                $facilityImage->uri         = $image;
                $facilityImage->is_default  = true;
                $facilityImage->save();
            }
            return redirect()->route('facility')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        $title          = 'Detail Facility';
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        return view('backends.facility.show', compact('title', 'facility', 'confirmDelete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        $title  = 'Edit facility';
        return view('backends.facility.edit', compact('title', 'facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'is_active'     => 'required|boolean',
        ], [
            'title.required'        => 'title wajib diisi',
            'description.required'  => 'description wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('facility.edit', $facility->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $facility->title               = $request->title;
            $facility->description         = $request->description;
            $facility->is_active           = $request->is_active;
            $facility->meta_title          = $request->title;
            $facility->meta_description    = Str::limit(strip_tags($request->description), 150);
            $facility->meta_keywords       = implode(',', explode(' ', Str::lower($request->title)));
            $facility->meta_author         = auth()->check() ? auth()->user()->name : 'Admin';
            $facility->meta_canonical      = url()->current();
            $facility->meta_robots         = 'index, follow';
            $facility->slug                = Str::slug($request->title);
            $facility->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('facility')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('facility')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            foreach($facility->images as $image){
                $deleteImage = ImageHelper::deleteFileExists($image->uri,'facility',['small-thumb', 'small','normal', 'meta', 'large', 'original']);
            }
            $facility->images->each->delete();

            $facility->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('facility')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('facility')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $facilities         = Facility::get(); // eager load roles
            $routeEdit          = 'facility.edit';
            $routeDestroy       = 'facility.delete';
            $routePermission    = 'facility.permission';
            $routeShow          = 'facility.show';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';
            $iconShow           = '<i class="bi bi-eye"></i>';

            return DataTables::of($facilities)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'facility/';
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
                ->addColumn('action', function ($facilities) use ($routeEdit, $routeDestroy, $routePermission, $routeShow, $iconEdit, $iconDestroy, $iconPermission, $iconShow) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can show facility')){
                        $btn_action .=  '<a title="Show facility data" class="btn btn-primary btn-sm btn-icon" href="' . route($routeShow, ['facility' => $facilities->id]) . '">' . $iconShow . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can edit facility')){
                        $btn_action .=  '<a title="Edit facility data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['facility' => $facilities->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $facilities->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $facilities->id;
                        $valueActive = $facilities->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('facility.active', ['facility' => $facilities->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($facilities->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete facility')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['facility' => $facilities->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $facilities->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $facilities->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $facilities->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $facilities->id . '">Hapus Data</h1>
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
            ->rawColumns(['facilities', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Facility $facility)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $facility->is_active           = $request->is_active;
            $facility->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('facility')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('facility')->with('success', 'Berhasil terkirim');
        }
    }

    public function imageAdd(Request $request, Facility $facility)
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('facility.show', $facility->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }
        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'facility',['small-thumb', 'small','normal', 'meta', 'large']);

                $facility->image            = $image;
                $facility->meta_image       = $image ?? null;
                $facility->update();

                $oldFacilityImage           = FacilityImage::where('facility_id', $facility->id)->where('is_default', true)->update(['is_default' => false]);

                $facilityImage              = new FacilityImage();
                $facilityImage->facility_id = $facility->id;
                $facilityImage->uri         = $image;
                $facilityImage->is_default  = true;
                $facilityImage->save();
            }

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('facility.show', $facility->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('facility.show', $facility->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageSetDefault(Request $request, Facility $facility, FacilityImage $facilityImage)
    {
        $facilityImage = FacilityImage::find($request->image_id);

        DB::beginTransaction();
        $success_trans = false;

        try {

            $facility->image             = $facilityImage->uri;
            $facility->meta_image        = $facilityImage->uri ?? null;
            $facility->update();

            $oldFacilityImage            = FacilityImage::where('facility_id', $facility->id)->where('is_default', true)->update(['is_default' => false]);

            $facilityImage->is_default  = true;
            $facilityImage->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('facility.show', $facility->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('facility.show', $facility->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageDelete(Request $request, Facility $facility, FacilityImage $facilityImage)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $facilityImage = FacilityImage::find($request->image_id);

            $facility->image             = null;
            $facility->meta_image        = null;
            $facility->update();

            $deleteImage = ImageHelper::deleteFileExists($facilityImage->uri,'facility',['small-thumb', 'small','normal', 'meta', 'large', 'original']);
            $facilityImage->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('facility.show', $facility->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('facility.show', $facility->id)->with('success', 'Berhasil terkirim');
        }
    }
}
