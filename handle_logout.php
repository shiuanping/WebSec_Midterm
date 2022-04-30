<?php
    session_start();
    if(!strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])){
        die('請求無效');
    }
    session_destroy();
    header("Location:index.php");
?>