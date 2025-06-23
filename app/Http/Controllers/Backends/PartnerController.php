<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Partner;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class PartnerController extends Controller
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
        $routeAjax      = 'partner.get_data';
        $title          = 'List Partner';

        return view('backends.partner.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = 'Tambah Partner';
        return view('backends.partner.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'nama.required'        => 'name wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('partner.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $partner            = new Partner();
            $partner->name      = $request->name;
            $partner->email     = $request->email;
            $partner->phone     = $request->phone;
            $partner->is_active = $request->is_active;
            $partner->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('partner')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'partner',['small-thumb', 'web-smaller']);

                $partner->image         = $image;
                $partner->update();
            }
            return redirect()->route('partner')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        $title  = 'Edit partner';
        return view('backends.partner.edit', compact('title', 'partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'name.required'        => 'name wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('partner.edit', $partner->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $partner->name      = $request->name;
            $partner->email     = $request->email;
            $partner->phone     = $request->phone;
            $partner->is_active = $request->is_active;
            $partner->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('partner')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {

                $deleteImage        = ImageHelper::deleteFileExists($partner->image,'partner',['small-thumb', 'web-smaller']);
                
                $file               = $request->file('image');

                $image              = ImageHelper::uploadImage($file,'partner',['small-thumb', 'web-smaller']);

                $partner->image      = $image;
                $partner->update();
            }
            return redirect()->route('partner')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            
            $deleteImage = ImageHelper::deleteFileExists($partner->image,'partner',['small-thumb', 'web-smaller']);

            $partner->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('partner')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('partner')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $partners            = Partner::get(); // eager load roles
            $routeEdit          = 'partner.edit';
            $routeDestroy       = 'partner.delete';
            $routePermission    = 'partner.permission';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';

            return DataTables::of($partners)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'partner/';
                    $thumbPath = $item->image
                        ? url($path . $dir . 'small-thumb/' . $item->image)
                        : url('assets/backend/images/png/no_image.png');

                    $originalPath = $item->image
                        ? url($path . $dir . 'web-smaller/' . $item->image)
                        : '#';

                    return '<a href="' . $originalPath . '" target="_blank">
                                <img src="' . $thumbPath . '" alt="' . e($item->name) . '" title="' . e($item->name) . '" height="50">
                            </a>';
                })
                ->addColumn('action', function ($partners) use ($routeEdit, $routeDestroy, $routePermission, $iconEdit, $iconDestroy, $iconPermission) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit partner')){
                        $btn_action .=  '<a title="Edit partner data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['partner' => $partners->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $partners->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $partners->id;
                        $valueActive = $partners->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('partner.active', ['partner' => $partners->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($partners->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete partner')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['partner' => $partners->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $partners->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $partners->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $partners->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $partners->id . '">Hapus Data</h1>
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
            ->rawColumns(['partners', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Partner $partner)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $partner->is_active           = $request->is_active;
            $partner->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('partner')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('partner')->with('success', 'Berhasil terkirim');
        }
    }
}
