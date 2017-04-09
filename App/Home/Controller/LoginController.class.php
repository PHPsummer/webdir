<?php
header("content-type:text/html;charset=utf8");
class LoginController extends Controller
{
    //显示注册页面
    public function register()
    {
        $this->smarty->display('register.html');
    }

    //显示验证码的方法
    public function code()
    {
        Verify::codeHandle();
    }

    //完成注册的方法
    public function registerHandle()
    {
        /*echo "<pre>";
        print_r($_POST);
        var_dump($_FILES['face']);
        die;*/
        /**
         *Array
        (
        [username] => naruto
        [pwd] => 123456
        [repwd] => 123456
        [phone] => 15188556790
        [email] => 1527020834@qq.com
        [yzm] => wvmn
        )
        array(5) {
        ["name"]=>
        string(15) "14882704704.jpg"
        ["type"]=>
        string(10) "image/jpeg"
        ["tmp_name"]=>
        string(46) "C:\Users\NRAUTO\AppData\Local\Temp\phpA4FB.tmp"
        ["error"]=>
        int(0)
        ["size"]=>
        int(1937)
        }
         */
        $arr = $_POST;

        //加入时间
        $arr['ctime'] = time();
        //密码加密处理
        $arr['pwd'] = md5(md5($arr['pwd'].'blog'));
        //判断是否有头像
        $arr['face'] = '';//先定义为空
        if($_FILES['face']['name'])
        {
            $upload = new Upload();
            //区分文章图片的保存路径和用户头像的保存路径
            $upload->rootPath = './Public/face';
            $arr['face'] = $upload->up();//调用up方法得到的是图片给的路径和名字 './Public/face/2017-03-04 .... .jpg'
            //图像的缩略
            //Image::thumb($arr['face'],50,50,false);
        }
        //判断验证码是否正确--注意：在核心文件的类Verify.class.php中，已经将验证码写入session中，需要的时候可以直接调出来使用
        if(strtolower($arr['yzm']) != strtolower($_SESSION['yzm']))
        {
            $this->jump('验证码不正确！','index.php?c=Login&a=register');
        }
        //由于数据库的字段中没有验证码这一字段，所有要进行去除，这样才能把注册信息写进数据库
        unset($arr['yzm']);
        //去除重复密码
        unset($arr['repwd']);
        $user = new UserModel();
        $res = $user->reg($arr);
        //根据结果判断
        if($res)
        {/*
            //成功，跳转到登录界面

            //注册成功，发送邮件，进行邮箱验证
            //(1)引入工具类：sendmail.class.php
            //(2)实例化sendmail
            $sendmail = new sendmail();
            //(3)处理发送邮件时的必要参数
            $to = $arr['email'];
            $subject = '如影随形博客网站账户激活软件-'.$arr['username'];
            //以空格来分割各个部位
            $code = base64_encode(md5('如影随形').' '.time().' '.$to);
            //点击，指向自己网站的地址，用来激活账号
            $url = "http://www.blog.com/index.php?c=Login&a=jihuo&code=$code";
            $content = <<<sd
您好！<br>
感谢您在如影随形网站注册账户！<br>
账户需要激活才能使用，赶紧激活成为如影随形正式的一员吧：)<br>
点击下面的链接立即激活账户(或将网址复制到浏览器中打开):
<a href='$url'>$url</a>
sd;
            //(4)调用postmail发送邮件
            $sendmail->postmail($to,$subject,$content,'如影随形',$arr['username']);*/

            $this->jump('注册成功！','index.php?c=Login&a=login');
        }else
        {
            //失败，跳转到注册界面
            $this->jump('注册失败！','index.php?c=Login&=register');
        }
    }

    /*//激活邮件的方法
    public function jihuo()
    {
        $code = $_GET['code'];
        //$code = base64_decode($code);
        //echo $code;
        //将激活信息分割成数组
        //$info = explode(' ',$code);
        //得到info数组，下标为1的是创建时间，下标为2的是注册的邮箱
        //根据邮箱来激活该用户，即，根据邮箱修改is_jihuo字段的值为1
        //$sql = "update user set is_jihuo = '$info[2]'";
        $user = new UserModel();
        if($user->jihuo($code))
        {
            $this->jump('恭喜，激活成功！','index.php?c=Login&a=login');
        }else
        {
            $this->jump('激活失败！','index.php?c=Login&a=register');
        }
    }*/

    //显示登录界面
    public function login()
    {
        $this->smarty->display('login.html');
    }

    //处理登录
    public function loginHandle()
    {
        $arr = $_POST;
        //验证码判断
        if(strtoupper($arr['yzm']) != strtoupper($_SESSION['yzm']))
        {
            $this->jump('验证码不正确！','index.php?c=Login&a=login');
        }
        //密码数据处理--为了和数据库进行对比
        $arr['pwd'] = md5(md5($arr['pwd'].'blog'));
        //echo $arr['pwd'];die;
        $user = new UserModel();
        $res = $user->loginCheck($arr);
        /*echo "<pre>";
        print_r($res);
        die;*/
        if($res)
        {
            $_SESSION['uname'] = $res['username'];
            $_SESSION['uid'] = $res['id'];//为了在添加评论的时候用到
            $this->jump('登录成功！','index.php');
        }else
        {
            $this->jump('登录失败！','index.php?c=Login&a=login');
        }
    }

    //退出登录
    public function logout()
    {
        //清除session
        unset($_SESSION['uname']);
        //跳转
        $this->jump('退出成功！','index.php');
    }

}