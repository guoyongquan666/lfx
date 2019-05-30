<?php
namespace app\index\controller;

use app\admin\model\article;
use app\admin\model\category;
use app\admin\model\celebrity;
use app\admin\model\images;
use think\Controller;
use think\Image;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }


    //关于我们
    public function about()
    {
        //分类的id
        $id = $this->request->param('id');
        $this->categoryList(5);

        $info = article::where('category_id', $id)->find();
        $this->assign('info', $info);

        $this->assign('id', $id);


        return $this->fetch();
    }

    //新闻中心
    public function news()
    {

        $id = $this->request->param('id', 0);

        $this->assign('id', $id);
        //查出新闻中心的所有子分类信息

        $category = $this->categoryList(1);

        $categories = [];

        foreach ($category as $v){
            $categories[] = $v['id'];

        }

        if ($id){
            //当前分类的信息
            $categoryInfo = category::where('id', $id)->find();
            $this->assign('categoryInfo', $categoryInfo);
            //文章列表
            $list = article::where('category_id', $id)
                    ->where('status', 1)
                    ->order('create_time desc')
                    ->paginate(3,true);
        }else{
            $this->assign('categoryInfo', '');
            $list = article::where('category_id','in', $categories)
                    ->where('status', 1)
                    ->order('create_time desc')
                    ->paginate(3,true);
        }
        $this->assign('page',$list);
        $this->assign('list', $list);


        return $this->fetch();
    }

    //新闻详情
    public function detail()
    {

        $category = $this->categoryList(1);

        //文章id
        $id = $this->request->param('id');


        $info = article::get($id);

        $this->assign('info', $info);

        //更新阅读量
        $info->setInc('hits');

//        $this->success($category);
        return $this->fetch();
    }

    //新闻详情的分类
    protected function categoryList($id){

        $category = category::where('pid', $id)->select();
        $this->assign('category', $category);
        return $category;
    }




    //产品欣赏
    public function product()
    {
        $re = $this->request;

        $id = $re->param('id',0);
        if ($id==0){
            $where =[];
        }else{
            $where['category_id'] = $id;
        }
        $this->assign('id',$id);

        $image = images::where($where)->paginate(12);
        $this->assign('imageList',$image);
        //查询当前类的所有子分类
        $categoryList = category::where('pid',3)->select();
        $this->assign('categoryList',$categoryList);

        return $this->fetch();
    }

    //名人代言
    public function celebrity()
    {
        $re = $this->request;

        $id = $re->param('id');

        $this->categoryList(31);
        //查询名人代言下的所有子分类
        $category = article::where('category_id',32)->select();
        $this->assign('categoryList',$category);
        $this->assign('id',$id);



        return $this->fetch();

    }


}
