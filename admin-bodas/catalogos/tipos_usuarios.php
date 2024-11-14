<?php
	include_once('../include/config.php');
	include_once('../include/conexion.php');

	$table_title = 'Tipos Usuarios';
	$title = $table_title.' - Catalogos Admin Bodas | Dreams Wedding';

	include_once('../include/page-forms/header.php');
?>
		<div id="page-wrapper">

			<?php include_once('../include/page-forms/navbar.php'); ?>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container large">
						<header class="major">
							<h2><?php echo $table_title; ?></h2>
							<!--<p>Ipsum dolor feugiat aliquam tempus sed magna lorem consequat accumsan</p>--->
						</header>

						<!-- Content -->
							<section id="content">
								<div class="table-wrapper">
									<table class="alt">
										<thead>
										</thead>
										<tbody>
										</tbody>
										<tfoot>
										</tfoot>
									</table>
								</div>
							</section>
					</div>
				</div>
			<?php
				include_once('../include/page-forms/footer.php');
			?>
		</div>
		<?php
			include_once('../include/page-forms/scripts.php');
		?>
        <script>
            request_tabla();

            function request_tabla() {
                var dataString = 'request={"type":"0"}';

                $.ajax({
                    data: dataString,
                    url: '../request/tipos_usuarios.php',
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
				var tbody = '';

				thead += '<tr>';
				for (let i = 0; i < key_res.length; i++) {
					thead += '<th>' + key_res[i] + '</th>';
				}
				thead += '</tr>';
				for (let i = 0; i < data_res.length; i++) {
					tbody += '<tr>';
					for (let j = 0; j < key_res.length; j++) {
						if(key_res[j] == 'id_tipo_usuario'){
							tbody += '<td><a href="../formularios/tipos_usuarios.php?id='+data_res[i][key_res[j]]+'">' + data_res[i][key_res[j]] + '</a></td>';
						}else{
							tbody += '<td>' + data_res[i][key_res[j]] + '</td>';
						}
					}
					tbody += '</tr>';
				}

				$('#content .table-wrapper thead').html(thead);
				$('#content .table-wrapper tbody').html(tbody);
            }
            
        </script>
	</body>
</html>