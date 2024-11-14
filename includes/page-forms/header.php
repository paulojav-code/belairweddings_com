<?php
    $idioma = isset($idioma) ? $idioma : 'es';
    $datos_json_pre = file_get_contents( $idioma=='en' && $folder[0]!='inicio'?$folder[1].'../includes/json/datos_' . $idioma . '.json':$folder[1].'includes/json/datos_' . $idioma . '.json');
    $datos_json     = json_decode($datos_json_pre, true);
    $contacto = isset($contacto) ? $contacto : true;
?>
<!DOCTYPE HTML>
<!--
-->
<html lang="<?php echo $datos_json['html_lan']; ?>">

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': 
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WCRPVVP');</script>
    <!-- End Google Tag Manager -->
    
    <?php include_once('metas.php');  ?>
</head>

<body class="is-preload">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCRPVVP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->