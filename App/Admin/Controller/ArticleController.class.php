<?php
header("content-type:text/html;charset=utf8");
class ArticleController extends CommonController
{
    //显示文章列表页
    public function index()
    {
        //判断是否登录
        //$this->session();
        //判断地址栏中是否有categoryid，如果有这个参数，就以这个参数为条件查询文章，如果没有这个参数就查询所有文章
        //$category = isset($_GET['categoryid']) ? $_GET['categoryid'] : 0;--构建查询时有缺陷,牵扯到博文管理，要显示所有的文章内容
        if(isset($_GET['categoryid']) && $_GET['categoryid'] != 0)
        {
            $where = "WHERE cid = ".$_GET['categoryid'];
        }else
        {
            $where = '';
        }
        //实例化模型类，调用getArticles()方法来获取数据
        $art = new ArticleModel();
//        $data = $art->getArticles($where);
        $arr = $art->getArticles($where);
        //下面使用smarty模板分配数据，显示模板即可
        //分配变量
//        $this->smarty->assign('data',$data);
        $this->smarty->assign('data',$arr['data']);//分配数据
        $this->smarty->assign('show',$arr['show']);//分配样式
        //指定模板
        $this->smarty->display('index.html');
    }

    //显示添加文章列表页
    public function add()
    {
        //判断是否登录
        //$this->session();

        //(0)取出所有的分类
        $category = new CategoryModel();
        $cate = $category->getAllCates();//取出未排序的分类
        $cate =  $category->sortCate($cate);//将分类排序
        //(1)将排序好的分类分配到模板中
        $this->smarty->assign('cate',$cate);
        //(2)指定模板
        $this->smarty->display('add.html');
    }

    //处理添加的方法
    public function addHandle()
    {
        /*//使用上传了实现上传
        $upload = new Upload();//会自动调用Upload类的构造方法
        //exit;
        //调用方法
        $upload->up();
        exit;*/

        //先获取表单中的字段(title,content,ptime,author,keywords,hits,description,alias,cid)
        $arr = $_POST;
        //缺少ctime--文章的添加时间
        //添加当前的时间戳为ctime,并放在数组中
        $arr['ctime'] = time();
        //缺少文章的修改时间
        //$arr['utime'] = 0;//如果数据没有值，就赋值为0

        $arr['pic'] = '';//默认文件的路径为空字符串
        //判断是否有文件上传
        if($_FILES['file']['name'])
        {
            //使用上传类实现上传
            $upload = new Upload();//会自动调用其中的构造方法
            $file = $upload->up();
            //文件路径覆盖
            $arr['pic'] = $file;
        }
        //模型类的实例化，调用方法，并得到返回值
        $art = new ArticleModel();
        $res = $art->insert($arr);
        //判断
        if($res)
        {
            $this->jump('添加成功！','?m=Admin&c=Article&a=index&categoryid='.$_POST['cid']);
        }else
        {
            $this->jump('添加失败！','?m=Admin&c=Article&a=add&categoryid='.$_POST['cid']);
        }
    }

    //删除一条文章的方法--接收传递过来的id并进行删除
    public function del()
    {
        $articleid = $_GET['articleid'];//文章id
        //取出地址栏的categoryid
        $categoryid = $_GET['categoryid'];
        $art = new ArticleModel();
        //调用方法，获取返回值
        $res = $art->delArt($articleid);
        //判断
        if($res)
        {
            //成功
            $this->jump('删除成功！','?m=Admin&c=Article&a=index&categoryid='.$categoryid);
        }else
        {
            //失败
            $this->jump('删除失败！','?m=Admin&c=Article&a=index&categoryid='.$categoryid);
        }
    }

    //批量删除的方法
    public function delAll()
    {
        /*echo "<pre>";
        print_r($_POST);*/
        $categoryid = $_POST['categoryid'];
        //echo $categoryid;die;
        $ids = $_POST['id'];//这是一个一维数组，数组的单元就是要删除的id
        //类的实例化
        $art = new ArticleModel();
        //调用方法，循环删除
        //第一种方法
       /* foreach($ids as $id)
        {
            $art->delArt($id);
        }*/

        //将数组变为字符串
        $idstr = implode(',',$ids);
        ///echo $idstr;die;
        //$sql = "DELETE FROM article WHERE id in($idstr)";
        $res = $art->delAll($idstr);
        if($res)
        {
            $this->jump('删除成功！','?m=Admin&c=Article&a=index&categoryid='.$categoryid);
        }else
        {
            $this->jump('删除成功！','?m=Admin&c=Article&a=index&categoryid='.$categoryid);
        }
    }

    //显示修改文章内容的方法
    public function updateArt()
    {
        //判断是否登录
        //$this->session();

        //查询所有的分类
        $category = new CategoryModel();
        $cate = $category->getAllCates();
        $cate = $category->sortCate($cate);

        //类的实例化
        $art = new ArticleModel();
        //调用类中显示修改内容的方法,获取返回值
        $data = $art->showArt();

        //分配变量
        $this->smarty->assign('data',$data);
        $this->smarty->assign('cate',$cate);
        //指定模板
        $this->smarty->display('update.html');
    }
    //处理修改文章内容的方法
    public function update()
    {
        //先获取表单中的字段(title,content,ptime,author,keywords,hits,description,alias,cid)
        $arr = $_POST;
        /*echo "<pre>";
        print_r($arr);
        echo "</pre>";die;*/
        //缺少ctime--文章的添加时间
        //添加当前的时间戳为ctime,并放在数组中
        $arr['ctime'] = time();
        //缺少文章的修改时间
        $arr['utime'] = time();//如果数据没有值，就赋值为0

        //$arr['pic'] = '';//默认文件的路径为空字符串
        //判断是否有文件上传
        if($_FILES['file']['name'])
        {
            //使用上传类实现上传
            $upload = new Upload();//会自动调用其中的构造方法
            $file = $upload->up();
            //文件路径覆盖
            $arr['pic'] = $file;
        }
        //echo $arr['pic'];die;
        //类的实例化，实现自动加载
        $art = new ArticleModel();
        //调用模型类中的处理方法
        $res = $art->updateHdle($arr);
        //判断
        //var_dump($res);die;
        if($res)
        {
            $this->jump('修改成功！','?m=Admin&c=Article&a=index');
        }else
        {
            $this->jump('修改失败！','?m=Admin&c=Article&a=index');
        }

    }
}