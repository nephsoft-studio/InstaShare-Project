<?php
function instashare_lite_header_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';	
	/*=========================================
	Instashare Site Identity
	=========================================*/	
	// Logo Width // 
	if ( class_exists( 'Nephsoft_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting(
			'logo_width',
			array(
				'default'			=> '140',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'instashare_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new Nephsoft_Customizer_Range_Slider_Control( $wp_customize, 'logo_width', 
			array(
				'label'      => __( 'Logo Width', 'neph-soft' ),
				'section'  => 'title_tagline',
				'input_attrs' => array(
					'min'    => 0,
					'max'    => 500,
					'step'   => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
	}	
	
	
	/*=========================================
	Above Header Section
	=========================================*/
	$wp_customize->add_section(
        'above_header',
        array(
        	'priority'      => 2,
            'title' 		=> __('Above Header','neph-soft'),
			'panel'  		=> 'header_section',
		)
    );

	/*=========================================
	Social
	=========================================*/
	$wp_customize->add_setting(
		'hdr_social_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'hdr_social_head',
		array(
			'type' => 'hidden',
			'label' => __('Social Icons','neph-soft'),
			'section' => 'above_header',
			'priority' => 1,
		)
	);
	
	
	$wp_customize->add_setting( 
		'hide_show_social_icon' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_social_icon', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'neph-soft' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);
	
	/**
	 * Customizer Repeater
	 */
		$wp_customize->add_setting( 'social_icons', 
			array(
			 'sanitize_callback' => 'instashare_repeater_sanitize',
			 'priority' => 2,
			 'default' => instashare_get_social_icon_default()
		)
		);
		
		$wp_customize->add_control( 
			new INSTASHARE_Repeater( $wp_customize, 
				'social_icons', 
					array(
						'label'   => esc_html__('Social Icons','neph-soft'),
						'section' => 'above_header',
						'add_field_label'                   => esc_html__( 'Add New Social', 'neph-soft' ),
						'item_name'                         => esc_html__( 'Social', 'neph-soft' ),
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_link_control' => true,
					) 
				) 
			);
	
		
	
	$theme = wp_get_theme(); // gets the current theme
	if ( 'Flavita' !== $theme->name){
	/*=========================================
	Language
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_language'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'hdr_top_language',
		array(
			'type' => 'hidden',
			'label' => __('Language','neph-soft'),
			'section' => 'above_header',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_language_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 4,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_language_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'neph-soft' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'tlh_language_icon',
    	array(
	        'default' => 'fa-language',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Instashare_Icon_Picker_Control($wp_customize, 
		'tlh_language_icon',
		array(
		    'label'   		=> __('Icon','neph-soft'),
		    'section' 		=> 'above_header',
			'iconset' => 'fa',
			
		))  
	);		
	// title // 
	$wp_customize->add_setting(
    	'tlh_language_title',
    	array(
	        'default'			=> __('Language','neph-soft'),
			'sanitize_callback' => 'instashare_sanitize_text',
			'transport'         => $selective_refresh,
			'capability' => 'edit_theme_options',
			'priority' => 5,
		)
	);	

	$wp_customize->add_control( 
		'tlh_language_title',
		array(
		    'label'   		=> __('Title','neph-soft'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// Link // 
	$wp_customize->add_setting(
    	'tlh_language_link',
    	array(
			'sanitize_callback' => 'instashare_sanitize_url',
			'capability' => 'edit_theme_options',
			'priority' => 6,
		)
	);	

	$wp_customize->add_control( 
		'tlh_language_link',
		array(
		    'label'   		=> __('Link','neph-soft'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	
	/*=========================================
	Settings
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 11,
		)
	);

	$wp_customize->add_control(
	'hdr_top_settings',
		array(
			'type' => 'hidden',
			'label' => __('Settings','neph-soft'),
			'section' => 'above_header',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_settings_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 12,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_settings_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'neph-soft' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'tlh_settings_icon',
    	array(
	        'default' => 'fa-cogs',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Instashare_Icon_Picker_Control($wp_customize, 
		'tlh_settings_icon',
		array(
		    'label'   		=> __('Icon','neph-soft'),
		    'section' 		=> 'above_header',
			'iconset' => 'fa',
			
		))  
	);	
	// Settings_title // 
	$wp_customize->add_setting(
    	'tlh_settings_title',
    	array(
	        'default'			=> __('Settings','neph-soft'),
			'sanitize_callback' => 'instashare_sanitize_text',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
			'priority' => 13,
		)
	);	

	$wp_customize->add_control( 
		'tlh_settings_title',
		array(
		    'label'   		=> __('Title','neph-soft'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// Settings subtitle // 
	$wp_customize->add_setting(
    	'tlh_settings_link',
    	array(
			'sanitize_callback' => 'instashare_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 14,
		)
	);	

	$wp_customize->add_control( 
		'tlh_settings_link',
		array(
		    'label'   		=> __('Link','neph-soft'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	
	
	/*=========================================
	Help
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_help'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'hdr_top_help',
		array(
			'type' => 'hidden',
			'label' => __('Help','neph-soft'),
			'section' => 'above_header',
			
		)
	);
	$wp_customize->add_setting( 
		'hide_show_help_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_help_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'neph-soft' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	// icon // 
	$wp_customize->add_setting(
    	'tlh_help_icon',
    	array(
	        'default' => 'fa-question-circle',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Instashare_Icon_Picker_Control($wp_customize, 
		'tlh_help_icon',
		array(
		    'label'   		=> __('Icon','neph-soft'),
		    'section' 		=> 'above_header',
			'iconset' => 'fa',
			
		))  
	);
	
	// Help title // 
	$wp_customize->add_setting(
    	'tlh_help_title',
    	array(
	        'default'			=> __('Help','neph-soft'),
			'sanitize_callback' => 'instashare_sanitize_text',
			'transport'         => $selective_refresh,
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_help_title',
		array(
		    'label'   		=> __('Title','neph-soft'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// Link // 
	$wp_customize->add_setting(
    	'tlh_help_link',
    	array(
			'sanitize_callback' => 'instashare_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 19,
		)
	);	

	$wp_customize->add_control( 
		'tlh_help_link',
		array(
		    'label'   		=> __('Link','neph-soft'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	}
}
add_action( 'customize_register', 'instashare_lite_header_settings' );

// Header selective refresh
function instashare_lite_header_partials( $wp_customize ){
	
	// hide_show_nav_btn
	$wp_customize->selective_refresh->add_partial(
		'hide_show_nav_btn', array(
			'selector' => '.navigator .av-button-area',
			'container_inclusive' => true,
			'render_callback' => 'header_navigation',
			'fallback_refresh' => true,
		)
	);
	// tlh_help_title
	$wp_customize->selective_refresh->add_partial( 'tlh_help_title', array(
		'selector'            => '#above-header .wgt-3 .title',
		'settings'            => 'tlh_help_title',
		'render_callback'  => 'instashare_tlh_help_title_render_callback',
	) );
	
	// tlh_settings_title
	$wp_customize->selective_refresh->add_partial( 'tlh_settings_title', array(
		'selector'            => '#above-header .wgt-2 .title',
		'settings'            => 'tlh_settings_title',
		'render_callback'  => 'instashare_tlh_settings_title_render_callback',
	) );
	
	// tlh_language_title
	$wp_customize->selective_refresh->add_partial( 'tlh_language_title', array(
		'selector'            => '#above-header .wgt-1 .title',
		'settings'            => 'tlh_language_title',
		'render_callback'  => 'instashare_tlh_language_title_render_callback',
	) );
	}

add_action( 'customize_register', '_lite_header_partials' );

// tlh_help_title
function instashare_tlh_help_title_render_callback() {
	return get_theme_mod( 'tlh_help_title' );
}

// tlh_settings_title
function instashare_tlh_settings_title_render_callback() {
	return get_theme_mod( 'tlh_settings_title' );
}

// tlh_language_title
function instashare_tlh_language_title_render_callback() {
	return get_theme_mod( 'tlh_language_title' );
}

