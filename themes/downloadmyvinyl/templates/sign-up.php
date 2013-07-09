<?php
/*
 * TEMPLATE NAME: Sign-up
 */
?>

<?php get_header(); ?>

<?php
	echo do_shortcode( "[gravityform id=1 title=false ajax=true]" );
?>

<?php get_footer(); ?>
