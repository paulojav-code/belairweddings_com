<script async>
    document.addEventListener("DOMContentLoaded", function() {
  var lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-background"));

  if ("IntersectionObserver" in window && "IntersectionObserverEntry" in window && "intersectionRatio" in window.IntersectionObserverEntry.prototype) {
    let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          lazyBackgroundObserver.unobserve(entry.target);
        }
      });
    });

    lazyBackgrounds.forEach(function(lazyBackground) {
      lazyBackgroundObserver.observe(lazyBackground);
    });
  }
});
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous" async></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous" async></script>
    <script async src="<?php echo URL;?>/js/lazysizes.min.js"></script>
    <?php echo ($carrousel == true)?"<script src=".URL."/js/owl.carousel.min.js></script>":"";?>
    <?php echo ($folder == 'nosotros')?'
    <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      stagePadding: 50,
      loop:true,
      margin:10,
      nav:false,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          992:{
              items:3,
              stagePadding: 0,
              loop: false,
          }
      }
  })
    </script>':'';?>
    <?php echo ($folder == 'despedida-de-soltera')?'
    <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:3
          },
          992:{
              items:4,
              stagePadding: 0,
              loop: true,
          }
      }
  });</script>':'';?>
<?php if($folder == 'despedida-de-soltera'){
  include('lightbox.php');
} ?>

<?php 
isset($connection)?mysqli_close($connection):"";

?>


</body>
</html>
