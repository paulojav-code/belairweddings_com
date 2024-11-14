<?php
	ini_set('display_errors', 1);
	$titulo = 'Offers';
	$folder = ['promociones', '../'];
	$idioma = 'en';
	$return = '../../';
	include_once('../../includes/php/const.php');
	include_once('../../includes/php/config.php');
	include_once('../../includes/page-forms/header.php');


	$contacto = false;

	$json_raw = file_get_contents($folder[1] . '../includes/json/offers.json');
	$promo = json_decode($json_raw, TRUE);
?>
<style>
	#titulo-articulo .titulo {height: 12rem;}
	#titulo-articulo .image{height:12rem;}

	#cuerpo article{display:flex;flex-direction:row;flex-wrap:wrap;margin-bottom:1em;}
	#cuerpo article > *{width:50%;}
	#cuerpo article div{padding:0 1em;}
	#cuerpo article div h2{color: #000;font-weight:700;font-size:1.25em;letter-spacing:-0.05em;text-transform: uppercase;margin-bottom:0;margin-top:0.25em;}
	#cuerpo article div h3{text-align: center;text-transform: uppercase;font-size:1.1em;}
	#cuerpo article div p{text-align:center;}
	/* #cuerpo article div p:last-of-type{font-size: 0.9em;text-align:left;} */
	#cuerpo article picture img{width:100%;}
	#cuerpo article div ul{padding:0;text-align:center;}
	#cuerpo article div ul li{display:inline-block;width:calc(50% - 3px);margin:0;}
	#cuerpo .button{width:100%;background: #d0abb1;text-transform:capitalize;font-size:0.9em;letter-spacing:0;padding:0;text-align:center;}
	#cuerpo .button.wp {background: #25D366;}
	@media screen and (max-width: 736px){#cuerpo article > * {width: 100%;}}
	@media screen and (max-width: 480px){#cuerpo article div ul li{width:auto;min-width:11em;margin-bottom:0.5em;}}
	
	#myModal {display: none;}
	.modal-background {position: fixed;z-index: 12000;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgba(0, 0, 0, 0.3);display: flex;flex-direction: column;flex-wrap: wrap;justify-content: center;align-items: center;}
	.modal-content {margin: 0 auto;background-color: #d0abb1;border-radius: 25px;z-index: 12001;padding: 1.5em;width: 40em;max-width: calc(100% - 1.5em);max-height: calc(100vh - 3em);position: relative;margin-bottom: 2em;-moz-transform: translateY(0.75rem);-webkit-transform: translateY(0.75rem);-ms-transform: translateY(0.75rem);transform: translateY(0.75rem);-moz-transition: opacity 0.25s ease;-moz-transform: 0.25s ease;-webkit-transition: opacity 0.25s ease;-webkit-transform: 0.25s ease;-ms-transition: opacity 0.25s ease;-ms-transform: 0.25s ease;transition: opacity 0.25s ease;transform: 0.25s ease;opacity: 1;}
	.modal-content h2{text-align: center; margin-bottom: 1em;color: rgba(255, 255, 255, 0.8);}
	#myModal span.close {position: absolute;color: #000;font-weight: bold;top: 1.5em;right: 1.5em;cursor: pointer;z-index: 12002;}
	::placeholder {color: #212529 !important;font-size: 1em;}
	.mdform {display: none;position: fixed;z-index: 11000;padding: 2em 0 2em 0;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgba(0, 0, 0, 0.3);color: #000 !important;}
	#mdform-alerta {background-color: rgba(0, 0, 0, 0.6);}
	.mdform-content {background-color: #fff;border-radius: 0;z-index: 1003;margin: 0 auto;padding: 3em;width: 50em;max-width: calc(100% - 2em);position: relative;-moz-transform: translateY(0.75rem);-webkit-transform: translateY(0.75rem);-ms-transform: translateY(0.75rem);transform: translateY(0.75rem);-moz-transition: opacity 0.25s ease, -moz-transform 0.25s ease;-webkit-transition: opacity 0.25s ease, -webkit-transform 0.25s ease;-ms-transition: opacity 0.25s ease, -ms-transform 0.25s ease;transition: opacity 0.25s ease, transform 0.25s ease;opacity: 0;}
	#mdform-alerta .mdform-content {width: 40em;}
	.mdform-content.loaded {-moz-transform: translateY(0);-webkit-transform: translateY(0);-ms-transform: translateY(0);transform: translateY(0);-moz-transition: opacity 0.5s ease, -moz-transform 0.5s ease;-webkit-transition: opacity 0.5s ease, -webkit-transform 0.5s ease;-ms-transition: opacity 0.5s ease, -ms-transform 0.5s ease;transition: opacity 0.5s ease, transform 0.5s ease;opacity: 1;}
	.mdform-content ul {margin-left: 1em;margin-bottom: 0em;}
	.mdform-content p {margin-bottom: 1em;}
	.mdform-content h3 {font-size: 2.5em;font-weight: 400;}
	.mdform-content h3::after {display: none;}
	#mdform-imagen {padding-top: 4em;}
	.mdform-content-img {position: relative;display: block;margin: 0 auto;width: fit-content;}
	.mdform-content-img img {width: auto;height: auto;max-height: calc(100vh - 8em);max-width: calc(100% - 4em);margin: 0 2em;}
	.mdform .close {position: absolute;color: #ffffff;top: 1em;right: 1em;font-size: 1.5em;font-weight: bold;z-index: 1005;}
	#mdform-imagen .close {font-size: 2.5em;top: 0.75em}
	.mdform .mdform-content .close {color: #000;}
	.mdform .close:hover,.mdform .close:focus {color: #eeeeee;text-decoration: none;cursor: pointer;}
	.mdform .flecha {position: absolute;color: #ffffff;top: calc(50vh - 1em);font-size: 2em;font-weight: bold;z-index: 1005;cursor: pointer;}
	.mdform .next {right: 1em;}
	.mdform .pre {left: 1em;}
	.mdform .flecha p {font-size: 2em;}
	@media screen and (max-width: 736px) {.mdform-content-img img {max-height: calc(100vh - 6em);max-width: calc(100% - 2em);margin: 0 1em;}#mdform-imagen .close {top: 0.5em;right: 0.5em;}.mdform .flecha {top: auto;bottom: 2em;}}
	@media screen and (max-width: 736px){
		#header{
			& nav{
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;
				justify-content: center;
				align-items: center;
			}
			ul{
				width: calc(100% - 8em);
				& li{
					padding-top: 0;
				}
				& + a{
					margin-right:1em;
				}
			}
			& br{
				display: none;
			}
			& a{
				padding-top:0;
			}
		}
	}
</style>
<div id="page-wrapper">
	<?php include_once('../../includes/page-forms/navbar.php'); ?>

	<div id="wrapper">
		<section id="titulo-articulo" class="panel spotlight custom center">
			<div class="image filtered blog">
				<img src="../../assets/en/img/promociones/cover.jpg" alt="">
			</div>
			<div class="content span-6">
				<div class="titulo">
					<h2 class="major"><?= $titulo ?></h2>
				</div>
				<div id="cuerpo">
					<section>
						<?php
						foreach ($promo as $index => $info) {
						?>
							<article>
								<picture>
									<img src="<?= $folder[1] . $info['url_image'] ?>" alt="">
								</picture>
								<div>
									<h2><?= $info['title'] ?></h2>
									<?= isset($info['subtitle'])? '<h3>'.$info['subtitle'].'</h3>':'' ?>
									<?= $info['desc'] ?>
									<ul>
										<!-- <li><a href="<?= $info['link_wp'] ?>" target="_blank" class="button wp"><i class="icon brands fa-whatsapp"></i> WhatsApp</a></li> -->
										<li><button type="button" id="promo_<?= $index ?>" class="button formulario">CONTACT US</button></li>
									</ul>
								</div>
							</article>
						<?php
						}
						?>
					</section>
				</div>
			</div>
		</section>
		<?php include_once('../../includes/page-forms/contacto.php'); ?>
	</div>
</div>
<?php include_once('../../includes/page-forms/formulario.php'); ?>

<!-- Scripts -->
<?php include_once('../../includes/page-forms/footer.php'); ?>
<script>
	$('.button.formulario').on('click', function() {
		// $('#formulario_titulo').val(promos[$(this)[0].id.substr(6)].title)
		
		$('#myModal').show();
	})
	$('#myModal .close').on('click', function() {
		$('#myModal').hide();
	})
	settings.keyboardShortcuts.enabled = false;
	settings.scrollWheel.enabled = false;
	if (breakpoints.active('>small')) {
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