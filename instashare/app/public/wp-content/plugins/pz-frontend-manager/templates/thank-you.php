<?php include( pzfm_include_template( 'header' ) ); ?>
<div id="wrapper">
    <div class="pzfm-login login-page d-flex flex-row min-vh-100 w-100">
        <?php do_action('pzfm_thankyou_video_sidebar'); ?>
        <?php if(!has_action('pzfm_thankyou_video_sidebar')){ ?>
            <?php if( !empty(pzfm_logout_banner()) ) : ?>
        		<?php pzfm_logout_banner(); ?>
        	<?php endif; ?>
    	<?php } ?>
    	<div id="login-section" class="col-md-6 d-flex flex-column justify-content-center bg-white">
    		<div class="p-5">
    			<div class="reg-login-title px-3 text-center mb-3">
    			    <a href="<?php echo home_url(); ?>"><img class="m-auto" src="<?php echo pzfm_dashboard_logo(); ?>" alt="site-logo" /></a>
    			    <div class="py-3">
        			    <h3 class="font-weight-bold"><?php esc_html_e('Your account has been successfully created', 'pz-frontend-manager' ); ?>.</h3>
        			    <p><?php esc_html_e('Please check your inbox/spam/promotion in the email you have provided for the activation link', 'pz-frontend-manager' ); ?>.</p>
    			    </div>
    			    <a href="<?php echo apply_filters('pzfm_loginbtn_redirectUrl', home_url('/login/')); ?>" class="btn login-btn"><?php esc_html_e('Login Here', 'pz-frontend-manager' ); ?></a>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<?php include( pzfm_include_template( 'footer' ) ); ?>
                