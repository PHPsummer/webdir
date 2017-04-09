<?php
class CommentController extends Controller
{
    //添加评论
    public function addComment()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo $_SESSION['uid'];
        echo "<br>";
        echo time();
        die;*/
        $comment = new Model();
        $sql = "INSERT INTO comment(content,articleid,userid,ctime)
        VALUES (:content,:articleid,:userid,:ctime)";
        $res = $comment->add($sql,array(
            ':content' => $_POST['content'],
            ':articleid' => $_POST['articleid'],
            ':userid' => $_SESSION['uid'],
            ':ctime' => time(),
        ));
        if($res)
        {
            $this->jump('添加评论成功！','index.php?c=Article&articleid='.$_POST['articleid'].'&categoryid='.$_GET['categoryid'].'&type=xiao');
        }else
        {
            $this->jump('添加评论失败！','index.php?c=Article&articleid='.$_POST['articleid'].'&categoryid='.$_GET['categoryid'].'&type=xiao');
        }
    }
}