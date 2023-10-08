<?php
/**
 * Plugin Name: PZ Frontend Manager
 * Plugin URI: https://proj-z.com/
 * Description: PZ Frontend Manager allows your clients to manage their platform without accessing the wp-admin dashboard! In this way, your client will not be confused by all the unnecessary menus and access they will see in the wp-admin dashboard. This will also prevent any undesirable actions that may cause the website to crash.
 * Version: 1.0.5
 * Author: <a href="https://proj-z.com/">Project Zealous</a>
 * Requires at least: 6.1
 * Tested up to: 6.2.2
 * Text Domain: pz-frontend-manager
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages/
 */

 /*
PZ Frontend Manager is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
PZ Frontend Manager is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with PZ Frontend Manager. If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Defined constant
define( 'PZ_FRONTEND_MANAGER_NAME', 'PZ Frontend Manager' );
define( 'PZ_FRONTEND_MANAGER_URL', plugin_dir_url( __FILE__ ) );
define( 'PZ_FRONTEND_MANAGER_PATH', plugin_dir_path( __FILE__ ) );
define( 'PZ_FRONTEND_MANAGER_TEXTDOMAIN', 'pz-frontend-manager' );
define( 'PZ_FRONTEND_MANAGER_VERSION', '1.0.4' );
define( 'PZ_FRONTEND_MANAGER_DB_VERSION', '1.0.0' );
define( 'PZ_FRONTEND_MANAGER_HOME_URL', home_url() );
define( 'PZ_FRONTEND_MANAGER_BASENAME', plugin_basename( __FILE__ ) );
define( 'PZ_FRONTEND_MANAGER_TEMPLATE_PATH', PZ_FRONTEND_MANAGER_PATH . 'templates/' );
define( 'PZ_FRONTEND_MANAGER_ASSETS_PATH', PZ_FRONTEND_MANAGER_URL . 'assets/' );

require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/includes/translations.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/includes/functions.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/includes/function-country-list.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/includes/hooks.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/includes/activation-hooks.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/includes/ajax-hooks.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/classes/class-menus.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/classes/class-core.php' );
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/classes/class-scripts.php' );

// Load textdomain translation
add_action( 'plugins_loaded', 'pzfm_load_textdomain' );
function pzfm_load_textdomain() {
	load_plugin_textdomain( 'pz-frontend-manager', false, '/pz-frontend-manager/languages' );
}

register_activation_hook( __FILE__, 'pzfm_plugin_page_creation' );