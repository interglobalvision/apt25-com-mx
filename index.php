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
    $dash = '&nbsp;&nbsp;&mdash;&nbsp;&nbsp;';
?>

    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<?php
if ( $post_type == 'post' ) {
// >> yeah it kinda sucks when you gotta do these kind of different post types probably be nice to use partials here to keep this template tidy and allow reuse for archive templates
?>
      <div class="container container-small">
        <div class="row">
          <div class="col into-2">
            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'feed-square' ); ?></a>
          </div>
          <div class="col into-2">
            <span class="date"><?php echo get_the_date(); ?></span>
            <h2>
              <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            </h2>
            <p><?php echo $excerpt . $dash; ?><a href="<?php echo get_bloginfo( 'url' ) . '/posts/'; ?>"><span class="fa fa-thumb-tack"></span></a></p>
          </div>
        </div>
      </div>
<?php
} else if ( $post_type == 'lookbook') {
?>
      <div class="container container-medium">
        <div class="row">
          <div class="col into-1">
            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'feed-large' ); ?></a>
          </div>
        </div>
      </div>
      <div class="container container-small">
        <div class="row">
          <div class="col into-2">
            <h2>
              <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            </h2>
            <span class="date"><?php echo get_the_date(); ?></span>
          </div>
          <div class="col into-2">
            <p><?php echo $excerpt . $dash; ?><a href="<?php echo get_post_type_archive_link( 'lookbook' ); ?>"><span class="fa fa-eye"></span></a></p>
          </div>
        </div>
      </div>
<?php
} else if ( $post_type == 'product') {
  $product_brand = get_post_meta( $post->ID, '_igv_product_brand', true );
  $product_url = get_post_meta( $post->ID, '_product_shop_url', true );
  $product_title = ucwords(strtolower(get_the_title()));
  $product_image = get_post_meta( $post->ID, '_igv_product_additional_image', true );
?>
      <div class="container container-medium">
        <div class="row">
          <a href="<?php echo $product_url; ?>">
<?php 
  if ($product_image) {
?>
            <div class="col into-2">
              <?php the_post_thumbnail( 'feed-square' ); ?>
            </div>
            <div class="col into-2">
              <img src="<?php echo $product_image; ?>">
            </div>
<?php 
  } else {
?>
            <div class="col into-1 u-align-center">
              <?php the_post_thumbnail( 'feed-large', 'class=product-thumb' ); ?>
            </div>
<?php } ?>
          </a>
        </div>
      </div>
      <div class="container container-small">
        <div class="row">
          <div class="col into-2">
            <h2>
              <a href="<?php echo $product_url; ?>"><?php echo $product_title; ?></a>
            </h2>
            <span class="date"><?php echo $product_brand; ?></span>
          </div>
          <div class="col into-2">
            <p><?php echo $excerpt . $dash; ?><a href="<?php echo get_post_type_archive_link( 'product' ); ?>"><span class="fa fa-shopping-cart"></span></a></p>
          </div>
        </div>
      </div>
<?php
}
?>

    </article>

<?php
  }
} else {
?>
    <article class="u-alert">
      <div class="container container-large">
        <div class="row">
          <div class="col into-1">
            <?php _e('Sorry, no posts matched your criteria :{'); ?>
          </div>
        </div>
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