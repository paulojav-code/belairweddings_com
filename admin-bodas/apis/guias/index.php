<?php
    $json = json_decode(file_get_contents('php://input'),1);
    $json['id'] = explode(',',$json['id']);

    foreach($json['id'] as $j){
        $path = "../../assets/img/wp/".$j;
        $path_destino = "../../../assets/img/wp/".$j;
        foreach(scandir($path) as $file){
            if($file != '.' || $file == '..'){
                $extencion = pathinfo($file,PATHINFO_EXTENSION);
                if(strtolower($extencion)=='pdf'){
                    copy($path."/".$file,$path_destino."/".$file);
                }
            }
        }
    }
    echo json_encode($json);
?>