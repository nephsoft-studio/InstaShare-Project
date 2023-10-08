<?php
/**
 * @package Instashare
 */
?>
<?php
function instashare_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer', 'instashare'),
		) 
	);
	// Footer Setting Section // 
	$wp_customize->add_section(
        'footer_copy_Section',
        array(
            'title' 		=> __('Below Footer','instashare'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );

	// Image Head // 
	$wp_customize->add_setting(
		'footer_copy_img'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'footer_copy_img',
		array(
			'type' => 'hidden',
			'label' => __('Logo','instashare'),
			'section' => 'footer_copy_Section',
			'priority' => 1,
		)
	);
	
	//  Image // 
    $wp_customize->add_setting( 
    	'footer_first_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/logo2.png'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_url',	
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'footer_first_img' ,
		array(
			'label'          => esc_html__( 'Image', 'instashare'),
			'section'        => 'footer_copy_Section',
			'priority' => 4,
		) 
	));
	
	
	
	
	// Social Head // 
	$wp_customize->add_setting(
		'footer_copy_social'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'footer_copy_social',
		array(
			'type' => 'hidden',
			'label' => __('Social Icons','instashare'),
			'section' => 'footer_copy_Section',
			'priority' => 5,
		)
	);

	/**
	 * Customizer Repeater
	 */
		if ( function_exists( 'instashare_get_social_icon_default' ) ) :
			$footer_social_icons = instashare_get_social_icon_default();
		else:
			$footer_social_icons 		= '';
		endif;	
		
		$wp_customize->add_setting( 'footer_social_icons', 
			array(
			 'sanitize_callback' => 'instashare_repeater_sanitize',
			 'default' => $footer_social_icons
		)
		);
		
		$wp_customize->add_control( 
			new INSTASHARE_Repeater( $wp_customize, 
				'footer_social_icons', 
					array(
						'label'   => esc_html__('Social Icons','instashare'),
						'section' => 'footer_copy_Section',
						'priority' => 6,
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_link_control' => true,
					) 
				) 
			);
	
	
	// Copyright Head // 
	$wp_customize->add_setting(
		'footer_copy_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'footer_copy_head',
		array(
			'type' => 'hidden',
			'label' => __('Copyright','instashare'),
			'section' => 'footer_copy_Section',
			'priority' => 7,
		)
	);
	
	// footer third text // 
	$instashare_footer_copyright = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'instashare' );
	$wp_customize->add_setting(
    	'footer_third_custom',
    	array(
			'default' => $instashare_footer_copyright,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
		)
	);	

	$wp_customize->add_control( 
		'footer_third_custom',
		array(
		    'label'   		=> __('Copyright','instashare'),
		    'section'		=> 'footer_copy_Section',
			'type' 			=> 'textarea',
			'priority'      => 9,
		)  
	);	
	
	

	// Footer Widget // 
	$wp_customize->add_section(
        'footer_widget',
        array(
            'title' 		=> __('Footer Widget Area','instashare'),
			'panel'  		=> 'footer_section',
			'priority'      => 3,
		)
    );
	
	// Widget Layout
	$wp_customize->add_setting(
		'footer_widget_display'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'footer_widget_display',
		array(
			'type' => 'hidden',
			'label' => __('Widget Middle Content','instashare'),
			'section' => 'footer_widget',
			'priority'  => 1,
		)
	);
	
	// Widget Content
	$wp_customize->add_setting(
    	'footer_widget_middle_content',
    	array(
			'default' => '<i class="fa fa-expeditedssl"></i>',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_html',
			'transport'         => $selective_refresh,
		)
	);	

	$wp_customize->add_control( 
		'footer_widget_middle_content',
		array(
		    'label'   		=> __('Widget Middle Content','instashare'),
		    'section'		=> 'footer_widget',
			'type' 			=> 'text',
		)  
	);	
	
	
	// Footer Background // 
	$wp_customize->add_section(
        'footer_background',
        array(
            'title' 		=> __('Footer Background','instashare'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );
	// enable Effect
	$wp_customize->add_setting(
		'footer_effect_enable'
			,array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'footer_effect_enable',
		array(
			'type' => 'checkbox',
			'label' => __('Enable Water Effect on Footer?','instashare'),
			'section' => 'footer_background',
		)
	);

	//  Image // 
    $wp_customize->add_setting( 
    	'footer_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/footer/footer_bg.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_url',	
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'footer_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'instashare'),
			'section'        => 'footer_background',
		) 
	));

	// Footer Parallax // 
	$wp_customize->add_section(
        'footer_parallax',
        array(
            'title' 		=> __('Footer Parallax','instashare'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );
	
	// enable Parallax
	$wp_customize->add_setting(
		'footer_parallax_enable'
			,array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'footer_parallax_enable',
		array(
			'type' => 'checkbox',
			'label' => __('Enable Parallax ?','instashare'),
			'section' => 'footer_parallax',
		)
	);
	
	
	// Margin
	if ( class_exists( 'Nephsoft_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting(
			'footer_parallax_margin',
			array(
				'default'	      => '775',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'instashare_sanitize_range_value',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control( 
		new Nephsoft_Customizer_Range_Slider_Control( $wp_customize, 'footer_parallax_margin', 
			array(
				'label'      => __( 'Margin Bottom', 'instashare' ),
				'section'  => 'footer_parallax',
				'input_attrs' => array(
					'min'           => 0,
					'max'           => 1000,
					'step'          => 1,
					//'suffix' => 'px', //optional suffix
				),	
			) ) 
		);
	}
}
add_action( 'customize_register', 'instashare_footer' );
// Footer selective refresh
function instashare_footer_partials( $wp_customize ){		
	// footer_third_custom
	$wp_customize->selective_refresh->add_partial( 'footer_third_custom', array(
		'selector'            => '.footer-copyright .copyright-text',
		'settings'            => 'footer_third_custom',
		'render_callback'  => 'instashare_footer_third_custom_render_callback',
	) );
	
	//footer_widget_middle_content
	$wp_customize->selective_refresh->add_partial( 'footer_widget_middle_content', array(
		'selector'            => '.footer-main .footer-info-overwrap',
		'settings'            => 'footer_widget_middle_content',
		'render_callback'  => 'instashare_footer_widget_middle_content_render_callback',
	) );
	}

add_action( 'customize_register', 'instashare_footer_partials' );


// copyright_content
function instasharet_footer_third_custom_render_callback() {
	return get_theme_mod( 'footer_third_custom' );
}

// footer_widget_middle_content
function instashare_footer_widget_middle_content_render_callback() {
	return get_theme_mod( 'footer_widget_middle_content' );
}