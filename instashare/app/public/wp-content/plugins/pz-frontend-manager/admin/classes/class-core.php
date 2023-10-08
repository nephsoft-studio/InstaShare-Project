<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'PZ_FRONTEND_MANAGER' ) ) :
	class PZ_FRONTEND_MANAGER {
		public function __construct() {
			$this->init_hooks();
			do_action( 'gbs-frontend-dashboard_loaded' );
		}

		private function init_hooks() {
			// Before init hook
			add_action( 'after_setup_theme', array( $this, 'login_user' ) );
			// Action hooks
			add_action(	'init', array( $this, 'pzfm_allow_uploads') );
			add_action( 'init', array( $this, 'pzfm_init_uninstall' ) );
			add_action( 'wp', array( $this, 'pzfm_sessions' ) );
			add_action( 'wp', array( $this, 'pzfm_user_registration' ) );
			add_action( 'wp', array( $this, 'save_settings' ) );
			add_action( 'wp', array( $this, 'save_user_profile' ) );
			add_action( 'wp', array( $this, 'save_user' ) );
			add_action( 'wp', array( $this, 'save_post' ) );
			add_action( 'template_redirect', array( $this, 'redirection_notification' ) );
			add_action( 'template_redirect', array( $this, 'user_regerror_redirection' ) );
			add_action( 'template_redirect', array( $this, 'user_session_redirection' ) );
			add_action( 'wp_footer', array( $this, 'pzfm_login_popup' ));
			// Filter hooks
			add_filter( 'theme_page_templates', array( $this, 'pzfm_add_wp_template'), 10, 4);
			add_filter( 'page_template', array( $this, 'pzfm_page_template'));
			// Shortcodes
			add_shortcode( 'pzfm-login-form', array( $this,'pzfm_get_loginpage' ));
			add_shortcode( 'pzfm-register', array( $this,'pzfm_get_registerpage' ));
			add_shortcode( 'pzfm-popup-login', array( $this,'pzfm_dashboard_menu' ));
		}

		function pzfm_dashboard_menu(){
			ob_start();
				$link = is_user_logged_in() ? get_permalink( pzfm_dashboard_page() ) : '#';
				$id = !is_user_logged_in() ? 'id="pzfm-login-open"' : '';
				add_filter( 'body_class', function( $classes ) {
					return array_merge( $classes, array( 'pzfm-popup-enabled' ) );
				} );
			?>
				<li class="header__menu-item">
					<a class="header__menu-link" href="<?php echo esc_url($link); ?>" <?php _e($id); ?>>
						<span><i class="fas fa-user"></i></span>
					</a>
				</li>
			<?php
			return ob_get_clean();
		}
		
		function pzfm_login_popup(){
			$classes = get_body_class();
			if( in_array( 'pzfm-popup-enabled', $classes ) ) {
				echo do_shortcode('[pzfm-login-form form="true" login="popup"]');
			}
		}

		function pzfm_get_loginpage( $atts ){
			ob_start();
					$form = $atts['form'];
					$login = $atts['login'];

					if($login == 'popup') {
						echo '<div id="pzfm-popup">';
							echo '<div id="pzfm-popup-wrap">';
								$login_template = pzfm_include_template( 'login.tpl' );
								include_once( $login_template );
							echo '</div>';
						echo '</div>';
					} else {
						include( pzfm_include_template( 'header' ) ); 
							echo '<div id="wrapper-login-ovveride">';
							$login_template = pzfm_include_template( 'login.tpl' );
							include_once( $login_template );
							echo '</div>';
						include( pzfm_include_template( 'footer' ) );
					}
			return ob_get_clean();
		}

		function pzfm_get_registerpage( $atts ){
			if( is_admin() ){
				return false;
			}
			$redirect_to    = apply_filters('pzfm_register_redirec_to', get_the_permalink( get_the_id() ));
			$is_shortcode 	= true;
			ob_start();
			if( is_user_logged_in() ){
				printf( esc_html__('Hi %s, you are already logged in. Go to %s', 'pz-frontend-manager' ), wp_get_current_user()->display_name, '<a href="'.esc_url( $redirect_to ).'">'.__('Dashboard', 'pz-frontend-manager' ).'</a>'  );
			}else{
				echo '<div id="wrapper-login-ovveride">';
					require_once( pzfm_include_template( 'registration-form.tpl' ) );
				echo '</div>';
			}
			return ob_get_clean();
		} 
        
		function pzfm_init_uninstall(){

		}
		function login_user(){
			if( !isset( $_POST['pzfm_login_fields'] ) || ! wp_verify_nonce( $_POST['pzfm_login_fields'], 'pzfm_login_action' ) ){
				return false;
			}
			$user_login 		= sanitize_text_field( $_POST['user-login'] );
			$user_password 		= $_POST['user-password'];
			$remember_me 		= isset( $_POST['rememberme'] ) ? true : false ;
			$redirect_permalink = apply_filters( 'pzfm_login_redirect', get_the_permalink( pzfm_dashboard_page() ).'?login='.urlencode($user_login), $user_login );

			if ( !email_exists( pzfm_get_email_user( $user_login ) ) ) {
				$_SESSION['pzfm_page_redirect'] = array(
					'url' => $redirect_permalink,
					'status' => false,
					'message' => sprintf( __('Login failed! Please check your username and password.', 'pz-frontend-manager'), $user_login )
				);
				return false;
			}

			/*
			* Check if user activation is enable
			* this will allow only users that are activated to login
			*/

			if( pzfm_activation() && ! pzfm_login_activate( $_POST['user-login']) ){
				// Check if use is activated
				$_SESSION['pzfm_page_redirect'] = array(
					'url' => $redirect_permalink,
					'status' => false,
					'message' => sprintf( __('Login failed! User %s is not yet activated, please contact site administrator', 'pz-frontend-manager'), $user_login )
				);
				return false;
			}

			$signon = pzfm_signon( $user_login, $user_password, $remember_me );
			if( is_wp_error( $signon ) ){
				$_SESSION['pzfm_page_redirect'] = array(
					'url' 		=> $redirect_permalink,
					'status' 	=> false,
					'message' 	=> $signon->get_error_message()
				);
				return false;
			}	

			$_SESSION['pzfm_page_redirect'] = array(
				'url' 		=> $redirect_permalink,
				'status' 	=> true,
				'message' 	=> sprintf( __('Welcome back %s!', 'pz-frontend-manager'), $user_login )
			);
			return false;

		}
		function pzfm_allow_uploads() {
		    if( gsfd_role_exists( 'subscriber' ) ) {
    		    $role     = 'subscriber';
    		    $new_role = get_role($role);
        		$new_role->add_cap('upload_files');
		    }
		}

	    public function pzfm_page_template( $page_template ) {
			if ( get_page_template_slug() == 'dashboard.php' ) {
			    $page_template = PZ_FRONTEND_MANAGER_TEMPLATE_PATH . '/dashboard.php';
		    }
		    if ( get_page_template_slug() == 'thank-you.php' ) {
			    $page_template = PZ_FRONTEND_MANAGER_TEMPLATE_PATH . '/thank-you.php';
		    }
		    return $page_template;
	    }
	    public function pzfm_add_wp_template( $post_templates, $wp_theme, $post, $post_type ) {
			$post_templates['dashboard.php'] = __( 'PZ Frontend Template', 'pz-frontend-manager' );
			$post_templates['thank-you.php'] = __( 'Thank you', 'pz-frontend-manager' );
	    	return $post_templates;
	    }

		function pzfm_sessions(){
			if( isset( $_POST['lost_password_field'] ) && wp_verify_nonce( $_POST['lost_password_field'], 'lost_password_actions' ) ){
				$redirect_permalink = apply_filters( 'pzfm_session_redirect', get_the_permalink( pzfm_dashboard_page() ).'?lostpassword=true' );
				$_message 			= __( 'Invalid Username/Password', 'pz-frontend-manager' );
				if(!pzfm_parameters('key')){
					$email 			= sanitize_email( $_POST['lost_password_email'] );
					$reset_password_url = get_the_permalink( pzfm_dashboard_page() ).'?lostpassword=true&key='.base64_encode($email);
					$logo 			= pzfm_email_logo();
					$color 			= pzfm_email_color();
					ob_start();
					require_once( pzfm_include_template( 'emails/email-lost-password.tpl' ) );
					$message 		= ob_get_clean();
					$send_to        = $email;
					$headers       	= array( 'Content-Type: text/html; charset=UTF-8' );
					$headers[]      = 'From: ' . get_bloginfo('name') .' <'. get_bloginfo('admin_email') .'>';
					$subject		= apply_filters( 'pzfm_lost_password_subject', __('Reset Password', 'pz-frontend-manager' ) );
					if(email_exists($email)){
						wp_mail( $send_to, $subject, $message, $headers );
						$_message = __( 'Check your email account to reset your password.', 'pz-frontend-manager' );
					}
					$_SESSION['pzfm_session_redirect'] = array(
						'url' 		=> $redirect_permalink,
						'status' 	=> true,
						'message' 	=> $_message
					);
					return true;
				}

				$key 		= base64_decode(pzfm_parameters('key'));
				$user 		= get_user_by( 'email', $key );
				$user_id 	= $user->ID;
				$_message 	= __( 'Password does not match', 'pz-frontend-manager' );
				if(!empty($user_id)){
					$password 	= trim($_POST['user-password']);
					$cpassword 	= trim($_POST['confirm-password']);
					if( $password == $cpassword ){
						wp_set_password( $password, $user_id );
						$user_info 		= get_userdata($user_id);
						$from_email 	= $user_info->user_email;
						$logo 			= pzfm_email_logo();
						$color 			= pzfm_email_color();
						ob_start();
						require_once( pzfm_include_template( 'emails/email-reset-password.tpl' ) );
						$message = ob_get_clean();
						$send_to        = $from_email;
						$headers       	= array( 'Content-Type: text/html; charset=UTF-8' );
						$headers[]      = 'From: ' . get_bloginfo('name') .' <'. get_bloginfo('admin_email') .'>';
						$subject		= apply_filters( 'pzfm_reset_password_subject', __( 'Password has been reset', 'pz-frontend-manager' ) );
						wp_mail( $send_to, $subject, $message, $headers );
						$_message = __( 'Password has successfully change.', 'pz-frontend-manager' );
					}
				}

				$_SESSION['pzfm_session_redirect'] = array(
					'url' 		=> $redirect_permalink,
					'status' 	=> true,
					'message' 	=> $_message
				);
				return true;
	
			}
			
			if( in_array( get_post_meta( get_the_ID(), '_wp_page_template', true  ), array( 'dashboard.php', 'registration-template.php', 'thank-you.php' ) ) ||  pzfm_get_editable_roles() ) {
				add_filter( 'show_admin_bar', '__return_false' );
			}
			
			if( isset( $_GET['account-activation'] ) && isset( $_GET['activation-key'] ) && !empty( $_GET['activation-key'] ) ){
				$_message			= __( 'Your account has already been activated.', 'pz-frontend-manager' );
				$activation_key 	= sanitize_text_field( $_GET['activation-key'] );
				$user_id 			= (int) explode( '-', $activation_key)[1];
				$account_activation = get_user_meta( $user_id, 'account_activated', true );
				if( ! $account_activation ){
					update_user_meta( $user_id, 'account_activated', 1 );
					do_action( 'pzfm_after_activation_success', $user_id );
					$_message 	= __( 'Your account has been successfully activated.', 'pz-frontend-manager' );
				}
				$_SESSION['pzfm_session_redirect'] = array(
					'url' 		=> $redirect_permalink,
					'status' 	=> true,
					'message' 	=> $_message
				);
				return true;
			}

			if( isset( $_POST['nonce_login_field'] ) && wp_verify_nonce( $_POST['nonce_login_field'], 'nonce_login' )) {
				$creds = array(
					'user_email'    => sanitize_text_field($_POST['login_username']),
					'user_password' => $_POST['login_password'],
					'remember'      => true
				);
				$user = wp_signon( $creds, true );
				if ( is_wp_error( $user ) ) {
					echo $user->get_error_message();
				}
			}
		}
		// Save user
		public function save_user(){
			if ( !isset( $_POST['pzfm_save_contact_field'] ) || !wp_verify_nonce( $_POST['pzfm_save_contact_field'], 'pzfm_save_contact' ) ) {
				return false;
			}

			$password 		= isset($_POST['pzfm_new_password']) && !empty($_POST['pzfm_new_password']) ? $_POST['pzfm_new_password'] : false ;
			$user_id 		= isset($_POST['user_id']) && (int)$_POST['user_id'] ? (int)$_POST['user_id'] : false ;
			$is_new_user 	= false;
			if( $user_id ){
				$email		= sanitize_email( $_POST['email'] );
				if( $password ){
					wp_set_password( $password, $user_id );
				}		
			}else{
				$email 		= sanitize_email( $_POST['email'] );
				$user_id 	= wp_create_user( $email, $password, $email );
				$is_new_user = true;
			}

			// Check error while processing data
			if( is_wp_error( $user_id ) ){
				$_SESSION['pzfm_page_redirect'] = array(
					'url' 		=> get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page().'&action=add-user',
					'status' 	=> false,
					'message' 	=> $user_id->get_error_message()
				);
				return false;
			}
			
			$user 			= new WP_User( $user_id );

			// Check if it is really a user
			if( !$user->ID ){
				printf( __('Error, Cannot find the user in the system.', 'pz-frontend-manager') );
				wp_die();
			}
			
			$current_roles 	= pzfm_user_role( $user->ID );

			// Save user role
			$submitted_roles = isset( $_POST['user_role'] ) && is_array( $_POST['user_role'] ) ? (array)$_POST['user_role'] : array( pzfm_default_user_role() );
			unset( $_POST['user_role'] );
			// Remove first the assigned roles
			if( pzfm_can_assign_role() || $is_new_user ){
				if( !empty( $current_roles ) ){
					foreach( $current_roles as $role ){
						$user->remove_role( $role );
					}
				}
				// Set new roles from the form submision
				if( !empty( $submitted_roles ) ){
					foreach( $submitted_roles as $role ){
						$user->add_role( $role );
					}
				}
			}

      // Set user active
      if(pzfm_can_assign_role()){
        update_user_meta( $user_id, 'account_activated', 1 );
      }

			foreach( $_POST as $key => $value ){
				if( $key == 'phone'){
					$phone_code = get_user_meta( $user_id, 'phone-code', true );
					$value = (!empty($_POST['phone-code'])) ? sanitize_text_field( $_POST['phone-code'] ) . sanitize_text_field( $_POST['phone'] ) : $phone_code . sanitize_text_field( $_POST['phone'] );
				}
				update_user_meta( $user_id, $key, sanitize_text_field( $value ) );
			}

			if( !empty($_POST['pzfm-send-notif']) 
				|| ( !empty($_POST['user_id']) && !empty($_POST['pzfm_new_password']) ) ){
				do_action( 'pzfm_send_email_notif', $_POST, $user_id, $password );
			}
			do_action( 'pzfm_after_save_contact', $_POST, $user_id );
			$_SESSION['pzfm_page_redirect'] = array(
				'url' 		=> get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_users_page().'&action=update&id='.$user_id,
				'status' 	=> true,
				'message' 	=> sprintf( __('%s information successfully updated.', 'pz-frontend-manager'), $user->display_name  )
			);

		}
		// Save user profile
		public function save_user_profile(){
			global $wpdb;
			if ( !isset( $_POST['pzfm_edit_profile_field'] ) 
				|| !wp_verify_nonce( $_POST['pzfm_edit_profile_field'], 'pzfm_edit_profile' ) ) {
					return false;
			}
			if( !is_user_logged_in() ){
				esc_html_e('Permission denied!', 'pz-frontend-manager');
				wp_die();
			}
			$user_id = get_current_user_id();
			// Save user profile data
			foreach( pzfm_personal_info_fields() as $user_meta => $user_data ){
				if( isset( $_POST[$user_meta] ) ){
					$value = sanitize_text_field( $_POST[$user_meta] );
					// Sanitize submitted data
					if( $user_data['field'] == 'email' ){
						$value = sanitize_email( $_POST[$user_meta] );
					}elseif( $user_data['field'] == 'email' ){
						$value = sanitize_text_field( $_POST[$user_meta] );
					}
					if( $user_meta == 'phone'){
						$phone_code =  !empty($_POST['phone-code']) ? sanitize_text_field( $_POST['phone-code'] ) : get_user_meta( $user_id, 'phone-code', true );
						$value 		= $phone_code . $value;
						update_user_meta( $user_id, 'phone-code', $phone_code );
					}
					update_user_meta( $user_id, $user_meta, $value );
				}
			}

			if(in_array( 'administrator', pzfm_current_user_role())){
				
				update_user_meta( $user_id, 'pzfm_social_media', $_POST['pzfm-social-media'] );
			}

			do_action( 'pzfm_after_save_user_profile', $_POST, $user_id );	
			$_SESSION['pzfm_page_redirect'] = array(
				'url' 		=> get_the_permalink( pzfm_dashboard_page() ).'/?dashboard=profile',
				'status' 	=> true,
				'message' 	=> __('User profile successfully updated.', 'pz-frontend-manager')
			);
		}
		public function save_post(){
			if ( !isset( $_POST['pzfm_save_post_field'] ) || ! wp_verify_nonce( $_POST['pzfm_save_post_field'], 'pzfm_save_post' ) ) {
				return false;
			}

			$post_title = !empty($_POST['post_title']) ? sanitize_text_field( $_POST['post_title'] ) : '';
			$post_tags 	= !empty($_POST['post-tags']) ? (array)$_POST['post-tags'] : array();
			$post_cat 	= !empty($_POST['post_category']) ? (array)$_POST['post_category'] : array();	
			$post_id 	= isset( $_POST['id'] ) ? (int)$_POST['id'] : false;
			$author_id 	= isset($_POST['assigned_author']) && (int)$_POST['assigned_author'] ? (int)$_POST['assigned_author'] :  get_current_user_id();
			$thumbnail_id = isset($_POST['post_image']) && (int)$_POST['post_image'] ? (int)$_POST['post_image'] : false;

			$post_status  		= isset($_POST['post_status']) ? sanitize_text_field( $_POST['post_status'] ) : '';
			$hidden_status 		= isset($_POST['hidden_post_status']) ? sanitize_text_field( $_POST['hidden_post_status'] ) : '';
			$post_password 		= '';
			$set_sticky 		= false;

			if( $hidden_status != 'publish' ){
				$post_status = 'publish';
			}
			// Direct save post status
			if( isset( $_POST['pzfm_draft_post'] )){
				$post_status = 'draft';
			}
			if( isset( $_POST['pzfm_pending_post'] )){
				$post_status = 'pending';
			}
			// Checked fro visibility form submission 
			if( isset($_POST['hidden_visibility_status']) && (int)$_POST['hidden_visibility_status'] ){
				$post_status = $_POST['visibility'] != 'private' ? 'publish' : 'private';
				if( $_POST['visibility'] == 'password' && !empty( trim($_POST['post_password']) ) ){
					$post_password = $_POST['post_password'];
				}
				if( $_POST['visibility'] == 'public' && isset($_POST['sticky']) ){
					$set_sticky = true;
				}
			}
			$year 	= str_pad((int)$_POST['aa'], 4, '0', STR_PAD_LEFT);
			$month 	= str_pad((int)$_POST['mm'], 2, '0', STR_PAD_LEFT);
			$day 	= str_pad((int)$_POST['jj'], 2, '0', STR_PAD_LEFT);
			$hour 	= str_pad((int)$_POST['hh'], 2, '0', STR_PAD_LEFT);
			$minute = str_pad((int)$_POST['mn'], 2, '0', STR_PAD_LEFT);
			$second = str_pad((int)$_POST['ss'], 2, '0', STR_PAD_LEFT);

			$post_date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;

			$pzfm_post = array(
				'post_title'    => wp_strip_all_tags( $post_title ),
				'post_content'  => wp_kses_post( $_POST['pzfm-post-content'] ),
				'post_status'   => $post_status,
				'post_author'   => $author_id,
				'post_excerpt' 	=> wp_kses_post( $_POST['post_short_description'] ),
				'post_password' => $post_password
			);

			if( pzfm_validate_date($post_date, 'Y-m-d H:i:s') && (int)$_POST['hidden_currtime_update'] ){
				$pzfm_post['post_date'] = $post_date;
			}
			if( $post_id ){
				$pzfm_post['ID'] = $post_id;
				wp_update_post( $pzfm_post );
			}else{
				$post_id = wp_insert_post( $pzfm_post );
			}

			$post_tags = !empty($_POST['remove-post-tags']) && is_array($_POST['remove-post-tags']) ? array_merge( $post_tags, (array)$_POST['remove-post-tags'] ) : $post_tags;

			wp_set_post_terms( $post_id, $post_tags );
			wp_set_post_terms( $post_id, $post_cat, 'category' );
			if( $set_sticky ){
				stick_post( $post_id );
			}elseif( is_sticky( $post_id ) ){
				unstick_post( $post_id );
			}

			if ( is_wp_error( $post_id ) ) {
				$message = $post_id->get_error_message();
				$_SESSION['pzfm_page_redirect'] = array(
					'url' 		=> get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_posts_page().'&action=update&id='.$post_id,
					'status' 	=> true,
					'message' 	=> $message 
				);
				return false;
			}

			// Save / delete post thumbnail
			if( $thumbnail_id ){
				set_post_thumbnail( $post_id, $thumbnail_id );
			}else{
				delete_post_thumbnail($post_id);
			}
			
			do_action( 'pzfm_after_save_post', $_POST, $post_id );

			$message = sprintf( __('%s successfully saved', 'pz-frontend-manager'), $post_title );
			if( $post_status != 'publish' ){
				$message = sprintf( __('%s is now %s', 'pz-frontend-manager'), $post_title, ucfirst($post_status) );
			}

			$_SESSION['pzfm_page_redirect'] = array(
				'url' => get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_posts_page().'&action=update&id='.$post_id,
				'status' => true,
				'message' => $message 
			);
			return false;

		}
		public function save_settings(){
			//  Save FM settings data
			// Check nonce field
			if( !isset( $_POST['pzfm_settings_form_fields'] ) 
				|| !wp_verify_nonce( $_POST['pzfm_settings_form_fields'], 'pzfm_settings_add_action' ) ){
				return false;
			}

			// Check user role permission
			if( !in_array( 'administrator', pzfm_current_user_role() ) ){
				esc_html_e('Permission denied!', 'pz-frontend-manager');
				wp_die();
			}
				
			// General Settings - TAB
			$pzfm_site_logo 		= isset($_POST['pzfm_site_logo']) ? sanitize_text_field( $_POST['pzfm_site_logo'] ) : null;
			$pzfm_login_background 	= isset($_POST['pzfm_login_background']) ? sanitize_text_field( $_POST['pzfm_login_background'] ) : null;
			$pzfm_base_color 		= isset($_POST['pzfm_base_color']) ? sanitize_text_field( $_POST['pzfm_base_color'] ) : null;

			update_option( 'pzfm_site_logo', $pzfm_site_logo );
			update_option( 'pzfm_login_background', $pzfm_login_background );
			update_option( 'pzfm_base_color', $pzfm_base_color );

			// User registration - TAB
			$pzfm_registration 			= isset($_POST['pzfm-registration']) ? (int)$_POST['pzfm-registration'] : null;
			$pzfm_activation 			= isset($_POST['pzfm-activation']) ? (int)$_POST['pzfm-activation'] : null;
			$pzfm_default_user_role 	= isset($_POST['pzfm_default_user_role']) ? sanitize_text_field( $_POST['pzfm_default_user_role'] ) : 'subscriber';
			$pzfm_activation_email 		= isset($_POST['pzfm-activation-email']) ? (array)$_POST['pzfm-activation-email'] : array();
			$pzfm_activation_email_content 	= isset($_POST['pzfm-activation-email-content']) ? sanitize_textarea_field( $_POST['pzfm-activation-email-content'] ) : '';

			$pzfm_enable_recaptcha 		= isset($_POST['pzfm-enable-recaptcha']) ? true : false;
			$pzfm_captcha_site_key 		= isset($_POST['pzfm-captcha-site-key']) ? sanitize_text_field( $_POST['pzfm-captcha-site-key'] ) : '';
			$pzfm_captcha_secret_key 	= isset($_POST['pzfm-captcha-secret-key']) ? sanitize_text_field( $_POST['pzfm-captcha-secret-key'] ) : '';

			$pzfm_deactivate_plugins_1 	= (get_option('pzfm_deactivate_plugins')) ? get_option('pzfm_deactivate_plugins') : array();
			$pzfm_deactivate_plugins_2	= isset($_POST['pzfm_deactivate_plugins']) ? $_POST['pzfm_deactivate_plugins'] : array();
			$result_merge_args			= array_merge($pzfm_deactivate_plugins_1, $pzfm_deactivate_plugins_2);
			$pzfm_disabled_plugins		= isset($_POST['pzfm_disabled_plugins']) ? $_POST['pzfm_disabled_plugins'] : array();

			if($pzfm_disabled_plugins){
				foreach( $pzfm_disabled_plugins as $key => $value ){
					unset($result_merge_args[$key]);
				}
			}

			update_option( 'pzfm-registration', $pzfm_registration );
			update_option( 'pzfm-activation', $pzfm_activation );
			update_option( 'pzfm_default_user_role', $pzfm_default_user_role );
			update_option( 'pzfm-activation-email', $pzfm_activation_email );
			update_option( 'pzfm-activation-email-content', $pzfm_activation_email_content );
			update_option( 'pzfm-enable-recaptcha', $pzfm_enable_recaptcha );
			update_option( 'pzfm-captcha-site-key', $pzfm_captcha_site_key );
			update_option( 'pzfm-captcha-secret-key', $pzfm_captcha_secret_key );
			update_option( 'pzfm_deactivate_plugins', $result_merge_args );
			do_action( 'pzfm_after_save_settings', $_POST );
			$page_tab = (!empty($_POST['tab-page'])) ? '&tab='. sanitize_text_field( $_POST['tab-page'] ) : '';
			$_SESSION['pzfm_page_redirect'] = array(
				'url' => get_the_permalink( pzfm_dashboard_page() ).'/?dashboard=settings'.$page_tab,
				'status' => true,
				'message' => __('General settings successfully saved', 'pz-frontend-manager')
			);
			return false;
		}
		function pzfm_user_registration(){
			global $post;
			if( !isset( $_POST['nonce_register_field'] ) || !wp_verify_nonce( $_POST['nonce_register_field'], 'nonce_register' )) {
				return false;
			}
			$email 			= sanitize_email( $_POST['email'] );
			$password 		= $_POST['reg_pass'];
			// UNSET POST DATA
			unset($_POST['email']);
			unset($_POST['reg_pass']);
			unset($_POST['confirm_pass']);
			$user_agent = '';
			if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
				$user_ip = sanitize_text_field( $_SERVER['HTTP_CLIENT_IP'] );
			} elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				$user_ip = sanitize_text_field( $_SERVER['HTTP_X_FORWARDED_FOR'] );
			} else {
				$user_ip = sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
			}
			if( !empty( $_SERVER['HTTP_USER_AGENT'] ) ){
				$user_agent = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
			}
			// Check if email if in correct format
			if( !is_email($email) || email_exists( $email ) ){
				$_SESSION['pzfm_page_redirect'] = array(
					'url' 		=> get_the_permalink( $post->ID ).'/?register=true',
					'status' 	=> false,
					'message' 	=> __('Email already exist!', 'pz-frontend-manager')
				);
				return false;
			}
			if( pzfm_spam_registration( $user_ip )  ){
				$_SESSION['pzfm_page_redirect'] = array(
					'url' 		=> get_the_permalink( $post->ID ).'/?register=true',
					'status' 	=> false,
					'message' 	=> __('IP blocked, please try again later.', 'pz-frontend-manager')
				);
				return false;
			}
			$user_id = wp_create_user( $email, $password, $email );
			if( is_wp_error($user_id) ){
				$_SESSION['pzfm_page_redirect'] = array(
					'url' 		=> get_the_permalink( $post->ID ).'/?register=true',
					'status' 	=> false,
					'message' 	=> $user_id->get_error_message()
				);
				return false;
			}
			
			foreach( pzfm_personal_info_fields() as $field_key => $user_fields ){
				$value = sanitize_text_field( $_POST[$field_key] );
				if( $field_key == 'phone' && isset( $_POST['phone-code'] ) ){
					$value = sanitize_text_field( $_POST['phone-code'].$_POST['phone'] );
				}
				if( isset( $_POST[$field_key] ) ){
					update_user_meta( $user_id, $field_key, $value );
				}
			}
			$new_user = new WP_User( $user_id );
			$new_user->set_role( pzfm_default_user_role() );
			$activation_key = pzfm_generate_numbers().'-'.$user_id;
			update_user_meta( $user_id, 'activation_key', $activation_key );
			update_user_meta( $user_id, 'pzfm_user_ip', $user_ip );
			update_user_meta( $user_id, 'pzfm_user_agent', $user_agent );
			do_action( 'pzfm_after_save_user_registration', $_POST, $user_id, $password );

			$message = sprintf( __( 'Hi %s, your account has been successfully created.', 'pz-frontend-manager'), $new_user->display_name );
			if( pzfm_activation() ){
				$message = sprintf( __('Hi %s, your account has been successfully created, please activate your account in your e-mail.'), $new_user->display_name );
			}

			$_SESSION['pzfm_page_redirect'] = array(
				'url' 		=> get_the_permalink( $post->ID ).'/?register=true',
				'status' 	=> true,
				'message' 	=> $message
			);
			return false;
		}
		public function redirection_notification(){
			if( !isset($_SESSION['pzfm_page_redirect']) || !is_array( $_SESSION['pzfm_page_redirect'] )  ){
				return false;
			}
			$pzfm_page_redirect = $_SESSION['pzfm_page_redirect'];
			unset($_SESSION['pzfm_page_redirect']);
			wp_redirect( wp_http_validate_url( $pzfm_page_redirect['url'] ).'&pzfm-alert=1&status='.$pzfm_page_redirect['status'].'&message='.urlencode($pzfm_page_redirect['message']  )  );
			die;
		}
		function user_regerror_redirection(){
			if(!isset($_POST['pzfm-process_error']) || empty($_POST['pzfm-process_error']) ){
				return false;
			}
			wp_redirect( get_the_permalink().'?register=true&'.sanitize_text_field($_POST['pzfm-process_error']));
			die;
		}
		function user_session_redirection(){
			if(!isset($_SESSION['pzfm_session_redirect']) || empty($_SESSION['pzfm_session_redirect']) ){
				return false;
			}
			$pzfm_session_redirect = $_SESSION['pzfm_session_redirect'];
			unset($_SESSION['pzfm_session_redirect']);
			wp_redirect( wp_http_validate_url( $pzfm_session_redirect['url'] ).'&pzfm-alert=1&status='.$pzfm_session_redirect['status'].'&message='.urlencode($pzfm_session_redirect['message']  )  );
			die;
		}
	}
	new PZ_FRONTEND_MANAGER;
else :
    add_action( 'admin_notices', function(){
    	printf(
    		'<div class="error notice"><p>%s</p></div>',
    		__( '<strong>PZ Frontend Manager</strong> PHP class (<code>class PZ_FRONTEND_MANAGER {</code>} is already exist.', 'pz-frontend-manager' )
    	);
    } );

endif;