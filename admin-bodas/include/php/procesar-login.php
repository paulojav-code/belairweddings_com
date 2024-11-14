<?php
    include_once('../config.php');
    include_once('../conexion.php');

    if(isset($_POST['request']) || isset($_GET['request'])){
        if(isset($_POST['request'])) {
            $_POST['request'] = urldecode($_POST['request']);
            $array_resquest = json_decode($_POST['request'], true);
        }else if(isset($_GET['request'])) {
            $_GET['request'] = urldecode($_GET['request']);
            $array_resquest = json_decode($_GET['request'], true);
        }
    }else{
        echo '{"error": "Parametros faltantes"}';
        exit;
    }

    $array_data = array();
    $array_response = array();
    $array_response['login'] = false;
    $sql = '';

    if(isset($array_resquest['usuario']) && $array_resquest['usuario'] != '' && 
        isset($array_resquest['contrasena']) && $array_resquest['contrasena'] != ''){
        $sql = 'SELECT t0.id_usuario, t0.usuario, t0.contrasena, t0.id_tipo_usuario, t0.permisos, t1.permisos AS permisos_tipo 
                FROM admin_bodas.usuarios AS t0
                INNER JOIN admin_bodas.tipos_usuarios AS t1 ON t0.id_tipo_usuario = t1.id_tipo_usuario
                WHERE t0.activo = 1 AND t0.usuario = ?';
        $stmt = $con -> prepare($sql);
        $stmt -> bind_param("s", $array_resquest['usuario']);
        $stmt -> execute();
        $result = $stmt->get_result();
        while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
            $array_data[] = $req;
        }
        $stmt->close();
        if(count($array_data) > 0){
            if(password_verify($array_resquest['contrasena'],$array_data[0]['contrasena'])){
                setcookie('LOGGE_IN', TRUE, time()+43200, '/', $_SERVER['SERVER_NAME']);
                setcookie('USERNAME', $array_data[0]['usuario'], time()+43200, '/', $_SERVER['SERVER_NAME']);
                setcookie('ID_ACCOUNT', $array_data[0]['id_usuario'], time()+43200, '/', $_SERVER['SERVER_NAME']);
                setcookie('ID_TYPE_ACCOUNT', $array_data[0]['id_tipo_usuario'], time()+43200, '/', $_SERVER['SERVER_NAME']);
                setcookie('PERMISSIONS', $array_data[0]['permisos'], time()+43200, '/', $_SERVER['SERVER_NAME']);
                setcookie('PERMISSIONS_TYPE', $array_data[0]['permisos_tipo'], time()+43200, '/', $_SERVER['SERVER_NAME']);
                setcookie('REMOTE_ADDR', $_SERVER['REMOTE_ADDR'], time()+43200, '/', $_SERVER['SERVER_NAME']);
                setcookie('HTTP_USER_AGENT', $_SERVER['HTTP_USER_AGENT'], time()+43200, '/', $_SERVER['SERVER_NAME']);

                $array_response['login'] = true;
            }else{
                $array_response['error'] = "Contraseña incorrecta";
            }
        }else{
            $array_response['error'] = "Usuario no existe";
        }
    }else{
        $array_response['error'] = "Parametros faltantes";
    }

    echo json_encode($array_response);
?>