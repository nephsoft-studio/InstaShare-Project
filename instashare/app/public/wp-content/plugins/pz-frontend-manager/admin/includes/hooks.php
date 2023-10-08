<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// Check frontend dashboard page ID
function pzfm_set_dashboard(){
	$dash_id = pzfm_dashboard_page_id();
	if( ! get_post( get_option( 'pzfm_dashboard' ) ) && $dash_id ){
        update_option( 'pzfm_dashboard', $dash_id );
    }
}
add_action( 'plugins_loaded', 'pzfm_set_dashboard' );
// Posts Table row fileter hooks
add_filter( 'pzfm_post_row_data_author', 'pzfm_post_row_data_author', 10, 2 );
function pzfm_post_row_data_author( ){
	$action 		= pzfm_can_edit_user() ? 'update' : 'view' ;
	$display_name 	= get_the_author_meta( 'display_name', );
	$author_url 	= get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page().'&action='.$action.'&id='.get_the_author_meta('ID');
	return sprintf( '<a href="%s" title="%s">%s</a>', esc_url( $author_url ), esc_attr( $display_name ), esc_html( $display_name ) );
}
add_filter( 'pzfm_post_row_data_date', 'pzfm_post_row_data_date', 10, 2 );
function pzfm_post_row_data_date(){
	return get_the_date('Y/m/d g:i a');
}
add_filter( 'pzfm_post_row_data_categories', 'pzfm_post_row_data_tax_categories', 10, 2 );
function pzfm_post_row_data_tax_categories( ){
	global $post;
	$terms = get_the_terms( $post, 'category' );
	if( empty( $terms ) ){
		return false;
	}
	$term_labels = array_map( function( $term ){ 
		$search_url = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&cat='.$term->term_id;
		return sprintf( '<a href="%s" title="%s">%s</a>', esc_url( $search_url ), esc_attr( $term->name ), esc_html( $term->name ) ); 
	}, $terms );
	if ( count($term_labels) > 5 ){
		$search_url = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&action=update&id='.$post->ID;
		$term_labels = array_slice( $term_labels, 0, 5 );
		$term_labels[] = sprintf( '<a href="%s" title="%s">%s</a>', esc_url( $search_url ), '...', '...' );
	}
	return implode( ', ', $term_labels );
}
add_filter( 'pzfm_post_row_data_tags', 'pzfm_post_row_data_tags', 10, 2 );
function pzfm_post_row_data_tags( ){
	global $post;
	$terms = get_the_terms( $post, 'post_tag' );
	if( empty( $terms ) ){
		return false;
	}
	$term_labels = array_map( function( $term ){ 
		$search_url = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&tag='.$term->term_id;
		return sprintf( '<a href="%s" title="%s">%s</a>', esc_url( $search_url ), esc_attr( $term->name ), esc_html( $term->name ) ); 
	}, $terms );
	if ( count($term_labels) > 5 ){
		$search_url = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&action=update&id='.$post->ID;
		$term_labels = array_slice( $term_labels, 0, 5 );
		$term_labels[] = sprintf( '<a href="%s" title="%s">%s</a>', esc_url( $search_url ), '...', '...' );
	}
	return implode( ', ', $term_labels );
}
add_action( 'pzfm_dashboard_content', 'pzfm_dashboard_content_cb', 1 );
function pzfm_dashboard_content_cb(){
	require_once( pzfm_include_template( 'dashboard-cards-tpl' ) );
}
add_filter( 'pzfm_personal_info_fields', 'pzfm_personal_info_fields_content' );
function pzfm_personal_info_fields_content($pzfm_personal_info_fields){
	if(!is_user_logged_in()){
		unset($pzfm_personal_info_fields['username']);
		$pzfm_personal_info_fields['email']['wrapper_class'] = 'email col-md-6';
	}
	return $pzfm_personal_info_fields;
}
add_filter( 'ajax_query_attachments_args', 'pzfm_show_current_user_attachments' );
function pzfm_show_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id ) {
        $query['author'] = $user_id;
    }
    return $query;
}
add_action( 'wp_head', 'pzfm_inline_styles' );
function pzfm_inline_styles(){
	?>
		<style type="text/css">
			:root{
				--main-bg-color: #eee; 
				--pzfm: <?php echo pzfm_base_color(); ?>;
				--pzfm-dark: #023E74;
				--pzfm-secondary: #010D27;
				--pzfm-icon-color: <?php echo pzfm_icon_color(); ?>
			}
		</style>
	<?php
}
add_filter( 'pzfm_email_meta_tags', 'pzfm_personal_info_meta_tags' );
function pzfm_personal_info_meta_tags( $tags ){
	if( !empty( pzfm_personal_info_fields() ) ){
		foreach( pzfm_personal_info_fields() as $field_key => $field_data ){
			$tags['{'.$field_key.'}'] = $field_data['label'];
		}
	}
	return $tags;
}
add_action( 'pzfm_after_users_header', 'after_contacts_role_header', 80 );
function after_contacts_role_header(){
	if( pzfm_can_assign_role() ){
		echo '<th>'.esc_html__( 'Role', 'pz-frontend-manager' ).'</th>';
	}
}
add_action( 'pzfm_after_users_details', 'after_contacts_role_details', 80 );
function after_contacts_role_details( $user_id ){
	if( pzfm_can_assign_role() ){
		$userdata = get_userdata( $user_id );
		$roles = array();
		foreach( pzfm_get_all_roles() as $role_key => $role_label ){
			if( in_array( $role_key, $userdata->roles ) ){
				$roles[] = '<a href="'. get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page().'&filter='.$role_key.'">'.$role_label.'</a>';
			}
		}
		$join_roles = join( ', ', $roles );
		
		printf( '<td data-label="%s">%s</td>', esc_html__( "Role", 'pz-frontend-manager' ), $join_roles );
	}
}
add_action( 'pzfm_after_users_header', 'pzfm_user_registered_column', 90 );
function pzfm_user_registered_column(){
	if( pzfm_parameters('dashboard') == pzfm_users_page() && in_array( 'administrator', pzfm_current_user_role() ) ){
		printf( '<th>%s</th>', esc_html__( 'Date Registered', 'pz-frontend-manager' ) );
	}
  echo '<th>'.esc_html__( 'Status', 'pz-frontend-manager' ).'</th>';
}
add_action( 'pzfm_after_users_details','pzfm_user_date_registered', 90 );
function pzfm_user_date_registered( $user_id ){
    if( pzfm_parameters('dashboard') == pzfm_users_page() && in_array( 'administrator', pzfm_current_user_role() ) ){
        $udata = get_userdata( $user_id );
        $registered = $udata->user_registered;
        $get_featured_status =  date( "Y-m-d h:i a", strtotime( $registered ) );
		printf( '<td data-label="%s">%s</td>', esc_html__( "user-registered", 'pz-frontend-manager' ), esc_html( $get_featured_status ) );
    }
    $status = pzfm_user_activated( $user_id ) ? 'Active' : 'Inactive';
    $status_class = $status == 'Active' ? 'success' : 'secondary';
    printf( '<td data-label="%s" class="text-%s">%s</td>', esc_html__( "Status", 'pz-frontend-manager' ), $status_class, $status );
}
add_action( 'pzfm_send_email_notif', 'pzfm_email_new_contact', 10, 3 );
function pzfm_email_new_contact( $data, $user_id, $password ){
	$get_user_data	= get_userdata( $user_id );
	ob_start();
	?>
	<?php printf( '<p>%s %s</p>', __( 'Dear', 'pz-frontend-manager' ), esc_html( $get_user_data->display_name ) ); ?>
	<?php printf( '<p>%s %s.</p>', get_bloginfo('name'), esc_html__( 'created an account for you. You can login here using the below credentials', 'pz-frontend-manager' ) ); ?>
	<?php printf( '<p><strong>%s : </strong> %s</p>', __( 'Username', 'pz-frontend-manager' ), esc_html( $get_user_data->user_email ) ); ?>
	<?php printf( '<p><strong>%s : </strong> %s</p>', __( 'Password', 'pz-frontend-manager' ), esc_html( $password ) ); ?>
	<?php
	$message		= ob_get_clean();
	$headers        = array( 'Content-Type: text/html; charset=UTF-8' );
	$headers[]      = 'From: ' . get_bloginfo('name') .' <'.get_option( 'admin_email' ).'>';
	$subject        = get_option( 'pzfm-contact-email-subject' );
	$send_to        = $get_user_data->user_email;
	  
	wp_mail( $send_to, $subject, $message, $headers );
}
add_action( 'pzfm_after_save_user_profile', 'pzfm_save_new_password', 10, 2 );
function pzfm_save_new_password( $data, $user_id){
	if( !isset( $data['pzfm_new_password'] ) || empty(trim( $data['pzfm_new_password'] )) ){
		return false;
	}

	$logo 			= pzfm_email_logo();
	$user_info 		= get_userdata( $user_id );
	$users_login 	= $user_info->user_email;
	// Save user password
	$password 		= $_POST['pzfm_new_password'];
	wp_set_password( $password, $user_id );
	wp_set_auth_cookie ( $user_id );
    wp_set_current_user( $user_id );

	$user_info 		= get_userdata( $user_id );
	$from_email 	= $user_info->user_email;
	ob_start();
	require_once( pzfm_include_template( 'emails/email-reset-password.tpl' ) );
	$message 		= ob_get_clean();
	$send_to        = $from_email;
	$headers       	= array( 'Content-Type: text/html; charset=UTF-8' );
	$headers[]      = 'From: ' . get_bloginfo('name') .' <'. get_bloginfo('admin_email') .'>';
	$subject		= esc_html__( apply_filters( 'pzfm_reset_password_subject', 'Password has been reset' ), 'pz-frontend-manager' );
	$wp_mail 		= wp_mail( $send_to, $subject, $message, $headers );
}
add_action( 'pzfm_after_save_user_profile', 'pzfm_save_billing_profile', 10, 2 );
function pzfm_save_billing_profile( $data, $user_id ){
	if( isset( $data['personal_to_billing'] ) ){
		update_user_meta( $user_id, 'personal_to_billing', sanitize_text_field( $data['personal_to_billing'] ) );
		if( function_exists('pzfm_billing_info_fields')){
			foreach( pzfm_billing_info_fields() as $user_meta => $user_data ){
				if( isset( $data[$user_meta] ) ){
					update_user_meta( $user_id, $user_meta, $data[$user_meta] );
				}
			}
		}
		if( $data['personal_to_billing'] ){
			update_user_meta( $user_id, '_billing_first_name', sanitize_text_field( $data['first_name'] ) );
			update_user_meta( $user_id, '_billing_last_name', sanitize_text_field( $data['last_name'] ) );
			update_user_meta( $user_id, '_billing_email', sanitize_email( $data['email'] ) );
			update_user_meta( $user_id, '_billing_phone', sanitize_text_field( $data['phone'] ) );
		}
	}else{
		update_user_meta( $user_id, 'personal_to_billing', '' );
	}
}
add_action( 'pzfm_after_footer_hook', 'pzfm_general_setting_alerts', 99 );
function pzfm_general_setting_alerts(){
	global $post;
	if( ! ( isset($_GET['pzfm-alert']) ) || !isset($_GET['message']) ){
		return false;
	}
	$message 	= sanitize_text_field($_GET['message']);
	$background = isset( $_GET['status'] ) && (int)$_GET['status'] ? 'bg-success' : 'bg-danger';
	require_once( PZ_FRONTEND_MANAGER_PATH . 'templates/alert-tpl.php' );
	?>
	<script>
    window.history.replaceState({}, document.title, '<?php echo get_the_permalink( pzfm_dashboard_page() ).'?'.pzfm_clean_url_parameter(['pzfm-alert', 'status','message']); ?>' );
  </script>
	<?php
}

function pzfm_registration_failed_callback(){
	global $post;
	if( $post->ID == pzfm_dashboard_page() ){
		return false;
	}
	if( !isset($_GET['pzfm-alert']) || !isset($_GET['message'])  ){
		return false;
	}
	$class = isset( $_GET['status'] ) && (int)$_GET['status'] ? 'success' : 'danger' ;
	?>
	<div class="alert alert-<?php echo esc_attr( $class ); ?>"><?php echo sanitize_text_field( $_GET['message'] ); ?></div>
	<script>
    window.history.replaceState({}, document.title, '<?php echo get_the_permalink( pzfm_dashboard_page() ).'?'.pzfm_clean_url_parameter(['pzfm-alert', 'status','message']); ?>' );
  </script>
	<?php
}
add_action( 'pzfm_before_registration_form', 'pzfm_registration_failed_callback');
function pzfm_registration_captcha_callback(){
	if( ! pzfm_recaptcha_active() ){
		return false;
	}
	?>
	<script>
		document.getElementById("pzfm-registration-form").addEventListener("submit",function(evt)
		{
			var response = grecaptcha.getResponse();
			if(response.length == 0){ 
				//reCaptcha not verified
				alert( "<?php esc_html_e( "Please verify you are human!", 'pz-frontend-manager'); ?>" );
				evt.preventDefault();
				return false;
			}
		});
	</script>
	<?php
}
add_action( 'pzfm_after_registration_form', 'pzfm_registration_captcha_callback');
function pzfm_registration_captcha_sitekey_callback(){
	if( ! pzfm_recaptcha_active() ){
		return false;
	}
	?><div class="g-recaptcha" data-sitekey="<?php echo pzfm_captcha_site_key(); ?>"></div><?php
}
add_action( 'pzfm_after_registration_form_fields', 'pzfm_registration_captcha_sitekey_callback');
function pzfm_registration_captcha_script_callback(){
	if( ! pzfm_recaptcha_active() ){
		return false;
	}
	?><script src="https://www.google.com/recaptcha/api.js"></script><?php
}
add_action('wp_footer', 'pzfm_registration_captcha_script_callback');
add_action("pzfm_after_save_pop", "pzfm_after_save_pop");
function pzfm_after_save_pop( $attachment_id ){
	$color 			= pzfm_base_color();
	$headers        = array( 'Content-Type: text/html; charset=UTF-8' );
	$subject        = esc_html__( 'Customer Proof of Payment', 'pz-frontend-manager' );
	$send_to        = get_option( 'admin_email' );
	ob_start();
	require_once( pzfm_include_template( 'emails/email-proof-of-payment.tpl' ) );
	$message        =  ob_get_clean();
	wp_mail( $send_to, $subject, $message, $headers );
}
add_filter( 'pzfm_users_args', 'pzfm_users_args_management' );
function pzfm_users_args_management($args){
	if( pzfm_parameters( 'filter' ) ){
		if( pzfm_parameters( 'filter' ) == 'pending'){
			$args['meta_query'][] = array(
				'key'       => 'account_activated',
				'compare'   => 'NOT EXISTS'
			);
		}else{
			$roles = pzfm_parameters('filter');
			$args['role__in'][] = $roles;
		}
	}
	
	return $args;
}
add_action('pzfm_after_save_user_profile','pzfm_save_author_cover' );
function pzfm_save_author_cover(){
    $user_id = get_current_user_id();
    if( isset( $_FILES["pzfm-cover-photo"] ) && !empty( $_FILES["pzfm-cover-photo"] || !empty( $_FILES["pzfm-cover-photo"]["tmp_name"] ) ) ){
		$upload_pp = wp_upload_bits( $_FILES["pzfm-cover-photo"]["name"], null, file_get_contents( $_FILES["pzfm-cover-photo"]["tmp_name"] ) );
		if ( ! $upload_pp['error'] ) {
			$filename = $upload_pp['file'];
			$wp_filetype = wp_check_filetype($filename, null);
			$attachment = array(
			  'post_mime_type' => $wp_filetype['type'],
			  'post_title' => sanitize_file_name($filename),
			  'post_content' => '',
			  'post_status' => 'inherit'
			);
			$attachment_id = wp_insert_attachment( $attachment, $filename, $user_id );
			if( ! is_wp_error( $attachment_id ) ){
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
				$avatar_url = wp_get_attachment_url( $attachment_id );
				update_user_meta($user_id,'pzfm_cover_avatar', $avatar_url);
			}
		}
	}
}

add_action('init','add_upload_capabilities');
function add_upload_capabilities(){
     if( in_array( 'subscriber', pzfm_current_user_role() ) ){
        $role_object = get_role( 'subscriber' );
        $role_object->add_cap( 'upload_files');
        $role_object->add_cap( 'delete_files');
   }
}
add_action( 'pzfm_after_save_user_registration', 'pzfm_send_email_notification', 10, 3 );
function pzfm_send_email_notification( $data, $user_id, $password ){
	$user_data		= get_userdata( $user_id );
	$user_firstname = $user_data->first_name;
	$user_lastname 	= $user_data->last_name;
	$user_email 	= $user_data->user_email;
	$blog_url 		= get_author_posts_url($user_id);
	$logo 			= pzfm_email_logo();
	$color 			= pzfm_email_color();

	if( pzfm_activation() ){
		// Allo the registered user to activate account using the email notification
		$activation_key = get_user_meta( $user_id, 'activation_key', true );
		$activation_url = get_permalink( pzfm_dashboard_page() ).'?account-activation=true&activation-key='.$activation_key;
		ob_start();
		require_once( pzfm_include_template( 'emails/email-registration-activation.tpl' ) );
		$message = ob_get_clean();
		$from_name		= pzfm_activation_email( 'name' ) ? pzfm_activation_email( 'name' ) : get_bloginfo('name');
		$from_email		= pzfm_activation_email( 'from' ) ? pzfm_activation_email( 'from' ) : get_option( 'admin_email' );
		$headers        = array( 'Content-Type: text/html; charset=UTF-8' );
		$headers[]      = 'From: ' . $from_name .' <'. $from_email .'>';
		$subject		= esc_html__( 'Account activation notification', 'pz-frontend-manager' );
		if( !empty( pzfm_activation_email( 'subject' ) ) ){
			$subject    =  pzfm_activation_email( 'subject' );
		}
		wp_mail( $user_email, $subject, $message, $headers );
	}

	// Send email notification admin for the new user registration
	ob_start();
	require_once( pzfm_include_template( 'emails/email-registration-confirmation.tpl' ) );
	$message = ob_get_clean();
	
	$send_to        = apply_filters( 'pzfm_after_save_user_registration_email_send_to', get_bloginfo('admin_email'), $data );
	$headers        = array( 'Content-Type: text/html; charset=UTF-8' );
	$headers[]      = 'From: ' . get_bloginfo('name') .' <'. get_option( 'admin_email' ) .'>';
	$subject		= esc_html__( 'New User Registration', 'pz-frontend-manager' );
	wp_mail( $send_to, apply_filters('pzfm_user_email_subject', $subject), $message, $headers );
}

add_action( 'pzfm_after_save_contact', 'pzfm_send_email_account_created', 10, 2 );
function pzfm_send_email_account_created($data, $user_id){
	$blog_url 		= get_author_posts_url($user_id);
	$user_firstname = get_user_meta( $user_id, 'first_name', true );
	$user_lastname  = get_user_meta( $user_id, 'last_name', true );
	$get_user_data	= get_userdata( $user_id );
	$logo 			= pzfm_email_logo();
	$color 			= pzfm_email_color();
	$from_name		= $user_firstname .' '. $user_lastname;
	$from_email		= apply_filters( 'pzfm_after_save_contact_email_send_to', $data['email'], $data );
	$password 		= $data['password'];
	ob_start();
	require_once( pzfm_include_template( 'emails/email-create-acount.tpl' ) );
	$message = ob_get_clean();
	
	$send_to        = $from_email;
	$headers       	= array( 'Content-Type: text/html; charset=UTF-8' );
	$headers[]      = 'From: ' . get_bloginfo('name') .' <'. get_bloginfo('admin_email') .'>';
	$subject		= esc_html__( 'Welcome to '.get_bloginfo('name'), 'pz-frontend-manager' );
	return wp_mail( $send_to, apply_filters( 'pzfm_user_email_subject', $subject ), $message, $headers );
}

function pzfm_registration_phone_error( $field_data, $value ){
	ob_start();
	?>
	<span id="valid-msg" class="hide text-success">&#10003; <?php esc_html_e('Valid','pz-frontend-manager') ?></span>
	<span id="error-msg" class="text-danger"></span>
	<?php
	echo ob_get_clean();
}
add_action( 'pzfm_field_generator_after_label_phone', 'pzfm_registration_phone_error', 10, 2 );

add_action( 'gsfd_posts_table_filter', 'gsfd_posts_table_filter_status' );
function gsfd_posts_table_filter_status(){
    $status_filter 	= pzfm_parameters( 'status' ) ? : ''; 
    $post_status 	= array('publish' => 'Published','draft'=> 'Draft');
    ?>
    <select name="status" class="form-control" aria-describedby="basic-addon2">
        <option value="" disabled selected><?php esc_html_e( 'Status', 'pz-frontend-manager' ); ?></option>
        <?php if($post_status): ?>
            <?php foreach( $post_status as $status_slug => $status_name ): ?>
                <option value="<?php echo esc_attr( $status_slug ); ?>" <?php echo $status_slug == $status_filter ? 'selected' : ''; ?>><?php echo esc_html( $status_name ); ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <?php
}
add_filter( 'pzfm_post_query', 'pzfm_post_query_status' );
function pzfm_post_query_status( $args ){
    if( pzfm_parameters( 'status' ) && !empty( pzfm_parameters( 'status' ) ) ){
        $args['post_status'] = pzfm_parameters( 'status' );
    }
    return $args;
}
function pzfm_save_capability_settings_callback( $data ){
	$post_caps = pzfm_post_capabilities();
	$user_caps = pzfm_user_capabilities();

	// Saving post capabilities
	if( is_array( $post_caps ) && !empty( $post_caps ) ){
		foreach( array_keys( $post_caps ) as $cap ) {
			if( !array_key_exists( $cap, $data ) ){
				update_option( $cap, array() );
				continue;
			}
			update_option( $cap, (array)$data[$cap] );
		}
	}
	// Saving user capabilities
	if( is_array( $user_caps ) && !empty( $user_caps ) ){
		foreach( array_keys( $user_caps ) as $cap ) {
			if( !array_key_exists( $cap, $data ) ){
				update_option( $cap, array() );
				continue;
			}
			update_option( $cap, (array)$data[$cap] );
		}
	}
}
add_action( 'pzfm_after_save_settings', 'pzfm_save_capability_settings_callback');
add_action('pzfm_after_save_admin_settings', 'pzfm_save_userrole_editor');
function pzfm_save_userrole_editor($data){
    /*User Roles Editor*/
    global $wp_roles;
   $other_roles = pzfm_get_editable_roles();
    
    $all_lists = array();
    $list_roles = $wp_roles->roles;
    foreach($list_roles as $list_roles_key => $list_roles_val){
        $all_lists[$list_roles_key] = $list_roles_val['name'];
    }
    $all_roles = array_merge($all_lists, $other_roles);
    unset($all_roles['administrator']);
    
    if( isset( $data['gsfd_role_editor'] ) && !empty( $data['gsfd_role_editor'] ) ){
        $current_roles = array();
        foreach( $data['gsfd_role_editor'] as $setting_role ){
            $role_name          = !empty( $setting_role['pzfm-role-name'] ) ? $setting_role['pzfm-role-name'] : '';
            $role_slug          = !empty( $setting_role['pzfm-role-slug'] ) ? $setting_role['pzfm-role-slug'] : pzfm_slugify( $role_name );
            $role_read          = !empty( $setting_role['pzfm-role-read-cap'] ) ? $setting_role['pzfm-role-read-cap'][0] : '';
            $role_write         = !empty( $setting_role['pzfm-role-write-cap'] ) ? $setting_role['pzfm-role-write-cap'][0] : '';
            $role_upload        = !empty( $setting_role['pzfm-role-upload-cap'] ) ? $setting_role['pzfm-role-upload-cap'][0] : '';
            $current_roles[]    = $role_slug;
            if( array_key_exists( $role_slug, $all_roles ) ){
                $wp_roles->roles[$role_slug]['name'] = $role_name;
            }else{
                add_role(
                    $role_slug,
                    $role_name,
                    array(
                        'read'          => $role_read == 1 ? true : false,
                        'edit_posts'    => $role_write == 1 ? true : false, 
                        'upload_files'  => $role_upload == 1 ? true : false
                    )
                );
            }
        }
        foreach( array_keys($all_roles) as $role_key ){ 
              if(!in_array($role_key, $current_roles )){
                    remove_role($role_key);
              }
        }
    }
}
add_filter('pzfm_login_url','pzfm_custom_loggedin_url');
function pzfm_custom_loggedin_url($url){
    $pages 		= pzfm_custom_logredirect_pages();
	if( empty($pages) ){
		return $url;
	}
    if(!is_user_logged_in() && is_page( array_values($pages) )){
        $uri_path 		= parse_url( sanitize_text_field( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH);
        $uri_segments 	= explode('/', $uri_path);
        if($uri_segments[2]){
            $url = home_url('/'.$uri_segments[1].'/login/');
        }else{
            $url = apply_filters(  'gsfd_created_login_url' ,home_url('/login/'));
        }
    }
    return $url;
}
add_filter('pzfm_register_url','pzfm_custom_register_url');
function pzfm_custom_register_url($url){
	$pages 		= pzfm_custom_logredirect_pages();
	if( empty($pages) ){
		return $url;
	}

    if(!is_user_logged_in() && is_page( array_values($pages) )){
        $uri_path 		= parse_url( sanitize_text_field( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH);
        $uri_segments 	= explode('/', $uri_path);
        if($uri_segments[2]){
            $url = home_url('/'.$uri_segments[1].'/register/');
        }else{
            $url = home_url('/register/');
        }
    }
    return $url;
}
add_filter('pzfm_logout_url', 'pzfm_new_logout_redirect');
function pzfm_new_logout_redirect($url){
    return home_url();
}
add_filter( 'tiny_mce_before_init', 'changeMceDefaults' );
function changeMceDefaults($in) {
    $in['theme_advanced_buttons1'] = 'bold,italic,underline,bullist,numlist,hr,blockquote,link,unlink,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent';         
    $in['theme_advanced_buttons2'] = 'formatselect,pastetext,pasteword,charmap,undo,redo';
    $in[ 'wordpress_adv_hidden' ] = FALSE;
    return $in;
}
// Saving User avatar
function is_pzfm_base64($s){
    // Check if there are valid base64 characters
    if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

    // Decode the string in strict mode and check the results
    $decoded = base64_decode($s, true);
    if(false === $decoded) return false;

    // Encode the string again
    if(base64_encode($decoded) != $s) return false;

    return true;
}
function pzfm_after_save_contact_avatar_callback( $post_data, $user_id  ){
	if( ! array_key_exists( 'pzfm_avatar_id',  $post_data ) || ! (int)$post_data['pzfm_avatar_id'] ){
		return;
	}
	$avatar_url = wp_get_attachment_url( (int)$post_data['pzfm_avatar_id'] );
	update_user_meta( $user_id, 'pzfm_user_avatar', $avatar_url );

}
add_action( 'pzfm_after_save_contact', 'pzfm_after_save_contact_avatar_callback', 10, 2 );