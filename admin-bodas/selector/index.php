<?php
	include_once('../include/php/global.php');
    include_once('../include/config.php');
    include_once('../include/conexion.php');
	$title = 'Inicio - Admin Bodas | BelairWedding';

	include_once('../include/page-forms/header.php');
?>
		<style>
			#list_dir p {
				margin-bottom: 0.5em;
			}
			#list_cover_form .imagenes {
				width: 90%;
				margin: 0 auto;
				position: relative;
				overflow: hidden;
			}
			#list_cover_form .imagenes:before {
				padding-top: 100%;
				display: block;
				content: '';
			}
			#list_cover_form .imagenes.ratio1-2:before {
				padding-top: 200%;
			}
			#list_cover_form .imagenes.ratio16-9:before {
				padding-top: 56.25%;
			}
			#list_cover_form .imagenes.ratio3-2:before {
				padding-top: 66.67%;
			}
			#list_cover_form .imagenes img {
				position: absolute;
				object-fit: cover;
				width: 100%;
				height: 100%;
				top: 0;
				bottom: 0;
				right: 0;
				left: 0;
			}

			img.op0-0 {object-position: 0% 0%}
			img.op0-25 {object-position: 0% 25%}
			img.op0-50 {object-position: 0% 50%}
			img.op0-75 {object-position: 0% 75%}
			img.op0-100 {object-position: 0% 100%}
			img.op25-0 {object-position: 25% 0%}
			img.op25-25 {object-position: 25% 25%}
			img.op25-50 {object-position: 25% 50%}
			img.op25-75 {object-position: 25% 75%}
			img.op25-100 {object-position: 25% 100%}
			img.op50-0 {object-position: 50% 0%}
			img.op50-25 {object-position: 50% 25%}
			img.op50-50 {object-position: 50% 50%}
			img.op50-75 {object-position: 50% 75%}
			img.op50-100 {object-position: 50% 100%}
			img.op75-0 {object-position: 75% 0%}
			img.op75-25 {object-position: 75% 25%}
			img.op75-50 {object-position: 75% 50%}
			img.op75-75 {object-position: 75% 75%}
			img.op75-100 {object-position: 75% 100%}
			img.op100-0 {object-position: 100% 0%}
			img.op100-25 {object-position: 100% 25%}
			img.op100-50 {object-position: 100% 50%}
			img.op100-75 {object-position: 100% 75%}
			img.op100-100 {object-position: 100% 100%}

			#list_cover_form input{
					background:transparent;
			}
			#list_cover_form select {
				width: 4em;
				max-width: 100%;
				display: inline-block;
				background-image: none;
				padding-right: 0;
			}
			#list_cover_form select:first-of-type {
				margin-right: 0.5em
			}

			input[type="radio"] + label, input[type="checkbox"] + label {
				margin-bottom: 0.25em;
				padding: 0 0.5em 0 1.75em;
				line-height: 1em;
			}
			input[type="radio"] + label:before, input[type="checkbox"] + label:before {
				height: 1.75em;
				width: 1.75em;
				line-height: 1.75em;
				font-size: 0.7em;
			}
			#cta{
				padding:2em;
			}
			.box{
				margin: 3em 0;
			}
		</style>
			<div id="page-wrapper">
			<?php include_once('../include/page-forms/navbar.php'); ?>
				<!-- Banner --> 

			<!-- Main -->
			<section id="main" class="container large">

<section class="box">
	<div class="row gtr-25">
		<div class="col-5 col-12-mobile">
			<h3>Carpetas</h3>
			<select name="select_dir" id="select_dir">
				<option value="">Seleccionar carpeta</option>
			</select>
		</div>
		<div class="col-6">
			<h3>_ </h3>
			<input type="submit" class="small" value="Abrir" onclick="request_list_files($('#select_dir').val())">
		</div>
		<div class="col-12">
			<br>
			<div class="row gtr-uniform" id="list_dir">
			</div>
			<br>
			<div class="row gtr-uniform" id="list_cover_form">
			</div>
		</div>
	</div>
</section>
</section>

<?php include_once('../include/page-forms/footer.php'); ?>

</div>

<?php include_once('../include/page-forms/scripts.php'); ?>
<script>
	var list_files;
	var select_dir;
	function request_dir() {
		var dataString = 'request={"id":0}';
		$.ajax({
		data: dataString,
		url: '../include/php/request_selector.php',
		type: 'POST',
		success: function(response) {
			
			var res = jQuery.parseJSON(response);
			for (let i = 0; i < res.length; i++) {
				$('#select_dir').append('<option value="'+res[i]+'">'+res[i]+'</option>');
			}
			
		},
		error: function(response, status, error) {
			console.log('Error: Data no encontrada');
		}
		});
	}
	request_dir();
	function request_list_files(dir) {
		select_dir = dir;
		var dataString = 'request={"id":1,"dir":"'+dir+'"}';
		$.ajax({
		data: dataString,
		url: '../include/php/request_selector.php',
		type: 'POST',
		success: function(response) {
			var res = jQuery.parseJSON(response);
			for (let i = 0; i < res.length; i++) {
				$('#list_dir').append(
					'<div class="col-2 col-6-mobile">'+
					//'<div class="imagenes"><img src="../assets/img/wp/'+dir+'/'+res[i]+'" class=""/></div>'+
					'<img src="../assets/img/wp/'+dir+'/'+res[i]+'" class="image fit"/>'+
					'<p>'+res[i]+'</p>'+
					'<input type="radio" id="cover_'+i+'" name="select_cover" value="'+i+'"><label for="cover_'+i+'">Cover</label>'+
					'<input type="radio" id="form_'+i+'" name="select_form" value="'+i+'"><label for="form_'+i+'">Form</label>'+
					'<input type="checkbox" id="galeria_'+i+'" name="galeria_'+i+'" value="'+i+'" checked><label for="galeria_'+i+'">Galeria</label>'+
					'</div>'
				);
			}
			$('#list_dir').append('<div class="col-12"><input type="submit" class="small form_cover" value="Cover/Form"> <input type="submit" class="small galeria" value="Galeria"></div>');
			$('#list_dir input.form_cover').on('click',function(){
				get_cover_form();
			});
			$('#list_dir input.galeria').on('click',function(){
				get_galeria();
			});
			list_files = res;
		},
		error: function(response, status, error) {
			console.log('Error: Data no encontrada');
		}
		});
	}
	function get_cover_form() {
		var cover = select_dir+'/'+list_files[$('input:radio[name=select_cover]:checked').val()];
		var form = select_dir+'/'+list_files[$('input:radio[name=select_form]:checked').val()];
		$('#list_cover_form').html('');
		$('#list_cover_form').append('<div class="col-5 col-6-"><div id="sel_1_img" class="imagenes ratio16-9"><img src="../assets/img/wp/'+cover+'" class=""/></div></div>');
		$('#list_cover_form').append('<div class="col-2 col-6-"><div id="sel_2_img" class="imagenes"><img src="../assets/img/wp/'+cover+'" class=""/></div></div>');
		$('#list_cover_form').append('<div class="col-2 col-6-"><div id="sel_3_img" class="imagenes ratio1-2"><img src="../assets/img/wp/'+cover+'" class=""/></div></div>');
		$('#list_cover_form').append('<div class="col-3 col-6-"><div id="sel_4_img" class="imagenes"><img src="../assets/img/wp/'+form+'" class=""/></div></div>');
		$('#list_cover_form').append(`<div class="col-5 col-6-"><input name="sel_1_x" id="sel_1_x" value="50" type="number" min="0" max="100"><input name="sel_1_y" id="sel_1_y" value="50" type="number" min="0" max="100"></div>`);
		$('#list_cover_form').append(`<div class="col-2 col-6-mobile"><input name="sel_2_x" id="sel_2_x" value="50" type="number" min="0" max="100"><input name="sel_2_y" id="sel_2_y" value="50" type="number" min="0" max="100"></div>`);
		$('#list_cover_form').append(`<div class="col-2 col-6-mobile"><input name="sel_3_x" id="sel_3_x" value="50" type="number" min="0" max="100"><input name="sel_3_y" id="sel_3_y" value="50" type="number" min="0" max="100"></div>`);
		$('#list_cover_form').append(`<div class="col-3 col-6-mobile"><input name="sel_4_x" id="sel_4_x" value="50" type="number" min="0" max="100"><input name="sel_4_y" id="sel_4_y" value="50" type="number" min="0" max="100"></div>`);
		$('#list_cover_form input').on('keyup',function(){
		var raiz = $(this).attr('id').substring(0,6);
		$('#'+raiz+'img img').css('object-position',`${$('#'+raiz+'x').val()}% ${$('#'+raiz+'y').val()}%`)
		});
		$('#list_cover_form').append('<div class="col-12"><input type="submit" class="small" value="Enviar"></div>');
		$('#list_cover_form input:submit').on('click',function(){
		request_cover_form(cover,form);
		});
	}
	function request_cover_form(cover,form){
		var dataString = 'request='+encodeURIComponent('{"id":2,"dir":"'+select_dir+'","cover":{"url":"'+cover+'","size":{"cover":['+$('#sel_1_x').val()+','+$('#sel_1_y').val()+'],"small":['+$('#sel_2_x').val()+','+$('#sel_2_y').val()+'],"large":['+$('#sel_3_x').val()+','+$('#sel_3_y').val()+']}},"form":{"url":"'+form+'","size":['+$('#sel_4_x').val()+','+$('#sel_4_y').val()+']}}');

		$.ajax({
		data: dataString,
		url: '../include/php/request_selector.php',
		type: 'POST',
		success: function(response) {
			var res = JSON.parse(response);
			if(typeof res.error === 'undefined'){
				console.log('Respuesta o accion de correcto')
			}
		},
		error: function(response, status, error) {
			console.log('Error: Data no encontrada');
		}
		});
	}
	function get_galeria(){
		var gal = $('#list_dir input:checkbox:checked');
		console.log(gal)
		$('#list_cover_form').html('');
		for (let i = 0; i < gal.length; i++) {
			let n = i>9?i:'0'+i;
			$('#list_cover_form').append(`
				<div class="col-3 col-6-">
					<div id="gal_${n}_img" class="imagenes ratio3-2">
						<img src="../assets/img/wp/${select_dir}/${list_files[gal[i]['value']]}" class=""/>
					</div>
					<br>
					<input name="gal_'${n}_x" id="gal_${n}_x" value="50" type="number" min="0" max="100">
					<input name="gal_${n}_y" id="gal_${n}_y" value="50" type="number" min="0" max="100">
				</div>
			`);
		}
		//gal.forEach((e,i) => {
		//	let n = i>9?i:'0'+i;
		//	$('#list_cover_form').append(`
		//	<div class="col-3 col-6-">
		//		<div id="gal_${n}_img" class="imagenes ratio3-2">
		//			<img src="../assets/img/wp/${select_dir}/${list_files[e]}" class=""/>
		//		</div>
		//		<br>
		//		<input name="gal_'${n}_x" id="gal_${n}_x" value="50">
		//		<input name="gal_${n}_y" id="gal_${n}_y" value="50">
		//	</div>
		//	`);
		//});


		$('#list_cover_form input').on('keyup',function(){
		var raiz = $(this).attr('id').substring(0,6);
		$('#'+raiz+'_img img').css('object-position',`${$('#'+raiz+'_x').val()}% ${$('#'+raiz+'_y').val()}%`)
		});
		$('#list_cover_form').append('<div class="col-12"><input type="submit" class="small" value="Enviar"></div>');
		$('#list_cover_form input:submit').on('click',function(){
		request_galeria(gal);
		});
	}
	function request_galeria(gal) {
		var jsonDataString = '{"id":3,"dir":"'+select_dir+'","galeria":[';
		for (let i = 0; i < gal.length; i++) {
		let n = i>9?i:'0'+i;
		jsonDataString += '{"url":"'+list_files[gal[i]['value']]+'","size":['+$('#gal_'+n+'_x').val()+','+$('#gal_'+n+'_y').val()+']},' 
		}
		jsonDataString = jsonDataString.slice(0, -1);
		jsonDataString += ']}';
		var dataString = 'request='+encodeURIComponent(jsonDataString);
		$.ajax({
		data: dataString,
		url: '../include/php/request_selector.php',
		type: 'POST',
		success: function(response) {
			var res = JSON.parse(response);
			if(typeof res.error === 'undefined'){
				console.log('Respuesta o accion de correcto')
			}
		},
		error: function(response, status, error) {
			console.log('Error: Data no encontrada');
		}
		});
	}
</script>

			</div>
			
	</body>
</html>