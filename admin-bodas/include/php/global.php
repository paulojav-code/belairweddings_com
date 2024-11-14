<?php
    if (!isset($_COOKIE['LOGGE_IN']) || !$_COOKIE['LOGGE_IN']) {
        header('Location: '.$url.'login.php');
        exit;
    }
    if(!isset($_COOKIE['REMOTE_ADDR'], $_COOKIE['HTTP_USER_AGENT'])) {
        header('Location: '.$url.'login.php');
        exit;
    }
    if($_COOKIE['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR'] || $_COOKIE['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']){
        header('Location: '.$url.'login.php');
        exit;
    }
?>