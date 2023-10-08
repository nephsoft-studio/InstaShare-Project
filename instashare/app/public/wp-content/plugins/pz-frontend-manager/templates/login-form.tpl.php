<form id="loginform" method="post">
    <?php wp_nonce_field( 'pzfm_login_action', 'pzfm_login_fields' ); ?>
    <div class="login-inputs-wrapper">
        <div class="input-group mb-3">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
            <input id="login-username" name="user-login" type="text" class="form-control login-inputs" value="<?php echo (!empty($_POST['user-login'])) ? esc_attr( $_POST['user-login'] ) : ''; ?>" required placeholder="<?php esc_html_e('Username / Email Address', 'pz-frontend-manager') ?>">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
            <input id="login_password" name="user-password" type="password" class="form-control login-inputs" required placeholder="<?php esc_html_e('Password', 'pz-frontend-manager') ?>">
        </div>
        <div class="col-md-12 flex-row d-flex p-0">
            <div class="form-check align-items-center col-6">
                <input name="rememberme" type="checkbox" id="rememberme" class="form-check-input mt-2" value="forever">
                <label class="form-check-label pzfm-label align-middle" for="rememberme"><?php esc_html_e( 'Remember me',  'pz-frontend-manager' ); ?></label>
            </div>
            <div class="col-6 text-right">
                <a class="pzfm-label" href="<?php echo pzfm_lost_password_url(); ?>"><?php esc_html_e( 'Forgot password?',  'pz-frontend-manager' ); ?></a>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-3 mb-1 pzfm-action-wrap text-center">
        <button type="submit" id="" class="btn login-btn py-2"><?php esc_html_e('Login',  'pz-frontend-manager') ?></button>
        <?php echo pzfm_loader(); ?>
    </div>
</form>