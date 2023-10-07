<?php

/**
 * Fired during plugin activation
 *
 * @package    Neph-soft
 */

/**
 * This class defines all code necessary to run during the plugin's activation.
 *
 */

class Nephsoft_Activator {

	public static function activate() {

        $item_details_page = get_option('item_details_page'); 
		$theme = wp_get_theme(); // gets the current theme
		if(!$item_details_page){
			if ( 'Instashare' == $theme->name  ){
				require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/default-pages/upload-media.php';
				require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/default-pages/home-page.php';
				require NEPHSOFT_PLUGIN_DIR . 'inc/instashare/default-widgets/default-widget.php';
			}
			
			update_option( 'item_details_page', 'Done' );
		}
	}

}