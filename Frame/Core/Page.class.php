<?php
//分页类
class Page
{
    public $nowPage =  1;//当前页
    public $start = 0;//用于查询的SQL语句中，limit开始的位置
    public $length = 5;//用于查询的SQL语句中，limit截取的长度
    public $count;//表示总记录数
    public $config = array(
      'first' => '首页',
      'prev' => '上一页',
      'next' => '下一页',
      'last' => '尾页',
      'current_tag' => 'a',//当前页的标签
      //'theme' => 'first prev link next last jump',//默认皮肤
      'theme' => array('first','prev','num','next','last','jump') //默认皮肤
    );

    //构造方法--处理分页类中所需要的变量--谁需要用的话就传递相应的参数
    public function __construct($count,$length = 5,$config = array())
    {
       /* echo "<pre>";
        print_r($config);
        echo "</pre>";
        die;*/
        //当前的页码，即当前为第几页--p为分页的参数
        $this->nowPage = isset($_GET['p']) ? $_GET['p'] : 1;//升级为成员属性
        $this->length = $length;//先获取length,然后在计算start
        //起始位置
        $this->start = ($this->nowPage - 1) * $this->length;
        //升级为成员属性
        $this->count = $count;
        //数组合并，修改配置信息
        $this->config = array_merge($this->config,$config);
    }

    //显示分页样式的方法
    public function show()
    {
        //return "上一页 下一页";

        //从需求入手
        $str = '';//用来保存分页样式

        //获取地址栏已有参数，处理成一个字符串
        //$ppp = $_GET;//这是一个一维数组
        /*echo "<pre>";
        print_r($ppp);
        echo "</pre>";*/
        //判断该数组中是否有p参数--判断p是否为某一个数组的键值
        //获取地址栏已有参数，处理成一个字符串
        //判断p是否是$_GET的键值
        if(array_key_exists('p',$_GET))
        {
            unset($_GET['p']);
        }
        //循环进行键值拼接
        $params = '';
        //连接跳转表单
        $formstr = '';
        foreach($_GET as $k=>$v)
        {
            $params .= "$k=$v&";
            $formstr .= "<input type='hidden' name='$k' value='$v'/>";
        }
        //echo $params;


        //首页，上一页
        //$str .= "<a>上一页</a>";
        if($this->nowPage > 1)
        {
//            $str .= "<a href='index.php?{$params}p=1'>首页</a>";
            //$str .= "<a href='index.php?{$params}p=1'>{$this->config['first']}</a>";
            $first = "<a href='index.php?{$params}p=1'>{$this->config['first']}</a>";
            //$str .= "<a href='index.php?{$params}p=".($this->nowPage -1)."'>{$this->config['prev']}</a>";
            $prev = "<a href='index.php?{$params}p=".($this->nowPage -1)."'>{$this->config['prev']}</a>";
        }else
        {
            $first = '';
            $prev = '';
        }


        //做1，2，3，4，5.。。
        /**
         * 当前页 所要显示的页的个数
         *   1   1 2 3 4 5
         *   2   1 2 3 4 5
         *
         *   3   1 2 3 4 5
         *   4   2 3 4 5 6
         *   5   3 4 5 6 7
         *   6   4 5 6 7 8
         *
         *  ...
         *   11  9 10 11 12 13
         *
         *   12  10 11 12 13 14
         *   13  11 12 14 15 16
         *
         *
         */
        $maxPage = ceil($this->count/$this->length);//向上取整
        //$link = 5;//表示在上一页和下一页之间显示几个小标签
        $link = $GLOBALS['conf']['PAGE_LINK'];//表示在上一页和下一页之间显示几个小标签
        //最大页(总页码)小于所要显示的分页数
        if($maxPage < $link)
        {
            $s = 1;
            $link = $maxPage;
        }
        //起始位置和当前页之间的关系
        $s = $this->nowPage - floor($link/2);//默认的循环起始位置
        //判断特殊的起始位置
        if($this->nowPage <= ceil($link/2))
        {
            $s = 1;
        }
        //如果页码过大，再判断
        if($this->nowPage > $maxPage - floor($link/2))
        {
            $s = $maxPage - $link+1;
        }
        $num = '';
        for($i=$s;$i<$s+$link;$i++)
        {
            //当前页
            if($i == $this->nowPage)
            {
                //当前页不挂链接
                $num .= "<{$this->config['current_tag']}>$i</{$this->config['current_tag']}>";
                //$str .= "<a href='index.php?{$params}p=$i'>$i</a>";
            }else
                $num .= "<a href='index.php?{$params}p=$i'>$i</a>";
            {

            }
        }

        //下一页
        //最大页 = ceil(总记录数/每页显示条数);
        //$maxPage = ceil($this->count/$this->length);
        if($this->nowPage < $maxPage)
        {
            $next = "<a href='index.php?{$params}p=".($this->nowPage +1)."'>{$this->config['next']}</a>";
            //尾页
            $last = "<a href='index.php?{$params}p={$maxPage}'>{$this->config['last']}</a>";
        }else
        {
            $next = '';
            $last = '';
        }

        //跳转页
        //$str .= "<form><input type='text' name='p'/></form>";
        //采用定界符处理
        $jump = <<<ads
<form>
    $formstr
    <input type='text' name='p' size='2'/>
    <input type='submit' value='GO'/>
</form>
ads;
        //设定需要的皮肤连接
        foreach($this->config['theme'] as $val)
        {
            //$val = 'first';
            //$$valu = $first;
            $str .= $$val;
        }

        return $str;
    }

}