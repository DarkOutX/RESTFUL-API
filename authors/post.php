<?php
header("Content-Type: text/html; charset=UTF-8");
$author=new Author();
$result=$author->post($_POST['name']);
unset($author);
?>