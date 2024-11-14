<section class="container formulario py-5 mb-3" id="formularioContacto">
    <div class="container px-4 py-lg-5 formularioContacto">
        <?php 
        if(isset($luna_miel)){
            $titulo_cotizado = 'Luna de Miel';
        }else if(isset($despedida)){
            $titulo_cotizado = 'Despedida';
        }else{
            $titulo_cotizado = 'Boda';
        }
        ?>
        <h3 class="text-center text-uppercase text-muted titulo pt-2" style="font-size:1.5em">Contáctanos y cotiza tu <?php echo $titulo_cotizado; ?></h3>
        <hr class="nosotros">
        <form class="nobottommargin" id="template-contactform" name="template-contactform" action="https://dreams-wedding.com.mx/cotiza-bodas.php" method="post">
            <div class="row" style="<?php echo (!isset($despedida)?'margin-right:1px':'') ?>">
                <div class="form-group text-center <?php echo (isset($id_destino)?'col-12':'col-lg-6')?>"><label for="template-contactform-name" class="text-uppercase text-center text-muted">Nombre(s)*</label><input type="text" id="template-contactform-name" onkeyup="textsOnly(this)" name="template-contactform-name" value="" class="form-control required text-muted" required style="background-color:#EBEBEB!important;color:#444E50!important;" /></div>
                <div class="form-group text-center <?php echo (isset($id_destino)?'col-12':'col-lg-6')?>"><label for="template-contactform-apellido" class="text-uppercase text-center text-muted">Apellido(s)*</label><input type="text" id="template-contactform-apellido" onkeyup="textsOnly(this)" name="template-contactform-apellido" value="" class="form-control required" required style="background-color:#EBEBEB!important;color:#444E50!important;" /></div>
                <div class="form-group text-center <?php echo (isset($id_destino)?'col-12':'col-lg-6')?>"><label for="template-contactform-email" class="text-uppercase text-center text-muted">E-mail*</label><input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email form-control" required style="background-color:#EBEBEB!important;color:#444E50!important;" /></div>
                <div class="form-group text-center <?php echo (isset($id_destino)?'col-12':'col-lg-6')?>"><label for="template-contactform-phone" class="text-uppercase text-center text-muted">Teléfono (10 digitos)*</label><input type="text" id="template-contactform-phone" onkeyup="numbersOnly(this)" name="template-contactform-phone" value="" class="form-control" required style="background-color:#EBEBEB!important;color:#444E50!important;" /></div>
                <div class="form-group text-center col-12"><label for="template-contactform-asunto" class="text-uppercase text-center text-muted">Asunto*</label><input type="text" id="template-contactform-asunto" name="template-contactform-asunto" onkeyup="textsOnly(this)" value="" class="form-control required" required style="background-color:#EBEBEB!important;color:#444E50!important;" /></div><input type="hidden" name="origen" value="<?php echo $origen; ?>">
                <div class="clear"></div>
                <div class="form-group text-center col-12"><label for="template-contactform-message" class="text-uppercase text-center text-muted">Mensaje*</label><textarea class="required form-control" id="template-contactform-message" name="template-contactform-message" onkeyup="textsOnly(this)" placeholder="Escribe tu mensaje..." rows="6" cols="30" required></textarea></div>
                <div class="d-none"><input type="hidden" name="recaptcha_response" id="recaptchaResponse"></div>
                <div class="form-group text-center col-12"><button class="btn btn-lg bg-verde" type="submit" name="submit" id="<?php echo $idBoton; ?>" value="submit">Enviar Mensaje</button></div>
            </div>
        </form>
    </div>
    <?php 
    if(isset($descarga_form) == true || $descarga_form == 1){
    ?>
    <div class="descarga d-none d-lg-block">
        <div class="descargaGuia text-center">
            <iframe aria-label="Descarga la guía de bodas de Dreams Wedding" width="350" height="400" src="https://0ab348ae.sibforms.com/serve/MUIEALi7L0x2-x0TV-tqez604_unMpz60ZSg1BZQrxSQvDTBQgpdneGGrGID7Fpn61vmVMXyl421MWqlV5UNePvF6UU6QuCxiR0ogxmT7NFySAhBoXIK9v335jf3R-EmgcXy59LMj82r0JKAovzrdUQmUZAHb0056M890aHd0yImEhYOeKHGOGzr3Tyub4rUJ3YjKdz2yU0YVEr7" frameborder="0" scrolling="auto" allowfullscreen style="display:block;margin-left:auto;margin-right:auto;max-width:100%;"></iframe>
        </div>
    </div>
    <?php
    }
    if(isset($luna_miel)){
    ?> 
    <div class="text-center pt-5">
        <h5>"VIVE UNA <span class="text-verde text-center font-weight-bold">LUNA DE MIEL DE ENSUEÑO</span>"</h5>
    </div>
    <?php
    }
    ?>
</section>
<script src="<?php echo URL; ?>/assets/js/validador-correo.js" async></script>