<div class="code-section section">
	<div class="row">
		<div class="col-lg-12">
		<?php if ( isset( $_SESSION['error'] ) ) : ?>
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
						<div class="error">
							<?php echo $_SESSION['error']; ?>
						</div>
					</div>
				</div>
			<?php unset( $_SESSION['error'] ); ?>
		<?php endif; ?>
			<div class="code-text">
				Got a download code? Enter your code here:
			</div>
			<div class="code-form">
					<form action="<?php echo get_home_url(); ?>/download/" method="post">
						<input type="text" name="downloadcode" id="downloadcode" maxlength="10" />
						<div class="submit">
							<input type="submit" name="submit" id="submit" class="submit btn btn-success" value="Get your download!" />
						</div>
				</form>
			</div>
			<div class="code-help-form" style="display: none;">
				<?php echo do_shortcode( "[gravityform id='4' ajax=true]" ); ?>
			</div>
		</div>
	</div>
</div>
