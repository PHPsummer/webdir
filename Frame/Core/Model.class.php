<?php
//基础模型类--为所有的自定义模型(它的子类)提供基本的查询方法
class Model
{
    private $pdo;//存放pdo对象

   //构造方法--完成数据库的连接(为了调用Db对象)
   public function __construct()
   {
       //得到Db对象--自动连接数据库
       $db = Db::getIns();
       //得到pdo对象--从Db.class.php而来
       //$pdo = $db->pdo
       //将此处从$db而来的pdo对象，赋值给成员属性
       $this->pdo = $db->pdo;
   }
    //查询所有行的方法
    /*public function select($sql)
    {
       //调用$pdo对象中的query()方法，得到$PDOStatement对象
       //$PDOStatement = $pdo->query($sql);
       $PDOStatement = $this->pdo->query($sql);
       //调用$PDOStatement对象中的fetchAll()方法，并返回结果集
       return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

        //预处理
        $PDOStatement = $this->pdo->prepare($sql);
        //预处理执行
        $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

   }*/

   //(0)查询所有行的方法
     public function select($sql,$params = array())
     {
        //预处理
         $PDOStatement = $this->pdo->prepare($sql);
         //绑定参数
        if($params)
        {
             foreach($params as $key=>$value)
             {
                 //注意：bindValue()中的值指向是从1开始的
                 $PDOStatement->bindValue($key,$value);
             }
        }
        //预处理执行
         $PDOStatement->execute();
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

    }

  /* //(1)查询所有行的方法
    public function select($sql,$params = array())
    {
       //预处理
        $PDOStatement = $this->pdo->prepare($sql);
        //绑定参数
       if($params)
       {
            foreach($params as $key=>$value)
            {
                $PDOStatement->bindValue($key+1,$value);
            }
       }
       //预处理执行
        $PDOStatement->execute();
       return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
   } */

   /*//(2)查询所有行的方法
    public function select($sql,$params = array())
    {
       //预处理
        $PDOStatement = $this->pdo->prepare($sql);
        //绑定参数
       if($params)
       {
            foreach($params as $key=>$value)
            {
                $PDOStatement->bindValue($key,$value);
            }
       }
       //预处理执行
        $PDOStatement->execute();
       return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
   }*/

   //查询一行数据的方法
    public function find($sql,$params = array())
    {
        //预处理
        $PDOStatement = $this->pdo->prepare($sql);
        //绑定参数
        if($params)
        {
            foreach($params as $key=>$value)
            {
                $PDOStatement->bindValue($key,$value);
            }
        }
        /*//预处理执行
        $PDOStatement->execute();
        //取出数据
        return $PDOStatement->fetch(PDO::FETCH_ASSOC);*/

        //错误信息抑制
        try
        {
            //预处理执行
            $PDOStatement->execute();
            //取出数据
            return $PDOStatement->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e)
        {
            echo $e->getMessage();//输出错误信息
            return false;
        }
    }

    //添加数据的方法
    //添加成功，返回最新的id；失败返回false
    public function add($sql,$params=array())
    {
        $PDOStatement = $this->pdo->prepare($sql);//预处理SQL语句，得到PDOStatement对象
        //判断SQL语句中是否有？或者:id参数
        if($params)
        {
            foreach($params as $key=>$value)
            {
                $PDOStatement->bindValue($key,$value);
            }
        }
        //$PDOStatement->execute();
        if($PDOStatement->execute())
        {
            return $this->pdo->lastInsertId();
        }else
        {
           return false;
        }
    }

    //查询总记录数
    //传递进来的sql格式必须是：select court(*) from table where ...;
    public function count($sql)
    {
        //执行SQL语句，得到PDOStatement对象
        $PDOStatement = $this->pdo->query($sql);
        //获取结果集中的第一行一列
        return $PDOStatement->fetchColumn();
    }

    //更新(修改)数据的方法
    /**
     * $sql = "update student set name=值,age=值 where id=xx";
     * $sql = "update student set name=:name,age=:age where id=:id";
     * $params = array(':name'=>'武大',':age'=>'男',':id'=>20);
     */
    public function save($sql,$params = array())
    {
        //echo $sql;die;
       $PDOStatement = $this->pdo->prepare($sql);
        /*echo "<pre>";
        print_r($params);
        echo "</pre>";
        die;*/
        //判断SQL中是否有占位符
        if($params)
        {
            //进行值绑定
           foreach($params as $key=>$value)
           {
               $PDOStatement->bindValue($key,$value);
           }
        }
        //echo $sql;die;
        /*if($PDOStatement->execute())
        {
            //成功返回受影响的行数
            return $PDOStatement->rowCount();
        }else
        {
            //失败返回false
            return false;
        }*/
        try
        {
            //尝试预处理执行
            $PDOStatement->execute();
            //echo $sql;die;//出现警报：SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens
            //预处理成功，返回受影响的行数
            return $PDOStatement->rowCount();
        }catch(PDOException $e)
        {
            //输出错误信息
            echo $e->getMessage();die();
            /*//或者把错误信息保存在一个文件夹中
             if(!file_exists(''))
             return false;*/
            return false;
        }
    }

    //delete用于删除语句
    /*
     * $sql = "delete from student where id=3";
     * $sql = "delete from where id=?";
     * $params = array(1=>25);
     */
    public function delete($sql,$params = array())
    {
        $PDOStatement = $this->pdo->prepare($sql);
        //判断SQL中是否有占位符
        if($params)
        {
            foreach($params as $key=>$value)
            {
                $PDOStatement->bindValue($key,$value);
            }
        }
        if($PDOStatement->execute())
        {
            //成功返回受影响的行数
            return $PDOStatement->rowCount();
        }else
        {
            //失败返回false
            return false;
        }
    }

    //添加学生信息的处理方法--一定要接收参数
    public function addSave1($sql,$params = array())
    {
        //测试
        //echo 13;die;
        //预处理，并返回$PDOStatement对象
        $PDOStatement = $this->pdo->prepare($sql);
        //判断SQL语句中是否有占位符
        if($params)
        {
            foreach($params as $key=>$value)
            {
                $PDOStatement->bindValue($key,$value);
            }
        }
        //预处理执行
        //执行成功返回受影响的行数，否则返回false
        //返回的结果传递给StudentModel.class.php中的方法addSave()
        if($PDOStatement->execute())
        {
           return $PDOStatement->rowCount();
        }else
        {
           return false;
        }
    }

    //处理分类名称的方法--注意：$params一定要分配一个默认的数组，否则会报警：为定义的参数
    public function updateHandle($sql,$params = array())
    {
        //SQL语句预处理，得到PDOStatement对象
        $PDOStatement = $this->pdo->prepare($sql);
        //判断SQL语句中是否有占位符
        if($params)
        {
            //循环指定字段的值
            foreach($params as $key=>$value)
            {
               $PDOStatement->bindValue($key,$value);
            }
        }
        /*//预处理执行,并作判断
        if($PDOStatement->execute())
        {
            //成功，返回受影响的行数
            return $PDOStatement->rowCount();
        }else
        {
            //失败，返回false
            return false;
        }*/
        //改写成错误提示的形式
        try
        {
            //尝试预处理执行
            $PDOStatement->execute();
            //预处理成功，返回最后受影响的id
            return $PDOStatement->rowCount();
        }catch(PDOException $e)
        {
            //输出错误信息
            echo $e->getMessage();die();
           /*//或者把错误信息保存在一个文件夹中
            if(!file_exists(''))
            return false;*/
           return false;
        }

    }


}
?>