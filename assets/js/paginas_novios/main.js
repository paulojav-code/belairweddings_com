/*
	Alpha by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

(function($) {

	var	$window = $(window),
		$body = $('body'),
		$header = $('#header'),
		$banner = $('#banner');

	// Breakpoints.
		breakpoints({
			wide:      ( '1281px',  '1680px' ),
			normal:    ( '981px',   '1280px' ),
			narrow:    ( '737px',   '980px'  ),
			narrower:  ( '737px',   '840px'  ),
			mobile:    ( '481px',   '736px'  ),
			mobilep:   ( null,      '480px'  )
		});

	// Play initial animations on page load.
		$window.on('load', function() {
			window.setTimeout(function() {
				$body.removeClass('is-preload');
			}, 100);
		});

	// Dropdowns.
		$('#nav > ul').dropotron({
			alignment: 'right'
		});

	// NavPanel.

		// Button.
			$(
				'<div id="navButton">' +
					'<a href="#navPanel" class="toggle"></a>' +
				'</div>'
			)
				.appendTo($body);

		// Panel.
			$(
				'<div id="navPanel">' +
					'<nav>' +
						$('#nav').navList() +
					'</nav>' +
				'</div>'
			)
				.appendTo($body)
				.panel({
					delay: 500,
					hideOnClick: true,
					hideOnSwipe: true,
					resetScroll: true,
					resetForms: true,
					side: 'left',
					target: $body,
					visibleClass: 'navPanel-visible'
				});

	// Header.
		if (!browser.mobile
		&&	$header.hasClass('alt')
		&&	$banner.length > 0) {

			$window.on('load', function() {

				$banner.scrollex({
					bottom:		$header.outerHeight(),
					terminate:	function() { $header.removeClass('alt'); },
					enter:		function() { $header.addClass('alt reveal'); },
					leave:		function() { $header.removeClass('alt'); }
				});

			});

		}

})(jQuery);

function modal(id,close = null) {
    if (!$(id).is(':visible') && close == null){
		$(id).fadeIn('fast',function(){
			$(id + ' .modal-content').addClass('loaded');
		});
		$('body').css("overflow", "hidden");
    }else{ 
		$('.modal .modal-content').removeClass('loaded');
		$('.modal').fadeOut().delay( 500 );
		$('body').css("overflow", "auto");
    }
}

function set_date_timer() {
	var now = new Date().getTime();
		distance = countDownDate - now;
		days = Math.floor(distance / (1000 * 60 * 60 * 24));
		hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		seconds = Math.floor((distance % (1000 * 60)) / 1000);
	$('#timer').html(days + "d " + hours + "h " + minutes + "m " + seconds + "s");
	if (distance < 0) {
		clearInterval(x);
		$('#timer').html("EXPIRED");
	}
}

function mostrar_imagen(numero,origen = null) {
	if(numero < 0){
		numero = (galeria.length - 1);
	}else if(numero > (galeria.length - 1)){
		numero = 0;
	}
	numero_galeria = numero;
	$('#modal-imagen').html(
		'<div class="modal-content-img">' + 
		'<img src="'+galeria[numero]+'" alt="Imagen Novies Galeria' + numero + '">' +
		'</div>' +
		'<span class="close" onclick="modal(\'#modal-imagen\')">&times;</span>' +
		'<span class="pre" onclick="mostrar_imagen('+(numero_galeria - 1)+')"><i class="fas fa-chevron-left"></i></span>' +
		'<span class="next" onclick="mostrar_imagen('+(numero_galeria + 1)+')"><i class="fas fa-chevron-right"></i></span>'
	)
	if (!$('#modal-imagen').is(':visible') && origen == null){
		modal('#modal-imagen');
	}
}

$(document).bind('keydown',function(event){
	if ( event.which == 27 ) {
		modal('',true);
	};
	if ( event.which == 37 ) {
		mostrar_imagen(numero_galeria - 1,'ARROW_KEY');
	};
	if ( event.which == 39 ) {
		mostrar_imagen(numero_galeria + 1,'ARROW_KEY');
	};
});

$(window).on("click", function(event) {
	if ($(event.target).attr('class') == 'modal') {
        modal('',true);
	}
});

var numero_galeria = 0;