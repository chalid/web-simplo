<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Redirect;
use ImageHelper;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $anu = 'ini anu, ';
        $ini = 'ini ani';
        return view('home',compact(['anu', 'ini']));
    }

    public function changePassword()
    {
        $user   = User::find(Auth::user()->id);
        $title  = 'Change Password';
        return view('backends.home.change_password', compact(['user', 'title']));
    }

    public function updatePassword(Request $request)
    {
        $user   = User::find(Auth::user()->id);

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
            return redirect()->route('home.change_password')
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
            return redirect()->route('home.change_password')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('home')->with('success', 'Your password has been updated successfully');
        }
    }

    public function updateAvatar(Request $request)
    {
        $user   = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'avatar'        => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'avatar.mimes'  => 'Hanya file jpg yang dapat diupload',
            'avatar.max'    => 'Ukuran file tidak boleh melebihin 2MB',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('home.change_avatar')
                        ->with('error',$validator->errors())
                        ->withInput();
        }
        $file   = $request->file('avatar');

        /**
         * select 1 size, multiple or all, it will create folder with + original size
         * large  = ['path' => $path . '/large', 'size' => 1280];
         * medium = ['path' => $path . '/medium', 'size' => 840];
         * small  = ['path' => $path . '/small', 'size' => 360];
         * avatar  = ['path' => $path . '/avatar', 'size' => 56];
         * thumb  = ['path' => $path . '/thumbnail', 'size' => 50];
         * all = all size;
         */
        $image = ImageHelper::uploadImage($file,'avatar',['avatar']);

        DB::beginTransaction();
        $success_trans = false;

        try {
            $user->avatar = $image;
            $user->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('home.change_avatar')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('home')->with('success', 'Your avatar has been updated successfully');
        }
    }

    public function changeAvatar()
    {
        $title  = 'Change Avatar';
        return view('backends.home.change_avatar', compact(['title']));
    }
}
