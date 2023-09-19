<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\User\UserService;

class RegisterController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function index(){
        return view('admin.users.register',[
            'title'=>'Đăng ký'
        ]);
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'bail|required|',
            'email' => 'bail|required|email',
            'mobile' => 'bail|required|unique:users|max:11',
            'password' => 'bail|required|min:8',
            'repass' => 'bail|required|same:password',
        ],
        [
            'name.required' => 'Vui lòng nhập tên!',
            'email.required' => 'Vui lòng nhập email!',
            'email.unique' => 'Email đã tồn tại!',
            'mobile.required' => 'Vui lòng nhập số điện thoại!',
            'mobile.unique' => 'Số điện thoại đã tồn tại!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.min' => 'Độ dài mật khẩu tối thiểu là 8 kí tự!',
            'repass.required' => 'Vui lòng nhập lại mật khẩu!',
            'repass.same' => 'Mật khẩu không giống!'
            ]);
        $result = $this->userService->create($request);
        if ($result){
            return redirect()->route('login');
        }
        return redirect()->back();
        //dd($request->input());
    }
}
