<?php
    function getData($post) {
        $array = array();

        if(isset($post["origen"])){
            $array['origen'] = intval(strip_tags($post["origen"]));
        }else{
            $array['origen'] = 0;
        }

        foreach ($post as $clave => $valor) {
            $array[$clave] = $post[$clave];
        }

        return $array;
    }

    function getBody($array) {
        global $correos;
        $body = '';

        switch($array['origen']){
            case 1:
            case 2:
                $correos['origen'][$array['origen']]['titulo'] .= $array['novies'];
                $body = "<strong>Nombre:</strong> ".$array['nombre']." ".$array['apellido']."<br/>";
                $body .= "<strong>Email:</strong> ".$array['email']."<br/>";
                $body .= "<strong>Teléfono:</strong> ".$array['telefono']."<br/>";
                $body .= "<strong>Checkin:</strong> ".$array['checkin']." <strong>Checkout:</strong> ".$array['checkout']."<br/>";
                $body .= "<strong>Habitacion:</strong> ".$array['room']."<br/>";
                $body .= "<strong>Total:</strong> ".$array['total']."<br/>";
                $correos['origen'][$array['origen']]['correos_copias'][0] = ['nombre' => 'Ejecutivo','correo'=>$array['ejecutivo']];
                break;
            default:
                $body = "<strong>Nombre:</strong> ".$array['nombre']."<br/>";
                $body .= "<strong>Email:</strong> ".$array['email']."<br/>";
                $body .= "<strong>Teléfono:</strong> ".$array['telefono']."<br/>";
                $body .= "<strong>Mensaje:</strong> ".$array['mensaje']."<br/>";
                break;
        }

        return $body;
    }

    function validarCampos($array) {
        $validacion = false;

        switch($array['origen']){
            case 1:
            case 2:
            default:
                if(
                    !empty($array['nombre']) ||
                    !empty($array['email']) ||
                    !empty($array['telefono'])
                ) {
                    $validacion = true;
                }
                break;
        }

        return $validacion;
    }

    function retorno($id, $array){
        global $correos;

        echo $id;
    }
?>