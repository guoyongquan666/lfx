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
/**
 * 后台部分
 */
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
Route::post('admin-article-upload-image', 'admin/Article/uploadImage');
Route::rule('admin-article-umupload-image', 'admin/Article/umUploadImage')->method('GET,POST');
//ajax获取文章封面
Route::post('admin-article-upload-image', 'admin/Article/uploadImage');

Route::get('admin-list-category', 'admin/Index/categoryList');

//删除文章
Route::get('admin-list-delete', 'admin/Index/delete');
//修改文章(有bug)
Route::get('admin-list-revise', 'admin/Index/revise');
//上传文章(未完成)
Route::rule('admin-list-upload','admin/Index/upload')->method('GET,POST');
//查看图片(未完成)
Route::rule('admin-list-image','admin/Index/image')->method('GET,POST');

//图片管理
Route::rule('admin-image/[:id]$', 'admin/Image/lists')->method('GET,POST');
Route::rule('admin-image-add', 'admin/Image/add')->method('GET,POST');
Route::rule('admin-image-category', 'admin/Image/getImageCategory')->method('GET,POST');



/**
 * 前台部分
 */
//首页
Route::get('lfx', 'Index/index/index');

//新闻中心
Route::get('news/[:id]$', 'Index/index/news');
//限制变量的规则，可选参数不受规则限制
//Route::get('news/:id', 'Index/index/news')->pattern(['id'=>'\d+']);
//Route::get('news/:id', 'Index/index/news', [], ['id'=>'\d+']);
//新闻详情
Route::get('news/detail/[:id]', 'Index/index/detail');
//关于我们
Route::rule('about/[:id]$', 'Index/index/about')->method('GET,POST');
//产品欣赏
Route::rule('product', 'Index/index/product')->method('GET,POST');
//名人代言
Route::rule('celebrity', 'Index/index/celebrity')->method('GET,POST');



















