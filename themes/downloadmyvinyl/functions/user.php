<?php

	function get_records( $user_id ) {
		$args = array (
			'post_type' => 'record',
			'post_status' => 'publish',
			'connected_type' => 'user_to_record',
			'connected_items' => $user_id,
			'surpress_filters' => false,
			'nopaging' => true,
			'orderby' => 'post_date',
			'order' => 'ASC',
		);

		return get_posts( $args );
	}

	function get_code_count( $record_id ) {
		$result = mysql_query( "SELECT COUNT( id ) FROM codes WHERE record_id = $record_id" );
		$row = mysql_fetch_row( $result );

		return number_format( $row[0] );

	}

	function get_used_count ( $record_id ) {
		$result = mysql_query( "SELECT COUNT( id ) FROM codes WHERE record_id = $record_id AND expired = 1" );
		$row = mysql_fetch_row( $result );

		return number_format( $row[0] );
	}

?>
