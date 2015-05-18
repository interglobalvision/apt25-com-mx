<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts">

<?php
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
  $query_split = explode("=", $string);
  $search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$posts = get_posts( $search_query );
if (! empty($posts)) { ?>
    <div class="container container-large">
      <div class="row">
        <div class="col into-1">
          <h3>Results for: <em><?php echo get_search_query(); ?></em></h3>
        </div>
      </div>
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