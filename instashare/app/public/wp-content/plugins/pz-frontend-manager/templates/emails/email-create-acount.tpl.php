<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body style="width:100% margin: 0; padding: 0;">
        <div style="background-color: #f2f2f2; padding: 50px 20px;">
            <div style="background-color: #ffffff; width: 900px; margin: 0 auto;">
                <div style="text-align: center; font-size: 18px;padding: 0 20px;color: #000000 !important;">
                    <div style="padding: 20px 0; border-bottom:1px solid #afafaf;">
                    	<a href="<?php echo home_url(); ?>">
                            <img class="alignnone wp-image-4286" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo bloginfo('name'); ?>" title="<?php echo bloginfo('name'); ?>" width="300" height="auto" />
                        </a>
                        <div style="margin: 20px 70px 0;">
                        	<p style="margin-top: 30px !important;">
                            <?php if( !empty( pzfm_email_menu() ) ){
                                foreach( pzfm_email_menu() as $menu_key => $menu_data ){ ?>
                                    <a href="<?php echo esc_url( $menu_data['permalink'] ); ?>" style="text-decoration:none; color:#000000;font-size: 20px;font-weight: bold;padding: 0 10px;">
                                        <?php echo esc_html( $menu_data['label'] ); ?>
                                    </a> 
                                <?php }
                            } ?>
                        	</p>
                    	</div>
                    </div>
                    <div style="padding: 50px 20px;">
                        <p style="font-size:25px; text-align:center;margin: 0; color: #000 !important;"><strong><?php echo esc_html__( 'Your account has been created!', 'pz-frontend-manager' );?></strong></p>
                        </br>
                        <p style="font-size:20px; text-align:left;margin-bottom: 0; color: #000 !important;"><?php echo esc_html__( 'We have created an account for you', 'pz-frontend-manager' );?></p>
                        <p style="font-size:20px; text-align:left;margin-bottom: 0; color: #000 !important;"><?php echo esc_html__( 'Please refer to the below details:', 'pz-frontend-manager' );?></p>
                        <p style="font-size:18px; text-align:left;margin: 0; color: #000 !important;"><strong><?php echo esc_html__( 'Your username:', 'pz-frontend-manager' );?></strong> <?php echo esc_html( $from_email ); ?></p>
                        <p style="font-size:18px; text-align:left;margin: 0; color: #000 !important;"><strong><?php echo esc_html__( 'Your Temporary password:', 'pz-frontend-manager' );?></strong> <?php echo esc_html( $password ); ?> <strong><?php echo esc_html__( '- You can change it later on', 'pz-frontend-manager' );?></strong></p>
                        <p style="font-size:18px; text-align:left;margin-bottom: 0; color: #000 !important;"><?php echo esc_html__( 'You can log-in to your account', 'pz-frontend-manager' );?> <a href="<?php echo home_url('/dashboard'); ?>" style="color: #15c !important; text-decoration: none;"><?php echo esc_html__( 'HERE', 'pz-frontend-manager' );?></a></p>
                        </br>
                    </div>
                    <div style="margin: 50px 20px 0; padding-bottom: 40px;">
                        <div id="social-media">
        					<p style="text-align: center;">
        						<a href="https://web.facebook.com/projectzealous" style="text-decoration: none !important;">
        							<img src="<?php echo esc_url( PZ_FRONTEND_MANAGER_URL .'assets/images/email-icons/facebook.png' ); ?>" alt="Project Zealous Web Development and Services" style="" />
        						</a>
        						<a href="https://www.instagram.com/project.zealous/" style="text-decoration: none !important;">
        							<img src="<?php echo esc_url( PZ_FRONTEND_MANAGER_URL .'assets/images/email-icons/instagram.png' ); ?>" alt="Project Zealous Web Development and Services" />
        						</a>
        					</p>
        				</div>
                        <p style="margin: 0; text-align: center; color: #000 !important;"><?php echo esc_html__( 'Copyright ©', 'pz-frontend-manager' ); ?> <?php echo date("Y"); ?> <?php echo bloginfo('name'); ?><?php echo esc_html__( ', All rights reserved.', 'pz-frontend-manager' ); ?></p>
                        <p style="margin: 0; text-align: center; color: #000 !important;"><?php echo esc_html__( 'You are receiving this email at', 'pz-frontend-manager' ); ?> <?php echo esc_html( $from_email ); ?> <?php echo esc_html__( 'because you signed up for', 'pz-frontend-manager' );?> <?php echo bloginfo('name'); ?>.</p> 
                        <p style="margin: 0; text-align: center;">
                            <a href="<?php echo home_url('/privacy-policy/'); ?>" style="color: #000000 !important; text-decoration: none;"><?php echo esc_html__( 'Privacy Policy', 'pz-frontend-manager' ); ?></a> | <a href="<?php echo home_url('/terms-of-use/'); ?>" style="color: #000000 !important; text-decoration: none;"><?php echo esc_html__( 'Terms of Use', 'pz-frontend-manager' );?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>