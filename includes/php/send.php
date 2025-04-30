<?php
if (isset($_POST['idioma'])) {
    $idioma = $_POST['idioma'];
}
require_once('../classes/class.phpmailer.php');
require_once('../classes/class.smtp.php');
include_once('../php/config.php');

$url_retorno = $idioma == 'es'? URL :URL.'/en';

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = '6LcYChIaAAAAAKqpKpU5BfXBZAp8zgPprqBcWlyi'; 
    $recaptcha_response = $_POST['recaptcha_response']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha); 

    if($recaptcha->score >= 0){

        var_dump($_POST);
        
        $nombre = strip_tags(strtolower($_POST["formulario_dw_nombre"]));
        $apellido = strip_tags(strtolower($_POST["formulario_dw_apellido"]));
        $email = strip_tags($_POST["formulario_dw_email"]);
        $telefono = strip_tags($_POST["formulario_dw_telefono"]);
        $mensaje = strip_tags($_POST["formulario_dw_mensaje"]);
        $origen = strip_tags($_POST["formulario_dw_origen"]);
        
        if( 
            !empty($nombre) AND 
            !empty($email) AND 
            !empty($apellido) AND 
            !empty($mensaje) 
        ) {
            $mail = new PHPMailer();

            $mail->IsSMTP();

            $body = "Nombre: <strong>".trim($nombre)." ".trim($apellido)."</strong><br/>";
            $body .= "Email: <strong>".trim($email)."</strong><br/>";
            $body .= "Teléfono: <strong>".trim($telefono)."</strong><br/>";
            $body .= "Mensaje: <strong>".trim($mensaje)."</strong><br/>";

            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "ssl";
            $mail->Host       = "smtp.gmail.com"; // sets the SMTP server
            $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
            $mail->Username   = "formulario@coleccionbelair.com"; // SMTP account username
            $mail->Password   = "uvgo rond qngg dnrn";        // SMTP account password

            $mail->SetFrom($email, $nombre.' '.$apellido);
            
            $mail->Subject    = "Formulario de Dreams Wedding " . $origen;

            $mail->MsgHTML($body);
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $address = "info@dreams-wedding.com.mx";
            $mail->AddAddress($address, "info bodas");

            //copia de correo a...
            // $mail->AddCC("mktmanager@dreams-wedding.com.mx", "mktmanager");
            // $mail->AddCC("gerencia@dreams-wedding.com.mx", "Norma");
            // $mail->AddCC("web@eze-trip.com", "Webmaster");
            // $mail->AddCC("auxwe@coleccionbelair.com", "auxiliar web");
            // $mail->AddCC("gerenciaoperaciones@eze-trip.com", "gerencia operaciones");
            // $mail->AddCC("mktmanagerbts@gmail.com", "mktmanager bts");
            // $mail->AddCC("mkt@coleccionbelair.com", "Vero");
            // $mail->AddCC("gteestrategia@itrip.mx", "Gerente Estrategia");
            $mail->AddCC("auxweb@coleccionbelair.com", "");
    
            if (!$mail->Send()) {
                $mensaje = 'Ocurrió un error, por favor, intentalo de nuevo';
            } else {
                $mensaje = 'Mensaje Enviado.';
            }
        } else {
            $mensaje = 'Todos los campos son requeridos.';
        }
    } else {
        $mensaje = 'Ocurrió un error, estás por debajo del 60% de probabilidad de que seas humano.';
    }
} else {
    $mensaje = 'Ocurrió un error, por favor, verifica tu conexión a Internet e intentalo de nuevo.';
}
?>
    
    <script>
        <?php
        echo 'alert("' . $mensaje . '");';
        echo 'window.location= "'.$url_retorno.'";'; 
        ?>
    </script>