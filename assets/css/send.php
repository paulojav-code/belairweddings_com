<?php
require_once('../classes/class.phpmailer.php');
include_once("../classes/class.smtp.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	$recaptcha_secret = '6LcYChIaAAAAAKqpKpU5BfXBZAp8zgPprqBcWlyi';
	$recaptcha_response = $_POST['recaptcha'];

	$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
	$recaptcha = json_decode($recaptcha);

	if ($recaptcha->score >= 0) {
		$asistencia   	= strip_tags($_POST["asistencia"]);
		$nombre       	= strip_tags($_POST["nombre"]);
		$apellido     	= strip_tags($_POST["apellido"]);
		$nombre2      	= strip_tags($_POST["nombre2"]);
		$apellido2    	= strip_tags($_POST["apellido2"]);
		$email        	= strip_tags($_POST["email"]);
		$telefono       = strip_tags($_POST["telefono"]);
		$ceremonia    	= strip_tags($_POST["ceremonia"]);
		$adultos      	= strip_tags($_POST["adultos"]);
		$ninhos       	= strip_tags($_POST["ninhos"]);
		$juniors      	= strip_tags($_POST["juniors"]);

		$ejecutivo      = strip_tags($_POST["ejecutivo"]);
		$nombre_novies  = strip_tags($_POST["novies"]);
		$correos_copias = strip_tags($_POST["copias"]);
        echo $correos_copias;
		$correos_copias = explode(',',$correos_copias);

		if(!empty($asistencia)) {
			if(!empty($nombre) || !empty($apellido) || !empty($email) || ($asistencia == 1 && !empty($ceremonia)) ) {
				$mail             = new PHPMailer();

				$mail->IsSMTP();

				$mail->SMTPAuth   = true;
				$mail->SMTPSecure = "ssl";
				$mail->Host       = "smtp.gmail.com";
				$mail->Port       = 465;
				$mail->Username   = "formulario@coleccionbelair.com";
				$mail->Password   = "!QuestioNWeB2024$";

				$mail->SetFrom($email, $nombre . ' ' . $apellido);
				$mail->Subject    = "Confirmación de Asistencia a Boda de " . $nombre_novies;

				if($asistencia == 1){
					switch($ceremonia){
						case 1: 
							$ceremonia_name = 'Ceremonia';
							break;
						case 2: 
							$ceremonia_name = 'Recepción';
							break;
						case 3:
							$ceremonia_name = 'Ceremonia y Recepción';
							break;
						default:
							break;
					}
					$body = "Nombre invitado: <strong>" . $nombre . " " . $apellido . "</strong><br/>";
					$body .= "Nombre acompañante: <strong>" . $nombre2 . " " . $apellido2 . "</strong><br/>";
					$body .= "Email: <strong>" . $email . "</strong><br/>";
					$body .= "Telefono: <strong>" . $telefono . "</strong><br/>";
					$body .= "¿Asistiré?: <strong>Si</strong><br/>";
					$body .= "Evento: <strong>" . $ceremonia_name . "</strong><br/>";
					$body .= "¿Cuantos adultos?: <strong>" . $adultos . "</strong><br/>";
					$body .= "<strong>" . $juniors . "</strong> Juniors y <strong>" . $ninhos . "</strong> niños";
				}else{
					$body = "Nombre: <strong>" . $nombre . " " . $apellido . "</strong><br/>";
					$body .= "Email: <strong>" . $email . "</strong><br/>";
					$body .= "¿Asistiré?: <strong>No</strong><br/>";
				}

				$mail->MsgHTML($body);
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				//$mail->AddAddress($ejecutivo, "Ejacutivo");
				$mail->AddAddress("web@eze-trip.com","Webmaster");
				// $mail->AddAddress("reservaciones@dreams-wedding.com.mx","Reservaciones");

				// $mail->AddCC("web@eze-trip.com","Webmaster");
				
				for ($i=0; $i < count($correos_copias); $i++) { 
					if($correos_copias[$i] != ''){
						$mail->AddCC($correos_copias[$i],'Copia '.($i + 1));
					}
				}

				if ($mail->Send()) {
					echo '0';
				} else {
					echo '2';
				}
			}else{
				echo '1';
			}
		}else {
			echo '1';
		}
	} else {
		echo '3';
	}
}
