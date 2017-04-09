<?php
class ArticleModel extends Model
{
    //查询文章
    public function getArticles($where)
    {
        //计算总的记录数
        $sql_count = "SELECT count(*) FROM article $where";
        $count = $this->count($sql_count);
        //配置皮肤
        $config = array(
            'theme' => array('prev','num','next'),
        );
        //配置首页的显示
        /*$config = array(
            'first' => '<<',
        );*/
        $page = new Page($count,5,$config);
        $show =$page->show($config);//通过分页类获取的分页样式

        //构建SQL--记得加空格
        //$sql = "SELECT * FROM article ".$where.' ORDER BY articleid DESC';
        //显示所属分类的SQL语句
        //$sql = "SELECT * FROM article JOIN category ON article.cid = category.categoryid ".$where.' ORDER BY articleid DESC';
        //优化SQL语句，只查询所需字段--养成良好的习惯--查询效率更高
        $sql = "SELECT a.articleid,a.title,c.name,a.author,a.ptime,a.hits,a.cid 
        FROM article a JOIN category c ON a.cid = c.categoryid "
            .$where." ORDER BY articleid DESC limit $page->start,$page->length";
        //调用基础模型类的方法，并将查询的结果返回到控制器
        $data = $this->select($sql);
        //将数据分配分配到数组中
        $arr['show'] = $show;
        $arr['data'] = $data;
        return $arr;
    }

    //添加文章
    public function insert($arr)
    {
        //构建SQL语句
        $sql = "INSERT INTO article(title,content,ptime,ctime,author,keywords,hits,description,alias,cid,pic) 
 values(:title,:content,:ptime,:ctime,:author,:keywords,:hits,:description,:alias,:cid,:pic)";
        //占位符绑定
        $params = array();
        foreach($arr as $key=>$val)
        {
            $params[':'.$key] = $val;
        }
        //得到返回值并返回给控制器
        return $this->add($sql,$params);
    }

    //删除的方法
    public function delArt($articleid)
    {
        $sql = "DELETE FROM article WHERE articleid = $articleid";
        return $this->delete($sql);
    }

    //批量删除的方法
    public function delAll($idstr)
    {
        $sql = "DELETE FROM article WHERE articleid in($idstr)";
        //echo $sql;die;
        return $this->delete($sql);
    }

    //获取要修改的文章的数据--在./App/View/Article/index.html的“修改”连接处添加：articleid={$value.articleid}，根据articleid提取出数据再显示出来
    public function showArt()
    {
        //获取地址栏的articleid
        $articleid = $_GET['articleid'];
        //构建SQL语句
        $sql = "SELECT * FROM article WHERE articleid = $articleid";
        //$sql = "SELECT *  FROM article a JOIN category c ON a.cid = c.categoryid WHERE articleid = $articleid";
        //调用基础模型类中的方法--查询一条数据即可
        $result = $this->find($sql);
        /*echo "<pre>";
        print_r($result);
        echo "</pre>";*/
        //die;
        //将结果返回到控制器
        return $result;
    }
    //处理文章内容修改的方法
    public function updateHdle($arr)
    {
        //获取表单传递过来的数据
        //$data = $_POST;
        $data = $arr;
       /* echo "<pre>";
        print_r($data);
        echo "</pre>",die;*/
        //echo $data['pic'];die;

        //构建SQL语句
        $id=$_GET['articleid'];
        $sql = "UPDATE article SET  title=:title,content=:content,ptime=:ptime,ctime=:ctime,utime=:utime,author=:author,keywords=:keywords,
hits=:hits,description=:description,alias=:alias,cid=:cid,pic=:pic WHERE articleid = $id";
        //占位符绑定
        $params = array();
        foreach($data as $key=>$val)
        {
            $params[':'.$key] = $val;
        }
        /*echo "<pre>";
        print_r($params);
        echo "</pre>";
        die;*/

        //构建SQL语句
        //$sql = "UPDATE article SET title='$data[title]',content='$data[content]',author='$data[author]',keywords='$data[keywords]',description='$data[description]' WHERE articleid = $data[articleid]";

        //echo $sql;die;
        //得到返回值并返回给控制器
        return $this->save($sql,$params);
    }


}