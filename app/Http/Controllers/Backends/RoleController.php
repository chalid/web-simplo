<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Backends\RoleModel;
use App\Models\Backends\PermissionModel;
use Session;
use DB;
use Redirect;
use Auth;
use Validator;
use DataTables;

class RoleController extends Controller
{
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
        $routeAjax      = 'role.get_data';
        $title          = 'List Role';

        return view('backends.role.index', compact(['confirmDelete','routeAjax','title']));
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
            'name'          => 'required',
            'guard_name'    => 'required',
        ], [
            'name.required'         => 'Name wajib diisi',
            'guard_name.required'   => 'Guard wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('role')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $role             = new RoleModel();
            $role->name       = $request->name;
            $role->guard_name = $request->guard_name;
            $role->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('role')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('role')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleModel $roleModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleModel $roleModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleModel $roleModel)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'guard_name'    => 'required',
        ], [
            'name.required'         => 'Name wajib diisi',
            'guard_name.required'   => 'Guard wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('role')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $role->name       = $request->name;
            $role->guard_name = $request->guard_name;
            $role->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('role')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('role')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleModel $roleModel)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $role->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('role')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('role')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $roles          = RoleModel::get();

            $routeEdit          = 'role.update';
            $routeDestroy       = 'role.delete';
            $routePermission    = 'role.permission';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';

            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($roles) use ($routeEdit, $routeDestroy, $iconEdit, $iconDestroy, $routePermission, $iconPermission) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit role')){
                        $btn_action .=  '<form action="' . route($routeEdit, ['role' => $roles->id]) . '" method="POST">
                                        <input type="hidden" name="_method" value="PATCH">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <a data-bs-toggle="modal" class="btn btn-warning btn-sm" title="Edit Data" href="" data-bs-target="#staticBackdrop' . $roles->id . '">' . $iconEdit . '</a>
                                        <div class="modal fade" id="staticBackdrop' . $roles->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel' . $roles->id . '" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel' . $roles->id . '">Edit Data</h1>
                                                        <button type="button" class="btn-close clear-form" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name' . $roles->id . '" class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="name" id="name' . $roles->id . '" value="' . $roles->name . '" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="guard_name' . $roles->id . '" class="form-label">Guard Name</label>
                                                            <select class="form-select" name="guard_name" id="guard_name' . $roles->id . '" required>
                                                                <option value="web"' . ($roles->guard_name == 'web' ? ' selected' : '') . '>WEB</option>
                                                                <option value="api"' . ($roles->guard_name == 'api' ? ' selected' : '') . '>API</option>
                                                            </select>
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
                    if(Auth::user()->can('Can delete role')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['role' => $roles->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="patch">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $roles->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $roles->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $roles->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $roles->id . '">Hapus Data</h1>
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
                    if(Auth::user()->can('Can show role permission')){
                        $btn_action .= '<a title="Role Permission" class="btn btn-primary btn-sm" href="' . route($routePermission,['role' => $roles->id]) . '">' . $iconPermission . '</a>';
                    }
                    $btn_action .=  '</div>';

                    return $btn_action;
                })
            ->rawColumns(['action']) // to html
            ->make(true);
        }
    }

    public function permission(Role $role)
    {
        $permissions    = PermissionModel::with(['children'])->where('parent_id', 0)->get();
        $title          = 'List Permission for [ ' . $role->name . ' ]';
        return view('backends.role.permission', compact('role', 'permissions', 'title'));
    }

    /**
     * Method untuk menyimpan/update permission untuk role
     *
     * @param Request $request
     * @param Role $role
     * @param PermissionModel $permission
     * @return array
     */
    public function permissionStore(Request $request, Role $role, PermissionModel $permission)
    {
        $state  = $request->get('state');
        $status = ['status' => false];
        if ($state == "true") {
            $role->givePermissionTo($permission);
            $status['status'] = true;
            $status['action'] = 'attach';
        } else {
            $role->revokePermissionTo($permission);
            $status['status'] = true;
            $status['action'] = 'revoke';
        }

        echo json_encode($status, JSON_PRETTY_PRINT);
    }
}
