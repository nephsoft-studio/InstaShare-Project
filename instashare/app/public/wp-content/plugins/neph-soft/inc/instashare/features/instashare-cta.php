<?php
function instashare_cta_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	CTA  Section
	=========================================*/
	$wp_customize->add_section(
		'cta_setting', array(
			'title' => esc_html__( 'Call to Action Section', 'neph-soft' ),
			'priority' => 6,
			'panel' => 'instashare_frontpage_sections',
		)
	);
	
	// Setting Head
	$wp_customize->add_setting(
		'cta_setting_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'cta_setting_head',
		array(
			'type' => 'hidden',
			'label' => __('Setting','neph-soft'),
			'section' => 'cta_setting',
		)
	);
	
	// Hide / Show 
	$wp_customize->add_setting(
		'cta_hs'
			,array(
			'default'     	=> '1',	
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'cta_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','neph-soft'),
			'section' => 'cta_setting',
		)
	);
	
	// CTA Call Section // 
	$wp_customize->add_setting(
		'cta_call_contents'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'cta_call_contents',
		array(
			'type' => 'hidden',
			'label' => __('Left Content','neph-soft'),
			'section' => 'cta_setting',
		)
	);
	
	// icon // 
	$wp_customize->add_setting(
    	'cta_call_icon',
    	array(
	        'default' => 'fa-files-o',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 1,
		)
	);	

	$wp_customize->add_control(new Instashare_Icon_Picker_Control($wp_customize, 
		'cta_call_icon',
		array(
		    'label'   		=> __('Icon','neph-soft'),
		    'section' 		=> 'cta_setting',
			'iconset' => 'fa',
			
		))  
	);	
	
	
	// CTA Call Title // 
	$wp_customize->add_setting(
    	'cta_call_title',
    	array(
	        'default'			=> __('New, Fast','neph-soft'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'cta_call_title',
		array(
		    'label'   => __('Title','neph-soft'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	// CTA Call Text // 
	$wp_customize->add_setting(
    	'cta_call_text',
    	array(
	        'default'			=> __('and Effective Method','neph-soft'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 2,
		)
	);	
	
	$wp_customize->add_control( 
		'cta_call_text',
		array(
		    'label'   => __('Text','neph-soft'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	
	// CTA Content Section // 
	$wp_customize->add_setting(
		'cta_contents'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'cta_contents',
		array(
			'type' => 'hidden',
			'label' => __('Right Content','neph-soft'),
			'section' => 'cta_setting',
		)
	);
	
	
	// icon // 
	$wp_customize->add_setting(
    	'cta_right_icon',
    	array(
	        'default' => 'fa-file-text',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 4,
		)
	);	

	$wp_customize->add_control(new Instashare_Icon_Picker_Control($wp_customize, 
		'cta_right_icon',
		array(
		    'label'   		=> __('Icon','neph-soft'),
		    'section' 		=> 'cta_setting',
			'iconset' => 'fa',
			
		))  
	);	
	
	
	// CTA Title // 
	$wp_customize->add_setting(
    	'cta_title',
    	array(
	        'default'			=> __('Try Our Newest Repository Service!','neph-soft'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 4,
		)
	);	
	
	$wp_customize->add_control( 
		'cta_title',
		array(
		    'label'   => __('Title','neph-soft'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	// CTA Description // 
	$wp_customize->add_setting(
    	'cta_description',
    	array(
	        'default'			=> __('Repository services support the ongoing administration, maintenance and preservation activities of digital collection management, as well as providing access to content. Below we offer these services as they could be used in a digital object.','neph-soft'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 6,
		)
	);	
	
	$wp_customize->add_control( 
		'cta_description',
		array(
		    'label'   => __('Description','neph-soft'),
		    'section' => 'cta_setting',
			'type'           => 'textarea',
		)  
	);
	
	// Button // 	
	$wp_customize->add_setting(
		'cta_btn'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'cta_btn',
		array(
			'type' => 'hidden',
			'label' => __('Button','neph-soft'),
			'section' => 'cta_setting',
		)
	);
	
	
	// icon // 
	$wp_customize->add_setting(
    	'cta_btn_icon',
    	array(
	        'default' => 'fa-angle-right',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 8,
		)
	);	

	$wp_customize->add_control(new Instashare_Icon_Picker_Control($wp_customize, 
		'cta_btn_icon',
		array(
		    'label'   		=> __('Icon','neph-soft'),
		    'section' 		=> 'cta_setting',
			'iconset' => 'fa',
			
		))  
	);	
	
	$wp_customize->add_setting(
    	'cta_btn_lbl',
    	array(
	        'default'			=> __('Start Now!','neph-soft'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 8,
		)
	);	
	
	$wp_customize->add_control( 
		'cta_btn_lbl',
		array(
		    'label'   => __('Button Label','neph-soft'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	$wp_customize->add_setting(
    	'cta_btn_link',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_url',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'cta_btn_link',
		array(
		    'label'   => __('Link','neph-soft'),
		    'section' => 'cta_setting',
			'type'           => 'text',
		)  
	);
	
	
	// CTA Background // 	
	$wp_customize->add_setting(
		'cta_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 13,
		)
	);

	$wp_customize->add_control(
	'cta_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','neph-soft'),
			'section' => 'cta_setting',
		)
	);
	
    $wp_customize->add_setting( 
    	'cta_bg_setting' , 
    	array(
			'default' 			=> esc_url(NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/slider/img01.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_url',	
			'priority' => 14,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'cta_bg_setting' ,
		array(
			'label'          => __( 'Background Image', 'neph-soft' ),
			'section'        => 'cta_setting',
		) 
	));

	$wp_customize->add_setting( 
		'cta_bg_position' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_select',
			'priority' => 15,
		) 
	);
	
	$wp_customize->add_control(
		'cta_bg_position' , 
			array(
				'label'          => __( 'Image Position', 'neph-soft' ),
				'section'        => 'cta_setting',
				'type'           => 'radio',
				'choices'        => 
				array(
					'fixed'=> __( 'Fixed', 'neph-soft' ),
					'scroll' => __( 'Scroll', 'neph-soft' )
			)  
		) 
	);	
	
	// enable Effect
	$wp_customize->add_setting(
		'cta_effect_enable'
			,array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 17,
		)
	);

	$wp_customize->add_control(
	'cta_effect_enable',
		array(
			'type' => 'checkbox',
			'label' => __('Enable Water Effect on CTA?','neph-soft'),
			'section' => 'cta_setting',
		)
	);

}

add_action( 'customize_register', 'instashare_cta_setting' );

// CTA selective refresh
function instashare_ata_section_partials( $wp_customize ){
	
	// cta_call_title
	$wp_customize->selective_refresh->add_partial( 'cta_call_title', array(
		'selector'            => '.home-cta .call-wrapper .call-title',
		'settings'            => 'cta_call_title',
		'render_callback'  => 'instashare_cta_call_title_render_callback',
	) );
	
	// cta_call_text
	$wp_customize->selective_refresh->add_partial( 'cta_call_text', array(
		'selector'            => '.home-cta .call-wrapper .call-phone',
		'settings'            => 'cta_call_text',
		'render_callback'  => 'instashare_cta_call_text_render_callback',
	) );
	
	// cta_title
	$wp_customize->selective_refresh->add_partial( 'cta_title', array(
		'selector'            => '.home-cta .cta-content-wrap h4',
		'settings'            => 'cta_title',
		'render_callback'  => 'instashare_cta_title_render_callback',
	) );
	
	// cta_description
	$wp_customize->selective_refresh->add_partial( 'cta_description', array(
		'selector'            => '.home-cta .cta-content-wrap p',
		'settings'            => 'cta_description',
		'render_callback'  => 'instashare_cta_description_render_callback',
	) );
	
	// cta_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'cta_btn_lbl', array(
		'selector'            => '.home-cta .cta-btn a',
		'settings'            => 'cta_btn_lbl',
		'render_callback'  => 'instashare_cta_btn_lbl_render_callback',
	) );
	}

add_action( 'customize_register', 'instashare_ata_section_partials' );

// cta_title
function instashare_cta_title_render_callback() {
	return get_theme_mod( 'cta_title' );
}


// cta_description
function instashare_cta_description_render_callback() {
	return get_theme_mod( 'cta_description' );
}

// cta_btn_lbl
function instashare_cta_btn_lbl_render_callback() {
	return get_theme_mod( 'cta_btn_lbl' );
}

// cta_call_title
function instashare_cta_call_title_render_callback() {
	return get_theme_mod( 'cta_call_title' );
}

// cta_call_text
function instashare_cta_call_text_render_callback() {
	return get_theme_mod( 'cta_call_text' );
}
