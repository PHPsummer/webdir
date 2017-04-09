<?php

/***********这个基础视图类的作用是：将Smarty引入到项目中***********/
class View
{
    //protected $smarty;//用来保存samrty对象--当作父类被继承时
    public $smarty;//用来保存samrty对象--被基础控制器类继承
    //将引入Smarty的工作放到构造方法中，那么实例化View对象的时候，就能获得Smarty
    public function __construct()
    {
        require_once FRAME_PATH.'/Smarty/Smarty.class.php';
        //得到Smart对象
        //$smarty = new Smarty();
        //return $smarty;
        $this->smarty = new Smarty();
        //配置模板目录--setTemplateDir()是一个成员方法
        $this->smarty->setTemplateDir(VIEW_PATH.C);
        //设置编译文件目录
        $this->smarty->setCompileDir(APP_PATH.'Runtime');
    }
}