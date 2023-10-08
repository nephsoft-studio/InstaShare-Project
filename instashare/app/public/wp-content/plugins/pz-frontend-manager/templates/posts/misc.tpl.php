<?php
if( !empty( pzfm_parameters( 'id' ) ) ){
  $post_status = get_post_status( pzfm_parameters( 'id' ) );
}
$post_statuses          = get_post_statuses();
$visibility_statuses    = $post_statuses;
unset( $post_statuses['private'] );
$status_label   = array_key_exists( $post_status, $post_statuses ) ? $post_statuses[$post_status] : $post_status ;
$visibility_label = esc_html__('Public', 'pz-frontend-manager');
if( $post_status == 'private' ){
    $status_label = esc_html__('Privately Published', 'pz-frontend-manager');
    $visibility_label = esc_html__('Private', 'pz-frontend-manager');
}
if( $post->post_password ){
    $visibility_label = esc_html__('Password protected', 'pz-frontend-manager');
}
if( is_sticky( $post_id ) ){
    $visibility_label = esc_html__('Public, Sticky', 'pz-frontend-manager');
}
if( $post_status != 'publish' ){
    unset( $post_statuses['publish'] );
}

if( ! function_exists( 'touch_time' ) ) {
    require_once( ABSPATH . '/wp-admin/includes/template.php' );
}

?>
<div id="pzfm-publish_card" class="card shadow mb-4">
    <div class="card-header pzfm-header">
        <?php esc_html_e( 'Publish', 'pz-frontend-manager' ); ?>
    </div>
    <div class="card-body">
        <div id="pzfm-btn-publishing-actions">
            <input type="submit" class="btn btn-sm btn-pzfm" name="pzfm_draft_post" value="<?php esc_html_e( apply_filters( 'pzfm_draft_post_label' ,'Save as draft'), 'pz-frontend-manager' ); ?>"/>
        </div>
         <!-- post status -->
        <div id="pzfm-misc-publishing-actions" class="mt-3">
            <section class="misc-pub-post-status">
                <i class="fas fa-key text-muted mr-2"></i> <?php _e('Status', 'pz-frontend-manager'); ?>: <span id="post-status-display" class="font-weight-bold"><?php echo esc_html( $status_label ); ?></span> <a href="#post_status" class="edit-post-status"><?php _e('Edit', 'pz-frontend-manager'); ?></a>
                <div id="post-status-select" class="mt-2 d-none align-items-center">
                    <input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( $post_status ); ?>">
                    <label for="post_status" class="sr-only"><?php _e('Set status', 'pz-frontend-manager'); ?></label>
                    <select name="post_status" id="post_status" class="form-control form-control-sm d-inline" style="width:initial;">
                        <?php foreach ( $post_statuses as $key => $status ): ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $post_status, $key ); ?>><?php echo esc_html( $status ); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a href="#post_status" class="save-post-status btn btn-sm btn-secondary"><?php _e('OK', 'pz-frontend-manager'); ?></a>
                    <a href="#post_status" class="cancel-post-status hide-if-no-js button-cancel"><?php _e('Cancel', 'pz-frontend-manager'); ?></a>
                </div>
            </section>
        </div>
        <!-- Post Visibility --> 
        <div class="pzfm-misc-pub-visibility my-3" id="visibility">
            <i class="fas fa-eye text-muted mr-2"></i> <?php _e('Visibility', 'pz-frontend-manager'); ?>: <span id="post-visibility-display" class="font-weight-bold"><?php echo esc_html( $visibility_label ); ?></span> <a href="#post_visibility" class="edit-visibility"><?php _e('Edit', 'pz-frontend-manager'); ?>  <span class="sr-only"><?php _e('Edit visibility', 'pz-frontend-manager'); ?></span></a>

            <div id="post-visibility-select" class="d-none">
                <input type="hidden" name="hidden_visibility_status" value="">
                <input type="radio" name="visibility" id="visibility-radio-public" value="public" checked> 
                <label  for="visibility-radio-public" class="selectit"><?php _e('Public', 'pz-frontend-manager'); ?></label><br>

                <span id="sticky-span" class="d-none" style="margin-left: 18px;">
                    <input id="sticky" name="sticky" type="checkbox" value="1" <?php checked( is_sticky($post_id ), 1 ); ?>> 
                    <label for="sticky" class="selectit text-sm"><?php _e('Stick this post to the front page', 'pz-frontend-manager'); ?></label><br>
                </span>
                
                <input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php echo !empty($post->post_password) ? 'checked' : '' ; ?>> 
                <label for="visibility-radio-password" class="selectit"><?php _e('Password protected', 'pz-frontend-manager'); ?></label><br>

                <span id="password-span" class="d-none" >
                    <label for="post_password"><?php _e('Password', 'pz-frontend-manager'); ?>:</label> 
                    <input type="text" class="form-control form-control-sm" name="post_password" id="post_password" value="<?php echo esc_attr( $post->post_password ); ?>" maxlength="255"><br>
                </span>

                <input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php checked( $post_status, 'private'); ?>> 
                <label for="visibility-radio-private" class="selectit"><?php _e('Private', 'pz-frontend-manager'); ?></label><br>

                <p class="mb-0">
                    <a href="#visibility" class="save-post-visibility btn btn-sm btn-secondary"><?php esc_html_e('OK', 'pz-frontend-manager'); ?></a>
                    <a href="#visibility" class="cancel-post-visibility hide-if-no-js button-cancel"><?php esc_html_e('Cancel', 'pz-frontend-manager'); ?></a>
                </p>
            </div>
        </div>
        <!-- Post publis date -->
        <div class="misc-pub-section curtime misc-pub-curtime mb-3">
            <input type="hidden" name="hidden_currtime_update" value="">
            <span id="timestamp">
                <i class="fas fa-calendar text-muted mr-2"></i>
                <?php
                if( $post->post_status != 'auto-draft' ):
                    $uploaded_on = sprintf(
                        /* translators: Publish box date string. 1: Date, 2: Time. See https://www.php.net/manual/datetime.format.php */
                        __( '%1$s at %2$s' ),
                        /* translators: Publish box date format, see https://www.php.net/manual/datetime.format.php */
                        date_i18n( _x( 'M j, Y', 'publish box date format' ), strtotime( $post->post_date ) ),
                        /* translators: Publish box time format, see https://www.php.net/manual/datetime.format.php */
                        date_i18n( _x( 'H:i', 'publish box time format' ), strtotime( $post->post_date ) )
                    );
                    /* translators: Attachment information. %s: Date the attachment was uploaded. */
                    printf( __( 'Date Published: %s', 'pz-frontend-manager' ), '<b>' . $uploaded_on . '</b>' );
                else:
                    printf( __( 'Date Published: %s', 'pz-frontend-manager' ), '<b>' . __('Immediately', 'pz-frontend-manager' ). '</b>' );
                endif;
                ?>
                <a href="#edit_timestamp" class="edit-timestamp"><?php _e('Edit', 'pz-frontend-manager'); ?>  <span class="sr-only"><?php _e('Edit date and time', 'pz-frontend-manager'); ?></span></a>
            </span>
            <fieldset id="timestampdiv" class="d-none">
                <legend class="screen-reader-text"><?php _e( 'Date and time', 'pz-frontend-manager' ); ?></legend>
                <?php touch_time( 1, 1 ); ?>
            </fieldset>
        </div><!-- .misc-pub-section -->
    </div>
    <div class="card-footer">
        <input type="hidden" name="id" value="<?php echo (int)$post_id; ?>">
        <input type="submit" class="btn btn-sm btn-pzfm" name="pzfm_publish_posts" value="<?php echo esc_attr( $publish_label ); ?>"/>
    </div>
</div>