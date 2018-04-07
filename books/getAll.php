<?php    
header("Charset=UTF-8");
$book=new Book();
echo $book->getAll();
unset($book);
?>