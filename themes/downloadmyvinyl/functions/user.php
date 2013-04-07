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
		$args = array (
			'post_type' => 'code',
			'post_status' => 'any',
			'connected_type' => 'record_to_code',
			'connected_items' => $record_id,
			'surpress_filters' => false,
			'nopaging' => true,
		);

		$query = new WP_Query( $args );

		return number_format( $query->post_count );
	}

?>
