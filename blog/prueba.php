<?php $tituloPag = "Blog | Dreams Wedding Agencia de viajes especializada en Bodas";
$descripcionPag = "Dreams Wedding te ofrece los siguientes destinos de playa para realizar tu boda";
$keywords = "Dreams Wedding";
$origen = "New Destinos Blog";
$folder = "blog";
$canonical = "https://dreams-wedding.com.mx/".$folder;
$count = $_GET['count'];
$todos="";
if ($count != "all"){$todos = false;} else {$todos = true;}

?>
<?php include('../includes/global.php'); ?>
<?php include('../global.php'); ?>
<?php include('../consultas.php'); ?>
<?php


?>
<?php include('../includes/header.php'); ?>
<link rel="stylesheet" media="(min-width:576px)" href="<?php echo URL.'/css/'.$folder;?>/small.css" />
<link rel="stylesheet" media="(min-width:768px)" href="<?php echo URL.'/css/'.$folder;?>/medium.css" />
<link rel="stylesheet" media="(min-width:992px)" href="<?php echo URL.'/css/'.$folder;?>/large.css" />
<link rel="stylesheet" media="(min-width:1200px)" href="<?php echo URL.'/css/'.$folder;?>/extralarge.css" />
<style>@font-face{font-family:Brandon;font-display:swap;src:url('<?php echo URL; ?>/fonts/Brandon_Grotesque/Brandon_Normal.otf')}@font-face{font-family:Chaparral;font-display:swap;src:url('<?php echo URL; ?>/fonts/Chaparral_Pro/Chaparral_Pro_Regular.ttf')}*,html,body{padding:0;margin:0;font-family:'Brandon', serif}body{background-color:#fbfbfb !important}.bg-verde{background-color:#52c1ae !important;color:#292323 !important;}.bg-verde:hover{background-color:#8bb1aa !important;color:white !important}.text-verde{color:#006150;}.iconito{width:10%}.text-blanco{color:#1a2323 !important}@font-face{font-family:Brandon;font-display:swap;src:url(<?php echo URL; ?>/fonts/Brandon_Grotesque/Brandon_Bold.otf);font-weight:700}@font-face{font-family:Brandon;font-display:swap;src:url(<?php echo URL; ?>/fonts/Brandon_Grotesque/Brandon-Lighter.otf);font-weight:lighter}@font-face{font-family:Brandon;font-display:swap;src:url(<?php echo URL; ?>/fonts/Brandon_Grotesque/brandon-grotesque-thin-italic-58a8a3a8861fe.otf);font-style:italic}hr.nosotros{width:50%;text-align:center;margin-left:25%}.linkNosotros{font-size:1.5rem;text-decoration:underline !important}.formulario input,.formulario textarea{background-color:#e1e3e5}.footer{background-color:#404d50}.navbar-nav li:hover>ul.dropdown-menu{display:block}.dropdown-submenu{position:relative}.dropdown-submenu a::after{transform:rotate(-90deg);position:absolute;right:6px;top:.8em}.dropdown-submenu .dropdown-menu{top:0;left:100%;margin-left:.1rem;margin-right:.1rem}.navbar-nav li:hover>ul.dropdown-menu2{display:block}ul{list-style-position:inside}.grecaptcha-badge{display:none}.lazy-background{display:block;}

    .cover {
        background: url('<?php echo URL; ?>/img/BLOG/cover-mobile-blog-2X.jpg');
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        height: 200px;
    }

    .cover.visible {
        background: url('<?php echo URL; ?>/img/BLOG/cover-mobile.jpg');
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .texto-rosa{color:#f28eeb;}
    .titulo-post{min-height:84px;}
/* Local */


</style>

</head>

<body>
    <?php include('../includes/menu.php'); ?>
    <section class="lazy-background cover container-fluid"></section>
    <section class="detalles py-3 container">
       <?php get_last_post();?>
       <div class="row justify-content-center">
         <?php 
         if($todos == true)
            {
             //get_all_post();
            }
        else{
            //get_last_6();
        }
         ?>
       </div>

    </section>
    <section class="destinos px-3 py-4">
        <div class="pt-4 <?php echo ($todos == true)?' d-none':' d-block' ?>">
            <h4 class="text-muted text-center"><a href="<?php echo URL;?>/blog/index.php?count=all#mas-entradas" class="text-verde">Mas entradas</a></h4>
        </div>
    </section>

    <?php include('../includes/footer.php'); ?>
    <?php include('../includes/cierre-footer.php'); ?>