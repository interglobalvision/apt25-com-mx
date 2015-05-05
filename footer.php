<?php
$address = IGV_get_option('_igv_address');
$hours = IGV_get_option('_igv_hours');
$email = IGV_get_option('_igv_email');
$facebook = IGV_get_option('_igv_facebook');
$twitter = IGV_get_option('_igv_twitter');
$instagram = IGV_get_option('_igv_instagram');
?>
    <footer id="footer" class="container">
      <div class="row">
        <div class="col into-3">
          <?php if (!empty($address)) { echo '<strong>' . $address . '</strong>'; } ?>
          <?php if (!empty($hours)) { echo wpautop( $hours ); } ?>
        </div>
        <div class="col into-3">
          <?php if (!empty($email)) { echo '<a href="mailto:' . $email . '">' . $email . '</a>'; } ?>
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
      "@type": "Organization",
      "url": "http://www.example.com",
      "logo": "http://www.example.com/images/logo.png",
      "contactPoint" : [
        { "@type" : "ContactPoint",
          "telephone" : "+1-877-746-0909",
          "contactType" : "customer service",
          "contactOption" : "TollFree",
          "areaServed" : "US"
        } , {
          "@type" : "ContactPoint",
          "telephone" : "+1-505-998-3793",
          "contactType" : "customer service"
        } ],
      "sameAs" : [
        "http://www.facebook.com/your-profile",
        "http://instagram.com/yourProfile",
        "http://www.linkedin.com/in/yourprofile",
        "http://plus.google.com/your_profile"
        ]
    }
  </script>

  </body>
</html>