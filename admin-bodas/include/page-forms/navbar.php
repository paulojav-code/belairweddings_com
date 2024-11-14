<!-- Header -->
<header id="header">
	<h1 id="logo"><a href="<?php echo URL; ?>/index.php">Admin Bodas</a></h1>
	<?php
		if(isset($_COOKIE['LOGGE_IN']) && $_COOKIE['LOGGE_IN']){
	?>
		<nav id="nav">
			<ul>
				<li><a href="<?php echo URL; ?>/imagenes">Imagenes</a></li>
				<li><a href="<?php echo URL; ?>/selector">Selector</a></li>
				<li><a href="<?php echo URL; ?>/index.php">Home</a></li>
				<li>
					<a href="#">Catalogos</a>
					<ul>
						<li>
							<a href="">Usuarios</a>
							<ul>
								<li><a href="<?php echo URL; ?>/catalogos/usuarios.php">Usuarios</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/tipos_usuarios.php">Tipos Usuarios</a></li>
							</ul>
						</li>
						<li>
							<a href="">Destinos</a>
							<ul>
								<li><a href="<?php echo URL; ?>/catalogos/destinos.php">Destinos</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/destinos_desc.php">Descripcion</a></li>
							</ul>
						</li>
						<li>
							<a href="">Hoteles</a>
							<ul>
								<li><a href="<?php echo URL; ?>/catalogos/hoteles.php">Hoteles</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/hoteles_desc.php">Descripcion</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/habitaciones.php">Habitaciones</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/habitaciones_desc.php">Descripcion Habitaciones</a></li>
							</ul>
						</li>
						<li>
							<a href="">Novies</a>
							<ul>
								<li><a href="<?php echo URL; ?>/catalogos/novies.php">Novies</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/novies_desc.php">Descripcion</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/novies_token.php">Token</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/tarifas.php">Tarifas</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/detalles_tarifas.php">Detalles Tarifas</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/mesa_regalos.php">Mesa de Regalos</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/novies_css.php">CSS Novies</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/comentarios.php">Comentarios</a></li>
							</ul>
						</li>
						<li>
							<a href="">Ceremonias</a>
							<ul>
								<li><a href="<?php echo URL; ?>/catalogos/ceremonias.php">Ceremonias</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/ceremonias_direccion.php">Dirección</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/ceremonias_desc.php">Descripcion</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/tipos_ceremonias.php">Tipos</a></li>
								<li><a href="<?php echo URL; ?>/catalogos/tipos_ceremonias_desc.php">Descripcion Tipos</a></li>
							</ul>
						</li>
						<li><a href="<?php echo URL; ?>/catalogos/ejecutivos.php">Ejecutivos</a></li>
						<li><a href="<?php echo URL; ?>/catalogos/idiomas.php">Idiomas</a></li>
					</ul>
				</li>
				<li>
					<a href="#">Formularios</a>
					<ul>
						<li>
							<a href="">Usuarios</a>
							<ul>
								<li><a href="<?php echo URL; ?>/formularios/usuarios.php">Usuarios</a></li>
								<li><a href="<?php echo URL; ?>/formularios/tipos_usuarios.php">Tipos Usuarios</a></li>
							</ul>
						</li>
						<li>
							<a href="">Destinos</a>
							<ul>
								<li><a href="<?php echo URL; ?>/formularios/destinos.php">Destinos</a></li>
								<li><a href="<?php echo URL; ?>/formularios/destinos_desc.php">Descripcion</a></li>
							</ul>
						</li>
						<li>
							<a href="">Hoteles</a>
							<ul>
								<li><a href="<?php echo URL; ?>/formularios/hoteles.php">Hoteles</a></li>
								<li><a href="<?php echo URL; ?>/formularios/hoteles_desc.php">Descripcion</a></li>
								<li><a href="<?php echo URL; ?>/formularios/habitaciones.php">Habitaciones</a></li>
								<li><a href="<?php echo URL; ?>/formularios/habitaciones_desc.php">Descripcion Habitaciones</a></li>
							</ul>
						</li>
						<li>
							<a href="">Novies</a>
							<ul>
								<li><a href="<?php echo URL; ?>/formularios/novies.php">Novies</a></li>
								<li><a href="<?php echo URL; ?>/formularios/novies_desc.php">Descripcion</a></li>
								<li><a href="<?php echo URL; ?>/formularios/novies_token.php">Token</a></li>
								<li><a href="<?php echo URL; ?>/formularios/tarifas.php">Tarifas</a></li>
								<li><a href="<?php echo URL; ?>/formularios/detalles_tarifas.php">Detalles Tarifas</a></li>
								<li><a href="<?php echo URL; ?>/formularios/mesa_regalos.php">Mesa de Regalos</a></li>
								<li><a href="<?php echo URL; ?>/formularios/novies_css.php">CSS Novies</a></li>
								<li><a href="<?php echo URL; ?>/formularios/comentarios.php">Comentarios</a></li>
							</ul>
						</li>
						<li>
							<a href="">Ceremonias</a>
							<ul>
								<li><a href="<?php echo URL; ?>/formularios/ceremonias.php">Ceremonias</a></li>
								<li><a href="<?php echo URL; ?>/formularios/ceremonias_direccion.php">Dirección</a></li>
								<li><a href="<?php echo URL; ?>/formularios/ceremonias_desc.php">Descripcion</a></li>
								<li><a href="<?php echo URL; ?>/formularios/tipos_ceremonias.php">Tipos</a></li>
								<li><a href="<?php echo URL; ?>/formularios/tipos_ceremonias_desc.php">Descripcion Tipos</a></li>
							</ul>
						</li>		
						
						<li><a href="<?php echo URL; ?>/formularios/ejecutivos.php">Ejecutivos</a></li>
						<li><a href="<?php echo URL; ?>/formularios/idiomas.php">Idiomas</a></li>
					</ul>
				</li>
				<li><a href="<?php echo URL; ?>/publicar/">Publicar</a></li>
				<li><a href="#" class="button primary">Sign Up</a></li>
				<li><a href="<?php echo URL; ?>/include/php/procesar-logout.php" class="button primary">Log Out</a></li>
			</ul>
		</nav>
	<?php
	}
	?>
</header>