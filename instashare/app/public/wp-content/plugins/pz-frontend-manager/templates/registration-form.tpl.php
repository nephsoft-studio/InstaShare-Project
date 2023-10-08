<div id="registration-section" class="pzfm-reg-parent <?php echo !isset($is_shortcode) ? 'offset-md-3 col-md-6 bg-white rounded my-2' : '' ; ?>">
	<div class="container">
		<?php if( !isset($is_shortcode) ): ?>
			<div class="reg-login-title px-3 text-center mb-3">
				<a href="<?php echo home_url(); ?>"><img class="m-auto" src="<?php echo pzfm_dashboard_logo(); ?>" alt="site-logo" /></a>
			</div>
		<?php endif; // Registration - site logo ?>
		<?php if( pzfm_registration() ): ?>
			<?php do_action( 'pzfm_before_registration_form' ); ?>
			<form id="pzfm-registration-form" action="<?php echo esc_url_raw( $redirect_to ); ?>" method="POST" class="pzfm-form-wrap">
				<?php wp_nonce_field('nonce_register', 'nonce_register_field'); ?>
				<div class="row">
					<?php do_action( 'pzfm_before_registration_fields_form' ); ?>
					<?php foreach( pzfm_personal_info_fields() as $form_key => $form_fields ):
						echo pzfm_field_generator( $form_fields, $form_key, '', $form_key );
						endforeach; ?>
					<?php do_action( 'pzfm_after_registration_fields_form' ); ?>
				</div>
					<div class="row">
						<div class="col-lg-6 float-left pb-2">
							<label for="reg_pass" class="strong pt-2"><?php esc_html_e('Password','pz-frontend-manager') ?></label><small id="passwordHelpInline" class="text-danger"> (<?php esc_html_e('Must be at least 8 characters long','pz-frontend-manager') ?>)</small>
							<div>
								<input id="reg_pass" class="form-control form-control-sm register-inputs" type="password" name="reg_pass" value="" placeholder="" required pattern=".{8,}">
							</div>
						</div>
						<div class="col-lg-6 float-left pb-2">
							<label for="confirm_pass" class="strong pt-2"><?php esc_html_e('Retype Password','pz-frontend-manager') ?></label>
							<div>
								<input id="confirm_pass" class="form-control form-control-sm register-inputs" type="password" name="confirm_pass" value="" placeholder="" required pattern=".{8,}">
							</div>
						</div>
					</div>
				<?php do_action( 'pzfm_after_registration_form_fields' ); ?>
				<?php $tou_url = apply_filters( 'pzfm_terms_of_use_url', home_url().'/terms-of-use/' ); ?>
				<div class="form-check">
					<input class="form-check-input mt-2" type="checkbox" id="agree-tc" name="reg_terms_cond" value="agree-tc" required>
					<label class="form-check-label align-middle" for="agree-tc">
						<?php esc_html_e('I agree to the', 'pz-frontend-manager') ?> <a href="<?php echo esc_url_raw( $tou_url ); ?>" target="_blank"><?php esc_html_e('Terms and Conditions', 'pz-frontend-manager') ?></a>
					</label>
				</div>
				<div class="row">
					<div class="col-md-12 pt-5 mb-1 text-center clear-both pzfm-action-wrap">
						<input type="button" id="reg_button" class="btn register-btn py-2" value="<?php esc_html_e('Register', 'pz-frontend-manager') ?>">
						<input type="submit" style="display:none !important" value="<?php esc_html_e('Register', 'pz-frontend-manager') ?>">
						<?php echo pzfm_loader(); ?>
					</div>
				</div>
			</form>
			<div class="login-wrapper col-md-12 text-center mt-4">
				<span><?php esc_html_e('Already have an account?','pz-frontend-manager') ?></span><a href="<?php echo pzfm_login_url(); ?>" class="login-here"><?php esc_html_e(' Login here','pz-frontend-manager') ?></a>
			</div>
			<?php do_action( 'pzfm_after_registration_form' ); ?>
		<?php else: ?>
			<div class="alert alert-danger" role="alert">
				<p><?php esc_html_e( 'Registration is disabled on this site. Kindly contact your system administrator for more information.', 'pz-frontend-manager' ); ?></p>
			</div>
			<p class="text-center"><a href="<?php echo pzfm_login_url(); ?>" class="btn btn-pzfm text-white"><i class="fas fa-arrow-left"></i> <?php esc_html_e( 'Go back to homepage', 'pz-frontend-manager' ); ?></a></p>
		<?php endif; ?>
	</div>
</div>
		
<style>
div#registration-section {
    padding: 2em 1em !important;
}
.registration-page {
    position: unset;
    height: auto !important;
    min-height: auto !important;
    width: 100%;
}
</style>