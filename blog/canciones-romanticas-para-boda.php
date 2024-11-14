<?php
include_once('../includes/php/config.php');
include_once('../includes/php/variables.php');
include_once('../includes/php/conexion.php');

$id_request = 318;
$array_data = array();

$sql = 'SELECT titulo, contenido, imagen, t2.nombre AS categoria, t2.id_categoria, DATE_FORMAT(fecha,"%d") AS dia, DATE_FORMAT(fecha,"%m") AS mes, DATE_FORMAT(fecha,"%Y") AS anho, t3.nombre AS autor, t3.id_autor
        FROM eze_blog.articulos AS t1
        INNER JOIN eze_blog.categorias AS t2 ON t1.id_categoria = t2.id_categoria
		INNER JOIN eze_blog.autores AS t3 ON t1.id_autor = t3.id_autor
        WHERE id_articulo = ?;';

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_request);
$stmt->execute();

$result = $stmt->get_result();

while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
	$array_data[] = $req;
}

$stmt->close();

$titulo = $array_data[0]['titulo'];
$folder = ['blog', '../'];

$contacto = false;

$array_data[0]['contenido'] = str_replace('\"', '&34;', $array_data[0]['contenido']);
$array_data[0]['contenido'] = str_replace('"', '&34;', $array_data[0]['contenido']);
$array_data[0]['contenido'] = str_replace("'", '"', $array_data[0]['contenido']);
$array_data[0]['contenido'] = str_replace('&34;', '\"', $array_data[0]['contenido']);
$array_data[0]['contenido'] = str_replace('&39;', "'", $array_data[0]['contenido']);

$array = json_decode($array_data[0]['contenido'], true);

include_once('../includes/page-forms/header.php');
?>
<!-- Page Wrapper -->
<div id="page-wrapper">

	<!-- Navbar -->
	<?php include_once('../includes/page-forms/navbar.php'); ?>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Panel (Banner) -->
		<section id="titulo-articulo" class="panel spotlight custom center">
			<div class="image filtered blog">
				<img src="<?php echo URL . '/' . $array_data[0]['imagen'] ?>" alt="">
			</div>
			<div class="content color6 span-6">
				<div class="titulo">
					<h2 class="major"><?php echo $array_data[0]['titulo'] ?></h2>
					<hr>
					<ul>
						<li><?php echo $array_data[0]['dia'] . '-' . $array_data[0]['mes'] . '-' . $array_data[0]['anho']; ?></li>
						<li><i><a href="../blog?cat=<?php echo $array_data[0]['id_categoria'] ?>"><?php echo $array_data[0]['categoria'] ?></a></i></li>
						<li>Por <i><a href="../blog?aut=<?php echo $array_data[0]['id_autor'] ?>"><?php echo $array_data[0]['autor'] ?></a></i></li>
					</ul>
					<a onclick="scrollblog()"><i class="icon solid fa-chevron-down"></i></a>
				</div>
				<div id="cuerpo">
					<?php
					for ($i = 0; $i < count($array); $i++) {
						switch ($array[$i]['type']) {
							case 't':
								echo '<h3>' . $array[$i]['data'] . '</h3>';
								break;
							case 'c':
								echo '<p>' . $array[$i]['data'] . '</p>';
								break;
							case 'p':
								echo '<p class="small">' . $array[$i]['data'] . '</p>';
								break;
							case 'i':
								echo '<div>
                                        <img src="'. $array[$i]['data'] . '" alt="" class="img-fluid imagenesBlog lazyload text-center px-1 px-md-5 py-4 w-75">
                                    </div>';
								break;
							case 'r':
								echo '<div class="resaltado">
                                        <p>' . $array[$i]['data'] . '</p>
                                    </div>';
								break;
							case 'l':
								echo '<ul>';
								$array_list = explode('|', $array[$i]['data']);
								for ($j = 0; $j < count($array_list); $j++) {
									echo '<li>' . $array_list[$j] . '</li>';
								}
								echo '</ul>';
								break;
							case 'ln':
								echo '<ol>';
								$array_list = explode('|', $array[$i]['data']);
								for ($j = 0; $j < count($array_list); $j++) {
									echo '<li>' . $array_list[$j] . '</li>';
								}
								echo '</ol>';
								break;
							case 'y':
								preg_match('/v=(.*)/', $array[$i]['data'], $matches, PREG_OFFSET_CAPTURE);
								echo '<div class="youtube">
                                        <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/' . substr($matches[1][0], 0, 11) . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>';
								break;
							case 'pt':
								echo '<div class="pinterest-desk"><a data-pin-do="embedBoard" data-pin-lang="es" data-pin-board-width="500" data-pin-scale-height="240" data-pin-scale-width="80" href="' . $array[$i]['data'] . '"></a></div>';
								echo '<div class="pinterest-mobile"><a data-pin-do="embedBoard" data-pin-lang="es" data-pin-board-width="300" data-pin-scale-height="240" data-pin-scale-width="80" href="' . $array[$i]['data'] . '"></a></div>';
								break;
							case 'pp':
								echo '<div class="pinterest-desk pin"><a data-pin-do="embedPin" data-pin-lang="es" data-pin-width="medium" data-pin-terse="true" href="' . $array[$i]['data'] . '"></a></div>';
								echo '<div class="pinterest-mobile pin"><a data-pin-do="embedPin" data-pin-lang="es" data-pin-terse="true" href="' . $array[$i]['data'] . '"></a></div>';
								break;
							default:
								echo '<p>' . $array[$i]['data'] . '</p>';
								break;
						}
					}
					?>
					<h3 class="hashtag"><a href="https://www.facebook.com/hashtag/dreamswedding">#DreamsWedding</a></h3>
				</div>
			</div>
		</section>

		<!-- Contacto -->
		<?php include_once('../includes/page-forms/contacto.php'); ?>

	</div>

</div>

<!-- Scripts -->
<?php include_once('../includes/page-forms/footer.php'); ?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<script>
	if (breakpoints.active('>small')) {
		settings.scrollWheel.enabled = false;
	}

	function scrollblog() {
		var $container = $('#titulo-articulo'),
			$scrollTo = $('#cuerpo');

		if (breakpoints.active('<=small')) {
			$('body,html').animate({
					scrollTop: ($scrollTo.offset().top - ($('#header').height()) - (1 * parseInt($('#wrapper').css('font-size'))))
				},
				1000, "swing"
			)
		} else {
			$container.animate({
					scrollTop: ($scrollTo.offset().top - Math.max(($(window).height() - (37 * parseInt($('#wrapper').css('font-size')))) / 2))
				},
				1000, "swing"
			)
		}
	}
</script>

</body>

</html>