<form  method="POST" class="pzfm-form-wrap">
    <?php wp_nonce_field('lost_password_actions', 'lost_password_field'); ?>
    <?php if( !pzfm_parameters( 'key' ) ) : ?>
        <h4 class="text-pzfm text-center"><?php esc_html_e( 'Lost your password?', 'pz-frontend-manager' ); ?></h4>
        <p class="text-center"><?php esc_html_e( 'Enter your email address and check your email for the new password link.', 'pz-frontend-manager' ); ?></p>
    <?php else : ?>
        <p class="text-center"><?php esc_html_e( 'Enter your new password', 'pz-frontend-manager' ); ?></p>
    <?php endif; ?>
    <div class="login-inputs-wrapper">
        <?php if(!pzfm_parameters('key')) : ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                <input id="login-username" name="lost_password_email" type="email" class="form-control login-inputs" value="<?php echo (!empty($_POST['lost_password_email'])) ? esc_attr( $_POST['lost_password_email'] ) : ''; ?>" required placeholder="<?php esc_html_e('Email Address','pz-frontend-manager') ?>">
            </div>
        <?php else : ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                <input id="login_password" name="user-password" type="password" class="form-control login-inputs" required placeholder="<?php esc_html_e('New Password','pz-frontend-manager') ?>">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                <input id="login_password" name="confirm-password" type="password" class="form-control login-inputs" required placeholder="<?php esc_html_e('Confirm Password','pz-frontend-manager') ?>">
            </div>
        <?php endif; ?>
        <div class="col-xl-12 text-center my-4">
            <input type="submit" id="" class="btn btn-pzfm" value="<?php esc_html_e( 'Reset Password', 'pz-frontend-manager' ); ?>">
            <p class="mt-4"><a href="<?php echo get_the_permalink( pzfm_dashboard_page() ); ?>"><?php esc_html_e('Go back to login page','pz-frontend-manager') ?></a></p>
        </div>
        <?php if(!empty($_POST['pzfm-password-reset'])) : ?>
            <div class="col-xl-12 text-center my-4">
                <div class="alert alert-success" role="alert">
                    <?php esc_html_e( 'You have successfully update your password. ', 'pz-frontend-manager' ); ?><a href="<?php echo get_the_permalink( pzfm_dashboard_page() ); ?>" class="alert-link"><?php esc_html_e('Login Here','pz-frontend-manager') ?></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</form>