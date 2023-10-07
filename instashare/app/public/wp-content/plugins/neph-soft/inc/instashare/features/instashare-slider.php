<?php
function instashare_slider_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
$theme = wp_get_theme(); // gets the current theme
	/*=========================================
	Slider Section Panel
	=========================================*/
	$wp_customize->add_panel(
		'instashare_frontpage_sections', array(
			'priority' => 32,
			'title' => esc_html__( 'Homepage Sections', 'neph-soft' ),
		)
	);
	
	$wp_customize->add_section(
		'slider_setting', array(
			'title' => esc_html__( 'Slider Section', 'neph-soft' ),
			'panel' => 'instashare_frontpage_sections',
			'priority' => 1,
		)
	);
	
	
	// Setting Head
	$wp_customize->add_setting(
		'slider_setting_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'slider_setting_head',
		array(
			'type' => 'hidden',
			'label' => __('Setting','neph-soft'),
			'section' => 'slider_setting',
		)
	);
	
	// Hide / Show 
	$wp_customize->add_setting(
		'slider_hs'
			,array(
			'default'     	=> '1',	
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'slider_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','neph-soft'),
			'section' => 'slider_setting',
		)
	);
	
	// slider Contents
	$wp_customize->add_setting(
		'slider_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'slider_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Contents','neph-soft'),
			'section' => 'slider_setting',
		)
	);
	
	/**
	 * Customizer Repeater for add slides
	 */
	
		$wp_customize->add_setting( 'slider', 
			array(
			 'sanitize_callback' => 'instashare_repeater_sanitize',
			 'priority' => 5,
			  'default' => instashare_get_slider_default()
			)
		);
		
		if ( 'Comoxa' == $theme->name){
			$wp_customize->add_control( 
			new Instashare_Repeater( $wp_customize, 
				'slider', 
					array(
						'label'   => esc_html__('Slide','neph-soft'),
						'section' => 'slider_setting',
						'add_field_label'                   => esc_html__( 'Add New Slider', 'neph-soft' ),
						'item_name'                         => esc_html__( 'Slider', 'neph-soft' ),
						
						
						'customizer_repeater_title_control' => true,
						'customizer_repeater_subtitle_control' => true,
						'customizer_repeater_subtitle2_control' => true,
						'customizer_repeater_text_control' => true,
						'customizer_repeater_text2_control'=> true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_slide_align' => true,
						'customizer_repeater_checkbox_control' => true,
						'customizer_repeater_image_control' => true,
						'customizer_repeater_image2_control' => true,
					) 
				) 
			);
		}else{
			$wp_customize->add_control( 
			new Instashare_Repeater( $wp_customize, 
				'slider', 
					array(
						'label'   => esc_html__('Slide','neph-soft'),
						'section' => 'slider_setting',
						'add_field_label'                   => esc_html__( 'Add New Slider', 'neph-soft' ),
						'item_name'                         => esc_html__( 'Slider', 'neph-soft' ),
						
						
						'customizer_repeater_title_control' => true,
						'customizer_repeater_subtitle_control' => true,
						'customizer_repeater_subtitle2_control' => true,
						'customizer_repeater_text_control' => true,
						'customizer_repeater_text2_control'=> true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_slide_align' => true,
						'customizer_repeater_checkbox_control' => true,
						'customizer_repeater_image_control' => true,
					) 
				) 
			);
		}
	
	// slider opacity
	$overlay_color	= '0.6';
	
	if ( class_exists( 'Nephsoft_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting(
			'slider_opacity',
			array(
				'default'	      => $overlay_color,
				'capability'     	=> 'edit_theme_options',
				//'sanitize_callback' => 'instashare_sanitize_range_value',
				'priority' => 7,
			)
		);
		$wp_customize->add_control( 
		new Nephsoft_Customizer_Range_Slider_Control( $wp_customize, 'slider_opacity', 
			array(
				'label'      => __( 'opacity', 'neph-soft' ),
				'section'  => 'slider_setting',
				 'input_attrs' => array(
					'min'    => 0,
					'max'    => 0.9,
					'step'   => 0.1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
	}	
	
}

add_action( 'customize_register', 'instashare_slider_setting' );