<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Backends\PermissionModel;
use App\Models\Backends\RoleModel;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Session;
use DB;
use Redirect;

class UserController extends Controller
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
        $routeAjax      = 'user.get_data';
        $title          = 'List Users';
        $roleUser       = Auth::user()->hasRole('Super Admin') ? true : null;
        if ($roleUser == null) {
            $roles          = Role::where('id', '!=', 1)->pluck('name', 'name')->put(0, 'Pilih Role')->sortKeys();
        } else {
            $roles          = Role::all()->pluck('name', 'name')->put(0, 'Pilih Role')->sortKeys();
        }

        return view('backends.user.index', compact(['confirmDelete','routeAjax','title', 'roles']));
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
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
            'role'      => 'required',
        ], [
            'name.required'     => 'Nama wajib diisi',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already in use.',
            'password.required' => 'Password wajib diisi',
            'role.required'     => 'Role wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $user           = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $role_arr = $request->get('role');
            $user->syncRoles($role_arr);

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('user')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title  = 'Edit Users';
        $roleUser       = Auth::user()->hasRole('Super Admin') ? true : null;
        if ($roleUser == null) {
            $roles          = Role::where('id', '!=', 1)->pluck('name', 'name')->put(0, 'Pilih Role')->sortKeys();
        } else {
            $roles          = Role::all()->pluck('name', 'name')->put(0, 'Pilih Role')->sortKeys();
        }
        return view('backends.user.edit', compact(['user', 'title', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('user')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('user')->with('alert-success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $user->active = 0;
            $user->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('user')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            // Clear cached user model
            Cache::forget('user:' . $user->id);
            return redirect()->route('user')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $users              = User::with('roles'); // eager load roles
            $routeEdit          = 'user.edit';
            $routeDestroy       = 'user.delete';
            $routePermission    = 'user.permission';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->join(', ');
                })
                ->addColumn('action', function ($users) use ($routeEdit, $routeDestroy, $routePermission, $iconEdit, $iconDestroy, $iconPermission) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit user')){
                        $btn_action .=  '<a title="Edit user data" class="btn btn-warning btn-sm" href="' . route($routeEdit, ['user' => $users->id]) . '">' . $iconEdit . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete user')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['user' => $users->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="patch">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $users->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $users->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $users->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $users->id . '">Hapus Data</h1>
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
            ->rawColumns(['roles', 'action']) // to html
            ->make(true);
        }
    }

    public function updatePassword(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required',
                
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Your password was not updated, since the provided current password does not match.');
                    }
                }
            ],
            'password' => [
                'required', 'min:6', 'confirmed', 'different:current_password'
            ]
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required'         => 'Password baru wajib diisi',
            'password.min'              => 'password min 6 char',
            'password.confirmed'        => 'Password yag diisi harus sama',
            'password.different'        => 'Password baru tidak dapat sama dengan password lama',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('user.edit',$user->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('user')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('user')->with('success', 'Your password has been updated successfully');
        }


    }

    public function updateRole(Request $request, User $user)
    {
        
        $validator = Validator::make($request->all(), [
            'role'          => 'required'
        ], [
            'role.required' => 'Role wajib diisi',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('user.edit',$user->id)
            ->with('error',$validator->errors())
            ->withInput();
        }
        $role_arr = $request->get('role');
        $user->syncRoles($role_arr);

        return redirect()->route('user')->with('success', 'Role has been updated successfully');

    }
}
