<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest.admin', ['except' => 'logout']);
    }


    /**
     * 显示后台登录模板
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * 使用 admin guard
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    /**
     * 重写验证时使用的用户名字段
     */
    public function username()
    {
        return 'name';
    }


    public function login(Request $request)
    {
        $arr = [
            'name' => $request->name
        ];
        $admin_info = Admin::where($arr)->first();
        if($admin_info){
            if(!Hash::check($request->password, $admin_info->password)){
                $message = [
                    'code' => 0,
                    'message' => '用户名或者密码错误，请重试'
                ];
            }else{
                $arr = [
                    "last_ip" => $_SERVER['SERVER_ADDR'],
                    'last_time' => date("Y-m-d H:i:s")
                ];
                $admin_info = Admin::where('id',$admin_info->id)->update($arr);
                if($admin_info){
                    $message = [
                        'code' => 1,
                        'message' => '登录成功',
                        'user_info' => $admin_info
                    ];
                }else{
                    $message = [
                        'code' => 0,
                        'message' => '登录失败'
                    ];
                }
            }
        }else{
            $message = [
                'code' => 0,
                'message' => '用户名或者密码错误，请重试'
            ];
        }
        return response()->json($message);
    }
}
