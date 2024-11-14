<!-- Footer -->
<footer id="footer">
			<div class="container large">
				<div class="row aln-center">
					<div class="col-4 col-12-mobile">
						<h2><?php echo $datos_json['footer_1']; ?></h2>
						<a href="<?php echo $ruta_raiz; ?>" class="logo"><img src="<?php echo $ruta_raiz; ?>assets/img/logos/logo-dw-bco.png" alt="Logo Dreams Wedding Blanco"></a>
						<a href="<?php echo $ruta_raiz; ?>"><?php echo $datos_json['footer_2']; ?></a>
					</div>
					<div class="col-4 col-12-mobile">
						<h2><?php echo $datos_json['footer_3']; ?></h2>
						<div class="tarjetas">
							<ul class="icons">
								<li><img src="<?php echo $ruta_raiz; ?>assets/img/paginas-novios/visa.png" alt="tarjetas visa"></li>
								<li><img src="<?php echo $ruta_raiz; ?>assets/img/paginas-novios/mastercard.png" alt="tarjetas mastercard"></li>
								<li><img src="<?php echo $ruta_raiz; ?>assets/img/paginas-novios/american-express.png" alt="tarjetas american express"></li>
							</ul>
						</div>
						<h2><?php echo ($clave_evento != '') ? $datos_json['footer_5'].' '.$clave_evento : '' ?></h2>
					</div>
					<div class="col-4 col-12-mobile">
						<h4><?php echo $datos_json['footer_4']; ?></h4>
						<ul class="datos">
							<li><?php echo $ejecutive; ?></li>
							<?php
								if($ejecutive_correo != ''){
									echo '<li>'.$ejecutive_correo.'</li>';
								}
								if($ejecutive_telefono != ''){
									echo '<li><a href="tel:'.$ejecutive_call.'">'.$ejecutive_telefono.'</a></li>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</footer>

	</div>

	<!-- Scripts -->
		<script src="<?php echo $dominio; ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo $dominio; ?>assets/js/jquery.dropotron.min.js"></script>
		<script src="<?php echo $dominio; ?>assets/js/jquery.scrollex.min.js"></script>
		<script src="<?php echo $dominio; ?>assets/js/browser.min.js"></script>
		<script src="<?php echo $dominio; ?>assets/js/breakpoints.min.js"></script>
		<script src="<?php echo $dominio; ?>assets/js/paginas_novios/util.js"></script>
		<script src="<?php echo $dominio; ?>assets/js/paginas_novios/main.js"></script>
		<script src="<?php echo $dominio; ?>assets/js/owl-carousel/owl.carousel.js"></script>
		<script>
			const countDownDate = new Date("<?php echo $fecha_timer; ?>").getTime();
			
			const respuestas_alertas = {
				'0' : ['¡Nos vemos en el gran día!','Muchas gracias por confirmar tu asistencia a la boda de <b><?php echo $novie_1 . ' ' . $conector . ' ' . $novie_2; ?></b>, a partir <br>de este momento nuestros ejecutivos se encargarán del registro y seguimiento <br>de tu reservación. Si tienes alguna pregunta no dudes en comunicarte con <br>nosotros, estaremos encantados de ayudarte.<br><br><i><b>Atentamente: Dreams Wedding</b></i>','1'],
				'1' : ['Falta información','Recuerda que debes llenar todos los campos para confirmar <br>tu asistencia, por favor inténtelo de nuevo.','0'],
				'2' : ['Ocurrió un error','Lo sentimos, tu asistencia no pudo confirmarse, <br>por favor inténtelo de nuevo.','0'],
				'3' : ['Identidad no valida','Ocurrió un error y no hemos podido validar si eres humano, <br>por favor inténtelo de nuevo','0'],
				'4' : ['¡Muchas gracias por tus palabras!','En breve le haremos llegar tu mensaje a nuestros queridos novios.','1'],
				'5' : ['Falta información','Recuerda que debes llenar todos los campos para enviar <br>tu comentario, por favor inténtelo de nuevo.','0'],
				'6' : ['Ocurrió un error','Lo sentimos, tu comentario no pudo enviarse, <br>por favor inténtelo de nuevo.','0'],
			};

			var galeria = [
			<?php
				if(isset($img_novie_default) && $img_novie_default){
					$index_galeria = 1;
				}else{
					$index_galeria = 0;
				}
				for ($i = $index_galeria; $i <= $novie_galeria; $i++) { 
					echo "'".$ruta_img . $i . ".jpg',";
				}
			?>
			];

			set_date_timer();
			var x = setInterval(function() { set_date_timer() }, 1000);

			function mostrar_alerta(id) {
				if(respuestas_alertas[id][2] == 1) {
					$('#modal-alerta img').attr("src","<?php echo $ruta_raiz.'assets/img/paginas-novios/'; ?>icono-confirmacion-aprovada.png");
				}else {
					$('#modal-alerta img').attr("src","<?php echo $ruta_raiz.'assets/img/paginas-novios/'; ?>icono-confirmacion-denegada.png");
				}
				$('#modal-alerta h2').html(respuestas_alertas[id][0]);
				$('#modal-alerta p').html(respuestas_alertas[id][1]);

				modal('#modal-alerta');
			}

			function enviar_comentario() {
				var dataString = "parentesco=" + $('#parentesco').val() + "&mensaje=" + $('#mensaje').val() + "&recaptcha=" + $('#recaptcha_response_com').val() +
					"&ejecutivo=<?php echo $ejecutive_correo_dw; ?>&copias=<?php echo $ejecutive_correo.','.$correo_copia; ?>&novies=<?php echo $novie_1 . ' ' . ($conector == '&' ? 'y' : $conector) . ' ' . $novie_2; ?>&clave_novie=<?php echo $id_novie; ?>";

				$.ajax({
					data: dataString,
					url: '<?php echo $ruta_pagina; ?>paginas-novios/send-comentario.php',
					type: 'POST',
					success: function(response) {
						mostrar_alerta(response);
					},
					error: function(response, status, error) {
						console.log('Error: Data no encontrada');
					}
				});
			}

			function enviar_confirmacion() {
				var dataString = "asistencia=" + $('#asistencia').val() + "&nombre=" + $('#nombre').val() + "&apellido=" + $('#apellido').val() + "&nombre2=" + $('#nombre2').val() + "&apellido2=" + $('#apellido2').val() + "&email=" + $('#email').val() + "&telefono=" + $('#telefono').val() +
					"&ceremonia=" + $('#ceremonia').val() + "&adultos=" + $('#adultos').val() + "&ninhos=" + $('#ninhos').val() + "&juniors=" + $('#juniors').val() + "&recaptcha=" + $('#recaptcha_response').val() +
					"&ejecutivo=<?php echo $ejecutive_correo_dw; ?>&novies=<?php echo $novie_1 . ' ' . ($conector == '&' ? 'y' : $conector) . ' ' . $novie_2; ?>&copias=<?php echo $ejecutive_correo.','.$correo_copia; ?>";

				$.ajax({
					data: dataString,
					url: '<?php echo $ruta_pagina; ?>paginas-novios/send.php',
					type: 'POST',
					success: function(response) {
						mostrar_alerta(response);
					},
					error: function(response, status, error) {
						console.log('Error: Data no encontrada');
					}
				});
			}

			function reservar(hotel, token = null, checkin = null, checkout = null) {
				var url = "https://dreams-wedding.com.mx/wbe/ratecode.aspx";
					form = $('<form name="frmMain" method="post" action="' + url + '" target="_blank" style="display:none">' +
						'<div><input type="text" id="hotel" name="hotel" value="' + hotel + '" /></div>' +
						'<div><input type="text" id="token" name="token" value="' + token.substr(0,50) + '" /></div>' +
						'<div><input type="text" id="checkin" name="checkin" value="' + checkin + '" /></div>' +
						'<div><input type="text" id="checkout" name="checkout" value="' + checkout + '" /></div>' +
						'<div><input type="text" id="adult" name="adult" value="2" /></div>' +
						'<div><input type="text" id="rooms" name="rooms" value="1" /></div>' +
						'<div><input type="text" id="currency" name="currency" value="<?php echo $datos_json['currency']; ?>" /></div>' +
						'<div><input type="text" id="language" name="language" value="<?php echo $datos_json['language']; ?>" /></div>' +
						'<div><input type="text" id="dateFormat" name="dateFormat" value="<?php echo $datos_json['date_format']; ?>" /></div>' +
						'<div><input type="text" id="showDeadLine" name="showDeadLine" value="S" /></div>' +
						'<div><input type="text" name="callMode" value="normal"/></div>' +
						'<div><input type="text" name="firstLoad" value="s"/></div>' +
						'</form>');

				$('body').append(form);
				form.submit();
			}

			$("#carousel-hotel").owlCarousel({
				items: 1,
				dots: false,
				loop: true,
				lazyLoad: true,
				autoplay: true,
				autoplayTimeout: 6000,
				autoplaySpeed: 1500,
			});
			$("#carousel-destino").owlCarousel({
				items: 3,
				dots: false,
				loop: true,
				lazyLoad: true,
				autoplay: true,
				autoplayTimeout: 8000,
				autoplaySpeed: 1500,
				responsive: {
					0: {
						items: 1
					},
					480: {
						items: 3
					},
				}
			});
			if(galeria.length > 0){
				$("#carousel-novies").owlCarousel({
					items: 3,
					dots: false,
					loop: true,
					lazyLoad: true,
					autoplay: true,
					autoplayTimeout: 8000,
					autoplaySpeed: 1500,
					responsive: {
						0: {
							items: 1
						},
						480: {
							items: 3
						},
					}
				});
			}
		</script>