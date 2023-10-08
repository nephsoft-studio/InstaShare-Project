<?php
$publish_label 		= pzfm_parameters('action') == 'update' ? esc_html__('Update', 'pz-frontend-manager') : esc_html__('Publish', 'pz-frontend-manager') ;
$default_image 		= PZ_FRONTEND_MANAGER_ASSETS_PATH.'images/post-placeholder.png';
$post_title         = '';
$post_content       = '';
$post_categories    = array();
$post_id            = 0;
$post_image  		= false;
if( !empty( pzfm_parameters( 'id' ) ) ){
	$post_id          	= pzfm_parameters( 'id' );
	$post_title 		= get_the_title( $post_id );
	$post_content 		= get_post_field('post_content', $post_id );
	$post_categories 	= wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
	$post_tags 			= wp_get_post_tags( $post_id );
	$post_image 		= get_post_thumbnail_id( $post_id );
	$post_url			= get_the_permalink( $post_id );
}
$post_status    = get_post_status();

?>
<form class="add-post-form mb-5" method="POST" enctype="multipart/form-data">
	<?php wp_nonce_field( 'pzfm_save_post', 'pzfm_save_post_field' ); ?>
	<div class="row">
		<div class="col-xl-9 mb-4">
			<?php do_action( 'pzfm_before_post_name', $post_id ); ?>
			<div class="card shadow mb-4">
				<div class="card-body">
					<div class="pzfm-post-title">
						<input id="post_title" class="form-control form-control-sm" type="text" name="post_title" placeholder="<?php esc_html_e( 'Title', 'pz-frontend-manager' ); ?>" value="<?php echo esc_attr( $post_title ); ?>" required="">
					</div>
					<?php if( $post_id ): ?>
						<div class="mt-1">
							<div class="pzfm-post-url">
								<a href="<?php echo esc_url( $post_url ); ?>"><?php echo esc_html( $post_url );  ?></a>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="card shadow mb-4"> 
				<div class="card-header pzfm-header">
				<?php echo apply_filters( 'pzfm_content_form_section_header_label', esc_html__(' Content', 'pz-frontend-manager') ); ?>
				</div>
				<div class="card-body">
					<?php echo pzfm_editor_field( 'pzfm-post-content', $post_content );?>
				</div>
			</div>
			<?php do_action( 'pzfm_after_post_name', $post_id ); ?>
			<?php do_action( 'pzfm_before_post_short_description', $post_id ); ?>
			<div class="card shadow mb-3">
				<div class="card-header pzfm-header">
					<?php echo apply_filters( 'pzfm_categories_form_section_header_label', esc_html__(' Excerpt', 'pz-frontend-manager') ); ?>
				</div>
				<div class="card-body">
					<textarea rows="6" id="post_short_description" class="post_short_description form-control" aria-describedby="basic-addon2" name="post_short_description"><?php echo get_post_field( 'post_excerpt', $post_id ); ?></textarea>
				</div>
			</div>
			<?php do_action( 'pzfm_after_post_short_description', $post_id ); ?>
		</div>
		<div class="col-xl-3 mb-4">
			<?php do_action( 'pzfm_before_post_categories', $post_id ); ?>
			<?php include_once pzfm_include_template( 'posts/misc.tpl' ); ?>
			<div class="card shadow mb-4">
				<div class="card-header pzfm-header">
					<?php echo apply_filters( 'pzfm_categories_form_section_header_label', esc_html__(' Categories', 'pz-frontend-manager') ); ?>
				</div>
				<div class="card-body">
					<?php pzfm_category_checklist( $post_id ); ?>
				</div>
			</div>
			<?php do_action( 'pzfm_before_post_featured_image', $post_id ); ?>
			<div id="pzfm-featured-image_card" class="card shadow mb-4">
				<div class="card-header pzfm-header">
					<?php echo apply_filters( 'pzfm_featured_image_form_section_header_label', esc_html__(' Featured Image', 'pz-frontend-manager') ); ?>
				</div>
				<div class="card-body">
					<div class="post-image-wrapper text-center p-1">
						<img class="thumbnail upload-image mw-100" src="<?php echo (!empty($post_image)) ? wp_get_attachment_url($post_image) : $default_image; ?>" alt="img" data-upload="product_image"><br>
						<input type="hidden" name="post_image" value="<?php echo esc_attr( $post_image ); ?>" class="upload-post-holder">
						<p class="text-muted text-sm m-0" id="set-post-thumbnail-desc"><?php esc_html_e( 'Click the image to edit or update', 'pz-frontend-manager' ); ?></p>
					</div>
					<?php if( $post_image ): ?>
						<a href="#" class="pzfm-remove-featured_image text-sm text-danger"><?php esc_html_e( 'Remove featured image', 'pz-frontend-manager' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<?php do_action( 'pzfm_after_post_featured_image', $post_id ); ?>
			<?php if( in_array( 'administrator', pzfm_current_user_role() ) ){ ?>
			<div class="card shadow mb-4">
				<div class="card-header pzfm-header">
					<?php echo apply_filters( 'pzfm_author_form_section_header_label', esc_html__(' Author', 'pz-frontend-manager') ); ?>
				</div>
				<div class="card-body">
					<select class="form-control pzfm-select-field" name="assigned_author">
						<option value="" selected>-- <?php esc_html_e( 'Select', 'pz-frontend-manager'); ?> --</option>
						<?php if(!empty( pzfm_get_users( array() ) ) ): ?>
							<?php foreach( pzfm_get_users( array() ) as $user_id => $username ) : ?>
								<option value="<?php echo (int)$user_id; ?>" <?php selected( pzfm_author_id( $post_id ), $user_id ); ?>><?php echo esc_html( $username ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div>
			<?php } ?>
			<div class="card shadow mb-4 pzfm-tags-card">
				<div class="card-header pzfm-header">
				<?php echo apply_filters( 'pzfm_tags_form_section_header_label', esc_html__(' Tags', 'pz-frontend-manager') ); ?>
				</div>
				<div class="card-body">
					<div class="tags_name">
						<select id="tags_name" class="form-control pzfm-select-tags-field" type="text" name="post-tags[]" multiple>
							<?php if(!empty($post_tags)){ ?>
								<?php foreach( $post_tags as $tag ) { ?>
									<option value="<?php echo esc_attr($tag->name); ?>"><?php echo esc_html( $tag->name ); ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<?php if( !empty( $post_id ) ):  
						$term_list = wp_get_post_tags($post_id, array("fields" => "all")); 	
						foreach( $term_list as $tag ): ?>
							<label for="<?php echo esc_attr( $tag->slug ); ?>">
								<input type="checkbox" id="<?php echo esc_attr( $tag->slug ); ?>" name="remove-post-tags[]" value="<?php echo esc_attr( $tag->name ); ?>" checked>
								<?php echo esc_html( $tag->name ); ?>
							</label>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</form>