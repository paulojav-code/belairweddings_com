<?php
	$return = $idioma == 'es'?'':'../';
    include_once($return.'includes/page-forms/formulario.php');
	if($contacto){
?>
<!-- Panel -->
<section class="panel color1" id="pre-fifth">
    <div class="intro span-1-5">
        <h2 class="major"><?php echo $datos_json['contacto_titulo']; ?></h2>
        <br>
        <button id="boton_open_formulario"><?= $datos_json['contacto_button']; ?></button>
    </div>
</section>
<script>
    document.querySelector(`#boton_open_formulario`).addEventListener('click',function(){
        openForm({
            source:`Home<?= $idioma == 'en'? ' EN':'' ?>`,
            move:true,
            copies:`mktmanagerbts@gmail.com,gerencia@dreams-wedding.com.mx,mktmanager@dreams-wedding.com.mx`});
    });
</script>
<?php
	}
?>

<!-- Panel -->
<section class="panel color3" id="fifth">
    <div class="inner columns divided">
        <?php
			if($contacto){
		?>
        <!-- <div class="span-3-25">
            <form method="post" action="<?php echo $return; ?>includes/php/send.php">
                <input type="hidden" name="idioma" value="<?= htmlspecialchars($idioma)?>">
                <div class="fields">
                    <div class="field">
                        <label for="name"><?php echo $datos_json['contacto_nombre']; ?></label>
                        <input type="text" name="formulario_dw_nombre" id="formulario_dw_nombre" />
                    </div>
                    <div class="field">
                        <label for="name"><?php echo $datos_json['contacto_apellido']; ?></label>
                        <input type="text" name="formulario_dw_apellido" id="formulario_dw_apellido" />
                    </div>
                    <div class="field half">
                        <label for="name"><?php echo $datos_json['contacto_telefono']; ?></label>
                        <input type="text" name="formulario_dw_telefono" id="formulario_dw_telefono" />
                    </div>
                    <div class="field half">
                        <label for="email"><?php echo $datos_json['contacto_correo']; ?></label>
                        <input type="email" name="formulario_dw_email" id="formulario_dw_email" />
                    </div>
                    <div class="field">
                        <label for="message"><?php echo $datos_json['contacto_mensaje']; ?></label>
                        <textarea name="formulario_dw_mensaje" id="formulario_dw_mensaje" rows="4"></textarea>
                    </div>
                </div>
                <ul class="actions">
                    <li><div class="h-captcha" data-sitekey="be240d90-e718-4480-abbc-e71e600ecdd6"></div></li>
                    <li><input type="hidden" name="formulario_dw_origen" id="formulario_dw_origen"/></li>
                    <li><input id="formulario_dw_boton_enviar" type="submit" value="<?php echo $datos_json['contacto_enviar']; ?>" class="pretty"/></li>
                </ul>
            </form>
        </div> -->
        <?php
			}
		?>
        <div class="span-1-75">
            <h2 class="major"><?php echo $datos_json['footer_title']; ?></h2>
            <p><?php echo $datos_json['footer_direccion']; ?></p>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1866.4316716612727!2d-103.376351!3d20.675138!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428ae1200a4f317%3A0x9ec86da441dcea43!2sCalle%20Juan%20Ruiz%20de%20Alarc%C3%B3n%208%2C%2044160%20Guadalajara%2C%20Jal.!5e0!3m2!1ses!2smx!4v1607099306323!5m2!1ses!2smx"
                width="300" height="150" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                tabindex="0"></iframe>
            <ul class="contact-icons">
                <?php
				for ($i=0; $i < count($datos_json['footer_telefonos']); $i++) { 
					echo '<li>'.$datos_json['footer_telefonos'][$i].'</li>';
				}
			?>
            </ul>
            <ul class="contact-icons">
				<?= $datos_json["html_lan"] == "en" ? "" : '<li class="icon brands fa-whatsapp"><a href="'.$whatsapp_url.'" target="blank">'.$datos_json["telefono_footer"].'</a></li>' ?>
                <li class="icon solid fa-envelope"><a href="mailto:<?= $email ?>"><?= $email ?></a></li>
                <li class="icon brands fa-facebook-f"><a href="<?= $facebook_url ?>">belairdreamsweddingmx</a></li>
                <li class="icon brands fa-instagram"><a href="<?= $instagram_url ?>">@belairdreamsweddingmx</a></li>
                <!--<li class="icon brands fa-twitter"><a href="https://twitter.com/dreamsweddingmx/">@dreamsweddingmx</a></li>-->
            </ul>
        </div>
    </div>
    <div class="intro color4">
        <img src="<?php echo URL ?>/assets/img/logos/LOGOTIPOS_belair-dreams-wedding.png" alt="" class="logo">
        <ul>
            <li>Copyrights&copy; Dreams Wedding by <br><i>Thy Collection <?= date('Y') ?></i></li>
            <li><i><a
                        href="<?php echo URL . '/' . $datos_json['footer_terminos_url'] ?>"><?php echo $datos_json['footer_terminos']; ?></a></i>
            </li>
            <li><i><?php echo $datos_json['footer_empresa']; ?></i></li>
        </ul>
        <a href="https://itrip.mx"><img src="<?php echo URL ?>/assets/img/logos/itrip_bco-2-small.png" alt=""
                class="logo sty2"></a>
    </div>
</section>