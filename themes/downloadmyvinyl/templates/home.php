<?php
/*
 * TEMPLATE NAME: Home
 */
?>

<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="span12">

			<?php get_template_part( 'template-parts/home/home', 'code-form' ); ?>

			<?php get_template_part( 'template-parts/home/home', 'info' ); ?>

			<?php get_template_part( 'template-parts/home/home', 'labels' ); ?>

			<?php get_template_part( 'template-parts/home/home', 'contact' ); ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>
