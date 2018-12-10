<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'admin/login',
        'admin/register',
        //后台用户管理
        'admin/adminUser/index',
        'admin/adminUser/add',
        'admin/adminUser/show',
        'admin/adminUser/edit',
        'admin/adminUser/delete',
        //前台用户管理
        'admin/user/index',
        'admin/user/add',
        'admin/user/show',
        'admin/user/edit',
        'admin/user/delete',
        //文章类别管理
        'admin/category/index',
        'admin/category/getAll',
        'admin/category/add',
        'admin/category/show',
        'admin/category/edit',
        'admin/category/delete',
        //文章管理
        'admin/article/index',
        'admin/article/add',
        'admin/article/show',
        'admin/article/edit',
        'admin/article/delete',
        //推荐链接管理
        'admin/link/index',
        'admin/link/add',
        'admin/link/show',
        'admin/link/edit',
        'admin/link/delete',
    ];
}
