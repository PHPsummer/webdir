<?php
header("content-type:text/html;charset=utf8");
class CategoryController extends CommonController
{
    //显示所有分类
    public function index()
    {
        /********未排序之前********/
        /*//取出所有的分类
        $category = new CategoryModel();
        $data = $category->getAllCates();
        //打印数据看看
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //分配变量
        $this->smarty->assign('data',$data);
        //指定模板
        $this->smarty->display('index.html');*/

        /********排序之后********/
        //$this->session();
        //取出所有的分类
        $category = new CategoryModel();
        $data = $category->getAllCates();
        $data = $category->sortCate($data);//将没有分类的数据进行分类
        //分配变量
        $this->smarty->assign('data',$data);
        //指定模板
        $this->smarty->display('index.html');
    }

    //显示添加分类的方法
    public function add()
    {
        //$this->session();
        //取出所有的分类，并分配到模板中，在模板的select框中循环option
        $category = new CategoryModel();
        //获取所有的未分类信息
        $data = $category->getAllCates();
        //调用模型控制器类中的方法，进行分类，并将未分类的信息传递过去
        $data = $category->sortCate($data);
        //分配变量
        $this->smarty->assign('data',$data);
        //指定模板
        $this->smarty->display('add.html');
    }

    //处理添加分类的方法
    public function addHandle()
    {

        /*echo "<pre>";
        print_r($_POST);
        die;*/
        $category = new CategoryModel();
        $res = $category->insert();//成功返回最新添加的id，失败返回false
        if($res)
        {
           $this->jump('添加成功！','?m=Admin&c=Category&a=index');
        }else
        {
            $this->jump('添加失败！','?m=Admin&c=Category&=add');
        }
    }

    //删除分类的方法--根据id进行删除
    public function del()
    {
        //首先得到所要删除的分类所有的id
        $category = new CategoryModel();
        //得到一个二维数组
        $id = $category->getIds();
        //调用模型控制器中的删除方法，并传递二维数组的参数
        $res = $category->delCate($id);
        /*echo "<pre>";
        print_r($res);//得到的是一个二维数组
        echo "</pre>";
        die;*/
        //将所选择的要删除的分类id获取到，并放到一维数组中
        $res[] = $_GET['id'];
        //真正删除
        $result = $category->delHandle($res);
        if($result)
        {
            $this->jump('删除成功！','?m=Admin&c=Category&a=index');
        }else
        {
            $this->jump('删除失败！','?m=Admin&c=Category&a=index');
        }

    }

    //显示修改分类的方法--根据id进行修改
    public function showUpdate()
    {
        //测试看看，能够正确获取到id
        //echo $_GET['id'];die;
        //类的实例化
        $category = new CategoryModel();
        //获取所有的未分类信息
        $cate = $category->getAllCates();
        //调用模型控制器类中的方法，进行分类，并将未分类的信息传递过去
        $cate = $category->sortCate($cate);
        //调用方法--根据id提取需要修改的数据到指定的模板
        $data = $category->showUpdate();

        /*echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;*/

        //分配变量
        $this->smarty->assign('cate',$cate);
        $this->smarty->assign('data',$data);
        //指定模板
        $this->smarty->display('update.html');
    }

    //处理修改分类的方法--根据id，进行数据的更新
    public function update()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        die;*/
        $categoryid = $_POST['categoryid'];
        $parent_id = $_POST['parent_id'];
        //打印看看id是否正确

        /*echo $categoryid;
        echo "<br>";
        echo $parent_id;
        die;*/
        //类的实例化--实现类的自动加载
        $res = new CategoryModel();
        //调用方法,传递参数id,获取返回值
        $result = $res->update();
        //echo $result;die;
        if($result)
        {
            //成功
            $this->jump('修改成功！','?m=Admin&c=Category&a=index');
        }else
        {
            //失败
            $this->jump('修改失败！','?m=Admin&c=Category&a=showUpdate');
        }
    }
}