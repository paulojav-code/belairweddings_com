<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <a class="navbar-brand" href="https://dreams-wedding.com.mx">
        <img src="<?php echo URL; ?>/img/dreams-wedding.png" width="120" height="30" alt="logo dreams wedding" class="img-fluid">
    </a>

    <div class="d-flex flex-column bd-highlight text-right">
        <div class="text-center py-1 d-block d-lg-none"><a role="button" class="btn bg-verde" style="font-size: .8rem;color:white;" href="tel:800 990 0116">800 990 0116<br><span class="parpadea">LLÁMANOS!</span></a></div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse pr-5" id="navbarSupportedContent" style="font-size:0.8rem;">
        <ul class="navbar-nav ml-auto" style="margin-right:-4em;">
            <li class="nav-item <?php echo ($folder == "home") ? "active" : ""; ?>"><a class="nav-link" href="<?php echo URL; ?>">HOME <span class="sr-only">(current)</span></a></li>
            <li class="nav-item <?php echo ($folder == "nosotros") ? "active" : ""; ?>"><a class="nav-link" href="<?php echo URL; ?>/nosotros/">NOSOTROS</a></li>
            <li class="nav-item dropdown <?php echo ($folder == "destinos-playa" || $folder == "destinos-ciudad") ? "active" : ""; ?>"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DESTINOS PARA BODAS:</a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li class="nav-item"><a class="nav-link" href="<?php echo URL; ?>/destinos-playa/">PLAYA</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo URL; ?>/destinos-ciudad/">CIUDAD</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown <?php echo ($folder == "paquetes" || $folder == "despedida-de-soltera" || $folder == "luna-de-miel") ? "active" : ""; ?>"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PAQUETES</a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">TU BODA EN LA PLAYA:</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/boda-de-tus-suenos/">LA BODA DE TUS SUEÑOS</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">TU BODA EN LA CIUDAD:</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/casate-como-un-rockstar/">CÁSATE COMO UN ROCKSTAR</a></li>
                            <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/todo-incluido/">TODO INCLUIDO</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">DESPEDIDA DE SOLTER@</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/despedidas/soltera/">BRIDE TEAM</a></li>
                            <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/despedidas/soltero/">GROOM TEAM</a></li>
                        </ul>
                    </li>
                    <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/luna-de-miel/">LUNA DE MIEL</a></li>
                    <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/bodas-boutique/">BODAS BOUTIQUE</a></li>
                    <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/bodas-eco-friendly/">BODAS ECO-FRIENDLY</a></li>
                    <li><a class="dropdown-item text-uppercase" href="<?php echo URL; ?>/paquetes/wedding-brunch/">WEDDING BRUNCH</a></li>
                </ul>
            </li>
            <li class="nav-item <?php echo ($folder == "galeria") ? "active" : ""; ?>"><a class="nav-link" href="<?php echo URL; ?>/galeria/">GALERÍA</a></li>
            <li class="nav-item <?php echo ($folder == "proximos-eventos") ? "active" : ""; ?>"><a class="nav-link" href="<?php echo URL; ?>/proximos-eventos/">PROXIMOS EVENTOS</a></li>
            <li class="nav-item <?php echo ($folder == "faq") ? "active" : ""; ?>"><a class="nav-link" href="<?php echo URL; ?>/faq/">FAQ</a></li>
            <li class="nav-item <?php echo ($folder == "blog") ? "active" : ""; ?>"><a class="nav-link" href="<?php echo URL; ?>/blog/">BLOG</a></li>
            <li class="nav-item <?php echo ($folder == "contacto") ? "active" : ""; ?>"><a class="nav-link" href="<?php echo URL; ?>/contacto/">CONTACTO</a></li>
            <!--<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">IDIOMA</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li class="nav-item"><a class="nav-link" href="../en/">EN</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo URL; ?>/destinos-ciudad/">ES</a></li>
                    </ul>
                </li>-->
            <li class="nav-item d-none d-lg-block"><a href="tel:8009900116" class="nav-link btn bg-verde">800 990 0116<br><span class="parpadea">LLÁMANOS!</span></a></li>
            <!--<li class="nav-item d-none d-lg-block"><a onclick="modal('#modal_telefonos')" class="nav-link btn bg-verde">800 990 0116<br><span class="parpadea">LLÁMANOS!</span></a></li>-->
        </ul>
    </div>
</nav>