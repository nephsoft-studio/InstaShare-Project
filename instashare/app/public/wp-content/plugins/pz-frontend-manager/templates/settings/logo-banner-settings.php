<div class="mb-4 col-md-12">
    <div class="card shadow h-100">
        <div class="card-header pzfm-header">
            <?php esc_html_e( 'Logo / Banner', 'pz-frontend-manager' ); ?>
        </div>
        <div class="card-body">
            <div class="row">
                <section class="col-md-6">
                    <div id="pz-logo-main-wrapper">
                        <p class="strong"><?php esc_html_e( 'Upload site logo', 'pz-frontend-manager' ); ?></p>
                        <div class="upload-logo-wrapper">
                            <img class="pz-image-placeholder thumbnail upload-image img-thumbnail" src="<?php echo pzfm_dashboard_logo(); ?>" alt="img" data-upload="logo_image"><br>
                            <input type="hidden" name="pzfm_site_logo" value="<?php echo pzfm_dashboard_logo(); ?>" class="upload-logo-holder">
                            <p class="field-descrip mt-2"><i><?php esc_html_e('Note: Click the logo to change', 'pz-frontend-manager'); ?></i></p>
                        </div>
                    </div>
                    <div class="color-setting-wrapper mb-3">
                        <label for="pzfm-base-color" class="strong"><?php esc_html_e( 'Base Color', 'pz-frontend-manager' ); ?></label>
                        <input type="text" class="color-field form-control form-control-sm" id="color-picker" name="pzfm_base_color" value="<?php echo pzfm_base_color(); ?>" placeholder="#06aff2"/>
                    </div>
                </section>
                <!-- BACKGOUND BANNER IMAGE -->
                <section class="col-md-6">
                    <label class="strong"><?php esc_html_e( 'Upload login background image', 'pz-frontend-manager' ); ?></label>
                    <div class="upload-background-wrapper">
                        <img class="pz-image-placeholder  thumbnail upload-image" src="<?php echo pzfm_login_dashboard_background(); ?>" alt="img" data-upload="background_image" width="100%">
                        <input type="hidden" name="pzfm_login_background" value="<?php echo pzfm_login_dashboard_background(); ?>" class="upload-background-holder">
                        <p class="field-descrip mt-2"><i><?php esc_html_e('Click the image to edit or update', 'pz-frontend-manager'); ?></i></p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>