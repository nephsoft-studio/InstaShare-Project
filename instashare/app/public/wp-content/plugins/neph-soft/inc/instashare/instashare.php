<?php
/**
 * @package   Instashare
 */

require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/extras.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/dynamic-style.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/sections/above-footer.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/features/instashare-footer.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/features/instashare-slider.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/features/instashare-info.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/features/instashare-service.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/features/instashare-cta.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/features/instashare-typography.php';
// Instashare - Pro
require NEPHSOFT_PLUGIN_DIR . 'inc/neph-soft-header/features/instashare-header.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/neph-soft-header/sections/above-header.php';
// Instashare - Normal
/**
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/features/instashare-header.php';
require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/sections/above-header.php';
*/
if ( ! function_exists( 'nephsoft_instashare_frontpage_sections' ) ) :
	function nephsoft_instashare_frontpage_sections() {	
		require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/sections/section-slider.php';
		require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/sections/section-info.php';
		require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/sections/section-service.php';
		require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/sections/section-cta.php';
    }
	add_action( 'instashare_sections', 'nephsoft_instashare_frontpage_sections' );
endif;


function nephsoft_instashare_enqueue_scripts() {
	wp_enqueue_style('animate',NEPHSOFT_PLUGIN_URL .'/inc/assets/css/animate.css');
}
add_action( 'wp_enqueue_scripts', 'nephsoft_instashare_enqueue_scripts' );