<?php    
header("Charset=UTF-8");
$author=new author();
echo $author->getAll();
unset($author);
?>