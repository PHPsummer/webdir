<?php
header("content-type:text/html;charset=utf8");
/**
 *过程：1.构造方法实现获取上传文件的信息，并将文件信息存在一个私有的成员属性中
 *     2.判断是否有系统错误，使用方法:error();并将错误提示信息的键值保存在成员属性中
 *     3.当前Update类中，写一个up测试方法，进行测试。
 *     4.文件大小的控制，声明大小，写一个checkSize()方法再进行判断
 *     5.文件后缀的控制,先获取后缀名getExt()，再另写方法进行判断checkExt()
 *     6.指定默认根目录为成员属性；生成新的文件名，设置新的文件名setName(),并在up方法中获取新文件名
 *     7.上传文件路径的设置setPath(),并在up方法中调用
 */
class Upload
{
    //上传之前应该有一定的判断(大小，后缀名。。)

    //最后是上传
    private $info = array();//用来存放上传文件的信息
    private $error = '';//用来记录错误的提示信息
    public $size = 2;//允许上传的文件大小，单位是M。写成public形式是外部可以临时调用。
    public $ext = array('jpg','gif','png');//允许上传的文件后缀
    public $rootPath = './Public/Uploads/' ;//默认存放的目录
    //(1)先获取上传文件的信息，才能进行各项判断，才能上传
    public function __construct()
    {
        //获取文件上传的信息
        /*echo "<pre>";
        print_r($_FILES['file']);//也可以转变成一维数组
        exit;*/
        /*
         * 二维数组
         * Array
         *   (
         *       [file] => Array
         *           (
         *               [name] => img3.jpg
         *               [type] => image/jpeg
         *               [tmp_name] => C:\Windows\Temp\php6078.tmp
         *               [error] => 0
         *               [size] => 15477
         *           )
         *   )
         *   一维数组
         *   Array
         *   (
         *       [name] => img3.jpg
         *       [type] => image/jpeg
         *       [tmp_name] => C:\Windows\Temp\phpA06C.tmp
         *       [error] => 0
         *       [size] => 15477
         *   )
         */
        //二维数组转一维数组，但是一维数组的名称受到文件域name的影响，要跟name的值一样，这样的话就不方便了，所以要跳过这个键
        //$this->info = $_FILES['file'] ;
        foreach($_FILES as $value)
        {
            $this->info = $value;
        }
        /*echo "<pre>";
        print_r($this->info);*/
        //echo ltrim(strrchr($this->info['name'],'.'),'.');
    }

    //(3)最终的上传方法
    public function up()
    {
        //先查看是否有错误
        if(!$this->error() || !$this->checkSize() || !$this->checkExt())
        {
           exit($this->error);
        }
        //设置上传文件路径--调用成员方法
        $this->setPath();
        //move_upload_file(临时文件路径文件名，要存放的位置文件名)
        $path = rtrim($this->rootPath,'/').'/'.date("Y-m-d");//./Public/Uploads/2017-02-26
        //获取新文件名,加上其它的后缀()
        $filename = $this->setName().'.'.$this->getExt();//1648946164.jpg
        //move_uploaded_file($this->info['tmp_name'],$path.'/'.$filename);//./Public/Uploads/2017-02-26/1648615648.jpg
        if(move_uploaded_file($this->info['tmp_name'],$path.'/'.$filename))
        {
            return $path.'/'.$filename;//./Public/Uploads/2017-02-26/1648946164.jpg
        }else
        {
            exit('上传失败！');//失败的原因是一些不可预料的，例如修改了图片的属性再进行上传，这样就不符合mime，可能会导致上传失败
        }

    }

    //(8)设置上传文件的目录
    public function setPath()
    {
        //设置子目录--为了按照上传的时间文件夹的形式进行存储
        $subPath = date("Y-m-d");//例如：2017-02-26
        //完整路径：先去掉默认的斜线再加上斜线，这样不论开始的路径后有没有斜线最后都会带上斜线
        $path = rtrim($this->rootPath,'/').'/'.$subPath;//./Public/Uploads/2017-02-26
        //判断文件路径是否存在，不存在则创建
        if(!file_exists($path))
        {
            mkdir($path,0777,true);//第三个参数为true表示可以递归创建目录
        }
    }

    //(7)生成新的文件名
    public function setName()
    {
        //当前的Unix时间戳和随机值的组合
        return time().mt_rand(000,999);
    }


    //(6)判断文件的后缀
    public function checkExt()
    {
        //调用方法，获取文件后缀
        $ext = $this->getExt();
        //判断后缀名是否在数组中
        if(!in_array(strtolower($ext),$this->ext))
        {
            //记录错误信息
            $this->error = '不允许的文件后缀';
            return false;
        }
        return true;
    }

    //(5)获取文件的后缀
    public function getExt()
    {
        //从右往左找最后一个'.'以及后面的字符串，并把左边的.去掉
        return ltrim(strrchr($this->info['name'],'.'),'.');

    }


    //(4)判断文件的大小
    public function checkSize()
    {
        if($this->info['size'] > $this->size * 1024 *1024)
        {
            $this->error = '上传文件太大';
            return false;
        }
        return true;

    }

    //(2)判断是否有系统错误
    public function error()
    {
        //将错误提示信息放到数组中，以键值对的形式
        $err = array(
            1 => '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值',
            2 => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
            3 => '文件只有部分被上传',
            4 => '没有文件被上传',
            6 => '找不到临时文件夹',
            7 => '文件写入失败',
        );
        //如果$this->info['error']是err数组的键值，那么就记录它的值
        if(array_key_exists($this->info['error'],$err))
        {
            //如果上传的文件信息中，$this->info数组中的键error对应的值为数组err中的键名，则将错误提示信息写入$error中
            $this->error = $err[$this->info['error']];
            //返回false给调用此方法的方法
            return false;
        }
        return true;
    }

}