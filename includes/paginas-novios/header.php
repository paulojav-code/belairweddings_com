<!DOCTYPE HTML>
<html lang="<?php echo $datos_json['html_lan']; ?>">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': 
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WCRPVVP');</script>
    <!-- End Google Tag Manager -->

	<title><?php echo $novie_1 . ' ' . $conector . ' ' . $novie_2; ?> - Dreams Wedding</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo $dominio; ?>assets/css/paginas-novios/main.css" />
	<link rel="stylesheet" href="<?php echo $dominio; ?>assets/css/paginas-novios/modal.css" />
	<link rel="stylesheet" href="<?php echo $dominio; ?>assets/js/owl-carousel/assets/owl.carousel.css">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $dominio; ?>assets/img/logos/dreams-wedding_favicon.ico">
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
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCRPVVP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
	