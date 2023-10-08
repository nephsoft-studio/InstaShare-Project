<?php
$activate = array(
        'instashare-sidebar-primary' => array(),
		'instasharet-footer-1' => array(
			 'text-1',
        ),
		'instashare-footer-2' => array(),
		'instashare-footer-3' => array()
    );
    /* the default titles will appear */
   update_option('widget_text', array(  
		1 => array('title' => 'About Insta·Share',
        'text'=>'<div class="textwidget">
				<p>'.sprintf(__('%s','neph-soft'),NEPHSOFT_FOOTER_ABOUT).'</p>
				<div class="footer-badge">
					<img src="'.NEPHSOFT_PLUGIN_URL.'inc/instashare/images/footer/about-01.png" alt="">
					<img src="'.NEPHSOFT_PLUGIN_URL.'inc/instashare/images/footer/about-02.png" alt="">
					<img src="'.NEPHSOFT_PLUGIN_URL.'inc/instashare/images/footer/about-03.png" alt="">
				</div>
			</div>'),		
        ));		
    update_option('sidebars_widgets',  $activate);
	$MediaId = get_option('instashare_media_id');
	set_theme_mod( 'custom_logo', $MediaId[0] );
	set_theme_mod('nav_btn_lbl','Book Now');
?>