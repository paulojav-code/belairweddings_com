<?php
    if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '172.17.1.77') {
        defined("URL") ? null : define("URL", "http://".$_SERVER['SERVER_NAME']."/web/belairweddings_com/admin-bodas");
        //defined("URL") ? null : define("URL", "http://localhost:3000/admin-bodas");
    }else{
        defined("URL") ? null : define("URL", "https://".$_SERVER['SERVER_NAME']."/admin-bodas");
    }
?>