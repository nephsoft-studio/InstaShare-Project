<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'PZ_FRONTEND_MANAGER_SCRIPTS' ) ){
	class PZ_FRONTEND_MANAGER_SCRIPTS {
		function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'pzfm_styles_scripts'));
			add_action( 'admin_enqueue_scripts', array( $this, 'pzfm_styles_scripts'));
			add_action( 'wp_footer', array( $this, 'pzfm_autocomplete_script' ) );
			add_action( 'wp_print_styles', array( $this, 'dequeue_scripts' ), 10 );
		}
        function dequeue_scripts(){
            global $post, $wp_scripts, $wp_styles;
		
            if( !empty( $post ) ){
                $template = get_page_template_slug( $post->ID );
                if( $template == 'dashboard.php' || $template == 'thank-you.php' || $post->ID == pzfm_dashboard_page() ){
                    $_scripts = array();
                    foreach( $wp_scripts->queue as $script ) :
                        $source =  $wp_scripts->registered[$script]->src;
                        $ex_source = explode('/', $source );
                        if( !in_array( $script, pzfm_registered_scripts() ) ){
                            $_scripts[] = $wp_scripts->registered[$script]->handle;
                            wp_dequeue_script( $wp_scripts->registered[$script]->handle );
                        }
                    endforeach;
                    $_styles = array();
                    foreach( $wp_styles->queue as $style ) :
                        $source =  $wp_styles->registered[$style]->src;
                        $ex_source = explode('/', $source );
                        if( !in_array( $style, pzfm_registered_styles() ) ){
                            $_styles[] = $wp_styles->registered[$style]->handle;
                            wp_dequeue_style( $wp_styles->registered[$style]->handle );
                        }
                    endforeach;
                }
            }
        }

		public function pzfm_styles_scripts() {
		    global $wp_styles, $wp_scripts, $post;
			if( !$post ){
				return false;
			}
		    $themes_uri = get_theme_root_uri();
			if ( ! wp_script_is( 'jquery', 'enqueued' )) {
				wp_enqueue_script( 'jquery' );
			}
		    if( 
				has_shortcode( $post->post_content, 'pzfm-login' ) 
				|| has_shortcode( $post->post_content, 'pzfm-register' ) 
				|| is_single() 
				|| in_array( get_post_meta( get_the_ID(), '_wp_page_template', true  ), array( 'dashboard.php', 'registration-template.php', 'thank-you.php' ) ) 
			) {

				$curr_roles    = isset( $_GET['id'] ) && (int)$_GET['id'] ? pzfm_user_role( (int)$_GET['id'] ) : array( pzfm_default_user_role() ) ;
				$translation   = array(
                    'ajaxurl' 						=> admin_url( 'admin-ajax.php' ),
					'confirmDeletion'   			=> apply_filters( 'pzfm_delete_confirmation', __( 'Are you sure you want to remove selected items?', 'pz-frontend-manager' ) ),
					'confirmActivate'   			=> apply_filters( 'pzfm_delete_confirmation', __( 'Are you sure you want to activate selected items?', 'pz-frontend-manager' ) ),
					'confirmDeactivate'   			=> apply_filters( 'pzfm_delete_confirmation', __( 'Are you sure you want to deactivate selected items?', 'pz-frontend-manager' ) ),
					'errorDeletion'   				=> apply_filters( 'pzfm_delete_error', __( 'No selected data to process.', 'pz-frontend-manager' ) ),
					'pzfmGetTypeLogin' 				=> pzfm_bg_login(),
					'pzfmLogin'						=> (is_user_logged_in()) ? true : false,
					'pzfmGetTypeBannerDashbiard' 	=> (!empty(pzfm_banner_slider_type())) ? pzfm_banner_slider_type() : 'empty',
					'currentRoles' 					=> $curr_roles,
					'select2Placeholder'			=> __('Select', 'pz-frontend-manager'),
					'featuredImgPlaceholder' 		=> PZ_FRONTEND_MANAGER_ASSETS_PATH.'images/post-placeholder.png',
					'removeFeaturedImage'			=> __( 'Remove featured image', 'pz-frontend-manager' ),
					'chooseImage'					=> __('Choose Image', 'pz-frontend-manager'),
					'selectImages'					=> __('Select Images', 'pz-frontend-manager'),
					'insertSelection'				=> __('Insert selection', 'pz-frontend-manager'),
					'noAction'						=> __('No action selected', 'pz-frontend-manager'),
				);
				$translation['utils'] 		= PZ_FRONTEND_MANAGER_ASSETS_PATH . '/js/utils.js';
				$translation['register'] 	= pzfm_parameters('register');
				$translation['dashboard'] 	= pzfm_parameters('dashboard');
				$translation['action'] 		= pzfm_parameters('action');
				$translation['countrycode'] = pzfm_phone_country_code();
				$translation['countryoption'] = pzfm_option_country_default();
				$translation['avatarPlaceholder'] = get_avatar_url( null, array( 'size' => 220 ) );

				if( isset( $_POST['pzfm-alert'] ) && !empty( $_GET['pzfm-alert'] ) ){
					$translation['pzfmAlert'] = sanitize_text_field( $_REQUEST['pzfm-alert'] );
				}

				wp_register_script( 'pzfm-sortable', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/jquery.sortable.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-repeater', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/jquery.repeater.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-popper-min', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/popper.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, false );
				wp_register_script( 'pzfm-bootstrap-bundle-scripts', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/bootstrap-bundle.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, false );
				wp_register_script( 'pzfm-datepicker-script', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/bootstrap-datepicker.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-select2-script', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/select2.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-bootstrap-admin', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/sb-admin-2.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-croppie-script', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/croppie.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-scripts', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/scripts.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-ajax', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/ajax.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-slick-script', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/slick.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_register_script( 'pzfm-spectrum-script', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/spectrum.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				wp_localize_script( 'pzfm-ajax', 'pzfmAjaxhandler', $translation );
				wp_register_script( 'pzfm-intlTelInput-script-js', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/intlTelInput.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, false );
				wp_register_script( 'pzfm-chart', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'js/Chart.min.js', array( 'jquery' ), PZ_FRONTEND_MANAGER_VERSION, true );
				
				if( pzfm_checkout() ){
					wp_register_style( 'woo-styles', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/woo-styles.css');
					wp_enqueue_style( 'woo-styles' );
				}
			
				wp_register_style( 'pzfm-datepicker-style', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/bootstrap-datepicker.css');
				wp_register_style( 'pzfm-bootstrap', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/sb-admin-2.min.css');
				wp_register_style( 'pzfm-fontawesome', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/fontawesome/all.min.css');
				wp_register_style( 'pzfm-croppie-style', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/croppie.css');
				wp_register_style( 'pzfm-style', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/style.min.css');
				wp_register_style( 'pzfm-select2-style', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/select2.min.css');	
				wp_register_style( 'pzfm-slick-style', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/slick.css');
				wp_register_style( 'pzfm-spectrum-style', PZ_FRONTEND_MANAGER_ASSETS_PATH . 'css/spectrum.min.css');
				wp_register_style( 'pzfm-intlTelInput-style', PZ_FRONTEND_MANAGER_ASSETS_PATH .'css/intlTelInput.css', array(), false );

				wp_localize_script( 'pzfm-scripts', 'pzfmAjaxhandler', $translation );

	
				wp_enqueue_script( 'pzfm-datepicker-script' );
				wp_enqueue_script( 'pzfm-popper-min' );
				wp_enqueue_script( 'pzfm-bootstrap-bundle-scripts' );
				wp_enqueue_script( 'pzfm-repeater' );
				wp_enqueue_script( 'pzfm-sortable' );
				wp_enqueue_script( 'pzfm-bootstrap-admin' );
				wp_enqueue_script( 'pzfm-select2-script' );
				wp_enqueue_script( 'pzfm-croppie-script' );
				wp_enqueue_script( 'pzfm-scripts' );
				wp_enqueue_script( 'pzfm-ajax' );
				wp_enqueue_script( 'pzfm-chart' );
				wp_enqueue_script( 'pzfm-slick-script' );
				wp_enqueue_script( 'pzfm-spectrum-script' );
				wp_enqueue_script( 'pzfm-intlTelInput-script-js');
				wp_enqueue_script( 'wp-color-picker');

				
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_style( 'pzfm-datepicker-style' );
				wp_enqueue_style( 'pzfm-bootstrap' );
				wp_enqueue_style( 'pzfm-fontawesome' );
				wp_enqueue_style( 'pzfm-select2-style' );
				wp_enqueue_style( 'pzfm-croppie-style' );
				wp_enqueue_style( 'pzfm-style' );
				wp_enqueue_style( 'pzfm-slick-style' );
				wp_enqueue_style( 'pzfm-spectrum-style' );
				wp_enqueue_style( 'pzfm-intlTelInput-style' );
			
				if( is_user_logged_in() ){
					wp_enqueue_style('thickbox'); // call to media files in wp
					wp_enqueue_script('thickbox');
					wp_enqueue_script( 'media-upload'); 
					wp_enqueue_media();
				}
		    }
		    
	    }
		public function pzfm_autocomplete_script() { ?>
			<?php if( pzfm_map_integ() ) : ?>
				<script>
					function initMap(){
						const elementsList = document.querySelectorAll("#address, #_billing_address_1");
						elementsList.forEach(input => {
							if(input){
							const options = {
								<?php if( !empty( pzfm_autocomplete_countries() ) ): ?>
									componentRestrictions: { country: ["<?php echo implode('", "', pzfm_autocomplete_countries() ); ?>"] },
								<?php endif; ?>
							};
							var autocomplete = new google.maps.places.Autocomplete(input, options);
							google.maps.event.addListener(autocomplete, 'place_changed', function () {
								var place = autocomplete.getPlace();
								const user_latitude = document.getElementById('user_latitude');
								const user_longitude = document.getElementById('user_longitude');
								if (user_latitude && user_longitude){
										user_latitude.value = place.geometry.location.lat();
										user_longitude.value = place.geometry.location.lng();
								}
							});
						}
						});
					}
				</script>
				<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo pzfm_api_key(); ?>&libraries=places&callback=initMap"></script>
				<?php
			endif;
		}
	}
	new PZ_FRONTEND_MANAGER_SCRIPTS;
}else{
	add_action( 'admin_notices', function(){
    	printf(
    		'<div class="error notice"><p>%s</p></div>',
    		__( '<strong>PZ Frontend Manager</strong> PHP class (<code>class PZ_FRONTEND_MANAGER_SCRIPTS {</code>} already exists.', 'pz-frontend-manager' )
    	);
    } );
}