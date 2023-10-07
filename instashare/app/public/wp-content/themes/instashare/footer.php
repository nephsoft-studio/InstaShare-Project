<div class="footer-one">
    <?php do_action('instashare_above_footer'); ?>
</div>
</div> 
 <!--===// Start: Footer
    =================================-->
<?php 
$instashare_footer_effect_enable	= get_theme_mod('footer_effect_enable','1');
?>	
    <footer id="footer-section" class="footer-one footer-section  <?php if($instashare_footer_effect_enable=='1'): echo esc_attr_e('footer-effect-active','instashare'); endif; ?>">
		<?php 
			$instashare_footer_middle_content	= get_theme_mod('footer_widget_middle_content','<i class="fa fa-expeditedssl"></i>');		
			if(is_active_sidebar( 'instashare-footer-1' )  || is_active_sidebar( 'instashare-footer-2' )  || is_active_sidebar( 'instashare-footer-3' )) { 
		?>
        <div class="footer-main">
            <div class="av-container">
			   <div class="av-columns-area">
					<?php if ( is_active_sidebar( 'instashare-footer-1' ) ) : ?>
						<div class="av-column-6 col-md-6 mb-xl-0 mb-4 pr-md-5">
						   <?php dynamic_sidebar( 'instashare-footer-1'); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'instashare-footer-2' ) ) : ?>
						<div class="av-column-3 col-md-6 mb-xl-0 mb-4 pl-md-5">
						   <?php dynamic_sidebar( 'instashare-footer-2'); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'instashare-footer-3' ) ) : ?>
						<div class="av-column-3 col-md-6 mb-xl-0 mb-4">
							<?php dynamic_sidebar( 'instashare-footer-3'); ?>
						</div>
					<?php endif; ?>
				</div>	       
            </div>
			<?php if(!empty($instashare_footer_middle_content)): ?>
				<div class="footer-info-overwrap"><div class="icon"><?php echo wp_kses_post($instashare_footer_middle_content); ?></div></div>
			<?php endif; ?>	
        </div>
		
		<?php
			}
			$instashare_footer_first_img 	= get_theme_mod('footer_first_img',esc_url(get_template_directory_uri() .'/assets/images/logo2.png'));
			if ( function_exists( 'instashare_get_social_icon_default' ) ) :
				$instashare_footer_social_icons 	= get_theme_mod('footer_social_icons',instashare_get_social_icon_default());
			else:
				$instashare_footer_social_icons 	= get_theme_mod('footer_social_icons');
			endif;	
			$instashare_copyright 	= get_theme_mod('footer_third_custom','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');
			if(!empty($instashare_footer_first_img) || !empty($instashare_footer_social_icons)  || !empty($instashare_copyright)) {
		?>
			<div class="footer-copyright">
				<div class="av-container">
					<div class="av-columns-area">
							<div class="av-column-4 av-md-column-6 text-md-left text-center">
								<div class="widget-left">
									<?php  if ( ! empty( $instashare_footer_first_img ) ){ ?>
										<div class="logo">
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><img src="<?php echo esc_url($instashare_footer_first_img); ?>"></a>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="av-column-4 av-md-column-6 text-md-center text-center">
								<div class="widget-center">
									<?php if( $instashare_footer_social_icons!='' ){ ?>
										<aside class="share-toolkit widget widget_social_widget">
											<ul>
												<?php
													$instashare_footer_social_icons = json_decode($instashare_footer_social_icons);
													foreach($instashare_footer_social_icons as $social_item){	
													$social_icon = ! empty( $social_item->icon_value ) ? apply_filters( 'instashare_translate_single_string', $social_item->icon_value, 'Footer section' ) : '';	
													$social_link = ! empty( $social_item->link ) ? apply_filters( 'instashare_translate_single_string', $social_item->link, 'Footer section' ) : '';
												?>
													<li><a href="<?php echo esc_url( $social_link ); ?>"><i class="fa <?php echo esc_attr( $social_icon ); ?>"></i></a></li>
												<?php } ?>
											</ul>
										</aside>
									<?php } ?>
								</div>
							</div>
							<div class="av-column-4 av-md-column-6 text-av-right text-md-left text-center">
								<div class="widget-right">                          
									<?php 	
										$instashare_copyright_allowed_tags = array(
											'[current_year]' => date_i18n('Y'),
											'[site_title]'   => get_bloginfo('name'),
											'[theme_author]' => sprintf(__('<a href="https://www.nayrathemes.com/instashare-free/" target="_blank">Instashare</a>', 'instashare')),
										);
									?>                        
									<div class="copyright-text">
										<?php
											echo apply_filters('instashare_footer_copyright', wp_kses_post(instashare_str_replace_assoc($instashare_copyright_allowed_tags, $instashare_copyright)));
										?>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		<?php } ?>
    </footer>
    <!-- End: Footer
    =================================-->
    
    <!-- ScrollUp -->
	<?php 
		$instashare_hs_scroller 	= get_theme_mod('hs_scroller','1');		
		if($instashare_hs_scroller == '1') :
	?>
		<button type=button class="scrollup"><i class="fa fa-eject"></i></button>
	<?php endif; ?>
</div>
<?php 
wp_footer(); ?>
</body>
</html>
