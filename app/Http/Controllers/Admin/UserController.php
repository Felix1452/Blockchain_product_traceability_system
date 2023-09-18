<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\User\UserAdminService;
use App\Models\staffs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpMqtt\Client\Facades\MQTT;


class UserController extends Controller
{
    protected $userAdminService;

    public function __construct(UserAdminService $userAdminService)
    {
        $this -> userAdminService = $userAdminService;
    }
    public function create()
    {
        return view('admin.users.add', [
            'title' => 'Thêm User Mới'
        ]);
    }
    public function store(Request $request)
    {
//        dd($request->input());
        $this->validate($request ,[
            'name'=> 'required',
            'email' => 'required|email',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'birth'      => 'required|date|before_or_equal:now',
            'sex' => 'required',
            'active' => 'required',
            'address' => 'required',
            'password' => 'required',
            'repass'=>'required|same:password'
        ]);
//        dd($request->input());
        if(session()->get('perr') == 1){
            $result = $this->userAdminService->create($request);
            if($result){
                return redirect()->route('admin.users.list');
            }else
            {
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function index()
    {
        return view('admin.users.list', [
            'title' => 'Danh sách tài khoản',
            'users' => $this->userAdminService->get()
        ]);
    }
    public function show(User $user){
        return view('admin.users.edit',[
            'title' => 'Chỉnh sửa tài khoản: '. $user->name,
            'users' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        if($request->input('password')!=$request->input('repass')){
            Session::flash('error','Mật khẩu nhập lại không trùng khớp!');
            return redirect()->back();
        }
        $result = $this->userAdminService->update($request, $user);
        if($result){
            return redirect()->route('admin.users.list');
        }
        else
            return redirect()->back();
    }

    public function updateIntern(User $user, $active)
    {
//        dd($active);
        if(session()->has('perr')){
            if (session()->get('perr') == 1 || session()->get('perr') == 2){
                $result = $this->userAdminService->updateIntern($user, $active);
                if($result){
                    return redirect()->route('staff');
                }
                else
                    return redirect()->back();
            }
            session()->flush();
            return redirect()->route('login');
        }

    }



    public function forgotpass(User $user){
        return view('admin.users.forgotpass',[
            'title' => 'Chỉnh sửa tài khoản: '. $user->name,
            'users' => $user
        ]);
    }

    public function updatePass(Request $request, User $user)
    {
        $this->validate($request ,[
            'password' => 'required',
            'repassword' => 'required',
            'repass2' => 'required'
        ]);
        if(Auth::attempt([
            'email'=>$user->email,
            'password'=>$request->input('password')
        ]
        )){
            if($request->input('repassword')!=$request->input('repass2')){
                Session::flash('error','Mật khẩu nhập lại không trùng khớp!');
                return redirect()->back();
            }
            $result = $this->userAdminService->updatePass($request, $user);
            if($result){
                return redirect()->route('admin.users.list');
            }
            else
                return redirect()->back();
        }else{
            Session::flash('error','Mật khẩu không chính xác!');
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        $result = $this->userAdminService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa tài khoản thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }

}
