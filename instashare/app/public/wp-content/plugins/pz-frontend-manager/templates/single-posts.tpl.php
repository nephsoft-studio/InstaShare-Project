<?php
    $gallery = get_post_meta( get_the_ID(), 'pzfm_gallery', true ) ? : array();
?>
<?php get_header(); ?>
    <div id="wrapper">
		<div id="content-wrapper" class="d-flex flex-column bg-white">
			<div class="gbsdf-featured-bg-image d-inline-block" style="background-image: url(<?php echo pzfm_post_bg_image(get_the_id()); ?>), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)); background-blend-mode: overlay;">
				<div class="container-fluid text-center page-heading">
					<h1 class="text-white position-relative"><?php echo get_the_title(); ?></h1>
					<?php do_action( 'pzfm_after_single_post_title', get_the_ID() ); ?>
				</div>
			</div>
			<div id="content" class="gbsdf-post-content">
				<div class="row">
					<div class="col-md-12">
						<div class="container-fluid l-section-h">
							<?php do_action( 'pzfm_before_single_post_content', get_the_ID() ); ?>
							<?php
								while ( have_posts() ) : the_post();
									echo '<div class="fc-single-content">';
										echo '<p>'.the_content().'</p>';
									echo '</div>';
								endwhile;
							?>
							<?php do_action( 'pzfm_after_single_post_content', get_the_ID() ); ?>
						</div>
					</div>
				</div>
                <?php if( !empty( $gallery ) ): ?>
                	<div class="container">
						<h4><?php esc_html_e( 'GALLERY', 'pz-frontend-manager' ); ?></h4>
	                    <div class="row">
	                        <?php foreach( $gallery as $data ): ?>
	                            <div class="mb-4 col-lg-4">
	                               <div class="col pzfm-portfolio-col d-table pzfm-post-image pt-5 h-100" style="background-image: url(<?php echo wp_get_attachment_url( $data['photo_id'], 'full' ); ?>); background-size: cover;" data-toggle="modal" data-target="#pzfm-img-popup-<?php echo (int)$data['photo_id'] ?>">
                                    	<div class="card-body d-table-cell align-bottom ">
	                                        <div class="pzfm-photo-descrion text-white"><?php echo esc_html( $data['photo_description'] ); ?></div>
	                                    </div>
	                                </div>
	                                <div class="modal pzfm-fade" id="pzfm-img-popup-<?php echo (int)$data['photo_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="pzfm-img-popup" aria-hidden="true">
	                                	<div class="modal-dialog modal-dialog-centered" role="document">
	                                		<img class="" src="<?php echo wp_get_attachment_url( (int)$data['photo_id'], 'full' ); ?>" alt="">
	                                	</div>
	                            	</div>
	                            </div>
	                        <?php endforeach; ?>
	                    </div>
	                </div>
                <?php endif; ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>