<?php
header("Content-Type: text/html; charset=UTF-8");
$book=new Book();
$bookinfo=json_decode(file_get_contents("php://input"));
$book->put($bookinfo->ID,$bookinfo->author_id,$bookinfo->title,$bookinfo->ISBN);
unset($book);
?>