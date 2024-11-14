<style>
    @import url(<?php echo URL; ?>/assets/css/karla.css);
    @import url(<?php echo URL; ?>/assets/css/brandon_grotesque.css);

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 10;
        /* Sit on top */
        padding-top: 8em;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.3);
        /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        width: 40em;
        height: 35em;
        display: block;
        font-family: Karla;
        color: #fff;
    }

    .close {
        position: absolute;
        right: 0.5em;
        top: 0.5em;
        color: #aaa;
        font-size: 32px;
        font-weight: bold;
        z-index: 11;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-content .pleca {
        width: 50%;
        height: 35em;
        float: left;
        background: linear-gradient(135deg, #d0b8ab 0%, #d0abb1 100%);
    }

    .modal-content .pleca img {
        margin-top: 1em;
        margin-left: -1em;
        width: 10em;
    }

    .modal-content .pleca hr {
        width: 4em;
        margin-left: 16px;
        border-top: solid 3px #fff;
    }

    .modal-content .pleca h2, .modal-content .pleca h3, .modal-content .pleca h4 {
        font-family: Brandon Grotesque;
        text-transform: uppercase;
        font-weight: 300;
        padding: 0 16px;
    }

    .modal-content .pleca h2 {
        font-size: 1.5em;
    }

    .modal-content .pleca h3 {
        font-size: 0.9em;
    }

    .modal-content .pleca h4 {
        font-weight: 600;
        font-size: 1em;
        margin-top: 0.5em
    }

    .modal-content .pleca p {
        margin: 4em 0 0 0;
        padding: 0 16px;
    }

    .modal-content .pleca ul {
        margin: 0;
    }

    .modal-content .pleca ul li {
        display: inline-block;
        border-right: solid 2px #fff;
        padding-right: 1em;
        padding: 0 16px;
    }

    .modal-content .pleca ul li:last-child {
        border: none;
    }

    .modal-content .pleca a {
        color: #fff;
    }

    .modal-content .banner-modal {
        position: relative;
        width: 50%;
        height: 35em;
        overflow: hidden;
        float: left;
    }

    .modal-content .banner-modal .fondo {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 60% 50%;
    }

    @media screen and (max-width: 480px) {
        .modal-content {
            width: calc(100% - 3em);
            margin: 0 1em;
        }
    }
</style>
<div class="modal" id="modal_telefonos">
    <div class="modal-content">
        <span class="close" onclick="modal('#modal_telefonos')">&times;</span>
        <div class="pleca">
            <img src="<?php echo URL; ?>/img/logo-dreams-wedding.png" alt="logo dreams wedding">
            <hr>
            <h2>Nuestra línea está pasando por problemas técnicos</h2>
            <h3>Disculpa las molestias</h3>
            <p>Te atenderemos en los siguientes números:</p>
            <h4>ventas</h4>
            <ul>
                <li><a href="tel:9982603700">99 8260 3700</a></li>
                <li><a href="tel:9982600990">99 8260 0990</a></li>
                <li><a href="tel:3331006752">33 3100 6752</a></li>
            </ul>
            <h4>reservaciones</h4>
            <ul>
                <li><a href="tel:3319910541">33 1991 0541</a></li>
            </ul>
            <hr>
        </div>
        <div class="banner-modal">
            <img src="<?php echo URL; ?>/assets/img/dw-ejecutiva-telefono.jpg" alt="Dreams Wedding Ejecutiva de Ventas" class="fondo">
        </div>
    </div>
</div>
<script>
    <?php
        if($folder == 'home'){
    ?>
        modal("#modal_telefonos");
    <?php
        }
    ?>
    window.onclick = function(event) {
        if ($(event.target).attr('class') == 'modal') {
            $(event.target).hide();
        }
        if ($(event.target).attr('class') == 'modal large') {
            $(event.target).hide();
        }
        //console.log($(event.target).attr('class'));
    }

    function modal(id) {
        if (!$(id).is(':visible')) {
            $(id).show();
        } else {
            $(id).hide();
        }
    }
    $(document).bind('keydown', function(event) {
        if (event.which == 27) {
            $('.modal').hide();
            $('.modal.large').hide();
        };
    });
</script>