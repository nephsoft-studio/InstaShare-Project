<?php
/**
 * @package Instashare
 */
?>
<?php
/* Notifications in customizer */


require get_template_directory() . '/inc/customizer-notify/instashare-customizer-notify.php';
$instashare_config_customizer = array(
	'recommended_plugins'       => array(
		'neph-soft' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>Nephsoft</strong> plugin for taking full advantage of all the features this theme has to offer.', 'instashare')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'instashare' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'instashare' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'instashare' ),
	'activate_button_label'     => esc_html__( 'Activate', 'instashare' ),
	'instashare_deactivate_button_label'   => esc_html__( 'Deactivate', 'instashare' ),
);
Instashare_Customizer_Notify::init( apply_filters( 'instashare_customizer_notify_array', $instashare_config_customizer ) );
?>