<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix'=>'admin','namespace'=>'Admin\Auth'],function (){
    //后台登录
    Route::post('login','LoginController@login');
    //后台注册
    Route::post('register','RegisterController@register');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    //后台首页

    //后台用户管理
    Route::post('adminUser/index','AdminController@index');
    //后台用户添加
    Route::post('adminUser/add','AdminController@add');
    //指定后台用户详情信息
    Route::get('adminUser/show/{id}','AdminController@show');
    //后台用户信息修改
    Route::post('adminUser/edit','AdminController@edit');
    //后台用户信息软删除
    Route::post('adminUser/destroy','AdminController@destroy');

    //前台用户管理
    Route::post('user/index','UserController@index');
    //前台用户添加
    Route::post('user/add','UserController@add');
    //前定后台用户详情信息
    Route::get('user/show/{id}','UserController@show');
    //前台用户信息修改
    Route::post('user/edit','UserController@edit');
    //前台用户信息软删除
    Route::post('user/destroy','UserController@destroy');

    //文章类别管理
    Route::post('category/index','CategoryController@index');
    Route::post('category/getAll','CategoryController@getAll');
    //添加
    Route::post('category/add','CategoryController@add');
    //详情信息
    Route::get('category/show/{id}','CategoryController@show');
    //修改
    Route::post('category/edit','CategoryController@edit');
    //软删除
    Route::post('category/destroy','CategoryController@destroy');

    //文章管理
    Route::post('article/index','ArticleController@index');
    //添加
    Route::post('article/add','ArticleController@add');
    //详情信息
    Route::get('article/show/{id}','ArticleController@show');
    //修改
    Route::post('article/edit','ArticleController@edit');
    //软删除
    Route::post('article/destroy','ArticleController@destroy');

    //推荐链接管理
    Route::post('link/index','LinkController@index');
    //添加
    Route::post('link/add','LinkController@add');
    //详情信息
    Route::get('link/show/{id}','LinkController@show');
    //修改
    Route::post('link/edit','LinkController@edit');
    //软删除
    Route::post('link/destroy','LinkController@destroy');

});