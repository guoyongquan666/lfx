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
Route::get('admin-tree-category', 'admin/Index/categoryTree');

//添加文章
Route::rule('admin-article-add', 'admin/Article/add')->method('GET,POST');

//ajax获取文章分类

Route::post('admin-article-category', 'admin/Article/ajaxCategory');
Route::post('admin-article-change-status', 'admin/Article/changeStatus');

Route::get('admin-list-category', 'admin/Index/categoryList');

//删除文章
Route::get('admin-list-delete', 'admin/Index/delete');
//修改文章
Route::get('admin-list-revise', 'admin/Index/revise');
//上传文章
Route::rule('admin-list-upload','admin/Index/upload');
//上传图片略错图
Route::rule('admin-list-image','admin/Index/image');

