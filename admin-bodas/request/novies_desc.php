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
                $sql = 'SELECT t0.`id_novie_desc`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "Novies",t2.`siglas`,t0.`frase`,t0.`tipo_codigo` AS "Tipo Codigo",t0.`codigo_vestimenta` AS "Codigo Vestimenta",t0.`guia_novies` AS "Guia Novies",t0.`telefono`,t0.`bitly`,t0.`activo`
						FROM admin_bodas.novies_desc AS t0 
                        INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`idiomas` AS t2 ON t0.`id_idioma` = t2.`id_idioma`
                        WHERE t0.`activo` = 1 ORDER BY id_novie_desc DESC;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'iissssss';
                $array_param[] = &$array_resquest['id_novie'];
				$array_param[] = &$array_resquest['id_idioma'];
				$array_param[] = &$array_resquest['frase'];
				$array_param[] = &$array_resquest['tipo_codigo'];
				$array_param[] = &$array_resquest['codigo_vestimenta'];
				$array_param[] = &$array_resquest['guia_novies'];
				$array_param[] = &$array_resquest['telefono'];
				$array_param[] = &$array_resquest['bitly'];
                $sql = "INSERT INTO admin_bodas.novies_desc (`id_novie`,`id_idioma`,`frase`,`tipo_codigo`,`codigo_vestimenta`,`guia_novies`,`telefono`,`bitly`) VALUE (?,?,?,?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_novie_desc']) && $array_resquest['id_novie_desc'] > 0 && $array_resquest['id_novie_desc'] != ''){
                    if(isset($array_resquest['frase'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['frase'];
                        $str_set .= ' `frase` = ?,';
                    }
					if(isset($array_resquest['tipo_codigo'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['tipo_codigo'];
                        $str_set .= ' `tipo_codigo` = ?,';
                    }
					if(isset($array_resquest['codigo_vestimenta'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['codigo_vestimenta'];
                        $str_set .= ' `codigo_vestimenta` = ?,';
                    }
					if(isset($array_resquest['guia_novies'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['guia_novies'];
                        $str_set .= ' `guia_novies` = ?,';
                    }
					if(isset($array_resquest['telefono'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['telefono'];
                        $str_set .= ' `telefono` = ?,';
                    }
					if(isset($array_resquest['bitly'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['bitly'];
                        $str_set .= ' `bitly` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.novies_desc SET".$str_set." WHERE `id_novie_desc` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_novie_desc'];
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
                if(isset($array_resquest['id_novie_desc']) && $array_resquest['id_novie_desc'] > 0 && $array_resquest['id_novie_desc'] != ''){
                    $sql = "UPDATE admin_bodas.novies_desc SET `activo` = 0 WHERE `id_novie_desc` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_novie_desc']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_novie_desc']) && $array_resquest['id_novie_desc'] > 0 && $array_resquest['id_novie_desc'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.novies_desc WHERE `activo` = 1 AND `id_novie_desc` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_novie_desc']);
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
                    $sql = 'SELECT t0.`id_novie_desc`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "Novies",t2.`siglas`,t0.`frase`,t0.`tipo_codigo` AS "Tipo Codigo",t0.`codigo_vestimenta` AS "Codigo Vestimenta",t0.`guia_novies` AS "Guia Novies",t0.`telefono`,t0.`bitly`,t0.`activo`
						FROM admin_bodas.novies_desc AS t0 
                            INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`idiomas` AS t2 ON t0.`id_idioma` = t2.`id_idioma`
                            WHERE t0.`activo` = 1 ORDER BY '.$array_resquest['order_by'].'DESC;';
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