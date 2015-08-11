<?php
$post_type = get_post_type( $entry_id );
$dash = '&nbsp;&nbsp;&mdash;&nbsp;&nbsp;';
if ($post_type == 'product') {
	$product_brand = get_post_meta( $entry_id, '_igv_product_brand', true );
  $product_url = get_post_meta( $entry_id, '_product_shop_url', true );
  $product_title = ucwords(strtolower(get_the_title( $entry_id )));
?>
  <a href="<?php echo $product_url; ?>"><?php echo get_the_post_thumbnail( $entry_id, 'related', 'class=archive-entry-img' ); ?></a>
  <h2>
    <a href="<?php echo $product_url; ?>"><?php echo $product_title; ?></a>
  </h2>
  <span class="date"><?php echo $product_brand; ?></span>
<?php
} else {
?>
	<a href="<?php echo get_the_permalink( $entry_id ) ?>"><?php echo get_the_post_thumbnail( $entry_id, 'related', 'class=archive-entry-img' ); ?></a>
  <h2>
    <a href="<?php echo get_the_permalink( $entry_id ) ?>"><?php echo get_the_title( $entry_id ); ?></a>
  </h2>
  <span class="date"><?php echo get_the_date( null, $entry_id ); ?></span>
<?php
}

echo $dash;

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
