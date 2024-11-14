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
                $sql = 'SELECT t0.`id_destino_desc`,t1.`siglas`,t0.`nombre`,t0.`nombre_corto` AS "Nombre Corto",t0.`nombre_largo` AS "Nombre Largo",t0.`descripcion`,t0.`activo`
						FROM admin_bodas.destinos_desc AS t0 
                        INNER JOIN admin_bodas.`idiomas` AS t1 ON t0.`id_idioma` = t1.`id_idioma`
                        WHERE t0.`activo` = 1 ORDER BY id_destino_desc;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'iissss';
                $array_param[] = &$array_resquest['id_destino'];
				$array_param[] = &$array_resquest['id_idioma'];
				$array_param[] = &$array_resquest['nombre'];
				$array_param[] = &$array_resquest['nombre_corto'];
				$array_param[] = &$array_resquest['nombre_largo'];
				$array_param[] = &$array_resquest['descripcion'];
                $sql = "INSERT INTO admin_bodas.destinos_desc (`id_destino`,`id_idioma`,`nombre`,`nombre_corto`,`nombre_largo`,`descripcion`) VALUE (?,?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_destino_desc']) && $array_resquest['id_destino_desc'] > 0 && $array_resquest['id_destino_desc'] != ''){
                    if(isset($array_resquest['nombre'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['nombre'];
                        $str_set .= ' `nombre` = ?,';
                    }
					if(isset($array_resquest['nombre_corto'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['nombre_corto'];
                        $str_set .= ' `nombre_corto` = ?,';
                    }
					if(isset($array_resquest['nombre_largo'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['nombre_largo'];
                        $str_set .= ' `nombre_largo` = ?,';
                    }
					if(isset($array_resquest['descripcion'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['descripcion'];
                        $str_set .= ' `descripcion` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.destinos_desc SET".$str_set." WHERE `id_destino_desc` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_destino_desc'];
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
                if(isset($array_resquest['id_destino_desc']) && $array_resquest['id_destino_desc'] > 0 && $array_resquest['id_destino_desc'] != ''){
                    $sql = "UPDATE admin_bodas.destinos_desc SET `activo` = 0 WHERE `id_destino_desc` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_destino_desc']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_destino_desc']) && $array_resquest['id_destino_desc'] > 0 && $array_resquest['id_destino_desc'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.destinos_desc WHERE `activo` = 1 AND `id_destino_desc` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_destino_desc']);
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
                    $sql = 'SELECT t0.`id_destino_desc`,t1.`siglas`,t0.`nombre`,t0.`nombre_corto` AS "Nombre Corto",t0.`nombre_largo` AS "Nombre Largo",t0.`descripcion`,t0.`activo`
						FROM admin_bodas.destinos_desc AS t0 
                            INNER JOIN admin_bodas.`idiomas` AS t1 ON t0.`id_idioma` = t1.`id_idioma`
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