<?php
header("Content-Type: text/html; charset=UTF-8");
$book=new Book();
$result=$book->post($_POST['author_id'],$_POST['title'],$_POST['ISBN']);
unset($book);
?>