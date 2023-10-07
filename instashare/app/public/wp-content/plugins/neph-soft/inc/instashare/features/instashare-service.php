<?php
function instashare_service_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Service  Section
	=========================================*/
	$wp_customize->add_section(
		'service_setting', array(
			'title' => esc_html__( 'Service Section', 'neph-soft' ),
			'priority' => 3,
			'panel' => 'instashare_frontpage_sections',
		)
	);

	// Setting Head
	$wp_customize->add_setting(
		'service_setting_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'service_setting_head',
		array(
			'type' => 'hidden',
			'label' => __('Setting','neph-soft'),
			'section' => 'service_setting',
		)
	);
	
	// Hide / Show 
	$wp_customize->add_setting(
		'service_hs'
			,array(
			'default'     	=> '1',	
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'service_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','neph-soft'),
			'section' => 'service_setting',
		)
	);
	
	// Service Header Section // 
	$wp_customize->add_setting(
		'service_headings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'service_headings',
		array(
			'type' => 'hidden',
			'label' => __('Header','neph-soft'),
			'section' => 'service_setting',
		)
	);
	
	// Service Title // 
	$wp_customize->add_setting(
    	'service_title',
    	array(
	        'default'			=> __('Insta <span class="primary-color">Share Expertise</span>','neph-soft'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 4,
		)
	);	
	
	$wp_customize->add_control( 
		'service_title',
		array(
		    'label'   => __('Title','neph-soft'),
		    'section' => 'service_setting',
			'type'           => 'text',
		)  
	);
	
	// Service Description // 
	$wp_customize->add_setting(
    	'service_description',
    	array(
	        'default'			=> __('Dynamic web servers update hosted files before serving them over an HTTP server. This allows them to generate and send dynamic content to a web browser.','neph-soft'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'transport'         => $selective_refresh,
			'priority' => 6,
		)
	);	
	
	$wp_customize->add_control( 
		'service_description',
		array(
		    'label'   => __('Description','neph-soft'),
		    'section' => 'service_setting',
			'type'           => 'textarea',
		)  
	);

	// Service content Section // 
	
	$wp_customize->add_setting(
		'service_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'service_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Content','neph-soft'),
			'section' => 'service_setting',
		)
	);
	
	/**
	 * Customizer Repeater for add service
	 */
	
		$wp_customize->add_setting( 'service_contents', 
			array(
			 'sanitize_callback' => 'instashare_repeater_sanitize',
			 'transport'         => $selective_refresh,
			 'priority' => 8,
			 'default' => instashare_get_service_default()
			)
		);
		
		$wp_customize->add_control( 
			new Instashare_Repeater( $wp_customize, 
				'service_contents', 
					array(
						'label'   => esc_html__('Service','neph-soft'),
						'section' => 'service_setting',
						'add_field_label'                   => esc_html__( 'Add New Service', 'neph-soft' ),
						'item_name'                         => esc_html__( 'Service', 'neph-soft' ),
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_image_control' => true,
						'customizer_repeater_title_control' => true,
						'customizer_repeater_subtitle_control' => true,
						'customizer_repeater_subtitle2_control' => true,
						'customizer_repeater_subtitle3_control' => true,
						'customizer_repeater_subtitle4_control' => true,
						'customizer_repeater_subtitle5_control' => true,
						'customizer_repeater_text2_control' => true,
						'customizer_repeater_link_control' => true,
					) 
				) 
			);
			
add_action( 'customize_register', 'instashare_service_setting' );
}

// service selective refresh
function instashare_home_service_section_partials( $wp_customize ){	
	// service title
	$wp_customize->selective_refresh->add_partial( 'service_title', array(
		'selector'            => '.service-home .heading-default h3',
		'settings'            => 'service_title',
		'render_callback'  => 'instashare_service_title_render_callback',
	
	) );
	
	// service description
	$wp_customize->selective_refresh->add_partial( 'service_description', array(
		'selector'            => '.service-home .heading-default p',
		'settings'            => 'service_description',
		'render_callback'  => 'instashare_service_desc_render_callback',
	
	) );
	// service content
	$wp_customize->selective_refresh->add_partial( 'service_contents', array(
		'selector'            => '.service-home .service-contents'
	
	) );
	
	}

add_action( 'customize_register', 'instashare_home_service_section_partials' );

// service title
function instashare_service_title_render_callback() {
	return get_theme_mod( 'service_title' );
}

// service description
function instashare_service_desc_render_callback() {
	return get_theme_mod( 'service_description' );
}