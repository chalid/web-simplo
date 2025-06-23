<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Sysparam;
use Illuminate\Http\Request;
use DataTables;
use Session;
use DB;
use Redirect;
use Auth;
use Validator;

class SysparamController extends Controller
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
        $routeAjax      = 'sysparam.get_data';
        $title          = 'List Sysparams';

        return view('backends.sysparam.index', compact(['confirmDelete','routeAjax','title']));
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
            'sgroup' => 'required',
            'skey' => 'required',
            'svalue' => 'required',
        ], [
            'sgroup.required'    => 'Sgroup wajib diisi',
            'skey.required'    => 'Skey wajib diisi',
            'svalue.required'    => 'Svalue wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sysparam')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $sysparam               = new Sysparam();
            $sysparam->sgroup       = $request->sgroup;
            $sysparam->skey         = $request->skey;
            $sysparam->svalue       = $request->svalue;
            $sysparam->lvalue       = $request->lvalue;
            $sysparam->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('sysparam')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('sysparam')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sysparam $sysparam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sysparam $sysparam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sysparam $sysparam)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $sysparam->sgroup       = $request->sgroup;
            $sysparam->skey         = $request->skey;
            $sysparam->svalue       = $request->svalue;
            $sysparam->lvalue       = $request->lvalue;
            $sysparam->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('sysparam')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('sysparam')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sysparam $sysparam)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $sysparam->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('sysparam')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('sysparam')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $sysparams      = Sysparam::get();

            $routeEdit      = 'sysparam.update';
            $routeDestroy   = 'sysparam.delete';
            $iconEdit       = '<i class="bi bi-pencil"></i>';
            $iconDestroy    = '<i class="bi bi-trash"></i>';

            return DataTables::of($sysparams)
                ->addIndexColumn()
                ->addColumn('action', function ($sysparams) use ($routeEdit,$routeDestroy,$iconEdit,$iconDestroy) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit sysparam')){
                        $btn_action .=  '<form action="' . route($routeEdit, ['sysparam' => $sysparams->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="PATCH">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-warning btn-sm" title="Edit Data" href="" data-bs-target="#staticBackdrop' . $sysparams->id . '">' . $iconEdit . '</a>' .
                                            '<div class="modal fade" id="staticBackdrop' . $sysparams->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel' . $sysparams->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel' . $sysparams->id . '">Edit Data</h1>
                                                            <button type="button" class="btn-close clear-form" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="sgroup" class="col-sm-4 col-form-label">sgroup</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="sgroup" class="form-control" id="sgroup" value="' . $sysparams->sgroup . '" required>
                                                                    <div class="invalid-feedback">Harap isi sgroup</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="skey" class="col-sm-4 col-form-label">skey</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="skey" class="form-control" id="skey" value="' . $sysparams->skey . '" required>
                                                                    <div class="invalid-feedback">Harap isi skey</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="svalue" class="col-sm-4 col-form-label">svalue</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="svalue" class="form-control" id="svalue" value="' . $sysparams->svalue . '" required>
                                                                    <div class="invalid-feedback">Harap isi svalue</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="lvalue" class="col-sm-4 col-form-label">lvalue</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="lvalue" class="form-control" id="lvalue" value="' . $sysparams->lvalue . '">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger clear-form" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete sysparam')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['sysparam' => $sysparams->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="DELETE">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $sysparams->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $sysparams->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $sysparams->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $sysparams->id . '">Hapus Data</h1>
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
                    $btn_action .=  '</div>';

                    return $btn_action;
                })
            ->rawColumns(['action']) // to html
            ->make(true);
        }
    }
}
