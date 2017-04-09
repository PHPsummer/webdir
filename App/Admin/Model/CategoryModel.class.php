<?php
class CategoryModel extends Model
{
    //获取所有的分类
    public function getAllCates()
    {
        $sql = "SELECT * FROM category ORDER BY categoryid ";
        //echo $sql;die;
        return $this->select($sql);
    }

    //对取出的分类进行递归排序
    //$data--未分类前数据；$parent_id--父级id，当为0时表示顶级id；$lev--类的级别--为了在后续的模板样式中使用，使之更加清晰的显示出来
    public function sortCate($data,$parent_id = 0,$lev = 0)
    {
        //(1)定义数组
        //$arr = array();
        //定义成静态的属性，不会被覆盖
        static $arr = array();//静态变量，可以保存住变量的值
        foreach($data as $key=>$value)
        {
            //(0)先找顶级类
            //if($value['parent_id'] == 0)
            if($value['parent_id'] == $parent_id )
            {
                //(2)先将当前的小数组(例如：中国)存放到arr中
                $value['lev'] = $lev;//将value放入arr之前，向value中添加一条数据
                $arr[] = $value;
                //(3)递归--函数的自调用
                $this->sortCate($data,$value['categoryid'],$lev+1);
            }
        }
        //返回给控制器的数组
        return $arr;
    }

    //添加分类的方法
    public function insert()
    {
        $sql = "INSERT INTO category(name,parent_id) values(:category_name,:parent_id)";
        //echo $sql;die;

        $params = array();
        foreach($_POST as $key=>$value)
        {
            $params[':'.$key] = $value;
        }
        //结果返回给控制器
        return $this->add($sql,$params);
    }

    /*//删除分类的处理方法--仅仅是删除了所点的那一项，该项下其它分类没有被删除
    public function del()
    {
        //获取地址栏的id
        $id = $_GET['id'];
        //echo $id;die;
        //构建SQL语句
        $sql = "DELETE FROM category WHERE categoryid = $id";
        //echo $sql;die;
        //调用基础模型类中的方法去处理，并传递参数
        $this->delete($sql);
    }*/
    //删除分类的处理方法--递归删除
    /*public function del($arr)
    {
            $sql = "DELETE FROM category WHERE categoryid = $arr[categoryid] OR parent_id = $arr[categoryid]";
            return $this->delete($sql);

    }*/

    //获取要删除的分类的所有id
    public function getIds()
    {
        //获取地址栏的id
        $categoryid = $_GET['id'];
        //echo $categoryid;die;
        //由parent_id=$categoryid得到categoryid;
        $sql = "SELECT categoryid FROM category WHERE parent_id = '$categoryid' order by categoryid";
        //调用基础模型类中的方法，执行SQL语句
        $res = $this->select($sql);
        /*echo "<pre>";
        print_r($res);//得到的是一个二维数组
        echo "</pre>";die;*/
        //将结果返回到控制器
        return $res;
    }

    //查找所有要删除分类categoryid的方法
    public function delCate($id)
    {
        /*echo "<pre>";
        print_r($id);die;//此时要删除的分类中不包括所选择的分类*/

        //定义静态的保存所需删除的id的数组变量
        static $categoryid = array();

        //循环所有需要的id
        foreach($id as $key=>$value)
        {
            //将传递进来的二维数组变成一维数组
            $categoryid[] = $value['categoryid'];
           /* echo "<pre>";
            print_r($categoryid);die;*/

            //再将数组中的categoryid的值作为parent_id的值，进行查找，得到categoryid
            $sql = "SELECT categoryid FROM category WHERE parent_id = '$value[categoryid]'";
            //查询所有行
            $id1 = $this->select($sql);
            //print_r($id1);die;
            //函数自调用
            $this->delCate($id1);
        }
        //得到最新的数组，并返回给控制器
        /*echo "<pre>";
        print_r($categoryid);//得到的是一个二维数组
        echo "</pre>";
        die;*/
        return $categoryid;
    }

    //删除分类，以及分类下的所有文章
    public function delHandle($res)
    {
        //将一维数组转换成字符串
        $str = implode($res,',');
        //echo $str;die;
        //注意:连表删除是错误的写法，不存在
        //例如:$sql = "DELETE FROM category c INNER JOIN article a ON a.cid = c.categoryid WHERE c.categoryid IN(34,28)";
        //根据所要删除的分类categoryid，到article表中，对相应的文章内容进行删除
        $sql = "DELETE FROM article WHERE cid IN($str)";
        $this->delete($sql);
        //删除所有的分类
        $sql1 = "DELETE FROM category WHERE categoryid IN($str)";
        //echo $sql;die;
        return $this->delete($sql1);
    }

    //获取要修改的类别的数据
    public function showUpdate()
    {
        //获取地址栏的id
        //$parent_id = $_GET['parent_id'];
        $categoryid = $_GET['categoryid'];

        /*echo $categoryid."<br>";
        echo $parent_id;
        die;*/

        $sql = "SELECT * FROM category WHERE categoryid = $categoryid";
        //echo $sql;die;

        //判断
        /*if($parent_id == 0)
        {
            $sql = "SELECT * FROM category WHERE categoryid = $categoryid";
        }else
        {
            $sql = "SELECT * FROM category WHERE categoryid = $parent_id";
        }*/

        //调用基础模型类中的方法，执行SQL语句--得到返回值
        //打印返回值看看
        /*echo "<pre>";
        print_r($this->select($sql));
        echo "</pre>";
        exit();*/
        return $this->find($sql);
    }

    //处理修改类别的方法
    public function update()
    {
        //获取表单传递过来的categoryid和parent_id
        $categoryid = $_POST['categoryid'];
        $parent_id = $_POST['parent_id'];
        //获取表单传递过来的类别名称
        $name = $_POST['category_name'];
        //构建SQL语句
        $sql = "UPDATE category SET name = '$name',parent_id = $parent_id WHERE categoryid = $categoryid";
        //echo $sql;die;
        //调用基础模型类中的方法，执行SQL语句,得到返回值
        return $this->updateHandle($sql);
    }



}
