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

<?php 
if ( $post_type == 'post' ) { 
?>
      <div class="container container-small">
        <div class="row">
          <div class="col into-2">
            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'feed-square' ); ?></a>
          </div>
          <div class="col into-2">
            <span class="date"><?php the_date( ); ?></span>
            <h2>
              <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            </h2>
            <p><?php echo $excerpt; ?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_post_type_archive_link( 'post' ); ?>"><span class="fa fa-thumb-tack"></span></a></p>
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
            <span class="date"><?php the_date( ); ?></span>
          </div>
          <div class="col into-2">
            <p><?php echo $excerpt; ?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_post_type_archive_link( 'lookbook' ); ?>"><span class="fa fa-eye"></span></a></p>
          </div>
        </div>
      </div>
<?php 
} else if ( $post_type == 'product') { 
?>
      <div class="container container-medium">
        <a href="<?php // LINK TO PRODUCT ?>">
          <div class="row">
            <div class="col into-2">
              <!-- PRODUCT IMAGE 1 -->
            </div>
            <div class="col into-2">
              <!-- PRODUCT IMAGE 2 -->
            </div>
          </div>
        </a>
      </div>
      <div class="container container-small">
        <div class="row">
          <div class="col into-2">
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
          </div>
          <div class="col into-2">
            <p><?php echo $excerpt; ?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_post_type_archive_link( 'product' ); ?>"><span class="fa fa-shopping-cart"></span></a></p>
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