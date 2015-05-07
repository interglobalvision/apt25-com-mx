<?php
$post_type = get_post_type( $entry_id );
// >> if you use setup_postdata() in here you can use normal the_title() type tags

?>
  <a href="<?php echo get_the_permalink( $entry_id ) ?>"><?php echo get_the_post_thumbnail( $entry_id, 'feed-small', 'class=archive-entry-img' ); ?></a>
  <h2>
    <a href="<?php echo get_the_permalink( $entry_id ) ?>"><?php echo get_the_title( $entry_id ); ?></a>
  </h2>
  <span class="date"><?php echo get_the_date( null, $entry_id ); ?></span>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;
<?php
if ( $post_type == 'post' ) {
?>
  <a href="<?php echo get_bloginfo( 'url' ) . '/posts/'; ?>"><span class="fa fa-thumb-tack"></span></a></p>
<?php
} else if ( $post_type == 'lookbook') {
?>
  <a href="<?php echo get_post_type_archive_link( 'lookbook' ); ?>"><span class="fa fa-eye"></span></a></p>
<?php
} else if ( $post_type == 'product') {
?>
  <a href="<?php echo get_post_type_archive_link( 'product' ); ?>"><span class="fa fa-shopping-cart"></span></a></p>
<?php
}
?>
</article>