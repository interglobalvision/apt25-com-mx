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

      <?php get_template_part( 'related' ); ?>

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