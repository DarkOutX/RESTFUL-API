<?php
header("Content-Type: text/html; charset=UTF-8");
$author=new author();
$authorinfo=json_decode(file_get_contents("php://input"));
$author->put($authorinfo->ID,$authorinfo->name);
unset($author);
?>