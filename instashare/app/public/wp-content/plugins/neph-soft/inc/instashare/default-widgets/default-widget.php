<?php
$activate = array(
        'instashare-sidebar-primary' => array(
            'search-1',
            'recent-posts-1',
            'archives-1',
        ),
		'instasharet-footer-1' => array(
			 'text-1',
        ),
		'instashare-footer-2' => array(
			 'categories-1',
        ),
		'instashare-footer-3' => array(
			 'search-1',
        )
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
		2 => array('title' => 'Recent Posts'),
		3 => array('title' => 'Categories'), 
        ));
		 update_option('widget_categories', array(
			1 => array('title' => 'Categories'), 
			2 => array('title' => 'Categories')));

		update_option('widget_archives', array(
			1 => array('title' => 'Archives'), 
			2 => array('title' => 'Archives')));
			
		update_option('widget_search', array(
			1 => array('title' => 'Search'), 
			2 => array('title' => 'Search')));	
		
    update_option('sidebars_widgets',  $activate);
	$MediaId = get_option('instashare_media_id');
	set_theme_mod( 'custom_logo', $MediaId[0] );
	set_theme_mod('nav_btn_lbl','Book Now');
?>