<?php
function instashare_lite_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Footer Above
	=========================================*/	
	$wp_customize->add_section(
        'footer_above',
        array(
            'title' 		=> __('Footer Above','neph-soft'),
			'panel'  		=> 'footer_section',
			'priority'      => 2,
		)
    );
	// hide/show
	$wp_customize->add_setting( 
		'hs_above_footer' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'instashare_sanitize_checkbox',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'hs_above_footer', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'neph-soft' ),
			'section'     => 'footer_above',
			'type'        => 'checkbox'
		) 
	);	
	//content
	$wp_customize->add_setting( 'footer_above_content', 
		array(
			 'sanitize_callback' => 'instashare_repeater_sanitize',
			 'default' => instashare_get_footer_above_default(),
			 'transport'         => $selective_refresh,
			 'priority' => 2,
			)
		);
		
		$wp_customize->add_control( 
			new INSTASHARE_Repeater( $wp_customize, 
				'footer_above_content', 
					array(
						'label'   => esc_html__('Content','neph-soft'),
						'section' => 'footer_above',
						'add_field_label'                   => esc_html__( 'Add New Content', 'neph-soft' ),
						'item_name'                         => esc_html__( 'Content', 'neph-soft' ),
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_title_control' => true,
						'customizer_repeater_text_control' => true,
						'customizer_repeater_link_control' => true,
					) 
				) 
			);			
}
add_action( 'customize_register', 'instashare_lite_footer' );
// Footer selective refresh
function instashare_lite_footer_partials( $wp_customize ){	
	//footer_above_content 
	$wp_customize->selective_refresh->add_partial( 'footer_above_content', array(
		'selector'            => '.footer-above .av-columns-area',
	) );
	
	}

add_action( 'customize_register', 'instashare_lite_footer_partials' );