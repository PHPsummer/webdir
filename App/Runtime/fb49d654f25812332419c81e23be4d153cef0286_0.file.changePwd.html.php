<?php
/* Smarty version 3.1.30, created on 2017-03-07 22:10:10
  from "D:\WWW\blog\App\Admin\View\Login\changePwd.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58bebf425a30d7_06547281',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fb49d654f25812332419c81e23be4d153cef0286' => 
    array (
      0 => 'D:\\WWW\\blog\\App\\Admin\\View\\Login\\changePwd.html',
      1 => 1488029203,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58bebf425a30d7_06547281 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改密码</title>
</head>
<body>
<h2 align="center">修改管理员密码</h2>
<p align="center">管理员：<font color="red"><?php echo $_SESSION['adminname'];?>
</font></p>
<form action="?m=Admin&c=Login&a=pwd" method="post">
    <table border="1" align="center" cellpadding="2" cellspacing="0" width="500" rules="all">
        <tr>
            <td>请输入原密码：</td>
            <td>
                <input type="password" name="old_pwd">
            </td>
        </tr>
        <tr>
            <td>请输入新密码：</td>
            <td>
                <input type="password" name="new_pwd">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit"  value="修改">
            </td>
        </tr>
    </table>
</form>
</body>
</html><?php }
}
