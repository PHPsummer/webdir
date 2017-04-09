<?php
/* Smarty version 3.1.30, created on 2017-03-08 00:06:02
  from "F:\WAMP\blog\App\Admin\View\Article\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58beda6a35aca5_58539050',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfdc28c609c23e43a4880e2c46324c55dca54c2a' => 
    array (
      0 => 'F:\\WAMP\\blog\\App\\Admin\\View\\Article\\index.html',
      1 => 1488902756,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../Public/left.html' => 1,
  ),
),false)) {
function content_58beda6a35aca5_58539050 (Smarty_Internal_Template $_smarty_tpl) {
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>
Admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>
Admin/css/main.css"/>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo __PUBLIC__;?>
Admin/js/libs/modernizr.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo __PUBLIC__;?>
Admin/js/jquery.js"><?php echo '</script'; ?>
>
    
    <?php echo '<script'; ?>
 >
        //jquery中有一个函数$,这个函数的参数是一个匿名函数
        $(function()
        {
            //当页面DOM节点加载完毕，要执行的代码
            //alert(123);
            //选中类为allChoose的节点
            $('.fanxuan').click(function () {
                //alert(123);
                $("input[type='checkbox']").prop("checked",function(i,val){
                    return !val;
                });
            });
            $('.quxiao').click(function () {
                //alert(123);
                $("input[type='checkbox']").prop("checked",function(i,val){
                    return false;
                });
            });
            $('.quanxuan').click(function () {
                //alert(123);
                $("input[type='checkbox']").prop("checked",function(i,val){
                    return true;
                });
            });

            //批量删除
            $('#batchDel').click(function () {
                $('#myform').submit();
            });
        });

        /*$(function()
        {
            //当页面DOM节点加载完毕，要执行的代码
            alert(456);
        })*/



        $(function(){
            $("#nowtime").css({color:'red'});
            window.setInterval('ShowTime()',1000);
        });
        function ShowTime(){
            var t = new Date();
            var str = t.getFullYear() + '年';
            str += t.getMonth() + '月';
            str += t.getDate() + '日 ';
            str += t.getHours() + ':';
            str += t.getMinutes() + ':';
            str += t.getSeconds() + '';
            $("#nowtime").html(str);
        }
    <?php echo '</script'; ?>
>
    
</head>
<body>


<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="?m=Admin&c=Index&a=index">首页</a></li>
                <li><a href="?m=Home&c=Index&a=index" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="?m=Admin&c=Index&a=index"><?php echo $_SESSION['adminname'];?>
</a></li>
                <li><a href="?m=Admin&c=Login&a=changePwd">修改密码</a></li>
                <li><a href="?m=Admin&c=Login&a=Logout">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    
    <!--左侧菜单栏-->

    <?php $_smarty_tpl->_subTemplateRender("file:../Public/left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


    <!--右侧主操作区-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i>
                <a href="?p=back">首页</a>
                <span class="crumb-step">&gt;</span>
                <span class="crumb-name">分类管理</span>
            </div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
                <form action="" method="post">
                    <table class="search-tab">
                        <tr>
                            <th width="70">关键字:</th>
                            <td><input class="common-text" placeholder="关键字" name="keywords" value="" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">

                <div class="result-title">
                    <div class="result-list">
                        <a href="?m=Admin&c=Article&a=add&categoryid=<?php echo $_GET['categoryid'];?>
"><i class="icon-font"></i>添加文章</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <span style="cursor:pointer" class="quanxuan">全选</span>
                        <span style="cursor:pointer" class="quxiao">取消</span>
                        <span style="cursor:pointer" class="fanxuan">反选</span>
                    </div>
                </div>
                <div class="result-content">
                    <form name="myform" id="myform" method="post" action="?m=Admin&c=Article&a=delAll">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%">
                                <!--<input class="allChoose" name="" type="checkbox">-->
                                <!--<span style="cursor:pointer" class="allChoose">全选</span>-->
                            </th>
                            <th width="5%">ID</th>
                            <th width="10%">标题</th>
                            <th width="10%">所属分类</th>
                            <th width="8%">作者</th>
                            <th width="10%">发布时间</th>
                            <th width="8%">点击数</th>
                            <th width="10%">操作</th>
                        </tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
                        <tr>
                            <td class="tc">
                                <input name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['articleid'];?>
" type="checkbox">
                            </td>
                            <td ><?php echo $_smarty_tpl->tpl_vars['value']->value['articleid'];?>
</td>
                            <td ><?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['value']->value['author'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['value']->value['ptime'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['value']->value['hits'];?>
</td>
                            <td>
                                <a class="link-update" href="?m=Admin&c=Article&a=updateArt&articleid=<?php echo $_smarty_tpl->tpl_vars['value']->value['articleid'];?>
&categoryid=<?php echo $_smarty_tpl->tpl_vars['value']->value['cid'];?>
">修改</a>
                                <!--articleid=<?php echo $_smarty_tpl->tpl_vars['value']->value['articleid'];?>
为删除传id，categoryid=<?php echo $_GET['categoryid'];?>
为删除完成之后提供地址栏的id (页面跳转都是通过地址栏来实现的)-->
                                <a class="link-del" href="?m=Admin&c=Article&a=del&articleid=<?php echo $_smarty_tpl->tpl_vars['value']->value['articleid'];?>
&categoryid=<?php echo $_smarty_tpl->tpl_vars['value']->value['cid'];?>
">删除</a>
                            </td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </table>
                        <!--隐藏域，实现跳转-->
                        <input type="hidden" name="categoryid" value="<?php echo $_GET['categoryid'];?>
">
                    </form>
                    <!--<div class="list-page"> 2 条 1/1 页</div>-->
                    <div class="list-page"><?php echo $_smarty_tpl->tpl_vars['show']->value;?>
</div>
                </div>

        </div>

    </div>
    <!--/右侧主操作区-->
</div>

</body>
</html><?php }
}
