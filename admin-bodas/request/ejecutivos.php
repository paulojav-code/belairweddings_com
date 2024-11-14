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

    $request_keys = array_keys($array_resquest);
    $array_response = array();
    $array_param = [''];
    $str_set = '';
    $sql = '';

    if(isset($array_resquest['type'])){
        switch($array_resquest['type']){
            case '0':
                //Request SELECT
                $sql = 'SELECT t0.`id_ejecutivo`,t0.`nombre`,t0.`paterno`,t0.`materno`,t0.`correo`,t0.`telefono`,t0.`extencion`,t0.`genero`,t0.`tipo`,t0.`activo`
						FROM admin_bodas.ejecutivos AS t0 
                        
                        WHERE t0.`activo` = 1 ORDER BY id_ejecutivo;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'ssssssii';
                $array_param[] = &$array_resquest['nombre'];
				$array_param[] = &$array_resquest['paterno'];
				$array_param[] = &$array_resquest['materno'];
				$array_param[] = &$array_resquest['correo'];
				$array_param[] = &$array_resquest['telefono'];
				$array_param[] = &$array_resquest['extencion'];
				$array_param[] = &$array_resquest['genero'];
				$array_param[] = &$array_resquest['tipo'];
                $sql = "INSERT INTO admin_bodas.ejecutivos (`nombre`,`paterno`,`materno`,`correo`,`telefono`,`extencion`,`genero`,`tipo`) VALUE (?,?,?,?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_ejecutivo']) && $array_resquest['id_ejecutivo'] > 0 && $array_resquest['id_ejecutivo'] != ''){
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
					if(isset($array_resquest['correo'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['correo'];
                        $str_set .= ' `correo` = ?,';
                    }
					if(isset($array_resquest['telefono'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['telefono'];
                        $str_set .= ' `telefono` = ?,';
                    }
					if(isset($array_resquest['extencion'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['extencion'];
                        $str_set .= ' `extencion` = ?,';
                    }
					if(isset($array_resquest['genero'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['genero'];
                        $str_set .= ' `genero` = ?,';
                    }
					if(isset($array_resquest['tipo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['tipo'];
                        $str_set .= ' `tipo` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.ejecutivos SET".$str_set." WHERE `id_ejecutivo` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_ejecutivo'];
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
                if(isset($array_resquest['id_ejecutivo']) && $array_resquest['id_ejecutivo'] > 0 && $array_resquest['id_ejecutivo'] != ''){
                    $sql = "UPDATE admin_bodas.ejecutivos SET `activo` = 0 WHERE `id_ejecutivo` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_ejecutivo']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_ejecutivo']) && $array_resquest['id_ejecutivo'] > 0 && $array_resquest['id_ejecutivo'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.ejecutivos WHERE `activo` = 1 AND `id_ejecutivo` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_ejecutivo']);
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
                    $sql = 'SELECT t0.`id_ejecutivo`,t0.`nombre`,t0.`paterno`,t0.`materno`,t0.`correo`,t0.`telefono`,t0.`extencion`,t0.`genero`,t0.`tipo`,t0.`activo`
						FROM admin_bodas.ejecutivos AS t0 
                            
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