<?php 
/* RECORDS CUSTOM POST TYPE
* ***************************************************************************************/
add_action( 'init', 'records_register_record_post_type' );
function records_register_record_post_type() {
    $labels = array(
        'name' => 'Records',
        'singular_name' => 'Record',
        'add_new' => 'Add New Record',
        'add_new_item' => 'Add New Record',
        'edit_item' => 'Edit Record',
        'new_item' => 'New Record',
        'all_items' => 'All Records',
        'view_item' => 'View Record',
        'search_items' => 'Search Records',
        'not_found' =>  'No Records found.',
        'not_found_in_trash' => 'No Records found in Trash.',
        'parent_item_colon' => '', 
        'menu_name' => 'Records'
    );  
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => array( 
            'slug' => 'records',
        ),  
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'format' ),
        'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/disc.png'
    );  
    
    register_post_type( 'record', $args );
}

/* CODES CUSTOM POST TYPE
* ***************************************************************************************/
add_action( 'init', 'codes_register_code_post_type' );
function codes_register_code_post_type() {
    $labels = array(
        'name' => 'Codes',
        'singular_name' => 'Code',
        'add_new' => 'Add New Code',
        'add_new_item' => 'Add New Code',
        'edit_item' => 'Edit Code',
        'new_item' => 'New Code',
        'all_items' => 'All Codes',
        'view_item' => 'View Code',
        'search_items' => 'Search Codes',
        'not_found' =>  'No Codes found.',
        'not_found_in_trash' => 'No Codes found in Trash.',
        'parent_item_colon' => '',
        'menu_name' => 'Codes'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'codes',
        ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title' ),
        'taxonomies' => array( ),
        'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/document-code.png'
    );

    register_post_type( 'code', $args );
}



/* FORMAT TAXONOMY
 * **************************************************************************************/
add_action( 'init', 'formats_register_format_taxonomy' );
function formats_register_format_taxonomy() {
    $labels = array(
        'name' => 'Formats',
        'singular_name' =>  'Format',
        'search_items' =>  'Search Formats',
        'all_items' => 'All Formats',
        'parent_item' => 'Parent Format',
        'parent_item_colon' => 'Parent Format:',
        'edit_item' => 'Edit Format', 
        'update_item' => 'Update Format',
        'add_new_item' => 'Add New Format',
        'new_item_name' => 'New Format Name',
        'menu_name' => 'Formats',
    );  
    $args = array(
        'heirarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 
            'slug' => 'formats',
        )   
    );  
    register_taxonomy(
        'format',
        array( 'record' ),
        $args
    );  
}
?>
