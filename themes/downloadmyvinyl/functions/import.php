<?php 

function import_data() {

	//import_users();
	//import_records();
	//import_codes();
}

function delete_data() {
	delete_posts();
}

function import_users() {
	$db = db_connect('downloadmyvinyl');

	$result = mysql_query( "SELECT * FROM labels" );
	while ( $label = mysql_fetch_array ( $result ) ) {
		$user_result = mysql_query ( "SELECT * FROM users WHERE label_id = {$label['id']}" );
		while ( $user = mysql_fetch_array( $user_result ) ) {

			if ( !username_exists( $user['username'] ) ) {

				$pass =  wp_hash_password( $user['username'] );
				$args[] = array (
					'user_login' => $user['username'],
					'user_pass' => $pass,
					'user_url' => $label['website'],
					'user_email' => $user['email'],
					'nickname' => $user['username'],
					'first_name' => $user['first_name'],
					'last_name' => $user['last_name'],
					'user_registered' => $user['created'],
					'role' => 'user',
					'record_label' => $label['name'],
					'location' => $label['location'],
					'old_label_id' => $label['id'],
				);	
			}
		}
	}

	$db = db_connect('downloadmyvinyl-wp');

	foreach ( $args as $user ) {
		$user_id = wp_insert_user( $user );
		update_user_meta( $user_id, 'record_label', $user['record_label'] );
		update_user_meta( $user_id, 'location',  $user['location'] );
		update_user_meta( $user_id, 'old_label_id',  $user['old_label_id'] );
	}
}

function import_records() {
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$db = db_connect('downloadmyvinyl');

	$result = mysql_query( 'SELECT * FROM records' );
	while ( $record = mysql_fetch_array( $result ) ) {

		$image_result = mysql_query( "SELECT file FROM images WHERE record_id={$record['id']}" );
		$image = mysql_fetch_row( $image_result );
		$image_url = 'http://downloadmyvinyl.com/img/thumbs/' . $image[0];

		$args[] = array (
			'post_title' => $record['band'] . ' - ' . $record['title'],
			'post_type' => 'record',
			'post_date' => $record['created'],
			'post_status' => 'publish',
			'label_id' => $record['label_id'],
			'old_record_id' => $record['id'],
			'format_id' => $record['format_id'],
			'band' => $record['band'],
			'record_title' => $record['title'],
			'image_url' => $image_url,
		);
	}

	$db = db_connect('downloadmyvinyl-wp');
	global $wpdb;

	foreach ( $args as $record ) {

		$result = mysql_query( "SELECT taxonomy_id FROM wp_taxonomymeta WHERE meta_value = {$record['format_id']}" );
		$format = mysql_fetch_row( $result );
		$format_id = $format[0];
		
		$result = mysql_query( "SELECT name FROM wp_terms WHERE term_id = {$record['format_id']}" );
		$format = mysql_fetch_row( $result );
		$format = $format[0];
		
		$result = mysql_query( "SELECT user_id FROM wp_usermeta WHERE meta_key = 'old_label_id' AND meta_value = {$record['label_id']}" );
		$user = mysql_fetch_row( $result );
		$user_id = $user[0];

		$query_args = array (
			'post_type' => 'record',
			'meta_key' => 'old_record_id',
			'meta_value' => $record['old_record_id'],
		);

		$query = new WP_Query( $query_args );

		if ( count( $query->posts ) == 0 ) {
			$record_id = wp_insert_post( $record );
			wp_set_post_terms( $record_id, $format, 'format' ); 
			add_post_meta( $record_id, 'old_record_id', $record['old_record_id'] );
			add_post_meta( $record_id, 'band', $record['band'] );
			add_post_meta( $record_id, 'record_title', $record['record_title'] );
			p2p_type( 'user_to_record' )->connect( $user_id, $record_id, array(
				'date' => current_time('mysql')
			) );

			$image = media_sideload_image( $record['image_url'], $record_id );
			$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
			$attachment_id = $last_attachment['ID'];

			add_post_meta($record_id, '_thumbnail_id', $attachment_id);
		}

	}

}

function import_codes() {
	$db = db_connect('downloadmyvinyl');
	$log_file = get_stylesheet_directory() . '/logs/' . date( 'c' ) . '-code-import-log.txt';
	$file_handle = fopen( $log_file, 'w' );

	$result = mysql_query( 'SELECT MAX(id) FROM CODES' );
	$max = mysql_fetch_row( $result );
	$max = $max[0];

	for( $count = 1; $count <= $max; $count++ ) {
		$args = null;

		$db = db_connect('downloadmyvinyl');
		$query = "SELECT * FROM codes WHERE id = $count";
		$result = mysql_query( $query );
		if ( $code = mysql_fetch_array( $result ) ) {
			$args = array (
				'post_title' => $code['code'],
				'post_type' => 'code',
				'post_date' => $code['created'],
				'post_status' => 'publish',
				'record_id' => $code['record_id'],
				'user_id' => $code['user_id'],
				'count' => $code['count'],
				'expired' => $code['expired'],
				'downloaded' => $code['downloaded'],
				'old_code_id' => $code['id'],
			);
		}

		$db = db_connect('downloadmyvinyl-wp');

		$result = mysql_query( "SELECT post_id FROM wp_postmeta WHERE meta_key='old_record_id' AND meta_value = {$code['record_id']}" );
		$record_id = mysql_fetch_row ( $result );
		$record_id = $record_id[0];

		if ( $args['count'] > 1 ) {
			$args['expired'] = 1;
		}
		
		if ( ( strtotime( $args['downloaded'] ) - mktime() ) > 86400 ) {
			$args['expired'] = 1;
		}

		if ( $args['expired'] == 1 ) {
			$args['post_status'] = 'expired';
		}

		$code_id = wp_insert_post ( $args );
		fwrite( $file_handle, "Storing code {$args['old_code_id']}\n" );
		add_post_meta( $code_id, 'download_count', $args['count'] );
		add_post_meta( $code_id, 'download_date', $args['downloaded'] );
		
		p2p_type( 'record_to_code' )->connect( $record_id, $code_id, array(
			'date' => current_time('mysql')
		) );
	}

	fclose( $file_handle );
}

function db_connect($database)   //connects to database
  {
     $db = @mysql_connect('localhost', 'root', 'root');
     if (!$db)
     {
       exit("Could not connect to Database. Please try again.");
     }
     if (!@mysql_select_db($database))
     {
       exit("Could not connect to Database. Please try again.");
     }
  }


function delete_users() {
	$result = mysql_query( 'SELECT user_id FROM wp_usermeta WHERE meta_key="wp_user_level" AND meta_value=2' );
	while ( $user = mysql_fetch_row( $result ) ) {
		wp_delete_user( $user[0] );
	}
}

function delete_posts() {
	$args = array (
		'post_type' => array('record', 'code'),
	);

	$query = new WP_Query( $args );
	
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<pre>' . print_r($post, true) . '</pre>';
		wp_delete_post( $post->ID, true );
	}
}

?>
