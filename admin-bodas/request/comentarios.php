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
                $sql = 'SELECT t0.`id_comentario`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "novies",t0.`nombre`,t0.`mensaje`,t0.`fecha_envio`,t0.`fecha_aprobacion`,t0.`activo`
						FROM admin_bodas.comentarios AS t0 
                        INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
                        WHERE t0.`activo` = 1 ORDER BY id_comentario;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'issss';
                $array_param[] = &$array_resquest['id_novie'];
				$array_param[] = &$array_resquest['nombre'];
				$array_param[] = &$array_resquest['mensaje'];
				$array_param[] = &$array_resquest['fecha_envio'];
				$array_param[] = &$array_resquest['fecha_aprobacion'];
                $sql = "INSERT INTO admin_bodas.comentarios (`id_novie`,`nombre`,`mensaje`,`fecha_envio`,`fecha_aprobacion`) VALUE (?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_comentario']) && $array_resquest['id_comentario'] > 0 && $array_resquest['id_comentario'] != ''){
                    if(isset($array_resquest['nombre'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['nombre'];
                        $str_set .= ' `nombre` = ?,';
                    }
					if(isset($array_resquest['mensaje'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['mensaje'];
                        $str_set .= ' `mensaje` = ?,';
                    }
					if(isset($array_resquest['fecha_envio'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['fecha_envio'];
                        $str_set .= ' `fecha_envio` = ?,';
                    }
					if(isset($array_resquest['fecha_aprobacion'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['fecha_aprobacion'];
                        $str_set .= ' `fecha_aprobacion` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.comentarios SET".$str_set." WHERE `id_comentario` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_comentario'];
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
                if(isset($array_resquest['id_comentario']) && $array_resquest['id_comentario'] > 0 && $array_resquest['id_comentario'] != ''){
                    $sql = "UPDATE admin_bodas.comentarios SET `activo` = 0 WHERE `id_comentario` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_comentario']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_comentario']) && $array_resquest['id_comentario'] > 0 && $array_resquest['id_comentario'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.comentarios WHERE `activo` = 1 AND `id_comentario` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_comentario']);
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
                    $sql = 'SELECT t0.`id_comentario`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "novies",t0.`nombre`,t0.`mensaje`,t0.`fecha_envio`,t0.`fecha_aprobacion`,t0.`activo`
						FROM admin_bodas.comentarios AS t0 
                            INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
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