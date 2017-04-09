<?php
class ListController extends Controller
{
    //显示列表页的方法
    public function index()
    {
        //获取地址栏的categoryid
        $categoryid = $_GET['categoryid'];//可能是大类别的id,也可能是小类别的id
        //判断获取的categoryid是大类别还是小类别
        //如果parent_id == 0，则是大类别
        //获取地址栏的type参数，用来判断传递过来的categoryid是大类别id还是小类别id
        $type = $_GET['type'];
        //类的实例化
        $art = new ArticleModel();
        //调用方法，并传递参数，得到返回值
        $arr = $art->getArtsByCategoryId($categoryid,$type);
        /*echo "<pre>";
        print_r($arr['name']);
        //echo $arr['name'][0]['name'];
        die;*/

        /*echo "<pre>";
        print_r($arr['data']);
        die;*/

        /*echo "<pre>";
        print_r($arr['comment']);
        die;*/


        //分配变量
        //print_r($arr['name']);根据其特点作相应的判断，然后显示不同的type类型--
        $this->smarty->assign('name',$arr['name']);//位置显示
        $this->smarty->assign('data',$arr['data']);//中间列表的数据内容，右侧“点击排行”的内容
        $this->smarty->assign('show',$arr['show']);//分页样式
        $this->smarty->assign('name3',$arr['name3']);//右侧子类导航显示
        $this->smarty->assign('title',$arr['title']);//右侧“栏目推荐”的内容
        $this->smarty->assign('comment',$arr['comment']);//最新评论

        //指定模板
        $this->smarty->display('index.html');
    }

    //显示"关于我"
    public function show()
    {
        //指定模板
        $this->smarty->display('about.html');
    }

    //显示“点击排行”、“栏目推荐”的文章内容
    public function showr()
    {

    }

}
