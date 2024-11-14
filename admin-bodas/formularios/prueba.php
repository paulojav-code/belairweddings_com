<?php
	include_once('../include/config.php');
	include_once('../include/conexion.php');

    $tabla_php = '{"name":"idiomas","title":"Idiomas","primary_key":0,"columns":[{"name":"id_idioma","data_type":"i","field_type":"1","primary_key":true,"insert":false},{"name":"nombre","data_type":"s","field_type":"1","max_size":30},{"name":"siglas","data_type":"s","field_type":"1","max_size":10},{"name":"bandera","data_type":"s","field_type":"1","max_size":100},{"name":"bandera_alt","data_type":"s","field_type":"1","max_size":100,"select_name":"bandera alterna"},{"name":"activo","data_type":"i","field_type":"1","insert":false}]}';

	$table_title = 'Idiomas';
	$title = $table_title.' - Formularios Admin Bodas | Dreams Wedding';

	$column_vars = array();

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
			var fields_print = false;
			var tabla = jQuery.parseJSON('<?php echo $tabla_php; ?>');

			const type_fields = {
				1: function(col) {
					var temp_editable = true;
					var temp_max = '';
					if( typeof(col['primary_key']) != "undefined" && col['primary_key'])
						temp_editable = false;
					if( typeof(col['insert']) != "undefined" && !col['insert'])
						temp_editable = false;
					if( typeof(col['max_size']) != "undefined" && col['max_size'] > 0)
						temp_max = 'maxlength="'+col['max_size']+'"';

					return '<input type="text" id="f_'+col['name']+'" name="f_'+col['name']+'"'+(!temp_editable ? ' class="disabled" readonly':'')+temp_max+'/>';
				},
				2: function(col) {
					return '<textarea id="f_'+col['name']+'" name="f_'+col['name']+'" cols="30" rows="10"></textarea>';
				}
			};

			print_fields();

			function print_fields() {
				var fields = '<div class="row gtr-uniform gtr-50">';
				for (let i = 0; i < tabla['columns'].length; i++) {
					fields += '<div class="'+(tabla['columns'][i]['data_type'] == 's' ?'col-4 col-6-narrower col-12-mobile':'col-2 col-4-narrower col-6-mobile')+'">';
					fields += '<label for="f_' + tabla['columns'][i]['name'] + '">' + ((typeof(tabla['columns'][i]['select_name']) != "undefined" && tabla['columns'][i]['select_name'] != "") ? tabla['columns'][i]['select_name']:tabla['columns'][i]['name']) + '</label>';
					fields += type_fields[tabla['columns'][i]['field_type']](tabla['columns'][i]);
					fields += '</div>';
				}
				fields += '</div>';
				fields += '<div class="col-12"><a class="button small">Guardar</a></div>';
				$('#content').html(fields);
				fields_print = true;
			}

			function print_columns_data(res) {

			}

            //request_tabla();

            function request_tabla() {
                var dataString = 'request={"type":"0"}';

                $.ajax({
                    data: dataString,
                    url: '../request/idiomas.php',
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
						tbody += '<td>' + data_res[i][key_res[j]] + '</td>';
					}
					tbody += '</tr>';
				}

				$('#content .table-wrapper thead').html(thead);
				$('#content .table-wrapper tbody').html(tbody);
            }
            
        </script>
	</body>
</html>