<?php
namespace App\Http\Helpers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

class UserHelper{

    public static function addUser($request,$data)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $password                   = 'arjayamarine' . date('Y');
            $user                       = new User();
            $user->name                 = $data['name'];
            $user->email                = $data['email'];
            $user->email_verified_at    = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $user->password             = Hash::make($password);
            $user->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route($request->segment(1))->with('error', $e->getMessage());
        }
        
        if ($success_trans == true) {
            // add role
            if($request->get('role')){
                $role_arr = $request->get('role');
                $user->syncRoles($role_arr);
            }
            return $user;
        } else {
            return redirect()->route($request->segment(1))->with('error', $e->getMessage());
        }

    }

}