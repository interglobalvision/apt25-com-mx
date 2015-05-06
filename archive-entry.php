<?php
$post_type = get_post_type();
?>
<article class="col into-3">
  <a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'feed-small' ); ?></a>
  <h2>
    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
  </h2>
  <span class="date"><?php the_date( ); ?></span>
<?php 
if ( $post_type == 'post' ) { 
?>
  &nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_post_type_archive_link( 'post' ); ?>"><span class="fa fa-thumb-tack"></span></a></p>
<?php 
} else if ( $post_type == 'lookbook') { 
?>
  &nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_post_type_archive_link( 'lookbook' ); ?>"><span class="fa fa-eye"></span></a></p>
<?php 
} else if ( $post_type == 'product') { 
?>
  &nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="<?php echo get_post_type_archive_link( 'product' ); ?>"><span class="fa fa-shopping-cart"></span></a></p>
<?php 
} 
?>
</article>