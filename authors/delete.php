<?php    
header("Charset=UTF-8");
$author=new author();
$authorinfo=json_decode(file_get_contents("php://input"));
$author->delete($authorinfo->ID);
unset($author);
?>