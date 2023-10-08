<?php $tab = isset($_GET['tab']) && !empty( trim($_GET['tab']) ) ? sanitize_text_field($_GET['tab']) : 'general-settings' ; ?>
<div class="bg-white pb-4">
	<div class="pzfm-settings-nav mb-4">
		<ul class="nav nav-tabs">
			<?php if( in_array( 'administrator', pzfm_current_user_role() ) ) : ?>
				<li class="nav-item" data-tab="general-settings">
					<a class="nav-link <?php echo $tab == 'general-settings' ? 'active' : ''; ?>" data-bs-toggle="tab" href="#general-settings"><?php esc_html_e( 'General Settings', 'pz-frontend-manager' ); ?></a>
				</li>
			<?php endif;?>
			<?php if( !empty( pzfm_settings_template() ) ): ?>
				<?php foreach( pzfm_settings_template() as $setting_data ): ?>
					<li class="nav-item" data-tab="<?php echo esc_attr( $setting_data['meta-key'] ); ?>-settings">
						<a class="nav-link <?php echo (!empty($setting_data['active'])) ? 'active' : '';?> <?php echo ($tab == $setting_data['meta-key'].'-settings') ? 'active' : '';?>" data-bs-toggle="tab" href="#<?php echo esc_attr( $setting_data['meta-key'] ); ?>-settings"><?php echo esc_html( $setting_data['label'] ); ?></a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
	<div class="tab-content">
		<?php if( in_array( 'administrator', pzfm_current_user_role() )  ) : ?>
      <?php if( !empty( pzfm_settings_template() ) ): ?>
        <?php foreach( pzfm_settings_template() as $setting_data ): ?>
          <div role="tabpanel" class="tab-pane fade <?php echo (!empty($setting_data['active'])) ? 'active show' : '';?> <?php echo ($tab == $setting_data['meta-key'].'-settings') ? 'active show' : '';?>" id="<?php echo esc_attr( $setting_data['meta-key'] ); ?>-settings" data-tab-content="<?php echo esc_attr( $setting_data['meta-key'] ); ?>-settings">
            <?php require_once( $setting_data['template'] ); ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
        <div role="tabpanel" class="tab-pane fade <?php echo pzfm_tab('general-settings', $tab, 'tab_content' ); ?>" id="general-settings" data-tab-content="general-settings">	
          <?php require_once( PZ_FRONTEND_MANAGER_TEMPLATE_PATH . 'settings/general-settings.php' ); ?>
        </div>
		<?php endif; ?>
	</div>
</div>