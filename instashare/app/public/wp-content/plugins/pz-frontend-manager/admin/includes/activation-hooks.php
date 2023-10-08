<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function pzfm_plugin_page_creation() {
  global $wpdb;
  if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'dashboard'" ) ) {
    $current_user = wp_get_current_user();
    $page = array(
      'comment_status' => 'closed',
      'ping_status'    => 'closed',
      'post_author'    => $current_user->ID,
      'post_date'      => date('Y-m-d H:i:s'),
      'post_name'      => 'dashboard',
      'post_status'    => 'publish',
      'post_title'     => 'Dashboard',
      'post_type'      => 'page',
    );
    
    $dashboard = wp_insert_post( $page, false  );
    update_option( 'pzfm_dashboard', $dashboard );
    update_post_meta( $dashboard, '_wp_page_template', 'dashboard.php' );
    update_user_meta( $current_user->ID, 'account_activated', 1 );

    if ( ! is_dir( WP_CONTENT_DIR . '/mu-plugins' ) ) {
      wp_mkdir_p( WP_CONTENT_DIR . '/mu-plugins' );

      $file 		= PZ_FRONTEND_MANAGER_PATH . 'admin/includes/mu-plugins/disable-plugins.php';
      $dir 		= WP_CONTENT_DIR . '/mu-plugins/';

      $dest = realpath($dir . DIRECTORY_SEPARATOR) . '/' . basename($file);
      copy($file, $dest);
    }
  }
  
  // Enable User Activation On
  update_option( 'pzfm-activation', 1 );
}
function pzfm_dashboard_page_notification(){
    $current_screen = get_current_screen();
    if( get_post( get_option('pzfm_dashboard') ) ){
        return false;
    }
    if( $current_screen && $current_screen->base == 'post' ){
        return false;
    }

    $class      = 'notice notice-error';
	$message    = __( 'PZ Frontend Manager dashboard is not set, please create page for the dashboard and set the template to "PZ Frontend Template" plugin may not work properly.', 'pz-frontend-manager' );
    $btn_label  = __( 'Create Dashboard page', 'pz-frontend-manager' );
    $link       = admin_url( 'post-new.php?post_type=page' );

	printf( '<div class="%1$s"><p>%2$s <a href="%3$s" class="button button-secondary">%4$s</a></p></div>', esc_attr( $class ), esc_html( $message ), esc_url($link), esc_html( $btn_label ) );
}
add_action( 'admin_notices', 'pzfm_dashboard_page_notification');


function pzfm__admin_bar_item ( WP_Admin_Bar $admin_bar ) {
    if( ! get_post( get_option('pzfm_dashboard') ) ){
        return false;
    }
    $args = array(
        'parent' => 'site-name',
        'id'     => 'pzfm-view-page',
        'title'  => __('Visit Frontend Dashboard', 'pz-frontend-manager'),
        'href'   => get_the_permalink( pzfm_dashboard_page() ),
        'meta'   => false        
    );
    $admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'pzfm__admin_bar_item', 500 );
function pzfm__dashboard_post_states( $states, $post ){
    if( $post->ID == get_option('pzfm_dashboard') ){
        $states[ 'pzfm__dashboard' ] = __( 'Frontend Dashboard', 'pz-frontend-manager' );
    }
    return $states;
}
add_filter( 'display_post_states', 'pzfm__dashboard_post_states', 10, 2 );

function pzfm_disable_plugin_deactivation( $actions, $plugin_file, $plugin_data, $context ) {
    if ( pzfm_plugin_addons_list() && array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file,
        array('pz-frontend-manager/pz-frontend-manager.php',)
       )
    )
    unset( $actions['deactivate'] );
    return $actions;
}
add_filter( 'plugin_action_links', 'pzfm_disable_plugin_deactivation', 10, 4 );