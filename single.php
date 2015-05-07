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
?>

    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <div class="container container-small">
        <div class="row">
          <div class="col into-1">
            <div class="single-post-details">
              <span class="date"><?php the_date( ); ?></span>
              <h1 class="article-title">
                <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
              </h1>
<?php
    $post_type = get_post_type();
    $excerpt = get_the_excerpt();
    $excerpt_output = '<p>' . $excerpt . '&nbsp;&nbsp;&mdash;&nbsp;&nbsp; <a href="';

    if ($post_type == 'post') {
      $excerpt_output .= get_bloginfo( 'url' ) . '/posts/"><span class="fa fa-thumb-tack"></span></a></p>';
    } elseif ($post_type == 'lookbook'){
      $excerpt_output .= get_post_type_archive_link( 'lookbook' ) . '"><span class="fa fa-eye"></span></a></p>';
    } else {
      $excerpt_output = $excerpt;
    }
?>          
              <?php echo $excerpt_output; ?>
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
      <div class="container container-small">
        <div class="row">
          <div class="col into-1">
            <?php the_tags( '<p class="post-tags"><strong>TAGGED: </strong>', ',', '</p>'); ?>
            <p class="post-share">
              <strong>SHARE: </strong>
              <a href="#"><span class="fa fa-twitter"></span></a>
              <a href="#"><span class="fa fa-facebook"></span></a>
            </p>
          </div>
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