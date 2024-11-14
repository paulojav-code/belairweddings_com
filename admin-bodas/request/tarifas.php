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
                $sql = 'SELECT t0.`id_tarifa`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "Novies",t3.`nombre` AS "hotel",t4.`nombre` AS "habitacion",t0.`precio`,t0.`doble`,t0.`extra`,t0.`junior`,t0.`ninho`,t0.`activo`
						FROM admin_bodas.tarifas AS t0 
                        INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`habitaciones` AS t2 ON t0.`id_habitacion` = t2.`id_habitacion`
						INNER JOIN admin_bodas.`hoteles` AS t3 ON t2.`id_hotel` = t3.`id_hotel`
						INNER JOIN admin_bodas.`habitaciones` AS t4 ON t2.`id_habitacion` = t4.`id_habitacion`
                        WHERE t0.`activo` = 1 ORDER BY id_tarifa;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'iisssss';
                $array_param[] = &$array_resquest['id_novie'];
				$array_param[] = &$array_resquest['id_habitacion'];
				$array_param[] = &$array_resquest['precio'];
				$array_param[] = &$array_resquest['doble'];
				$array_param[] = &$array_resquest['extra'];
				$array_param[] = &$array_resquest['junior'];
				$array_param[] = &$array_resquest['ninho'];
                $sql = "INSERT INTO admin_bodas.tarifas (`id_novie`,`id_habitacion`,`precio`,`doble`,`extra`,`junior`,`ninho`) VALUE (?,?,?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_tarifa']) && $array_resquest['id_tarifa'] > 0 && $array_resquest['id_tarifa'] != ''){
                    if(isset($array_resquest['id_habitacion'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['id_habitacion'];
                        $str_set .= ' `id_habitacion` = ?,';
                    }
                    if(isset($array_resquest['precio'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['precio'];
                        $str_set .= ' `precio` = ?,';
                    }
					if(isset($array_resquest['doble'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['doble'];
                        $str_set .= ' `doble` = ?,';
                    }
					if(isset($array_resquest['extra'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['extra'];
                        $str_set .= ' `extra` = ?,';
                    }
					if(isset($array_resquest['junior'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['junior'];
                        $str_set .= ' `junior` = ?,';
                    }
					if(isset($array_resquest['ninho'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['ninho'];
                        $str_set .= ' `ninho` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.tarifas SET".$str_set." WHERE `id_tarifa` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_tarifa'];
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
                if(isset($array_resquest['id_tarifa']) && $array_resquest['id_tarifa'] > 0 && $array_resquest['id_tarifa'] != ''){
                    $sql = "UPDATE admin_bodas.tarifas SET `activo` = 0 WHERE `id_tarifa` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_tarifa']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_tarifa']) && $array_resquest['id_tarifa'] > 0 && $array_resquest['id_tarifa'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.tarifas WHERE `activo` = 1 AND `id_tarifa` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_tarifa']);
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
                    $sql = 'SELECT t0.`id_tarifa`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "Novies",t3.`nombre` AS "hotel",t4.`nombre` AS "habitacion",t0.`precio`,t0.`doble`,t0.`extra`,t0.`junior`,t0.`ninho`,t0.`activo`
						FROM admin_bodas.tarifas AS t0 
                            INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`habitaciones` AS t2 ON t0.`id_habitacion` = t2.`id_habitacion`
						INNER JOIN admin_bodas.`hoteles` AS t3 ON t2.`id_hotel` = t3.`id_hotel`
						INNER JOIN admin_bodas.`habitaciones` AS t4 ON t2.`id_habitacion` = t4.`id_habitacion`
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