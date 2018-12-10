<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $map = [
            ['status','>=',0]
        ];
        if($request->name){
            $map[] = ['name','like','%'.$request->name.'%'];
        }
        $list = Link::where($map)->get();
        return response()->json($list);
    }

    public function add(Request $request)
    {
        $link = new Link();
        $link->name = $request->name;
        $link->title = $request->title;
        $link->url = $request->url;
        if($request->orders){
            $link->orders = $request->orders;
        }else{
            $link->orders = 0;
        }
        $link->status = $request->status;

        if($link->save()){
            $message = [
                'code' => 1,
                'message' => '添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '添加失败，请稍后重试'
            ];
        }
        return response()->json($message);
    }

    public function show($id)
    {
        $info = Link::where('id',$id)->first();
        if($info){
            $message = [
                'code' => 1,
                'message' => '查询成功',
                'info' => $info
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '查询失败'
            ];
        }
        return response()->json($message);
    }

    public function edit(Request $request)
    {
        if(Link::find($request->id)){
            $arr = [
                'name' => $request->name,
                'title' => $request->title,
                'url' => $request->url,
                'status' => $request->status
            ];
            if($request->orders){
                $arr['orders'] = $request->orders;
            }else{
                $arr['orders'] = 0;
            }
            if(Link::where('id',$request->id)->update($arr)){
                $message = [
                    'code' => 1,
                    'message' => '超链接信息修改成功'
                ];
            }else{
                $message = [
                    'code' => 0,
                    'message' => '超链接信息修改失败，请稍后重试'
                ];
            }
        }else{
            $message = [
                'code' => 0,
                'message' => '所修改超链接不存在'
            ];
        }
        return response()->json($message);
    }

    public function destroy($ids)
    {
        $arr = explode(',',$ids);
        $message = [
            'code' => 0,
            'message' => '软删除失败'
        ];
        foreach ($arr as $id){
            if(!Link::where('id',$id)->update(['status' => -1])){
                $message = [
                    'code' => 0,
                    'message' => '软删除失败'
                ];
            }
        }
        return response()->json($message);
    }
}
