<?php
/**
 * @package Instashare
 */
?>
<?php
class instashare_import_dummy_data {

	private static $instance;

	public static function init( ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof instashare_import_dummy_data ) ) {
			self::$instance = new instashare_import_dummy_data;
			self::$instance->instashare_setup_actions();
		}

	}

	/**
	 * Setup the class props based on the config array.
	 */
	

	/**
	 * Setup the actions used for this class.
	 */
	public function instashare_setup_actions() {

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'instashare_import_customize_scripts' ), 0 );

	}
	
	

	public function instashare_import_customize_scripts() {

	wp_enqueue_script( 'instashare-import-customizer-js', get_template_directory_uri() . '/assets/js/instashare-import-customizer.js', array( 'customize-controls' ) );
	}
}

$instashare_import_customizers = array(

		'import_data' => array(
			'recommended' => true,
			
		),
);
instashare_import_dummy_data::init( apply_filters( 'instashare_import_customizer', $instashare_import_customizers ) );