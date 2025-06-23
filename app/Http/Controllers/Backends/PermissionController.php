<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\PermissionModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DataTables;
use Session;
use DB;
use Redirect;
use Auth;
use Validator;

class PermissionController extends Controller
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
        $routeAjax      = 'permission.get_data';
        $routeEdit      = 'permission.edit';
        $title          = 'List Permissions';
        $permission     = Permission::where('parent_id', 0)->pluck('name', 'id')->put(0, 'Sebagai Parent')->sortKeys();

        return view('backends.permission.index', compact(['confirmDelete','routeAjax','title', 'permission', 'routeEdit']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title          = 'Tambah Permission';
        $permission     = null;
        $permissionList = Permission::where('parent_id', 0)->pluck('name', 'id')->put(0, 'Sebagai Parent')->sortKeys();
        return view('backends.permission.create', compact('permission', 'permissionList', 'title'));
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
            return redirect()->route('permission')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $permission             = new PermissionModel();
            $permission->name       = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->parent_id  = $request->parent_id ?? 0;
            $permission->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('permission')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('permission')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermissionModel $permission)
    {
        $title          = 'Ubah Permission';
        $permissionList = Permission::where('parent_id', 0)->pluck('name', 'id')->put(0, 'Sebagai Parent')->sortKeys();

        return view('backends.permission.edit', compact(['title', 'permission', 'permissionList']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermissionModel $permission)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'guard_name'    => 'required',
        ], [
            'name.required'         => 'Name wajib diisi',
            'guard_name.required'   => 'Guard wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('permission.edit', $permission->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $permission->name       = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->parent_id  = $request->parent_id ?? 0;
            $permission->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('permission')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('permission')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermissionModel $permissionModel)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $permissionModel->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('permission')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('permission')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $permissions    = PermissionModel::with('children')->where('parent_id',0)->get();

            $routeEdit      = 'permission.edit';
            $routeDestroy   = 'permission.delete';
            $iconEdit       = '<i class="bi bi-pencil"></i>';
            $iconDestroy    = '<i class="bi bi-trash"></i>';

            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('action', function ($permissions) use ($routeEdit,$routeDestroy,$iconEdit,$iconDestroy) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit permission')){
                        $btn_action .=  '<a title="Edit Data" class="btn btn-warning btn-sm" href="'. route($routeEdit, ['permission' => $permissions->id]) . '">' . $iconEdit . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete permission')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['permission' => $permissions->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="DELETE">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $permissions->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $permissions->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $permissions->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $permissions->id . '">Hapus Data</h1>
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
            ->rawColumns(['action'])
            ->editColumn('children', function ($permissions) use($routeDestroy, $iconDestroy){
                $children    = $permissions->children;
                $newChildren = [];
                if (is_object($permissions->children) && $permissions->children->count() > 0) {
                    foreach ($permissions->children as $item) {
                        $action = '';
                        if(Auth::user()->can('Can edit permission')){
                            $action .= "<a href='" . route('permission.edit', ['permission' => $item->id]) . "' class='btn btn-warning btn-sm' title='Edit'>
                                          <i class='bi bi-pencil'></i>
                                        </a>&nbsp";
                        }
                        if(Auth::user()->can('Can delete permission')){
                            $action .= '<form action="' . route($routeDestroy, ['permission' => $item->id]) . '" method="POST">' .
                                        '<input type="hidden" name="_method" value="DELETE">' . // Add this line to specify the PATCH method
                                        '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $item->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $item->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $item->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $item->id . '">Hapus Data</h1>
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
                        $item['action'] = $action;
                        $newChildren[]  = $item;
                    }
                }
    
                return $newChildren;
            })->escapeColumns([])->setRowClass(function ($newPermission) {
                if ($newPermission->children && $newPermission->children()->count() > 0) return 'has-child';
                else return '';})
            ->make(true);
        }
    }

    public function checkPermission(Request $request)
    {
        try {
            // Retrieve the permission from the request
            $permission = $request->input('permission');

            // Check if the user is authenticated
            if (!Auth::check()) {
                throw new \Exception('User is not authenticated.');
            }

            // Check if the user has the specified permission
            if (Auth::user()->hasPermissionTo($permission)) {
                return response()->json(['hasPermission' => true]);
            } else {
                if(Auth::user()->hasRole('Super Admin')){
                    return response()->json(['hasPermission' => true]);
                } else {
                    return response()->json(['hasPermission' => false]);
                }
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
