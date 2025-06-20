<?php
	include_once '../includes/php/config.php';
    include_once '../includes/php/connections.php';
    include_once '../includes/wp/functions.php';

    if(!isset($_REQUEST['uri'])){
        // header('Location: ../');
    }
    $u = explode('/',trim($_REQUEST['uri'],'/'));
    $r = $u[0];
    $sql = "SELECT id_novie FROM novies WHERE ruta = ? AND activo = 1 ORDER BY id_novie DESC";
    $id = 0;
	$dominio = URL.'/';
    $res = query($con,$sql,['s',&$r]);
    if(count($res) > 0){
        $id = $res[0]['id_novie'];
    }
    $id_novie = $id;
    $id_idioma = 1;

    if(isset($u[1]) && $u[1] == "en"){
        $id_idioma = 2;
    }

    $retorno =  '../';
    $retorno_img = $id_idioma == 1 ? '../' : '../../';
    include_once($retorno.'includes/php/conexion.php');
    include_once($retorno.'includes/paginas-novios/funciones.php');

    $datos_json_pre = file_get_contents($retorno . 'includes/paginas-novios/datos_' . ($id_idioma == 1 ? 'es' : 'en') . '.json');
    $datos_json     = json_decode($datos_json_pre, true);
	
    include_once($retorno.'includes/paginas-novios/get_sql.php');
	$ruta = $array_novie['ruta'];
	if($id_idioma == 2 && !isset($array_novie["idiomas"])){
		header("location: ".$dominio.'wp/'.$r);
	}

    // variables
    $ruta_raiz      	 = $datos_json['rutas']['raiz'];
	$ruta_raiz = $dominio;
	$_REQUEST['uri'] == $r  ? $retorno_img = "../" : $retorno_img = "../../";
    $ruta_pagina    	 = $datos_json['rutas']['pagina'];
    $ruta_img       	 = $datos_json['rutas']['img'];
    $ruta_img = $retorno_img . 'assets/img/wp/' . $id_novie . '/';
    $currency       	 = $datos_json['currency'];
    $languague      	 = $datos_json['language'];
    $date_format    	 = $datos_json['date_format'];
    //general
    $novie_1             = $array_novie['person_1'];
	
    $novie_2             = $array_novie['person_2'];
    $conector            = $array_novie['conector'];
    $fecha_timer         = dateFormat($array_novie['fecha'], 'mm/dd/yyyy');
    $fecha_texto         = dateFormat($array_novie['fecha'], ($id_idioma == 1 ? 'dd M yyyy' : 'M dd yyyy'));
    //token
    $token 				 = $array_novie['token'];
    $check_in 			 = !is_null($array_novie['check_in']) ? dateFormat($array_novie['check_in'], $date_format) : '';
    $check_out 			 = !is_null($array_novie['check_out']) ? dateFormat($array_novie['check_out'], $date_format) : '';
    //descripcion
    $frase               = $array_novie['frase'];
    $tipo_codigo   		 = $array_novie['tipo_codigo'];
    $codigo_vestimenta   = $array_novie['codigo_vestimenta'];
    $guia_novies    	 = $ruta_img . $array_novie['guia_novies'];
    $telefono       	 = $datos_json['telefono_reserva'] != '' ? $datos_json['telefono_reserva'] : $array_novie['celular'];
    $bitly               = $array_novie['bitly'];
    //configuracion
    $ambas 				 = $array_novie['idiomas'] == 'en' ? true : false;
    $bandera             = $array_novie['bandera_alt'];
    $asistencia			 = $array_novie['asistencia'];
    $permitido_ninos     = $array_novie['permitido_ninos'];
    $clave_evento        = $array_novie['clave_evento'];
    $categoria_novies    = $array_novie['categoria_parejas'];
    $css_style           = $array_novie['style'];
    $correo_copia        = $array_novie['copia'];
    //imagenes
    $array_novie['cover_desk'] = str_replace('img/','',$array_novie['cover_desk']);
    $array_novie['cover_mobile'] = str_replace('img/','',$array_novie['cover_mobile']);
    $array_novie['mini_ceremonia'] = str_replace('img/','',$array_novie['mini_ceremonia']);
    $array_novie['mini_novie'] = str_replace('img/','',$array_novie['mini_novie']);

    //
    $novie_galeria		 = $array_novie['galeria'];
    $cover               = $ruta_img . $array_novie['cover_desk'];
    $cover_mobile        = $ruta_img . ($array_novie['cover_mobile'] != '' ? $array_novie['cover_mobile'] : $array_novie['cover_desk']);  

    $img_ceremonia       = $array_novie['mini_ceremonia'] != '' ? $ruta_img . $array_novie['mini_ceremonia'] : $ruta_raiz .'assets/img/paginas-novios/ramo.jpg';
    $img_novie           = $array_novie['mini_novie'] != '' ? $ruta_img . $array_novie['mini_novie'] : $ruta_raiz . 'assets/img/paginas-novios/form.jpg';
    $img_novie_default   = $array_novie['mini_novie'] == '';
    //destinos
    $destino_carpeta     = 'assets/img/paginas-novios' . $array_novie['carpeta_d'];
    $destino_banner      = $ruta_raiz . $destino_carpeta . $array_novie['banner_d'];
    $destino_mini        = $ruta_raiz . $destino_carpeta . $array_novie['mini_d'];
    $destino_galeria     = $array_novie['galeria_d'];
    $destino_corto       = $array_novie['nombre_corto'];
    $destino_largo       = $array_novie['nombre_largo'];
    $destino_descripcion = $array_novie['descripcion_d'];
    //hoteles
    $hotel_carpeta       = $destino_carpeta . $array_novie['carpeta_h'];
    $hotel_banner        = $ruta_raiz . $hotel_carpeta . $array_novie['banner_h'];
    $hotel_logo          = $ruta_raiz . $hotel_carpeta . $array_novie['logo'];
    $hotel_mini          = $ruta_raiz . $hotel_carpeta . $array_novie['mini_h'];
    $hotel_galeria       = $array_novie['galeria_h'];
    $hotel_nombre        = $array_novie['hotel'];
    $hotel_descripcion   = $array_novie['descripcion_h'];
    $hotel_clave 		 = $array_novie['clave_hotel'];
    $hotel_direccion     = $array_novie['direccion'];
    $hotel_mapa 		 = $array_novie['mapa'];
    //ejecutivos
    $ejecutive           = $datos_json['ejecutive'][$array_novie['genero']].' '.$array_novie['ejecutivo'];
    $ejecutive_telefono  = phoneFormat($array_novie['telefono']);
    $ejecutive_correo    = $array_novie['correo'];
    $ejecutive_correo_dw = $array_novie['correo_dw'];
    $ejecutive_call 	 = $array_novie['telefono'];

    $detalles_tarifas = [ $array_novie['edades'], $array_novie['limite'], $array_novie['cancelacion'] ];
    //ceremonias
    for ($i = 0; $i < count($array_ceremonia); $i++) {
        $array_ceremonia[$i]['hora'] = $array_ceremonia[$i]['hora'] != null ? timeFormat($array_ceremonia[$i]['hora']) : $datos_json['pendiente'];
        $array_ceremonia[$i]['lugar'] = $array_ceremonia[$i]['lugar'] != '' ? $array_ceremonia[$i]['lugar'] : $hotel_nombre;
        $array_ceremonia[$i]['direccion'] = $array_ceremonia[$i]['direccion'] != '' ? $array_ceremonia[$i]['direccion'] : $hotel_direccion;
        $array_ceremonia[$i]['mapa'] = $array_ceremonia[$i]['mapa'] != '' ? $array_ceremonia[$i]['mapa'] : $hotel_mapa;
    }
    //habitaciones
    for ($i = 0; $i < count($array_habitacion); $i++) {
        $array_habitacion[$i]['mini'] = $ruta_raiz . $destino_carpeta . $array_habitacion[$i]['mini'];
        $array_habitacion[$i]['amenidades'] = explode("|",$array_habitacion[$i]['servicios']);
        $array_habitacion[$i]['tarifas'] = [
            ($array_habitacion[$i]['precio'] != '0' ? $array_habitacion[$i]['precio'] : $datos_json['gratis']),
            ($array_habitacion[$i]['doble'] != '0' ? $array_habitacion[$i]['doble'] : $datos_json['gratis']),
            ($array_habitacion[$i]['extra'] != '0' ? $array_habitacion[$i]['extra'] : $datos_json['gratis']),
            ($array_habitacion[$i]['ninho'] != '0' ? $array_habitacion[$i]['ninho'] : $datos_json['gratis']),
            ($array_habitacion[$i]['junior'] != '0' ? $array_habitacion[$i]['junior'] : $datos_json['gratis'])
        ];
    }

    include_once $retorno."includes/paginas-novios/header.php";
?>
	<style>
		#banner { background: linear-gradient(0deg, rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url("<?php echo $cover; ?>");background-position: 50% 50%;background-size: cover;}
		@media screen and (max-width: 480px) { #banner { background: linear-gradient(0deg, rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url("<?php echo $cover_mobile; ?>");background-position: 50% 50%;background-size: cover;}}
		.box.special.hotel { background: linear-gradient(0deg, rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url("<?php echo $hotel_banner; ?>");background-position: 50% 50%;background-size: cover;}
		.box.special.destino { background: linear-gradient(0deg, rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url("<?php echo $destino_banner; ?>");background-position: 50% 10%;background-size: cover;}

		<?php echo $css_style; ?>
	</style>
	<div id="page-wrapper">

		<!-- Header -->
		<header id="header" class="alt">
			<div class="logo">
				<a href="<?php echo $ruta_raiz; ?>"><img src="<?php echo $ruta_raiz; ?>assets/img/logos/LOGOTIPOS_belair-dreams-wedding.png" alt="Logo Dreams Wedding Blanco"></a>
			</div>
			<?php
			if ($ambas) {
				echo '<div class="bandera"><a href="' . ($id_idioma == 1 ? 'en/' : '../') . '"><img src="' . $ruta_raiz . 'assets/img/paginas-novios/' . $bandera . '" alt="Logo Bandera"></a></div>';
			}
			?>
		</header>

		<!-- Banner -->
		<section id="banner" class="alt">
			<h2><?php echo $novie_1; ?><span class="detalle"><?php echo $conector; ?></span><?php echo $novie_2; ?></h2>
			<p><?php echo $fecha_texto; ?> | <?php echo $destino_corto; ?></p>
		</section>

		<!-- Main -->
		<section id="main" class="container">

			<section class="box special contador">
				<header class="major">
					<div class="row gtr-0">
						<div class="col-12">
							<h4><?php echo $frase; ?></h4>
						</div>
						<div class="col-12 imp-mobile">
							<span id="timer"></span>
						</div>
					</div>
				</header>
			</section>

			<!-- Info -->
			<section id="detalle">
				<div class="row align-center aln-center">
					<div class="col-12 imp">
						<h3 class="titulo-flores"><?php echo $datos_json['titulo_detalle']; ?></h3>
						<img class="flores" src="<?php echo $ruta_raiz; ?>assets/img/paginas-novios/flores.png" alt="flores de dreams wedding">
					</div>
					<?php
						$ceremonias_vars = array();
						$ceremonias_vars['size'] = count($array_ceremonia);
						$ceremonias_vars['col_ramo_size'] = '3';
						$ceremonias_vars['imp'] = array();
						switch($ceremonias_vars['size']) {
							case 1:
								$ceremonias_vars['col_ramo_size'] = '5';
								$ceremonias_vars['col_size'] = '5';
								break;
							case 2:
								$ceremonias_vars['col_size'] = '4';
								$ceremonias_vars['classes'] = [' imp',''];
								break;
							case 3:
								$ceremonias_vars['col_size'] = '3';
								break;
							case 4:
								$ceremonias_vars['col_ramo_size'] = '4';
								$ceremonias_vars['col_size'] = '4';
								break;
							default:
								break;
						}
						echo '<div class="col-' . $ceremonias_vars['col_ramo_size'] . ' col-12-mobile imp-mobile">
							<div class="ramo">
								<img src="' . $img_ceremonia . '" alt="Ramo Flores" class="ramo-flores">
							</div>
						</div>';
						for ($i=0; $i < $ceremonias_vars['size']; $i++) {
							if($ceremonias_vars['size'] == 4 && $i == 1){
								echo '<div class="col-12"><div class="row">';
							}
							echo '<div class="col-' . $ceremonias_vars['col_ramo_size'] . ' col-12-mobile' . (isset($ceremonias_vars['classes'][$i]) ? $ceremonias_vars['classes'][$i] : '') . '">
									<h4>' . $array_ceremonia[$i]['nombre'] . '</h4>
									<span class="tiempo">' . $array_ceremonia[$i]['hora'] . '</span>
									<h5>' . $array_ceremonia[$i]['lugar'] . '</h5>
									<p class="strong">' . $array_ceremonia[$i]['direccion'] . '</p>
									<p>' . $array_ceremonia[$i]['descripcion'] . '</p>
									<a href="' . $array_ceremonia[$i]['mapa'] . '" target="_blank">' . $datos_json['mapa'] . ' <i class="icon solid fa-map-marker-alt"></i></a>
								</div>';
							if($ceremonias_vars['size'] == 4 && $i == 3){
								echo '</div></div>';
							}
						}
					?>
				</div>
				<?php
					if ($codigo_vestimenta != '') {
						echo '<div id="codigo-vestimenta" class="row aln-center align-center gtr-uniform"><div class="col-10 col-12-mobile">';
						if($tipo_codigo == 0){
							echo '<h4>' . $datos_json['codigo_vestimenta'] . '</h4><p>' . $codigo_vestimenta . '</p>';
						}else{
							echo $codigo_vestimenta;
						}
						echo '</div></div>';
					}
				?>
			</section>

			<!-- Hotel -->
			<section class="box special hotel">
				<h2><?php echo $datos_json['titulo_hoteles']; ?></h2>
			</section>
			<section id="hotel">
				<div class="row aln-center gtr-uniform">
					<div class="col-5 col-12-mobile">
						<div id="carousel-hotel" class="owl-carousel">
							<?php
								for ($i = 0; $i < $hotel_galeria; $i++) {
									echo '<div class=""><img src="' . $hotel_mini . ($i + 1) . '.jpg" alt="Imagen Hotel ' . $hotel_nombre . ' Galeria ' . ($i + 1) . '" class="image fit"></div>';
								}
							?>
						</div>
					</div>
					<div class="col-6 col-12-mobile">
						<img src="<?php echo $hotel_logo; ?>" alt="Logo <?php echo $hotel_nombre; ?>" class="logo">
						<div class="info-hotel">
							<p><?php echo $hotel_descripcion; ?></p>
						</div>
					</div>
				</div>
				<?php 
					if(count($array_habitacion) > 0){
				?>
				<div class="row aln-center">
					<div class="col-11">
						<div id="tarifas" class="box">
							<h3><?php echo $datos_json['titulo_tarifas']; ?></h3>
							<hr>
							<div class="row gtr-uniform">
							<?php
								for ($i = 0; $i < count($array_habitacion); $i++) {
									echo '<div class="col-5 col-12-mobile"><img src="' . $array_habitacion[$i]['mini'] . '1.jpg" alt="Imagen Habtación ' . $array_habitacion[$i]['habitacion'] . '" class="image fit"></div>';
									echo '<div class="col-7 col-12-mobile"><h4>' . $array_habitacion[$i]['habitacion'] . '</h4><div class="row">';
									$tarifas_vars = array();
									$tarifas_vars = array_count_values($array_habitacion[$i]['tarifas']);
									if(!isset($tarifas_vars[''])){
										$tarifas_vars['col_size'] = 4;
									}else{
										$tarifas_vars['col_size'] = 12 / (5 - $tarifas_vars['']);
									}
									for ($j = 0; $j < 5; $j++) {
										if($array_habitacion[$i]['tarifas'][$j] != ''){
											echo '<div class="col-' . $tarifas_vars['col_size'] . ' col-6-mobile imp imp-mobile"><b>' . $datos_json['tipo_tarifas'][$j] . '</b></div>';
											echo '<div class="col-' . $tarifas_vars['col_size'] . ' col-6-mobile imp-mobile">' . $array_habitacion[$i]['tarifas'][$j] . '</div>';
										}
										if(!isset($tarifas_vars['']) && $j == 2){
											$tarifas_vars['col_size'] = 5;
											echo '</div><div class="row aln-center">';
										}
									}
									echo '<div class="col-12"><br><br><a class="button small alt" onclick="modal(\'#modal_hab_' . ($i + 1) . '\')">' . $datos_json['ver_mas'] . '</a></div></div></div>';
								}
							?>
								<div class="col-12">
									<?php
									for ($i = 0; $i < count($detalles_tarifas); $i++) {
										echo '<p' . ($i == 0 ? ' class="small"' : '') . '>' . $detalles_tarifas[$i] . '</p>';
									}
									?>
								</div>
								<div class="col-12">
									<ul class="icons">
										<li><a href="tel:<?php echo $telefono; ?>" class="button small" onclick=""><?php echo $datos_json['llamar']; ?></a></li>
										<?php 
										if ($bitly != ''){
										?>
											<li><a href="<?php echo $bitly; ?>" class="button small" onclick="">WhatsApp</a></li>
										<?php
										}
										if ($token != '') { 
										?>
											<li><a class="button small" onclick="reservar('<?php echo $hotel_clave; ?>','<?php echo $token; ?>','<?php echo $check_in; ?>','<?php echo $check_out; ?>')"><?php echo $datos_json['reservar']; ?></a></li>
										<?php 
										} 
										if($array_novie['guia_novies'] != '') {
										?>
											<li><a href="<?php echo $guia_novies; ?>" class="button small" onclick="" target="_blank"><?php echo $datos_json['guia']; ?></a></li>
										<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php	
					}
				?>
			</section>

			<!-- Novios -->
			<section class="box special novios">
				<h2><?php echo $datos_json['titulo_novies'][$categoria_novies]; ?></h2>
			</section>
			<section id="novios">
				<div class="row aln-center">
					<div class="col-11">
						<div id="comentario" class="box">
							<div class="row gtr-uniform">
								<div class="col-12 align-center">
									<p><?php echo $datos_json['nuestros_novies'][$categoria_novies]; ?></p>
								</div>
								<div class="col-5 col-12-mobile">
									<div class="imagen-cover">
										<img <?php echo !$img_novie_default? 'onclick="mostrar_imagen(0)" ':''; ?>src="<?php echo $img_novie; ?>" alt="Imagen Novies confirmacion" class="fondo" style="object-position:50% 0%">
									</div>
								</div>
								<div class="col-7 col-12-mobile">
									<div class="row gtr-uniform gtr-25 align-center">
										<div class="col-12">
											<input name="parentesco" id="parentesco" type="text" placeholder="<?php echo $datos_json['parentesco_novies'][$categoria_novies]; ?>" maxlength="100">
											<textarea name="mensaje" id="mensaje" cols="30" rows="5" placeholder="<?php echo $datos_json['mensaje_novies'][$categoria_novies]; ?>"></textarea>
										</div>
										<div class="col-12">
											<ul class="icons">
												<li><input type="hidden" name="recaptcha_response_com" id="recaptcha_response_com"></li>
												<li><input type="submit" value="<?php echo $datos_json['enviar']; ?>" class="small alt" id="botton_comentarios_novies" /></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						if ($novie_galeria > 0) {
					?>
						<div class="col-12">
							<div id="carousel-novies" class="owl-carousel">
								<?php
								for ($i = 0; $i < $novie_galeria; $i++) {
									echo '<div class=""><img onclick="mostrar_imagen('.($i + 1).')" src="'.$ruta_img . ($i + 1) . '-m.jpg" alt="Imagen Novies ' . $novie_1 . ' ' . $conector . ' ' . $novie_2 . ' Galeria ' . ($i + 1) . '" class="image fit"></div>';
								}
								?>
							</div>
						</div>
					<?php
						}
						if(count($comentarios) > 0) {
					?>
						<div class="col-12 align-center">
							<h3 class="titulo-flores"><?php echo $datos_json['titulo_comentarios'][$categoria_novies]; ?></h3>
							<img class="flores" src="<?php echo $ruta_raiz; ?>assets/img/paginas-novios/flores.png" alt="flores de dreams wedding">
						</div>
						<div class="col-12">
							<div class="row aln-center align-center elemento-comentario">
							<?php
								for ($i=0; $i < count($comentarios); $i++) { 
									echo '<div class="col-8 col-12-narrower">
										<p>'.$comentarios[$i][1].'</p>
										<h3>'.$comentarios[$i][0].'</h3>
										<hr>
									</div>';
								}
							?>
							</div>
							<br>
						</div>
					<?php
						}
						if (count($array_mesa) > 0) {
					?>
						<div class="col-11">
							<div id="mesa" class="box special mesa">
								<div class="row aln-center">
									<div class="col-12">
										<h3><?php echo $datos_json['mesa_regalo']; ?></h3>
										<p></p>
									</div>
									<?php
										$mesa_vars = array();
										$mesa_vars['size'] = count($array_mesa);
										$mesa_vars['col_caja_size'] = '3';
										switch($mesa_vars['size']) {
											case 1:
												$mesa_vars['col_caja_size'] = '4';
												$mesa_vars['col_size'] = '5';
												break;
											case 2:
												$mesa_vars['col_size'] = '4';
												break;
											case 3:
												$mesa_vars['col_size'] = '3';
												break;
											default:
												break;
										}
										echo '<div class="col-' . $mesa_vars['col_caja_size'] . ' col-6-narrower col-12-mobile">
												<img src="' . $ruta_raiz . 'assets/img/paginas-novios/regalo.png" alt="Imagen mesa de regalo" class="image fit">
											</div>';
										for ($i = 0; $i < count($array_mesa); $i++) {
											echo '<div class="col-' . $mesa_vars['col_size'] . ' col-8-narrower col-12-mobile align-center">
												<h3>' . $array_mesa[$i]['titulo'] . '</h3>
												<h4>' . $array_mesa[$i]['descripcion'] . '</h4>
												<ul class="icons">
													' . ($array_mesa[$i]['enlace'] != '' ? '<li><a href="'.$array_mesa[$i]['enlace'].'" class="button small alt" target="_blank">'.$datos_json['mesa_regalo_ir'].'</a></li>' : '') .
												'</ul>
											</div>';
										}
									?>
								</div>
							</div>
						</div>
					<?php
					}
					if($asistencia){
					?>
					<div class="col-11 align-center">
						<h3><?php echo $datos_json['form_confirmation']; ?></h3>
						<img class="flores" src="<?php echo $ruta_raiz; ?>assets/img/paginas-novios/flores.png" alt="Imagen flores de Dreams Wedding">
					</div>
					<div class="col-11 align-center">
						<div id="formulario" class="box">
							<h4><?php echo $datos_json['form_thanks']; ?></h4>
							<div class="row gtr-50 gtr-uniform aln-center">
								<div class="col-6 col-12-mobilep">
									<br>
									<select name="asistencia" id="asistencia">
										<option value=""><?php echo $datos_json['form_selection']; ?></option>
										<option value="1"><?php echo $datos_json['form_yes']; ?></option>
										<option value="2"><?php echo $datos_json['form_not']; ?></option>
									</select>
								</div>
								<div class="col-6 col-12-mobilep">
									<label for="ceremonia"><?php echo $datos_json['form_ceremony']; ?></label>
									<select name="ceremonia" id="ceremonia">
										<option value=""><?php echo $datos_json['form_selection']; ?></option>
										<option value="1"><?php echo $datos_json['form_religious']; ?></option>
										<option value="2"><?php echo $datos_json['form_recepcion']; ?></option>
										<option value="3"><?php echo $datos_json['form_both']; ?></option>
									</select>
								</div>
								<div class="col-6 col-12-mobilep">
									<label for="nombre"><?php echo $datos_json['form_name']; ?></label>
									<input type="text" name="nombre" id="nombre" value="" placeholder="<?php echo $datos_json['form_name']; ?>(s)" />
								</div>
								<div class="col-6 col-12-mobilep">
									<label for="apellido"><?php echo $datos_json['form_last']; ?></label>
									<input type="text" name="apellido" id="apellido" value="" placeholder="<?php echo $datos_json['form_last']; ?>(s)" />
								</div>
								<div class="col-6 col-12-mobilep">
									<label for="email"><?php echo $datos_json['form_email']; ?></label>
									<input type="email" name="email" id="email" value="" placeholder="<?php echo $datos_json['form_email']; ?>" />
								</div>
								<div class="col-6 col-12-mobilep">
									<label for="telefono"><?php echo $datos_json['form_telefono']; ?></label>
									<input type="text" name="telefono" id="telefono" value="" placeholder="<?php echo $datos_json['form_telefono']; ?>" />
								</div>
								<div class="<?php echo ($permitido_ninos) ? 'col-4':'col-12'; ?> col-12-mobilep">
									<label for="adultos"><?php echo $datos_json['form_adults']; ?></label>
									<select name="adultos" id="adultos">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
									</select>
								</div>
								<?php
									if($permitido_ninos){
								?>
								<div class="col-4 col-12-mobilep">
									<label for="ninhos"><?php echo $datos_json['form_child']; ?></label>
									<select name="ninhos" id="ninhos">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
									</select>
								</div>
								<div class="col-4 col-12-mobilep">
									<label for="juniors"><?php echo $datos_json['form_juniors']; ?></label>
									<select name="juniors" id="juniors">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
									</select>
								</div>
								<?php
									}else{
								?>
									<input type="hidden" name="ninhos" id="ninhos" value="0" />
									<input type="hidden" name="juniors" id="juniors" value="0" />
								<?php
									}
								?>
								<div class="col-12">
									<ul class="icons">
										<li><input type="hidden" name="recaptcha_response" id="recaptcha_response"></li>
										<li><input type="submit" value="<?php echo $datos_json['enviar']; ?>" class="small alt" onclick="enviar_confirmacion()" /></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?php
					}
					?>
				</div>
			</section>

			<!-- Destino -->
			<section class="box special destino">
				<h2><?php echo $datos_json['titulo_destino']; ?></h2>
			</section>
			<section id="destino">
				<div class="row gtr-25 aln-center gtr-uniform">
					<div class="col-11 col-12-mobile">
						<div class="info-destino">
							<h3><?php echo $destino_largo; ?></h3>
							<p><?php echo $destino_descripcion; ?></p>
						</div>
					</div>
					<div class="col-12">
						<div id="carousel-destino" class="owl-carousel">
							<?php
							for ($i = 0; $i < $destino_galeria; $i++) {
								echo '<div><img src="' . $destino_mini . ($i + 1) . '.jpg" alt="Imagen Destino' . $destino_largo . ' Galeria ' . ($i + 1) . '" class="image fit"></div>';
							}
							?>
						</div>
					</div>
				</div>
			</section>

		</section>

		<?php
			for ($i = 0; $i < count($array_habitacion); $i++) {
				$numero_amenidades = count($array_habitacion[$i]['amenidades']);
		?>
			<div class="modal" id="modal_hab_<?php echo $i + 1; ?>">
				<div class="modal-content">
					<span class="close" onclick="modal('#modal_hab_<?php echo $i + 1; ?>')">&times;</span>
					<div class="row gtr-50 aln-center gtr-uniform">
						<div class="col-12">
							<h3><?php echo $array_habitacion[$i]['habitacion']; ?></h3>
						</div>
						<div class="col-7 col-12-mobile">
							<img src="<?php echo $array_habitacion[$i]['mini']; ?>1.jpg" alt="Imagen Habitación <?php echo $array_habitacion[$i]['habitacion']; ?>" class="image fit">
						</div>
						<div class="col-6 col-12-mobile">
							<?php $array_habitacion[$i]['ocupacion'] != '' ? '<p><b>' . $datos_json['ocupacion'] . '</b> ' . $array_habitacion[$i]['ocupacion'] . '</p>' : ''; ?>
						</div>
						<div class="col-6 col-12-mobile">
							<?php $array_habitacion[$i]['vista'] != '' ? '<p><b>' . $datos_json['vista'] . '</b> ' . $array_habitacion[$i]['vista'] . '</p>' : ''; ?>
						</div>
						<div class="col-12">
							<?php $array_habitacion[$i]['descripcion'] != '' ? '<p>' . $array_habitacion[$i]['descripcion'] . '</p>' : ''; ?>
							<?php $numero_amenidades > 0 ? '<p><b>' . $datos_json['caracteristica'] . '</b></p>' : ''; ?>
						</div>
						<?php
							for ($j=0; $j < $numero_amenidades; $j++) { 
								if ($j == 0 || $j == (ceil($numero_amenidades / 2))) {
									echo '<div class="col-6 col-12-mobile"><ul>';
								}
								echo '<li>' . $array_habitacion[$i]['amenidades'][$j] . '</li>';
								if ($j == ($numero_amenidades - 1) || $j == (ceil($numero_amenidades / 2) - 1)) {
									echo '</ul></div>';
								}
							}
						?>
					</div>
				</div> 
			</div>
		<?php
			}
		?>

		<div class="modal" id="modal-imagen">
            <div class="modal-content-img">
                <span class="close" onclick="modal('#modal-imagen')">&times;</span>
            </div>
        </div>

		<div class="modal" id="modal-alerta">
			<div class="modal-content">
				<img src="" alt="Icono confirmación">
				<h2></h2>
				<p></p>
			</div>
		</div>

	<?php include_once($retorno.'includes/paginas-novios/footer.php'); ?>
	<script>
	</script>
</body>
</html>