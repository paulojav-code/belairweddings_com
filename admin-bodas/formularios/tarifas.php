<?php
	include_once('../include/config.php');
	include_once('../include/conexion.php');

	$table_title = 'Tarifas';
	$title = $table_title.' - Formularios Admin Bodas | Dreams Wedding';

	$id_data_php = 0;

	if(isset($_GET['id']) && $_GET['id'] != ''){
		$id_data_php = $_GET['id'];
	}

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
			var tabla = jQuery.parseJSON('{"name":"tarifas","title":"Tarifas","primary_key":0,"columns":[{"name":"id_tarifa","data_type":"i","field_type":"1","primary_key":true,"insert":false},{"name":"id_novie","data_type":"i","field_type":"0","primary_key":true,"foreign":{"table_name":"novies","key_name":"id_novie","column_name":"id_novie","concat":["person_1","&39; &39;","conector","&39; &39;","person_2"],"select_name":"Novies"}},{"name":"id_habitacion","data_type":"i","field_type":"0","primary_key":true,"foreign":{"table_name":"habitaciones","key_name":"id_habitacion","column_name":[{"column":"id_hotel","data":{"table_name":"hoteles","key_name":"id_hotel","column_name":"nombre","field_column_name":"hotel","select_name":"hotel"}},{"column":"id_habitacion","data":{"table_name":"habitaciones","key_name":"id_habitacion","column_name":"nombre","field_column_name":"nombre","select_name":"habitacion"}}]}},{"name":"precio","data_type":"s","field_type":"1","max_size":10},{"name":"doble","data_type":"s","field_type":"1","max_size":10},{"name":"extra","data_type":"s","field_type":"1","max_size":10},{"name":"junior","data_type":"s","field_type":"1","max_size":10},{"name":"ninho","data_type":"s","field_type":"1","max_size":20},{"name":"activo","data_type":"i","field_type":"1","insert":false}]}');
			var id_data = <?php echo $id_data_php; ?>;
			var pre_data;

			const type_fields = {
				0: function(col) {
					return '<select id="f_'+col['name']+'" name="f_'+col['name']+'"></select>';
				},
				1: function(col) {
					var temp_editable = true;
					var temp_class = '';
					var temp_max = '';
					var temp_value = '';
					if( typeof(col['primary_key']) != "undefined" && col['primary_key']) {
						temp_editable = false;
						temp_class += 'primary ';
					}
					if( typeof(col['insert']) != "undefined" && !col['insert']) {
						temp_editable = false;
					}
					if( typeof(col['max_size']) != "undefined" && col['max_size'] > 0){
						temp_max = ' maxlength="'+col['max_size']+'"';
					}
					if( !temp_editable){
						temp_class += 'disabled ';
					}
					if( typeof(col['default']) != "undefined") {
						temp_value = col['default'];
					}
					temp_class = temp_class.slice(0, -1);
					return '<input type="text" id="f_'+col['name']+'" name="f_'+col['name']+'"'+(!temp_editable ? ' readonly':'')+' class="'+temp_class+'"'+temp_max+' value="'+temp_value+'"/>';
				},
				2: function(col) {
					var temp_value = '';
					if( typeof(col['default']) != "undefined") {
						temp_value = col['default'];
					}
					return '<textarea id="f_'+col['name']+'" name="f_'+col['name']+'" cols="30" rows="3">'+temp_value+'</textarea>';
				},
				3: function(col) {
					return '<input type="text" id="f_'+col['name']+'" name="f_'+col['name']+'" class="date"/>';
				}
			};

			print_fields(id_data);

			function print_fields(id) {
				var fields = '<div class="row gtr-uniform gtr-50">';
				var select_fields = [];
				for (let i = 0; i < tabla['columns'].length; i++) {
					fields += '<div class="'+(tabla['columns'][i]['data_type'] == 's' ?'col-4 col-6-medium col-12-small':'col-2 col-4-medium col-6-small')+'">';
					fields += '<label for="f_' + tabla['columns'][i]['name'] + '">' + ((typeof(tabla['columns'][i]['select_name']) != "undefined" && tabla['columns'][i]['select_name'] != "") ? tabla['columns'][i]['select_name']:tabla['columns'][i]['name']) + '</label>';
					fields += type_fields[tabla['columns'][i]['field_type']](tabla['columns'][i]);
					fields += '</div>';
				}
				fields += '</div>';
				fields += '<div class="col-12"><br><ul class="actions"><li><a class="button primary small">Guardar Nuevo</a></li><li><a class="button small" href="../catalogos/tarifas.php">Cancelar</a></li></li></ul></div>';
				$('#content').html(fields);

				$('#content .actions li:first-child a').on('click',function() {
					request_insert();
				});
				if(id > 0){
					request_data(id);
				}
				for (let i = 0; i < tabla['columns'].length; i++) {
					if(tabla['columns'][i]['field_type'] == 0){
						request_select(tabla['columns'][i]);
					}
				}
				try {
					$(".date").datepicker({
						dateFormat: 'yy/mm/dd',
						firstDay: 1,
						dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
						monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
						monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec"]
					});
				} catch (err) {
					console.log("Error: Actualizar Jquery");
				}
			}
			
			function print_data(res) {
				var key = Object.keys(res[0]);
				pre_data = res[0];
				for (let i = 0; i < key.length; i++) {
					if($('#f_'+key[i]).is("input")){
						$('#f_'+key[i]).val(res[0][key[i]]);
						if(!$('#f_'+key[i]).hasClass("primary")){
							$('#f_'+key[i]).removeClass("disabled");
							$('#f_'+key[i]).attr("readonly", false)
						}
					}else if($('#f_'+key[i]).is("select")){
						Loop_tabla:
						for(var j=0; j<tabla['columns'].length; j++) {
							for(keys in tabla['columns'][j]) {
								if(tabla['columns'][j][keys] == key[i]) {
									request_select(tabla['columns'][j],res[0][key[i]]);
									break Loop_tabla;
								}
							}
						}
					}else {
						$('#f_'+key[i]).html(res[0][key[i]]);
					}
				}
				$('#content .actions li:first-child a').html('Guardar');
				$('#content .actions li:first-child a').off();
				$('#content .actions li:first-child a').on('click',function() {
					request_update();
				});
			}

			function print_select(res,col,id) {
				var select = '<option value="0"></option>';
				var option = '';
				for (let i = 0; i < res.length; i++) {
					if(Array.isArray(col['foreign']['column_name'])){
						option = '';
						for (let j = 0; j < col['foreign']['column_name'].length; j++) {
							option += res[i][col['foreign']['column_name'][j]['data']['field_column_name']]+' - ';
						}
						option = option.slice(0, -3);
						select += '<option value="'+res[i][col['foreign']['key_name']]+'"'+( res[i][col['foreign']['key_name']]==id ? ' selected' : '')+'>'+option+'</option>';
					}else{
						select += '<option value="'+res[i][col['foreign']['key_name']]+'"'+( res[i][col['foreign']['key_name']]==id ? ' selected' : '')+'>'+res[i][col['foreign']['column_name']]+'</option>';
					}
				}
				$('#f_'+col['name']).html(select);
			}

			function request_insert() {
                var dataString = 'request={"type":"1",';
					for (let i = 0; i < tabla['columns'].length; i++) {
						if(typeof(tabla['columns'][i]['insert']) == "undefined" || tabla['columns'][i]['insert']){
							dataString += '"'+tabla['columns'][i]['name']+'":"'+encodeURIComponent($('#f_'+tabla['columns'][i]['name']).val())+'",';
						}
					}
					dataString = dataString.slice(0, -1);
					dataString += '}';

                $.ajax({
                    data: dataString,
                    url: '../request/tarifas.php',
                    type: 'POST',
                    success: function(response) {
						var res = jQuery.parseJSON(response);
                        if(typeof(res['error']) == "undefined"){
							if(res['insert'] > 0){
								print_fields(0);
								alert('Se insertó en tarifas');
								window.location = "../catalogos/tarifas.php";
							}else{
								alert('No insertó en tarifas');
							}
						}else{
							alert('Error:'+res['error']);
						}
                    },
                    error: function(response, status, error) {
                        console.log('Error: Data no encontrada');
                    }
                });
            }

			function request_data(id) {
				var dataString = 'request={"type":"4","id_tarifa":"'+id+'"}';

				$.ajax({
                    data: dataString,
                    url: '../request/tarifas.php',
                    type: 'POST',
                    success: function(response) {
						var res = jQuery.parseJSON(response);
                        if(typeof(res['error']) == "undefined"){
							print_data(res);
						}else{
							alert('Error:'+res['error']);
						}
                    },
                    error: function(response, status, error) {
                        console.log('Error: Data no encontrada');
                    }
                });
			}

			function request_select(col,id=0) {
				if(typeof(col['foreign']['order_by']) != "undefined" && col['foreign']['order_by'] != ''){
					var dataString = 'request={"type":"5","order_by":"'+col['foreign']['order_by']+'"}';
				}else{
					var dataString = 'request={"type":"5","order_by":"'+col['foreign']['key_name']+'"}';
				}

				$.ajax({
                    data: dataString,
                    url: '../request/'+col['foreign']['table_name']+'.php',
                    type: 'POST',
                    success: function(response) {
						var res = jQuery.parseJSON(response);
                        if(typeof(res['error']) == "undefined"){
							print_select(res,col,id);
						}else{
							alert('Error:'+res['error']);
						}
                    },
                    error: function(response, status, error) {
                        console.log('Error: Data no encontrada');
                    }
                });
			}

			function request_update() {
				var dataString = 'request={"type":"2","id_tarifa":"'+$('#f_id_tarifa').val()+'",';
					for (let i = 0; i < tabla['columns'].length; i++) {
						if(typeof(tabla['columns'][i]['insert']) == "undefined" || !tabla['columns'][i]['primary']){
							if($('#f_'+tabla['columns'][i]['name']).val() != pre_data[tabla['columns'][i]['name']]){
								dataString += '"'+tabla['columns'][i]['name']+'":"'+encodeURIComponent($('#f_'+tabla['columns'][i]['name']).val())+'",';
							}
						}
					}
					dataString = dataString.slice(0, -1);
					dataString += '}';

                $.ajax({
                    data: dataString,
                    url: '../request/tarifas.php',
                    type: 'POST',
                    success: function(response) {
						console.log(response);
						var res = jQuery.parseJSON(response);
                        if(typeof(res['error']) == "undefined"){
							if(res['update'] > 0){
								print_fields();
								alert('Se actualizó en tarifas');
								window.location = "../catalogos/tarifas.php";
							}else{
								alert('No actualizó en tarifas');
							}
						}else{
							alert('Error:'+res['error']);
						}
                    },
                    error: function(response, status, error) {
                        console.log('Error: Data no encontrada');
                    }
                });
			}

			$(document).ready(function () {
				
			});
        </script>
	</body>
</html>