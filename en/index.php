<?php
	include_once('../includes/php/const.php');
	include_once('../includes/php/config.php');
	include_once('../includes/php/conexion.php');
	

	$titulo = 'Home';
	$folder = ['inicio','../'];

	$idioma = 'en';

	$testimonios = [
		['"Hi! <br>We want to share with you the beautiful experience that we had at our wedding on December 7, 2019. It was at Nuevo Vallarta, and to be honest, everything was amazing: the attention, the food, the service, all went beyond my expectations."','Elizabeth and José Antonio'],
		['"Thanks for everything! I had the wedding of my dreams. The service was perfect and so Azalia’s work, she’s the best! I recommend you to team up with her 100%"', 'Thania and Dane <br>Wedding in Cancún, 2020'],
		['"We are from Argentina and planning a wedding from far away is really complicated, but last month we had our wedding there, and it went amazing, like a fairytale."', 'Luciana Lobo Loberse'],
		['"All my friends and family were happy with the wedding. Daniela was the planner and we had such great communication day and night. Honestly, she was really nice, she answered all my questions and solved any problem."', 'Abril Jímenez'],
		['"All my respect for you and your team, you have always answered my questions and the guests were really happy with their booking."', 'Gonzalo Arriaga <br>Wedding in Nuevo Vallarta, 2020'],
		['"I want to say thank you to the hotel, everybody was kind and so was the attention. It was the wedding of our dreams, and it’s a great choice: the rates are fine, and the suppliers always check on the details."', 'Abigail Margarita'],
		['"They solved all my doubts! They’re amazing!"', 'Diana Fernández, guest <br>Wedding in Nuevo Vallarta, 2020'],
		['"I want to thank everybody for all the support provided. The day when Azalia called me to explain the details of my daughter’s wedding, she made me trust in her work. What convinced me was the speed and security of the information provided by the agency and its link with the hotel."', 'Leticia García (mother of the bride) <br>Wedding of Taly and Luis at Hilton Puerto Vallarta, 2020'],
	];

	/* SQL Bodas */
	$sql = 'SELECT id_novie, person_1, person_2, conector, fecha, ruta, mini_small, mini_large, activo
    FROM admin_bodas.novies
    WHERE activo IN(1,3) AND fecha >= CURDATE()
    ORDER BY fecha ASC;';

    $stmt = $con->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
        $array_data_proximos[] = $req;
    }

    $stmt->close();

	$json_raw = json_encode($array_data_proximos);
	$proximos_eventos = json_decode($json_raw,TRUE);

	include_once('../includes/page-forms/header.php');
?>
		<!-- Page Wrapper -->
			<div id="page-wrapper">

                <!-- Navbar -->
                    <?php include_once('../includes/page-forms/navbar.php'); ?>

				<!-- Wrapper -->
					<div id="wrapper">

						<!-- Panel (Banner) -->
							<section id="titulo" class="panel banner right alt">
								<div class="content color0 span-5-75">
                                    <h2 class="major"><span class="your">Your</span><br><br><br><span class="font-anitto"> Dreams Wedding</span></h2><br><br>
                                    <h3 class="major">Book a minimum of rooms in an all-inclusive package, and we'll give you the ceremony of your wedding at the beach</h3>
                                    <a href="package/">Let's start!</a>
								</div>
								<div class="image filtered span-3-25" data-position="top left">
									<img src="<?php echo URL ?>/assets/img/home/imagen-home-la-boda-de-tu-suenos.jpg" alt="" />
								</div>
							</section>

					<!-- Galeria -->
						<!-- Panel -->
							<section class="panel">
								<div class="gallery">
									<div class="group span-2-5">
										<a href="<?php echo URL ?>/assets/img/galeria/gallery_dw_02.jpg" class="image filtered span-2-5" data-position="center"><img src="<?php echo URL ?>/assets/img/galeria/gallery_dw_02.jpg" alt="" /></a>
										<a href="<?php echo URL ?>/assets/img/galeria/gallery_dw_06.jpg" class="image filtered span-2-5" data-position="bottom"><img src="<?php echo URL ?>/assets/img/galeria/gallery_dw_06.jpg" alt="" /></a>
									</div>
									<a href="<?php echo URL ?>/assets/img/galeria/gallery_dw_01.jpg" class="image filtered span-1-5" data-position="top"><img src="<?php echo URL ?>/assets/img/galeria/gallery_dw_01.jpg" alt="" /></a>
									<div class="group span-5">
										<a href="<?php echo URL ?>/assets/img/galeria/gallery_dw_03.jpg" class="image filtered span-2-5" data-position="bottom"><img src="<?php echo URL ?>/assets/img/galeria/gallery_dw_03.jpg" alt="" /></a>
										<a href="<?php echo URL ?>/assets/img/galeria/gallery_dw_05.jpg" class="image filtered span-2-5" data-position="top"><img src="<?php echo URL ?>/assets/img/galeria/gallery_dw_05.jpg" alt="" /></a>
										<a href="<?php echo URL ?>/assets/img/galeria/gallery_dw_04.jpg" class="image filtered span-2-5" data-position="top"><img src="<?php echo URL ?>/assets/img/galeria/gallery_dw_04.jpg" alt="" /></a>
										<a href="<?php echo URL ?>/assets/img/galeria/gallery_dw_07.jpg" class="image filtered span-2-5" data-position="center"><img src="<?php echo URL ?>/assets/img/galeria/gallery_dw_07.jpg" alt="" /></a>
									</div>
								</div>
							</section>

					<!-- Nosotros -->
						<!-- Panel  -->
							<section class="panel" id="pre-first">
								<div class="intro color2">
									<ul>
										<li><b>More than 12 years</b> <br>of experience in destination weddings</li>
										<li><b>More than 4,200</b> <br>happy couples</li>
										<li><b>More than 260k</b> <br>satisfied guests</li>
									</ul>
								</div>
							</section>

						<!-- Panel (Spotlight) -->
							<section class="panel spotlight large left" id="first">
								<div class="content span-4-75">
									<p>
										<b>Dreams Wedding</b> will be the best ally of your love story.<br><br>
										With our package <b>Your Dreams Wedding</b>, we will optimize your budget so that you get your dream wedding on the beach <b>completely free!</b>
									</p>
									<a href="#pre-second">Learn more!</a>
								</div>
								<div class="image filtered tinted" data-position="top right">
									<img src="<?php echo URL ?>/assets/img/home/imagen-home-dw-01.jpg" alt="" />
								</div>
							</section>

					<!-- FAQ -->
						<!-- Panel -->
							<section class="panel color1" id="pre-second">
								<div class="intro span-2-5">
									<h2 class="major">Our services: </h2>
									<ul>
										<li>Wedding Planning </li>
										<li>Ceremony Setup </li>
										<li>Wedding banquet</li>
										<li>Special rates</li>
										<li>All-inclusive package</li>
										<li>Digital invitation</li>
										<li>Web page</li>
									</ul>
									<a id="button_faq">Frequently asked questions</a>
								</div>
							</section>

					<!-- Testimonios -->
						<!-- Panel (Spotlight) -->
							<section class="panel spotlight large right" id="second">
								<div class="content color0 span-5">
									<div id="div_testimonios"></div>
									<ul class="icons">
									</ul>
								</div>
								<div class="image filtered tinted" data-position="top right">
									<img src="<?php echo URL ?>/assets/img/home/imagen-home-dw-02.jpg" alt="" />
								</div>
							</section>

					<!-- Proximos Eventos-->
						<!-- Panel -->
							<section class="panel color1" id="pre-third">
								<div class="intro span-1-5">
									<h2 class="major">Coming soon</h2>
								</div>
							</section>

						<!-- Panel -->
							<section class="panel" id="third">
								<div class="gallery">
									<?php
										$array_fecha_split = explode("-",$proximos_eventos[0]['fecha']);

										echo '<div class="image filtered span-1-75" data-position="top">
											<img src="../assets/img/wp/'.$proximos_eventos[0]['id_novie']."/mini-large.jpg".'" alt="">
											<img src="../assets/img/wp/'.$proximos_eventos[0]['id_novie'].'/mini-small.jpg'.'" alt="" class="alterno">
											<div class="container">
												<a href="'.($proximos_eventos[0]['activo'] == 1 ? URL.'/wp':'..').'/'.$proximos_eventos[0]['ruta'].'/en/" target="_blank">
													<h2>'.$proximos_eventos[0]['person_1'].' <span>'.$proximos_eventos[0]['conector'].'</span> '.$proximos_eventos[0]['person_2'].'</h2>
													<h3>'.$array_fecha_split[1].' | '.$array_fecha_split[2].' | '.$array_fecha_split[0].'</h3>
												</a>
											</div>
										</div>';

										for ($i=1; $i < 6; $i++) {
											$array_fecha_split = explode("-",$proximos_eventos[$i]['fecha']);
											if($i % 2 != 0){
												echo '<div class="group span-1-75">';
											}
											echo '<div class="image filtered span-3" data-position="center">
												<img src="../assets/img/wp/'.$proximos_eventos[$i]['id_novie'].'/mini-small.jpg'.'" alt="" />
												<img src="../assets/img/wp/'.$proximos_eventos[$i]['id_novie'].'/mini-small.jpg'.'" alt="" class="alterno">
												<div class="container">
													<a href="'.($proximos_eventos[$i]['activo'] == 1 ?  URL.'/wp/':'').$proximos_eventos[$i]['ruta'].'/en/" target="_blank">
														<h2>'.$proximos_eventos[$i]['person_1'].' <span>'.$proximos_eventos[$i]['conector'].'</span> '.$proximos_eventos[$i]['person_2'].'</h2>
														<h3>'.$array_fecha_split[1].' | '.$array_fecha_split[2].' | '.$array_fecha_split[0].'</h3>
													</a>
												</div>
											</div>';
											if($i % 2 == 0){
												echo '</div>';
											}
										}
									?>
										<div class="image filtered span-3 active" data-position="center">
											<div class="container">
												<a>See more</a>
											</div>
										</div>
									</div>
								</div>
							</section>

					<!-- Contacto -->
						<?php include_once('../includes/page-forms/contacto.php'); ?>

					<!-- Modal FAQ -->
						<?php include_once('../includes/page-forms/faq_en.php'); ?>

					</div>

			</div>

		<!-- Scripts -->
			<?php include_once('../includes/page-forms/footer.php'); ?>
			<script>

				$('#formulario_dw_origen').val('Home');

				var testimonios = [
					<?php
						for ($i=0; $i < count($testimonios); $i++) { 
							echo "['".$testimonios[$i][0]."','".$testimonios[$i][1]."'],";
						}
					?>
				];

				var numero_testimonio = 0;
				var loop_testimonio = 0;

				var proximos = jQuery.parseJSON(<?php echo json_encode($json_raw); ?>);

				$('#button_faq').on('click', function(event){
					$('#faq .modal').addClass('visible');
					$('#faq .modal').addClass('loaded');
						
					settings.scrollWheel.enabled = false;
				});

				testimonios_slider(numero_testimonio);
				setInterval('testimonios_slider()', 1000);

				function testimonios_slider(id = null) {
					if(id == null){
						if(loop_testimonio < 12){
							loop_testimonio++;
							return;
						}
					}else{
						numero_testimonio = id;
					}
					$('#div_testimonios').html('<p>'+testimonios[numero_testimonio][0]+'</p><h5>'+testimonios[numero_testimonio][1]+'</h5>');

					testimonios_puntos();

					loop_testimonio = 0;
					numero_testimonio++;

					if(numero_testimonio == testimonios.length){
						numero_testimonio = 0;
					}
				}

				function testimonios_puntos() {
					var texto_puntos = '';

					for (let index = 0; index < testimonios.length; index++) {
						if(numero_testimonio == index){
							texto_puntos += '<li><a onclick="testimonios_slider('+index+')" class="icon solid fa-circle active"><span class="label">' + (index + 1) + '</span></a></li>';
						}else{
							texto_puntos += '<li><a onclick="testimonios_slider('+index+')" class="icon solid fa-circle"><span class="label">' + (index + 1) + '</span></a></li>';
						}
					}

					$('#second .icons').html(texto_puntos);
				}
				
				$('#third .active a').on('click', function(event) {
					show_all_proximos();
				});

				function show_all_proximos() {
					var cuerpo_lista_eventos = print_evento(proximos[0],0);
					for (let i = 1; i < Object.keys(proximos).length; i++) {
						if(i % 4 == 1){
							cuerpo_lista_eventos += '<div class="group span-3">';
						}
						cuerpo_lista_eventos += print_evento(proximos[i]);
						if(i % 4 == 0){
							cuerpo_lista_eventos += '</div>';
						}
					}
					$('#third .gallery').html(cuerpo_lista_eventos);
				}

				function print_evento(array,type=1) {
					var carpeta = '';
					var ruta_img="/assets/img/wp/"

					if(array['activo'] == 1){
						carpeta = '<?=URL?>/wp/';
					}else{
						carpeta = '<?=URL?>/';
					}

					if(type == 1) {
						var cuerpo_evento = '<div class="image filtered span-1-5" data-position="top">' +
						'<img src="<?=URL?>' + ruta_img + array['id_novie'] + '/' + 'mini-small.jpg' + '" alt="">' +
						'<img src="<?=URL?>' + ruta_img + array['id_novie'] + '/' + 'mini-small.jpg' + '" alt=""  class="alterno">';
					}else{
						var cuerpo_evento = '<div class="image filtered span-1-75" data-position="top">' + 
						'<img src="<?=URL?>' + ruta_img + array['id_novie'] + '/' + 'mini-large.jpg' + '" alt="">' +
						'<img src="<?=URL?>' + ruta_img + array['id_novie'] + '/' + 'mini-small.jpg' + '" alt=""  class="alterno">';
					}

					cuerpo_evento += '<div class="container">' +
							'<a href="'+carpeta  + array['ruta'] + '/en" target="_blank">' +
								'<h2>' + array['person_1'] + ' <span>' + array['conector'] + '</span> ' + array['person_2'] + '</h2>' +
								'<h3>' + array['fecha'].split('-')[2] + ' | ' + array['fecha'].split('-')[1] + ' | ' + array['fecha'].split('-')[0] + '</h3>' +
							'</a>' +
						'</div>' +
					'</div>';

					return cuerpo_evento;
				}
			</script>

	</body>
</html>