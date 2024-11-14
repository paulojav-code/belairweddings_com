<?php
	
	include_once('../includes/php/variables.php');
	include_once('../includes/php/conexion.php');
	include_once('../includes/php/config.php');
	include_once('../includes/wabutton.php');

	$titulo = 'La boda de tus sueños';
	$folder = ['lbdts','../'];

	$json_raw = file_get_contents('../includes/json/lbdts.json');
	$json_raw = preg_replace("/[\r\n|\n|\r]+/",'', $json_raw);
	$data_lbdts = json_decode($json_raw,TRUE);

	$destinos_php = $data_lbdts['destinos'];
	$contenido_php = $data_lbdts['contenido'];

	$destinos_index = 0;
	$hoteles_index = 0;

	for ($i=0; $i < count($destinos_php); $i++) {
		if(isset($_GET[$destinos_php[$i]['var']])){
			$destinos_index = $i;
			for ($j=0; $j < count($destinos_php[$destinos_index]['hoteles']); $j++) { 
				if(isset($_GET[$destinos_php[$destinos_index]['hoteles'][$j]['var']])){
					$hoteles_index = $j;
				}
			}
		}
	}

	include_once('../includes/page-forms/header.php');
?>
		<!-- Page Wrapper -->
			<div id="page-wrapper">

                <!-- Navbar -->
                    <?php include_once('../includes/page-forms/navbar.php'); ?>

				<!-- Wrapper -->
					<div id="wrapper">

						<!-- Panel (Banner) -->
							<section id="titulo-bdts" class="panel spotlight large left">
								<div class="content span-6">
									<h2 class="major">La boda de tus <span class="font-anitto">sueños</span></h2>
									<h3 class="major">Reserva un mínimo de habitaciones en plan All Inclusive y te regalamos la ceremonia de tu boda en la playa</h3>
									<a href="#lista-destinos">¿En qué destino te quieres casar?</a>
								</div>
								<div class="image filtered tinted" data-position="left">
									<img src="<?php echo URL ?>/assets/img/lbdts/la_boda_de_tus_suenos_banner.jpg" alt="" />
								</div>
							</section>

							<section class="panel color0">
								<div class="intro span-2-5" id="descripcion">
									<h4>Llegó el momento de dar el “sí” frente al mar</h4>
									<p>En Dreams Wedding tenemos el objetivo de ayudarles a las parejas a celebrar la boda que siempre imaginaron, por eso creamos el paquete La Boda de Tus Sueños, con el que haremos realidad su sueño de casarse en la playa.</p>
								</div>
								<div class="intro span-3-25" id="contenido">
									<h3>¿En qué consiste La Boda De Tus Sueños?*</h3>
									<ul class="lista-contenido">
										<?php
											for ($i=0; $i < count($contenido_php); $i++) {
												echo '<li>';
												echo '<a>'.$contenido_php[$i]['nombre'].'</a><ul>';
												for ($j=0; $j < count($contenido_php[$i]['puntos']); $j++) { 
													echo '<li>'.$contenido_php[$i]['puntos'][$j].'</li>';
												}
												echo '</ul></li>';
											}
										?>
									</ul>
									<p>*Algunos hoteles pueden variar los productos ofrecidos, comunícate con un ejecutivo para mayor información.</p>
								</div>
								<div class="intro span-2-25" id="lista-destinos">
									<ul>
										<?php
											for ($i=0; $i < count($destinos_php); $i++) { 
												echo '<li><a id="boton-destino-'.$i.'" href="#lista-hoteles" onclick="show_hoteles('.$i.')" '.($i == $destinos_index? 'class="active"':'').'>'.$destinos_php[$i]['destino'].'</a></li>'.PHP_EOL;
											}
										?>
									</ul>
									<a id="button_hoteles" href="#hoteles" style="position:absolute;z-index:-1">Ver hoteles</a>
								</div>
								<div class="intro span-3-25" id="lista-hoteles">
									<h3>La boda de tus sueños<br> <b>en <?php echo $destinos_php[0]['destino']; ?></b></h3>
									<ul class="lista-contenido">
										<?php
											for ($i=0; $i < count($destinos_php[$destinos_index]['hoteles']); $i++) {
												echo '<li><a href="#hoteles" onclick="show_hotel_info(0,'.$i.')">' . $destinos_php[$destinos_index]['hoteles'][$i]['nombre'] . '</a></li>';
											}
										?>
									</ul>
									<a id="button_hotel" href="#hoteles">Ver hoteles</a>
									<!--<a href="#pre-fifth">Cotiza tu boda</a>-->
								</div>
							</section>

							<section class="panel color0" id="hoteles">
								<div class="intro span-2-5">
								</div>
							</section>

							<section class="panel spotlight medium left" id="imagen-destino">
								<div class="content color6 span-10">
								</div>
								<div class="image filtered span-5-5" data-position="center">
									<img src="<?php echo URL . $destinos_php[0]['banner']; ?>" alt="" />
								</div>
							</section>

					<!-- Contacto -->
						
						<?php include_once('../includes/page-forms/contacto.php'); ?>

					<!-- Modals Hotel -->
							<section id="habitaciones">
								<div class="modal" tabIndex="-1">
									<div class="inner">
									</div>
								</div>
							</section>

							<section id="restaurantes">
								<div class="modal" tabIndex="-1">
									<div class="inner">
									</div>
								</div>
							</section>
					</div>

			</div>

		<!-- Scripts -->
			<?php include_once('../includes/page-forms/footer.php'); ?>
			<script>
				var destinos = jQuery.parseJSON('<?php echo json_encode($destinos_php); ?>');
										
				show_hoteles(<?php echo $destinos_index; ?>);

				<?php 
					if(isset($_GET[$destinos_php[$destinos_index]['var']])){
						echo '$("#boton-destino-'.$destinos_index.'").trigger("click");';

						if(isset($_GET[$destinos_php[$destinos_index]['hoteles'][$hoteles_index]['var']])){
							echo 'show_hotel_info('.$destinos_index.','.$hoteles_index.');';
						}
					}
				?>

				$('.lista-contenido a').on('click', function(event) {
					if ($(this).next().is(':visible')) {
						$(this).next().hide();
					} else {
						$(this).next().show();
					}
				});

				function show_hoteles(id) {
					$('#hoteles').hide();
					$('#lista-destinos ul li a.active').removeClass('active');
					$('#boton-destino-'+id).addClass('active');
					$('#imagen-destino .image').html('<img src="<?php echo URL; ?>' + destinos[id]['banner'] + '" alt="" />');
					$('#formulario_dw_origen').val('LBDTS ' + destinos[id]['destino']);

					var cuerpo_lista_hoteles = '<h3>La boda de tus sueños<br> <b>en ' + destinos[id]['destino'] + '</b></h3>' + 
						'<ul>';
					for (let index = 0; index < Object.keys(destinos[id]['hoteles']).length; index++) {
						cuerpo_lista_hoteles += '<li><a href="#hoteles" onclick="show_hotel_info(' + id + ',' + index + ')">' + destinos[id]['hoteles'][index]['nombre'] + '</a></li>';
					}
					cuerpo_lista_hoteles += '</ul>';
					for (let index = 0; index < (5 - Object.keys(destinos[id]['hoteles']).length); index++) {
						cuerpo_lista_hoteles += '<br>';
					}

					cuerpo_lista_hoteles += '<a href="#pre-fifth">Cotiza tu boda</a>';

					$('#lista-hoteles').html(cuerpo_lista_hoteles);
				}

				function show_hotel_info(id,hotel) {
					var cuerpo_hoteles = '<img src="../assets/img/lbdts/destinos/'+destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta']+destinos[id]['hoteles'][hotel]['logo']+'" alt="">' +
						'<ul>' +
						'<li><a href="'+destinos[id]['hoteles'][hotel]['mapa']+'" target="_blank">Ubicación</a></li>' +
						'<li><a id="button_habitaciones">Habitaciones</a></li>' +
						'<li><a id="button_restaurantes">Restaurantes</a></li>' +
						'</ul>';

					var cuerpo_habitaciones = '<h2>' + destinos[id]['hoteles'][hotel]['nombre'] + '</h2><h3>Habitaciones</h3>' +
					'<div class="row gtr-uniform">';
					for (let i = 0; i < Object.keys(destinos[id]['hoteles'][hotel]['habitaciones']).length; i++) {
						if(destinos[id]['hoteles'][hotel]['habitaciones'][i]['imagenes'][0] != null){
							cuerpo_habitaciones += '<div class="col-4 col-12-mobile">' +
							'<img src="../assets/img/lbdts/destinos/'+destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta']+'HABITACIONES/'+destinos[id]['hoteles'][hotel]['habitaciones'][i]['imagenes'][0] + '" alt="">' +
							'</div>';
						}
						cuerpo_habitaciones +=	'<div class="col-8 col-12-mobile">' +
							'<h3>'+destinos[id]['hoteles'][hotel]['habitaciones'][i]['nombre']+'</h3>';

						if (typeof destinos[id]['hoteles'][hotel]['habitaciones'][i]['descripcion'] !== 'undefined') {
							cuerpo_habitaciones +=	'<p>'+destinos[id]['hoteles'][hotel]['habitaciones'][i]['descripcion']+'</p>';
						}

						if(typeof destinos[id]['hoteles'][hotel]['habitaciones'][i]['puntos'] !== 'undefined'){
							var caracteristicas = Object.keys(destinos[id]['hoteles'][hotel]['habitaciones'][i]['puntos']).length;
							cuerpo_habitaciones += '<div class="row">';
							for (let j = 0; j < caracteristicas; j++) {
								if(j == 0 || (caracteristicas > 4 && j == Math.ceil(caracteristicas/2))){
									cuerpo_habitaciones += '<div class="col-6 col-12-mobile">' +
										'<ul>';
								}
								cuerpo_habitaciones += '<li>' + destinos[id]['hoteles'][hotel]['habitaciones'][i]['puntos'][j] + '</li>'
								if((caracteristicas > 4 && j == Math.ceil(caracteristicas/2) - 1 ) || j == caracteristicas - 1){
									cuerpo_habitaciones += '</ul>' +
										'</div>';
								}
							}

							cuerpo_habitaciones += '</div>';
						}

						cuerpo_habitaciones += '</div>';
					}
					cuerpo_habitaciones += '</div>';

					var cuerpo_restaurantes = '<h2>' + destinos[id]['hoteles'][hotel]['nombre'] + '</h2><h3>Restaurantes</h3>' +
					'<div class="row gtr-uniform">';

					for (let i = 0; i < Object.keys(destinos[id]['hoteles'][hotel]['restaurantes']).length; i++) {
						if(destinos[id]['hoteles'][hotel]['restaurantes'][i]['imagenes'][0] != null){
							cuerpo_restaurantes += '<div class="col-4 col-12-mobile">' +
							'<img src="../assets/img/lbdts/destinos/'+destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta']+'RESTAURANTES/'+destinos[id]['hoteles'][hotel]['restaurantes'][i]['imagenes'][0] + '" alt="">' +
							'</div>';
						}
						cuerpo_restaurantes +=	'<div class="col-8 col-12-mobile">' +
							'<h3>'+destinos[id]['hoteles'][hotel]['restaurantes'][i]['nombre']+'</h3>' +
							'<p>'+destinos[id]['hoteles'][hotel]['restaurantes'][i]['descripcion']+'</p>';
						

						if (typeof destinos[id]['hoteles'][hotel]['restaurantes'][i]['horarios'] !== 'undefined') {
							var horarios = Object.keys(destinos[id]['hoteles'][hotel]['restaurantes'][i]['horarios']).length;

							for (let j = 0; j < horarios; j++) {
								if(j == 0){
									cuerpo_restaurantes += '<ul>';
								}
								cuerpo_restaurantes += '<li>' + destinos[id]['hoteles'][hotel]['restaurantes'][i]['horarios'][j] + '</li>'
								if(j == horarios - 1){
									cuerpo_restaurantes += '</ul>';
								}
							}
						}
						
						cuerpo_restaurantes +=	'</div>';
					}

					cuerpo_restaurantes += '</div>';

					$('#hoteles .intro').html(cuerpo_hoteles);
					$('#hoteles').show();
					$("#button_hoteles").trigger("click");
					$('#imagen-destino .image').html('<img src="../assets/img/lbdts/destinos/' +destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta'] + 'GALERIA_GENERAL/1.jpg" alt="" />');
					$('#imagen-destino .content').html('<div class="next"><i class="icon solid fa-chevron-right"></i></div><div class="pre"><i class="icon solid fa-chevron-left"></i></div>');

					$('#habitaciones .inner').html(cuerpo_habitaciones);
					$('#restaurantes .inner').html(cuerpo_restaurantes);

					$('#button_habitaciones').on('click', function(event){
						$('#habitaciones .modal').addClass('visible');
						$('#habitaciones .modal').addClass('loaded');
						
						settings.scrollWheel.enabled = false;
					});

					$('#button_restaurantes').on('click', function(event){
						$('#restaurantes .modal').addClass('visible');
						$('#restaurantes .modal').addClass('loaded');
						
						settings.scrollWheel.enabled = false;
					});

					$('#imagen-destino .content .pre').on('click', function(event){
						imagen_galeria(id,hotel,'pre',1);
					});

					$('#imagen-destino .content .next').on('click', function(event){
						imagen_galeria(id,hotel,'next',1);
					});
				}

				function imagen_galeria(id,hotel,direccion='next',img) {
					if(direccion == 'next'){
						img = parseInt(img) + 1;
					}else{
						img = parseInt(img) - 1;
					}

					if(img > parseInt(destinos[id]['hoteles'][hotel]['galeria'])){
						img = 1;
					}else if(img <= 0) {
						img = parseInt(destinos[id]['hoteles'][hotel]['galeria']);
					}
					
					$('#imagen-destino .image').html('<img src="../assets/img/lbdts/destinos/' +destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta'] + 'GALERIA_GENERAL/'+img+'.jpg" alt="" />');

					$('#imagen-destino .content .pre').off('click');
					$('#imagen-destino .content .pre').on('click', function(event){
						imagen_galeria(id,hotel,'pre',img);
					});

					$('#imagen-destino .content .next').off('click');
					$('#imagen-destino .content .next').on('click', function(event){
						imagen_galeria(id,hotel,'next',img);
					});

					
				}
			</script>
			<?php include_once('../includes/wabutton.php')?>
	</body>
</html>