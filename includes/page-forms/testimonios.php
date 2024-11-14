<section id="testimonios">
    <div class="modal" tabIndex="-1">
        <div class="inner">
            <div class="panel">
                <div class="span-2">
                    <h2 class="major">Testimonios y experiencias</h2>
                </div>
                <div class="span-5">
                    <?php
                    for ($i=0; $i < count($testimonios_php); $i++) { 
                    ?>
                        <?php if(isset($testimonios_php[$i]['imagen'])){ echo '<img src="assets/img/testimonios/'.$testimonios_php[$i]['imagen'].'" alt="">'; } ?>
                        <p><?php echo $testimonios_php[$i]['testimonio']; ?></p>
                        <h3><?php echo $testimonios_php[$i]['autor']; ?></h3>
                        <hr>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>