<?php
/*
 * TEMPLATE NAME: Import
 */
?>

<?php get_header(); ?>

<?php
	set_time_limit(11200);
	$db=db_connect('downloadmyvinyl-wp');

	delete_data();
	import_data();
?>


<?php get_footer(); ?>
