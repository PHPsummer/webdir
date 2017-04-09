<?php
header("content-type:text/html;charset=utf-8");
class ArticleModel extends Model
{
    //从article表中取出按照点击量排序的五篇文章
    //一般在实际的开发项目中，方法的名字应该有意义
    public function getFiveArtsByHits()
    {
        //$sql = "SELECT * FROM article ORDER BY articleid DESC limit 5";
        //取出文章分类，实行连表查询，通过cid
        $sql = "SELECT a.articleid,a.title,a.description,a.pic,a.ptime,a.hits,a.author,
        c.categoryid,c.name FROM article a JOIN category c 
        ON a.cid = c.categoryid ORDER BY articleid DESC limit 5";
        return $this->select($sql);
    }

    //根据文章的articleid，获取文章的详细信息
    public function getArtByArticleid($articleid)
    {
        //$sql = "SELECT * FROM article WHERE articleid = $articleid";
        $sql = "SELECT a.articleid,a.title,a.content,a.ptime,a.hits,a.keywords,
        c.categoryid,c.name FROM article a JOIN category c 
        ON a.cid = c.categoryid WHERE articleid = $articleid";
        $row['content'] = $this->find($sql);
         //上一篇、下一篇
        //下一篇
        $sql = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid 
WHERE a.articleid < $articleid ORDER BY a.articleid DESC LIMIT 1";
        $row['first'] = $this->select($sql);
        //上一篇
        $sql = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid 
WHERE a.articleid > $articleid ORDER BY a.articleid ASC LIMIT 1";
        $row['next'] = $this->select($sql);
        //数组合并
        $row['page'] = array_merge($row['first'],$row['next']);
        return $row;//查询一条数据
    }

    //根据分类id,取出分类中的文章
    public function getArtsByCategoryId($categoryid,$type)
    {
        //根据$type，写不同的SQL语句
        if($type == 'da')
        {
            $sql_count = "SELECT count(*) FROM article WHERE cid IN(SELECT categoryid FROM category WHERE parent_id=$categoryid) ";
            $count = $this->count($sql_count);
            $config = array(
                'first' => '<<',
                'prev' => '<',
                'next' => '>',
                'last' => '>>',
                'current_tag' => 'b',
                'theme' => array('first','prev','num','next','last'),
            );
            $page = new Page($count,10,$config);
            //$sql = "SELECT * FROM article WHERE cid IN(SELECT categoryid FROM category WHERE parent_id=$categoryid)";
            //取出列表显示、点击排行的标题
            $sql = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid WHERE a.cid IN(SELECT categoryid FROM category
            WHERE parent_id=$categoryid) ORDER BY hits DESC limit $page->start,$page->length";
            //取出栏目推荐的标题
            $sql4 = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid WHERE a.cid IN(SELECT categoryid FROM category 
             WHERE parent_id=$categoryid) ORDER BY a.articleid DESC limit $page->start,$page->length";
            //echo $sql;die;

            //取出大分类下的小分类的名称
            $sql3 = "SELECT * FROM category WHERE parent_id = $categoryid";
            $res = $this->select($sql3);
            //模板右侧导航显示
            $arr['name3'] = $res;

            //分页样式
            $show = $page->show();
        }else
        {
            $sql_count = "SELECT count(*) FROM article WHERE cid=$categoryid";
            $count = $this->count($sql_count);
            $config = array(
                'first' => '<<',
                'prev' => '<',
                'next' => '>',
                'last' => '>>',
                'current_tag' => 'b',
                'theme' => array('first','prev','num','next','last'),
            );
            $page = new Page($count,10,$config);
            //$sql = "SELECT * FROM article WHERE cid=$categoryid";
            //取出列表显示、点击排行的标题
            $sql = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid WHERE cid=$categoryid ORDER BY hits DESC limit $page->start,$page->length";
            //取出栏目推荐的标题
            $sql4 = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid WHERE cid=$categoryid ORDER BY a.articleid DESC limit $page->start,$page->length";
            //echo $sql;die;

            //取出同类别分类的名称
            $sql3 = "SELECT * FROM category WHERE parent_id = (select parent_id from category where categoryid = $categoryid)";
            $res = $this->select($sql3);

            //分页样式
            $show = $page->show();
        }
        //调用基础模型类中的方法，获取返回值
        //得到所选分类的名称
        $sql1 = "SELECT * FROM category WHERE categoryid = $categoryid";//子类名称
        $sql2 = "SELECT * FROM category WHERE categoryid = (select parent_id from category where categoryid = $categoryid)";//父类名称
        //关于评论
        $sql5 = "SELECT * FROM comment c JOIN user u ON c.userid = u.id ORDER BY c.ctime DESC";
        $arr['comment'] = $this->select($sql5);

        $arr['name1'] = $this->select($sql1);
        $arr['name2'] = $this->select($sql2);
        //进行数组合并
        $arr['name'] = array_merge($arr['name2'],$arr['name1']);
        //右侧导航栏显示
        $arr['name3'] = $res;
        //右侧"栏目推荐"标题显示
        $arr['title'] = $this->select($sql4);
        $arr['data'] = $this->select($sql);
        //将所选类的名称进行数组拼接
        //$arr['data'] = array_merge($category_name,$arr['data']);
       /* echo "<pre>";
        print_r($arr['data']);die;*/

        $arr['show'] = $show;
        return $arr;

    }

    //取出“位置信息”的方法
    public function getAddress($articleid)
    {
        $sql = "SELECT cid FROM article WHERE articleid = $articleid";
        $res = $this->select($sql);//得到是一个二维数组
        //将二维数组变成一维数组
        foreach($res as $key=>$val)
        {
            $cid[] = $key;
        }
        //print_r($val);die;
        //将一维数组数组拆分为字符串
        $cid = implode('',$val);//得到的是article表的cid
        //echo $cid;die;
        //到category表中查parent_id
        $sql = "SELECT parent_id FROM category WHERE categoryid = $cid";
        $res = $this->select($sql);
        /*echo "<pre>";
        print_r($res);die;*/
        //再次进行一维数组转化
        foreach($res as $k=>$v)
        {
            $parent_id[] = $k;
        }
        //print_r($v);die;
        //将一维数组数组拆分为字符串
        $parent_id = implode('',$v);//得到的是category表的父类的parent_id
        //echo $parent_id;die;
        //再次构建SQL语句，查询文章所属的分类
        $sql = "SELECT * FROM category WHERE categoryid IN ($cid,$parent_id)";
        //echo $sql;die;
        $res = $this->select($sql);
        /*echo "<pre>";
        print_r($res);die;*/
        //return $val;
        return $res;
    }

    //首页“最新文章”、“推荐文章”显示的方法
    public function getEightArts()
    {
        //取出文章分类，实行连表查询，通过cid
        //最新文章--根据添加的时间
        $sql = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid ORDER BY articleid DESC limit 8";
        $arr['title1'] =  $this->select($sql);
        /*echo "<pre>";
        print_r($arr);
        die;*/
        //推荐文章--根据点击量
        $sql = "SELECT * FROM article a JOIN category c ON a.cid = c.categoryid ORDER BY hits DESC limit 8";
        $arr['title2'] = $this->select($sql);
        /*echo "<pre>";
        print_r($arr);
        die;*/
        return $arr;
    }

}
?>