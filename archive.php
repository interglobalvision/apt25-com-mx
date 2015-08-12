<?php
/*
Template Name: Archive
*/
get_header();

$num_posts = 12;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

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
      'paged' => $paged,
    );
  } else if (is_page('archive')) {
    $args = array(
      'post_type' => array('post','lookbook','product'),
      'posts_per_page' => $num_posts,
      'paged' => $paged,
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
      'paged' => $paged,
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

    if ( $search_posts->have_posts() || $tag_posts->have_posts() ) {

      // Merge IDs
      $results = array_merge( $search_posts->posts, $tag_posts->posts);

    } else {

      $results = array(0);

    }

    $args =  array(
      'post_type' => array('post','lookbook','product'),
      'posts_per_page' => $num_posts,
      'post__in'  => $results,
      'paged' => $paged,
    );

  } else {
    $post_type = get_post_type();
    $args = array(
      'posts_per_page' => $num_posts,
      'post_type' => $post_type,
      'paged' => $paged,
    );
  }
  $query = new WP_Query( $args );
  if ( $query->have_posts() ) { ?>
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
    while ( $query->have_posts() ) {
     $query->the_post();  
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

    <!-- post pagination -->
    <nav id="pagination">
      <div class="container container-small">
        <div class="row">
<?php
$right = url_get_contents( get_bloginfo('stylesheet_directory') . '/img/arrow-right.svg' );
$left = url_get_contents( get_bloginfo('stylesheet_directory') . '/img/arrow-left.svg' );

$previous = get_previous_posts_link($left);
$next = get_next_posts_link($right, $query->max_num_pages);
if ($previous && $next) {
?>
          <span class="col into-2 u-align-left"><?php echo $previous; ?></span>
          <span class="col into-2 u-align-right"><?php echo $next; ?></span>
<?php
} else if ($previous && !$next) {
?>
          <span class="col into-1 u-align-left"><?php echo $previous; ?></span>
<?php
} else if ($next && !$previous) {
?>
          <span class="col into-1 u-align-right"><?php echo $next; ?></span>
<?php
}
?>
        </div>
      </div>
    </nav>

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

<!-- end main-content -->

</main>

<?php
get_footer();
?>