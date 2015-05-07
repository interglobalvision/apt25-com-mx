<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $post_type = get_post_type();
    $excerpt = get_the_excerpt();
?>

    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <div class="container container-small">
        <div class="row">
          <div class="col into-1">
            <div class="single-post-details">
              <span class="date"><?php the_date( ); ?></span>
              <h1>
                <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
              </h1>
<?php
    if ($post_type == 'post') {
?>
              <p><?php echo $excerpt; ?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_bloginfo( 'url' ) . '/posts/'; ?>"><span class="fa fa-thumb-tack"></span></a></p>
<<<<<<< HEAD
=======
<!--               >> what does those classes mean? fa? classes need to be explanitory doesnt matter if they a few more chars -->
<!--               >> maybe we should express this space space dash thing in a nicer way. could just at least make php function to echo that so we can change it sitewide if we need to -->
>>>>>>> 87d1c0d4adacdd3b538f18bd9a3dc50d59ab90de
<?php
    } elseif ($post_type == 'lookbook'){
?>
              <p><?php echo $excerpt; ?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_post_type_archive_link( 'lookbook' ); ?>"><span class="fa fa-eye"></span></a></p>
<?php
    } else {
?>
              <p><?php echo $excerpt; ?></p>
<?php
    }
?>
            </div>
          </div>
        </div>
      </div>
      <div class="container container-medium">
        <div class="row">

<?php
    if ($post_type == 'post') {
?>
          <div class="col into-1">
            <div class="type-post-content">
              <?php the_content(); ?>
            </div>
          </div>
<?php
    } else {
?>
          <div class="type-lookbook-content">
            <?php the_content(); ?>
          </div>
<?php
    }
?>
        </div>
      </div>
    </article>

    <div class="container container-small">
      <div class="row">
<?php
    for ($i = 1; $i <= 2; $i++) {
      $entry_id = null;
      $entry_id = get_post_meta( $post->ID, '_igv_related' . $i, true );
      if ( empty( $entry_id ) ) {
        $rand_args = array(
          'orderby' => 'rand',
          'post_type' => array('post','lookbook','product'),
          'post__not_in' => array($post->ID),
          'numberposts'=>1,
        );
        // >> this should be a tags query so the post is a bit related. Ive got a boiler somewhere but probably something better out there

        $rand_posts = get_posts($rand_args);
        foreach ($rand_posts as $rand_post) {
          $entry_id = $rand_post->ID;
        }
      }
?>

        <article class="col into-2">
          <?php include(locate_template('archive-entry.php')); ?>
        </article>

<?php
      wp_reset_postdata();
    } // end for
?>

      </div>
    </div>

<?php
  } // end while

} else {
?>
    <article class="u-alert">
      <div class="container container-small">
        <?php _e('Sorry, no posts matched your criteria :{'); ?>
      </div>
    </article>
<?php
} ?>

    </div>
  <!-- end posts -->
  </section>


  <?php get_template_part('partials/pagination'); ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>