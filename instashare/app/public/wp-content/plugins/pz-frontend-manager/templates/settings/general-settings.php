<form id="pzfm-settings-form" class="mw-100" method="POST" enctype="multipart/form-data">
  <?php wp_nonce_field( 'pzfm_settings_add_action', 'pzfm_settings_form_fields' ); ?>
    <?php do_action( 'pzfm_before_general_settings' ); ?>
    <?php require_once( PZ_FRONTEND_MANAGER_TEMPLATE_PATH . 'settings/license-key-settings.php' ); ?>
    <?php require_once( PZ_FRONTEND_MANAGER_TEMPLATE_PATH . 'settings/logo-banner-settings.php' ); ?>
    <?php require_once( PZ_FRONTEND_MANAGER_TEMPLATE_PATH . 'settings/registration-settings.php' ); ?>
    <?php require_once( PZ_FRONTEND_MANAGER_TEMPLATE_PATH . 'settings/capability-settings.php' ); ?>
    <?php do_action( 'pzfm_after_general_settings' ); ?>
    <div class="col-lg-12">
      <button type="submit" class="btn btn-sm btn-pzfm pzfm-show-popup-loader">
        <?php esc_html_e( 'Save settings', 'pz-frontend-manager' ); ?>
      </button>
      <input type="hidden" name="tab-page" class="tab-page" value="">
      <div class="clearfix"></div>
    </div>
  </div>
</form>