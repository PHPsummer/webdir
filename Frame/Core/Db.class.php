<?php
//单利模式：三私一公
//MVC设计模式、MVC架构思想、MVC架构模式
class Db
{
    //私有的静态的保存Db对象的属性
    private static $ins;
    //存放pdo对象
    public $pdo = null;

    //私有的构造方法
    private function __construct()
    {
        //调用connect()方法，保证得到Db对象的时候，就能连接上数据库
        $this->connect();
    }

    //私有的克隆方法
    private function __clone(){}

    //公共的静态的获取对象的方法
    public static function getIns()
    {
        if(self::$ins === null)
        {
            self::$ins = new Db();
        }
        return self::$ins;
    }

    //连接数据库
    private function connect()
    {
        //设置异常模式--PDO处理错误的方式为异常模式
        try
        {
            //$dsn = "mysql:host=localhost;dbname=zhongteng;charset=utf-8";
            $dsn = "{$GLOBALS['conf']['DB_TYPE']}:host={$GLOBALS['conf']['DB_HOST']};dbname={$GLOBALS['conf']['DB_NAME']};charset={$GLOBALS['conf']['DB_CHARSET']}";
            //$pdo = new PDO($dsn,'root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            //通过new PDO()，将产生的$pdo对象赋值给成员属性$pdo--为了在Model.class.php中使用
            //$this->pdo = new PDO($dsn,'root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $this->pdo = new PDO($dsn,$GLOBALS['conf']['DB_USER'],$GLOBALS['conf']['DB_PWD'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        }catch(PDOException $e)
        {
            exit($e->getMessage());
        }

    }
}
