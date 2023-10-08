<?php
require_once( PZ_FRONTEND_MANAGER_PATH . 'admin/includes/function-fields.php' );
function pzfm_registered_scripts(){
	$pzfm_registered_scripts = array(
		'pzfm-datepicker-script',
		'wp-color-picker',
		'pzfm-bootstrap-script',
		'pzfm-popper-min',
		'pzfm-bootstrap-bundle-scripts',
		'pzfm-repeater',
		'pzfm-sortable',
		'pzfm-bootstrap-admin',
		'pzfm-croppie-script',
		'pzfm-select2-script',
		'pzfm-scripts',
		'pzfm-ajax',
		'pzfm-chart',
		'pzfm-slick-script',
		'pzfm-spectrum-script',
		'pzfm-intlTelInput-script-js',
		'jquery', 
		'wp-mediaelement',
		'media-editor',
		'media-audiovideo'
	);
	return apply_filters( 'pzfm_registered_scripts', $pzfm_registered_scripts);
}
function pzfm_registered_styles(){
    $pzfm_registered_styles = array(
        'wp-color-picker',
        'pzfm-datepicker-style',
        'pzfm-bootstrap',
        'pzfm-fontawesome',
        'pzfm-select2-style',
        'pzfm-croppie-style',
        'pzfm-style',
        'pzfm-slick-style',
        'pzfm-spectrum-style',
        'pzfm-intlTelInput-style',
        'media-views',
        'imgareaselect'
    );
    return apply_filters( 'pzfm_registered_styles', $pzfm_registered_styles );
}
function pzfm_registered_plugins(){
	$pzfm_registered_plugins = array(
        'genesis-frontend-dashboard/genesis-frontend-dashboard.php',
        'wp-mail-smtp/wp_mail_smtp.php',
    );
	return apply_filters( 'pzfm_registered_plugins', $pzfm_registered_plugins );
}
/* GENERAL FUNCTIONS */
function pzfm_post_table_columns(){
	$columns = array(
		'title' 			=> __('Title', 'pz-frontend-manager'),
		'author' 			=> __('Author', 'pz-frontend-manager'),
		'categories' 		=> __('Categories', 'pz-frontend-manager'),
		'tags' 				=> __('Tags', 'pz-frontend-manager'),
		'date' 				=> __('Date', 'pz-frontend-manager')
	);
	return apply_filters( 'pzfm_post_table_columns', $columns );
}
function pzfm_table_actions(){
	return array(
		'view' 		=> __( 'View', 'pz-frontend-manager'),
		'edit' 		=> __( 'Edit', 'pz-frontend-manager'),
		'delete' 	=> __( 'Delete', 'pz-frontend-manager')
	);
}
function pzfm_table_bulk_actions(){
	return array(
		'delete' 	=> __( 'Delete', 'pz-frontend-manager')
	);
}
function pzfm_clean_url_parameter( $exclude_array = array() ){
    $query_array    = explode( '&', $_SERVER['QUERY_STRING'] );
    $filtered_query = array();
    if( empty( $query_array ) || empty($exclude_array) ){
        return false;
    }
    foreach ($query_array as $value) {
        $keyvalue_pairs = explode( '=', $value );
        if( in_array( $keyvalue_pairs[0], $exclude_array ) ){
            continue;
        }
        $filtered_query[] = $value;
    }
    return implode('&', $filtered_query );
}
function pzfm_category_dropdown( $type = 'category', $name = 'cat', $class = '' ){
	$terms = get_terms( $type, array(
		'hide_empty' => true,
	) );
	if( !$terms ){
		return false;
	}
	ob_start();
	$tax = isset( $_GET[$name] ) ? (int)$_GET[$name] : 0 ;
	?>
	<select class="custom-select <?php echo esc_attr( $class ); ?>" name="<?php echo esc_attr( $name ); ?>" id="tax_<?php echo esc_attr( $type ); ?>">
		<option selected value="0"><?php esc_html_e( 'All Categories', 'pz-frontend-manager' ); ?></option>
		<?php foreach ($terms as $term ): ?>
		<option value="<?php echo (int)$term->term_id; ?>" <?php selected( $tax, $term->term_id ); ?>><?php echo esc_html( $term->name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
	return ob_get_clean();
}
function pzfm_months_dropdown( $post_type = 'post', $class = '' ) {
	global $wpdb, $wp_locale;

	/**
	 * Filters whether to remove the 'Months' drop-down from the post list table.
	 */
	if ( apply_filters( 'disable_months_dropdown', false, $post_type ) ) {
		return;
	}

	/**
	 * Filters whether to short-circuit performing the months dropdown query.
	 */
	$months = apply_filters( 'pre_months_dropdown_query', false, $post_type );

	if ( ! is_array( $months ) ) {
		$extra_checks = "AND post_status != 'auto-draft'";
		if ( ! isset( $_GET['post_status'] ) || 'trash' !== $_GET['post_status'] ) {
			$extra_checks .= " AND post_status != 'trash'";
		} elseif ( isset( $_GET['post_status'] ) ) {
			$extra_checks = $wpdb->prepare( ' AND post_status = %s', sanitize_text_field( $_GET['post_status'] ) );
		}

		$months = $wpdb->get_results(
			$wpdb->prepare(
				"
			SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
			FROM $wpdb->posts
			WHERE post_type = %s
			$extra_checks
			ORDER BY post_date DESC
		",
				$post_type
			)
		);
	}

	/**
	 * Filters the 'Months' drop-down results.
	 */
	$months = apply_filters( 'months_dropdown_results', $months, $post_type );

	$month_count = count( $months );

	if ( ! $month_count || ( 1 == $month_count && 0 == $months[0]->month ) ) {
		return;
	}
	$m = isset( $_GET['ym'] ) ? (int) $_GET['ym'] : 0;
	ob_start();
	?>
	<select name="ym" id="filter-by-date" class="custom-select <?php echo esc_attr( $class ); ?>">
		<option selected value="0"><?php esc_html_e( 'All Dates', 'pz-frontend-manager' ); ?></option>
		<?php
		foreach ( $months as $arc_row ) {
			if ( 0 == $arc_row->year ) {
				continue;
			}

			$month = zeroise( $arc_row->month, 2 );
			$year  = $arc_row->year;

			printf(
				"<option %s value='%s'>%s</option>\n",
				selected( $m, $year . $month, false ),
				esc_attr( $arc_row->year . $month ),
				/* translators: 1: Month name, 2: 4-digit year. */
				sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $month ), $year )
			);
		}
		?>
	</select>
	<?php
	return ob_get_clean();
}
function pzfm_default_address(){
	return apply_filters( 'pzfm_default_address', '3rd flr, Golden AC Business Centre, 425 E Lopez St, Jaro, Iloilo City, 5000 Iloilo' );
}	
function can_access_user_role(){
	$roles = array( 'administrator' );
	$can_access_general_role = apply_filters( 'can_access_user_role', $roles );
	if( array_intersect( pzfm_current_user_role(), $can_access_general_role ) ){
		return true;
	}else{
		return false;
	}
}
function pzfm_include_template( $file_name ){
	$template_path  = PZ_FRONTEND_MANAGER_TEMPLATE_PATH .$file_name.'.php';
	return apply_filters( 'pzfm_template_'.$file_name, $template_path );
}
function pzfm_slugify($string){
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}
function pzfm_generate_numbers(){ 
    $numdigit  	= 8;
	$numstr = '';
	for ( $i = 1; $i < $numdigit; $i++ ) {
		$numstr .= 9;
	}
	$pzfm_generate_numbers = str_pad( wp_rand( 0, $numstr ), $numdigit, "0", STR_PAD_LEFT );
	return $pzfm_generate_numbers;
}
function pzfm_user_activated( $user_id ){
	$activated = get_user_meta( $user_id, 'account_activated', true) ? : false;
	return $activated;
}
function pzfm_register_url(){
	$url = get_permalink( pzfm_dashboard_page() ).'?register=true';
	return apply_filters( 'pzfm_register_url', $url ); 
}
function pzfm_logout_banner(){
	$data = '';
	return apply_filters( 'pzfm_logout_banner', $data ); 
}
function pzfm_logout_url(){
	$url = get_permalink( pzfm_dashboard_page() );
	return apply_filters( 'pzfm_logout_url', $url );
}
function pzfm_login_url(){
	$url = get_permalink( pzfm_dashboard_page() );
	return apply_filters( 'pzfm_login_url', $url ); 
}
function pzfm_lost_password_url(){
	$url = get_permalink( pzfm_dashboard_page() ).'?lostpassword=true';
	return apply_filters( 'pzfm_lost_password_url', $url ); 
}
function pzfm_map_integ(){
	return get_option( 'pzfm-map-integ' );
}
function pzfm_api_key(){
	return get_option( 'pzfm-api-key' );
}
function pzfm_autocomplete_countries(){
	$countries = array();
	if( !empty( get_option( 'pzfm_autocomplete_countries' ) )){
		$countries = get_option( 'pzfm_autocomplete_countries' );
	}
	return $countries;
}
function pzfm_recaptcha_active(){
	return get_option( 'pzfm-enable-recaptcha' );
}
function pzfm_captcha_site_key(){
	return get_option( 'pzfm-captcha-site-key' );
}
function pzfm_captcha_secret_key(){
	return get_option( 'pzfm-captcha-secret-key' );
}
function pzfm_registration(){
	return get_option( 'pzfm-registration' );
}
function pzfm_activation(){
	return get_option( 'pzfm-activation' );
}
function pzfm_bg_login(){
	return get_option( 'pzfm-background-login' );
}
function pzfm_bg_login_settings(){
	return get_option( 'pzfm-bg-login-settings' );
}
function pzfm_bg_login_default_title(){
	return get_option( 'default-bg-title' );
}
function pzfm_bg_login_default_description(){
	return get_option( 'default-bg-description' );
}
function pzfm_display_logo(){
	return get_option( 'pzfm-display-logo' );
}
function pzfm_announcement(){
	return get_option( 'pzfm-announcement' );
}
function pzfm_post_status(){
	return get_option( 'pzfm_post_status' );
}
function pzfm_banner_slider(){
	return get_option( 'pzfm_banner_slider' );
}
function pzfm_banner_slider_settings(){
	return get_option( 'pzfm_banner_slider_settings' );
}
function pzfm_banner_slider_type(){
	return get_option( 'pzfm-banner-dashboard-type' );
}
function pzfm_default_dash_layout(){
	return get_option( 'pzfm-default-dash-page' );
}
function pzfm_dashboard_cards(){
	return ( !empty( get_option( 'pzfm_dash_cards' ) ) ) ? get_option( 'pzfm_dash_cards' ) : array();
}
function pzfm_phone_country_code(){
	$country_code = get_option( 'pzfm-country-code' );
	return $country_code ? $country_code : 'us';
}
function pzfm_option_country_default(){
	$country_code = get_option( 'pzfm-country-default' );
	return $country_code ? $country_code : 'US';
}
function pzfm_author_id($post_id){
	$author_id = get_post_field( 'post_author', $post_id );
	return (!empty($author_id)) ? $author_id : '';
}
function pzfm_checkout(){
	$checkout_page = get_option( 'woocommerce_checkout_page_id' );
	if( $checkout_page == get_the_ID() && is_page_template( 'dashboard.php' ) ){
		return true;	
	}else{
		return false;
	}
}
function pzfm_determine_url($url){
	$url = filter_var($url, FILTER_SANITIZE_URL);
	if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
		return true;
	}else{
		return false;
	}
}
function pzfm_activation_email( $detail ){
	$email_details = get_option( 'pzfm-activation-email' );
	if( ! $email_details || ! is_array( $email_details ) || ! array_key_exists( $detail, $email_details ) ){
		return false;
	}
	return $email_details[$detail];
}
function pzfm_get_uid_email( $email ){
	$user 	 = get_user_by( 'email', $email );
	$user_id = ( !empty( $user ) ) ? $user->ID : '';
	return $user_id;
}
function pzfm_get_uid_login( $login ){
	$user 	 = get_user_by( 'login', $login );
	$user_id = ( !empty( $user ) ) ? $user->ID : '';
	return $user_id;
}
function pzfm_custom_logredirect_pages(){
	$login 		= get_page_by_path('login');
    $register 	= get_page_by_path('register');
	$pages 		= array();
	if( $login ){
		$pages['login'] = $login->ID;
	}
	if( $register ){
		$pages['register'] = $register->ID;
	}
	return $pages;
}
function pzfm_get_email_user($login){
    $user = get_user_by( 'login', $login );
	if( !$user ){
		return false;
	}
    $user_email = $user->user_email;
    return $user_email;
}

function pzfm_country_name( $code ){
    $country_list = pzfm_country_list();
    return $country_list[$code];
}
function pzfm_dashboard_count( $type ){
	if( $type == 'posts' ){
		$args = array(
			'post_type' => 'post',
			'post_status' => array('publish'),
			'numberposts' => -1
		);
		if( !in_array( 'administrator', pzfm_current_user_role() ) ){
			$args['author'] = get_current_user_id();
		}
		$num_count = !empty( get_posts( $args ) ) ? count( get_posts( $args ) ) : 0;
	}
	if( $type == 'users' ){
        $user_args = array( 
            'role__not_in'	=> 'administrator',
        );
		$num_count = !empty( get_users( $user_args ) ) ? count( get_users( $user_args ) ) : 0;
	}
    if( $type == 'user-pending' ){
		$user_args = array(
			'role__in'       => array( 'customer', 'subscriber' ),
            'meta_key'       => 'account_activated',
			'meta_compare'   => 'NOT EXISTS',
		);
		$num_count = count( get_users( $user_args ) ) != '' ? count( get_users( $user_args ) ) : 0;
	}
	return apply_filters( 'pzfm_dashboard_count', $num_count, $type );
}
function pzfm_signon( $username, $password, $remember_me = false ){
	return wp_signon( 
		array( 
			'user_login' 	=> $username, 
			'user_password' => $password,
			'remember'      => $remember_me
		)
	);
}
function pzfm_login_activate($email){
	$activate = get_user_meta( pzfm_get_uid_login( $email ), 'account_activated', true );
	return $activate;
}
function pzfm_base_color(){
	$color = '#06aff2';
	if( !empty( get_option( 'pzfm_base_color' ) ) ){
		$color = get_option( 'pzfm_base_color' );
	}
	$color = apply_filters( 'pzfm_base_color', $color );
	return $color;
}
function pzfm_icon_color(){
	$color = '#06aff2';
	if( !empty( get_option( 'pzfm_base_color' ) ) ){
		$color = get_option( 'pzfm_base_color' );
	}
	$color = apply_filters( 'pzfm_icon_color', $color );
	return $color;
}
function pzfm_default_user_role(){
	$default_user_role = 'subscriber';
	if( !empty( get_option( 'pzfm_default_user_role' ) ) ){
		$default_user_role = get_option( 'pzfm_default_user_role' );
	}
	return apply_filters( 'pzfm_default_user_role', $default_user_role );
}

function pzfm_parameters($parameters){
	if(isset($_GET[$parameters]) && !empty($_GET[$parameters])){
		return $_GET[$parameters];
	}else{
		return '';
	}
}
/* USERS DATA FUNCTIONS */
function pzfm_email_logo( ){
	$logo 	= pzfm_dashboard_logo();
	return apply_filters( 'pzfm_email_logo', $logo);
}
function pzfm_email_color( ){
	$color = pzfm_base_color();
	return apply_filters( 'pzfm_email_color', $color);
}

function pzfm_user_avatar( $size = 128, $class = "photo-inner" ){
    $current_user = wp_get_current_user();
    echo get_avatar( $current_user->ID, $size, '', '', array( 'class'=> $class ) );
}

function pzfm_user_avatar_url( $user_id = false ){
	$user_id 		= $user_id ? $user_id : 0;
	$user_avatar 	= get_user_meta($user_id, 'pzfm_user_avatar', true);
	$avatar_url 	= $user_avatar ? $user_avatar : get_avatar_url( $user_id );
	return apply_filters( 'pzfm_user_avatar_url', $avatar_url );
}
function pzfm_current_user_role(){
	$user_role = array();
	if( is_user_logged_in() ){
		$user_id = get_current_user_id();
		$user_data = get_userdata( $user_id );
		$user_role = $user_data->roles;
	}
	return $user_role;
}
function pzfm_countby_userRoles($role_slug){
    $args = array(
        'role'    => $role_slug,
        'orderby' => 'user_nicename',
        'order'   => 'ASC'
    );
    $pzfm_role_count = count(get_users( $args ));
    return $pzfm_role_count;
}
function pzfm_get_all_roles(){
	global $wp_roles;
	$all_roles = $wp_roles->roles;
	$roles = array();
	$all_roles = apply_filters( 'pzfm_get_all_roles', $all_roles );
	foreach( $all_roles as $role_slug => $role_data ){
		if( $role_slug != 'administrator' ){
			$roles[$role_slug] = $role_data['name'];
		}
	}
	return apply_filters( 'pzfm_role_lists_name' , $roles );
}
function pzfm_user_ip(){
    if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $user_ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $user_ip = $_SERVER['REMOTE_ADDR'];
    }
    return $user_ip;
}
function pzfm_user_full_name( $user_id ){
	$user_firstname = get_user_meta( $user_id, 'first_name', true );
	$user_lastname = get_user_meta( $user_id, 'last_name', true );
	$user_fullname = '';
	if( !empty( $user_firstname ) && !empty( $user_lastname ) ){
		$user_name_results = $user_firstname.' '.$user_lastname;
	}elseif( !empty( $user_firstname ) && empty( $user_lastname ) ){
		$user_name_results = $user_firstname;
	}elseif( empty( $user_firstname ) && !empty( $user_lastname ) ){
		$user_name_results = $user_lastname;
	}else{
		$user_data = get_userdata( $user_id );
		$user_name_results = $user_data->display_name;
	}
	return apply_filters( 'pzfm_user_full_name', $user_name_results, $user_id );
}
function pzfm_get_users( $role ){
	$args = array(
		'role__not_in'	=> 'administrator',
		'orderby'		=> 'user_nicename',
		'order'			=> 'ASC'
	);
	if( !empty( $role ) ){
		$args['role__in'] = $role;
	}
	$args = apply_filters( 'pzfm_get_users', $args );
	$users = get_users( $args );
	if( !empty( $users ) ){
		$get_users = array();
		foreach( $users as $user ){
			$get_users[$user->ID] =  pzfm_user_full_name( $user->ID );
		}
	}
	return $get_users;
}
function pzfm_user_role( $user_id = null ){
	$user_data = get_userdata( (int)$user_id );
	if( $user_data ){
		$user_role = ( array ) $user_data->roles;
		return $user_role;
	}
	return null;
}
function pzfm_settings_template(){
	return apply_filters( 'pzfm_settings_template', array() );
}
/* DASHBOARD FUNCTIONS */
function pzfm_dashboard_page_id(){
	global $wpdb;
    $sql = "SELECT ID FROM {$wpdb->posts} AS tblpost INNER JOIN {$wpdb->postmeta} AS tblmeta ON tblpost.ID = tblmeta.post_id WHERE tblpost.post_status LIKE 'publish' AND tblpost.post_status LIKE 'publish' AND tblmeta.meta_key LIKE '_wp_page_template' AND tblmeta.meta_value LIKE 'dashboard.php' LIMIT 1";
	return $wpdb->get_var( $sql );
}

function pzfm_dashboard_page(){
	$get_dashboard_page = get_option( 'pzfm_dashboard' ) ? get_option( 'pzfm_dashboard' ) : 0;
	return $get_dashboard_page;
}
function pzfm_current_page_url(){
    $currentPage_url = get_the_permalink( get_the_ID() );
    if( isset( $_GET['dashboard'] ) ){
        $currentPage_url = get_the_permalink( pzfm_dashboard_page() ).'?dashboard='. sanitize_text_field( $_GET['dashboard'] );
    }
    return $currentPage_url;
}
function pzfm_dashboard_logo(){
	$get_dashboard_logo = PZ_FRONTEND_MANAGER_URL . 'assets/images/placeholder-logo.png';
	if( !empty( get_option( 'pzfm_site_logo' ) ) ){
		$get_dashboard_logo = get_option( 'pzfm_site_logo' );
	}
	return apply_filters( 'get_dashboard_logo', $get_dashboard_logo );
}
function pzfm_login_dashboard_background(){
	$get_login_background = PZ_FRONTEND_MANAGER_URL . 'assets/images/background-banner.jpg';
	if( !empty( get_option( 'pzfm_login_background' ) ) ){
		$get_login_background = get_option( 'pzfm_login_background' );
	}
	return $get_login_background;
}
function pzfm_get_post_id_by_reverse($key, $value) {
	global $wpdb;
	$sql = "SELECT * FROM `{$wpdb->postmeta}` WHERE meta_key LIKE %s AND meta_value LIKE %s";
	$meta = $wpdb->get_results( $wpdb->prepare( $sql, sanitize_text_field( $key ), sanitize_text_field( $value ) ) );
	if (is_array($meta) && !empty($meta) && isset($meta[0])) {
		$meta = $meta[0];
	}if (is_object($meta)) {
		return $meta->post_id;
	}else{
		return false;
	}
}
// DASHBOARD MENUS
function pzfm_after_sidebar_menu_items(){
	$menu_items = array();
	if( pzfm_can_manage_posts() ){
		$menu_items[pzfm_posts_page()] = array(
			'title'		=> pzfm_posts_label(),
			'permalink' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page(),
			'icon' 		=> pzfm_posts_icon(),
			'submenu'   => false,
			'submenu_items' => array()
		);
		if( in_array( 'administrator', pzfm_current_user_role() ) ){
			$menu_items[pzfm_posts_page()]['submenu'] = true;
			$menu_items[pzfm_posts_page()]['submenu_items'] = array( esc_html__( 'Manage ', 'pz-frontend-manager' ).pzfm_posts_label(), esc_html__( 'Categories', 'pz-frontend-manager' ), esc_html__( 'Tags', 'pz-frontend-manager' ) );
		}
	}
	if( can_access_pzfm_users() ){
		$menu_items[pzfm_users_page()] = array(
			'title'		=> pzfm_users_label(),
			'permalink' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page(),
			'icon' 		=> 'fas fa-users pzfm-icon-color',
			'submenu'   => false,
			'submenu_items' => array()
		);
	}
	return apply_filters( 'pzfm_after_sidebar_menu_items', $menu_items );
}

// DASHBOARD CARDS
function pzfm_after_dashboard_cards_items(){
	$dashboard_items = array();
	if( can_access_pzfm_users() ){
		$dashboard_items['pzfm_dashboard_'.pzfm_users_page()] = array(
			'title'		=> pzfm_users_label(),
			'permalink' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page(),
			'icon' 		=> 'fas fa-users pzfm-icon-color',
			'colg' 		=> 'col-md-3',
			'description'  => '',
			'count'  	 => pzfm_dashboard_count('users'),
			'visibility' => true
		);
	}
	if( pzfm_can_manage_posts() ){
		$dashboard_items['pzfm_dashboard_'.pzfm_posts_page()] = array(
			'title'		=> pzfm_posts_label(),
			'permalink' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page(),
			'icon' 		=> 'fas fa-lightbulb pzfm-icon-color',
			'colg' 		=> 'col-md-3',
			'description'  => '',
			'count'  	 => pzfm_dashboard_count( 'posts' ),
			'visibility' => true,
		);
	}
	if( pzfm_parameters('dashboard') != 'settings'){
		foreach( pzfm_dashboard_cards() as $dashboard_unset ){
			unset($dashboard_items[$dashboard_unset]);
		}
	}
	return apply_filters( 'pzfm_dashboard_cards_items', $dashboard_items );
}
/* SETTINGS FUNCTIONS */
function can_access_pzfm_settings(){
	$can_access_pzfm_settings = array( 'administrator' );
	if( !empty( get_option( 'can_access_pzfm_settings' ) ) ){
		$can_access_pzfm_settings = array_merge( $can_access_pzfm_settings, get_option( 'can_access_pzfm_settings' ) );
	}
	if( array_intersect( pzfm_current_user_role(), $can_access_pzfm_settings ) ){
		return true;
	}else{
		return false;
	}
}

/* USERS USERS PERMISSION FUNCTIONS */
function is_pzfm_admin_user(){
	if( in_array( 'administrator', pzfm_current_user_role() ) ){
		return true;
	}
	return false;
}
function can_assign_user_role(){
	$can_assign_user_role = array( 'administrator' );
	if( !empty( get_option( 'can_access_pzfm_contacts_role' ) ) ){
		$can_assign_user_role = array_merge( $can_assign_user_role, get_option( 'can_access_pzfm_contacts_role' ) );
	}
	if( array_intersect( pzfm_current_user_role(), $can_assign_user_role ) ){
		return true;
	}
	return false;
}
function can_access_pzfm_users(){
	if( pzfm_can_add_user() || pzfm_can_edit_user() || pzfm_can_delete_user() ){
		return true;
	}
	return false;
}
function can_access_pzfm_user_actions(){
	if( pzfm_can_edit_user() || pzfm_can_delete_user() ){
		return true;
	}
	return false;
}
function pzfm_can_add_user_roles(){
	$roles 		= get_option( 'pzfm_can_add_user', array() );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_add_user_roles', $roles );
}
function pzfm_can_add_user(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_add_user_roles() ) ? true : false;
	return apply_filters( 'pzfm_can_add_user', $access );
}
function pzfm_can_edit_user_roles(){
	$roles 		= get_option( 'pzfm_can_edit_user', array() );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_edit_user_roles', $roles );
}
function pzfm_can_edit_user(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_edit_user_roles() ) ? true : false;
	return apply_filters('pzfm_can_edit_user', $access );
}
function pzfm_can_delete_user_roles(){
	$roles 		= get_option( 'pzfm_can_delete_user', array() );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_delete_user_roles', $roles );
}
function pzfm_can_delete_user(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_delete_user_roles() ) ? true : false ;
	return apply_filters( 'pzfm_can_delete_user', $access );
}
function pzfm_can_assign_role_roles(){
	$roles 		= get_option( 'pzfm_can_assign_role', array() );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_assign_role_roles', $roles );
}
function pzfm_can_assign_role(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_assign_role_roles() ) ? true : false ;
	return apply_filters( 'pzfm_can_assign_role', $access );
}
function can_modify_pzfm_users( $role ){
    $can_modify_user = array( 'administrator' );
	if( !empty( get_option( 'can_modify_'.$role ) ) ){
		$can_modify_user = array_merge( $can_modify_user, get_option( 'can_modify_'.$role ) );
	}
	if( array_intersect( pzfm_current_user_role(), $can_modify_user ) ){
		return true;
	}else{
		return false;
	}
}
function is_user_post( $post_id, $user_id, $post_type = 'post' ){
	global $wpdb;
	if( is_pzfm_admin_user() ){
		return true;
	}
	$sql = "SELECT `ID` FROM {$wpdb->posts} WHERE `ID` = %d AND `post_author` = %d AND `post_type` LIKE %s LIMIT 1";
	return $wpdb->get_var( $wpdb->prepare( $sql, (int)$post_id, (int)$user_id, sanitize_text_field( $post_type ) ) );
}
function pzfm_can_manage_posts_roles(){
	$roles 		= get_option( 'pzfm_can_manage_posts' );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_manage_posts_roles', $roles );
}
function pzfm_can_manage_posts(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_manage_posts_roles() ) ? true : false;
	return apply_filters( 'pzfm_can_manage_posts', $access );
}
function pzfm_can_add_post_roles(){
	$roles 		= get_option( 'pzfm_can_add_post' );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_add_post_roles', $roles );
}
function pzfm_can_add_post(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_add_post_roles() ) ? true : false;
	return apply_filters( 'pzfm_can_add_post', $access );
}
function pzfm_can_edit_post_roles(){
	$roles 		= get_option( 'pzfm_can_edit_post', array() );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_edit_post_roles', $roles );
}
function pzfm_can_edit_post(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_edit_post_roles() ) ? true : false ;
	return apply_filters( 'pzfm_can_edit_post', $access );
}
function pzfm_can_delete_post_roles(){
	$roles 		= get_option( 'pzfm_can_delete_post', array() );
	$roles[] 	= 'administrator';
	return apply_filters( 'pzfm_can_delete_post_roles', $roles );
}
function pzfm_can_delete_post(){
	$access = array_intersect( pzfm_current_user_role(), pzfm_can_delete_post_roles() ) ? true : false ;
	return apply_filters('pzfm_can_delete_post', $access);
}
/* END USERS PERMISSION FUNCTIONS */
function pzfm_post_bg_image($post_id){
	$default_image 	= PZ_FRONTEND_MANAGER_ASSETS_PATH.'images/post-placeholder.png';
	$post_image_id 	= get_post_thumbnail_id( $post_id );
	$post_image 	= (!empty($post_image_id)) ? wp_get_attachment_url($post_image_id) : $default_image;
	return $post_image;
}

function pzfm_post_capabilities(){
	$cap = array(
		'pzfm_can_manage_posts' => esc_html__('Can manage posts', 'pz-frontend-manager' ), 
	);
	return apply_filters( 'pzfm_post_capabilities', $cap );
}
function pzfm_user_capabilities(){
	$cap = array(
		'pzfm_can_add_user' => esc_html__('Can add user', 'pz-frontend-manager' ), 
		'pzfm_can_edit_user' => esc_html__('Can edit user', 'pz-frontend-manager' ), 
		'pzfm_can_delete_user' => esc_html__('Can delete user', 'pz-frontend-manager' ), 
		'pzfm_can_assign_role' => esc_html__('Can assign role', 'pz-frontend-manager' )
	);
	return apply_filters( 'pzfm_user_capabilities', $cap );
}

function pzfm_capabilities_array(){
	$cap = array(
		'post' => array(
			'label' => esc_html__('Posts', 'pz-frontend-manager' ),
			'options' => pzfm_post_capabilities()
		),
		'user' => array(
			'label' => esc_html__('Users', 'pz-frontend-manager' ),
			'options' => pzfm_user_capabilities()
		)
	);
	return apply_filters( 'pzfm_capabilities_array', $cap );
}
function pzfm_random_password(){
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
function pzfm_add_prefix( $count ){
	$prefix = '';
	for ($i=1; $i <= $count ; $i++) { 
		$prefix .= '-';
	}
	return $prefix;
}
function pzfm_get_terms( $taxonomy, $parent = false ){
	$number 	= pzfm_parameters('action') ? false : 20; 
    $paged 		= (get_query_var('paged')) ? get_query_var('paged') : 1;
    $offset 	= ( $paged > 0 ) ?  $number * ( $paged - 1 ) : 1;
	$args 		= array(
		'orderby'    	=> 'name',
		'order'      	=> 'ASC',
		'hide_empty' 	=> 0,
		'parent'		=> $parent,
		'number'      	=> $number,
		'offset'      	=> $offset,
	);
	$args 		= apply_filters( 'pzfm_get_terms', $args );
	$get_terms 	= get_terms( $taxonomy, $args );
	return ( !empty( $get_terms ) ) ? $get_terms : array();
}
function pzfm_get_term_list( $taxonomy, $parent='' ){
    $args = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => 0,
		'parent'	=> $parent,
	);
	$args = apply_filters( 'pzfm_get_term_list', $args );
	$get_terms = get_terms( $taxonomy, $args );
    $term_list = array();
    if( !empty( $get_terms ) ){
        foreach( $get_terms as $term ){
            $term_list[$term->term_id] = $term->name;
        }
    }
    return $term_list;
}
function pzfm_get_post_categories(){
	$get_post_categories = get_categories( 
		array(
			'hide_empty' => false
		)
	);
	return apply_filters( 'pzfm_get_post_categories', $get_post_categories );
}

function pzfm_category_checklist( $post_id = null ){
	if ( ! function_exists( 'wp_terms_checklist' ) ) {
		include ABSPATH . 'wp-admin/includes/template.php';
	}
	?><ul id="pzfm-category_checklist"><?php
	wp_terms_checklist( $post_id );
	?></ul><?php
}
function pzfm_email_activation_content( $user_id, $logo, $color ){
	ob_start();
	require_once( pzfm_include_template( 'emails/email-admin-activation.tpl' ) ); 
	$message = ob_get_clean();
	return apply_filters( 'pzfm_email_activation_content', $message, $user_id ); 
}
function pzfm_tab($tab, $current_tab, $type ){
	if($type == 'tab_content'){
		$tabs = ($tab == $current_tab) ? 'active show' : '';
	}else{
		$tabs = ($tab == $current_tab) ? 'active' : '';
	}
	return $tabs;
}
function pzfm_loader(){
    ob_start();
    ?>
    <div class="loader-wrapper text-center mb-3" style="display: none;">
        <div class="spinner-grow text-pzfm" style="width: 15px; height: 15px;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-pzfm" style="width: 15px; height: 15px;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-pzfm" style="width: 15px; height: 15px;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-pzfm" style="width: 15px; height: 15px;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-pzfm" style="width: 15px; height: 15px;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
function gsfd_role_exists( $role ) {
  if( ! empty( $role ) ) {
    return $GLOBALS['wp_roles']->is_role( $role );
  }
  return false;
}
function pzfm_get_editable_roles() {
    global $wp_roles;
    $all_roles = $wp_roles->roles;
    $editable_roles = apply_filters('editable_roles', $all_roles);
    return apply_filters('pzfm_get_editable_roles',$editable_roles);
}
function pzfm_email_menu(){
	return apply_filters( 'pzfm_email_menu', array() );
}
function pzfm_spam_registration( $ip_address ){
	global $wpdb;
	// 1 hr  : 3600 sec
	// 10 min : 600 sec
	$sql = "SELECT tbluser.user_registered FROM {$wpdb->prefix}users AS tbluser";
	$sql .= " LEFT JOIN {$wpdb->prefix}usermeta AS tblmeta ON tbluser.ID = tblmeta.user_id";
	$sql .= " WHERE tblmeta.meta_key LIKE 'pzfm_user_ip' AND tblmeta.meta_value LIKE %s ORDER BY tbluser.ID DESC";
	$reg_time = $wpdb->get_var( $wpdb->prepare( $sql, sanitize_text_field( $ip_address ) ) );
	if( !$reg_time ){
		return false;
	}
	return current_time('timestamp') - strtotime( $reg_time ) < 600 ? true : false;
}
// Validate date string
function pzfm_validate_date($date, $format = 'Y-m-d')
{
    $dateObj = DateTime::createFromFormat($format, $date);
    return $dateObj && $dateObj->format($format) == $date;
}
// Plugin addons list
function pzfm_plugin_addons_list(){
	$bool = false;
	$addons = array(
		'pz-listing-booking/pz-listing-booking.php'
	);
	/**
	 * Conditional Statement
	 *
	 * @return bool
	 */
	if(array_intersect( apply_filters( 'pzfm_addons', $addons ), get_option( 'active_plugins' ) )){
		$bool = true;
	}
	return $bool;
}
// Plugin License Key Args
function pzfm_plugin_license_key(){
	ob_start();
	do_action( 'pzfm_plugin_license_key' );
	$content = ob_get_contents();
	ob_end_clean();
	$bool = false;
	if (!empty($content)) {
		$bool = true;
	}
	return $bool;
}
function pzfm_get_all_plugins(){
	$active_plugins = array();
	if(get_option('active_plugins', array())){
		$exclude_plugins = apply_filters('pzfm_exclude_plugins', array('woocommerce/woocommerce.php', 'pz-frontend-manager/pz-frontend-manager.php','pz-listing-booking/pz-listing-booking.php') );
		$active_plugins = array_diff(get_option('active_plugins', array()), $exclude_plugins);
	}
	return apply_filters('pzfm_get_all_plugins', $active_plugins);
}