<?php    
header("Charset=UTF-8");
$book=new Book();
echo $book->getByAuthorID($_GET['author_id']);
unset($book);
?>