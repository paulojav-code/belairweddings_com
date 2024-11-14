<?php
require_once('../classes/class.phpmailer.php');
require_once('../classes/class.smtp.php');

include_once('../php/cuerpo_correo.php');

$json_raw_php = file_get_contents('../php/datos_correos.json');
$correos  = json_decode($json_raw_php, TRUE);

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = $correos['clave_secreta']; 
    $recaptcha_response = $_POST['recaptcha']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha); 

    $array_datos = getData($_POST);

    if($recaptcha->score >= floatval($correos['recaptcha_score'])){
        
        $origen = $array_datos['origen'];
        
        if(validarCampos($array_datos)) {
            $mail = new PHPMailer();

            $mail->IsSMTP();

            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host       = "smtp-relay.gmail.com";
            $mail->Port       = 465;
            $mail->Username   = "formulario@coleccionbelair.com";
            $mail->Password   = "!QuestioNWeB2019$";
            $mail->CharSet    = "UTF-8";

            $mail->SetFrom('formulario@coleccionbelair.com', 'Formulario');
            
            $mail->MsgHTML(getBody($array_datos));
            $mail->Subject    = $correos['origen'][$origen]['titulo'];
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->AddAddress($correos['origen'][$origen]['correo_titular']['correo'], $correos['origen'][$origen]['correo_titular']['nombre']);
            
            $mail->AddCC('reservaciones@dreams-wedding.com.mx', 'Reservas');
            for ($i=0; $i < count($correos['origen'][$origen]['correos_copias']); $i++) { 
                $mail->AddCC($correos['origen'][$origen]['correos_copias'][$i]['correo'], $correos['origen'][$origen]['correos_copias'][$i]['nombre']);
            }
            if ($mail->Send()) {
                retorno('0',$array_datos);
            } else {
                retorno('2',$array_datos);
            }
        }else{
            retorno('1',$array_datos);
        }
    } else {
        retorno('3',$array_datos);
    }
}