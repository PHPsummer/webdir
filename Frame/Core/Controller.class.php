<?php
//基础控制器类--为了拿到Smarty对象
class Controller
{
    protected $smarty;
    //构造方法，作用是拿到Smarty对象
    public function __construct()
    {
        if(method_exists($this,'yanzheng'))
        {
            //如果当前对象有yanzheng 这个方法，则调用
            $this->yanzheng();
        }
        $view = new View();//拿到smarty对象
        //把类View中的成员属性传递到类Controller中的成员属性中
        $this->smarty = $view->smarty;
    }

    //判断页面是否有adminname的session值
    public function session()
    {
        if(!isset($_SESSION['adminname']))
        {
            $this->jump('请先登录！','?m=Admin&c=Login&a=login');
        }
    }
    //跳转的方法
    protected function jump($message,$url,$time = 1)
    {
        //php中无法解析js中的变量
        //echo "<script>alert($message);location.href='$src'</script>";
        //使用header函数
        header("content-type:text/html;charset=utf-8");//设置客户端字符集编码
        header("refresh:$time;url=$url");//2秒后更新并进行跳转
        echo $message;//输出提示信息
        exit;//

    }
}