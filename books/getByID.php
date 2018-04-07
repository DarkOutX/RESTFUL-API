<?php    
header("Charset=UTF-8");
$book=new Book();
echo $book->getByID($_GET['id']);
unset($book);
?>