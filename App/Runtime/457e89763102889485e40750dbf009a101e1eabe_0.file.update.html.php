<?php
/* Smarty version 3.1.30, created on 2017-03-09 21:58:25
  from "F:\WAMP\blog\App\Admin\View\Category\update.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c15f81b806e0_87158850',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '457e89763102889485e40750dbf009a101e1eabe' => 
    array (
      0 => 'F:\\WAMP\\blog\\App\\Admin\\View\\Category\\update.html',
      1 => 1488902554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../Public/left.html' => 1,
  ),
),false)) {
function content_58c15f81b806e0_87158850 (Smarty_Internal_Template $_smarty_tpl) {
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
        $(function () {
            $("#nowtime").css({color: 'red'});
            window.setInterval('ShowTime()', 1000);
        });
        function ShowTime() {
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
                <li><a href="http://www.jscss.me"><?php echo $_SESSION['adminname'];?>
</a></li>
                <li><a href="http://www.jscss.me">修改密码</a></li>
                <li><a href="http://www.jscss.me">退出</a></li>
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
                <a href="?m=Admin&c=Index&a=index">首页</a>
                <span class="crumb-step">&gt;</span>
                <span class="crumb-name">分类管理</span>
                <span class="crumb-step">&gt;</span>
                <span class="crumb-name">修改分类</span>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="?m=Admin&c=Category&a=update" method="post" id="myform">
                    <table class="insert-tab" width="100%">
                        <tbody>
                        <tr>
                            <th><i class="require-red">*</i>父类名称：</th>
                            <td>
                                <select name="parent_id">
                                    <option value="0">--顶级类别--</option>
                                    <!--循环输出-->
                                    <!--<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value['categoryid'];?>
" style="padding-left:<?php echo $_smarty_tpl->tpl_vars['value']->value['lev']*15;?>
px">
                                            <?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>

                                        </option>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
-->

                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cate']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                                    <option <?php if ($_smarty_tpl->tpl_vars['val']->value['categoryid'] == $_GET['parent_id']) {?>selected="selected"<?php }?> style="padding-left:<?php echo $_smarty_tpl->tpl_vars['val']->value['lev']*15;?>
px" value=<?php echo $_smarty_tpl->tpl_vars['val']->value['categoryid'];?>
>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>

                                    </option>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>分类名称：</th>
                            <td>
                                <input class="common-text required" id="title" name="category_name" size="50"
                                       value="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" type="text">
                            </td>
                        </tr>

                        <tr>
                            <th></th>

                            <td>
                                <!--利用隐藏域，实现categoryid的传递-->
                                <input type="hidden" name="categoryid" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['categoryid'];?>
">
                                <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>

    </div>
    <!--/右侧主操作区-->
</div>

</body>
</html><?php }
}
