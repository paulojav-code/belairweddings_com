<?php $return = $idioma == 'es'?'../':'../../'?>
<div class="mdform" id="myModal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <!-- <form>
            <div class="row gtr-50 gtr-uniform">
                <div class="col-12">
                    <h2>Contáctanos</h2>
                </div>
                <div class="col-6 col-12-narrow">
                    <label for="">Nombre(s):</label>
                    <input type="text" name="formulario_nombre" id="formulario_nombre" placeholder="" />
                </div>
                <div class="col-6 col-12-narrow">
                    <label for="">Apellido(s):</label>
                    <input type="text" name="formulario_apellido" id="formulario_apellido" placeholder="" />
                </div>
                <div class="col-6 col-12-narrow">
                    <label for="">Correo:</label>
                    <input type="email" name="formulario_email" id="formulario_email" placeholder="" />
                </div>
                <div class="col-6 col-12-narrow">
                    <label for="">Telefono(10 dígitos):</label>
                    <input type="text" name="formulario_telefono" id="formulario_telefono" placeholder="" />
                </div>
                <div class="col-12">
                    <label for="">Mensaje:</label>
                    <textarea name="formulario_mensaje" id="formulario_mensaje" cols="30" rows="3"></textarea>
                </div>
                <input type="hidden" name="recaptcha_response" id="recaptcha_response">
                <input type="hidden" name="formulario_origen" id="formulario_origen" value="">
                <input type="hidden" name="formulario_titulo" id="formulario_titulo">
                <div class="col-12" style="text-align: center;">
					<a type="submit" id="formulario_promocion_enviar" class="button" style="background: #A32135;">Enviar mensaje</a>
                </div>
            </div>
        </form> -->

        <div class="span-3-25">
			<form method="post" action="<?php echo $return; ?>includes/php/send_buenfin.php">
            <input type="hidden" name="idioma" value="<?= htmlspecialchars($idioma)?>">
            <h2>Contáctanos</h2>
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
                <input type="hidden" name="recaptcha_response" id="recaptcha_response" />
                <input type="hidden" name="formulario_dw_origen" id="formulario_dw_origen" />
                <input type="hidden" name="formulario_titulo" id="formulario_titulo">
				<ul class="actions">
					<li><input id="formulario_dw_boton_enviar" type="submit" value="<?php echo $datos_json['contacto_enviar']; ?>" class="pretty" /></li>
				</ul>

			</form>
		</div>
    </div>
</div>
