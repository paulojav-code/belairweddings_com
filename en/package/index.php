<?php
	include_once('../../includes/php/config.php');
	include_once('../../includes/php/conexion.php');
	include_once('../../includes/php/const.php');

	$titulo = 'Your Dreams Wedding';
	$folder = ['lbdts','../'];

	$idioma = 'en';

	$json_raw = file_get_contents('../../includes/json/lbdts_en.json');
	$destinos = json_decode($json_raw,TRUE);

	$destinos_index = 0;
	$hoteles_index = 0;

	include_once('../../includes/page-forms/header.php');
?>
	<style>
	#lista-hoteles {
		justify-content: center;
	}
	#pru{
		color:#000;
	}

	</style>

		<!-- Page Wrapper -->
			<div id="page-wrapper">

                <!-- Navbar -->
                    <?php include_once('../../includes/page-forms/navbar.php'); ?>

				<!-- Wrapper -->
				<div id="wrapper">

				<!-- Panel (Banner) -->
					<section id="titulo-bdts" class="panel spotlight large left alt">
						<div class="content span-6">
							<h2 class="major"><span class="your">Your</span><br> <span class="font-anitto"> Dreams Wedding</span></h2>
							<h3 class="major">Book a minimum number of rooms in All Inclusive plan and we'll give you the wedding ceremony on the beach for free</h3>
							<a href="#lista-destinos">In which destination do you want to get married?</a>
						</div>
						<div class="image filtered tinted" data-position="left">
							<img src="<?php echo URL ?>/assets/img/lbdts/la_boda_de_tus_suenos_banner.jpg" alt="" />
						</div>
					</section>

					<section class="panel color0">
						<div class="intro span-2-5" id="descripcion">
							<h4>The time has come to say "I do" in front of the sea</h4>
							<p><!--At Dreams Wedding -->We want to help you celebrate the beach wedding you have always imagined, that's why we created the Your Dreams Wedding package.</p>
						</div>
						<div class="intro span-3-25" id="contenido">
							<h3>What is it about?*</h3>
							<ul class="lista-contenido">
								<?php
									for ($i=0; $i < count($destinos['contenido']); $i++) {
										echo '<li>';
										echo '<a>'.$destinos['contenido'][$i]['nombre'].'</a><ul>';
										for ($j=0; $j < count($destinos['contenido'][$i]['puntos']); $j++) { 
											echo '<li>'.$destinos['contenido'][$i]['puntos'][$j].'</li>';
										}
										echo '</ul></li>';
									}
								?>
							</ul>
							<p>*Some hotels may vary the products offered, contact an executive for more information.</p>
						</div>
						<div class="intro span-2-25" id="lista-destinos">
							<ul>
								<?php
									for ($i=0; $i < count($destinos) - 1; $i++) { 
										echo '<li><a id="boton-destino-'.$i.'" href="#lista-hoteles" onclick="show_hoteles('.$i.')" '.($i == $destinos_index? 'class="active"':'').'>'.$destinos[$i]['destino'].'</a></li>'.PHP_EOL;
									}
								?>
							</ul>
							<a id="button_hoteles" href="#hoteles" style="position:absolute;z-index:-1">Ver hoteles</a>
						</div>
						<div class="intro span-2-25" id="lista-hoteles">
							<h3>Your Dreams Wedding <b>in <?php echo $destinos[0]['destino']; ?></b></h3>
							<ul class="lista-contenido">
								<?php
									for ($i=0; $i < count($destinos[$destinos_index]['hoteles']); $i++) {
										echo '<li><a onclick="show_hotel_info(0,'.$i.')">' . $destinos[$destinos_index]['hoteles'][$i]['nombre'] . '</a></li>';
									}
								?>
							</ul>
							<a id="button_hotel">See hotels</a>
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
						<?php include_once('../../includes/page-forms/contacto.php'); ?>

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
			<?php include_once('../../includes/page-forms/footer.php'); ?>
			<script>
				var destinos = jQuery.parseJSON(<?php echo json_encode($json_raw); ?>);
										
				show_hoteles(<?php echo $destinos_index; ?>);

				<?php 
					if(isset($_GET[$destinos[$destinos_index]['var']])){
						echo '$("#boton-destino-'.$destinos_index.'").trigger("click");';

						if(isset($_GET[$destinos[$destinos_index]['hoteles'][$hoteles_index]['var']])){
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

					var cuerpo_lista_hoteles = '<h3>Your dream wedding<br> <b>in ' + destinos[id]['destino'] + '</b></h3>' + 
						'<ul>';
					for (let index = 0; index < Object.keys(destinos[id]['hoteles']).length; index++) {
						cuerpo_lista_hoteles += '<li><a href="#hoteles" onclick="show_hotel_info(' + id + ',' + index + ')">' + destinos[id]['hoteles'][index]['nombre'] + '</a></li>';
					}
					cuerpo_lista_hoteles += '</ul>';
					for (let index = 0; index < (5 - Object.keys(destinos[id]['hoteles']).length); index++) {
						cuerpo_lista_hoteles += '<br>';
					}

					cuerpo_lista_hoteles += '<a href="#pre-fifth">Get a quote</a>';

					$('#lista-hoteles').html(cuerpo_lista_hoteles);
				}

				function show_hotel_info(id,hotel) {
					var cuerpo_hoteles = '<img src="../assets/img/lbdts/destinos/'+destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta']+destinos[id]['hoteles'][hotel]['logo']+'" alt="">' +
						'<ul>' +
						'<li><a href="'+destinos[id]['hoteles'][hotel]['mapa']+'" target="_blank">Location</a></li>' +
						'<li><a id="button_habitaciones">Rooms</a></li>' +
						'<li><a id="button_restaurantes">Restaurants</a></li>' +
						'</ul>';

					var cuerpo_habitaciones = '<h2>' + destinos[id]['hoteles'][hotel]['nombre'] + '</h2><h3>Rooms</h3>' +
					'<div class="row gtr-uniform">';
					for (let i = 0; i < Object.keys(destinos[id]['hoteles'][hotel]['habitaciones']).length; i++) {
						if(destinos[id]['hoteles'][hotel]['habitaciones'][i]['imagenes'][0] != null){
							cuerpo_habitaciones += '<div class="col-4 col-12-mobile">' +
							'<img src="../../assets/img/lbdts/destinos/'+destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta']+'HABITACIONES/'+destinos[id]['hoteles'][hotel]['habitaciones'][i]['imagenes'][0] + '" alt="">' +
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

					var cuerpo_restaurantes = '<h2>' + destinos[id]['hoteles'][hotel]['nombre'] + '</h2><h3>Restaurants</h3>' +
					'<div class="row gtr-uniform">';

					for (let i = 0; i < Object.keys(destinos[id]['hoteles'][hotel]['restaurantes']).length; i++) {
						if(destinos[id]['hoteles'][hotel]['restaurantes'][i]['imagenes'][0] != null){
							cuerpo_restaurantes += '<div class="col-4 col-12-mobile">' +
							'<img src="../../assets/img/lbdts/destinos/'+destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta']+'RESTAURANTES/'+destinos[id]['hoteles'][hotel]['restaurantes'][i]['imagenes'][0] + '" alt="">' +
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
					$('#imagen-destino .image').html('<img src="../../assets/img/lbdts/destinos/' +destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta'] + 'GALERIA_GENERAL/1.jpg" alt="" />');
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
					
					$('#imagen-destino .image').html('<img src="../../assets/img/lbdts/destinos/' +destinos[id]['carpeta']+destinos[id]['hoteles'][hotel]['carpeta'] + 'GALERIA_GENERAL/'+img+'.jpg" alt="" />');

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

	</body>
</html>