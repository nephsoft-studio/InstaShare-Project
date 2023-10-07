<?php  
	$cta_hs 			= get_theme_mod('cta_hs','1');
	$cta_call_icon 		= get_theme_mod('cta_call_icon','fa-files-o');
	$cta_call_title		= get_theme_mod('cta_call_title',__('New, Fast','neph-soft')); 
	$cta_call_text		= get_theme_mod('cta_call_text',__('and Effective Method','neph-soft'));
	$cta_right_icon		= get_theme_mod('cta_right_icon','fa-file-text'); 
	$cta_title			= get_theme_mod('cta_title',__('Try Our Newest Repository Service!','neph-soft'));
	$cta_description	= get_theme_mod('cta_description',__('Repository services support the ongoing administration, maintenance and preservation activities of digital collection management, as well as providing access to content. Below we offer these services as they could be used in a digital object.','neph-soft'));
	$cta_btn_icon		= get_theme_mod('cta_btn_icon','fa-angle-right');
	$cta_btn_lbl		= get_theme_mod('cta_btn_lbl',__('Start Now!','neph-soft')); 	
	$cta_btn_link		= get_theme_mod('cta_btn_link');
	$cta_effect_enable	= get_theme_mod('cta_effect_enable','1');
	if($cta_hs=='1'){
?>
<section id="cta-section" class="cta-section home-cta <?php if($cta_effect_enable=='1'): echo esc_attr_e('cta-effect-active','neph-soft'); endif; ?>">
	<div class="cta-overlay">
		<div class="av-container">
			<div class="av-columns-area">
				<div class="av-column-5 my-auto">
					<div class="call-wrapper">
						<?php if(!empty($cta_call_icon)): ?>
							<div class="call-icon-box"><i class="fa <?php echo esc_attr($cta_call_icon); ?>"></i></div>
						<?php endif; ?>
						<?php if(!empty($cta_call_title) || !empty($cta_call_text)): ?>
							<div class="cta-info">
								<div class="call-title"><?php echo wp_kses_post($cta_call_title); ?></div>
								<div class="call-phone"><?php echo wp_kses_post($cta_call_text); ?></div>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="av-column-7 my-auto">
					<div class="cta-content-wrap">
						<div class="cta-content">
							<?php if(!empty($cta_right_icon)): ?>
								<span class="cta-icon-wrap"><i class="fa <?php echo esc_attr($cta_right_icon); ?>"></i></span>
							<?php endif; ?>
							<?php if(!empty($cta_title)): ?>
								<h4><?php echo wp_kses_post($cta_title); ?></h4>
							<?php endif; ?>
							<?php if(!empty($cta_description)): ?>
								<p><?php echo wp_kses_post($cta_description); ?></p>
							<?php endif; ?>
						</div>
						
						<?php if(!empty($cta_btn_lbl)  || !empty($cta_btn_icon)): ?>
							<div class="cta-btn">
								<a href="<?php echo esc_url($cta_btn_link); ?>" class="av-btn av-btn-primary av-btn-bubble"><?php echo esc_html($cta_btn_lbl); ?> <i class="fa <?php echo esc_attr($cta_btn_icon); ?>"></i> <span class="bubble_effect"><span class="circle top-left"></span> <span class="circle top-left"></span> <span class="circle top-left"></span> <span class="button effect-button"></span> <span class="circle bottom-right"></span> <span class="circle bottom-right"></span> <span class="circle bottom-right"></span></span></a>
							</div>
						<?php endif; ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>