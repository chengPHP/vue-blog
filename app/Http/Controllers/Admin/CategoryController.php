<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $map = [
            ['status','>=',0]
        ];
        if($request->name){
            $map[] = ['name','like','%'.$request->name.'%'];
        }
        $list = Category::where($map)->get();

        return response()->json($list);
    }

    public function getAll(){
        $map = [
            ['status','>',0]
        ];
        $list = Category::where($map)->get();
        return response()->json($list);
    }

    public function add(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->pid = $request->pid;
        $category->status = $request->status;
        if($request->pid == 0){
            $category->path = '0';
        }else{
            $path = Category::where('id',$request->pid)->value('path');
            $category->path = $path.','.$request->pid;
        }

        if($category->save()){
            $message = [
                'code' => 1,
                'message' => '类别信息添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '类别信息添加失败，请稍后重试'
            ];
        }
        return response()->json($message);
    }

    public function show($id)
    {
        $info = Category::find($id);
        if($info){
            $map = [
                ['status','>',0]
            ];
            $list = Category::where($map)->get();
            $message = [
                'code' => 1,
                'info' => $info,
                'list' => $list
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '请检查正确之后再查询'
            ];
        }
        return response()->json($message);
    }

    public function edit(Request $request)
    {
        $arr = [
            'name' => $request->name,
            'status' => $request->status,
            'pid' => $request->pid
        ];
        if($request->pid == 0){
            $arr['path'] = '0';
        }else{
            $path = Category::where('id',$request->pid)->value('path');
            $arr['path'] = $path.','.$request->pid;
        }
        if(Category::where('id',$request->id)->update($arr)){
            $message = [
                'code' => 1,
                'message' => '类别信息修改成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '类别信息修改失败，请稍后重试'
            ];
        }
        return response()->json($message);
    }

    public function destroy($id)
    {
        $category_info = Category::with('article')->find($id);
        if($category_info->pid==0){
            if(count($category_info->article) > 0){
                $message = [
                    'code' => 0,
                    'message' => '此类别下还有文章，暂时不可以删除'
                ];
            }else{
                if(Category::where('id',$id)->update(['status' => -1])){
                    $message = [
                        'code' => 1,
                        'message' => '删除成功'
                    ];
                }else{
                    $message = [
                        'code' => 0,
                        'message' => '删除失败，请稍后重试'
                    ];
                }
            }
        }else{
            $message = [
                'code' => 0,
                'message' => '此类别下还有子类，暂时无法删除'
            ];
        }
        return response()->json($message);
    }
}
