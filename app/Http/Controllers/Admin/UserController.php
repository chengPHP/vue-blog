<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 用户列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $map = [];
        if($request->phone){
            $map = [
                ['phone', "like", '%'.$request->phone.'%']
            ];
        }
        $list = User::where($map)->get();
        return response()->json($list);
    }

    /**
     * 添加用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->sex = $request->sex;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);

        if($user->save()){
            $message = [
                'code' => 1,
                'message' => '前台用户添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '前台用户添加失败，请稍后再试'
            ];
        }
        return response()->json($message);
    }

    /**
     * 修改用户信息
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = User::find($id);
        if($info){
            $message = [
                'code' => 1,
                'message' => '用户信息获取成功',
                'info' => $info
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '非法查询，请检查之后再查询'
            ];
        }
        return response()->json($message);
    }

    /**
     * 软删除指定用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $arr = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sex' => $request->sex,
            'status' => $request->status
        ];

        if($request->password) {
            $arr['password'] = bcrypt($request->password);
        }

        if(User::where('id',$request->id)->update($arr)){
            $message = [
                'code' => 1,
                'message' => '前台用户信息修改成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '前台用户信息修改失败，请稍后再试'
            ];
        }
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::find($id)){
            $info = User::where('id',$id)->update(['status' => -1]);
            if($info){
                $message = [
                    'code' => 1,
                    'message' => '前台用户软删除成功'
                ];
            }else{
                $message = [
                    'code' => 0,
                    'message' => '操作异常，请稍后重试'
                ];
            }
        }else{
            $message = [
                'code' => 0,
                'message' => '非法操作，请检查正确再操作'
            ];
        }
        return response()->json($message);
    }
}
