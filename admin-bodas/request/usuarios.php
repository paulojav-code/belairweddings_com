<?php
    include_once('../include/config.php');
    include_once('../include/php/global.php');
    include_once('../include/conexion.php');

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

    $array_response = array();
    $array_param = [''];
    $str_set = '';
    $sql = '';

    if(isset($array_resquest['type'])){
        switch($array_resquest['type']){
            case '0':
                //Request SELECT
                $sql = 'SELECT t0.`id_usuario`,t0.`usuario`,t0.`contrasena`,t0.`nombre`,t0.`paterno`,t0.`materno`,t0.`permisos`,t0.`genero`,t0.`activo`
						FROM admin_bodas.usuarios AS t0 
                        
                        WHERE t0.`activo` = 1 ORDER BY id_usuario;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_resquest['contrasena'] = password_hash($array_resquest['contrasena'],PASSWORD_DEFAULT);
                $array_param[0] = 'issssssi';
                $array_param[] = &$array_resquest['id_tipo_usuario'];
				$array_param[] = &$array_resquest['usuario'];
				$array_param[] = &$array_resquest['contrasena'];
				$array_param[] = &$array_resquest['nombre'];
				$array_param[] = &$array_resquest['paterno'];
				$array_param[] = &$array_resquest['materno'];
				$array_param[] = &$array_resquest['permisos'];
				$array_param[] = &$array_resquest['genero'];
                $sql = "INSERT INTO admin_bodas.usuarios (`id_tipo_usuario`,`usuario`,`contrasena`,`nombre`,`paterno`,`materno`,`permisos`,`genero`) VALUE (?,?,?,?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_usuario']) && $array_resquest['id_usuario'] > 0 && $array_resquest['id_usuario'] != ''){
                    if(isset($array_resquest['id_tipo_usuario'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['id_tipo_usuario'];
                        $str_set .= ' `id_tipo_usuario` = ?,';
                    }
					if(isset($array_resquest['usuario'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['usuario'];
                        $str_set .= ' `usuario` = ?,';
                    }
					if(isset($array_resquest['contrasena'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['contrasena'];
                        $str_set .= ' `contrasena` = ?,';
                    }
					if(isset($array_resquest['nombre'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['nombre'];
                        $str_set .= ' `nombre` = ?,';
                    }
					if(isset($array_resquest['paterno'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['paterno'];
                        $str_set .= ' `paterno` = ?,';
                    }
					if(isset($array_resquest['materno'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['materno'];
                        $str_set .= ' `materno` = ?,';
                    }
					if(isset($array_resquest['permisos'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['permisos'];
                        $str_set .= ' `permisos` = ?,';
                    }
					if(isset($array_resquest['genero'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['genero'];
                        $str_set .= ' `genero` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.usuarios SET".$str_set." WHERE `id_usuario` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_usuario'];
                    call_user_func_array(array($stmt, "bind_param"), $array_param);
                    $stmt -> execute();
                    $array_response['update'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
                break;
            case '3':
                //Request DELETE
                if(isset($array_resquest['id_usuario']) && $array_resquest['id_usuario'] > 0 && $array_resquest['id_usuario'] != ''){
                    $sql = "UPDATE admin_bodas.usuarios SET `activo` = 0 WHERE `id_usuario` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_usuario']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_usuario']) && $array_resquest['id_usuario'] > 0 && $array_resquest['id_usuario'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.usuarios WHERE `activo` = 1 AND `id_usuario` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_usuario']);
                    $stmt -> execute();
                    $result = $stmt->get_result();
                    while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                        $array_response[] = $req;
                    }
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
                break;
            case '5':
                //Request ORDER BY
                if(isset($array_resquest['order_by']) && $array_resquest['order_by'] != ''){
                    $sql = 'SELECT t0.`id_usuario`,t0.`usuario`,t0.`contrasena`,t0.`nombre`,t0.`paterno`,t0.`materno`,t0.`permisos`,t0.`genero`,t0.`activo`
						FROM admin_bodas.usuarios AS t0 
                            
                            WHERE t0.`activo` = 1 ORDER BY '.$array_resquest['order_by'].';';
                    $stmt = $con -> prepare($sql);
                    $stmt -> execute();
                    $result = $stmt->get_result();
                    while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                        $array_response[] = $req;
                    }
                }
                break;
            default:
                echo '{"error": "Parametros faltantes"}';
                exit;
        }
    }else{
        echo '{"error": "Parametros faltantes"}';
        exit;
    }

    $stmt -> close();

    echo json_encode($array_response);
?>