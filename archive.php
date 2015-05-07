<?php
/*
Template Name: Archive
*/
get_header();

$num_posts = 12;

?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts">

<?php
  if (is_page('posts')) {
    $args = array(
      'posts_per_page' => $num_posts,
      'post_type' => 'post',
    );
  } else if (is_page('archive')) {
    $args = array(
      'post_type' => array('post','lookbook','product'),
      'posts_per_page' => $num_posts,
    );
  } else if (is_tag()) {
    $term_id = get_query_var('tag_id');
    $taxonomy = 'post_tag';
    $args ='include=' . $term_id;
    $terms = get_terms( $taxonomy, $args );
    $tag_slug = $terms[0]->slug;
    $args = array(
      'posts_per_page' => $num_posts,
      'post_type' => array('post','lookbook','product'),
      'tax_query' => array(
        array(
          'taxonomy' => 'post_tag',
          'field'    => 'slug',
          'terms'    => $tag_slug,
        ),
      ),
    );
  } else {
    $post_type = get_post_type();
    $args = array(
      'posts_per_page' => $num_posts,
      'post_type' => $post_type,
    );
  }
  $posts = get_posts( $args );
  if (! empty($posts)) { ?>
    <div class="container container-large">
      <div class="row">
<?php
    foreach ($posts as $post) {
      setup_postdata( $post );
      $entry_id = $post->ID;
?>
      <article class="col into-3">
        <?php set_query_var( 'entry_id', $entry_id ); get_template_part( 'archive', 'entry' ); ?>   
      </article>
<?php
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
?>

  <!-- end posts -->
  </section>

  <?php get_template_part('partials/pagination'); ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>