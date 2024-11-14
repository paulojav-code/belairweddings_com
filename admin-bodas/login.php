<?php
	include_once('include/config.php');
	include_once('include/conexion.php');

	if(isset($_COOKIE['LOGGE_IN']) && $_COOKIE['LOGGE_IN']) {
		header('Location: index.php');
	}

	$title = 'Log In - Admin Bodas | Dreams Wedding';;

	include_once('include/page-forms/header.php');
?>
		<div id="page-wrapper">

			<?php include_once('include/page-forms/navbar.php'); ?>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container xsmall">
						<header class="major">
							<h2>Admin Bodas</h2>
							<!--<p>Ipsum dolor feugiat aliquam tempus sed magna lorem consequat accumsan</p>--->
						</header>

						<!-- Content -->
							<section id="content">
								<div class="row gtr-uniform gtr-50 aln-center">
									<div class="col-12" id="login_alert">&nbsp;</div>
									<div class="col-12">
										<label for="username">Usuario</label>
										<input type="text" id="username" name="username">
									</div>
									<div class="col-12">
										<label for="password">Contraseña</label>
										<input type="password" id="password" name="password">
									</div>
									<div class="col-12">
										<ul class="actions">
											<li><a id="ingresar" class="button small">Ingresar</a></li>
										</ul>
									</div>
								</div>
							</section>

					</div>
				</div>
			<?php
				include_once('include/page-forms/footer.php');
			?>
		</div>
		<?php
			include_once('include/page-forms/scripts.php');
		?>
		<script>
			function getLogin() {
				var dataString = 'request={"usuario":"' + $('#username').val() + '","contrasena":"' + $('#password').val()+ '"}';

				$.ajax({
					data: dataString,
					url: 'include/php/procesar-login.php',
					type: 'POST',
					success: function(response) {
						printLogin(response);
					},
					error: function(response, status, error) {
						console.log('Error: Autentificacion no encontrada');
					}
				});
			}

			function printLogin(response){
				var res = jQuery.parseJSON(response);
				if(res['login']){
					location.href = "index.php";
				}else{
					$('#login_alert').html('Error: '+res['error']);
				}
			}

			$('#ingresar').on('click',function() {
				$('#login_alert').html('&nbsp;');
				getLogin();
			});
		</script>

	</body>
</html>