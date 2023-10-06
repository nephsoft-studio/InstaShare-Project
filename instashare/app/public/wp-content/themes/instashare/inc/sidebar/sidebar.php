<?php	
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package instashare
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function instashare_widgets_init() {	
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'instashare' ),
		'id' => 'instashare-sidebar-primary',
		'description' => __( 'The Primary Widget Area', 'instashare' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title"><span></span>',
		'after_title' => '</h5>',
	) );
	

	register_sidebar( array(
		'name' => __( 'Footer 1', 'instashare' ),
		'id' => 'instashare-footer-1',
		'description' => __( 'The Footer Widget Area 1', 'instashare' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer 2', 'instashare' ),
		'id' => 'instashare-footer-2',
		'description' => __( 'The Footer Widget Area 2', 'instashare' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer 3', 'instashare' ),
		'id' => 'instashare-footer-3',
		'description' => __( 'The Footer Widget Area 3', 'instashare' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => __( 'WooCommerce Widget Area', 'instashare' ),
		'id' => 'instashare-woocommerce-sidebar',
		'description' => __( 'This Widget area for WooCommerce Widget', 'instashare' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Info Widget Area', 'instashare' ),
		'id' => 'instashare-info-sidebar',
		'description' => __( 'This Widget area for Info', 'instashare' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'instashare_widgets_init' );
?>