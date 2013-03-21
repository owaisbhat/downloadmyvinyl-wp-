<?php
/*
 * TEMPLATE NAME: Temporary
 */
?>

<?php get_header(); ?>

<?php

$args = array (
	'post_type' => 'record',
);

$record = new WP_Query( $args );
while ( $record->have_posts() ) :
	$record->the_post();
	echo '<pre>' . print_r($post, true) . '</pre>';

	$format_terms = wp_get_post_terms( $post->ID, 'format' );
	echo '<pre>' . print_r($format_terms, true) . '</pre>';

	$img = get_the_post_thumbnail( $post->ID, 'thumbnail');
	echo '<pre>' . print_r($img, true) . '</pre>';


endwhile;	

?>

<?php get_footer(); ?>
