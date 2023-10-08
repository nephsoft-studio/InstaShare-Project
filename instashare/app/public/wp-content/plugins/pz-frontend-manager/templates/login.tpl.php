<?php global $form; ?>
<div class="pzfm-login login-page d-flex flex-row min-vh-100 w-100 <?php echo $form == "true" ? 'pzfm-login-form-active' : ''; ?>">
	<div id="login-bg" class="container-fluid" style="background-image: url(<?php echo pzfm_login_dashboard_background(); ?>) ">
		<section class="row my-5">
			<div id="login-section" class="offset-md-4 col-md-4 bg-white rounded my-5">
				<div class="container">
					<?php do_action( 'pzfm_before_login_content' ); ?>
					<?php if(empty($form) || $form == "false"){ ?>
					<div class="reg-login-title px-3 text-center mb-3">
					<a href="<?php echo home_url(); ?>"><img class="m-auto" src="<?php echo pzfm_dashboard_logo(); ?>" alt="site-logo" /></a>
					</div>
					<?php do_action( 'pzfm_after_login_title' ); ?>
					<?php } ?>
					<?php if( isset( $_GET['lostpassword'])) : ?>
						<?php include_once( pzfm_include_template('lostpassword.tpl') ); ?>
					<?php else: ?>
						<?php include_once( pzfm_include_template('login-form.tpl') ); ?>
						<?php if( pzfm_registration() ): ?>
							<div class="register-wrapper col-md-12 text-center mt-4"><?php esc_html_e('Not Registered yet? ',  'pz-frontend-manager') ?><a href="<?php echo pzfm_register_url(); ?>" class="loginpage-register-link"><?php esc_html_e('Create an Account',  'pz-frontend-manager') ?></a>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(empty($form) || $form == "false"){ ?>
						<?php do_action( 'pzfm_after_login_content' ); ?>
					<?php } ?>
				</div>
			</div>
		</section>
	</div>
</div>
<style>
#login-section{
	padding: 6em 1em !important;
}
#pzfm-popup {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

/* Modal Content/Box */
#pzfm-popup-wrap {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
}
</style>
<script>
	// When the user clicks on the button, open the modal
	jQuery('#pzfm-login-open').click(function(){
		$("#pzfm-popup").css({"display":"block"});
	});
	// When the user clicks anywhere outside of the modal, close it
	jQuery(window).click(function(event){
		if (event.target.id == jQuery("#pzfm-popup").attr("id")) {
			jQuery("#pzfm-popup").css({"display":"none"});
		}
	});
</script>