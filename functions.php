<?php
function scripts_and_styles_method() {

  $templateuri = get_template_directory_uri() . '/js/';

  // library.js is to bundle plugins. my.js is your scripts. enqueue more files as needed
  $jslib = $templateuri."library.js";
  wp_enqueue_script( 'jslib', $jslib,'','',true);
  $myscripts = $templateuri."main.min.js";
  wp_enqueue_script( 'myscripts', $myscripts,'','',true);

  // enqueue stylesheet here. file does not exist until stylus file is processed
  wp_enqueue_style( 'site', get_stylesheet_directory_uri() . '/css/site.css' );

  // dashicons for admin
  if(is_admin()){
    wp_enqueue_style( 'dashicons' );
  }

}
add_action('wp_enqueue_scripts', 'scripts_and_styles_method');

if( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}

if( function_exists( 'add_image_size' ) ) {
  add_image_size( 'admin-thumb', 150, 150, false );
  add_image_size( 'opengraph', 1200, 630, true );

  add_image_size( 'feed-square', 700, 700, true );
  add_image_size( 'feed-small', 900, 500, true );
  add_image_size( 'feed-large', 1200, 500, true );

  add_image_size( 'image-small', 700, 700, false );
  add_image_size( 'image-basic', 1000, 700, false );
  add_image_size( 'image-large', 1600, 1200, false );

  add_image_size( 'related', 500, 277, true );
}

// Register Nav Menus
/*
register_nav_menus( array(
	'menu_location' => 'Location Name',
) );
*/

get_template_part( 'lib/gallery' );
get_template_part( 'lib/post-types' );
get_template_part( 'lib/meta-boxes' );
get_template_part( 'lib/theme-options' );

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 11 );
function cmb_initialize_cmb_meta_boxes() {
  // Add CMB2 plugin
  if( ! class_exists( 'cmb2_bootstrap_202' ) ) {
    require_once 'lib/CMB2/init.php';
  }

  // Add CMB2 Attached Posts Field plugin
  if ( ! function_exists( 'cmb2_attached_posts_fields_render' ) ) {
    require_once 'lib/CMB2-plugins/cmb2-post-search/cmb2_post_search_field.php';
  }
}


add_action( 'init', 'initialize_globie_product_sucker', 9999 );
function initialize_globie_product_sucker() {
  if( ! class_exists( 'Globie_Product_Sucker' ) ) {
    require_once( 'lib/globie-product-sucker/globie-product-sucker.php' );
  }
}

// Customize search
function custom_search($query) {
  if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {

    add_filter( 'template_include', function() {
      return locate_template( 'archive.php' );
    }, 0 );

  }
}
add_filter('pre_get_posts','custom_search');

// Disable that freaking admin bar
add_filter('show_admin_bar', '__return_false');

// Turn off version in meta
function no_generator() { return ''; }
add_filter( 'the_generator', 'no_generator' );

// Show thumbnails in admin lists
add_filter('manage_posts_columns', 'new_add_post_thumbnail_column');
function new_add_post_thumbnail_column($cols){
  $cols['new_post_thumb'] = __('Thumbnail');
  return $cols;
}
add_action('manage_posts_custom_column', 'new_display_post_thumbnail_column', 5, 2);
function new_display_post_thumbnail_column($col, $id){
  switch($col){
    case 'new_post_thumb':
    if( function_exists('the_post_thumbnail') ) {
      echo the_post_thumbnail( 'admin-thumb' );
      }
    else
    echo 'Not supported in theme';
    break;
  }
}

// remove <p> tag from images in the content
function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// remove automatic <a> links on images in the content
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);


// include post types in main loop
function my_get_posts( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'lookbook', 'product' ) );

  return $query;
}
add_filter( 'pre_get_posts', 'my_get_posts' );


// disable rich text editor for product
add_filter( 'user_can_richedit', 'disable_for_cpt' );
function disable_for_cpt( $default ) {
  global $post;
  if ( 'product' == get_post_type( $post ) )
    return false;
  return $default;
}

// shorter excerpt length for custom post types (lookbook, product)
function excerpt_length_post_type($length) {
  global $post;
  if ($post->post_type == 'post' )
    return 55;
  else
    return 35;
}
add_filter('excerpt_length', 'excerpt_length_post_type');

// wrapper for oembed iframes from YouTube or Vimeo
add_filter('oembed_dataparse','oembed_video_add_wrapper',10,3);
function oembed_video_add_wrapper($return, $data, $url) {
  if ($data->provider_name == 'YouTube' || $data->provider_name == 'Vimeo') {
    return "<div class='video-wrapper'>{$return}</div>";
  } else {
    return $return;
  }
}

// custom login logo
function custom_login_logo() {
  echo '<style type="text/css">h1 a { background-image:url(' . get_bloginfo( 'template_directory' ) . '/img/favicon.png) !important; background-size:194px auto !important; width:194px !important; height:194px !important;}</style>';
}
add_action( 'login_head', 'custom_login_logo' );


// UTILITY FUNCTIONS


// to replace file_get_contents
function url_get_contents($Url) {
  if (!function_exists('curl_init')){
      die('CURL is not installed!');
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $Url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}

// get ID of page by slug
function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if($page) {
		return $page->ID;
	} else {
		return null;
	}
}
// is_single for custom post type
function is_single_type($type, $post) {
  if (get_post_type($post->ID) === $type) {
    return true;
  } else {
    return false;
  }
}

?>
