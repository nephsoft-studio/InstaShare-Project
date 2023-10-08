<?php
    $socials_list = get_user_meta( 1, 'pzfm_social_media', true );
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
          @import url('https://fonts.googleapis.com/css2?family=Urbanist&display=swap');
        </style>
    </head>
    <body style="font-family: 'Urbanist', sans-serif; font-size: 16px; line-height: 1.5; background: #CDEFFC; padding: 40px;">
        <div class="mail-container" style="max-width: 1000px; width: 80%; margin: 0 auto; padding: 30px 20px; border-radius: 50px; background: #fff;">
            <div class="main-content row" style="width: 100%; display: flex; flex-wrap: wrap; margin-bottom: 50px;">
                <div class="col col-1" style="flex: 0 0 50%; max-width: 50%;">
                    <div class="col-wrap" style="padding: 0px 60px; border-right: 1px solid;">
                        <div class="logo">
                            <img src="<?php echo esc_url( $logo ); ?>" alt="PZ FM logo" style="max-height: 150px;">
                        </div>
                        <div class="intro" style="margin-bottom: 0px">
                          <?php if( !empty( get_option('pzfm-activation-email-content') ) ): ?>
                            <?php echo get_option('pzfm-activation-email-content'); ?>
                          <?php else: ?>
                            <h3 style="font-size: 35px; line-height: 1; margin-bottom: 0px; margin-top: 0px; font-weight: 400;"><?php echo esc_html__( 'You\'re almost there!', 'pz-frontend-manager' );?></h3>
                            <p>
                                <?php echo esc_html__( 'Activate your account by clicking on the “Activate Account” button. You will then be redirected to the login page.', 'pz-frontend-manager' );?>
                            </p>
                          <?php endif;?>
                        </div>
                        <div class="login-credentials" style="margin-bottom: 30px">
                            <p><?php echo esc_html__( 'Your Login Details', 'pz-frontend-manager' );?></p>
                            <p class="login-email" style="margin-left: 30px; margin-bottom: 0px;"><?php echo esc_html__( 'Email: ', 'pz-frontend-manager' );?><span style="color: #05aff2; text-decoration: none;"><?php echo esc_html( $user_data->user_email ); ?></span></p>
                            <p class="login-password" style="margin-left: 30px; margin-top: 0px;"><?php echo esc_html__( 'Password: ', 'pz-frontend-manager' );?><span style="color: #05aff2;"><?php echo esc_html( $password ); ?></span></p>
                        </div>
                        <div class="click-to-activate">
                            <p style="margin-bottom: 25px;"><?php echo esc_html__( 'Click the button below to activate your account:', 'pz-frontend-manager' );?></p>
                            <a class="btn" style="background: #05AFF2; border: 1px solid #05AFF2; border-radius: 50px; color: #fff; padding: 10px 25px; font-size: 16px; text-decoration: none" href="<?php echo esc_html( $activation_url ); ?>"><?php echo esc_html__( 'ACTIVATE ACCOUNT', 'pz-frontend-manager' );?></a>
                        </div>
                    </div>
                </div>
                <div class="col col-2" style="flex: 0 0 50%; max-width: 50%;">
                    <div class="col-wrap" style="padding: 0px 60px; text-align: center; margin-top: 30px;">
                        <img class="account-avatar" style="margin-bottom: 30px; width: 80%;" src="<?php echo PZ_FRONTEND_MANAGER_ASSETS_PATH . 'images/email-avatar.png'; ?>" alt="Account Avatar">
                        <img class="account-line-divider" style="margin-bottom: 40px; width: 100%;" src="<?php echo PZ_FRONTEND_MANAGER_ASSETS_PATH . 'images/email-avatar-line.png'; ?>" alt="">
                        <div class="social-icons">
                            <?php if($socials_list) : ?>
                                <?php foreach($socials_list as $key => $value) : ?>
                                    <img style="width: 40; height: 40px;" src="<?php echo ($value['[pzfm-soc-icon]']) ? wp_get_attachment_url( $value['[pzfm-soc-icon]'] ) : PZ_FRONTEND_MANAGER_ASSETS_PATH . 'images/icons/upload.png'; ?>" />
                                <?php endforeach; ?>
                            <?php endif;?>
                        </div>
                        <div class="quick-links" style="margin-bottom: 20px;">
                            <a href="" style="color: #05aff2; text-decoration: none;"><?php echo esc_html__( 'Policy', 'pz-frontend-manager' );?></a> | 
                            <a href="" style="color: #05aff2; text-decoration: none;"><?php echo esc_html__( 'Help', 'pz-frontend-manager' );?></a> | 
                            <a href="" style="color: #05aff2; text-decoration: none;"><?php echo esc_html__( 'About Us', 'pz-frontend-manager' );?></a>
                        </div>
                        <div class="address">
                            <p style="text-align: center; font-size: 16px;"><?php echo pzfm_default_address(); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer" style="width: 100%; text-align: center;">
                <p style="font-size: 12px;"><?php echo esc_html__( 'You receive these emails because you signed up to ', 'pz-frontend-manager' );?> <span style="color: #05aff2;"><?php apply_filters('pzfm_company_name_information_email' , bloginfo('name') );?></span></p>
            </div>
        </div>
    </body>
</html>