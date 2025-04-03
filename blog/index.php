<?php
include_once('../includes/php/config.php');
include_once('../includes/php/variables.php');
include_once('../includes/php/conexion.php');

$titulo = 'Blog';
$folder = ['blog', '../'];

$contacto = false;

$id_unidad_negocio = 2;

$array_data = array();

/* SQL Blog */
$sql = 'SELECT id_articulo, titulo, t1.ruta, imagen, DATE_FORMAT(fecha,"%d") AS dia, DATE_FORMAT(fecha,"%m") AS mes, DATE_FORMAT(fecha,"%Y") AS anho, t2.nombre AS categoria, descripcion
		FROM eze_blog.articulos AS t1
		INNER JOIN eze_blog.categorias AS t2 ON t1.id_categoria = t2.id_categoria
		WHERE t1.id_unidad_negocio = ? AND t1.activo = 1
		ORDER BY t1.fecha DESC;';

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_unidad_negocio);
$stmt->execute();

$result = $stmt->get_result();

while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
	$array_data[] = $req;
}

$stmt->close();
echo $array_data;
include_once('../includes/page-forms/header.php');
?>
<!-- Page Wrapper -->
<div id="page-wrapper">

	<!-- Navbar -->
	<?php include_once('../includes/page-forms/navbar.php'); ?>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Panel (Banner) -->
		<section id="titulo-blog" class="panel">
			<div class="intro color2 span-1-5">
				<h2 class="major">Blog</h2>
			</div>
		</section>

		<section class="panel spotlight medium right">
			<div class="content color4 span-4 datos-articulo">
				<h2 class="major"><?php echo $array_data[0]['titulo']?></h2>
				<hr>
				<ul>
					<li><?php echo $array_data[0]['dia'].'-'.$array_data[0]['mes'].'-'.$array_data[0]['anho']; ?></li>
					<li><a href="<?php echo URL.'/blog/'.$array_data[0]['ruta']; ?>.php">Leer nota</a></li>
				</ul>
			</div>
			<div class="image filtered transparent">
				<img src="<?php echo URL . '/' . $array_data[0]['imagen']?>" alt="">
			</div>
		</section>

		<section class="panel">
			<div class="gallery">
				<?php
					for ($i=1; $i <= count($array_data) - 1; $i++) { 
						if($i % 2 == 1){
							echo '<div class="group span-5">';
						}
						echo '<div class="image filtered transparent span-2-5" data-position="center"><img src="'.URL.'/assets/img/blog/'.$array_data[$i]['id_articulo'].'/mini.jpg" alt="" />';
						echo '<div class="container datos-articulo">
							<h3>'.$array_data[$i]['titulo'].'</h3>
							<hr>
							<ul>
								<li>'.$array_data[$i]['dia'].'-'.$array_data[$i]['mes'].'-'.$array_data[$i]['anho'].'</li>
								<li><a href="'.URL.'/blog/'.str_replace(array('/blog/', '.php'), '', $array_data[$i]['ruta']).'.php">Leer nota</a></li>
							</ul>
						</div>';
						echo '</div>';
						if($i % 2 == 0){
							echo '</div>';
						}
					}
				?>
			</div>
		</section>

		<!-- Contacto -->
		<?php include_once('../includes/page-forms/contacto.php'); ?>

	</div>

</div>

<!-- Scripts -->
<?php include_once('../includes/page-forms/footer.php'); ?>

</body>

</html>