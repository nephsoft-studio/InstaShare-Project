<div class="mb-4 col-md-12">
	<div class="card shadow">
		<div class="card-header pzfm-header">
			<?php esc_html_e( 'User Capabilities', 'pz-frontend-manager' ); ?>
		</div>
		<div class="card-body">
			<section class="pzfm-contacts-page-settings-wrapper">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<th>&nbsp;</th>
							<?php foreach( array_values( pzfm_get_all_roles() ) as $role_name ): ?>
								<th class="text-center"><?php echo esc_html( $role_name ); ?></th>
							<?php endforeach; ?>
						</thead>
						<tbody>
							<?php foreach ( pzfm_capabilities_array() as $capability ): ?>
								<tr class="capabilities-title">
									<td class="bg-custom font-weight-bold text-dark" colspan="<?php echo count(pzfm_get_all_roles()) + 1; ?>"><?php echo esc_html( $capability['label'] ); ?></td>
								</tr>
								<?php if( !array_key_exists( 'options', $capability) || empty( $capability['options'] ) ) continue; ?>
								<?php foreach( $capability['options'] as $optkey => $optlabel ): ?>
									<?php $assigned_roles = $optkey.'_roles'; ?>
									<tr class="capabilities-row">
										<td><?php echo esc_html( $optlabel ); ?></td>
										<?php foreach( array_keys( pzfm_get_all_roles() ) as $role_key ): ?>
											<?php $cap_id = $role_key.'-'.$optkey; ?>
											<td data-label="<?php echo esc_attr( $role_key ); ?>" class="text-center">
												<div class="custom-control custom-switch">
													<input type="checkbox" id="pzfm-access-<?php echo esc_attr( $cap_id ); ?>" class="custom-control-input" name="<?php echo esc_attr( $optkey ); ?>[]" value="<?php echo esc_attr( wp_unslash($role_key) ); ?>" <?php echo in_array( $role_key, $assigned_roles() ) ? 'checked' : '' ; ?>>
													<label class="custom-control-label" for="pzfm-access-<?php echo esc_attr( $cap_id ); ?>"></label>
												</div>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
</div>