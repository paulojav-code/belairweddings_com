<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WCRPVVP');</script>
        <!-- End Google Tag Manager -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="<?php echo $descripcionPag; ?>">
        <meta name="keywords" content="<?php echo $keywords; ?>">
        <link rel=”canonical” href="<?php echo $canonical; ?>"/> 
        <link rel="shortcut icon" type="image/x-icon" href="https://dreams-wedding.com.mx/assets/img/logos/dreams-wedding_favicon.ico">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title><?php echo $tituloPag; ?></title>
        <script src='https://www.google.com/recaptcha/api.js?render=6LfSGKIUAAAAAPq5Ca3FYOi4w-LzWOz0XSQGx29b'></script>
<?php if($folder != 'blog'){?>
        <script defer>
            grecaptcha.ready(function() {
                grecaptcha.execute('6LfSGKIUAAAAAPq5Ca3FYOi4w-LzWOz0XSQGx29b', {
                    action: 'pagina_LBDTS'
                }).then(function(token) {
                    var recaptchaResponse = document.getElementById('recaptchaResponse');
                    recaptchaResponse.value = token;
                });
            });
        </script>    
<?php
}
?>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">