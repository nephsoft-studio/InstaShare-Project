<div class="col bg-white mb-5">
	<div class="row mb-4">
		<div id="pzfm-posts_table_wrapper" class="shadow col-md-12 card px-0">
			<div class="card-body">
			<div class="row mb-4 pzfm-search-wrap px-0">
				<?php if( pzfm_can_manage_posts() ): ?>
					<div class="col p-0">
						<form id="pzfm-search-form" class="navbar-form d-md-flex" method="get">
							<input type="hidden" name="dashboard" value="pzfm_posts">
							<div class="input-group mb-2">
								<input type="text" class="form-control form-control-sm" name="pzfm-search" value="<?php echo esc_attr( $searched ); ?>" placeholder="<?php esc_html_e( 'Search for...', 'pz-frontend-manager' ); ?>" aria-label="<?php esc_html_e( 'Search for...', 'pz-frontend-manager' ); ?>" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button class="btn btn-sm btn-pzfm" type="submit"><?php esc_html_e('Search posts', 'pz-frontend-manager'); ?></button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-xl-8 col-md-6 px-0 text-right pzfm-add-btn-wrap">
						<a href="<?php echo get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&action=add-posts'; ?>" class="btn btn-sm btn-pzfm text-white"><?php _e('Add post', 'pz-frontend-manager') ; ?></a>
					</div>
				<?php endif; ?>
				<div class="mt-2 col-md-12 d-md-flex p-0">
					<form method="GET">
						<input type="hidden" name="dashboard" value="pzfm_posts">
						<div class="form-row w-100 m-0">
							<?php if( pzfm_category_dropdown('category') ) : ?>
							<div class="col p-0">
								<?php echo pzfm_category_dropdown('category', 'cat', 'custom-select-sm mr-sm-2'); ?>
							</div>
							<?php endif; ?>
							<div class="col">
								<?php echo pzfm_months_dropdown('post', 'custom-select-sm mr-sm-2'); ?>
							</div>
							<input class="btn btn-sm btn-pzfm" type="submit" value="<?php esc_html_e('Filter', 'pz-frontend-manager'); ?>">
						</div>
					</form>
				</div>
			</div>
				<div class="pzfm_table pzfm_post_table">
					<table class="table table-sm">
						<thead>
							<tr>
								<th scope="col">
									<input id="bulk-select-all" type="checkbox"/>
									<label class="form-check-label sr-only" for="bulk-select-all" ><?php esc_html_e('Select All Posts', 'pz-frontend-manager'); ?></label>
								</th>
								<?php foreach ( array_values( pzfm_post_table_columns() ) as $header ): ?>
									<th scope="col"><?php echo esc_html( $header ); ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
								<tr id="pzpost-<?php echo get_the_ID(); ?>" class="pz-row pzpost-row" data-id="<?php echo get_the_ID(); ?>">
									<td><input class="bulk-select-checkbox" type="checkbox" value="<?php echo get_the_ID(); ?>" data-title="<?php echo get_the_title(); ?>"></td>
									<?php $colcounter = 0; ?>
									<?php foreach ( array_keys( pzfm_post_table_columns() ) as $metakeys ): ?>
										<?php 
											$row_data = apply_filters( 'pzfm_post_row_data_'.$metakeys, get_the_title(), $metakeys ); 
											$edit_url = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&action=update&id='.get_the_ID();
										?>
										<td data-label="<?php echo esc_attr( $metakeys ); ?>" scope="row">
											<?php
											$prefix = get_post_status() == 'draft' && array_key_exists( 'draft', get_post_statuses() ) ? get_post_statuses()['draft'].': ' : '';
			
											echo !$colcounter ? sprintf( '<a href="%s">%s%s</a>', esc_url($edit_url), esc_html($prefix), esc_html($row_data) ) : $row_data;
											do_action( 'pzfm_after_post_row_data_'.$metakeys );
											?>
											<?php if(!$colcounter): ?>
												<section class="pzfm-row-actions">
													<ul>
													<?php foreach ( pzfm_table_actions() as $actn_key => $actn_label ): ?>
														<?php 
															$class = 'pzfm-post_'.$actn_key;
															$link = get_the_permalink(); 
															if( $actn_key == 'delete' ){
																$class .= ' text-danger pzfm-delete-post-btn';
																$link = '#';
															}elseif( $actn_key == 'edit' ){
																$link = $edit_url; 
															}	
														?>
														<li><a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $actn_label ); ?>"><?php echo esc_html( $actn_label ); ?></a></li>
													<?php endforeach; ?>
													</ul>
												</section>
											<?php endif; ?>
										</td>
									<?php $colcounter++; endforeach; ?>
								</tr>
							<?php endwhile; ?>
							<?php if( !$posts->have_posts() ): ?>
								<tr class="col-md-12">
									<td colspan="6"><div class="alert alert-warning"><i><?php esc_html_e( 'No posts found', 'pz-frontend-manager' ); ?>.</i></div></td>
								</tr>
							<?php endif;?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<section class="col-md-6">
						<div class="row align-items-center">
							<div class="col col-auto pr-0">
								<select name="pzfm-bulk-actions" class="form-control form-control-sm d-inline" style="width:120px">
									<option value=""><?php esc_html_e('Bulk Actions', 'pz-frontend-manager'); ?></option>
									<?php foreach( pzfm_table_bulk_actions() as $bulk_key => $bulk_label ): ?>
										<option value="<?php echo esc_attr( $bulk_key ); ?>"><?php echo esc_html( $bulk_label ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col pl-1">
								<button class="btn btn-sm btn-secondary pzfm-post-bulk_action" style="width: fit-content"><?php esc_html_e('Apply', 'pz-frontend-manager'); ?></button>
							</div>
						</div>
					</section>
					<section class="col-md-6 text-left mt-md-0 mt-3 text-md-right">
						<span class="font-italic text-muted"><i><?php printf( _n( '%s post found.', '%s posts found.', $posts->found_posts, 'pz-frontend-manager' ), number_format_i18n( $posts->found_posts ) ); ?></i></span>
						<?php if( $total_pages > 1 ): ?>
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
					</section>
				</div>
			</div>
		</div>
	</div>
</div>