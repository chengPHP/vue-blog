<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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
        $list = Admin::where($map)->get();
        return response()->json($list);
    }

    /**
     * 添加用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->status = $request->status;
        $admin->password = bcrypt($request->password);

        if($admin->save()){
            $message = [
                'code' => 1,
                'message' => '后台用户添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '后台用户添加失败，请稍后再试'
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
        $info = Admin::find($id);
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
        /*$admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->status = $request->status;
        if($request->password) {
            $admin->password = bcrypt($request->password);
        }*/

        $arr = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status
        ];

        if($request->password) {
            $arr['password'] = bcrypt($request->password);
        }

        if(Admin::where('id',$request->id)->update($arr)){
            $message = [
                'code' => 1,
                'message' => '后台用户信息修改成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '后台用户信息修改失败，请稍后再试'
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
        if(Admin::find($id)){
            $info = Admin::where('id',$id)->update(['status' => -1]);
            if($info){
                $message = [
                    'code' => 1,
                    'message' => '后台用户软删除成功'
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
