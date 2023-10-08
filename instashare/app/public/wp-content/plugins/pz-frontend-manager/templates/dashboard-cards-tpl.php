<?php do_action( 'pzfm_before_dashboard_items' ); ?>
<?php if( !empty( pzfm_after_dashboard_cards_items() ) ) : ?>
<div class="row pzfm-cards-main">
    <?php foreach( pzfm_after_dashboard_cards_items() as $key => $dashboard_value ) : ?>
    	<?php if ( pzfm_default_dash_layout() ){
    		echo pzfm_dashboard_customize( $key ); 
    	}else{
    		echo pzfm_dashboard_generator( $key ); 
    	}
    	?>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php do_action( 'pzfm_after_dashboard_items' ); ?>