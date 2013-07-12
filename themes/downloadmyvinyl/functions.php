<?php

include_once( get_stylesheet_directory() . '/functions/enqueues.php' );
include_once( get_stylesheet_directory() . '/functions/posttypes_and_taxonomies.php' );
include_once( get_stylesheet_directory() . '/functions/add_fields_to_formats.php' );
include_once( get_stylesheet_directory() . '/functions/import.php' );
include_once( get_stylesheet_directory() . '/functions/user.php' );

add_action( 'p2p_init', 'my_connection_types' );
function my_connection_types() {
	p2p_register_connection_type( array(
		'name' => 'user_to_record',
		'from' => 'user',
		'to' => 'record',
		'cardinality' => 'one-to-many',
	) );

	p2p_register_connection_type( array(
		'name' => 'record_to_code',
		'from' => 'record',
		'to' => 'code',
		'cardinality' => 'one-to-many',
	) );
}

add_action( 'init', 'custom_post_status', 0 );
function custom_post_status() {
	$args = array(
		'label'                     => _x( 'expired', 'Status General Name', 'text_domain' ),
		'label_count'               => _n_noop( 'Expired (%s)',  'Expired (%s)', 'text_domain' ),
		'public'                    => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'exclude_from_search'       => true,
	);

	register_post_status( 'expired', $args );
}

add_action( 'attachments_register', 'my_attachments' );
function my_attachments( $attachments )
{
  $fields         = array(
    array(
      'name'      => 'title',                         // unique field name
      'type'      => 'text',                          // registered field type
      'label'     => __( 'Title', 'attachments' ),    // label to display
      'default'   => 'title',                         // default value upon selection
    ),
    array(
      'name'      => 'caption',                       // unique field name
      'type'      => 'textarea',                      // registered field type
      'label'     => __( 'Caption', 'attachments' ),  // label to display
      'default'   => 'caption',                       // default value upon selection
    ),
  );

  $args = array(
    // title of the meta box (string)
    'label'         => 'Download File',
    // all post types to utilize (string|array)
    'post_type'     => array( 'record' ),
    // meta box position (string) (normal, side or advanced)
    'position'      => 'normal',
    // meta box priority (string) (high, default, low, core)
    'priority'      => 'high',
    // allowed file type(s) (array) (image|video|text|audio|application)
    'filetype'      => null,  // no filetype limit
    // include a note within the meta box (string)
    'note'          => 'Attach Download File here!',
    // by default new Attachments will be appended to the list
    // but you can have then prepend if you set this to false
    'append'        => true,
    // text for 'Attach' button in meta box (string)
    'button_text'   => __( 'Attach Download File', 'attachments' ),
    // text for modal 'Attach' button (string)
    'modal_text'    => __( 'Attach', 'attachments' ),
    // which tab should be the default in the modal (string) (browse|upload)
    'router'        => 'browse',
    // fields array
    'fields'        => $fields,
  );

  $attachments->register( 'my_attachments', $args ); // unique instance name
}

?>
