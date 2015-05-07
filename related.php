<div class="container container-small">
  <div class="row">
<?php 
$all_tags = get_tags();
$tag_slugs = array();
foreach( $all_tags as $tag ) {
    $tag_slugs[] = $tag->slug;
}

$related_id = get_post_meta( $post->ID, '_igv_related1', true );

if ( empty( $related_id_1 ) ) {
  $rand_args = array(
    'orderby' => 'rand',
    'post_type' => array('post','lookbook','product'),
    'post__not_in' => array($post->ID),
    'numberposts' => 1,
    'tax_query' => array(
      array(
        'taxonomy' => 'post_tag',
        'field'    => 'slug',
        'terms'    => $tag_slugs,
      ),
    ),
  );
  $rand_posts = get_posts($rand_args);

  if ( empty($rand_posts) ) { 
    $rand_args = array(
      'orderby' => 'rand',
      'post_type' => array('post','lookbook','product'),
      'post__not_in' => array($post->ID),
      'numberposts' => 1,
    );
    $rand_posts = get_posts($rand_args);
  }

  foreach ($rand_posts as $rand_post) {
    $entry_id = $rand_post->ID;
  }
} else {
  $entry_id = $related_id;
}

?>
    <article class="col into-2">
      <?php include(locate_template('archive-entry.php')); ?>      
    </article>
<?php
$related_id = null;
$related_id = get_post_meta( $post->ID, '_igv_related2', true );

if ( empty( $related_id ) || $related_id == $entry_id ) {
  $rand_args = array(
    'orderby' => 'rand',
    'post_type' => array('post','lookbook','product'),
    'post__not_in' => array($post->ID, $entry_id),
    'numberposts' => 1,
    'tax_query' => array(
      array(
        'taxonomy' => 'post_tag',
        'field'    => 'slug',
        'terms'    => $tag_slugs,
      ),
    ),
  );
  $rand_posts = get_posts($rand_args);

  if ( empty($rand_posts) ) { 
    $rand_args = array(
      'orderby' => 'rand',
      'post_type' => array('post','lookbook','product'),
      'post__not_in' => array($post->ID, $entry_id),
      'numberposts' => 1,
    );
    $rand_posts = get_posts($rand_args);
  }
  
  foreach ($rand_posts as $rand_post) {
    $entry_id = $rand_post->ID;
  }
} else {
  $entry_id = $related_id;
}

?>
    <article class="col into-2">
<?php
        set_query_var( 'entry_id', $entry_id );
        get_template_part( 'archive', 'entry' ); ?>
?>     
    </article>

  </div>
</div>