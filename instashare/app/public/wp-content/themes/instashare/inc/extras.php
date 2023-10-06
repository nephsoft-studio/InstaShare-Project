<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Instashare
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function instashare_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Parallax
	$footer_parallax_enable		= get_theme_mod('footer_parallax_enable','1');
	if($footer_parallax_enable=='1'):
		$classes[] = "footer-parallax";
	endif;
	
	return $classes;
}
add_filter( 'body_class', 'instashare_body_classes' );



if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Backward compatibility for wp_body_open hook.
	 *
	 * @since 1.0.0
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if (!function_exists('instashare_str_replace_assoc')) {

    /**
     * instashare_str_replace_assoc
     * @param  array $replace
     * @param  array $subject
     * @return array
     */
    function instashare_str_replace_assoc(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
}

// Instashare Navigation
if ( ! function_exists( 'instashare_primary_navigation' ) ) :
function instashare_primary_navigation() {
	wp_nav_menu( 
		array(  
			'theme_location' => 'primary_menu',
			'container'  => '',
			'menu_class' => 'menu-wrap',
			'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
			'walker' => new WP_Bootstrap_Navwalker()
			 ) 
		);
	} 
endif;
add_action( 'instashare_primary_navigation', 'instashare_primary_navigation' );


// Instashare Navigation Button
if ( ! function_exists( 'instashare_navigation_button' ) ) :
function instashare_navigation_button() {
	$instashare_hs_nav_btn 		= get_theme_mod( 'hide_show_nav_btn','1'); 
	$instashare_nav_btn_icon 		= get_theme_mod( 'nav_btn_icon','fa-code-fork');
	$instashare_nav_btn_lbl 		= get_theme_mod( 'nav_btn_lbl');
	$instashare_nav_btn_link 		= get_theme_mod( 'nav_btn_link');
	if($instashare_hs_nav_btn=='1'  && !empty($instashare_nav_btn_lbl)):	
?>
	<li class="av-button-area">
		<a href="<?php echo esc_url($instashare_nav_btn_link); ?>" class="av-btn av-btn-primary av-btn-bubble"><?php echo wp_kses_post($instashare_nav_btn_lbl); ?> <?php if(!empty($instashare_nav_btn_icon)): ?><i class="fa <?php echo esc_attr($instashare_nav_btn_icon); ?>"></i><?php endif; ?> <span class="bubble_effect"><span class="circle top-left"></span> <span class="circle top-left"></span> <span class="circle top-left"></span> <span class="button effect-button"></span> <span class="circle bottom-right"></span> <span class="circle bottom-right"></span> <span class="circle bottom-right"></span></span></a>
	</li>
<?php endif;
	} 
endif;
add_action( 'instashare_navigation_button', 'instashare_navigation_button' );



// Instashare Navigation Search
if ( ! function_exists( 'instashare_navigation_search' ) ) :
function instashare_navigation_search() {
	$instashare_hs_search 	= get_theme_mod( 'hide_show_search','1'); 
	if($instashare_hs_search=='1'):	
?>
<li class="search-button">
	<button id="view-search-btn" class="header-search-toggle"><i class="fa fa-search"></i></button>
	<div class="view-search-btn header-search-popup">
		<div class="search-overlay-layer"></div>
		<div class="header-search-pop">
			<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Site Search', 'instashare' ); ?>">
				<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'instashare' ); ?></span>
				<input type="search" class="search-field header-search-field" placeholder="<?php esc_attr_e( 'Type To Search', 'instashare' ); ?>" name="s" id="popfocus" value="" autofocus>
				<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
			</form>
			<button type="button" class="close-style header-search-close"></button>
		</div>
	</div>
</li>
<?php endif;
	} 
endif;
add_action( 'instashare_navigation_search', 'instashare_navigation_search' );



// Instashare Navigation Cart
if ( ! function_exists( 'instashare_navigation_cart' ) ) :
function instashare_navigation_cart() {
	$instashare_hs_cart 	= get_theme_mod( 'hide_show_cart','1'); 
		if($instashare_hs_cart=='1' && class_exists( 'WooCommerce' )):	
	?>
		<li class="cart-wrapper">
			<a href="javascript:void(0);" class="cart-icon-wrap" id="cart" title="View your shopping cart">
				<i class="fa fa-shopping-bag"></i>
				<?php 
					if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
						$count = WC()->cart->cart_contents_count;
						$cart_url = wc_get_cart_url();
						
						if ( $count > 0 ) {
						?>
							 <span><?php echo esc_html( $count ); ?></span>
						<?php 
						}
						else {
							?>
							<span><?php echo esc_html_e('0','instashare'); ?></span>
							<?php 
						}
					}
				?>
			</a>
			<!-- Shopping Cart Start -->
			<div class="shopping-cart">
				<?php get_template_part('woocommerce/cart/mini','cart'); ?>
			</div>
			<!-- Shopping Cart End -->
		</li>
	<?php endif; 
	} 
endif;
add_action( 'instashare_navigation_cart', 'instashare_navigation_cart' );



// Instashare Logo
if ( ! function_exists( 'instashare_logo_content' ) ) :
function instashare_logo_content() {
		if(has_custom_logo())
			{	
				the_custom_logo();
			}
			else { 
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title">
				<h4 class="site-title">
					<?php 
						echo esc_html(get_bloginfo('name'));
					?>
				</h4>
			</a>	
		<?php 						
			}
		?>
		<?php
			$instashare_description = get_bloginfo( 'description');
			if ($instashare_description) : ?>
				<p class="site-description"><?php echo esc_html($instashare_description); ?></p>
		<?php endif;
	} 
endif;
add_action( 'instashare_logo_content', 'instashare_logo_content' );



 /**
 * Add WooCommerce Cart Icon With Cart Count (https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header)
 */
function instashare_add_to_cart_fragment( $fragments ) {
	
    ob_start();
    $count = WC()->cart->cart_contents_count; 
    ?> 
	<a href="javascript:void(0);" class="cart-icon-wrap" id="cart" title="View your shopping cart">
	<i class="fa fa-shopping-bag"></i>	
	<?php
    if ( $count > 0 ) { 
	?>
        <span><?php echo esc_html( $count ); ?></span>
	<?php            
    } else {
	?>	
		<span><?php echo esc_html_e('0','instashare'); ?></span>
	<?php
	}
    ?></a><?php
 
    $fragments['a.cart-icon-wrap'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'instashare_add_to_cart_fragment' );





/*******************************************************************************
 *  Get Started Notice
 *******************************************************************************/

add_action( 'wp_ajax_instashare_dismissed_notice_handler', 'instashare_ajax_notice_handler' );

/**
 * AJAX handler to store the state of dismissible notices.
 */
function instashare_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        // Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        // Store it in the options table
        update_option( 'dismissed-' . $type, TRUE );
    }
}

function instashare_deprecated_hook_admin_notice() {
        // Check if it's been dismissed...
        if ( ! get_option('dismissed-get_started', FALSE ) ) {
            // Added the class "notice-get-started-class" so jQuery pick it up and pass via AJAX,
            // and added "data-notice" attribute in order to track multiple / different notices
            // multiple dismissible notice states ?>
            <div class="updated notice notice-get-started-class is-dismissible" data-notice="get_started">
                <div class="instashare-getting-started-notice clearfix">
                    <div class="instashare-theme-screenshot">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/screenshot.jpg" class="screenshot" alt="<?php esc_attr_e( 'Theme Screenshot', 'instashare' ); ?>" />
                    </div><!-- /.instashare-theme-screenshot -->
                    <div class="instashare-theme-notice-content">
                        <h2 class="instashare-notice-h2">
                            <?php
                        printf(
                        /* translators: 1: welcome page link starting html tag, 2: welcome page link ending html tag. */
                            esc_html__( 'Welcome! Thank you for choosing %1$s!', 'instashare' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
                        ?>
                        </h2>

                        <p class="plugin-install-notice"><?php echo sprintf(__('Install and activate <strong>Neph Soft</strong> plugin for taking full advantage of all the features this theme has to offer.', 'instashare')) ?></p>

                        <a class="instashare-btn-get-started button button-primary button-hero instashare-button-padding" href="#" data-name="" data-slug=""><?php esc_html_e( 'Get started with Instashare', 'instashare' ) ?></a><span class="instashare-push-down">
                        <?php
                            /* translators: %1$s: Anchor link start %2$s: Anchor link end */
                            printf(
                                'or %1$sCustomize theme%2$s</a></span>',
                                '<a target="_blank" href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
                                '</a>'
                            );
                        ?>
                    </div><!-- /.instashare-theme-notice-content -->
                </div>
            </div>
        <?php }
}

add_action( 'admin_notices', 'instashare_deprecated_hook_admin_notice' );

/*******************************************************************************
 *  Plugin Installer
 *******************************************************************************/

add_action( 'wp_ajax_install_act_plugin', 'instashare_admin_install_plugin' );

function instashare_admin_install_plugin() {
    /**
     * Install Plugin.
     */
    include_once ABSPATH . '/wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

    if ( ! file_exists( WP_PLUGIN_DIR . '/neph-soft' ) ) {
        $api = plugins_api( 'plugin_information', array(
            'slug'   => sanitize_key( wp_unslash( 'neph-soft' ) ),
            'fields' => array(
                'sections' => false,
            ),
        ) );

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );
    }

    // Activate plugin.
    if ( current_user_can( 'activate_plugin' ) ) {
        $result = activate_plugin( 'neph-soft/neph-soft.php' );
    }
}		