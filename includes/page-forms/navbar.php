<div id="header" class="content">
	<nav>
		<a href="<?php echo URL ?>"><img src="<?php echo URL ?>/assets/img/logos/belair_wedding.svg" alt="Belair Dreams Wedding" class="logo"></a>
		<ul>
			<?php
				if($datos_json["html_lan"] == 'en'){
					echo '<li><a href="'.URL.'/en"'.$datos_json["menu_inicio"].'>' .$datos_json['menu_inicio'].'</a></a></li>';
				}else{
					echo '<li><a href="'.URL.'"'.$datos_json["menu_inicio"].'>' .$datos_json['menu_inicio'].'</a></li>';
				}
			?>
			<?php
				if($contacto){
			?>
			<li><a href="#pre-fifth"><?php echo $datos_json['menu_contacto']; ?></a></li>
			<?php
				}
				if($folder[0] != 'promociones') {
			?>
			<li><a href="<?= $datos_json["html_lan"] == 'en' ? URL .'/en'. '/offers/' : URL . '/promociones/' ?>"><?php echo $datos_json['promociones'];?></a></li>
			<?php
				}
			?>
			<?php
				if($folder[0] != 'servicios') {
			?>
			<li><a href="<?= URL . '/' . $datos_json['menu_servicios_url']; ?>"><?php echo $datos_json['menu_servicios']; ?></a></li>
			<?php
				}
			?>
			<?php
				if($folder[0] != 'blog'  && $datos_json["html_lan"] != 'en') {
			?>
			<li><a href="<?php echo URL ?>/blog/">BLOG</a></li>
			<?php
				}
			?>
			<li><a id="lang_change" href="<?php echo URL.$datos_json['cambio_idioma']['href'];?>"<strong><?php echo $datos_json['cambio_idioma']['idioma'];?></strong></a></li>
		</ul>
		<a href="tel:<?= $phone_number ?>"><b><?php echo $datos_json['menu_telefono']; ?></b> <br><?= format_phone($phone_number); ?></a>
	</nav>
</div>