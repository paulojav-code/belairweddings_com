<?php
    if($_SERVER['SERVER_NAME'] == 'localhost') {
        //defined("URL") ? null : define("URL", "http://localhost/web/dreams-wedding_com_mx");
        defined("URL") ? null : define("URL", "http://localhost:3000");
    }else{
        defined("URL") ? null : define("URL", "https://".$_SERVER['SERVER_NAME']);
    }
?>