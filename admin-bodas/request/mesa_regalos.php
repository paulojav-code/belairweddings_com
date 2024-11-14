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
                $sql = 'SELECT t0.`id_mesa_regalo`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "Novies",t2.`siglas`,t0.`titulo`,t0.`descripcion`,t0.`enlace`,t0.`activo`
						FROM admin_bodas.mesa_regalos AS t0 
                        INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`idiomas` AS t2 ON t0.`id_idioma` = t2.`id_idioma`
                        WHERE t0.`activo` = 1 ORDER BY id_mesa_regalo;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'iisss';
                $array_param[] = &$array_resquest['id_novie'];
				$array_param[] = &$array_resquest['id_idioma'];
				$array_param[] = &$array_resquest['titulo'];
				$array_param[] = &$array_resquest['descripcion'];
				$array_param[] = &$array_resquest['enlace'];
                $sql = "INSERT INTO admin_bodas.mesa_regalos (`id_novie`,`id_idioma`,`titulo`,`descripcion`,`enlace`) VALUE (?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_mesa_regalo']) && $array_resquest['id_mesa_regalo'] > 0 && $array_resquest['id_mesa_regalo'] != ''){
                    if(isset($array_resquest['titulo'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['titulo'];
                        $str_set .= ' `titulo` = ?,';
                    }
					if(isset($array_resquest['descripcion'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['descripcion'];
                        $str_set .= ' `descripcion` = ?,';
                    }
					if(isset($array_resquest['enlace'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['enlace'];
                        $str_set .= ' `enlace` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.mesa_regalos SET".$str_set." WHERE `id_mesa_regalo` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_mesa_regalo'];
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
                if(isset($array_resquest['id_mesa_regalo']) && $array_resquest['id_mesa_regalo'] > 0 && $array_resquest['id_mesa_regalo'] != ''){
                    $sql = "UPDATE admin_bodas.mesa_regalos SET `activo` = 0 WHERE `id_mesa_regalo` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_mesa_regalo']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_mesa_regalo']) && $array_resquest['id_mesa_regalo'] > 0 && $array_resquest['id_mesa_regalo'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.mesa_regalos WHERE `activo` = 1 AND `id_mesa_regalo` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_mesa_regalo']);
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
                    $sql = 'SELECT t0.`id_mesa_regalo`,CONCAT(t1.`person_1`," ",t1.`conector`," ",t1.`person_2`) AS "Novies",t2.`siglas`,t0.`titulo`,t0.`descripcion`,t0.`enlace`,t0.`activo`
						FROM admin_bodas.mesa_regalos AS t0 
                            INNER JOIN admin_bodas.`novies` AS t1 ON t0.`id_novie` = t1.`id_novie`
						INNER JOIN admin_bodas.`idiomas` AS t2 ON t0.`id_idioma` = t2.`id_idioma`
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