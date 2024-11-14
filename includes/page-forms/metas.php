<title><?php echo ($titulo != 'Inicio' ? $titulo . ' | ':'') .  $datos_json['html_title']; ?></title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="<?php echo URL ?>/assets/css/main.css" />
<link rel="stylesheet" href="<?php echo URL ?>/assets/css/color.css" />
<link rel="stylesheet" href="<?php echo URL ?>/assets/css/header.css" />
<link rel="shortcut icon" type="image/svg+xml" href="<?php echo URL ?>/assets/img/logos/LOGOTIPOS_B.svg">
<?php
    if($folder[0] == 'inicio') {
        echo '<link rel="stylesheet" href="'. URL . '/assets/css/modal.css" />';
    }
	if($folder[0] == 'lbdts' || $folder[0] == 'servicios') {
		echo '<link rel="stylesheet" href="'. URL . '/assets/css/servicios.css" />';
	}
    if($folder[0] == 'lbdts') {
        echo '<link rel="stylesheet" href="'. URL . '/assets/css/rows.css" />';
    }
    if($folder[0] == 'blog') {
        echo '<link rel="stylesheet" href="'. URL . '/assets/css/blog.css" />';
        echo '<link rel="stylesheet" href="'. URL . '/assets/css/modal.css" />';
        //echo '<meta property="og:title" content="'.$titulo.'">';
        //echo '<meta property="og:description" content="'..'">';
        echo '<meta property="og:image" content="'.URL . '/' . $array_data[0]['imagen'].'">';
    }
    if($folder[0] == 'promociones') {
        echo '<link rel="stylesheet" href="'. URL . '/assets/css/blog.css" />';
        echo '<link rel="stylesheet" href="'. URL . '/assets/css/modal.css" />';
    }
?>
<noscript><link rel="stylesheet" href="<?php echo URL ?>/assets/css/noscript.css" /></noscript>
<script src='https://www.google.com/recaptcha/api.js?render=6LcYChIaAAAAAH_sztDG5vFPw1lK_w8tHdysHJcD'></script>
<script defer>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcYChIaAAAAAH_sztDG5vFPw1lK_w8tHdysHJcD', {
                action: 'pagina_dreams_wedding'
            }).then(function(token) {
                var recaptchaResponse = document.getElementById('recaptcha_response');
                recaptchaResponse.value = token;
            });
        });
</script>