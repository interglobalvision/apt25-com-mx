<?php
$address = IGV_get_option('_igv_address');
$hours = IGV_get_option('_igv_hours');
$email = IGV_get_option('_igv_email');
$facebook = IGV_get_option('_igv_facebook');
$twitter = IGV_get_option('_igv_twitter');
$instagram = IGV_get_option('_igv_instagram');

$address_replaced = preg_replace("/[\s]/","+",$address);
$maps_url = 'https://www.google.com.mx/maps/place/'.$address_replaced;
?>
    <footer id="footer" class="container">
      <div class="row">
        <div class="col into-3">
          <?php if (!empty($address)) { echo '<a class="address" href="'. $maps_url . '" target="_blank">' . $address . '</a>'; } ?>
          <?php if (!empty($hours)) { echo wpautop( $hours ); } ?>
        </div>
        <div class="col into-3">
          <?php if (!empty($email)) { echo '<span class="contact-email"><a href="mailto:' . $email . '">' . $email . '</a></span>'; } ?>
          <?php get_template_part('partials/subscribe'); ?>
        </div>
        <div class="col into-3 footer-social">
          <?php if (!empty($facebook)) { echo '<a href="' . $facebook . '" target="_blank"><span class="fa fa-facebook-square"></span></a>'; } ?>
          <?php if (!empty($twitter)) { echo '<a href="' . $twitter . '" target="_blank"><span class="fa fa-twitter-square"></span></a>'; } ?>
          <?php if (!empty($instagram)) { echo '<a href="' . $instagram . '" target="_blank"><span class="fa fa-instagram"></span></a>'; } ?>
        </div>
      </div>
    </footer>

  </section>

  <?php get_template_part('partials/scripts'); ?>

  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "LocalBusiness",
      "url": "<?php bloginfo('url'); ?>",
      "logo": "<?php echo get_stylesheet_directory_uri(); ?>/img/og.jpg",
      "sameAs" : [
      <?php
        if (!empty($facebook)) {
          echo '"' . $facebook . '",';
        }
        if (!empty($twitter)) {
          echo '"' . $twitter . '",';
        }
        if (!empty($instagram)) {
          echo '"' . $instagram . '"';
        }
      ?>
        ]
    }
  </script>

  </body>
</html>