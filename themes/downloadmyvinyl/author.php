<?php get_header(); ?>


<?php

	/* RESET PASSWORD IF REQUESTED
	 ************************************************************/
	get_template_part( 'template-parts/user/password', 'reset' );


	/* GET USER PROFILE
	 ************************************************************/
	get_template_part( 'template-parts/user/user', 'profile' );


	/* SHOW RESET PASSWORD FORM
	 ************************************************************/
	get_template_part( 'template-parts/user/password', 'form' );
?>

	
<?php get_footer(); ?>
