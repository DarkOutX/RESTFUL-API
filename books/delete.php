<?php    
header("Charset=UTF-8");
$book=new Book();
$bookinfo=json_decode(file_get_contents("php://input"));
$book->delete($bookinfo->ID);
unset($book);
?>