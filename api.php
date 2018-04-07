<?php
require('classes/'.$_GET['page'].'.php');
switch (getenv("REQUEST_METHOD")) {
    case "GET":
        if (isset($_GET['id']))
            require($_GET['page'].'/getByID.php');
        elseif (isset($_GET['ISBN']))
            require($_GET['page'].'/getByISBN.php');
        elseif (isset($_GET['author_id']))
            require($_GET['page'].'/getByAuthorID.php');
        else
            require($_GET['page'].'/getAll.php');
        break;
    case "POST":
        require($_GET['page'].'/post.php');
        break;
    case "PUT":
        require($_GET['page'].'/put.php');
        break;
    case "DELETE":
        require($_GET['page'].'/delete.php');
        break;
}
?>