<div class="col bg-white mb-5">
	<div class="row mb-4">
		<div class="card shadow col-md-12 px-0">
			<div class="card-body">
				<div class="row mb-3 pzfm-search-wrap">
					<div class="col-xl-4 col-md-6 px-0">
						<div class="row">
							<div class="col">
								<form id="pzfm-search-form" class="navbar-form d-md-flex" method="get">
									<input type="hidden" name="dashboard" value="<?php echo pzfm_users_page(); ?>">
									<div class="input-group mb-2">
										<input type="text" value="<?php echo esc_html( $search_value ); ?>" name="user-search" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Search for...', 'pz-frontend-manager' ); ?>" aria-label="<?php esc_html_e( 'Search for...', 'pz-frontend-manager' ); ?>" aria-describedby="basic-addon2">
										<?php do_action( 'pzfm_user_filter' ); ?>
										<div class="input-group-append">
											<button type="submit" class="btn btn-sm btn-pzfm"><?php esc_html_e( 'Search users', 'pz-frontend-manager' ); ?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-md-6 px-0 text-right pzfm-add-btn-wrap">
						<div class="row">
							<div class="col-xl-12">
								<?php if( pzfm_can_add_user() ): ?>
									<a href="<?php echo get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page().'&action=add-user'; ?>" class="btn btn-pzfm text-white btn-sm"><?php esc_html_e( 'Add user', 'pz-frontend-manager' ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="pzfm_table pzfm_user_table">
						<div class="row mb-2">
							<div class="col">
								<?php
								$count_users = apply_filters( 'pzfm_count_users', count_users() );
								$admin_count = (int)$count_users['avail_roles']['administrator'];
								$all_count 	 = (int)$count_users['total_users'] - $admin_count;
								unset($count_users['avail_roles']['administrator']);
								$all_class 	 = !isset($_GET['filter']) ? 'text-muted' : '' ;
								$role_list 		 = array(
									'all' => sprintf( 
										'<a href="%s" class="small mr-2 font-weight-bold %s">%s</a>(%d)', 
									 	esc_url_raw( get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page() ), 
										esc_attr( $all_class ),
										esc_html__('ALL', 'pz-frontend-manager'),
										$all_count
									)
								);
								foreach ($count_users['avail_roles'] as $rkey => $rvalue) {
									if( !array_key_exists( $rkey, $wp_roles->role_names)){
										continue;
									}
									$class = isset($_GET['filter']) && $rkey == $_GET['filter'] ? 'text-muted' : '' ;
									$role_list[$rkey] = sprintf(
										'<a href="%s" class="small mr-2 %s">%s</a>(%s)',
										esc_url_raw( get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page().'&filter='.$rkey ),
										esc_attr( $class ),
										$wp_roles->role_names[$rkey],
										esc_html($rvalue)
									);
								}
								?>
								<ul class="pzfm-role_list">
									<li><?php echo implode( '</li><li>', $role_list ); ?></li>
								</ul>
							</div>
						</div>
					<table class="table table-sm">
						<thead class="table-head">
							<tr class="gcfl-header-text">
								<?php if( pzfm_can_delete_user() ): ?>
									<th scope="col"><input id="bulk-select-all" type="checkbox" class="bulk-select-all"></th>
								<?php endif; ?>
								<th colspan="2"><?php esc_html_e( 'Name', 'pz-frontend-manager' ); ?></th>
								<th><?php esc_html_e( 'Email', 'pz-frontend-manager' ); ?></th>
								<?php do_action( 'pzfm_after_users_header' ); ?>
							</tr>
						</thead>
						<?php if( ! empty( $user_results ) ): ?>
							<tbody>
								<?php foreach( $user_results as $users ): ?>
									<?php 
										$user_id 	= $users->ID;
										$activated 	= get_user_meta( $user_id, 'account_activated', true );
										$user_info 	= get_userdata($user_id);
										$user_email = $user_info->user_email;
										$page_action 	= pzfm_can_edit_user() ? 'update' : 'view';
										$user_label_url = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page().'&action='.$page_action.'&id='.$user_id;

									?>
									<tr id="pzuser-<?php echo (int)$user_id; ?>" class="pz-row pzpost-row" data-id="<?php echo (int)$user_id; ?>">
										<?php if( pzfm_can_delete_user() ): ?>
											<td class="align-middle"><input type="checkbox" value="<?php echo (int)$user_id; ?>" name="user_checkbox[]" class="bulk-select-checkbox"></td>
										<?php endif; ?>
										<td colspan="2" data-label="<?php esc_html_e( 'Name', 'pz-frontend-manager' ); ?>">
											<div class="row align-items-center pzfm-avatar-wrap">
												<div class="col col-auto pr-0">
													<span class="pzfm-user-avatar" style="background-image:url(<?php echo pzfm_user_avatar_url( $user_id ); ?>)"></span>
												</div>
												<div class="col pr-0">
													<a href="<?php echo esc_url_raw( $user_label_url ); ?>"><?php echo pzfm_user_full_name( $user_id ); ?></a>
													<section class="pzfm-row-actions">
														<ul>
														<?php foreach ( $table_actions as $actn_key => $actn_label ): ?>
															<?php 
																$class = 'pzfm-post_'.$actn_key;
																$link  = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page().'&action=view&id='.$user_id;
																if( $actn_key == 'delete' ){
																	$link = '#';
																	$class .= ' text-danger user-remove-btn';
																}elseif( $actn_key == 'edit' ){
																	$link = $user_label_url; 
																}	
															?>
															<li><a href="<?php echo esc_url_raw( $link ); ?>" class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $actn_label ); ?>" data-id="<?php echo (int)$user_id; ?>"><?php echo esc_html( $actn_label ); ?></a></li>
														<?php endforeach; ?>
														</ul>
													</section>
												</div>
											</div>
										</td>
										<td data-label="<?php esc_html_e( 'Email', 'pz-frontend-manager' ); ?>">
											<a href="mailto:<?php echo esc_attr( $user_email ); ?>"><?php echo esc_html( $user_email ); ?></a>
										</td>
										<?php do_action( 'pzfm_after_users_details', $user_id ); ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						<?php else: ?>
							<tr>
								<td colspan="<?php echo count( $pzfm_personal_info_fields ) + 3; ?>"><div class="alert alert-warning"><?php esc_html_e( 'No users found.', 'pz-frontend-manager' ); ?></div></td>
							</tr>
						<?php endif; ?>
					</table>
					<?php do_action( 'pzfm_after_users_table' ); ?>
				</div>
				<div class="row align-items-center">
					<?php if( pzfm_can_delete_user() ): ?>
						<section class="col-md-6">
							<div class="row align-items-center">
								<div class="col col-auto pr-0">
									<select name="pzfm-bulk-actions" class="form-control form-control-sm d-inline" style="width:120px">
										<option value=""><?php esc_html_e('Bulk Actions', 'pz-frontend-manager'); ?></option>
										<?php foreach( $bulk_actions as $bulk_key => $bulk_label ): ?>
											<option value="<?php echo esc_html( $bulk_key ); ?>"><?php echo esc_html( $bulk_label ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col pl-1">
									<button class="btn btn-sm btn-secondary pzfm-users-bulk_action" style="width: fit-content"><?php esc_html_e('Apply', 'pz-frontend-manager'); ?></button>
								</div>
							</div>
						</section>
					<?php endif; ?>
					<div class="col-md-6 text-left mt-md-0 mt-3 text-md-right">
						<span class="font-italic text-muted"><i><?php echo (int)$total_users,' '.esc_html__( 'users found', 'pz-frontend-manager' ); ?></i></span>
						<?php if( $total_pages ): ?>
							<div class="page-buttons text-center text-md-right d-inline ml-4">
								<?php
									$big = 999999999;
									echo paginate_links( array(
										'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
										'format' => '?paged=%#%',
										'current' => max( 1, get_query_var('paged') ),
										'total' => $total_pages,
										'prev_text' => '&lsaquo;',
										'next_text' => '&rsaquo;'
									) );
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>