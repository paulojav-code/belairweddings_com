<?php
$lang = 'es';
ini_set('display_errors', 1);
include_once('includes/php/variables.php');
include_once('includes/php/config.php');
include_once('includes/php/conexion.php');

$titulo = 'Inicio';
$folder = ['inicio', ''];

/* Galeria */
$tamanho_galeria_php = 60;

/* Testimonios*/
$json_raw_testimonios = file_get_contents('includes/json/testimonios.json');
$json_raw_testimonios = preg_replace("/[\r\n|\n|\r]+/", '', $json_raw_testimonios);
$testimonios_php = json_decode($json_raw_testimonios, TRUE);
$json_raw_testimonios = str_replace("\\", "\\\\", $json_raw_testimonios);

/* Blogs */
$id_unidad_negocio = 2;
$array_data = array();
$sql = 'SELECT id_articulo, titulo, t1.ruta, imagen, DATE_FORMAT(fecha,"%d") AS dia, DATE_FORMAT(fecha,"%m") AS mes, DATE_FORMAT(fecha,"%Y") AS anho, t2.nombre AS categoria
			FROM eze_blog.articulos AS t1
			INNER JOIN eze_blog.categorias AS t2 ON t1.id_categoria = t2.id_categoria
			WHERE t1.id_unidad_negocio = ? AND t1.activo = 1
			ORDER BY t1.fecha DESC LIMIT 4;';
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_unidad_negocio);
$stmt->execute();
$result = $stmt->get_result();
while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
	$array_data[] = $req;
}
$stmt->close();

/* Proximos eventos */
$array_data_proximos = array();
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
$json_raw_proximos = json_encode($array_data_proximos);
$proximos_eventos = json_decode($json_raw_proximos, TRUE);

include_once('includes/page-forms/header.php');
?>
<!-- Page Wrapper -->
<div id="page-wrapper">

	<!-- Navbar -->
	<?php include_once('includes/page-forms/navbar.php'); ?>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Panel (Banner) -->
		<section id="titulo" class="panel banner right">
			<div class="content color0 span-5-75">
				<h2 class="major">La boda de tus <span class="font-anitto">sueños</span></h2>
				<h3 class="major">Reserva un mínimo de habitaciones en plan All Inclusive y obtén tu boda gratis en la playa.</h3>
				<a href="la-boda-de-tus-suenos/">Ver paquete</a>
			</div>
			<div class="image filtered span-3-25" data-position="top left">
				<img src="<?php echo URL ?>/assets/img/home/imagen-home-la-boda-de-tu-suenos.jpg" alt="" />
			</div>
		</section>

		<!-- Galeria -->
		<!-- Panel -->
		<section class="panel" id="galeria">
			<div class="gallery">
				<?php
				for ($i = 1; $i <= $tamanho_galeria_php; $i++) {
					if ($i % 4 == 1) {
						echo '<div class="group span-3">';
					}
					echo '<a href="assets/img/galeria/' . ($i) . '.jpg" class="image filtered span-1-5" data-position="center"><img src="' . URL . '/assets/img/galeria/' . ($i) . '-m.jpg" alt="" /></a>';
					if ($i % 4 == 0) {
						echo '</div>';
					}
				}
				?>
				<div class="flecha-galeria pre"><i class="icon solid fa-angle-left"></i></div>
				<div class="flecha-galeria next"><i class="icon solid fa-angle-right"></i></div>
			</div>
		</section>

		<!-- Nosotros -->
		<!-- Panel  -->
		<section class="panel" id="pre-first">
			<div class="intro color2">
				<ul>
					<li><b>Más de 12 años</b> <br>de experiencia</li>
					<li><b>Más de 4,200</b> <br>parejas felices</li>
					<li><b>260 mil invitados</b> <br>satisfechos</li>
				</ul>
			</div>
		</section>

		<!-- Panel (Spotlight) -->
		<section class="panel spotlight large left" id="first">
			<div class="content span-4-75">
				<p>
					En <b>Dreams Wedding</b> somos cómplices de su historia de amor.<br><br>
					Con el paquete <b>La Boda de tus Sueños</b> nos comprometemos a optimizar su presupuesto para que obtengan su boda soñada en la playa <b>totalmente gratis.</b>
				</p>
				<a href="#pre-second">Conoce más</a>
			</div>
			<div class="image filtered tinted" data-position="top right">
				<img src="<?php echo URL ?>/assets/img/home/imagen-home-dw-01.jpg" alt="" />
			</div>
		</section>

		<!-- FAQ -->
		<!-- Panel -->
		<section class="panel color1" id="pre-second">
			<div class="intro span-2-5">
				<h2 class="major">Nuestros Servicios</h2>
				<ul>
					<li>Coordinación de la boda</li>
					<li>Montaje de ceremonia</li>
					<li>Banquete de boda</li>
					<li>Tarifas especiales</li>
					<li>Plan all-inclusive</li>
					<li>Invitación digital</li>
					<li>Páginas web</li>
					<li>Personal de reservaciones</li>
				</ul>
				<a id="button_faq">Preguntas frecuentes</a>
			</div>
		</section>

		<!-- Testimonios -->
		<!-- Panel (Spotlight) -->
		<section class="panel spotlight large right" id="second">
			<div class="content color0 span-5-5">
				<div id="div_testimonios"></div>
				<ul class="icons">
					<li><a id="button_testimonios_left"><i class="icon solid fa-angle-left"></i></a></li>
					<li><a id="button_testimonios">Ver todos los testimonios</a></li>
					<li><a id="button_testimonios_right"><i class="icon solid fa-angle-right"></i></a></li>
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
				<h2 class="major">Próximos Eventos</h2>
			</div>
		</section>

		<!-- Panel -->
		<section class="panel" id="third">
			<div class="gallery">
				<?php
				for ($i = 0; $i < 7; $i++) {
					$array_fecha_split = explode("-", $proximos_eventos[$i]['fecha']);
					if ($i % 2 != 0) {
						echo '<div class="group span-1-75">';
					}
					echo '<div class="image filtered ' . ($i > 0 ? 'span-3' : 'span-1-75') . ($i == 6 ? ' active' : '') . '" data-position="' . ($i > 0 ? 'center' : 'top') . '">';
					if ($i < 6) {
						echo '<img src="assets/img/wp/' . $proximos_eventos[$i]['id_novie'] . '/' . 'mini-small.jpg' . '" alt="" />
												<img src="assets/img/wp/' . $proximos_eventos[$i]['id_novie'] . '/' . 'mini-small.jpg' . '" alt="" class="alterno">
												<div class="container">
													<a href="' . ($proximos_eventos[$i]['activo'] == 1 ? URL.'/wp/' : '') . '' . $proximos_eventos[$i]['ruta'] . '/" target="_blank">
														<h2>' . $proximos_eventos[$i]['person_1'] . ' <span>' . $proximos_eventos[$i]['conector'] . '</span> ' . $proximos_eventos[$i]['person_2'] . '</h2>
														<h3>' . $array_fecha_split[2] . ' | ' . $array_fecha_split[1] . ' | ' . $array_fecha_split[0] . '</h3>
													</a>
												</div>';
					} else {
						echo '<div class="container">
													<a>Ver más</a>
												</div>';
					}
					echo '</div>';
					if ($i > 0 && $i % 2 == 0) {
						echo '</div>';
					}
				}
				?>
			</div>
		</section>

		<!-- Blog -->
		<!-- Panel -->
		<section class="panel spotlight medium left" id="fourth">
			<div class="content color2-alt span-2-5">
				<h2 class="major">Blog</h2>
			</div>
			<div class="content color7 span-7-5">
				<div class="datos-articulo">
					<h3><a href="<?php echo URL . '/blog/' . $array_data[0]['ruta']; ?>.php"><?php echo $array_data[0]['titulo'] ?></a></h3>
					<hr>
					<ul>
						<li><?php echo $array_data[0]['dia'] . '-' . $array_data[0]['mes'] . '-' . $array_data[0]['anho']; ?></li>
						<li><a href="<?php echo URL . '/blog/' . $array_data[0]['ruta']; ?>.php">Leer nota</a></li>
					</ul>
				</div>
			</div>
			<div class="image filtered transparent" data-position="center center">
				<img src="<?php echo $array_data[0]['imagen'] ?>" alt="" />
			</div>
		</section>

		<section class="panel spotlight color5" id="post-fourth">
			<div class="content span-3-75">
				<?php
				for ($i = 1; $i < 4; $i++) {
					echo '<div class="lista-articulos">
												<div class="imagen-articulo">
													<img src="assets/img/blog/' . $array_data[$i]['id_articulo'] . '/mini.jpg" alt="" class="fondo">
												</div>
												<div class="datos-articulo">
													<h3><a href="'.URL.'/blog/' . $array_data[$i]['ruta'] . '.php">' . $array_data[$i]['titulo'] . '</a></h3>
													<ul>
														<li>' . $array_data[$i]['dia'] . '-' . $array_data[$i]['mes'] . '-' . $array_data[$i]['anho'] . '</li>
														<li><a href="'.URL.'/blog/' . $array_data[$i]['ruta'] . '.php">Leer nota</a></li>
													</ul>
													<h4>' . $array_data[$i]['categoria'] . '</h4>
												</div>
											</div>';
				}
				?>
				<div class="enlace-articulos">
					<hr>
					<a href="https://belairweddings.com/blog/">Ir al blog</a>
				</div>
			</div>
		</section>

		<!-- Contacto -->
		<?php include_once('includes/page-forms/contacto.php'); ?>

		<!-- Modal FAQ -->
		<?php include_once('includes/page-forms/faq.php'); ?>

		<!-- Modal Testimonios -->
		<?php include_once('includes/page-forms/testimonios.php'); ?>

		<style>
			#promo-buen-fin .inner {
				width: 70em;
				height: 35em;
				max-width: 90vw;
				max-height: 85vh;
				z-index: 11001;
				padding: 0;
				text-align: center;
			}

			#promo-buen-fin .inner .logo {
				display: block;
				width: 40em;
				max-height: 90%;
				max-width: 100%;
				margin: 0 auto;
			}

			#promo-buen-fin .inner a {
				text-align: center;
			}

			#tyc-buen-fin .image.fit {
				max-width: 100%;
				max-height: 100%;
			}

			#promo-in-love-fest img {
				max-width: 100%;
			}

			#promo-in-love-fest .desk {
				display: block;
			}

			#promo-in-love-fest .mobile {
				display: none;
			}

			@media screen and (max-width: 736px) {
				#promo-in-love-fest .desk {
					display: none;
				}

				#promo-in-love-fest .mobile {
					max-height: 95vh;
					width: auto;
					display: block;
				}
			}

			#promo-mejor-puente img {
				margin: 0 auto;
				max-width: calc(100% - 4em);
				max-height: calc(100vh - 4em);
			}

			#promo-mejor-puente .desk {
				display: block;
			}

			#promo-mejor-puente .mobile {
				display: none;
			}

			@media screen and (max-width: 736px) {
				#promo-mejor-puente .desk {
					display: none;
				}

				#promo-mejor-puente .mobile {
					max-height: 95vh;
					width: auto;
					display: block;
				}
			}
		</style>
		<!--<section id="promo-buen-fin">
			<div class="modal" tabIndex="-1">
				<div class="inner">
					<img src="assets/img/promociones/2021/buen-fin/promo.png" alt="Logo en verano no te rajes" class="logo">
					<p>*El descuento se aplicará según el paquete y según el hotel seleccionado. <br>Aplican restricciones. Consulta hoteles participantes y términos y condiciones completas <a id="button_tyc_buen-fin">aquí</a> <br>Para más información llama al <a href="tel:8009900116">800 990 0116</a></p>
					<a href="#pre-fifth" onclick="modal($('.modal'))">Cotiza tu boda</a>
				</div>
			</div>
		</section>
		<section id="tyc-buen-fin">
			<div class="modal" tabIndex="-1">
				<div class="inner">
					<img src="assets/img/promociones/2021/buen-fin/tyc.jpg" alt="Logo en verano no te rajes" class="image fit">
				</div>
			</div>
		</section>
		<section id="promo-in-love-fest">
			<div class="modal" tabIndex="-1">
				<div class="inner">
					<a href="servicios/"><img src="assets/img/promociones/2021/in-love-fest/escritorio.png" alt="Banner in love fest" class="desk"></a>
					<a href="servicios/"><img src="assets/img/promociones/2021/in-love-fest/mobile.png" alt="Banner in love fest" class="mobile"></a>
				</div>
			</div>
		</section>
		<section id="promo-mejor-puente">
			<div class="modal" tabIndex="-1">
				<div class="inner">
					<a href="https://api.whatsapp.com/send?phone=523313125570&text=Hola%21+me+gustar%C3%ADa+obtener+el+10%+de+descuento+en+mis+pr%C3%B3ximas+vacaciones&%E2%9F%A8=es"><img src="assets/img/promociones/2022/mejor-puente/Mejor Puente_DW_Web.png" alt="Promoción Mejor Puente - La Boda de tus Sueños" class="desk"></a>
					<a href="https://api.whatsapp.com/send?phone=523313125570&text=Hola%21+me+gustar%C3%ADa+obtener+el+10%+de+descuento+en+mis+pr%C3%B3ximas+vacaciones&%E2%9F%A8=es"><img src="assets/img/promociones/2022/mejor-puente/Mejor Puente_DW_Mobile.png" alt="Promoción Mejor Puente - La Boda de tus Sueños" class="mobile"></a>
				</div>
			</div>
		</section>-->
	</div>

</div>

<!-- Scripts -->
<script>
	tamanho_galeria = <?php echo $tamanho_galeria_php; ?>;
</script>
<?php include_once('includes/wabutton.php'); ?>
<?php include_once('includes/page-forms/footer.php'); ?>
<script>
	$('#formulario_dw_origen').val('Home');

	var testimonios = jQuery.parseJSON('<?php echo $json_raw_testimonios; ?>');

	var numero_testimonio = 0;
	var loop_testimonio = 0;

	var proximos = jQuery.parseJSON(<?php echo json_encode($json_raw_proximos); ?>);

	print_galeria();

	function print_galeria(page = 1) {
		if (page <= 0) {
			page = Math.ceil(tamanho_galeria / 12);
		} else if (page > Math.ceil(tamanho_galeria / 12)) {
			page = 1;
		}

		$('#galeria .gallery .group').css('display', 'none');
		$('#galeria .gallery .group:nth-child(-n+' + ((page * 3) + 1) + ')').css('display', 'flex');
		$('#galeria .gallery .group:nth-child(-n+' + (((page - 1) * 3) + 1) + ')').css('display', 'none');

		$('.gallery .flecha-galeria.pre').on('click', function() {
			print_galeria(page - 1);
		});
		$('.gallery .flecha-galeria.next').on('click', function() {
			print_galeria(page + 1)
		});
	}

	// window.setTimeout(function() {
	// 	$('#promo-in-love-fest .modal').addClass('visible');
	// 	$('#promo-in-love-fest .modal').addClass('loaded');
	// 	settings.scrollWheel.enabled = false;
	// }, 3000)

	// window.setTimeout(function() {
	// 	$('#promo-buen-fin .modal').addClass('visible');
	// 	$('#promo-buen-fin .modal').addClass('loaded');
	// 	settings.scrollWheel.enabled = false;
	// }, 3000);

	// window.setTimeout(function() {
	// 	$('#promo-mejor-puente .modal').addClass('visible');
	// 	$('#promo-mejor-puente .modal').addClass('loaded');
	// 	settings.scrollWheel.enabled = false;
	// }, 3000);

	// $('#button_tyc_buen-fin').on('click', function(event){
	// 	modal($('.modal'));
	// 	window.setTimeout(function() {
	// 		$('#tyc-buen-fin .modal').addClass('visible');
	// 		$('#tyc-buen-fin .modal').addClass('loaded');
	// 	}, 1000);

	// 	settings.scrollWheel.enabled = false;
	// });

	$('#button_faq').on('click', function(event) {
		$('#faq .modal').addClass('visible');
		$('#faq .modal').addClass('loaded');

		settings.scrollWheel.enabled = false;
	});

	$('#button_testimonios').on('click', function(event) {
		$('#testimonios .modal').addClass('visible');
		$('#testimonios .modal').addClass('loaded');

		settings.scrollWheel.enabled = false;
	});

	$('#button_testimonios_left').on('click', function(event) {
		testimonios_slider(numero_testimonio - 1);
	});
	$('#button_testimonios_right').on('click', function(event) {
		testimonios_slider(numero_testimonio + 1);
	});

	testimonios_slider(numero_testimonio);
	setInterval('testimonios_slider()', 1000);

	function testimonios_slider(id = null) {
		if (id == null) {
			if (loop_testimonio < 12) {
				loop_testimonio++;
				return;
			} else {
				loop_testimonio = 0;
				numero_testimonio++;
			}
		} else {
			numero_testimonio = id;
			loop_testimonio = 0;
		}

		if (numero_testimonio >= Object.keys(testimonios).length) {
			numero_testimonio = 0;
		} else if (numero_testimonio < 0) {
			numero_testimonio = Object.keys(testimonios).length - 1;
		}

		$('#div_testimonios').html('<p>' + testimonios[numero_testimonio]['testimonio'] + '</p><h5>' + testimonios[numero_testimonio]['autor'] + '</h5>');
	}

	$('#third .active a').on('click', function(event) {
		show_all_proximos();
	});

	function print_evento(array, type = 1) {
		var carpeta = '';
		if (array['activo'] == 1) {
			carpeta = 'wp/';
		} else {
			carpeta = '/';
		}

		if (type == 1) {
			var cuerpo_evento = '<div class="image filtered span-1-5" data-position="top">' +
				'<img src="assets/img/wp/' + array['id_novie'] + '/' + 'mini-small.jpg' + '" alt="">' +
				'<img src="assets/img/wp/' + array['id_novie'] + '/' + 'mini-small.jpg' + '" alt=""  class="alterno">';
		} else {
			var cuerpo_evento = '<div class="image filtered span-1-75" data-position="top">' +
				'<img src="assets/img/wp/' + array['id_novie'] + '/' + 'mini-large.jpg' + '" alt="">' +
				'<img src="assets/img/wp/' + array['id_novie'] + '/' + 'mini-small.jpg' + '" alt=""  class="alterno">';
		}

		cuerpo_evento += '<div class="container">' +
			'<a href="' + carpeta + array['ruta'] + '/" target="_blank">' +
			'<h2>' + array['person_1'] + ' <span>' + array['conector'] + '</span> ' + array['person_2'] + '</h2>' +
			'<h3>' + array['fecha'].split('-')[2] + ' | ' + array['fecha'].split('-')[1] + ' | ' + array['fecha'].split('-')[0] + '</h3>' +
			'</a>' +
			'</div>' +
			'</div>';
		
		return cuerpo_evento;
	}
	

	function show_all_proximos() {
		var cuerpo_lista_eventos = print_evento(proximos[0], 0);
		console.log(proximos);
		for (let i = 1; i < Object.keys(proximos).length; i++) {
			if (i % 4 == 1) {
				cuerpo_lista_eventos += '<div class="group span-3">';
			}		
			cuerpo_lista_eventos += print_evento(proximos[i]);
			if (i % 4 == 0) {
				cuerpo_lista_eventos += '</div>';
			}
		}
		$('#third .gallery').html(cuerpo_lista_eventos);
	}
</script>

</body>

</html>