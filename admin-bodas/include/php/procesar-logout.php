<?php
    setcookie('LOGGE_IN', false, time()-72000, '/', $_SERVER['SERVER_NAME']);
    setcookie('USERNAME', '', time()-72000, '/', $_SERVER['SERVER_NAME']);
    setcookie('ID_ACCOUNT', '', time()-72000, '/', $_SERVER['SERVER_NAME']);
    setcookie('PERMISSIONS', '', time()-72000, '/', $_SERVER['SERVER_NAME']);
    setcookie('ID_TYPE_ACCOUNT', '', time()-72000, '/', $_SERVER['SERVER_NAME']);
    setcookie('REMOTE_ADDR', '', time()-72000, '/', $_SERVER['SERVER_NAME']);
    setcookie('HTTP_USER_AGENT', '', time()-72000, '/', $_SERVER['SERVER_NAME']);
    
    header('Location: ../../login.php');
?>