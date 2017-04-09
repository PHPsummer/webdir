<?php
/* Smarty version 3.1.30, created on 2017-03-07 23:59:26
  from "F:\WAMP\blog\App\Home\View\Public\header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58bed8deb601b9_09549734',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '992b9505d34e9ac78fefd0a5c55f100639b6d336' => 
    array (
      0 => 'F:\\WAMP\\blog\\App\\Home\\View\\Public\\header.html',
      1 => 1488902308,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58bed8deb601b9_09549734 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style>
    #topnav span
    {
        cursor:pointer;
        float:right;
        color:azure;
        padding:0 15px;//内填充
        text-align:center;
        background-color:#BC2BD8;
        margin-left:10px;
    }

</style>
<?php echo '<script'; ?>
>
    window.onload = function () {

        //注册
        document.getElementById('reg').onclick = function () {
            location.href = 'index.php?c=Login&a=register';
        }

        //登录
        document.getElementById('log').onclick = function () {
            location.href = 'index.php?c=Login&a=login';
        }
        //退出
        document.getElementById('logout').onclick = function () {
            location.href = 'index.php?c=Login&a=logout';
        }
    }
<?php echo '</script'; ?>
>
<header>
    <style><EMBED src="./01.mp3" autostart="true" loop="true" width="80" height="20">
    </style>
    <h1>如影随形</h1>
    <h2>影子是一个会撒谎的精灵，它在虚空中流浪和等待被发现之间;在存在与不存在之间....</h2>
    <div class="logo"><a href="/"></a></div>
    <nav id="topnav">
        <!--/:表示网站的根目录-->
        <a href="?m=Home&c=Index&a=index">首页</a>
        <!--<a href="index.php?c=List&a=show&categoryid=1&type=da">关于我</a>-->
        <a href="index.php?c=List&a=show">关于我</a>
        <a href="index.php?c=List&categoryid=2&type=da">慢生活</a>
        <a href="index.php?c=List&categoryid=3&type=da">学海无涯</a>
        <a href="index.php?c=List&categoryid=4&type=da">相册</a>
        <!--<span href="" id="reg">注册</span>
        <span href="" id="log">登录</span>-->

        <!--会导致js代码找不到DOM节点-->
        <!--<?php if (isset($_SESSION['uname'])) {?>
        <span id="logout">退出</span>
        <span id="uname"><?php echo $_SESSION['uname'];?>
</span>
        <?php } else { ?>
        <span href="" id="reg">注册</span>
        <span href="" id="log">登录</span>
        <?php }?>-->

        <span id="logout" <?php if (isset($_SESSION['uname'])) {?> style="display:block;" <?php } else { ?> style="display:none;" <?php }?>>退出</span>
        <span id="uname" <?php if (isset($_SESSION['uname'])) {?> style="display:block;" <?php } else { ?> style="display:none;" <?php }?>><?php echo $_SESSION['uname'];?>
</span>

        <span id="reg" <?php if (isset($_SESSION['uname'])) {?> style="display:none;" <?php } else { ?> style="display:block;" <?php }?>>注册</span>
        <span id="log" <?php if (isset($_SESSION['uname'])) {?> style="display:none;" <?php } else { ?> style="display:block;" <?php }?>>登录</span>


    </nav>
</header><?php }
}
