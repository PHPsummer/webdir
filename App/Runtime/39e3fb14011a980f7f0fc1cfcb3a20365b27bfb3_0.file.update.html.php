<?php
/* Smarty version 3.1.30, created on 2017-03-07 23:52:58
  from "F:\WAMP\blog\App\Admin\View\Article\update.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58bed75aea6117_50640443',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '39e3fb14011a980f7f0fc1cfcb3a20365b27bfb3' => 
    array (
      0 => 'F:\\WAMP\\blog\\App\\Admin\\View\\Article\\update.html',
      1 => 1488691289,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../Public/left.html' => 1,
  ),
),false)) {
function content_58bed75aea6117_50640443 (Smarty_Internal_Template $_smarty_tpl) {
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
Admin/js/jquery1.42.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo __PUBLIC__;?>
Plugins/laydate/laydate.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo __PUBLIC__;?>
Plugins/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
        window.onload = function()
        {
            //页面加载完毕要执行的代码，函数
            //document.getElementByName('ptime');//不是很好支持的方法
            var ptime = document.getElementById('ptime');//不是很好支持的方法
            //ptime.value = '2017-02-16';
            //获取今天的时间
            var d = new Date();
            var year = d.getFullYear();//获取四位数的年
            var month = d.getMonth();//获取月份，值是0-11，所以得加1
            month = month + 1;
            //对月份进行处理
            month = month < 10 ? '0' + month : month;
            //获取天
            var day = d.getDate();
            //对天进行处理
            day = day < 10 ? '0' + day : day;
            //进行字符串拼接
            var str = year + '-' + month + '-' + day;
            //赋值
            ptime.value = str;

            //处理点击量(随机：10-500)
            //Math.random();--产生0-1之间的随机小数
            var hits = (500-10)*Math.random() + 10;
            //四舍五入
            hits = Math.round(hits);
            //赋值
            document.getElementById('hits').value = hits;
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
                <span class="crumb-name">博文管理</span>
                <span class="crumb-step">&gt;</span>
                <span class="crumb-name">添加博文</span>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="?m=Admin&c=Article&a=update&articleid=<?php echo $_smarty_tpl->tpl_vars['data']->value['articleid'];?>
" method="post" id="myform" enctype="multipart/form-data">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>所属分类：</th>
                                <td>
                                   <select name="cid">
                                       <!--为博文管理作准备-->
                                       <option value="0">请选择</option>
                                       <!--为文章列表作准备-->
                                       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cate']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                                       <option <?php if ($_smarty_tpl->tpl_vars['val']->value['categoryid'] == $_GET['categoryid']) {?>selected="selected"<?php }?> style="padding-left:<?php echo $_smarty_tpl->tpl_vars['val']->value['lev']*15;?>
px" value=<?php echo $_smarty_tpl->tpl_vars['val']->value['categoryid'];?>
><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
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
                                <th><i class="require-red">*</i>标题：</th>
                                <td>
                                    <input class="common-text required" name="title" size="50" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red" >*</i>发布时间：</th>
                                <td>
                                    <!--<input onclick="laydate()" class="common-text required" name="ptime" size="50" value="" type="text" id="ptime">-->
                                    <input  class="common-text required" name="ptime" size="50" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['ptime'];?>
" type="text" id="ptime">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>作者：</th>
                                <td>
                                    <input class="common-text required" name="author" size="50" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['author'];?>
" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>图片：</th>
                                <td>
                                    <!--获取原头像，并都加上id，为了在不对原有图像修改时也能把原来的pic传递过去，不至于为空-->
                                    <img id="img" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['pic'];?>
"/>
                                    <input id="image" class="common-text required" name="file"  type="file" >
                                </td>
                            </tr>
                                <!--JS代码：为了在不对原有图像修改时也能把原来的pic传递过去，不至于为空-->
                                <!--<?php echo '<script'; ?>
>
                                    document.getElementById('image').value = document.getElementById('img').src;
                                    alert(document.getElementById('image')) ;
                                <?php echo '</script'; ?>
>-->
                            <tr>
                                <th><i class="require-red">*</i>关键字：</th>
                                <td>
                                    <input class="common-text required" name="keywords" size="50" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['keywords'];?>
" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>别名：</th>
                                <td>
                                    <input class="common-text required" name="alias" size="50" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['alias'];?>
" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>点击量：</th>
                                <td>
                                    <input class="common-text required" name="hits" size="5" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['hits'];?>
" type="text" id="hits">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>描述：</th>
                                <td>
                                    <textarea name="description" class="common" cols="100" rows="20"><?php echo $_smarty_tpl->tpl_vars['data']->value['description'];?>
</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>内容：</th>
                                <td>
                                    <textarea id="content" name="content" class="common" cols="100" rows="20"><?php echo $_smarty_tpl->tpl_vars['data']->value['content'];?>
</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input type="hidden" name="pic" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['pic'];?>
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
<!--日历-->
<?php echo '<script'; ?>
>
    ;!function(){

//laydate.skin('molv');
        //选择一种日历的皮肤
        laydate.skin('molv')
        laydate({
            //指定输入框的id
            elem: '#ptime'
        })

    }();
<?php echo '</script'; ?>
>
<!--富文本编辑器-->
<?php echo '<script'; ?>
>
    CKEDITOR.replace('content',{
        /*skin:'office2013',
        width:735*/
        //customConfig
        customConfig:'custom.js',
        extraPlugins:'codesnippet',//插件名
        //codeSnippet_theme:'Pojoaque'//插件皮肤
        codeSnippet_theme:'arta'//插件皮肤
    });
<?php echo '</script'; ?>
>
</html><?php }
}
