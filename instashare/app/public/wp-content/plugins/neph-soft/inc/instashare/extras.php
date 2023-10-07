<?php
/**
 * Instashare Above Header Social
 */
if ( ! function_exists( 'instashare_abv_hdr_social' ) ) {
	function instashare_abv_hdr_social() {
		//above_header_first
		$hide_show_social_icon 		= get_theme_mod( 'hide_show_social_icon','1'); 
		$social_icons 				= get_theme_mod( 'social_icons',instashare_get_social_icon_default());	
		
				 if($hide_show_social_icon == '1') { ?>
					<aside class="share-toolkit widget widget_social_widget"">
						<ul>
							<?php
								$social_icons = json_decode($social_icons);
								if( $social_icons!='' )
								{
								foreach($social_icons as $social_item){	
								$social_icon = ! empty( $social_item->icon_value ) ? apply_filters( 'instashare_translate_single_string', $social_item->icon_value, 'Header section' ) : '';	
								$social_link = ! empty( $social_item->link ) ? apply_filters( 'instashare_translate_single_string', $social_item->link, 'Header section' ) : '';
							?>
								<li><a href="<?php echo esc_url( $social_link ); ?>"><i class="fa <?php echo esc_attr( $social_icon ); ?>"></i></a></li>
							<?php }} ?>
						</ul>
					</aside>
				<?php } 
	}
}
add_action( 'instashare_abv_hdr_social', 'instashare_abv_hdr_social' );




/**
 * Instashare Above Header Contact Info
 */
if ( ! function_exists( 'instashare_abv_hdr_contact_info' ) ) {
	function instashare_abv_hdr_contact_info() {
		
			$hide_show_language_details 	= get_theme_mod( 'hide_show_language_details','1'); 
			$tlh_language_icon 			= get_theme_mod( 'tlh_language_icon',__('fa-language','neph-soft')); 	
			$tlh_language_title 			= get_theme_mod( 'tlh_language_title',__('Language','neph-soft')); 
			$tlh_language_link 			= get_theme_mod( 'tlh_language_link'); 
				if($hide_show_language_details == '1') { ?>
					<aside class="widget widget-contact wgt-1">
						<div class="contact-area">
							<?php if(!empty($tlh_language_icon)): ?>
								<div class="contact-icon">
								   <i class="fa <?php echo  esc_attr($tlh_language_icon); ?>"></i>
								</div>
							<?php endif; ?>
							<a href="<?php echo esc_url($tlh_language_link); ?>" class="contact-info">
								<span class="title"><?php echo esc_html($tlh_language_title); ?></span>
							</a>
						</div>
					</aside>
				<?php }
				
					$hide_show_settings_details 	= get_theme_mod( 'hide_show_settings_details','1');
					$tlh_settings_icon 			= get_theme_mod( 'tlh_settings_icon','fa-cogs'); 	
					$tlh_settings_title 			= get_theme_mod( 'tlh_settings_title',__('Settings','neph-soft')); 
					$tlh_settings_link 			= get_theme_mod( 'tlh_settings_link'); 
				?>	
				<?php if($hide_show_settings_details == '1') { ?>
						 <aside class="widget widget-contact wgt-2">
							<div class="contact-area">
								<?php if(!empty($tlh_settings_icon)): ?>
									<div class="contact-icon">
										<i class="fa <?php echo  esc_attr($tlh_settings_icon); ?>"></i>
									</div>
								<?php endif; ?>	
								<a href="<?php echo esc_url($tlh_settings_link); ?>" class="contact-info">
									<span class="title"><?php echo esc_html($tlh_settings_title); ?></span>
								</a>
							</div>
						</aside>
					<?php } 
					
						$hide_show_help_details 	= get_theme_mod( 'hide_show_help_details','1'); 	
						$tlh_help_icon 		= get_theme_mod( 'tlh_help_icon','fa-question-circle');
						$tlh_help_title 		= get_theme_mod( 'tlh_help_title',__('Help','neph-soft')); 
						$tlh_help_link 		= get_theme_mod( 'tlh_help_link'); 
					?>
					<?php if($hide_show_help_details == '1') { ?>
						<aside class="widget widget-contact wgt-3">
							<div class="contact-area">
								<?php if(!empty($tlh_help_icon)): ?>
									<div class="contact-icon">
										<i class="fa <?php echo  esc_attr($tlh_help_icon); ?>"></i>
									</div>
								<?php endif; ?>	
								<a href="<?php echo esc_url($tlh_help_link); ?>" class="contact-info">
									<span class="title"><?php echo esc_html($tlh_help_title); ?></span>
								</a>
							</div>
						</aside>
					<?php } ?>		
			<?php
	}
}
add_action( 'instashare_abv_hdr_contact_info', 'instashare_abv_hdr_contact_info' );

/*
 *
 * Social Icon
 */
function instashare_get_social_icon_default() {
	return apply_filters(
		'instashare_get_social_icon_default', json_encode(
				 array(
				array(
					'icon_value'	  =>  esc_html__( 'fa-facebook', 'neph-soft' ),
					'link'	  =>  esc_html__( 'https://www.facebook.com/NephSoftStudio', 'neph-soft' ),
					'id'              => 'customizer_repeater_header_social_001',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-twitter', 'neph-soft' ),
					'link'	  =>  esc_html__( 'https://twitter.com/NephSoft_Studio', 'neph-soft' ),
					'id'              => 'customizer_repeater_header_social_002',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-instagram', 'neph-soft' ),
					'link'	  =>  esc_html__( 'https://www.instagram.com/nephsoftstudios/', 'neph-soft' ),
					'id'              => 'customizer_repeater_header_social_003',
				)
			)
		)
	);
}

/*
 *
 * Footer Above Default
 */
 function instashare_get_footer_above_default() {
	return apply_filters(
		'instashare_get_footer_above_default', json_encode(
				 array(
				array(
					'icon_value'       => 'fa-phone-square',
					'title'           => esc_html__( 'Call us', 'neph-soft' ),
					'text'            => esc_html__( '(+53)-5458-1277', 'neph-soft' ),
					'link'	  =>  esc_html__( 'tel:+5354581277', 'neph-soft' ),
					'id'              => 'customizer_repeater_footer_above_001',
					
				),
				array(
					'icon_value'       => 'fa-envelope-square',
					'title'           => esc_html__( 'Support Mail', 'neph-soft' ),
					'text'            => esc_html__( '@Neph·Soft·Studio', 'neph-soft' ),
					'link'	  =>  esc_html__( 'mailto:nephsoftstudio@gmail.com', 'neph-soft' ),
					'id'              => 'customizer_repeater_footer_above_002',
				
				),
				array(
					'icon_value'       => 'fa-map-marker',
					'title'           => esc_html__( 'Villa Clara, Cuba, 52 900 ', 'neph-soft' ),
					'text'            => esc_html__( '5th Str. 12, Cifuentes', 'neph-soft' ),
					'link'	  =>  esc_html__( 'https://www.google.com/maps/place/Cifuentes,+Cuba/@22.6451433,-80.0682309,14z/data=!3m1!4b1!4m6!3m5!1s0x88d521a9dba0f5ef:0xab5721ad5f4d94bc!8m2!3d22.6491239!4d-80.0479039!16s%2Fg%2F11cl_5cbj_?entry=ttu', 'neph-soft' ),
					'id'              => 'customizer_repeater_footer_above_003',
			
				),
			)
		)
	);
}


/*
 *
 * Slider Default
 */
$theme = wp_get_theme(); // gets the current theme
if ( 'Instashare' == $theme->name):	
	function instashare_get_slider_default() {
		return apply_filters(
			'instashare_get_slider_default', json_encode(
					 array(
					array(
						'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/slider/img01.jpg',
						'image_url2'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/slider/img01.jpg',
						'title'           => esc_html__( 'The entire development team is delighted to welcome you on board of', 'neph-soft' ),
						'subtitle'         => esc_html__( 'Insta', 'neph-soft' ),
						'subtitle2'         => esc_html__( 'Share', 'neph-soft' ),
						'text'            => esc_html__( 'We hope you do some amazing work here!', 'neph-soft' ),
						'text2'	  =>  esc_html__( 'Get Started', 'neph-soft' ),
						'link'	  =>  esc_html__( '#', 'neph-soft' ),
						"slide_align" => "left", 
						'id'              => 'customizer_repeater_slider_001',
					),
					array(
						'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/slider/img02.jpg',
						'image_url2'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/slider/img02.jpg',
						'title'           => esc_html__( 'Innovation is welcomed in our new', 'neph-soft' ),
						'subtitle'         => esc_html__( 'Retrieval', 'neph-soft' ),
						'subtitle2'         => esc_html__( 'System', 'neph-soft' ),
						'text'            => esc_html__( 'That stores and maintains, in a centralized and standardized manner, information in digital format.', 'neph-soft' ),
						'text2'	  =>  esc_html__( 'Get Started', 'neph-soft' ),
						'link'	  =>  esc_html__( '#', 'neph-soft' ),
						"slide_align" => "center", 
						'id'              => 'customizer_repeater_slider_002',
					),
					array(
						'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/slider/img03.jpg',
						'image_url2'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/slider/img03.jpg',
						'title'           => esc_html__( 'We provide a file upload/download service of', 'neph-soft' ),
						'subtitle'         => esc_html__( 'Digital', 'neph-soft' ),
						'subtitle2'         => esc_html__( 'Repository', 'neph-soft' ),
						'text'            => esc_html__( 'Created and built with a flexible and creative design, helping to increase customer satisfaction.', 'neph-soft' ),
						'text2'	  =>  esc_html__( 'Get Started', 'neph-soft' ),
						'link'	  =>  esc_html__( '#', 'neph-soft' ),
						"slide_align" => "right", 
						'id'              => 'customizer_repeater_slider_003',
					),
				)
			)
		);
	}
endif;


/*
 *
 * Service Default
 */
function instashare_get_service_default() {
	return apply_filters(
		'instashare_get_service_default', json_encode(
				 array(
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/service/service01.jpg',
					'icon_value'           => 'fa-usb',	
					'title'           => esc_html__( 'Secure File Transfer Solution', 'neph-soft' ),
					'subtitle'           => esc_html__( 'File Sharing Solutions', 'neph-soft' ),
					'subtitle2'           => esc_html__( 'Industry-Standard Protocols', 'neph-soft' ),
					'subtitle3'           => esc_html__( 'Encrypted File Transfer', 'neph-soft' ),
					'text'           => esc_html__( 'SFTP, FTPS, HTTPS, and AS2 ...', 'neph-soft' ),
					'text2'           => esc_html__( 'View More', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_service_001',
				),
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/service/service02.jpg',
					'icon_value'           => 'fa-cloud-download',
					'title'           => esc_html__( 'Cloud Download Service', 'neph-soft' ),
					'subtitle'           => esc_html__( 'Online Hosting Service ', 'neph-soft' ),
					'subtitle2'           => esc_html__( 'Free Files and Images', 'neph-soft' ),
					'subtitle3'           => esc_html__( 'Download and Store', 'neph-soft' ),
					'text'           => esc_html__( 'Synchronize Data', 'neph-soft' ),
					'text2'           => esc_html__( 'View More', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_service_002',				
				),
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/service/service03.jpg',
					'icon_value'           => 'fa-cloud-upload',
					'title'           => esc_html__( 'Cloud Upload Service', 'neph-soft' ),
					'subtitle'           => esc_html__( 'Minimizing Service Outage', 'neph-soft' ),
					'subtitle2'           => esc_html__( 'Fewest and Shortest Outages', 'neph-soft' ),
					'subtitle3'           => esc_html__( 'Centralized Security Policies', 'neph-soft' ),
					'text'           => esc_html__( 'Service-Level Agreements', 'neph-soft' ),
					'text2'           => esc_html__( 'View More', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_service_003',
				)
			)
		)
	);
}

/*
 *
 * Icon Menu Default
 */
 function instashare_get_icon_menu_default() {
	return apply_filters(
		'instashare_get_icon_menu_default', json_encode(
				 array(
				array(
					'title'           => esc_html__( 'File Manager', 'neph-soft' ),
					'icon_value'       => 'fa-ioxhost',
					'id'              => 'customizer_repeater_hdr_icon_menu_001',
				),
				array(
					'title'           => esc_html__( 'User Activity Log', 'neph-soft' ),
					'icon_value'       => 'fa-users',
					'id'              => 'customizer_repeater_hdr_icon_menu_002',				
				)
			)
		)
	);
}



/*
 *
 * Client Default
 */
function instashare_get_client_default() {
	return apply_filters(
		'instashare_get_client_default', json_encode(
				 array(
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/client/client01.png',
					'title'           => esc_html__( 'Creative', 'neph-soft' ),
					'subtitle'           => esc_html__( 'Business', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_client_001',
				),
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/client/client02.png',
					'title'           => esc_html__( 'Creative', 'neph-soft' ),
					'subtitle'           => esc_html__( 'Logo', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_client_002',				
				),
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/client/client03.png',
					'title'           => esc_html__( 'Website', 'neph-soft' ),
					'subtitle'           => esc_html__( 'Hosting', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_client_003',
				),
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/client/client04.png',
					'title'           => esc_html__( 'Digital', 'neph-soft' ),
					'subtitle'           => esc_html__( 'Marketing', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_client_004',
				),
				array(
					'image_url'       => NEPHSOFT_PLUGIN_URL . 'inc/instashare/images/client/client05.png',
					'title'           => esc_html__( 'Business', 'neph-soft' ),
					'subtitle'           => esc_html__( 'Group', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_client_005',
				)
			)
		)
	);
}function instashare_get_features_default() {
	return apply_filters(
		'instashare_get_features_default', json_encode(
				 array(
				array(
					'icon_value'           => 'fa-delicious',	
					'title'           => esc_html__( 'SEO Marketing', 'neph-soft' ),
					'text'           => esc_html__( 'Lorem ipsum is simple dummy', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_features_001',
				),
				array(
					'icon_value'           => 'fa-paint-brush',	
					'title'           => esc_html__( 'Web Design', 'neph-soft' ),
					'text'           => esc_html__( 'Lorem ipsum is simple dummy', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_features_002',				
				),
				array(
					'icon_value'           => 'fa-plug',	
					'title'           => esc_html__( 'Features Addons', 'neph-soft' ),
					'text'           => esc_html__( 'Lorem ipsum is simple dummy', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_features_003',
				),
				array(
					'icon_value'           => 'fa-mixcloud',	
					'title'           => esc_html__( 'Cloud Host', 'neph-soft' ),
					'text'           => esc_html__( 'Lorem ipsum is simple dummy', 'neph-soft' ),
					'link'       => '#',
					'id'              => 'customizer_repeater_features_004',
				)
			)
		)
	);
}