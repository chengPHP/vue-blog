<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $map = [
            ['status', '>=', 0]
        ];
        if($request->title){
            $map[] = ['title', 'like', '%'.$request->title.'%'];
        }
        $list = Article::where($map)->with('category')->get();
        return response()->json($list);
    }

    public function add(Request $request)
    {
        $arr = [
            'title' => $request->title,
            'tags' => $request->tags,
            'descr' => $request->descr,
            'admin_id' => $request->admin_id,
            'art' => $request->art,
            'status' => $request->status
        ];
        $id = DB::table('articles')->insertGetId($arr);
        if($id){
            //添加关联表数据
            foreach ($request->category_id as $k=>$v){
                ArticleCategory::insert(["article_id"=>$id,"category_id"=>$v]);
            }
            $message = [
                'code' => 1,
                'message' => '文章信息添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '文件添加失败，请稍后重试'
            ];
        }
        return response()->json($message);
    }

    public function show($id)
    {
        $info = Article::with('category')->find($id);
        if($info){
            $message = [
                'code' => 1,
                'message' => '查询成功',
                'info' => $info
            ];
        }else{
            $message = [
                'code' =>'0',
                'message' => '查询操作不正确，请稍后再试'
            ];
        }
        return response()->json($message);
    }

    public function edit(Request $request)
    {
        $arr = [
            'title' => $request->title,
            'tags' => $request->tags,
            'descr' => $request->descr,
            'admin_id' => $request->admin_id,
            'art' => $request->art,
            'status' => $request->status
        ];
        if(Article::where('id',$request->id)->update($arr)){
            //删除该文章之前所有的文章类别
            ArticleCategory::where("article_id",$request->id)->delete();
            //添加关联表数据
            foreach ($request->category_arr as $category_id){
                ArticleCategory::insert(["article_id"=>$request->id,"category_id"=>$category_id]);
            }
            $message = [
                'code' => 1,
                'message' => '文章信息添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '文章信息修改失败，请稍后再试'
            ];
        }
        return response()->json($message);
    }

    public function destroy($id)
    {
        $arr = explode(',',$id);
        foreach ($arr as $article_id){
            $info = Article::where('id',$article_id)->update(['status' => -1]);
            if(!$info){
                $message = [
                    'code' => 0,
                    'message' => '文章删除失败，请稍后再试'
                ];
                return response()->json($message);
            }
            $message = [
                'code' => 1,
                'message' => '指定文章删除成功'
            ];
        }
        return response()->json($message);
    }
}
