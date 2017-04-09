<?php
class LoginController extends Controller
{
    //显示登录页面
    public function login()
    {
        $this->smarty->display('login.html');
    }

    //处理登录页面表单提交的信息
    public function loginCheck()
    {
        /*echo $_SESSION['yzm'];
        echo "<br>";
        echo $_POST['yzm'];
        die;*/
        //判断验证码是否正确
        if(strtoupper($_POST['yzm']) != strtoupper($_SESSION['yzm']))
        {
            $this->jump('验证码错误！','?m=Admin&c=Login&a=login');
        }
        //调用LoginModel模型类中的方法loginHandle,验证用户名和密码
        $login = new LoginModel();
        $res = $login->loginHandle();//模型中验证用户名和密码
        if($res)
        {
           //把用户名存入session,为了后来的作登陆判断
           $_SESSION['adminname'] = $_POST['adminname'];
            //将密码存入session,为了后来修改密码时使用
            $_SESSION['pwd'] = $_POST['pwd'];
           //echo 'ok';
           $this->jump('登录成功！','?m=Admin');
        }else
        {
            //echo 'fail';
            $this->jump('用户名或密码错误！','?m=Admin&c=Login&a=login');
        }
    }

    //退出
    public function logout()
    {
        //清除session
        unset($_SESSION['adminname']);
        //跳转
        $this->jump('退出成功！','?m=Admin&c=Login&a=login');
    }

    //实现验证码图片的方法
    public function code()
    {
        //echo 11;die;
        //调用Verify中的code方法
        Verify::codeHandle();
    }

    //显示修改密码页面的方法
    public function changePwd()
    {
        //echo 11;die;

        //指定模板
        $this->smarty->display('changePwd.html');
    }

    //修改密码的方法
    public function pwd()
    {
        /*echo "<pre>";
        print_r($_POST);
        die;*/
        //模型类的实例化
        $res = new LoginModel();
        //调用方法
        $res->pwdHandle();
        //判断是否修改成功
        if($res)
        {
            //成功
            $this->jump('修改成功！','?m=Admin&c=Login&a=login');
        }else
        {
            //失败
            $this->jump('修改失败！','?m=Admin&c=Login&a=changePwd');
        }
    }

}