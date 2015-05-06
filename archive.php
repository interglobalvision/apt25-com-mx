<?php
/*
Template Name: Post Archive
*/
get_header();
?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts">

<?php
  if (is_page()) {
    $posts = get_posts( 'post_type=post' ); 
    if (! empty($posts)) { ?>
      <div class="container container-large">
        <div class="row">
<?php 
      foreach ($posts as $post) {
        setup_postdata( $post );
        get_template_part('archive','entry');
      }
    } else { 
?>
    <article class="u-alert">
    <div class="container container-small">
      <?php _e('Sorry, no posts matched your criteria :{'); ?>
    </div>
    </article>
<?php
    }
  } else {
    if( have_posts() ) { 
?>
    <div class="container container-large">
      <div class="row">
<?php
      while( have_posts() ) {
        the_post();
        get_template_part('archive','entry');
      } 
?>
      </div>
    </div>
<?php
    } else {
?>
    <article class="u-alert">
      <div class="container container-small">
        <?php _e('Sorry, no posts matched your criteria :{'); ?>
      </div>
    </article>
<?php
    } 
  }
?>
      
  <!-- end posts -->
  </section>

  <?php get_template_part('partials/pagination'); ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>