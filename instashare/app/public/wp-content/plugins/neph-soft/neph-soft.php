<?php
/*
Plugin Name: Neph Soft
Description: Neph Soft plugin to enhance the functionality of free themes made by Neph·Soft·Studio´s. It provides intuitive features to your website. 
Version: 1.0
Author: Neph·Soft·Studio´s
Author URI: https://www.instagram.com/nephsoftstudios/
Text Domain: neph-soft
Requires PHP: 5.6
*/
define( 'NEPHSOFT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'NEPHSOFT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'NEPHSOFT_FOOTER_ABOUT', 'There are many variations of dummy passages of Lorem Ipsum a available, but the majority have suffered that is alteration in some that form  injected humour or randomised.' );

function nephsoft_activate() {
	
	/**
	 * Load Custom control in Customizer
	 */

	define( 'NEPHSOFT_DIRECTORY', plugin_dir_url( __FILE__ ) . '/inc/custom-controls/' );
	define( 'NEPHSOFT_DIRECTORY_URI', plugin_dir_url( __FILE__ ) . '/inc/custom-controls/' );
	if ( class_exists( 'WP_Customize_Control' ) ) {
		require_once('inc/custom-controls/controls/range-validator/range-control.php');	
	}
	
	$theme = wp_get_theme(); // gets the current theme
		if( 'Instashare' == $theme->name){
			require_once('inc/instashare/instashare.php');
			}
	}

add_action( 'init', 'nephsoft_activate' );

$theme = wp_get_theme();

/**
 * Instashare Block
 */

if( 'Instashare' == $theme->name){
	require NEPHSOFT_PLUGIN_DIR . '/inc/instashare/block/info-box.php'; 
}

/**
 * Renoval Block
 */

if( 'Renoval' == $theme->name ){
	require NEPHSOFT_PLUGIN_DIR . '/inc/renoval/block/info-box.php'; 
}

	if ( ! class_exists( 'Neph_Soft_Setup' ) ) {

	/**
	 * Customizer Loader
	 *
	 * @since 1.0.0
	 */

	class Neph_Soft_Setup {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */

		private static $instance;

		/**
		 * Initiator
		 */

		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */

		public function __construct() {
			add_action( 'admin_menu', array($this, 'neph_soft_setup_menu') );
			add_action( 'wp_ajax_neph-soft-activate-theme', array( $this, 'activate_theme' ),2 );
			// add_action( 'wp_ajax_neph-soft-activate-theme', array( $this, 'activate_theme' ),1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'neph_soft_enqueue_scripts' ) );
		}
		
		
		public function neph_soft_enqueue_scripts() {
			wp_enqueue_style('neph-soft-admin',NEPHSOFT_PLUGIN_URL .'inc/assets/css/admin.css');
			wp_enqueue_script( 'jquery-ui-core' );
					wp_enqueue_script( 'jquery-ui-dialog' );
					wp_enqueue_style( 'wp-jquery-ui-dialog' );	
					
					wp_enqueue_script( 'neph-soft-install-theme', NEPHSOFT_PLUGIN_URL . 'inc/assets/js/install-theme.js', array( 'jquery' ) );
					
					wp_enqueue_script( 'neph-soft-filter-tabs', NEPHSOFT_PLUGIN_URL . 'inc/assets/js/filter-tabs.js', array( 'jquery' ) );
					
					$data = apply_filters(
						'neph_soft_install_theme_localize_vars',
						array(
							'installed'  => __( 'Installed! Activating..', 'neph-soft' ),
							'activating' => __( 'Activating..', 'neph-soft' ),
							'activated'  => __( 'Activated! Reloading..', 'neph-soft' ),
							'installing' => __( 'Installing..', 'neph-soft' ),
							'ajaxurl'    => esc_url( admin_url( 'admin-ajax.php' ) ),
							'security' => wp_create_nonce( 'my-special-string' )
						)
					);
					wp_localize_script( 'neph-soft-install-theme', 'NephSoftInstallThemeVars', $data );
		}

		public function neph_soft_setup_menu() {
			add_menu_page( 'Neph Soft', 'Neph Soft', 'manage_options', 'neph-soft', array($this, 'neph_soft_page_init')  );
		}


		function neph_soft_page_init(){
	echo "<h2 class='neph-heading'>Neph·Soft·Studio´s Themes Compatible Themes</h2>";
	?>
	
	<div class="filter-buttons">
		<button class="filter-button button-primary" data-category="all"><?php esc_html_e('All','neph-soft'); ?></button>
		<button class="filter-button button-primary" data-category="Business"><?php esc_html_e('Business','neph-soft'); ?></button>
		<button class="filter-button button-primary" data-category="Agency"><?php esc_html_e('Agency','neph-soft'); ?></button>
		<button class="filter-button button-primary" data-category="Corporate"><?php esc_html_e('Corporate','neph-soft'); ?></button>
		<button class="filter-button button-primary" data-category="Multipurpose"><?php esc_html_e('Multipurpose','neph-soft'); ?></button>
		<button class="filter-button button-primary" data-category="IT-Software"><?php esc_html_e('IT & Software','neph-soft'); ?></button>
		<button class="filter-button button-primary" data-category="Education"><?php esc_html_e('Education','neph-soft'); ?></button>	
		<button class="filter-button button-primary" data-category="Hotel-Resorts"><?php esc_html_e('Hotel & Resorts','neph-soft'); ?></button>	
		<button class="filter-button button-primary" data-category="News-Blog"><?php esc_html_e('News & Blog','neph-soft'); ?></button>	
		<button class="filter-button button-primary" data-category="Spa-Saloon"><?php esc_html_e('Spa Saloon','neph-soft'); ?></button>	
		<button class="filter-button button-primary" data-category="Events"><?php esc_html_e('Events','neph-soft'); ?></button>	
	</div>
	
	<?php
	
		$api_url = 'https://github.com/nephsoft-studio/nephSoft-Plugin.git';

		// Read JSON file
		$json_data = file_get_contents($api_url);

		// Decode JSON data into PHP array
		$response_data = json_decode($json_data);

	
		// All user data exists in 'data' object
		$theme_data = $response_data->themes;

		// Traverse array and display user data
		
		?>
		
		<div class="specia-sites-panel wp-clearfix">
			<div class="specia-sites-wrapper" id="wrap-disk">
				<?php foreach ($theme_data as $themes) { 
				
				$theme = wp_get_theme();
				
				$get_theme_staus='';
				// Theme installed and activate.
				if ( $themes->name == $theme->name ) {
					$get_theme_staus= 'installed-and-active';
					$specia_btn_value= 'Activated';
				}else{

					// Theme installed but not activate.
					foreach ( (array) wp_get_themes() as $theme_dir => $themesss ) {
						if ( $themes->name == $themesss->name ) {
							$get_theme_staus= 'installed-but-inactive';
							$specia_btn_value= 'Activate Now';
						}
						 //$get_theme_staus= 'not-installed';
					}
				}
				
				?>
				
				
					<?php 
						if ( ($themes->name) == "Instashare" ):
						$theme_category ="Corporate";

						else :
							$theme_category ="Business";
						endif;
					?>
					<div id="specia-theme-activation-xl" data-category="<?php echo esc_html($theme_category); ?>" class="neph-soft-sites-items <?php echo esc_html($themes->name); ?>">
						<div class="neph-soft-items-inner">
							<div class="specia-demo-screenshot">
								<div class="specia-demo-image" style="background-image: url(<?php echo esc_url($themes->screenshot_url); ?>);"></div>
									<div class="specia-demo-actions">
										<a class="neph-soft-btn neph-soft-btn-outline" href="https://github.com/nephsoft-studio/nephSoft-Plugin.git<?php echo esc_html($themes->slug); ?>" target="_blank"><?php esc_html_e('Preview','neph-soft'); ?></a>
										<?php 
										if($get_theme_staus !== 'installed-and-active' && $get_theme_staus !== 'installed-but-inactive'):
											$get_theme_staus= 'not-installed';
											$specia_btn_value= 'Install & Activate Now';
										endif;
										$theme_status = 'neph-soft-theme-' . $get_theme_staus;
										echo sprintf( __( '<a href="#" class="%3$s xl-btn-active neph-soft-btn-outline xl-install-action neph-soft-btn" data-theme-slug="%1$s">%4$s</a>', 'neph-soft' ), esc_html($themes->name),esc_url( admin_url( 'themes.php?theme=%1$s' ) ), $theme_status, $specia_btn_value );
										//switch_theme( $themes->name );
										?>
									</div>
								</div>
								<div class="sp-demo-meta  sp-demo-meta--with-preview">
									<div class="sp-demo-name"><h4 title="Neph·Soft·Studio´s Themes"><a href="<?php echo esc_url(admin_url('theme-install.php?search='.$themes->name)); ?>"><?php echo esc_html($themes->name); ?></a></h4></div>	
									<a class="neph-soft-btn neph-soft-btn-outline" href="https://www.instagram.com/nephsoftstudios/<?php echo esc_html($themes->slug); ?>-pro/" target="_blank"><?php esc_html_e('Buy Now','neph-soft'); ?></a>	
								</div>
								<?php //echo $get_theme_staus; ?>
						</div>
					</div>
				<?php } ?>									
				</div>
			</div>
		
		<?php
}


		/**
		 * Activate theme
		 *
		 * @since 1.0
		 * @return void
		 */

		function activate_theme() { 
			 $specia_current_theme =  strtolower($_POST['specia_current_theme']);
			switch_theme(  $specia_current_theme );
			wp_send_json_success(
				array(
					'success' => true,
					'message' => __( 'Theme Successfully Activated', 'neph-soft' ),
				)
			);
			wp_die(); 
		}
		
	}
}// End if().

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Neph_Soft_Setup::get_instance();


/**
 * The code during plugin activation.
 */

function activate_nephsoft() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/nephsoft-activator.php';
	Nephsoft_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_nephsoft' );