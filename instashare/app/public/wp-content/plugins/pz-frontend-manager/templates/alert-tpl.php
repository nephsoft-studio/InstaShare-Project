<!-- Toast container -->
<div style="position: absolute; top: 1rem; right: 1rem; z-index: 999999;">
    <!-- Toast -->
    <div class="toast show" id="toastBasic" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
        <div class="toast-header <?php echo esc_attr( $background ); ?>">
            <label class="text-white mb-0"><i class="mr-2 fa fas fa-bell text-white"></i><?php echo esc_html( $message ); ?></label>
            <button class="ml-2 mb-1 close text-white toastClose" type="button" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
		</div>
    </div>
    <script>
        setTimeout( function(){
            jQuery('body').find('.toast.show').remove();
        }, 5000 );
    </script>
</div>