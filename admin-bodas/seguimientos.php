<?php
    $title= "Seguimiento";
	include_once('include/config.php');
	include_once('include/conexion.php');
	include_once('include/page-forms/header.php');
?>
		<div id="page-wrapper">

			<?php include_once('include/page-forms/navbar.php'); ?>

			<!-- Main -->
				<div id="main" class="wrapper style1">
					<div class="container">
						<header class="major">
							<h2>Seguimiento</h2>
						</header>

						<!-- Content -->
							<section id="content large">
                                <div class="row">
								<?php
                                function listarArchivos( $path ){
                                    // Abrimos la carpeta que nos pasan como parámetro
                                    $dir = opendir($path);
                                    // Leo todos los ficheros de la carpeta
                                    while ($elemento = readdir($dir)){
                                        // Tratamos los elementos . y .. que tienen todas las carpetas
                                        if( $elemento != "." && $elemento != ".."){
                                            // Si es una carpeta
                                            if( is_dir($path.$elemento) ){
                                                // Muestro la carpeta
                                                echo '<div class="col-12"><p><strong>CARPETA: '.$elemento.'</strong></p></div>';
                                                listarArchivos($path.$elemento.'/');
                                            // Si es un fichero
                                            } else {
                                                // Muestro el fichero
                                                echo '<div class="col-4 col-6-narrower"><img src="'.$path.$elemento.'" alt="" class="image fit"></div>';
                                            }
                                        }
                                    }
                                }
                                // Llamamos a la función para que nos muestre el contenido de la carpeta gallery
                                listarArchivos("../assets/img/seguimientos/");
                                ?>
                                </div>
							</section>


					</div>
			<?php
				include_once('include/page-forms/footer.php');
			?>

	</body>
</html>