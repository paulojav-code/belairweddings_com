<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once('../../../include/php/const.php');
    include_once('../../../include/conexion.php');
    include_once('../../../includes/php/functions.php');

    $json = $_REQUEST;

    if(!isset($json['action'])){
        echo json_encode(['error'=>'action no definida']);
        exit();
    }
    $user = [];
    if(!isset($json['token'])){
        echo json_encode(['error'=>'02','msg'=>'login no definido','login'=>false]);
        exit();
    }
    $user = is_jwt_valid($json['token']);
    if($user == []){
        echo json_encode(['error'=>'03','error'=>'login no existente','login'=>false]);
        exit();
    }

    $type_action = [
        'files'=>function($p){return copy_images($p);}
    ];
    
    $res = isset($type_action[$json['action']]) ? $type_action[$json['action']](['con'=>$con,'user'=>$user,'json'=>$json,'file'=>$_FILES['file']]) : ['error'=>'action desconocida'];
    echo json_encode($res);

    function copy_images($d){
        if(IN_PRODUCTION){
            $url_root = 'C:/inetpub/wwwroot/itrip_mx/services/assets/img/pages/'.$d['json']['page'].'/';
        }else{
            $url_root = '../../../assets/img/pages/'.$d['json']['page'].'/';
        }
        $url = $d['file']['name'];

        if(!file_exists($url_root)){
            mkdir($url_root, 0700);
        }

        move_uploaded_file($d['file']['tmp_name'], $url_root.$url);

        if(file_exists($url_root.$url)){
            return ['file'=>$url];
        }else{
            return ['error'=>'file no copiado'];
        }
    }
?>