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
  } else if (is_search()) {
    $search_term =  $_GET['s'];

    $search_args = array(
      'post_type' => array('post','lookbook','product'),
      's' => $search_term,
      'fields' => 'ids',
    );

    $tag_args = array(
      'post_type' => array('post','lookbook','product'),
      'tag' => $search_term,
      'fields' => 'ids',
    );

    $search_posts = new WP_Query( $search_args );
    $tag_posts = new WP_Query( $tag_args );


    // Merge IDs
    $results = array_merge( $search_posts->posts, $tag_posts->posts);

    $args =  array(
      'post_type' => array('post','lookbook','product'),
      'posts_per_page' => $num_posts,
      'post__in'  => $results,
      'orderby'   => 'date',
      'order'     => 'DESC'
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
<?php 
    if (is_search()) { 
?>
      <div class="row">
        <div class="col into-1">
          <h3>Results for: <em><?php echo get_search_query(); ?></em></h3>
        </div>
      </div>
<?php } ?>
      <div class="row">
<?php
    foreach ($posts as $post) {
      setup_postdata( $post );
      $entry_id = $post->ID;
?>
      <article class="col into-3 archive-entry">
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
    <article>
      <div class="container container-large">
        <div class="row">
          <div class="col into-1">
            <?php 
            if (is_search()) {
              echo 'Sorry, no posts matched your search for<em> ' . get_search_query() . '</em>.';
            } else {
              echo 'Sorry, no posts matched your criteria.';
            }
            ?>
          </div>
        </div>
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