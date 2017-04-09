<?php
header("content-type:text/html;charset=utf8");
class LoginModel extends Model
{
    //验证登录页面用户名和密码是否正确的处理方法
    //全部正确返回true,只要有错误就返回false
    public function loginHandle()
    {
        //获取登录表单数据
        $adminname = $_POST['adminname'];//用户名
        $pwd = md5($_POST['pwd']);//加密的密码

        //会造成SQL注入
        $sql = "SELECT * FROM admin WHERE adminname='$adminname' and pwd='$pwd'";
        $res = $this->find($sql);
        if($res)
        {
            //用户名和密码正确
            return true;
        }else
        {
            return false;
        }

        /*//防止SQL注入
        $sql = "SELECT pwd FROM admin WHERE adminname='$adminname'";
        $res = $this->find($sql);
        if($res)
        {
            //用户名正确
            //判断密码
            if($res['pwd'] == $pwd)
            {
               //密码正确
               return true;
            }else
            {
               //密码错误
               return false;
            }
        }else
        {
          //用户名错误
          return false;
        }*/
    }

    //修改密码的方法
    public function pwdHandle()
    {
        /*echo $_POST['old_pwd'];
        echo $_SESSION['pwd'];die;*/
        if($_POST['old_pwd'] == $_SESSION['pwd'])
        {
            //获取表单传递过来的数据--进行md5加密处置
            $pwd = md5($_POST['new_pwd']);
            //获取
            $adminname = $_SESSION['adminname'];
            //构建SQL语句
            $sql = "UPDATE admin SET pwd = '$pwd' WHERE adminname = '$adminname'";
            //调用基础模型类中方法，执行SQL语句
            return $this->save($sql);
        }else
        {
           echo "<script>alert('原密码不正确！');location.href='?m=Admin&c=Login&a=changePwd'</script>";
        }

       /*//获取表单传递过来的数据--进行md5加密处置
        $pwd = md5($_POST['new_pwd']);
        //构建SQL语句
        $sql = "UPDATE admin SET pwd='$pwd' WHERE adminname='admin'";
        //调用基础模型类中方法，执行SQL语句
        return $this->save($sql);*/
    }


}