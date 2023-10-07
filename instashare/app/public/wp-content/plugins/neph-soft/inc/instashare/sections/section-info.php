<?php  
   if (  is_active_sidebar( 'instashare-info-sidebar' ) ) {
?>	
<div id="info-section" class="">
	<div class="av-container">
		<?php dynamic_sidebar('instashare-info-sidebar'); ?>
	</div>
</div>
<?php } ?>