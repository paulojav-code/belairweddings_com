<?php
	
	include_once('../includes/php/variables.php');
	include_once('../includes/php/conexion.php');
	include_once('../includes/php/config.php');
	include_once('../includes/wabutton.php');

	$titulo = 'Nuestros servicios';
	$folder = ['servicios','../'];

	$json_raw = file_get_contents('../includes/json/lbdts.json');
	$json_raw = preg_replace("/[\r\n|\n|\r]+/",'', $json_raw);
	$data_lbdts = json_decode($json_raw,TRUE);

	$destinos = $data_lbdts['destinos'];
	
	$paquete_index = -1;

	$paquetes = [
		0 => ['wedding-brunch','titulo-wedding-brunch'],
		1 => ['boda-eco-friendly','titulo-boda-eco-friendly'],
		2 => ['boda-boutique','titulo-boda-boutique'],
		3 => ['tu-boda-cdmx','titulo-tu-boda-cdmx'],
		4 => ['tu-boda-alturas','titulo-tu-boda-alturas'],
		5 => ['despedida-solteres','titulo-despedida-soltere']
	];

	if(isset($_GET)){
		for ($i=0; $i < count($paquetes); $i++) { 
			if(isset($_GET[$paquetes[$i][0]])){
				$paquete_index = $i;
				break;
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
							<section id="titulo-servicios" class="panel spotlight large">
								<div class="content color3 span-10">
									<h2 class="major">La boda de tus <span class="font-anitto">sueños</span></h2>
									<h3 class="major">Obtén tu boda en la playa gratis</h3>
									<a href="../la-boda-de-tus-suenos/">Ver paquete</a>
									<a id='paquete-target' href='#<?php echo $paquetes[$paquete_index][1]; ?>' style="display:block"></a>
								</div>
								<div class="image filtered tinted" data-position="center">
									<img src="<?php echo URL ?>/assets/img/servicios/la_boda_de_tus_sueños_banner_servicios.jpg" alt="" />
								</div>
							</section>

							<section class="panel color1">
								<div class="intro span-2" id="lista-destinos">
									<ul>
									<?php
									for ($i=0; $i < count($destinos); $i++) { 
										if(isset($destinos[$i]['var'])){
											echo '<li><a id="boton-destino-'.$i.'" href="../la-boda-de-tus-suenos/?'.$destinos[$i]['var'].'">'.$destinos[$i]['destino'].'</a></li>';
										}
									}
									?>
									</ul>
								</div>
							</section>

						<!-- Wedding Brunch -->
							<?php include_once('../includes/paquetes/wedding-brunch.php'); ?>

						<!-- Bodas Eco-friendly -->
							<?php include_once('../includes/paquetes/boda-eco-friendly.php'); ?>

						<!-- Bodas Botique -->
							<?php include_once('../includes/paquetes/boda-boutique.php'); ?>
						
						<!-- Luna de Miel -->
							<?php include_once('../includes/paquetes/tu-luna-miel.php'); ?>

						<!-- Tu boda en las alturas -->
							<?php include_once('../includes/paquetes/tu-boda-alturas.php'); ?>

						<!-- Lunas de Miel -->
							<!--<section id="titulo-servicios" class="panel spotlight large right">
								<div class="content color3 span-4">
									<h2 class="major">La boda de tus <span class="font-anitto">sueños</span></h2>
									<h3 class="major">Obten tu boda en la playa gratis</h3>
									<a href="../la-boda-de-tus-suenos/">Ver paquete</a>
								</div>
								<div class="image filtered tinted" data-position="left">
									<img src="<?php echo URL ?>/assets/img/servicios/tu-luna-de-miel-banner-servicios.jpg" alt="" />
								</div>
							</section>-->

						<!-- Despedidas -->
							<?php include_once('../includes/paquetes/despedida-solteres.php'); ?>

						<!-- Tu boda en CDMX -->
							<?php include_once('../includes/paquetes/tu-boda-cdmx.php'); ?>

					<!-- Contacto -->
						<?php include_once('../includes/page-forms/contacto.php'); ?>

					</div>
					
			</div>

		<!-- Scripts -->
			<?php include_once('../includes/page-forms/footer.php'); ?>
			<script>

				$('#formulario_dw_origen').val('Servicios');

				<?php 
					if($paquete_index >= 0 && isset($_GET[$paquetes[$paquete_index][0]])){

						if($paquete_index == 5){
							echo '$( document ).ready(function() {
								$("#titulo-despedida-soltero .content").addClass("active");
								$("#titulo-despedida-soltera .content").addClass("active");
								$("#paquete-target").trigger("click");
							});';
						}else{
							echo '$( document ).ready(function() {
								$("#'.$paquetes[$paquete_index][1].' a").trigger("click");
								$("#paquete-target").trigger("click");
							});';
						}
					}
				?>

				var destinos = [
					<?php
						for ($i=0; $i < count($destinos) - 1; $i++) { 
							if(isset($destinos['var'])){
								echo "['".$destinos[$i]['destino']."',[";
								for ($j=0; $j < count($destinos[$i]['hoteles']); $j++) { 
									echo "'".$destinos[$i]['hoteles'][$j]['nombre']."'";
									if($j != (count($destinos[$i]['hoteles']) - 1)) {
										echo ",";
									}
								}
								echo "],'".$destinos[$i]['banner']."']";
								if($i != (count($destinos) - 1)) {
									echo ",";
								}
							}
						}
					?>
				];

				function show_paquete_info(id) {
					$('.panel-titulo').show();
					if (!$(id).is(':visible')) {
						$('.panel-info').hide();
						$(id).show();
						$(this).html('Menos información');
					} else {
						$(id).hide();
					}

					switch(id){
						case '#info-boda-boutique':
							$('#formulario_dw_origen').val('Boda Boutique');
							break;
						case '#info-boda-eco-friendly':
							$('#formulario_dw_origen').val('Boda Ecofriendly');
							break;
						case '#info-wedding-brunch':
							$('#formulario_dw_origen').val('Wedding Brunch');
							break;
						case '#info-boda-cdmx':
							$('#formulario_dw_origen').val('Tu boda en CDMX');
							break;
						case '#info-boda-alturas':
							$('#formulario_dw_origen').val('Tu boda en las alturas');
							break;
						case '#info-despedida-soltere':
							$('#formulario_dw_origen').val('Despedida de solter@');
							$('#titulo-despedida-soltere .panel-titulo').hide()
							break;
						default:
							break;
					}
				}

				$( ".panel-info ul a" ).click(function() {
					if ($(this).next().is(':visible')) {
						$(this).next().hide();
					} else {
						$(this).next().show();
					}
				});

			</script>

	</body>
</html>