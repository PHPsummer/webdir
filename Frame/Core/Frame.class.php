<?php
class Frame
{
    //总体的方法，依次调用要执行的方法
    public static function run()
    {
        //注意方法的调用顺序
        self::startSession();
        self::readConfig();//读取配置项
        self::getParams();//获取地址栏中的参数
        self::setConst();//定义常量
        self::autoload();//类的自动加载
        self::dispatch();//分类控制
    }

    //开启session--在项目的任何位置都可以保证session是开启状态，随时可以向session中添加内容，也可以从session中取出内容。无需再次手工开启。
    public static function startSession()
    {
        session_start();
    }

    //类的自动加载
    /**
     * 整个框架，只有下面三个目录中有类文件，所以要做这三个目录中类的自动加载
     * App/平台/Controller
     * App/平台/Model
     * Frame/Core
     * 当new一个对象时，例如：new StudentController();会自动把StudentController当成参数传递到spl_autoload_register(function ($class)中
     */
    public static function autoload()
    {
        //spl_autoload_register函数是php系统函数，参数为匿名函数
        //该匿名函数的参数为$class--要自动加载的类的名称
        spl_autoload_register(function ($class){
            $filename = './Frame/Core/'.$class.'.class.php';
            if(file_exists($filename)) require_once $filename;
            $filename = CONTROLLER_PATH.$class.'.class.php';
            if(file_exists($filename)) require_once $filename;
            $filename = MODEL_PATH.$class.'.class.php';
            if(file_exists($filename)) require_once $filename;
        });
    }

    //定义常量的方法
    public static function setConst()
    {
        //定义项目目录中App目录中，常用的MVC三层目录
        //$m = isset($_GET['m'])?$_GET['m']:$GLOBALS['conf']['DEFAULT_M'];//前后台选择
        //define('CONTROLLER_PATH',APP_PATH.$m.'/Controller/');
        define('CONTROLLER_PATH',APP_PATH.M.'/Controller/');
        //define('MODEL_PATH',APP_PATH.$m.'/Model/');
        define('MODEL_PATH',APP_PATH.M.'/Model/');
        //define('VIEW_PATH',APP_PATH.$m.'/View/');
        define('VIEW_PATH',APP_PATH.M.'/View/');
        //测试看看，能否实现动态获取
        //echo CONTROLLER_PATH;
        //定义Core目录为常量--因为该目录经常被用到
        //define('CORE_PATH','./Frame/Core/');
        //第二种定义方法
        define('FRAME_PATH','./Frame');
        define('CORE_PATH',FRAME_PATH.'/Core/');

        //外部资源目录
        define('__PUBLIC__','./Public/');
    }

    //获取地址栏的m,c,a的参数
    public static function getParams()
    {
        //获取地址栏中的参数--三元运算符
        //$m = isset($_GET['m'])?$_GET['m']:'Home';//前后台选择
        $m = isset($_GET['m'])?$_GET['m']:$GLOBALS['conf']['DEFAULT_M'];//前后台选择
        //$c = isset($_GET['c'])?$_GET['c']:'Index';//控制器选择--默认值设置为Index是为了后续的引导文件，此时访问时要在地址栏输入值
        $c = isset($_GET['c'])?$_GET['c']:$GLOBALS['conf']['DEFAULT_C'];//控制器选择--默认值设置为Index是为了后续的引导文件，此时访问时要在地址栏输入值
        //$a = isset($_GET['a'])?$_GET['a']:'index';//控制器方法选择
        $a = isset($_GET['a'])?$_GET['a']:$GLOBALS['conf']['DEFAULT_A'];//控制器方法选择
        //为了在其它方法中调用，定义为常量
        define('M',$m);
        define('C',$c);
        define('A',$a);
    }

    //读取配置文件方法--Config.php
    public static function readConfig()
    {
        //包含系统配置文件，并得到配置文件的返回值
        $config = require_once './Frame/Config/Config.php';//以入口文件index.php为准去寻找
        //包含应用的配置文件
        $myconfig = require_once APP_PATH.'Config/Config.php';
        //数组合并
        $endconfig = array_merge($config,$myconfig);
        //echo '<pre>';
        //print_r($config);
        //将获取的$config存放到全局数组GLOBALS中
        //$GLOBALS['conf'] = $config;
        $GLOBALS['conf'] = $endconfig;
    }

    //分发控制器
    //根据地址栏中的m,c,a参数，加载不同的控制器类，实例化控制器类，调用控制器类中的方法
   public static function dispatch()
   {
       //echo '<pre>';
       //print_r($GLOBALS);
       //获取地址栏中的参数--三元运算符
       //$m = isset($_GET['m'])?$_GET['m']:'Home';//前后台选择
       //$m = isset($_GET['m'])?$_GET['m']:$GLOBALS['conf']['DEFAULT_M'];//前后台选择
       //$c = isset($_GET['c'])?$_GET['c']:'Index';//控制器选择--默认值设置为Index是为了后续的引导文件，此时访问时要在地址栏输入值
       //$c = isset($_GET['c'])?$_GET['c']:$GLOBALS['conf']['DEFAULT_C'];//控制器选择--默认值设置为Index是为了后续的引导文件，此时访问时要在地址栏输入值
       //$a = isset($_GET['a'])?$_GET['a']:'index';//控制器方法选择
       //$a = isset($_GET['a'])?$_GET['a']:$GLOBALS['conf']['DEFAULT_A'];//控制器方法选择

       //(1)引入控制器类
       /*$str = './App/'.$m.'/Controller/'.$c.'Controller.class.php';
       echo $str;
       exit;*/
       //require_once './App/'.$m.'/Controller/'.$c.'Controller.class.php';
       //实行类的自动加载，此段代码不需要了
       //require_once './App/'.M.'/Controller/'.C.'Controller.class.php';
       //(2)实例化控制器类
       //$lei = $c.'Controller';//控制器的名字，类似于：StudentController
       $lei = C.'Controller';//控制器的名字，类似于：StudentController
       $obj = new $lei();
       //(3)控制器对象->方法
       $a = A;
       //$obj->$a();//$obj->text();
       $obj->$a();//$obj->text();
   }
}