<?php
    include_once("../includes/php/conexion.php");
    include_once("./functions.php");

    $sql="SELECT * from novies";
    $ruta="../wp";

    $res = query($con,$sql);
    // echo json_encode($res);


    // echo json_encode(scandir($ruta));

    foreach (scandir($ruta) as $s) {
        foreach ($res as  $r) {
            # code...
        }
    }

?>