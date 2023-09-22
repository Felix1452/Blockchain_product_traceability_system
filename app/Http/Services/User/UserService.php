<?php

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getUser($request){
        $user =  User::select('email',$request->input('email'))->get();
        return $user;
    }
    public function getName($request){
        $user =  User::select('name')
            ->where('email',$request->input('email'))
            ->get();
        return $user;
    }
    public function create($request){
        $a = DB::select('select email from users where email ="'.$request->input('email').'"');
//        dd($a);
        try {
            if (sizeof($a) == 0){
                if($request->input('uid') != null){
                    User::create([
                    'name'=>(string)$request->input('name'),
                    'email'=>(string)$request->input('email'),
                    'mobile'=>(string)$request->input('mobile'),
                    'password'=>bcrypt($request->input('password')),
                    'uid'=>(string)$request->input('uid'),
                    'active'=>4
                    ]);
                    return true;
                }else{
                    User::create([
                    'name'=>(string)$request->input('name'),
                    'email'=>(string)$request->input('email'),
                    'mobile'=>(string)$request->input('mobile'),
                    'password'=>bcrypt($request->input('password')),
                    'active'=>4
                    ]);
                    Session::flash("success","Tạo tài khoản thành công");
                    return true;
                }
            }else{
                if($request->input('uid') != null){
                    return false;
                }else{
                    Session::flash("error","Tài khoản tồn tại");
                    return false;
                }

            }
        }catch (\Exception $err){
            Session::flash("error",$err->getMessage());
            return false;
        }
    }


}
