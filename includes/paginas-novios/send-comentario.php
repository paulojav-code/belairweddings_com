<?php
include_once('../classes/class.phpmailer.php');
include_once("../classes/class.smtp.php");

include_once('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	$recaptcha_secret = '6LcYChIaAAAAAKqpKpU5BfXBZAp8zgPprqBcWlyi';
	$recaptcha_response = $_POST['recaptcha'];

	$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
	$recaptcha = json_decode($recaptcha);

	if ($recaptcha->score >= 0.0) {
		$parentesco   	= strip_tags($_POST["parentesco"]);
		$mensaje   	= strip_tags($_POST["mensaje"]);
        $nombre_novies  = strip_tags($_POST["novies"]);
		$id_novie  = strip_tags($_POST["clave_novie"]);
		$correos_copias = strip_tags($_POST["copias"]);
		$correos_copias = explode(',',$correos_copias);

		if(!empty($mensaje)) {
			$mail             = new PHPMailer();
			$body             = $umsg;
			$body             = strip_tags($umsg);

			$mail->IsSMTP();

			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host       = "smtp.gmail.com";
			$mail->Port       = 465;
			$mail->Username   = "formulario@coleccionbelair.com";
			$mail->Password   = "!QuestioNWeB2019$";

			$mail->SetFrom('formulario@coleccionbelair.com', 'Admin Bodas');
			$mail->Subject    = utf8_decode("Comentario para novios " . $nombre_novies);

			$body = "<strong>El comentario para los novios:</strong><br/> Parentesco: " . $parentesco . "<br/> Mensaje: " . $mensaje;

			$mail->MsgHTML($body);
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->AddAddress($ejecutivo, "Ejacutivo");

			$mail->AddCC("web@eze-trip.com","Webmaster");
			
			for ($i=0; $i < count($correos_copias); $i++) { 
				$mail->AddCC($correos_copias[$i]);
			}

			$sql = 'INSERT INTO admin_bodas.comentarios (id_novie, nombre, mensaje, fecha_envio, activo) VALUES (?,?,?,NOW(),0)';
			$stmt = $con->prepare($sql);
			$stmt->bind_param("iss", $id_novie, $parentesco, $mensaje);
			
			if ($stmt->execute()) {
				if ($mail->Send()) {
					echo '4';
				} else {
					echo '6';
				}
			} else {
				echo '6';
			}
		}else {
            echo '5';
		}
	} else {
		echo '3';
	}
}
