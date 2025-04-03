<?php
    $ip_data = file_get_contents("https://api.ipquery.io/");
    echo $ip_data;   

    $data = file_get_contents("https://api.ipquery.io/".$ip_data);
    echo "<br>".$data
?>