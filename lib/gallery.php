<?php
remove_shortcode('gallery', 'gallery_shortcode');
function my_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'li',
		'icontag'    => 'li',
		'captiontag' => 'span',
		'columns'    => 3,
		'size'       => 'gallery',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		$tag = '';

		$img = wp_get_attachment_image_src($id, $size);
		$dimensions = getimagesize($img[0]);
		$into = 1;
		$orientation = 'landscape';
		if ($dimensions[1] > $dimensions[0]) {
			$into = 2;
			$orientation = 'portrait';
			$rand_direction = 'top';
			$min = 10;
			$max = 30;
		} else {
			$rand = rand ( 0 , 1 );
			if ( $rand == 0 ) {
				$rand_direction = 'left';
			} else {
				$rand_direction = 'right';
			}
			$min = 5;
			$max = 20;
		}
		$rand_percent = rand ( $min , $max );
		
/*
		$largeimg = wp_get_attachment_image_src($id, 'single');
		$large = $largeimg[0];
*/

if ( trim($attachment->post_excerpt) ) {
			$tag = "
				<span class='wp-caption-text gallery-caption'>" . wptexturize($attachment->post_excerpt) . "</span>";
		} else {
			$tag = null;
		}


		$output .= '<div class="col gallery-item into-' . $into . '" style="padding-' . $rand_direction . ': ' . $rand_percent . '%"><img src="' . $img[0] . '">' . $tag . '</div>';
		}

	$output .= "</div>\n";

	return $output;
}
add_shortcode('gallery', 'my_gallery_shortcode');