<?php    
header("Charset=UTF-8");
$book=new Book();
echo $book->getByISBN($_GET['ISBN']);
unset($book);
?>