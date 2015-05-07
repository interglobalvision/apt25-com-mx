<?php
// Menu icons for Custom Post Types
function add_menu_icons_styles(){
?>
 
<style>
#adminmenu .menu-icon-project div.wp-menu-image:before {
    content: '\f498';
}
</style>
 
<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );


//Register Custom Post Types
add_action( 'init', 'register_cpt_lookbook' );

function register_cpt_lookbook() {

    $labels = array( 
        'name' => _x( 'Lookbooks', 'lookbook' ),
        'singular_name' => _x( 'Lookbook', 'lookbook' ),
        'add_new' => _x( 'Add New', 'lookbook' ),
        'add_new_item' => _x( 'Add New Lookbook', 'lookbook' ),
        'edit_item' => _x( 'Edit Lookbook', 'lookbook' ),
        'new_item' => _x( 'New Lookbook', 'lookbook' ),
        'view_item' => _x( 'View Lookbook', 'lookbook' ),
        'search_items' => _x( 'Search Lookbooks', 'lookbook' ),
        'not_found' => _x( 'No lookbooks found', 'lookbook' ),
        'not_found_in_trash' => _x( 'No projects found in Trash', 'lookbook' ),
        'parent_item_colon' => _x( 'Parent Lookbook:', 'lookbook' ),
        'menu_name' => _x( 'Lookbooks', 'lookbook' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'taxonomies' => array('post_tag')
    );

    register_post_type( 'lookbook', $args );
}

add_action( 'init', 'register_cpt_product' );

function register_cpt_product() {

    $labels = array( 
        'name' => _x( 'Products', 'product' ),
        'singular_name' => _x( 'Product', 'product' ),
        'add_new' => _x( 'Add New', 'product' ),
        'add_new_item' => _x( 'Add New Product', 'product' ),
        'edit_item' => _x( 'Edit Product', 'product' ),
        'new_item' => _x( 'New Product', 'product' ),
        'view_item' => _x( 'View Product', 'product' ),
        'search_items' => _x( 'Search Products', 'product' ),
        'not_found' => _x( 'No products found', 'product' ),
        'not_found_in_trash' => _x( 'No projects found in Trash', 'product' ),
        'parent_item_colon' => _x( 'Parent Product:', 'product' ),
        'menu_name' => _x( 'Products', 'product' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'thumbnail', 'excerpt'),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'taxonomies' => array('post_tag')
    );

    register_post_type( 'product', $args );
}
