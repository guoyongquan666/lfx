<?php
/**
 * Created by PhpStorm.
 * User: qingyun
 * Date: 19/5/20
 * Time: 下午8:03
 */

namespace app\admin\controller;

use app\admin\model\category;
use think\Controller;

class Article extends Controller
{
    /**
     * @return mixed
     * @throws \think\Exception\DbException
     *
     * 添加文章
     */
    public function add()
    {
        $request = $this->request;

        //如果是POST请求
        if ($request->isPost()){

            $data = $request->only('title','category_id','author','content','status');

            //验证
            $rule = [
                'title' => 'require|length:1,50',
                'category_id' => 'require|min:1',
                'author' => 'length:2,10',
                'content' => 'require|length:10,16635',
                'status' => 'in:0,1'
            ];
            $msg = [
                'title.require' => '请输入文章标题',
                'title.length' => '文章标题应在1-50字符之间',
                'category_id.require' => '请选择正确的分类信息',
                'category_id,min' => '请选择正确的分类信息',
                'author.length' => '署名长度应在2-10个字符之间',
                'content.require' => '请输入文章内容',
                'content.length' => '文章内容格式不符',
                'status.in' => '文章状态有误'
            ];

             $check = $this->validate($data,$rule,$msg);
            if ($check !== true){
                $this->error($check);
            }
            $data['aid'] = session('adminLoginInfo')->id;


            //入库
            $cre =  \app\admin\model\article::create($data);
            if ($cre){
                $this->success('添加成功',url('admin/Article/lists'));
            }else{
                $this->error('添加失败');
            }
        }

        //如果是GET请求
        if ($request->isGet()){
            //获取分类信息

            $all = category::where('pid',0)->all();

            $this->assign('all',$all);
            return $this->fetch();
        }


    }


    /**
     * 使用ajax获取文章分类
     */
    public function ajaxCategory()
    {

        $pid = $this->request->param('id',0);
        $data = category::where('pid',$pid)->select();
        return json($data);
    }

    /**
     * 文章列表
     */
    public function lists()
    {
        $lists = \app\admin\model\article::with('category')->order('create_time DESC')->paginate();

        $this->assign('list',$lists);

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
        $obj->status = abs($obj->status -1);
        if ($obj->save()){
            return $this->success('成功','',$obj->status);
        }else{
            return $this->error('失败');
        }
    }
}