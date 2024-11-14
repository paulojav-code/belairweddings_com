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
                $sql = 'SELECT t0.`id_idioma`,t0.`nombre`,t0.`siglas`,t0.`bandera`,t0.`bandera_alt` AS "bandera alterna",t0.`activo`
						FROM admin_bodas.idiomas AS t0 
                        
                        WHERE t0.`activo` = 1 ORDER BY id_idioma;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'ssss';
                $array_param[] = &$array_resquest['nombre'];
				$array_param[] = &$array_resquest['siglas'];
				$array_param[] = &$array_resquest['bandera'];
				$array_param[] = &$array_resquest['bandera_alt'];
                $sql = "INSERT INTO admin_bodas.idiomas (`nombre`,`siglas`,`bandera`,`bandera_alt`) VALUE (?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_idioma']) && $array_resquest['id_idioma'] > 0 && $array_resquest['id_idioma'] != ''){
                    if(isset($array_resquest['nombre'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['nombre'];
                        $str_set .= ' `nombre` = ?,';
                    }
					if(isset($array_resquest['siglas'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['siglas'];
                        $str_set .= ' `siglas` = ?,';
                    }
					if(isset($array_resquest['bandera'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['bandera'];
                        $str_set .= ' `bandera` = ?,';
                    }
					if(isset($array_resquest['bandera_alt'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['bandera_alt'];
                        $str_set .= ' `bandera_alt` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.idiomas SET".$str_set." WHERE `id_idioma` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_idioma'];
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
                if(isset($array_resquest['id_idioma']) && $array_resquest['id_idioma'] > 0 && $array_resquest['id_idioma'] != ''){
                    $sql = "UPDATE admin_bodas.idiomas SET `activo` = 0 WHERE `id_idioma` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_idioma']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_idioma']) && $array_resquest['id_idioma'] > 0 && $array_resquest['id_idioma'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.idiomas WHERE `activo` = 1 AND `id_idioma` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_idioma']);
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
                    $sql = 'SELECT t0.`id_idioma`,t0.`nombre`,t0.`siglas`,t0.`bandera`,t0.`bandera_alt` AS "bandera alterna",t0.`activo`
						FROM admin_bodas.idiomas AS t0 
                            
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