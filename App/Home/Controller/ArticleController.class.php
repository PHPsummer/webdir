<?php
//文章内容页面控制器
class ArticleController extends Controller
{
    //显示文章内容页
    public function index()
    {
        //$this->smarty->display('index.html');
        //获取地址栏的articleid，根据articleid，获取当前这篇文章的内容
        $articleid = $_GET['articleid'];
        //获取categoryid type,为了显示右侧的部分内容
        $categoryid = $_GET['categoryid'];
        $type = $_GET['type'];
        //echo $categoryid,$type,$articleid;die;
        //调用Article模型中的方法
        //得到文章的内容--并且包含上一篇和下一篇
        $art = new ArticleModel();
        $row = $art->getArtByArticleid($articleid);
        /*echo "<pre>";
        print_r($row);
        die;*/

        //取出“位置”信息
        $res = $art->getAddress($articleid);

        //显示右侧部分信息
        $arr = $art->getArtsByCategoryId($categoryid,$articleid,$type);
        $this->smarty->assign('content',$row['content']);//文章信息以及上一篇和下一篇
        /*$this->smarty->assign('first',$row['first']);//上一篇
        $this->smarty->assign('next',$row['next']);//下一篇*/
        $this->smarty->assign('page',$row['page']);

        $this->smarty->assign('res',$res);//位置信息
        $this->smarty->assign('name3',$arr['name3']);//右侧子类导航显示
        $this->smarty->assign('data',$arr['data']);//中间列表的数据内容，右侧“点击排行”的内容
        $this->smarty->assign('title',$arr['title']);//右侧“栏目推荐”的内容
        $this->smarty->assign('comment',$arr['comment']);//最新评论

        //取出这篇文章的评论
        $model = new Model();
        //$sql = "SELECT * FROM comment WHERE articleid = $articleid";
        $sql = "SELECT c.content,c.ctime,u.username,u.face FROM comment c LEFT JOIN user u ON c.userid = u.id WHERE articleid = $articleid";
        $pinglun = $model->select($sql);
        //分配变量
        $this->smarty->assign('pinglun',$pinglun);

        //指定模板--View/Article/index.html
        $this->smarty->display('index.html');
    }



}