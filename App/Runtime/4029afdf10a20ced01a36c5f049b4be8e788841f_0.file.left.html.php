<?php
/* Smarty version 3.1.30, created on 2017-03-07 22:10:07
  from "D:\WWW\blog\App\Admin\View\Public\left.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58bebf3fe15955_21891363',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4029afdf10a20ced01a36c5f049b4be8e788841f' => 
    array (
      0 => 'D:\\WWW\\blog\\App\\Admin\\View\\Public\\left.html',
      1 => 1488092258,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58bebf3fe15955_21891363 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--左侧菜单栏 begin-->
<div class="sidebar-wrap">
    <div class="sidebar-title">
        <h1>菜单</h1>
    </div>
    <div class="sidebar-content">
        <ul class="sidebar-list">
            <li>
                <a href="#"><i class="icon-font">&#xe003;</i>常用操作</a>
                <ul class="sub-menu">
                    <li><a href="?m=Admin&c=Category&a=index"><i class="icon-font">&#xe008;</i>分类管理</a></li>
                    <li><a href="?m=Admin&c=Article&a=index&categoryid=0"><i class="icon-font">&#xe005;</i>博文管理</a></li>
                    <!--<li><a href="#"><i class="icon-font">&#xe006;</i>分类管理</a></li>-->
                    <li><a href="#"><i class="icon-font">&#xe012;</i>评论管理</a></li>
                    <li><a href="#"><i class="icon-font">&#xe052;</i>友情链接</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="icon-font">&#xe018;</i>系统管理</a>
                <ul class="sub-menu">
                    <li><a href="#"><i class="icon-font">&#xe017;</i>系统设置</a></li>
                    <li><a href="#"><i class="icon-font">&#xe046;</i>数据备份</a></li>
                    <li><a href="#"><i class="icon-font">&#xe045;</i>数据还原</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!--左侧菜单栏 begin--><?php }
}
