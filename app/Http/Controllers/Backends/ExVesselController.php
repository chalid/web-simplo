<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\ExVessel;
use App\Models\Backends\ExVesselImage;
use App\Models\Backends\Sysparam;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class ExVesselController extends Controller
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
        $routeAjax      = 'exvessel.get_data';
        $title          = 'List Ex Vessel';

        return view('backends.exvessel.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = 'Tambah Ex Vessel';
        $vesselType = Sysparam::where('sgroup', 'vessel_type')->pluck('svalue', 'skey')->put(0, 'Pilih Tipe Kapal')->sortKeys();
        $soldType   = Sysparam::where('sgroup', 'is_sold')->pluck('svalue', 'skey')->sortKeys();
        return view('backends.exvessel.create', compact('title', 'vesselType', 'soldType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'vessel_type'   => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'        => 'title wajib diisi',
            'description.required'  => 'description wajib diisi',
            'vessel_type.required'  => 'tipe kapal wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('exvessel.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $exVessel                   = new ExVessel();
            $exVessel->title            = $request->title;
            $exVessel->description      = $request->description;
            $exVessel->grt              = $request->grt;
            $exVessel->loa              = $request->loa;
            $exVessel->dwt              = $request->dwt;
            $exVessel->year             = $request->year;
            $exVessel->vessel_type      = $request->vessel_type;
            $exVessel->engine           = $request->engine;
            $exVessel->is_active        = $request->is_active;
            $exVessel->is_sold          = $request->is_sold;
            $exVessel->meta_title       = $request->title;
            $exVessel->meta_description = Str::limit(strip_tags($request->description), 150);
            $exVessel->meta_keywords    = implode(',', explode(' ', Str::lower($request->title)));
            $exVessel->meta_author      = auth()->check() ? auth()->user()->name : 'Admin';
            $exVessel->meta_image       = null;
            $exVessel->meta_canonical   = url()->current();
            $exVessel->meta_robots      = 'index, follow';
            $exVessel->slug             = Str::slug($request->title);
            $exVessel->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('exvessel')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'exvessel',['small-thumb', 'small','normal', 'meta', 'large']);

                $exVessel->image         = $image;
                $exVessel->meta_image    = $image ?? null;
                $exVessel->update();

                $exVesselImage                 = new ExVesselImage();
                $exVesselImage->ex_vessel_id   = $exVessel->id;
                $exVesselImage->uri            = $image;
                $exVesselImage->is_default     = true;
                $exVesselImage->save();
            }
            return redirect()->route('exvessel')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExVessel $exVessel)
    {
        $title          = 'Detail Ex Vessel';
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        return view('backends.exvessel.show', compact('title', 'exVessel', 'confirmDelete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExVessel $exVessel)
    {
        $title      = 'Edit Ex Vessel';
        $vesselType = Sysparam::where('sgroup', 'vessel_type')->pluck('svalue', 'skey')->put(0, 'Pilih Tipe Kapal')->sortKeys();
        $soldType   = Sysparam::where('sgroup', 'is_sold')->pluck('svalue', 'skey')->put(0, 'Available / Sold Out')->sortKeys();
        return view('backends.exvessel.edit', compact('title', 'exVessel', 'vesselType', 'soldType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExVessel $exVessel)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'vessel_type'   => 'required',
            'is_active'     => 'required|boolean',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'        => 'title wajib diisi',
            'description.required'  => 'description wajib diisi',
            'vessel_type.required'  => 'tipe kapal wajib diisi',
            'is_active.required'    => 'is active wajib diisi',
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('exvessel.edit', $exVessel->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $exVessel->title            = $request->title;
            $exVessel->description      = $request->description;
            $exVessel->grt              = $request->grt;
            $exVessel->loa              = $request->loa;
            $exVessel->dwt              = $request->dwt;
            $exVessel->year             = $request->year;
            $exVessel->vessel_type      = $request->vessel_type;
            $exVessel->engine           = $request->engine;
            $exVessel->is_active        = $request->is_active;
            $exVessel->is_sold          = $request->is_sold;
            $exVessel->meta_title       = $request->title;
            $exVessel->meta_description = Str::limit(strip_tags($request->description), 150);
            $exVessel->meta_keywords    = implode(',', explode(' ', Str::lower($request->title)));
            $exVessel->meta_author      = auth()->check() ? auth()->user()->name : 'Admin';
            $exVessel->meta_canonical   = url()->current();
            $exVessel->meta_robots      = 'index, follow';
            $exVessel->slug             = Str::slug($request->title);
            $exVessel->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('exvessel')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('exvessel')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExVessel $exVessel)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            foreach($exVessel->images as $image){
                $deleteImage = ImageHelper::deleteFileExists($image->uri,'exvessel',['small-thumb', 'small','normal', 'meta', 'large', 'original']);
            }
            $exVessel->images->each->delete();

            $exVessel->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('exvessel')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('exvessel')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $exVessels           = ExVessel::with('vesselType')->latest(); // eager load roles
            $routeEdit          = 'exvessel.edit';
            $routeDestroy       = 'exvessel.delete';
            $routePermission    = 'exvessel.permission';
            $routeShow          = 'exvessel.show';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';
            $iconShow           = '<i class="bi bi-eye"></i>';

            return DataTables::of($exVessels)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('is_sold', function ($row) {
                    return $row->is_sold ? 'Sold' : 'Not Sold';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'exvessel/';
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
                ->addColumn('vessel_type_label', function ($row) {
                    return $row->vesselType->svalue ?? '-';
                })
                ->filterColumn('vessel_type_label', function ($query, $keyword) {
                    $query->whereIn('vessel_type', function ($q) use ($keyword) {
                        $q->select('skey')
                        ->from('sysparams')
                        ->where('sgroup', 'vessel_type')
                        ->where('svalue', 'like', "%{$keyword}%");
                    });
                })
                ->orderColumn('vessel_type_label', function ($query, $order) {
                    $query->leftJoin('sysparams', function ($join) {
                        $join->on('ex_vessels.vessel_type', '=', 'sysparams.skey')
                            ->where('sysparams.sgroup', '=', 'vessel_type');
                    })->orderBy('sysparams.svalue', $order);
                })
                ->addColumn('action', function ($exVessels) use ($routeEdit, $routeDestroy, $routePermission, $routeShow, $iconEdit, $iconDestroy, $iconPermission, $iconShow) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can show exvessel')){
                        $btn_action .=  '<a title="Show Ex Vessel data" class="btn btn-primary btn-sm btn-icon" href="' . route($routeShow, ['exVessel' => $exVessels->id]) . '">' . $iconShow . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can edit exvessel')){
                        $btn_action .=  '<a title="Edit exvessel data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['exVessel' => $exVessels->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $exVessels->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $exVessels->id;
                        $valueActive = $exVessels->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('exvessel.active', ['exVessel' => $exVessels->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($exVessels->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete exvessel')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['exVessel' => $exVessels->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $exVessels->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $exVessels->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $exVessels->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $exVessels->id . '">Hapus Data</h1>
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
            ->rawColumns(['exvessels', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, ExVessel $exVessel)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $exVessel->is_active           = $request->is_active;
            $exVessel->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('exvessel')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('exvessel')->with('success', 'Berhasil terkirim');
        }
    }

    public function imageAdd(Request $request, ExVessel $exVessel)
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('exvessel.show', $exVessel->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }
        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'exvessel',['small-thumb', 'small','normal', 'meta', 'large']);

                $exVessel->image         = $image;
                $exVessel->meta_image    = $image ?? null;
                $exVessel->update();

                $oldExVesselImage               = ExVesselImage::where('ex_vessel_id', $exVessel->id)->where('is_default', true)->update(['is_default' => false]);

                $exVesselImage                  = new ExVesselImage();
                $exVesselImage->ex_vessel_id    = $exVessel->id;
                $exVesselImage->uri             = $image;
                $exVesselImage->is_default      = true;
                $exVesselImage->save();
            }

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('exvessel.show', $exVessel->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('exvessel.show', $exVessel->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageSetDefault(Request $request, ExVessel $exVessel, ExVesselImage $exVesselImage)
    {
        $exVesselImage = ExVesselImage::find($request->image_id);

        DB::beginTransaction();
        $success_trans = false;

        try {

            $exVessel->image             = $exVesselImage->uri;
            $exVessel->meta_image        = $exVesselImage->uri ?? null;
            $exVessel->update();

            $oldExVesselImage            = ExVesselImage::where('ex_vessel_id', $exVessel->id)->where('is_default', true)->update(['is_default' => false]);

            $exVesselImage->is_default  = true;
            $exVesselImage->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('exvessel.show', $exVessel->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('exvessel.show', $exVessel->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageDelete(Request $request, ExVessel $exVessel, ExVesselImage $exVesselImage)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $exVesselImage = ExVesselImage::find($request->image_id);

            $exVessel->image             = null;
            $exVessel->meta_image        = null;
            $exVessel->update();

            $deleteImage = ImageHelper::deleteFileExists($exVesselImage->uri,'exvessel',['small-thumb', 'small','normal', 'meta', 'large', 'original']);
            $exVesselImage->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('exvessel.show', $exVessel->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('exvessel.show', $exVessel->id)->with('success', 'Berhasil terkirim');
        }
    }
}
