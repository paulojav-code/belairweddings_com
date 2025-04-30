<?php
    if($_SERVER['SERVER_NAME'] == 'localhost') {
        defined("URL") ? null : define("URL", "http://localhost/web/belairweddings_com");
    }else{
        defined("URL") ? null : define("URL", "https://".$_SERVER['SERVER_NAME']);
    }
    include_once($_SERVER['DOCUMENT_ROOT'] . "/web/belairweddings_com/includes/php/config.php");
?>