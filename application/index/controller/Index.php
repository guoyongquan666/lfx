<?php
namespace app\index\controller;

use app\admin\model\article;
use app\admin\model\category;
use think\Controller;

class Index extends  Controller
{
    /**
     * @return mixed
     *
     * 首页
     */
    public function index()
    {
        return $this->fetch();
    }


    /**
     * 关于我们
     */
    public function about()
    {
        return $this->fetch();
    }





    /**
     * @return mixed
     * @throws \think\exception\DbException
     *
     * 新闻中心
     */
    public function news()
    {
        $id = $this->request->param('id',0);
        $this->assign('id',$id);
        //查出新闻中心所有的子分类信息
        $category = $this->categoryList(1);

        $categories = [];
        foreach ($category as $v){
            $categories[] = $v['id'];
        }

        if ($id){
            //当前分类信息
            $categoryInfo = category::where('id',$id)->find();
            $this->assign('categoryInfo',$categoryInfo);
            //文章列表
            $list = article::where('category_id', $id)
                ->where('status', 1)
                ->order('create_time desc')
                ->paginate(10);
        }else{
            $this->assign('categoryInfo','');
            //文章列表
            $list = article::where('category_id','in', $categories)
                ->where('status', 1)
                ->order('create_time desc')
                ->paginate(10);
        }

        $this->assign('list',$list);

        return $this->fetch();
    }

    /**
     * @return mixed
     *
     * 新闻内容
     */
    public function detail()
    {
        $category = $this->categoryList(1);

        //文章id
        $id = $this->request->param('id');

        $info = article::get($id);
        $this->assign('info',$info);

        //更新阅读量
        $info->setInc('hits');




        return $this->fetch();

    }

    public function categoryList($id)
    {
        $category = category::where('pid',$id)->select();

        $this->assign('category',$category);

        return $category;

    }




}
