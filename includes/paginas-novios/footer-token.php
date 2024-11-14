<!-- Scripts -->
    <script src="<?php echo $ruta_raiz; ?>assets/js/jquery.min.js"></script>
    <script>
        function send_token() {
			var url = "https://localhost/web/dreams-wedding_com_mx/wp/book/";
				form = $('<form name="frmMain" method="post" action="' + url + '" style="display:none">' +
					'<div><input type="text" id="id_novie" name="id_novie" value="<?php echo $id_novie; ?>" /></div>' +
					'<div><input type="text" id="language" name="language" value="<?php echo $datos_json['language']; ?>" /></div>' +
					'</form>');
			$('body').append(form);
			form.submit();
		}
		send_token();
    </script>