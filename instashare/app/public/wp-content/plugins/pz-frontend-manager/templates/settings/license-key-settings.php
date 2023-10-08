<?php 
  if ( ! function_exists( 'get_plugins' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
  }
?>
<div class="mb-4 col-md-12">
    <section class="row">
        <?php if(pzfm_plugin_license_key()) : ?>
            <div class="mb-4 col-md-6">
                <div class="card shadow">
                    <div class="card-header pzfm-header">
                        <?php esc_html_e( 'License Key', 'pz-frontend-manager' ); ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <?php do_action( 'pzfm_plugin_license_key' ); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="mb-4 col-md-6">
            <div class="card shadow">
                <div class="card-header pzfm-header">
                    <?php esc_html_e( 'Disable Plugins in Dashboard', 'pz-frontend-manager' ); ?>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <label class="text-dark"><?php esc_html_e( 'Active Plugins', 'pz-frontend-manager' ); ?></label>
                            <?php if(pzfm_get_all_plugins()) : ?>
                                <?php foreach(pzfm_get_all_plugins() as $key => $value) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pzfm_deactivate_plugins[]" value="<?php echo $value; ?>" id="<?php echo $value; ?>">
                                        <label class="form-check-label" for="<?php echo $value; ?>">
                                            <?php echo get_plugins()[$value]['Name']; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-xl-6">
                            <label class="text-dark"><?php esc_html_e( 'Disabled Plugins', 'pz-frontend-manager' ); ?></label>
                            <?php if(get_option('pzfm_deactivate_plugins')) : ?>
                                <div class="p-3 bg-secondary text-white">
                                    <?php foreach(get_option('pzfm_deactivate_plugins') as $key => $value) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pzfm_disabled_plugins[]" value="<?php echo $value; ?>" id="<?php echo $value; ?>">
                                            <label class="form-check-label" for="<?php echo $value; ?>">
                                                <?php echo get_plugins()[$value]['Name']; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="field-descrip mt-2"><i><?php esc_html_e( 'This is to avoid conflicts when accessing the dashboard', 'pz-frontend-manager' ); ?></i></p>
                </div>
            </div>
        </div>
    </section>
</div>