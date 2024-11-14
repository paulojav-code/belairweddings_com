<!DOCTYPE HTML>
<html lang="<?php echo $datos_json['html_lan']; ?>">
<head>

	<title><?php echo $titulo; ?> - Crowne Plaza Detroit</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo $ruta_raiz; ?>assets/css/paginas-novios/main-grupo.css" />
	<link rel="stylesheet" href="<?php echo $ruta_raiz; ?>assets/css/paginas-novios/modal.css" />
	<link rel="stylesheet" href="<?php echo $ruta_raiz; ?>assets/js/owl-carousel/assets/owl.carousel.css">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $ruta_raiz; ?>assets/img/logos/dreams-wedding_favicon.ico">
	<script src='https://www.google.com/recaptcha/api.js?render=6LcYChIaAAAAAH_sztDG5vFPw1lK_w8tHdysHJcD'></script>
	<script>
		grecaptcha.ready(function() {
			grecaptcha.execute('6LcYChIaAAAAAH_sztDG5vFPw1lK_w8tHdysHJcD', {
					action: 'pagina_novios'
				})
				.then(function(token) {
					var recaptchaResponse = document.getElementById('recaptcha_response');
					recaptchaResponse.value = token;

					var recaptchaResponse_com = document.getElementById('recaptcha_response_com');
					recaptchaResponse_com.value = token;
				});
		});
	</script>
</head>
<body class="landing is-preload">