<?php
//获取表单的内容
$title = $_POST['title'];
$content = $_POST['content'];
$to = $_POST['to'];

include 'sendmail.class.php';

$mail = new sendmail();
$mail->postmail($to, $title, $content);