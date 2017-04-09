<?php
//用来验证访问后台的人是否登陆
class CommonController extends Controller
{
    public function yanzheng()
    {
        //echo 1234;die;

        if(!isset($_SESSION['adminname']))
        {
            $this->jump('请先登录！','?m=Admin&c=Login&a=login');
        }
    }
}