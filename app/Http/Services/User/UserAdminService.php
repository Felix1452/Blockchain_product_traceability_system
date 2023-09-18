<?php

namespace App\Http\Services\User;

use App\Models\User;
use App\Models\staffs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpMqtt\Client\Facades\MQTT;

class UserAdminService
{
    public function create($request){
        $a = DB::select('select email from users where email ="'.$request->input('email').'"');
        try {
            if (sizeof($a) == 0){
                $namsinh = $request->input('birth');
                $time = strtotime($namsinh);
                $newformat = date('Y-m-d',$time);
                $a = Carbon::now();
                $age = $a->diffInYears($newformat);
                if ($request->input('active') == 3){
                    $active = 5;
                }
//                dd($age);
                User::create([
                    'name'=>(string)$request->input('name'),
                    'email'=>(string)$request->input('email'),
                    'mobile'=>(string)$request->input('mobile'),
                    'active'=>(integer)$active,
                    'birth'=>(string)$request->input('birth'),
                    'age'=>(integer)$age,
                    'sex'=>(string)$request->input('sex'),
                    'address'=>(string)$request->input('address'),
                    'img'=>(string)$request->input('img'),
                    'password'=>bcrypt($request->input('password'))
                ]);
//                staffs::create([
//                    'name'=>(string)$request->input('name'),
//                    'user_id'=>$us[0]->id,
//                    'email'=>(string)$request->input('email'),
//                    'mobile'=>(string)$request->input('mobile'),
//                    'sex'=>(string)$request->input('sex'),
//                    'age'=>(integer)$age,
//                    'address'=>(string)$request->input('address'),
//                    'description'=>(string)$request->input('description'),
//                    'active'=>(integer)$request->input('active')
//                ]);
                Session::flash("success","Tạo tài khoản thành công");
                return true;
            }else{
                Session::flash("error","Tài khoản tồn tại");
                return false;
            }
        }catch (\Exception $err){
            Session::flash("error",'Lỗi');
            return false;
        }
    }

    public function get(){
        return User::orderByDesc('id')->paginate(10);
    }
    public function getProfile($email){
        return User::where('email',$email)->get();
    }

    public function getStaffAdmin(){
        return User::where('active',1)
            ->orWhere('active',2)
            ->orWhere('active',3)
            ->orWhere('active',5)
            ->orderByDesc('id')
            ->paginate(10);
    }

    public function getStaff(){
        return User::where('active',3)->orderByDesc('id')->paginate(10);

    }

    public function getIntern(){
        return User::where('active',5)->orderByDesc('id')->paginate(10);
    }

    public function update($request, $user){
        try {
            $namsinh = $request->input('birth');
            $time = strtotime($namsinh);
            $newformat = date('Y-m-d',$time);
            $a = Carbon::now();
            $age = $a->diffInYears($newformat);
            //-----------------------
            $user->name = (string) $request->input('name');
            $user->email = (string) $request->input('email');
            $user->birth = (string) $request->input('birth');
            $user->mobile = (string) $request->input('mobile');
            $user->age = $age;
            $user->address = (string) $request->input('address');
            $user->sex = (string) $request->input('sex');
            $user->password = bcrypt($request->input('password'));
            if($request->input('active')==''){
                $user->active  = 4;
            }
            else{
                $user->active = (integer) $request->input('active');
            }
            $user->save();
            Session::flash('success', 'Cập nhật thành công !');
        }
        catch (\Exception $err){
            Session::flash('error','Lỗi');
            return false;
        }
        return true;
    }

    public function updateIntern($user, $active){
        try {
            $user->active = (integer) $active;
            $user->save();
            Session::flash('success', 'Cập nhật thành công !');
        }
        catch (\Exception $err){
            Session::flash('error','Lỗi');
            return false;
        }
        return true;
    }



    public function updatePass($request, $user){
        try {
            $user->password = bcrypt($request->input('repassword'));
            $user->save();
            Session::flash('success', 'Cập nhật thành công !');
        }
        catch (\Exception $err){
            Session::flash('error','Lỗi');
            return false;
        }
        return true;
    }

    public function destroy($request){
        $result2 = User::select('email')->where('id',$request->input('id'))->get();
        if (session()->get('email') == $result2[0]["email"]){
            return false;
        }
        $id = (int)$request->input('id');
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }



}
