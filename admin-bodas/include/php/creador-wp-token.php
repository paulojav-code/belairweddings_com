<?php
    $plantilla_default = '../include/plantillas/wp/plantilla_token.txt';

    $param_str = '';
    $type_str = '';
    $array_param = [''];
    for ($i=0; $i < count($array_resquest); $i++) { 
        $param_str .= '?,';
        $array_param[0] .= 'i';
        $array_param[] = &$array_resquest[$i];
    }
    $param_str = trim($param_str,',');

    $sql = 'SELECT id_novie, CONCAT(person_1," ",conector," ",person_2) AS novies, ruta, idiomas, activo FROM admin_bodas.novies WHERE id_novie IN('.$param_str.') ORDER BY activo DESC,ruta;';
	$stmt = $con->prepare($sql);
    call_user_func_array(array($stmt, "bind_param"), $array_param);
	$stmt->execute();
    $result = $stmt->get_result();
    $array_data = array();
    $array_response = array();
	while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
		$array_data[] = $req;
	}
	$stmt->close();

    for ($i=0; $i < count($array_data); $i++) {
        if(!file_exists('../../wp/'.$array_data[$i]['ruta'])){
            mkdir('../../wp/'.$array_data[$i]['ruta'].'/', 0777);
        }
        if(file_exists('../../wp/'.$array_data[$i]['ruta'].'/token.php')){
            unlink('../../wp/'.$array_data[$i]['ruta'].'/token.php');
        }

        $file = fopen('../../wp/'.$array_data[$i]['ruta'].'/token.php',"a+");

        $plantilla = $plantilla_default;
        $cuerpo_plantilla = file_get_contents($plantilla);

        $cuerpo_plantilla = str_replace('{id}', $array_data[$i]['id_novie'], $cuerpo_plantilla);
        $cuerpo_plantilla = str_replace('{idioma}', 1, $cuerpo_plantilla);

        fwrite($file, $cuerpo_plantilla);
        fclose($file);

        $array['id_novie'] = $array_data[$i]['id_novie'];
        $array['novies'] = $array_data[$i]['novies'];
        $array['ruta'] = $array_data[$i]['ruta'];
        $array['ruta_local'] = '../../wp/'.$array_data[$i]['ruta'].'/token.php';
        $array['ruta_dw'] = 'https://dreams-wedding.com.mx/wp/'.$array_data[$i]['ruta'].'/token.php';

        if($array_data[$i]['idiomas'] == 'en') {
            if(!file_exists('../../wp/'.$array_data[$i]['ruta'].'/en/')){
                mkdir('../../wp/'.$array_data[$i]['ruta'].'/en/', 0777);
            }
            if(file_exists('../../wp/'.$array_data[$i]['ruta'].'/en/token.php')){
                unlink('../../wp/'.$array_data[$i]['ruta'].'/en/token.php');
            }

            $file = fopen('../../wp/'.$array_data[$i]['ruta'].'/en/token.php',"a+");
    
            $plantilla = $plantilla_default;
            $cuerpo_plantilla = file_get_contents($plantilla);
    
            $cuerpo_plantilla = str_replace('{id}', $array_data[$i]['id_novie'], $cuerpo_plantilla);
            $cuerpo_plantilla = str_replace('{idioma}', 2, $cuerpo_plantilla);
    
            fwrite($file, $cuerpo_plantilla);
            fclose($file);

            //$array['ruta_dw'] .= '<br>https://dreams-wedding.com.mx/wp/'.$array_data[$i]['ruta'].'/en/token.php';
        }

        $array_response[] = $array;
    }
?>