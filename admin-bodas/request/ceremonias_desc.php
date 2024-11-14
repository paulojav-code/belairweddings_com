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
                $sql = 'SELECT t0.`id_ceremonia_desc`,CONCAT(t2.`person_1`," ",t2.`conector`," ",t2.`person_2`) AS "Novies",t3.`nombre` AS "Tipo Ceremonia",t4.`siglas`,t0.`descripcion`,t0.`activo`
						FROM admin_bodas.ceremonias_desc AS t0 
                        INNER JOIN admin_bodas.`ceremonias` AS t1 ON t0.`id_ceremonia` = t1.`id_ceremonia`
						INNER JOIN admin_bodas.`novies` AS t2 ON t1.`id_novie` = t2.`id_novie`
						INNER JOIN admin_bodas.`tipos_ceremonias` AS t3 ON t1.`id_tipo_ceremonia` = t3.`id_tipo_ceremonia`
						INNER JOIN admin_bodas.`idiomas` AS t4 ON t0.`id_idioma` = t4.`id_idioma`
                        WHERE t0.`activo` = 1 ORDER BY id_ceremonia_desc;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'iis';
                $array_param[] = &$array_resquest['id_ceremonia'];
				$array_param[] = &$array_resquest['id_idioma'];
				$array_param[] = &$array_resquest['descripcion'];
                $sql = "INSERT INTO admin_bodas.ceremonias_desc (`id_ceremonia`,`id_idioma`,`descripcion`) VALUE (?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_ceremonia_desc']) && $array_resquest['id_ceremonia_desc'] > 0 && $array_resquest['id_ceremonia_desc'] != ''){
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
                    $sql = "UPDATE admin_bodas.ceremonias_desc SET".$str_set." WHERE `id_ceremonia_desc` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_ceremonia_desc'];
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
                if(isset($array_resquest['id_ceremonia_desc']) && $array_resquest['id_ceremonia_desc'] > 0 && $array_resquest['id_ceremonia_desc'] != ''){
                    $sql = "UPDATE admin_bodas.ceremonias_desc SET `activo` = 0 WHERE `id_ceremonia_desc` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_ceremonia_desc']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_ceremonia_desc']) && $array_resquest['id_ceremonia_desc'] > 0 && $array_resquest['id_ceremonia_desc'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.ceremonias_desc WHERE `activo` = 1 AND `id_ceremonia_desc` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_ceremonia_desc']);
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
                    $sql = 'SELECT t0.`id_ceremonia_desc`,CONCAT(t2.`person_1`," ",t2.`conector`," ",t2.`person_2`) AS "Novies",t3.`nombre` AS "Tipo Ceremonia",t4.`siglas`,t0.`descripcion`,t0.`activo`
						FROM admin_bodas.ceremonias_desc AS t0 
                            INNER JOIN admin_bodas.`ceremonias` AS t1 ON t0.`id_ceremonia` = t1.`id_ceremonia`
						INNER JOIN admin_bodas.`novies` AS t2 ON t1.`id_novie` = t2.`id_novie`
						INNER JOIN admin_bodas.`tipos_ceremonias` AS t3 ON t1.`id_tipo_ceremonia` = t3.`id_tipo_ceremonia`
						INNER JOIN admin_bodas.`idiomas` AS t4 ON t0.`id_idioma` = t4.`id_idioma`
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