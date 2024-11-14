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
                $sql = 'SELECT t0.`id_ceremonia`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "novies",t2.`nombre`,t0.`orden`,t0.`fecha`,t0.`hora`,t0.`activo`
						FROM admin_bodas.ceremonias AS t0 
                        INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`tipos_ceremonias` AS t2 ON t0.`id_tipo_ceremonia` = t2.`id_tipo_ceremonia`
                        WHERE t0.`activo` = 1 ORDER BY id_ceremonia;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'iiiss';
                $array_param[] = &$array_resquest['id_novie'];
				$array_param[] = &$array_resquest['id_tipo_ceremonia'];
				$array_param[] = &$array_resquest['orden'];
				$array_param[] = &$array_resquest['fecha'];
				$array_param[] = &$array_resquest['hora'];
                $sql = "INSERT INTO admin_bodas.ceremonias (`id_novie`,`id_tipo_ceremonia`,`orden`,`fecha`,`hora`) VALUE (?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_ceremonia']) && $array_resquest['id_ceremonia'] > 0 && $array_resquest['id_ceremonia'] != ''){
                    if(isset($array_resquest['id_novie'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['id_novie'];
                        $str_set .= ' `id_novie` = ?,';
                    }
                    if(isset($array_resquest['id_tipo_ceremonia'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['id_tipo_ceremonia'];
                        $str_set .= ' `id_tipo_ceremonia` = ?,';
                    }
                    if(isset($array_resquest['orden'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['orden'];
                        $str_set .= ' `orden` = ?,';
                    }
					if(isset($array_resquest['fecha'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['fecha'];
                        $str_set .= ' `fecha` = ?,';
                    }
					if(isset($array_resquest['hora'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['hora'];
                        $str_set .= ' `hora` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.ceremonias SET".$str_set." WHERE `id_ceremonia` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_ceremonia'];
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
                if(isset($array_resquest['id_ceremonia']) && $array_resquest['id_ceremonia'] > 0 && $array_resquest['id_ceremonia'] != ''){
                    $sql = "UPDATE admin_bodas.ceremonias SET `activo` = 0 WHERE `id_ceremonia` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_ceremonia']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_ceremonia']) && $array_resquest['id_ceremonia'] > 0 && $array_resquest['id_ceremonia'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.ceremonias WHERE `activo` = 1 AND `id_ceremonia` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_ceremonia']);
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
                    $sql = 'SELECT t0.`id_ceremonia`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "novies",t2.`nombre`,t0.`orden`,t0.`fecha`,t0.`hora`,t0.`activo`
						FROM admin_bodas.ceremonias AS t0 
                            INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`tipos_ceremonias` AS t2 ON t0.`id_tipo_ceremonia` = t2.`id_tipo_ceremonia`
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