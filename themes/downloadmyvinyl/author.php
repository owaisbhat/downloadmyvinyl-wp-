<?php get_header(); ?>

<?php 

/* PASSWORD RESET */
if ( isset( $_POST['new-password'] ) && !empty( $_POST['new-password'] ) && isset( $_POST['confirm-password'] ) && !empty( $_POST['confirm-password'] ) ) :
	$new_password = wp_kses( $_POST['new-password'] );
	$confirm_password = wp_kses( $_POST['confirm-password'] );
	if ( $new_password === $confirm_password ) :
		$user_login = $current_user->user_login;
		wp_set_password( $new_password, $current_user->ID );
		$creds = array(
			'user_login' => $user_login,
			'user_password' => $new_password
		);
		// make sure to log user back in after password change
		wp_signon( $creds, false );
		$is_success = true;
	else:
		$error_messages[] = "Sorry, there was an error updating your password.  Please make sure your passwords match and try again.";
	endif;
	// Confirmation left blank
	elseif ( ( isset( $_POST['new-password'] ) && !empty( $_POST['new-password'] ) ) &&
		( !isset( $_POST['confirm-password'] ) || empty( $_POST['confirm-password'] ) ) ) :
			$error_messages[] = "Sorry, the password confirmation field was left blank.  Please type in a new password and confirm it in the boxes below.";
	// Password field left blank
	elseif ( ( isset( $_POST['confirm-password'] ) && !empty( $_POST['confirm-password'] ) ) &&
		( !isset( $_POST['new-password'] ) || empty( $_POST['new-password'] ) ) ) :
			$error_messages[] = "Sorry, the new password field was left blank even though the password confirmation was entered.  Please type in a new password and confirm it in the boxes below.";
	endif;
/* PASSWORD */

global $current_user;
get_currentuserinfo();

$label = get_user_meta( $current_user->ID, 'record_label', true);
$records = get_records( $current_user->ID );

?>

<h1><?php echo $label; ?></h1>
<div class="row">
	<div class="span12">
		<div class="records">
			<?php 
				foreach( $records as $record ) :
				$record_meta = get_post_meta( $record->ID );
				extract ($record_meta);

				$format = wp_get_post_terms( $record->ID, 'format' );
				$format = $format[0];
				$code_count = get_code_count( $record->ID );
			?>
				<div class="span3">
					<div class="record">
						<div class="thumb">
							<?php echo get_the_post_thumbnail( $record->ID, array( 110, 110 ) ); ?>
						</div>
						<div class="record-info">
							<div class="band">
								<?php echo $band[0]; ?>
							</div>
							<div class="record-title">
								"<?php echo $record_title[0]; ?>"
							</div>
							<div class="format">
								<?php echo $format->name; ?>
							</div>
							<div class="codes">
								<?php echo $code_count; ?> codes generated	
							</div>
						</div>
					</div>
				</div><!-- end span3 -->
			<?php endforeach; ?>
		</div><!-- end .records -->
	</div><!-- end span12 -->
</div>
	
<?php
/*
echo do_shortcode( "[gravityform id=2 ajax=true]" ); 
<form action='' method='post' >
	<div class='input-prepend'>
		<span class='add-on'>New password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<input class='span4' id='new-password' name='new-password' type='password' placeholder='enter your password here...' autocomplete='off'>
	</div><!-- end .input-prepend -->
	<div class='input-prepend'>
		<span class='add-on'>Confirm password</span>
		<input class='span4' id='confirm-password' name='confirm-password' type='password' placeholder='confirm your password here...' value='' autocomplete='off'>
	</div><!-- end .input-prepend -->

	<?php //Save Buttons ?>
	<hr>
	<input type='hidden' name='did_submit' value='1' />
	<div class="profile-buttons">
		<button type='submit' class='btn btn-success btn-large'>Save Changes</button>
		<button type='button' class='btn btn-large btn-cancel'>Cancel</button>
	</div><!-- end .profile-buttons -->
	<?php wp_nonce_field( 'user-profile-submit-action', 'user-profile-nonce' ); ?>
</form>
 */

?>
<?php get_footer(); ?>
