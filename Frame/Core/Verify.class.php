<?php
//验证码类
class Verify
{
    //实现验证码的方法
    //传递参数：验证码默认的宽度和高度
    public static function codeHandle($width = 200,$height = 80)
    {
       //(1)新建一张真彩色图像
       $img = imagecreate($width,$height);
       //(5)给图片添加背景颜色
       //创建一种随机颜色
       $bgcolor = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
       //填充背景颜色
       imagefill($img,0,0,$bgcolor);
       //简单的模糊处理--加入干扰线
        for($i=0;$i<10;$i++)
        {

            $linecolor = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imageline($img,mt_rand(0,200),mt_rand(0,80),mt_rand(0,200),mt_rand(0,80),$linecolor);
        }
       //写trueType类型字体(系统中的字体，需要指定一个系统文件)
        //$ttfcolor = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        //imagettftext($img,'60',mt_rand(-30,30),10,65,$ttfcolor,CORE_PATH.'hua.ttf','A');
       //循环输出4个字符串
        $baseStr = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //打乱字符串
        $shuffle = str_shuffle($baseStr);
        //截取四个字符
        $yzm = substr($shuffle,0,4);
        //将验证码写入到session中，以便使用验证码的时候进行判断
        $_SESSION['yzm'] = $yzm;
        //循环输出四个字符串
        for($i=0;$i<4;$i++)
        {
            $ttfcolor = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //imagettftext($img,'60',mt_rand(-30,30),10,65,$ttfcolor,CORE_PATH.'hua.ttf',$yzm);
            //截取循环出来的字符串，从出现的第几个开始截取，每次截取一个
            //imagettftext($img,'60',mt_rand(-30,30),10,65,$ttfcolor,CORE_PATH.'hua.ttf',substr($yzm,$i,1));
            //把每个字符串出现的位置进行分开(200的宽度，平分四份)，随着每次出现，位置增加50
            imagettftext($img,'50',mt_rand(-20,30),50*$i,65,$ttfcolor,CORE_PATH.'hua2.ttf',substr($yzm,$i,1));
        }
       //(2)设定图片类型
       //清空缓存区
       ob_clean();
       header('content-type:image/png');
       //(3)输出图像
        imagepng($img);
       //(4)销毁资源
       imagedestroy($img);

    }

    //验证验证码的方法
}