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
            <span class="date"><?php the_date( ); ?></span>
            <h1>
              <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            </h1>
            <p><?php echo $excerpt; ?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<span class="fa fa-thumb-tack"></span></p>
          </div>
        </div>
      </div>
      <div class="container container-medium">
        <div class="row">
          <div class="col into-1">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
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