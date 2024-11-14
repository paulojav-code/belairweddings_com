<?php
	include_once('include/config.php');
	include_once('include/php/global.php');
	include_once('include/conexion.php');

	$title = 'Inicio - Admin Bodas | Dreams Wedding';;

	include_once('include/page-forms/header.php');
?>
		<div id="page-wrapper">

			<?php include_once('include/page-forms/navbar.php'); ?>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container">
						<header class="major">
							<h2>Admin Bodas</h2>
							<!--<p>Ipsum dolor feugiat aliquam tempus sed magna lorem consequat accumsan</p>--->
						</header>

						<!-- Content -->
							<section id="content">
								<input type="text" id="token">
                                <a onclick="cortar()" class="button">Cortar</a>
                                <p id="result"></p>
							</section>

					</div>
			<?php
				include_once('include/page-forms/footer.php');
			?>
		</div>
		<?php
			include_once('include/page-forms/scripts.php');
		?>
        <script>
            function cortar() {
                var t = $('#token').val();
				$('#token').val('');
                $('#result').html(t.substring(0, 50));
            }
        </script>

	</body>
</html>
