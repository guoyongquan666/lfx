<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//用户登录的路由
Route::rule('login', 'admin/Login/in')->method('GET,POST');

//后台首页
Route::get('admin$', 'admin/Index/index');

//console页
Route::get('admin-console', 'admin/Index/console');
Route::rule('admin-add-category', 'admin/Index/addCategory')->method('GET,POST');
Route::get('admin-list-category', 'admin/Index/categoryList');