<?php
//显示后台首页
class IndexController extends CommonController
{
    //显示后台首页
    public function index()
    {
        //echo $_SESSION['adminname'] ;exit() ;
        //判断session是否有adminname，如果有，表示已经登录，可以访问首页，如果没有则跳转到登录页面
        /*if(!isset($_SESSION['adminname']))
        {
           $this->jump('请先登录！','?m=Admin&c=Login&a=login');
        }*/
        //把session值的判断写在基础类控制器中，需要的时候直接调用方法即可
        //$this->session();
        $this->smarty->display('index.html');
        //分配用户名到后台模板显示
        $this->smarty->assign('adminname',$_SESSION['adminname']);
    }
}
