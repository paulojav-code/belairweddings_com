<?php
	include_once('../include/config.php');
	include_once('../include/conexion.php');

	$title = 'Publicar - Admin Bodas | Dreams Wedding';

	$array_resquest = array();
	if(isset($_POST['request']) || isset($_GET['request'])){
        if(isset($_POST['request'])) {
            $_POST['request'] = urldecode($_POST['request']);
            $array_resquest = json_decode($_POST['request'], true);
        }else if(isset($_GET['request'])) {
            $_GET['request'] = urldecode($_GET['request']);
            $array_resquest = json_decode($_GET['request'], true);
        }
    }

	if(count($array_resquest ) > 0){
		include_once('../include/php/creador-wp-token.php');
	}

	include_once('../include/page-forms/header.php');
?>
		<div id="page-wrapper">

			<style>
				td:last-child i { cursor:pointer}
				td:last-child i:hover {
					color: var(--color-rosa);
				}
				i.seleccionado {
					color: var(--color-rosa);
				}
				ul.actions {
					justify-content: flex-end;
				}
				h4 {
					margin-bottom: 0;
				}
			</style>

			<?php include_once('../include/page-forms/navbar.php'); ?>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container large">
						<header class="major">
							<h2>Publicar</h2>
							<!--<p>Ipsum dolor feugiat aliquam tempus sed magna lorem consequat accumsan</p>--->
						</header>

						<!-- Content -->
							<section id="content">
								<?php
								if(count($array_resquest ) <= 0){
								?>
								<div id="publicar" style="display:none">
									<h3>Por publicar</h3>
									<div class="table-wrapper">
										<table class="alt">
											<thead></thead>
											<tbody></tbody>
										</table>
									</div>
									<ul class="actions">
										<li><a class="button primary small">Publicar</a></li>
									</ul>
								</div>
								<div id="activo-5">
									<h3>No publicados</h3>
									<div class="table-wrapper">
										<table class="alt">
											<thead></thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
								<div id="activo-1">
									<h3>Volver a publicar</h3>
									<div class="table-wrapper">
										<table class="alt">
											<thead></thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
								<?php
								}else{
									$array_keys = array_keys($array_response[0]);

									$thead = '<tr>';
									for ($j=0; $j < count($array_keys); $j++) { 
										$thead .= '<th>'.$array_keys[$j].'</th>';
									}
									$thead .= '</tr>';

									$tbody = '';
									for ($i=0; $i < count($array_response); $i++) {
										$tbody .= '<tr>';
										for ($j=0; $j < count($array_keys); $j++) {
											if($array_keys[$j] == 'ruta_local' || $array_keys[$j] == 'ruta_dw'){
												$tbody .= '<td><a href="'.$array_response[$i][$array_keys[$j]].'" target="_blank">'.$array_response[$i][$array_keys[$j]].'</a></td>';
											}else{
												$tbody .= '<td>'.$array_response[$i][$array_keys[$j]].'</td>';
											}
										}
										$tbody .= '</tr>';
									}
								?>
								<div>
									<div class="table-wrapper">
										<table class="alt">
											<thead><?php echo $thead; ?></thead>
											<tbody><?php echo $tbody; ?></tbody>
										</table>
									</div>
								</div>
								<?php
									for ($i=0; $i < count($array_response); $i++) { 
										echo '<h4>'.$array_response[$i]['novies'].'</h4>';
										echo '<p>'.$array_response[$i]['ruta_dw'].'</p>';
									}
								?>
								<ul class="actions">
									<li><a class="button primary small" href="index.php">Continuar</a></li>
								</ul>
								<?php
								}
								?>
							</section>

					</div>
			<?php
				include_once('../include/page-forms/footer.php');
			?>
		</div>
		<?php
			include_once('../include/page-forms/scripts.php');
		?>
		<script>
			<?php
				if(count($array_resquest ) <= 0){
					echo 'request_tabla();';
				}
			?>

			function request_tabla() {
				var dataString = 'request={"type":"creador"}';

				$.ajax({
					data: dataString,
					url: '../request/novies.php',
					type: 'POST',
					success: function(response) {
						print_tabla(response);
					},
					error: function(response, status, error) {
						console.log('Error: Data no encontrada');
					}
				});
			}

			function print_tabla(res) {
				var data_res = jQuery.parseJSON(res);
				var key_res = Object.keys(data_res[0]);
                var thead = '';
				var tbody = {
					0:"",1:"",5:""
				};
				const DEFAULT_COLUMNS = function(col){
					return '<th>' + col + '</th>'
				};
				const COLUMNS = {
					'id_novie': function(col){ return '<th width="20%">' + col + '</th>';},
					'activo': function(col){return '<th width="10%">' + col + '</th>';},
				};

				thead += '<tr>';
				for (let i = 0; i < key_res.length; i++) {
					thead += COLUMNS[key_res[i]] ? COLUMNS[key_res[i]](key_res[i]) : DEFAULT_COLUMNS(key_res[i]);
				}
				thead += '<th style="width:10%;"></th>';
				thead += '</tr>';
				for (let i = 0; i < data_res.length; i++) {
					tbody[0] = '<tr id="r_' + data_res[i]['id_novie'] + '">';
					for (let j = 0; j < key_res.length; j++) {
						tbody[0] += '<td>' + data_res[i][key_res[j]] + '</td>';
					}
					tbody[0] += '<td style="text-align:center"><i id="b_' + data_res[i]['id_novie'] + '" class="icon solid ' + (data_res[i]['activo'] == 5 ? 'fa-file-upload':'fa-redo-alt') + '"></i></td>';
					tbody[0] += '</tr>';
					tbody[data_res[i]['activo']] += tbody[0];
				}

				$('#publicar thead').html(thead);
				$('#activo-5 thead').html(thead);
				$('#activo-1 thead').html(thead);
				$('#activo-5 tbody').html(tbody[5]);
				$('#activo-1 tbody').html(tbody[1]);

				$('td:last-child i').on('click',function(){
					var id = $(this).attr('id').slice(2);
					
					if($(this).hasClass('seleccionado')){
						if($(this).hasClass('fa-file-upload')){
							$('#r_' + id).appendTo('#activo-5 tbody');
						}else{
							$('#r_' + id).appendTo('#activo-1 tbody');
						}
						$(this).removeClass('seleccionado');
					}else{
						$('#r_' + id).appendTo('#publicar tbody');
						$(this).addClass('seleccionado');
					}
					if($('#publicar tbody').is(':empty')) {
						$('#publicar').hide();
					}else{
						$('#publicar').show();
					}
				});
            }
			$('#publicar .button').on('click',function(){
				var select = $('#publicar tbody tr').toArray();
				var request = '[';
				for (let i = 0; i < select.length; i++) {
					request += select[i]['id'].slice(2) + ',';
				}
				request = request.slice(0,-1);
				request += ']';
				window.location = "token.php?request="+request;
			});
		</script>

	</body>
</html>