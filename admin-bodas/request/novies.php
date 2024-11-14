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
                $sql = 'SELECT t0.`id_novie`,CONCAT(t1.`nombre`," ",t1.`paterno`) AS "Ejecutivo",t2.`nombre` AS "Hotel",t0.`person_1` AS "Novie 1",t0.`person_2` AS "Novie 2",t0.`fecha`,t0.`ruta`,t0.`cover_desk` AS "Imagen Cover",t0.`cover_mobile` AS "Imagen Mobile",t0.`mini_small` AS "Mini Cuadrado",t0.`mini_large` AS "Mini Largo",t0.`mini_novie` AS "Imagen Novies",t0.`mini_ceremonia` AS "Imagen Ceremonias",t0.`galeria`,t0.`copia`,t0.`clave_evento` AS "Clave Evento",t0.`idiomas`,t0.`activo`
						FROM admin_bodas.novies AS t0 
                        INNER JOIN admin_bodas.`ejecutivos` AS t1 ON t0.`id_ejecutivo` = t1.`id_ejecutivo`
						INNER JOIN admin_bodas.`hoteles` AS t2 ON t0.`id_hotel` = t2.`id_hotel`
                        WHERE t0.`activo` IN(1,2,3,4,5) ORDER BY FIELD(t0.activo,5,4,1,3,2), id_novie DESC;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break;
            case '1':
                //Request INSERT
                $array_param[0] = 'iiisssiiisssssssssisss';
                $array_param[] = &$array_resquest['id_ejecutivo'];
				$array_param[] = &$array_resquest['id_ejecutivo_publico'];
				$array_param[] = &$array_resquest['id_hotel'];
				$array_param[] = &$array_resquest['person_1'];
				$array_param[] = &$array_resquest['person_2'];
				$array_param[] = &$array_resquest['conector'];
				$array_param[] = &$array_resquest['categoria_parejas'];
				$array_param[] = &$array_resquest['permitido_ninos'];
                $array_param[] = &$array_resquest['asistencia'];
				$array_param[] = &$array_resquest['fecha'];
				$array_param[] = &$array_resquest['tiempo'];
				$array_param[] = &$array_resquest['ruta'];
				$array_param[] = &$array_resquest['cover_desk'];
				$array_param[] = &$array_resquest['cover_mobile'];
				$array_param[] = &$array_resquest['mini_small'];
				$array_param[] = &$array_resquest['mini_large'];
				$array_param[] = &$array_resquest['mini_novie'];
				$array_param[] = &$array_resquest['mini_ceremonia'];
				$array_param[] = &$array_resquest['galeria'];
				$array_param[] = &$array_resquest['copia'];
				$array_param[] = &$array_resquest['clave_evento'];
				$array_param[] = &$array_resquest['idiomas'];
                $sql = "INSERT INTO admin_bodas.novies (`id_ejecutivo`,`id_ejecutivo_publico`,`id_hotel`,`person_1`,`person_2`,`conector`,`categoria_parejas`,`permitido_ninos`,`asistencia`,`fecha`,`tiempo`,`ruta`,`cover_desk`,`cover_mobile`,`mini_small`,`mini_large`,`mini_novie`,`mini_ceremonia`,`galeria`,`copia`,`clave_evento`,`idiomas`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $con -> prepare($sql);
                call_user_func_array(array($stmt, "bind_param"), $array_param);
                $stmt -> execute();
                $array_response['insert'] = $stmt->affected_rows;
                break;
            case '2':
                //Request UPDATE
                if(isset($array_resquest['id_novie']) && $array_resquest['id_novie'] > 0 && $array_resquest['id_novie'] != ''){
                    if(isset($array_resquest['id_ejecutivo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['id_ejecutivo'];
                        $str_set .= ' `id_ejecutivo` = ?,';
                    }
					if(isset($array_resquest['id_ejecutivo_publico'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['id_ejecutivo_publico'];
                        $str_set .= ' `id_ejecutivo_publico` = ?,';
                    }
					if(isset($array_resquest['id_hotel'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['id_hotel'];
                        $str_set .= ' `id_hotel` = ?,';
                    }
					if(isset($array_resquest['person_1'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['person_1'];
                        $str_set .= ' `person_1` = ?,';
                    }
					if(isset($array_resquest['person_2'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['person_2'];
                        $str_set .= ' `person_2` = ?,';
                    }
					if(isset($array_resquest['conector'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['conector'];
                        $str_set .= ' `conector` = ?,';
                    }
					if(isset($array_resquest['categoria_parejas'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['categoria_parejas'];
                        $str_set .= ' `categoria_parejas` = ?,';
                    }
					if(isset($array_resquest['permitido_ninos'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['permitido_ninos'];
                        $str_set .= ' `permitido_ninos` = ?,';
                    }
                    if(isset($array_resquest['asistencia'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['asistencia'];
                        $str_set .= ' `asistencia` = ?,';
                    }
					if(isset($array_resquest['fecha'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['fecha'];
                        $str_set .= ' `fecha` = ?,';
                    }
					if(isset($array_resquest['tiempo'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['tiempo'];
                        $str_set .= ' `tiempo` = ?,';
                    }
					if(isset($array_resquest['ruta'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['ruta'];
                        $str_set .= ' `ruta` = ?,';
                    }
					if(isset($array_resquest['cover_desk'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['cover_desk'];
                        $str_set .= ' `cover_desk` = ?,';
                    }
					if(isset($array_resquest['cover_mobile'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['cover_mobile'];
                        $str_set .= ' `cover_mobile` = ?,';
                    }
					if(isset($array_resquest['mini_small'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['mini_small'];
                        $str_set .= ' `mini_small` = ?,';
                    }
					if(isset($array_resquest['mini_large'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['mini_large'];
                        $str_set .= ' `mini_large` = ?,';
                    }
					if(isset($array_resquest['mini_novie'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['mini_novie'];
                        $str_set .= ' `mini_novie` = ?,';
                    }
					if(isset($array_resquest['mini_ceremonia'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['mini_ceremonia'];
                        $str_set .= ' `mini_ceremonia` = ?,';
                    }
					if(isset($array_resquest['galeria'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['galeria'];
                        $str_set .= ' `galeria` = ?,';
                    }
					if(isset($array_resquest['copia'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['copia'];
                        $str_set .= ' `copia` = ?,';
                    }
					if(isset($array_resquest['clave_evento'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['clave_evento'];
                        $str_set .= ' `clave_evento` = ?,';
                    }
					if(isset($array_resquest['idiomas'])){
                        $array_param[0] .= 's';
                        $array_param[] = &$array_resquest['idiomas'];
                        $str_set .= ' `idiomas` = ?,';
                    }
					if(isset($array_resquest['activo'])){
                        $array_param[0] .= 'i';
                        $array_param[] = &$array_resquest['activo'];
                        $str_set .= ' `activo` = ?,';
                    }
                    $str_set = trim($str_set,',');
                    $sql = "UPDATE admin_bodas.novies SET".$str_set." WHERE `id_novie` = ?;";
                    $stmt = $con -> prepare($sql);
                    $array_param[0] .= 'i';
                    $array_param[] = &$array_resquest['id_novie'];
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
                if(isset($array_resquest['id_novie']) && $array_resquest['id_novie'] > 0 && $array_resquest['id_novie'] != ''){
                    $sql = "UPDATE admin_bodas.novies SET `activo` = 0 WHERE `id_novie` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_novie']);
                    $stmt -> execute();
                    $array_response['delete'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
                }
            case '4':
                //Request ID
                if(isset($array_resquest['id_novie']) && $array_resquest['id_novie'] > 0 && $array_resquest['id_novie'] != ''){
                    $sql = 'SELECT * FROM admin_bodas.novies WHERE `activo` IN(1,2,3,4,5) AND `id_novie` = ?;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_novie']);
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
                    $sql = 'SELECT t0.`id_novie`,CONCAT(t1.`nombre`," ",t1.`paterno`) AS "Ejecutivo",t2.`nombre` AS "Hotel",t0.`person_1` AS "Novie 1",t0.`person_2` AS "Novie 2",t0.`conector`,t0.`fecha`,t0.`ruta`,t0.`cover_desk` AS "Imagen Cover",t0.`cover_mobile` AS "Imagen Mobile",t0.`mini_small` AS "Mini Cuadrado",t0.`mini_large` AS "Mini Largo",t0.`mini_novie` AS "Imagen Novies",t0.`mini_ceremonia` AS "Imagen Ceremonias",t0.`galeria`,t0.`copia`,t0.`clave_evento` AS "Clave Evento",t0.`idiomas`,t0.`activo`
						FROM admin_bodas.novies AS t0 
                            INNER JOIN admin_bodas.`ejecutivos` AS t1 ON t0.`id_ejecutivo` = t1.`id_ejecutivo`
						INNER JOIN admin_bodas.`hoteles` AS t2 ON t0.`id_hotel` = t2.`id_hotel`
                            WHERE t0.`activo` IN(1,2,3,4,5) ORDER BY '.$array_resquest['order_by'].' DESC;';
                    $stmt = $con -> prepare($sql);
                    $stmt -> execute();
                    $result = $stmt->get_result();
                    while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                        $array_response[] = $req;
                    }
                }
                break;
            case 'creador':
                //Request ORDER BY
                $sql = 'SELECT t0.`id_novie`,CONCAT(t0.`person_1`," ",t0.`conector`," ",t0.`person_2`) AS `novies`, t0.`ruta`, t0.`activo`
                        FROM admin_bodas.novies AS t0
                        WHERE t0.`activo` IN(1,5) ORDER BY activo DESC, id_novie DESC;';
                $stmt = $con -> prepare($sql);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
                    $array_response[] = $req;
                }
                break; 
            case 'activar':
                //Request ACTIVAR
                if(isset($array_resquest['id_novie']) && $array_resquest['id_novie'] > 0 && $array_resquest['id_novie'] != ''){
                    $sql = "UPDATE admin_bodas.novies SET `activo` = 1 WHERE `id_novie` = ?;";
                    $stmt = $con -> prepare($sql);
                    $stmt -> bind_param("i", $array_resquest['id_novie']);
                    $stmt -> execute();
                    $array_response['activo'] = $stmt->affected_rows;
                    break;
                }else{
                    echo '{"error": "Parametros faltantes"}';
                    exit;
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