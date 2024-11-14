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
                $sql = 'SELECT t0.`id_destino`,t0.`nombre`,t0.`lat` AS "Latitud",t0.`lon` AS "Longitud",t0.`carpeta`,t0.`banner`,t0.`mini`,t0.`galeria`,t0.`activo`
						FROM admin_bodas.destinos AS t0 
                        
                        WHERE t0.`activo` = 1 ORDER BY id_destino;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'ssssssi';
                $array_param[] = &$array_resquest['nombre'];
				$array_param[] = &$array_resquest['lat'];
				$array_param[] = &$array_resquest['lon'];
				$array_param[] = &$array_resquest['carpeta'];
				$array_param[] = &$array_resquest['banner'];
				$array_param[] = &$array_resquest['mini'];
				$array_param[] = &$array_resquest['galeria'];
                $sql = "INSERT INTO admin_bodas.destinos (`nombre`,`lat`,`lon`,`carpeta`,`banner`,`mini`,`galeria`) VALUE (?,?,?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_destino']) && $array_resquest['id_destino'] > 0 && $array_resquest['id_destino'] != ''){
                    if(isset($array_resquest['nombre'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['nombre'];
                        $str_set .= ' `nombre` = ?,';
                    }
					if(isset($array_resquest['lat'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['lat'];
                        $str_set .= ' `lat` = ?,';
                    }
					if(isset($array_resquest['lon'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['lon'];
                        $str_set .= ' `lon` = ?,';
                    }
					if(isset($array_resquest['carpeta'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['carpeta'];
                        $str_set .= ' `carpeta` = ?,';
                    }
					if(isset($array_resquest['banner'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['banner'];
                        $str_set .= ' `banner` = ?,';
                    }
					if(isset($array_resquest['mini'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['mini'];
                        $str_set .= ' `mini` = ?,';
                    }
					if(isset($array_resquest['galeria'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['galeria'];
                        $str_set .= ' `galeria` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.destinos SET".$str_set." WHERE `id_destino` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_destino'];
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
                if(isset($array_resquest['id_destino']) && $array_resquest['id_destino'] > 0 && $array_resquest['id_destino'] != ''){
                    $sql = "UPDATE admin_bodas.destinos SET `activo` = 0 WHERE `id_destino` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_destino']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_destino']) && $array_resquest['id_destino'] > 0 && $array_resquest['id_destino'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.destinos WHERE `activo` = 1 AND `id_destino` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_destino']);
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
                    $sql = 'SELECT t0.`id_destino`,t0.`nombre`,t0.`lat` AS "Latitud",t0.`lon` AS "Longitud",t0.`carpeta`,t0.`banner`,t0.`mini`,t0.`galeria`,t0.`activo`
						FROM admin_bodas.destinos AS t0 
                            
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