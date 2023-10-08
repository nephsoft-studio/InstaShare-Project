<div class="col-md-12">
	<section class="row">
		<div class="mb-4 col-md-6">
			<div class="card shadow">
				<div class="card-header pzfm-header">
					<?php esc_html_e( 'User Registration', 'pz-frontend-manager' ); ?>
				</div>
				<div class="card-body">
					<section class="registration-wrapper mb-4">
						<div class="custom-control custom-switch mb-3">
							<input type="checkbox" id="enable-registration" class="custom-control-input" name="pzfm-registration" value="1" <?php echo pzfm_registration() ? 'checked' : ''; ?>>
							<label class="custom-control-label" for="enable-registration"><?php esc_html_e( 'Enable user registration', 'pz-frontend-manager' ); ?></label>
						</div>
						<div class="custom-control custom-switch">
							<input type="checkbox" id="enable-activation" class="custom-control-input" name="pzfm-activation" value="1" <?php echo pzfm_activation() ? 'checked' : ''; ?>>
							<label class="custom-control-label" for="enable-activation"><?php esc_html_e( 'Enable user activation', 'pz-frontend-manager' ); ?></label>
						</div>
					</section><!-- registration-wrapper -->
					<section class="default-user-role-wrapper mb-4 pt-4 border-top">
						<h2 class="h4 mb-4"><?php esc_html_e( 'Default User Role', 'pz-frontend-manager' ); ?></h2>
						<select name="pzfm_default_user_role" id="default-user-role" class="custom-select custom-select-sm form-control form-control-sm mw-100 w-50 mb-3">
							<option value="" disabled selected>-- <?php esc_html_e( 'Select a role', 'pz-frontend-manager' ); ?> --</option>
							<?php foreach( pzfm_get_all_roles() as $role_meta => $role_label ): ?>
								<option value="<?php echo esc_html( $role_meta ); ?>" <?php selected( pzfm_default_user_role(), $role_meta, true ); ?>><?php echo esc_html( $role_label ); ?></option>
							<?php endforeach; ?>
						</select>
						<p class="field-descrip"><i><?php esc_html_e( 'Select a default role of the user upon registration.', 'pz-frontend-manager' ); ?></i></p>
					</section> <!-- default-user-role-wrapper -->
					<section class="recaptcha-wrapper mb-4 pt-4 border-top">
						<h2 class="h4 mb-4"><?php esc_html_e( 'ReCaptcha', 'pz-frontend-manager' ); ?></h2>
						<div class="map-integ-wrapper mb-3">
							<div class="custom-control custom-switch">
								<input type="checkbox" id="pzfm-enable-recaptcha" class="custom-control-input" name="pzfm-enable-recaptcha" value="1" <?php checked( pzfm_recaptcha_active(), 1 ) ?>>
								<label class="custom-control-label" for="pzfm-enable-recaptcha"><?php esc_html_e( 'Enable ReCaptcha upon registration', 'pz-frontend-manager' ); ?></label>
							</div>
						</div>
						<div class="map-details mb-2">
							<p class="strong"><?php esc_html_e( 'Site Key', 'pz-frontend-manager' ); ?></p>
							<input type="text" class="form-control form-control-sm" id="pzfm-captcha-site-key" name="pzfm-captcha-site-key" value="<?php echo pzfm_captcha_site_key(); ?>"/>
						</div>
						<div class="map-details">
							<p class="strong"><?php esc_html_e( 'Secret Key', 'pz-frontend-manager' ); ?></p>
							<input type="text" class="form-control form-control-sm" id="pzfm-captcha-secret-key" name="pzfm-captcha-secret-key" value="<?php echo pzfm_captcha_secret_key(); ?>"/>
						</div>
						<span class="field-descrip"><?php esc_html_e( 'Learn how to generate your keys ', 'pz-frontend-manager' ); ?>
							<a class="strong" href="https://developers.google.com/recaptcha/intro" target="_blank"><?php esc_html_e( 'here', 'pz-frontend-manager' ); ?></a>. <?php esc_html_e('Make sure to select the "reCAPTCHA v2
" for the reCAPTCHA type.', ''); ?></span>
					</section><!-- recaptcha-wrapper -->
				</div>
			</div>
		</div>
		<div class="mb-4 col-md-6">
			<div class="card shadow">
				<div class="card-header pzfm-header">
				<?php esc_html_e( 'User Activation Email', 'pz-frontend-manager' ); ?>
				</div>
				<div class="card-body">
					<div class="new-activation-email-fields">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="pzfm-activation-email-from" class="strong"><?php esc_html_e( 'From Email', 'pz-frontend-manager' ); ?></label>
									<input id="pzfm-activation-email-from" type="text" class="form-control form-control-sm" name="pzfm-activation-email[from]" value="<?php echo pzfm_activation_email( 'from' ); ?>">
								</div>
								<div class="col-md-6 mb-3">
									<label for="pzfm-activation-email-name-from" class="strong"><?php esc_html_e( 'From Name', 'pz-frontend-manager' ); ?></label>
									<input id="pzfm-activation-email-name-from" type="text" class="form-control form-control-sm" name="pzfm-activation-email[name]" value="<?php echo pzfm_activation_email( 'name' ); ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 mb-3">
									<label for="pzfm-activation-email-subject" class="strong"><?php esc_html_e( 'Email Subject', 'pz-frontend-manager' ); ?></label>
									<input id="pzfm-activation-email-subject" type="text" class="form-control form-control-sm" name="pzfm-activation-email[subject]" value="<?php echo pzfm_activation_email( 'subject' ); ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label for="pzfm-contact-content" class="strong"><?php esc_html_e( 'Email Content', 'pz-frontend-manager' ); ?></label>
									<?php pzfm_editor_field( 'pzfm-activation-email-content', get_option( 'pzfm-activation-email-content' ) ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>