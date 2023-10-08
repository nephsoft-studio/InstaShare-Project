<div class="bg-white mb-5">
	<form method="POST" enctype="multipart/form-data">
	<?php wp_nonce_field( 'pzfm_edit_profile', 'pzfm_edit_profile_field' ); ?>
		<div class="row">
			<div class="col-xl-9">
			    <?php do_action( 'pzfm_before_personal_info_card', get_current_user_id() ); ?>
				<div class="card shadow mb-4 px-0">
					<div class="card-header pzfm-header">
						<?php esc_html_e( 'Personal Information', 'pz-frontend-manager' ); ?>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<?php do_action( 'pzfm_before_personal_info_fields' , get_current_user_id() ); ?>
								<div class="row mb-3 pzfm-profile-fields">
								<?php if( !empty( pzfm_personal_info_fields() ) ): ?>
									<?php foreach( pzfm_personal_info_fields() as $form_key => $form_fields ): ?>
										<?php
											$user_info = get_userdata(get_current_user_id());
											$value = get_user_meta( get_current_user_id(), $form_key, true ) ? : '';
											if($form_key == 'email'){
												$user_email = (!empty($user_info->user_email)) ? $user_info->user_email : '';
												$value = $user_email;
											}elseif( $form_key == 'username' ){
												$username = (!empty($user_info->user_login)) ? $user_info->user_login : '';
												$value = $username;
											}elseif( $form_key == 'country' ){
											  $value = $value ? $value : 'US';
											}  
											echo pzfm_field_generator( $form_fields, $form_key, $value, $form_key );
										?>
										<?php if( $form_key == 'phone' ): ?>
											<div class="pzfm-error-message col-md-12">
												<div class="row">
													<div class="inner-wrap col-md-6">
														<span id="hidden-message" class="hide"><?php esc_html_e( 'Please input full format on phone', 'pz-frontend-manager' ); ?>:</span>
													</div>
													<div class="inner-wrap col-md-6">
														<span id="valid-msg" class="hide text-success">✓ <?php esc_html_e( 'Valid', 'pz-frontend-manager' ); ?></span>
														<span id="error-msg" class="text-danger"></span>
													</div>
												</div>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
								<?php do_action( 'pzfm_after_personal_info_fields', get_current_user_id() ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if(in_array( 'administrator', pzfm_current_user_role())) : ?>
					<div class="card shadow mb-4 px-0">
						<div class="card-header pzfm-header">
							<?php esc_html_e( 'Social Media', 'pz-frontend-manager' ); ?>
						</div>
						<div id="pzfm-social-media" class="card-body pzfm-social-media-wrap pt-0">
							<div class="table-responsive">
                                <table class="table" width="100%" cellspacing="0" =>
                                    <thead>
                                        <tr>
                                            <th><?php esc_html_e( 'Name', 'pz-frontend-manager' ); ?></th>
                                            <th><?php esc_html_e( 'URL', 'pz-frontend-manager' ); ?></th>
											<th><?php esc_html_e( 'Icon', 'pz-frontend-manager' ); ?></th>
                                            <th></th>
                                        </tr>
                                    </thead>
									<tbody data-repeater-list="pzfm-social-media">
										<tr data-repeater-item>
											<td><input type="text" class="form-control" name="pzfm-soc-name"></td>
											<td><input type="text" class="form-control" name="pzfm-soc-url"></td>
											<td>
												<div class="icon-image-wrapper text-left p-1" role="button">
													<img class="thumbnail upload-image" src="<?php echo PZ_FRONTEND_MANAGER_ASSETS_PATH . 'images/icons/upload.png'; ?>" alt="img" data-upload="product_image" style="width: 31px;"><br>
													<input type="hidden" name="pzfm-soc-icon" value="" class="upload-image-holder">
												</div>
											</td>
											<td><i class="fa-solid fa-trash text-danger" data-repeater-delete></i></td>
										</tr>
										<?php if(get_user_meta( get_current_user_id(), 'pzfm_social_media', true )) : ?>
											<?php foreach(get_user_meta( get_current_user_id(), 'pzfm_social_media', true ) as $key => $value) : ?>
												<tr data-repeater-item>
													<td><input type="text" class="form-control" name="pzfm-soc-name" value="<?php echo $value['pzfm-soc-name']; ?>"></td>
													<td><input type="text" class="form-control" name="pzfm-soc-url" value="<?php echo $value['pzfm-soc-url']; ?>"></td>
													<td>
														<div class="icon-image-wrapper text-left p-1" role="button">
															<img class="thumbnail upload-image" src="<?php echo ($value['pzfm-soc-icon']) ? wp_get_attachment_url( $value['pzfm-soc-icon'] ) : PZ_FRONTEND_MANAGER_ASSETS_PATH . 'images/icons/upload.png'; ?>" alt="img" data-upload="product_image" style="width: 31px;"><br>
															<input type="hidden" name="pzfm-soc-icon" value="<?php echo ($value['pzfm-soc-icon']) ? $value['pzfm-soc-icon'] : ''; ?>" class="upload-image-holder">
														</div>
													</td>
													<td><i class="fa-solid fa-trash text-danger" data-repeater-delete></i></td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
							<div class="btn btn-sm btn-pzfm" data-repeater-create>
								<?php esc_html_e( 'Add New', 'pz-frontend-manager' ); ?>
							</div>
						</div>	
					</div>
				<?php endif; ?>
				<?php do_action( 'pzfm_after_personal_info_card', get_current_user_id() ); ?>
			</div>
			<div class="col-xl-3">
				<div class="card shadow mb-4">
					<div class="card-header pzfm-header">
						<?php esc_html_e( 'Upload Profile', 'pz-frontend-manager' ); ?>
					</div>	
					<div class="card-body">
						<div id="pzfm-avatar-wrapper" >
							<div id="user-avatar">
								<a href="#" id="pzfm-change-avatar"><i class="fa fa-camera text-primary"></i></a>
								<div class="photo-container">
									<img alt="" src="<?php echo pzfm_user_avatar_url( get_current_user_id() ); ?>" class="avatar avatar-128 photo photo-inner" height="200" width="200" loading="lazy" decoding="async">
								</div>
							</div>
							<div id="upload-avatar-wrapper" style="display:none;">
								<a href="#" id="close-upload-avatar"><i class="fa fa-close text-danger"></i></a>
								<div id="upload-avatar" ></div>
								<div id="croppie-actions">
									<input type="file" id="upload" class="btn actionUpload btn-primary btn-sm" value="<?php esc_html_e('Upload Avatar', 'pz-frontend-manager' ); ?>" accept="image/*" style="width: 100%;" />
									<a class="button actionSave btn btn-success btn-sm"><?php esc_html_e('Save avatar', 'pz-frontend-manager' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php do_action( 'pzfm_after_upload_profile', get_current_user_id() ); ?>
				<div class="card shadow mb-4">
					<div class="card-header pzfm-header">
						<?php esc_html_e( 'User Password', 'pz-frontend-manager' ); ?>
					</div>	
					<div class="card-body">
						<button type="button" id="pzfm-gen_newpass" class="btn btn-sm btn-secondary mb-2"><?php esc_html_e( 'Set new password', 'pz-frontend-manager' ); ?></button>
					    <div class="form-group d-none">
							<input type="text" name="pzfm_new_password" class="form-control form-control-sm input-lg" rel="gp" minlength="6" data-size="12" data-character-set="a-z,A-Z,0-9,#">
						</div>
					</div>
				</div>
				<?php do_action( 'pzfm_after_user_password', get_current_user_id() ); ?>
				<?php do_action( 'pzfm_before_upload_profile', get_current_user_id() ); ?>
				<div class="justify-content-center my-4">
					<input type="hidden" value="<?php echo get_current_user_id(); ?>" name="user_id">
					<button type="submit" class="btn btn-sm btn-block btn-pzfm save-profile-btn"><?php esc_html_e('Save changes', 'pz-frontend-manager'); ?></button>
				</div>
			</div>
		</div>
  	</form> 
</div>