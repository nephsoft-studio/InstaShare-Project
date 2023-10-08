
<?php do_action( 'pzfm_before_user_view_content', $user_id ); ?>
<div class="row">
    <?php do_action( 'pzfm_before_user_view_row', $user_id ); ?>
    <div class="col-12 mb-4 mt-5 pt-4">
        <?php do_action( 'pzfm_before_user_view_col', $user_id ); ?>
        <div class="card shadow">
            <div class="card-body pzfm-header">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 ">
                        <?php do_action( 'pzfm_view_before_profile_picture', $user_id ); ?>
                        <div class="view-profile-pic-wrap text-center text-sm-left">
                            <img alt="" src="<?php echo pzfm_user_avatar_url( $user_id ); ?>" class="avatar avatar-128 photo photo-inner" height="170" width="170" loading="lazy" decoding="async">
                        </div>
                        <?php do_action( 'pzfm_view_after_profile_picture', $user_id ); ?>
                    </div>
                    <div class="col-xl-10 col-lg-9 mt-3 mt-lg-0 text-center text-sm-left pzfm_view_before_personal_info">
                        <?php do_action( 'pzfm_view_before_personal_info', $user_id ); ?>
                        <div class="row pl-xl-4">
                            <?php foreach( pzfm_personal_info_fields() as $form_key => $form_fields ): ?>
                                <?php 
                                    $key = ucwords(str_replace('_', ' ', $form_key));
                                    $value = get_user_meta( $user_id, $form_key, true ) ? : '';
                                    if( $form_key == 'country' ){
                                        $value = pzfm_get_country_name($value);
                                    }
                                ?>
                                <div class="col-lg-6">
                                    <p class="mb-1 <?php echo esc_attr($key); ?>"><span class="strong d-none d-sm-inline"><?php echo esc_html( $key ); ?>:</span> <span class="text-break"><?php echo esc_html( $value ); ?></span></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php do_action( 'pzfm_view_after_personal_info', $user_id ); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php do_action( 'pzfm_after_user_view_col', $user_id ); ?>
    </div>
    <?php do_action( 'pzfm_after_user_view_row', $user_id ); ?>
</div>
<div class="row">
<?php do_action( 'pzfm_after_user_view_content', $user_id ); ?>
</div>