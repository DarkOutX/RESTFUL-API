<?php    
header("Charset=UTF-8");
$author=new Author();
echo $author->getByID($_GET['id']);
unset($author);
?>