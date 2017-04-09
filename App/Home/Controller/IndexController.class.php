<?php
class IndexController extends Controller
{
    //默认的方法，显示首页的方法
    public function index()
    {
        $art = new ArticleModel();
        $data = $art->getFiveArtsByHits();
        //右侧“最新文章”、“推荐文章”显示
        $arr = $art->getEightArts();
        /*echo "<pre>";
        print_r($arr['title2']);
        die;*/
        //分配变量
        $this->smarty->assign('title1',$arr['title1']);//右侧最新文章
        $this->smarty->assign('title2',$arr['title2']);//右侧推荐文章
        $this->smarty->assign('data',$data);
        //指定模板
        $this->smarty->display('index.html');
    }
}