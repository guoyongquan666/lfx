<?php

namespace app\admin\controller;

use app\admin\model\category;
use think\Controller;

class Article extends Controller
{

    /**
     * 添加文章
     */
    public function add()
    {
        $request = $this->request;
        //如果是POST请求
        if ($request->isPost()){


            $data = $request->only(['title', 'category_id', 'author', 'content', 'status']);
            //验证
            $rule = [
                'title' => 'require|length:1,50',
                'category_id' => 'require|min:1',
                'author' => 'length:2,10',
                'content' => 'require|length:10,65535',
                'status' => 'in:0,1'
            ];
            $msg = [
                'title.require' => '文章标题为必填项',
                'title.length' => '文章标题长度应在1-50个字符之间',
                'category_id.require' => '请选择正确的分类信息',
                'category_id.min' => '请选择正确的分类信息',
                'author.length' => '署名长度应在2-10个字符之间',
                'content.require' => '文章内容为必填项',
                'content.length' => '文章内容过短或者过长',
                'status.in' => '文章状态有误'

            ];
            $check = $this->validate($data, $rule, $msg);
            if ($check !== true){
                $this->error($check);
            }

            $data['aid'] = session('adminLoginInfo')->id;
            //入库

            if (\app\admin\model\article::create($data)){
                $this->success('添加成功', url('admin/Article/lists'));
            }else{
                $this->error('添加失败');
            }


        }
        //如果是GET请求
        if ($request->isGet()){

            //获取分类信息
            $all = category::where('pid', 0)->all();


            $this->assign('all', $all);
            return $this->fetch();
        }

    }

    /**
     * 使用ajax获取文章分类
     */
    public function ajaxCategory()
    {
        $request = $this->request;
        $pid = $this->request->param('id', 0);
        $data = category::where('pid', $pid)->select();
        return json($data);
//        if ($request->isAjax()){
//            $pid =$request->param('id',0);
//            if ($pid != 0){
//                $data = category::where('pid',$pid)->select();
//                return json($data);
//            }
//        }
    }


    /**
     * 文章列表
     */
    public function lists()
    {
        $list = \app\admin\model\article::with('category')->order('create_time DESC')->paginate(2);

        $this->assign('list', $list);
        return $this->fetch();
    }

    public function changeStatus()
    {
        $id = $this->request->param('id');
        if (empty($id)){
            return $this->error('非法操作');
        }

        $obj = \app\admin\model\article::get($id);
        if (empty($obj)){
            return $this->error('非法操作');
        }

        $obj->status = abs($obj->status - 1);

        if ($obj->save()){
            return $this->success('成功', '', $obj->status);
        }else{
            return $this->error('失败');
        }


    }
    
    
    //删除文章
    public function delete()
    {
        $request = $this->request;

        $id = $request->param('id');

        if (empty($id)){
            $this->error('非法操作');
        }

        $delete = \app\admin\model\article::get($id);

        if ($delete){
             $res =  \app\admin\model\article::where('id',$id)->delete();
            if ($res){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法操作');
        }
        
    }
    
    
    
    //修改文章
    public function revise()
    {

        $request = $this->request;
        if ($request->isGet()){
            $id = $request->param('id');
            $article =  \app\admin\model\article::with('category')->where('id',$id)->find();

            //查询当前字段pid相同的字段
            $pid = $article['category']['pid'];
            $category = category::where('pid',$pid)->where('id','<>',$article['category_id'])->select();

            $this->assign('info',$article);
            $this->assign('category',$category);
            return $this->fetch();
        }

        if ($request->isPost()){
            $data = $request->only(['title','author','content','category_id','update_time']);
            $id = $request->param('id');

            $article=new \app\admin\model\article;
            if ($article->save($data,['id'=>$id])){
                $this->success('修改成功',url('admin/article/lists'));
            }else{
                $this->error('修改失败');
            }
        }


    }

}