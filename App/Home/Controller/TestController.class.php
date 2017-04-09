<?php
class TestController extends Controller
{
    //前台测试类，分别指向前台的各个模板，进行测试
    public function test()
    {
        $this->smarty->display('index.html');
    }


}