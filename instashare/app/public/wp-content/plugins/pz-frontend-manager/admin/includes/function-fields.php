<?php
function pzfm_field_generator( $field_data, $field_meta, $value = '', $class='', $placeholder = '' ){
	ob_start();
	$field_atts = '';
	$field_atts .= $field_data['required'] == true ? ' required' : '';
	$field_atts .= $field_data['read-only'] == true ? ' readonly' : '';
	$field_required = $field_data['required'] == true ? ' <span class="text-danger">*</span>' : '';
	if( !in_array( $field_data['field'], array( 'radio', 'file', 'checkbox' ) ) ){
		$class .= ' form-control form-control-sm';
	}
	?>
	<?php if( $field_data['field'] == 'textarea' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?> <?php echo (!empty($field_data['tooltip'])) ? 'input-group' : ''; ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ); ?>" class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<textarea id="<?php echo esc_attr( $field_meta ); ?>" class="<?php echo esc_attr( $class ); ?>" aria-describedby="basic-addon2" name="<?php echo esc_attr( $field_meta ); ?>" <?php echo esc_attr( $field_atts ); ?>><?php echo esc_html( $value ); ?></textarea>
			<?php if(!empty($field_data['tooltip'])) : ?>
			<div class="input-group-append d-flex align-items-center p-2">
				<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="<?php echo esc_attr( $field_data['tooltip_position'] ); ?>" title="<?php echo esc_attr( $field_data['tooltip_description'] ); ?>"></i>
			</div>
			<?php endif; ?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'select' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?> <?php echo (!empty($field_data['tooltip'])) ? 'input-group' : ''; ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ); ?>" class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<select id="<?php echo esc_attr( $field_meta ); ?>" class="<?php echo esc_attr( $class ); ?> pzfm-select-field" name="<?php echo esc_attr( $field_meta ); ?>" aria-describedby="basic-addon2" <?php echo esc_attr( $field_atts ); ?>>';		
				<option value="" readonly>-- <?php esc_html_e('Select', 'pz-frontend-manager' )?> --</option>		
				<?php if( !empty( $field_data['options'] ) ): ?>
					<?php foreach ( $field_data['options'] as $key => $_value): ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php echo $key == $value ? 'selected' : '';  ?>><?php echo esc_html( trim($_value) ); ?></option>
					<?php endforeach; ?>
				<?php endif;?>
			</select>
			<?php if(!empty($field_data['tooltip'])) : ?>
			<div class="input-group-append d-flex align-items-center p-2">
				<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="<?php echo esc_attr( $field_data['tooltip_position'] ); ?>" title="<?php echo esc_attr( $field_data['tooltip_description'] ); ?>"></i>
			</div>
			<?php endif; ?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'radio' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<?php if( !empty( $field_data['options'] ) ): ?>
				<?php foreach ( $field_data['options'] as $_value): ?>
					<?php $field_atts = $_value == $value ? 'checked' : ''; ?>
					<input class="<?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $field_meta.'_'.$_value ) ; ?>" type="radio" name="<?php echo esc_attr( $field_meta ); ?>" value="<?php echo esc_attr( $_value ); ?>" <?php echo esc_attr( $field_atts ); ?>>
					<label for="<?php echo esc_attr( $field_meta.'_'.$_value ); ?>"><?php echo ucfirst( esc_html( $_value ) ); ?></label><br>
				<?php endforeach; ?>
			<?php endif;?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'checkbox' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label class="col-md-12 pl-0 pt-2 strong">
				<?php echo esc_html( $field_data['label'] ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
			</label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<?php if( !empty( $field_data['options'] ) ): 
				$cb_value = $value  ? $value : array(); ?>
				<?php foreach ( $field_data['options'] as $_value): ?>
					<?php $field_atts = in_array($_value, $cb_value) ? 'checked': ''; ?>
					<input type="checkbox" class="<?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $field_meta.'_'.$_value ); ?>" name="<?php echo esc_attr( $field_meta ); ?>[]" value="<?php echo esc_attr( $_value ); ?>" <?php echo esc_attr( $field_atts ); ?>>
					<label for="<?php echo esc_attr( $field_meta.'_'.$_value ); ?>"><?php echo ucfirst( esc_html( $_value ) ); ?></label><br>
				<?php endforeach; ?>
			<?php endif;?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'number' ): ?>
		<?php
			$min = !empty( $field_data['options'] ) ? $field_data['options'][0] : '';
			$max = !empty( $field_data['options'] ) ? $field_data['options'][1] : '';
		?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?> <?php echo (!empty($field_data['tooltip'])) ? 'input-group' : ''; ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ); ?>" class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<input id="<?php echo esc_attr( $field_meta ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" class="<?php echo esc_attr( $class ); ?>" aria-describedby="basic-addon2" type="<?php echo esc_attr( $field_data['field'] ); ?>" name="<?php echo esc_attr(  $field_meta ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $field_atts ); ?>>
			<?php if(!empty($field_data['tooltip'])) : ?>
			<div class="input-group-append d-flex align-items-center p-2">
				<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="<?php echo esc_attr( $field_data['tooltip_position'] ); ?>" title="<?php echo esc_attr( $field_data['tooltip_description'] ); ?>"></i>
			</div>
			<?php endif; ?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'time' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?> <?php echo (!empty($field_data['tooltip'])) ? 'input-group' : ''; ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ); ?>" class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<input id="<?php echo esc_attr( $field_meta ); ?>" class="<?php echo esc_attr( $class ); ?>" aria-describedby="basic-addon2" type="<?php echo esc_attr( $field_data['field'] ); ?>" name="<?php echo esc_attr( $field_meta ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $field_atts ); ?>>
			<?php if(!empty($field_data['tooltip'])) : ?>
			<div class="input-group-append d-flex align-items-center p-2">
				<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="<?php echo esc_attr( $field_data['tooltip_position'] ); ?>" title="<?php echo esc_attr( $field_data['tooltip_description'] ); ?>"></i>
			</div>
			<?php endif; ?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'date' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?> <?php echo (!empty($field_data['tooltip'])) ? 'input-group' : ''; ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ); ?>" class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<input id="<?php echo esc_attr( $field_meta ); ?>" class="<?php echo esc_attr( $class ); ?>" aria-describedby="basic-addon2" type="<?php echo esc_attr( $field_data['field'] ); ?>" name="<?php echo esc_attr( $field_meta ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $field_atts ); ?>>
			<?php if(!empty($field_data['tooltip'])) : ?>
			<div class="input-group-append d-flex align-items-center p-2">
				<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="<?php echo esc_attr( $field_data['tooltip_position'] ); ?>" title="<?php echo esc_attr( $field_data['tooltip_description'] ); ?>"></i>
			</div>
			<?php endif; ?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'file' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ); ?>" class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<input id="<?php echo esc_attr( $field_meta ); ?>" class="<?php echo esc_attr( $class ); ?>" type="file" name="<?php echo esc_attr( $field_meta ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $field_atts ); ?>>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php elseif( $field_data['field'] == 'url' ): ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ).'_link'; ?>" class="col-md-12 pl-0 pt-2"><?php esc_html_e( 'Link', 'pz-frontend-manager' ); ?></label>
			<input id="<?php echo esc_attr( $field_meta ).'_link'; ?>" class="<?php echo esc_attr( $class ); ?>" type="text" name="<?php echo esc_attr( $field_meta ); ?>[link]" value="<?php echo esc_attr( $value['link'] ); ?>" <?php echo esc_attr( $field_atts ); ?>>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php else: ?>
		<div class="<?php echo esc_attr( $field_data['wrapper_class'] ); ?> <?php echo (!empty($field_data['tooltip'])) ? 'input-group' : ''; ?>">
			<?php do_action('pzfm_field_generator_before_'.$field_meta, $field_data, $value ); ?>
			<label for="<?php echo esc_attr( $field_meta ); ?>" class="col-md-12 pl-0 pt-2 strong">
                <?php echo esc_html( $field_data['label'] ); ?>
                <?php _e( $field_required ); ?>
				<?php do_action('pzfm_field_generator_after_label_'.$field_meta, $field_data, $value ); ?>
            </label>
			<?php do_action('pzfm_field_generator_middle_'.$field_meta, $field_data, $value ); ?>
			<input id="<?php echo esc_attr( $field_meta ); ?>" class="<?php echo esc_attr( $class ); ?>" aria-describedby="basic-addon2" type="<?php echo esc_attr( $field_data['field'] ); ?>" name="<?php echo esc_attr( $field_meta ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $field_atts ); ?>>
			<?php if(!empty($field_data['tooltip'])) : ?>
			<div class="input-group-append d-flex align-items-center p-2">
				<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="<?php echo esc_attr( $field_data['tooltip_position'] ); ?>" title="<?php echo esc_attr( $field_data['tooltip_description'] ); ?>"></i>
			</div>
			<?php endif; ?>
			<?php do_action('pzfm_field_generator_after_'.$field_meta, $field_data, $value ); ?>
		</div>
	<?php endif; ?>
	<?php
	$field = ob_get_clean();
	$field = apply_filters( 'pzfm_field_generator_template_'.$field_meta, $field, $field_data, $value );
	return $field;
}
function pzfm_editor_field( $editor_id, $content ){
	$settings =   array(
        'wpautop' 		=> true, 
        'media_buttons' => true, 
        'textarea_name' => $editor_id, 
        'textarea_rows' => get_option('default_post_edit_rows', 10),
        'tabindex' 		=> '',
        'editor_css' 	=> '', 
        'editor_class' 	=> '', 
        'teeny' 		=> false, 
        'dfw' 			=> false, 
        'tinymce' 		=> true, 
        'quicktags' 	=> true 
    );
	return wp_editor( $content, $editor_id, $settings );
}
function pzfm_personal_info_fields(){
	$email_field = pzfm_parameters('action') != 'add-user' && is_user_logged_in() ? true : false;
	$pzfm_personal_info_fields = array(
			'first_name' => array(
				'id'			=> 'first_name',
				'label'			=> __('First Name', 'pz-frontend-manager'),
				'field'			=> 'text',
				'required'		=> true,
				'read-only'		=> false,
				'options'		=> array(),
				'wrapper_class'	=> 'first_name col-md-6 mb-3',
			),
			'last_name' => array(
				'id'			=> 'last_name',
				'label'			=> __('Last Name', 'pz-frontend-manager'),
				'field'			=> 'text',
				'required'		=> true,
				'read-only'		=> false,
				'options'		=> array(),
				'wrapper_class'	=> 'last_name col-md-6 mb-3'
			),
			'email' => array(
				'id'			=> 'email',
				'label'			=> __('Email', 'pz-frontend-manager'),
				'field'			=> 'email',
				'required'		=> true,
				'read-only'		=> $email_field,
				'options'		=> array(),
				'wrapper_class'	=> 'email col-md-6 mb-3'
			),
			'phone'     => array(
				'id'			=> 'phone',
				'label'			=> __('Phone', 'pz-frontend-manager'),
				'field'			=> 'text',
				'required'		=> false,
				'read-only'		=> false,
				'options'		=> array(),
				'wrapper_class'	=> 'phone col-md-6 mb-3'
			),
			'address'     => array(
				'id'			=> 'address',
				'label'			=> __('Complete Address', 'pz-frontend-manager'),
				'field'			=> 'text',
				'required'		=> false,
				'read-only'		=> false,
				'options'		=> array(),
				'wrapper_class'	=> 'address col-md-6 mb-3'
			),
			'country'     => array(
				'id'			=> 'country',
				'label'			=> __('Country', 'pz-frontend-manager'),
				'field'			=> 'select',
				'required'		=> false,
				'read-only'		=> false,
				'options'		=> pzfm_country_list(),
				'wrapper_class'	=> 'country pzfm-select-input col-md-6 mb-3'
			),
    );
	if( pzfm_map_integ() ){
		$pzfm_personal_info_fields['user_latitude'] = array(
			'id'			=> 'user_latitude',
			'label'			=> '',
			'field'			=> 'hidden',
			'required'		=> false,
			'read-only'		=> false,
			'options'		=> array(),
			'wrapper_class'	=> 'user_latitude col-md-6 mb-3',
		);
		$pzfm_personal_info_fields['user_longitude'] = array(
			'id'			=> 'user_longitude',
			'label'			=> '',
			'field'			=> 'hidden',
			'required'		=> false,
			'read-only'		=> false,
			'options'		=> array(),
			'wrapper_class'	=> 'user_longitude col-md-6 mb-3',
		);
	}
	if(pzfm_parameters('dashboard') == pzfm_profile_page()){
		$pzfm_personal_info_fields['country'] = array(
			'id'			=> 'country',
			'label'			=> __('Country', 'pz-frontend-manager'),
			'field'			=> 'select',
			'required'		=> false,
			'read-only'		=> false,
			'options'		=> pzfm_country_list(),
			'wrapper_class'	=> 'country pzfm-select-input col-md-6 mb-3',
		);
		$pzfm_personal_info_fields['description'] = array(
			'id'			=> 'description',
            'label'			=> __('Biographical Info', 'pz-frontend-manager'),
            'field'			=> 'textarea',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'description col-md-12'
        );
	}
    return apply_filters( 'pzfm_personal_info_fields', $pzfm_personal_info_fields );
}
function pzfm_password_fields(){
	$pzfm_password_fields = array(
        '_password' => array(
			'id'			=> '_password',
            'label'			=> __('Password', 'pz-frontend-manager'),
            'field'			=> 'password',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> '_password'
        ),
        '_confirmed_password' => array(
			'id'			=> '_confirmed_password',
            'label'			=> __('Confirm Password', 'pz-frontend-manager'),
            'field'			=> 'password',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> '_confirmed_password'
        )
    );
	return apply_filters( 'pzfm_password_fields', $pzfm_password_fields );
}
function pzfm_categories_fields( $taxonomy ){
	$pzfm_categories_fields = array(
        'name' => array(
			'id'			=> 'name',
            'label'			=> __('Name', 'pz-frontend-manager'),
            'field'			=> 'text',
            'required'		=> true,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'name col-md-12'
        ),
        'slug'     => array(
			'id'			=> 'slug',
            'label'			=> __( 'Slug', 'pz-frontend-manager' ),
            'field'			=> 'text',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'slug col-md-12'
        ),
        'parent'     => array(
			'id'			=> 'parent',
            'label'			=> __( 'Parent', 'pz-frontend-manager' ),
            'field'			=> 'select',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> pzfm_get_term_list( $taxonomy ),
			'wrapper_class'	=> 'parent col-md-12'
        ),
        'description'     => array(
			'id'			=> 'description',
            'label'			=> __( 'Description', 'pz-frontend-manager' ),
            'field'			=> 'textarea',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'description col-md-12'
        ),
    );
	return apply_filters( 'pzfm_categories_fields', $pzfm_categories_fields );
}
function pzfm_tags_fields(){
	$pzfm_tags_fields = array(
        'name' => array(
			'id'			=> 'name',
            'label'			=> __('Name', 'pz-frontend-manager'),
            'field'			=> 'text',
            'required'		=> true,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'name col-md-12'
        ),
        'slug'     => array(
			'id'			=> 'slug',
            'label'			=> __( 'Slug', 'pz-frontend-manager' ),
            'field'			=> 'text',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'slug col-md-12'
        ),
        'description'     => array(
			'id'			=> 'description',
            'label'			=> __( 'Description', 'pz-frontend-manager' ),
            'field'			=> 'textarea',
            'required'		=> false,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'description col-md-12'
        ),
    );
	return apply_filters( 'pzfm_tags_fields', $pzfm_tags_fields );
}
function pzfm_get_term_template( $taxonomy, $object, $term_fields ){
	$prefix   		= pzfm_add_prefix( count( get_ancestors( $object->term_id, $taxonomy ) ) );
	$colcounter 	= 0;
	$dashboard_url 	= get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page();
	ob_start();
	?>
	<tr class="pz-row pzpost-row">
		<td class="align-middle">
			<input type="checkbox" value="<?php echo (int)$object->term_id; ?>" name="cat_checkbox[]" class="bulk-select-checkbox">
		</td>
		<?php foreach( $term_fields as $cat_key => $cat_value ): ?>
			<?php $label = $cat_key == 'name' ? $prefix.$object->$cat_key : $object->$cat_key; ?>
			<td data-label="<?php echo esc_attr( $cat_key ); ?>" class="pzfm-cat-<?php echo esc_attr( $cat_key ); ?>">
				<?php echo !$colcounter ? sprintf( '<a href="%s">%s</a> ', esc_url( pzfm_current_page_url().'&action=update-categories&term_id='.$object->term_id ), esc_html( $label ) ) : esc_html( $label ); ?>
				<?php if(!$colcounter): ?>
					<section class="pzfm-row-actions">
						<ul>
						<?php foreach ( pzfm_table_actions() as $actn_key => $actn_label ): ?>
							<?php 
								$class = 'pzfm-post_'.$actn_key;
								$link = get_the_permalink(); 
								if( $actn_key == 'delete' ){
									$class .= ' text-danger cat-remove-btn';
									$link = '#';
								}elseif( $actn_key == 'edit' ){
									$class .= ' pzfm-category-edit';
									$link = '#';
								}else{
									$link = get_term_link( $object->term_id ); 
								}
							?>
							<li>
								<a href="<?php echo esc_url( $link ); ?>" class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $actn_label ); ?>" data-id="<?php echo (int)$object->term_id; ?>" data-type="posts_cat"><?php echo esc_html( $actn_label ); ?></a>
							</li>
						<?php endforeach; ?>
						</ul>
					</section>
				<?php $colcounter++; endif; ?>
			</td>
		<?php endforeach; ?>
		<td data-label="Count" class="pzfm-tax-count">
			<?php printf( '<a href="%s">%d</a>', esc_url( $dashboard_url.'&cat='.$object->term_id ), esc_html( $object->count ) ); ?>
		</td>
	</tr>
	<?php
	return ob_get_clean();
}
function pzfm_post_field(){
    $pzfm_post_field = array(
        'post_title' => array(
			'id'			=> 'post_title',
            'label'			=> __( 'Post Title', 'pz-frontend-manager' ),
            'field'			=> 'text',
            'required'		=> true,
			'read-only'		=> false,
            'options'		=> array(),
			'wrapper_class'	=> 'post_title col-md-12',
        )
    );
    return apply_filters( 'pzfm_post_field', $pzfm_post_field );
}
// Dashboard Generator
function pzfm_dashboard_generator( $key ){
	ob_start();
    $card_items 	= pzfm_after_dashboard_cards_items();
    $key_visibility = (!empty($card_items[$key]['visibility'])) ? $card_items[$key]['visibility'] : '';
    $key_icon 		= (!empty($card_items[$key]['icon'])) ? $card_items[$key]['icon'] : '';
    $key_count 		= (!empty($card_items[$key]['count'])) ? $card_items[$key]['count'] : 0;
    $key_title 		= (!empty($card_items[$key]['title'])) ? $card_items[$key]['title'] : '';
    $key_description = (!empty($card_items[$key]['description'])) ? $card_items[$key]['description'] : '';
    $key_permalink 	= (!empty($card_items[$key]['permalink'])) ? $card_items[$key]['permalink'] : '';

    if( $key_visibility == 1 ) :
	?>

<div class="col-xl-3 col-lg-6 mb-4 <?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $key_visibility ); ?>>
    <a href="<?php echo esc_url( $key_permalink ); ?>" class="inline-block text-pzfm">
        <div class="card pzfm-border-left shadow h-80">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-pzfm text-uppercase mb-1">
                       <div class="text-md font-weight-bold text-dark text-capitalize mb-1"><?php echo esc_html( $key_title ); ?></div>
	                        <div class="h3 mb-0 font-weight-600 text-pzfm text-pzfm"><?php echo esc_html( $key_count ); ?></div>                            
                        </div>
                    </div>
                    <div class="col-auto pzfm-icons">
                        <?php if(!empty(pzfm_determine_url($key_icon))) : ?>
                            <img class="dash-card-icon" src="<?php echo esc_url($key_icon); ?>">
                        <?php else: ?>
                            <i class="<?php echo esc_attr( $key_icon ); ?>"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
	<?php
    endif;
	$dashboard = ob_get_clean();
	return $dashboard;
} 

function pzfm_dashboard_customize( $key ){
	ob_start();
    $card_items 	= pzfm_after_dashboard_cards_items();
    $key_visibility = (!empty($card_items[$key]['visibility'])) ? $card_items[$key]['visibility'] : '';
    $key_icon 		= (!empty($card_items[$key]['icon'])) ? $card_items[$key]['icon'] : '';
    $key_count 		= (!empty($card_items[$key]['count'])) ? $card_items[$key]['count'] : 0;
    $key_title 		= (!empty($card_items[$key]['title'])) ? $card_items[$key]['title'] : '';
    $key_description = (!empty($card_items[$key]['description'])) ? $card_items[$key]['description'] : '';
    $key_permalink 	= (!empty($card_items[$key]['permalink'])) ? $card_items[$key]['permalink'] : '#';

    if( $key_visibility == 1 ) :
	?>
    <div class="mt-3 my-5 pzfm-card-main-wrap col-lg-3 col-md-4 col-sm-12 <?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $key_visibility ); ?>>
        <a href="<?php echo esc_url( $key_permalink ); ?>" class="inline-block">
            <div class="card shadow">
                <div class="pzfm-card-header card-header-info card-header-icon">
                    <div class="pzfm-card-wrap card-icon container-fluid pzfm-header">
                        <?php if(!empty(pzfm_determine_url($key_icon))) : ?>
                            <img class="dash-card-icon" src="<?php echo esc_url($key_icon); ?>">
                        <?php else: ?>
                            <i class="<?php echo esc_attr( $key_icon ); ?>"></i>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-1">
                    <h6 class="pzfm-card-count text-center"><?php echo esc_html( $key_count ); ?></h6>
                    <h5 class="pzfm-card-title text-center"><?php echo esc_html( $key_title ); ?></h5>
                    <?php if(!empty($key_description)){ ?>
                        <p class="pzfm-card-desc text-center"><?php echo esc_html( $key_description ); ?></p>
                    <?php } ?>
                </div>
            </div>
        </a>
    </div>
	<?php
    endif;
	$dashboard = ob_get_clean();
	return $dashboard;
}