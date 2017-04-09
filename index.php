<?php
/*************单一地址文件**************/
//定义项目目录--与index.php同一级，所以要加‘.’
define('APP_PATH','./App/');
//加载框架引导类Frame.class.php
require_once './Frame/Core/Frame.class.php';
//Frame::dispatch();
Frame::run();
?>