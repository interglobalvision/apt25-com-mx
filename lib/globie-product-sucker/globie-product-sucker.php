<?php
/**
 * Plugin Name: Globie Product Sucker
 * Plugin URI:
 * Description: Pull data directly from OpenCart products and insert it on your post.
 * Version: 1.0.0
 * Author: Interglobal Vision
 * Author URI: http://interglobal.vision
 * License: GPL2
*/

class Globie_Product_Sucker {
  public function __construct() {
    add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    add_action( 'add_meta_boxes', array( $this, 'add_product_field' ) );
    add_action( 'save_post', array( $this, 'save_product_id' ) );
    add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    add_action( 'admin_init', array( $this, 'settings_init' ) );
  }

  /** 
   * Load JS scripts
   * Only on post.php and post-new.php
   */
  public function enqueue_scripts( $hook ){
    if( 'post.php' != $hook && 'post-new.php' != $hook )
      return;
    wp_register_script( 'globie-product-sucker-script', get_template_directory_uri() . '/lib/globie-product-sucker/globie-product-sucker.js' , array( 'jquery' ) );

    // Get plugin options
    $base_url = get_option( 'gpsucker_settings_base_url' );

    // Pass options to js script
    wp_localize_script( 'globie-product-sucker-script', 'gpsucker', array( 
      'baseURL' => $base_url 
    ) );

    // Enqueue script
    wp_enqueue_script( 'globie-product-sucker-script' );
  }

  public function add_product_field() {
    $saved_post_types = get_option( 'gpsucker_settings_post_types' );

    foreach( $saved_post_types as $post_type ) {
      add_meta_box(
        'gpsucker-product-id-meta-box',
        'Product URL',
        array( $this, 'product_id_meta_box_callback' ),
        $post_type
      );
    }
  }

  /**
   * Prints the Product URL box.
   *
   * @patam WP_Post $post The object for the current post.
   */
  public function product_id_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'globie_product_sucker', 'gpsucker_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $product_id_value = get_post_meta( $post->ID, '_product_id_value', true );

    echo '<input type="text" id="gpsucker-url-field" name="gpsucker-url-field" value="' . esc_attr( $product_id_value ) . '" size="25" />';
    echo '<input type="hidden" id="gpsucker-img-field" name="gpsucker-img-field" value="" />';

    echo ' <input type="submit" id="suck-product-data" value="Suck it!" class="button">';
    echo ' <div id="globie-spinner" style="background: url(\'/wp-admin/images/wpspin_light.gif\') no-repeat; background-size: 16px 16px; display: none; opacity: .7; filter: alpha(opacity=70); width: 16px; height: 16px; margin: 0 10px;"></div>';
  }

  public function save_product_id( $post_id ) {

    // Check nonce
    if ( ! isset( $_POST['gpsucker_nonce'] ) ) {
      return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['gpsucker_nonce'], 'globie_product_sucker' ) ) {
      return;
    }

    // Prevent autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }

    // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }

    // OK, it's safe for us to save the data now.

    // Make sure that product ID is set.
    if ( ! isset( $_POST['gpsucker-url-field'] ) ) {
      return;
    }

    // Sanitize product ID input
    $product_id = sanitize_text_field( $_POST['gpsucker-url-field'] );

    // Update the product ID field in the database.
    update_post_meta( $post_id, '_product_id_value', $product_id );

    // Make sure that thumb url is set.
    if ( ! isset( $_POST['gpsucker-img-field'] ) ) {
      return;
    }

    // Sanitize user input
    $product_img = sanitize_text_field( $_POST['gpsucker-img-field'] );
    $upload_dir = wp_upload_dir();

    //Get the remote image and save to uploads directory
    $img_name = time().'_'.basename( $product_img );
    $img = wp_remote_get( $product_img );
    if ( is_wp_error( $img ) ) {
      $error_message = $img->get_error_message();
      add_action( 'admin_notices', array( $this, 'wprthumb_admin_notice' ) );
    } else {
      $img = wp_remote_retrieve_body( $img );
      $fp = fopen( $upload_dir['path'].'/'.$img_name , 'w' );
      fwrite( $fp, $img );
      fclose( $fp );
      $wp_filetype = wp_check_filetype( $img_name , null );
      $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => preg_replace( '/\.[^.]+$/', '', $img_name ),
        'post_content' => '',
        'post_status' => 'inherit'
      );
      //require for wp_generate_attachment_metadata which generates image related meta-data also creates thumbs
      require_once ABSPATH . 'wp-admin/includes/image.php';
      $attach_id = wp_insert_attachment( $attachment, $upload_dir['path'].'/'.$img_name, $post_id );
      //Generate post thumbnail of different sizes.
      $attach_data = wp_generate_attachment_metadata( $attach_id , $upload_dir['path'].'/'.$img_name );
      wp_update_attachment_metadata( $attach_id,  $attach_data );
      //Set as featured image.
      delete_post_meta( $post_id, '_thumbnail_id' );
      add_post_meta( $post_id , '_thumbnail_id' , $attach_id, true );
    }

  }

  public function add_admin_menu() {
    add_options_page(
      'Globie Product Sucker Options',
      'Globie Product Sucker',
      'manage_options',
      'globie_product_sucker',
      array( $this, 'options_page' )
    );
  }

  // Register settings, sections and fields
  public function settings_init() {

    // Check if previous settings aren't stored
    if( !get_option( 'gpsucker_settings_post_types' ) ) {
      // Enable Product field on "posts" post type
      update_option( 'gpsucker_settings_post_types', array(
        0 => 'product'
      ) );
    }
    //delete_option( 'gpsucker_settings_post_types' );
    //delete_option( 'gpsucker_settings_base_url' );
    
    // Register option: post types
    register_setting( 'gpsucker_options_page', 'gpsucker_settings_post_types' );

    // Add post type section
    add_settings_section(
      'gpsucker_post_types_section',
      __( 'Enable/Disable on post types', 'wordpress' ),
      array( $this, 'settings_section_callback' ),
      'gpsucker_options_page'
    );

    // Post Types fields
    add_settings_field(
      'gpsucker_post_types_fields',
      __( 'Post types', 'wordpress' ),
      array( $this, 'settings_post_types_fields_render' ),
      'gpsucker_options_page',
      'gpsucker_post_types_section'
    );

    // Register option: base_url
    register_setting( 'gpsucker_options_page', 'gpsucker_settings_base_url' );

    // Add base_url section
    add_settings_section(
      'gpsucker_base_url_section',
      __( 'Store API base URL', 'wordpress' ),
      array( $this, 'settings_base_url_section_callback' ),
      'gpsucker_options_page'
    );

    // base_url field
    add_settings_field(
      'gpsucker_base_url_fields',
      __( 'URL', 'wordpress' ),
      array( $this, 'settings_base_url_field_render' ),
      'gpsucker_options_page',
      'gpsucker_base_url_section'
    );
  }

  public function settings_post_types_fields_render() {
    // Get options saved
    $saved_post_types = get_option( 'gpsucker_settings_post_types' );

    // Get post types
    $post_types= get_post_types(
      array(
        'public' => true
      )
    );

    // Render fields
    echo "<fieldset>";
    foreach( $post_types as $post_type ) {
      $checked = '';

      // Check if field is checked
      if( !empty( $saved_post_types ) && in_array($post_type, $saved_post_types) )
        $checked = 'checked';

      echo '<label for="gpsucker_settings_post_types[' . $post_type . ']"><input type="checkbox" name="gpsucker_settings_post_types[]" id="gpsucker_settings_post_types[' . $post_type . ']" value="' . $post_type . '" ' . $checked . '> ' .  ucfirst($post_type) . '</label><br />';
    }
    echo "</fieldset>";
  }

  public function settings_section_callback() {
    echo __( 'Select the post types where you want to enable the Product URL field', 'wordpress' );
  }

  public function settings_base_url_field_render() {

    // Get options saved
    $base_url = get_option( 'gpsucker_settings_base_url' );

    // Render fields
    echo "<fieldset>";
    echo '<label for="gpsucker_input_base_url" style="width: 100%;"><input type="text" style="width: 100%;" name="gpsucker_settings_base_url" id="gpsucker_input_base_url" value="' . $base_url  . '"></label><br />';
    echo "</fieldset>";
  }

  public function settings_base_url_section_callback() {
    echo __( 'Ex. <i>http://www.apt25.com.mx/store/index.php?route=api/product/get&id=</i>', 'wordpress' );
  }

  public function options_page() {
    echo '<form action="options.php" method="post">';
    echo '<h2>Globie Product Sucker Options</h2>';

    settings_fields( 'gpsucker_options_page' );
    do_settings_sections( 'gpsucker_options_page' );
    submit_button();

    echo '</form>';

  }
}
$gpsucker = new Globie_Product_Sucker();

function pr( $var ) {
  echo '<pre>';
  print_r( $var );
  echo '</pre>';
}
