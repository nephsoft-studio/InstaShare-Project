<form class="modify-contact-form mb-5" method="POST" enctype="multipart/form-data">
	<?php wp_nonce_field( 'pzfm_save_contact', 'pzfm_save_contact_field' ); ?>
	<div class="row">
		<div class="col-xl-9 mb-4">
			<div class="card shadow mb-3">
				<div class="card-header pzfm-header">
					<?php esc_html_e( 'Personal Information', 'pz-frontend-manager' ); ?>
				</div>
				<?php if( !empty( pzfm_personal_info_fields() ) ): ?>
					<div class="card-body">
						<div class="row mb-3">
							<?php foreach( pzfm_personal_info_fields() as $form_key => $form_fields ): ?>
								<?php
									$user_info = get_userdata($user_id);
									$class = $form_key;
									$value = get_user_meta( $user_id, $form_key, true ) ? : '';
									if($form_key == 'email'){
										$value = (!empty($user_info->user_email)) ? $user_info->user_email : '';
									}elseif( $form_key == 'username' ){
										$username = (!empty($user_info->user_login)) ? $user_info->user_login : '';
										$value = $username;
									}
									echo pzfm_field_generator( $form_fields, $form_key, $value, $class);
								?>
							<?php endforeach; ?>
							<?php if( !empty( pzfm_get_all_roles() ) && pzfm_can_assign_role() ): ?>
								<div class="col-md-6 pzfm-select-input">
									<div class="pzfm-select-user-role-wrap">
										<label for="user_role" class="col-md-12 pl-0 pt-2 strong"><?php esc_html_e( 'Role', 'pz-frontend-manager' ); ?></label>
										<select name="user_role[]" id="user_role" class="form-control pzfm-multiselect-field" multiple="multiple">
											<?php foreach( pzfm_get_all_roles() as $role_meta => $role_label ): ?>
												<option value="<?php echo esc_html( $role_meta ); ?>" <?php selected( !empty($user_roles) ? in_array( $role_meta, $user_roles) : '' ); ?>><?php echo esc_html( $role_label ); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
							<?php do_action( 'pzfm_after_personal_info_fields', $user_id ); ?>
						</div>
						<?php if( (int)$user_id ): ?>
							<div class="row mb-3" id="user-id-wrapper" style="display:none;">
								<div class="col-md-6">
									<label for="user_id" class="strong"><?php esc_html_e( 'User ID', 'pz-frontend-manager' ); ?></label>
									<input type="text" id="user_id" class="form-control" name="user_id" value ="<?php echo (int)$user_id; ?>" readonly>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php do_action( 'pzfm_after_personal_info_card', $user_id ); ?>
			<?php do_action( 'pzfm_additional_contact_info', $user_id ); ?>
		</div>
		<div class="col-xl-3">
			<div class="card shadow mb-4">
				<div class="card-header pzfm-header">
					<?php esc_html_e( 'Upload Profile', 'pz-frontend-manager' ); ?>
				</div>	
				<div class="card-body">
					<div id="pzfm-avatar-wrapper" class="col-md-12">
						<div id="user-avatar">
							<a href="#" id="pzfm-change-avatar"><i class="fa fa-camera text-primary"></i></a>
							<div class="photo-container">
								<img alt="" src="<?php echo pzfm_user_avatar_url( $user_id ); ?>" class="avatar avatar-128 photo photo-inner" height="200" width="200" loading="lazy" decoding="async">
							</div>
						</div>
						<div id="upload-avatar-wrapper" style="display:none;">
							<a href="#" id="close-upload-avatar"><i class="fa fa-close text-danger"></i></a>
							<div id="upload-avatar" ></div>
							<div id="croppie-actions">
								<input type="file" id="upload" class="btn actionUpload btn-primary btn-sm" value="<?php esc_html_e('Upload Avatar', 'pz-frontend-manager' ); ?>" accept="image/*" style="width: 100%;" />
								<input type="hidden" name="pzfm_avatar_id" value="">
								<a class="button actionSave btn btn-success btn-sm"><?php esc_html_e('Save avatar', 'pz-frontend-manager' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if( pzfm_parameters('action') == 'add-contact' ){ ?>
				<div class="card shadow my-3">
					<div class="card-header pzfm-header">
						<?php esc_html_e( 'Send Email Notification', 'pz-frontend-manager' ); ?>
					</div>	
					<div class="card-body">
						<label for="pzfm-send-notif">
							<input type="checkbox" id="pzfm-send-notif" name="pzfm-send-notif" value="1">
							<?php esc_html_e( 'Send the new user an email about their account.', 'pz-frontend-manager' ); ?>
						</label>
					</div>
				</div>
			<?php } ?>
			<div class="card shadow my-3">
				<div class="card-header pzfm-header">
					<?php esc_html_e( 'User Password', 'pz-frontend-manager' ); ?>
				</div>	
				<div class="card-body generate-password-wrap">
					<button type="button" id="pzfm-gen_newpass" class="btn btn-sm btn-secondary mb-2"><?php esc_html_e( 'Set new password', 'pz-frontend-manager' ); ?></button>
					<div class="form-group <?php echo $generate_password ? '' : 'd-none'; ?>">
						<input type="text" name="pzfm_new_password" class="form-control form-control-sm input-lg" rel="gp" minlength="6" data-size="12" data-character-set="a-z,A-Z,0-9,#" value="<?php echo esc_html( $generate_password ); ?>">
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-sm btn-block btn-pzfm"><?php esc_html_e( 'Save', 'pz-frontend-manager' ); ?></button>
		</div>
	</div>
</form>