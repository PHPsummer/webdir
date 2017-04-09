<?php
/* Smarty version 3.1.30, created on 2017-03-07 22:10:39
  from "D:\WWW\blog\App\Admin\View\Category\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58bebf5fbee4f2_89758802',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f6495d7d682ff11023b5d1161a8a613ba29c454' => 
    array (
      0 => 'D:\\WWW\\blog\\App\\Admin\\View\\Category\\index.html',
      1 => 1488637236,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../Public/left.html' => 1,
  ),
),false)) {
function content_58bebf5fbee4f2_89758802 (Smarty_Internal_Template $_smarty_tpl) {
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
 type="text/javascript" src="../../../web/home/js/jquery1.42.min.js"><?php echo '</script'; ?>
>
    
    <?php echo '<script'; ?>
 >
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
                <li><a class="on" href="index.html">首页</a></li>
                <li><a href="#" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <!--<li><a href="http://www.jscss.me">管理员</a></li>-->
                <li><a href="?m=Admin&c=Index&a=index"><?php echo $_SESSION['adminname'];?>
</a></li>
                <li><a href="?m=Admin&c=Login&a=changePwd">修改密码</a></li>
                <li><a href="?m=Admin&c=Login&a=logout">退出</a></li>
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
                            <th width="120">选择分类:</th>
                            <td>
                                <select name="search-sort" id="">
                                    <option value="">全部</option>
                                    <option value="19">精品界面</option><option value="20">推荐界面</option>
                                </select>
                            </td>
                            <th width="70">关键字:</th>
                            <td><input class="common-text" placeholder="关键字" name="keywords" value="" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                    <div class="result-list">
                        <!--<a href="?p=back&c=Category&a=add"><i class="icon-font"></i>添加分类</a>-->
                        <a href="?m=Admin&c=Category&a=add"><i class="icon-font"></i>添加分类</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%">
                                <input class="allChoose" name="" type="checkbox">
                            </th>
                            <th>ID</th>
                            <th>标题</th>
                            <!--<th>评论</th>-->
                            <th>操作</th>
                        </tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
                        <tr>
                            <td class="tc">
                                <input name="id[]" value="1" type="checkbox">
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
</td>
                            <!--<td ><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>-->
                            <td style="padding-left:<?php echo $_smarty_tpl->tpl_vars['value']->value['lev']*15;?>
px;"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
                            <!--<td></td>-->
                            <td>
                                <!--<a class="link-update" href="?m=Admin&c=Category&a=showUpdate&parent_id=<?php echo $_smarty_tpl->tpl_vars['value']->value['parent_id'];?>
&categoryid=<?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
">修改</a>
                                <a class="link-del" href="?m=Admin&c=Category&a=del&id=<?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
">删除</a>
                                <?php if ($_smarty_tpl->tpl_vars['value']->value['parent_id'] != 0) {?>
                                <a class="link-del" href="?m=Admin&c=Article&a=index&categoryid=<?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
">文章管理</a>
                                <?php }?>-->
                                <a class="link-update" href="?m=Admin&c=Category&a=showUpdate&parent_id=<?php echo $_smarty_tpl->tpl_vars['value']->value['parent_id'];?>
&categoryid=<?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
">修改</a>
                                <a class="link-del" href="?m=Admin&c=Category&a=del&id=<?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
">删除</a>
                                <a class="link-del" href="?m=Admin&c=Article&a=index&categoryid=<?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
">文章管理</a>

                            </td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            <!--                    <tr>
                            <td class="tc">
                                <input name="id[]" value="2" type="checkbox">
                            </td>
                            <td>59</td>
                            <td >MVC框架技术</td>
                            <td>有关PHP领域的各种MVC框架技术</td>
                            <td>
                                <a class="link-update" href="#">修改</a>
                                <a class="link-del" href="#">删除</a>
                            </td>
                        </tr>
                                                <tr>
                            <td class="tc">
                                <input name="id[]" value="3" type="checkbox">
                            </td>
                            <td>59</td>
                            <td >生活感悟</td>
                            <td>随时随地记录生活的点点滴滴</td>
                            <td>
                                <a class="link-update" href="#">修改</a>
                                <a class="link-del" href="#">删除</a>
                            </td>
                        </tr>
                                                <tr>
                            <td class="tc">
                                <input name="id[]" value="4" type="checkbox">
                            </td>
                            <td>59</td>
                            <td >技术前沿</td>
                            <td>关注新技术，保持竞争力</td>
                            <td>
                                <a class="link-update" href="#">修改</a>
                                <a class="link-del" href="#">删除</a>
                            </td>
                        </tr>-->
                                            </table>
                    <div class="list-page"> 2 条 1/1 页</div>
                </div>
            </form>
        </div>

    </div>
    <!--/右侧主操作区-->
</div>

</body>
</html><?php }
}
