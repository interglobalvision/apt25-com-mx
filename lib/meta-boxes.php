<?php

/* Get post objects for select field options */ 
function get_post_objects( $query_args ) {
$args = wp_parse_args( $query_args, array(
    'post_type' => 'post',
) );
$posts = get_posts( $args );
$post_options = array();
if ( $posts ) {
    foreach ( $posts as $post ) {
        $post_options [ $post->ID ] = $post->post_title;
    }
}
return $post_options;
}


/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add metaboxes. Can only happen on the 'cmb2_init' hook.
 */
add_action( 'cmb2_init', 'igv_cmb_metaboxes' );
function igv_cmb_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_igv_';

	/**
	 * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
	 */

	$related_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'related',
		'title'         => __( 'Related Posts', 'cmb2' ),
		'object_types'  => array( 'post', ), 
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, 
	) );

	$related_metabox->add_field( array(
		'name' => __( 'Related 1', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix . 'related1',
		'type' => 'post_search_text',
	) );

	$related_metabox->add_field( array(
		'name' => __( 'Related 2', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix . 'related2',
		'type' => 'post_search_text',
	) );

	$credits_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'credits_metabox',
		'title'         => __( 'Credits', 'cmb2' ),
		'object_types'  => array( 'lookbook', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
	) );

	$credits_group = $credits_metabox->add_field( array(
		'id'          => $prefix . 'credits',
		'type'        => 'group',
		'description' => __( '', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Credit {#}', 'cmb2' ), 
			'add_button'    => __( 'Add Another Credit', 'cmb2' ),
			'remove_button' => __( 'Remove Credit', 'cmb2' ),
			'sortable'      => true, 
		),
	) );

	$credits_metabox->add_group_field( $credits_group, array(
		'name'       => __( 'Name', 'cmb2' ),
		'id'         => 'name',
		'type'       => 'text',
	) );

	$credits_metabox->add_group_field( $credits_group, array(
		'name'       => __( 'Role', 'cmb2' ),
		'id'         => 'role',
		'type'       => 'text',
	) );

	$credits_metabox->add_group_field( $credits_group, array(
		'name'       => __( 'Link', 'cmb2' ),
		'id'         => 'link',
		'description'=> 'must begin with http:// or https://',
		'type'       => 'text',
	) );

}
?>
