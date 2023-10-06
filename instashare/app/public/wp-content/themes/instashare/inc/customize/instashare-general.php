<?php
/**
 * @package Instashare
 */
?>
<?php
function instashare_general_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'instashare_general', array(
			'priority' => 31,
			'title' => esc_html__( 'General', 'instashare' ),
		)
	);
	
	
	/*=========================================
	Background Elements
	=========================================*/
	$wp_customize->add_section(
		'bg_elements', array(
			'title' => esc_html__( 'Background Elements', 'instashare' ),
			'priority' => 1,
			'panel' => 'instashare_general',
		)
	);
	
	$wp_customize->add_setting( 
		'hs_bg_elements' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'hs_bg_elements', 
		array(
			'label'	      => esc_html__( 'Hide / Show Background Elements', 'instashare' ),
			'section'     => 'bg_elements',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Scroller
	=========================================*/
	$wp_customize->add_section(
		'top_scroller', array(
			'title' => esc_html__( 'Scroller', 'instashare' ),
			'priority' => 4,
			'panel' => 'instashare_general',
		)
	);
	
	$wp_customize->add_setting( 
		'hs_scroller' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'hs_scroller', 
		array(
			'label'	      => esc_html__( 'Hide / Show Scroller', 'instashare' ),
			'section'     => 'top_scroller',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Breadcrumb  Section
	=========================================*/
	$wp_customize->add_section(
		'breadcrumb_setting', array(
			'title' => esc_html__( 'Breadcrumb', 'instashare' ),
			'priority' => 12,
			'panel' => 'instashare_general',
		)
	);
	
	// Settings
	$wp_customize->add_setting(
		'breadcrumb_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_settings',
		array(
			'type' => 'hidden',
			'label' => __('Settings','instashare'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Breadcrumb Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'hs_breadcrumb' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hs_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'instashare' ),
			'section'     => 'breadcrumb_setting',
			'type'        => 'checkbox'
		) 
	);
	
	// enable Effect
	$wp_customize->add_setting(
		'breadcrumb_effect_enable'
			,array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_effect_enable',
		array(
			'type' => 'checkbox',
			'label' => __('Enable Water Effect on Breadcrumb?','instashare'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Breadcrumb Content Section // 
	$wp_customize->add_setting(
		'breadcrumb_contents'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_contents',
		array(
			'type' => 'hidden',
			'label' => __('Content','instashare'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Content size // 
	if ( class_exists( 'Nephsoft_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting(
			'breadcrumb_min_height',
			array(
				'default' => 246,
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'instashare_sanitize_range_value',
				'transport'         => 'postMessage',
				'priority' => 8,
			)
		);
		$wp_customize->add_control( 
			new Nephsoft_Customizer_Range_Slider_Control( $wp_customize, 'breadcrumb_min_height', 
				array(
					'label'      => __( 'Min Height', 'instashare'),
					'section'  => 'breadcrumb_setting',
					'input_attrs' => array(
						'min'    => 1,
						'max'    => 1000,
						'step'   => 1,
						//'suffix' => 'px', //optional suffix
					),
				) ) 
			);
	}	
		
	// Background // 
	$wp_customize->add_setting(
		'breadcrumb_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 9,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','instashare'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'breadcrumb_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/breadcrumb/breadcrumb.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'breadcrumb_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'instashare'),
			'section'        => 'breadcrumb_setting',
		) 
	));
	
	// Background Attachment // 
	$wp_customize->add_setting( 
		'breadcrumb_back_attach' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_select',
			'priority'  => 10,
		) 
	);
	
	$wp_customize->add_control(
	'breadcrumb_back_attach' , 
		array(
			'label'          => __( 'Background Attachment', 'instashare' ),
			'section'        => 'breadcrumb_setting',
			'type'           => 'select',
			'choices'        => 
			array(
				'inherit' => __( 'Inherit', 'instashare' ),
				'scroll' => __( 'Scroll', 'instashare' ),
				'fixed'   => __( 'Fixed', 'instashare' )
			) 
		) 
	);
	
	/*=========================================
	Instashare Container
	=========================================*/
	$wp_customize->add_section(
        'instashare_container',
        array(
        	'priority'      => 2,
            'title' 		=> __('Container','instashare'),
			'panel'  		=> 'instashare_general',
		)
    );
	
	if ( class_exists( 'Nephsoft_Customizer_Range_Slider_Control' ) ) {
		//container width
		$wp_customize->add_setting(
			'instashare_site_cntnr_width',
			array(
				'default'			=> '1200',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'instashare_sanitize_range_value',
				'transport'         => 'postMessage',
				'priority'      => 1,
			)
		);
		$wp_customize->add_control( 
		new Nephsoft_Customizer_Range_Slider_Control( $wp_customize, 'instashare_site_cntnr_width', 
			array(
				'label'      => __( 'Container Width', 'instashare' ),
				'section'  => 'instashare_container',
				'input_attrs' => array(
					 'min'           => 768,
					'max'           => 2000,
					'step'          => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
		
	}
}

add_action( 'customize_register', 'instashare_general_setting' );