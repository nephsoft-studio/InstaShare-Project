<?php
add_action("wp_ajax_pzfm_remove_item", "pzfm_remove_item_callback");
function pzfm_remove_item_callback(){
    $user_id    = get_current_user_id();
    $data_id    = is_array( $_REQUEST['dataID'] ) ? array_map( function( $value ) { return (int) $value; }, $_REQUEST['dataID'] ) : (int)$_REQUEST['dataID'] ;
    $data_type  = sanitize_text_field( $_REQUEST['dataType'] );

    $response = array(
        'status'    => 0,
        'message'   => __('Something went wrong with your request. please reload and try again.','pz-frontend-manager'),
        'url'       => get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_posts_page()
    );
    if( $data_type == 'user' && !empty( $data_id ) ){
        // check if the current user can delete
        if( pzfm_can_delete_user() ){
            if( is_array( $data_id ) ){
                foreach( $data_id as $user_id ){
                    if( get_current_user_id() == (int)$user_id ){
                        continue;
                    }
                    $delete_user = wp_delete_user( (int)$user_id );
                    if( !$delete_user ){
                        $response = array(
                            'status' => 0,
                            'message' => __('Something went wrong with your request. please reload and try again.','pz-frontend-manager'),
                            'url' => get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_users_page()
                        );
                        break;
                    }
                    $response = array(
                        'status' => 1,
                        'message' => __( 'User successfully deleted.','pz-frontend-manager'),
                        'url' => get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_users_page()
                    );
                }
            }else{
                // make sure the current user can't delete own account
                if( get_current_user_id() != (int)$data_id ){
                    $delete_user = wp_delete_user( (int)$data_id );
                    if( $delete_user ){
                        $response = array(
                            'status' => 1,
                            'message' => __( 'User successfully deleted.','pz-frontend-manager'),
                            'url' => get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_users_page()
                        );
                    }
                }
            }    
        }
    }elseif( $data_type == 'posts_cat' && !empty( $data_id ) ){
        if( is_pzfm_admin_user() ){
            $response['status'] = 1;
            $response['url'] = get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_posts_page().'&action=categories';
            if( is_array( $data_id ) ){
                foreach( $data_id as $term_id ){
                    wp_delete_term( $term_id, 'category' );
                }
                $response['message'] = sprintf( __( '%d terms successfully deleted.','pz-frontend-manager'), count($data_id) );
            }else{
                $term_info   = get_term( $data_id, 'category' );
                $delete_term = wp_delete_term( $data_id, 'category' );
                if( $delete_term  ){
                    $response['message'] = sprintf( __( '%s successfully completed.','pz-frontend-manager'), $term_info->name );
                }elseif( is_wp_error( $delete_term ) ){
                    $response['status'] = 0;
                    $response['message'] = $delete_term->get_error_message();
                }
            }
            
        }
    }elseif( $data_type == 'post_tag' && !empty( $data_id ) ){
        if( is_pzfm_admin_user() ){
            $response['status'] = 1;
            $response['url']    = get_the_permalink( pzfm_dashboard_page() ).'/?dashboard='.pzfm_posts_page().'&action=tags';
            if( is_array( $data_id ) ){
                foreach( $data_id as $term_id ){
                    wp_delete_term( $term_id, 'post_tag' );
                }
                $response['message'] = sprintf( __( '%d terms successfully deleted.','pz-frontend-manager'), count($data_id) );
            }else{
                $term_info  = get_term( $data_id, 'post_tag' );
                $delete_term = wp_delete_term( $data_id, 'post_tag' );
                if( $delete_term  ){
                    $response['message'] = sprintf( __( '%s successfully deleted.','pz-frontend-manager'), $term_info->name );
                }elseif( is_wp_error( $delete_term ) ){
                    $response['status'] = 0;
                    $response['message'] = $delete_term->get_error_message();
                }
            }
        }
    }else{
        // Check is data is array
		if( is_array( $data_id ) ){
            // Chech if there is post that are included where the user not allowed to delete
            $has_errors = array_filter( array_map(function( $value ) use ($user_id){
                return !is_user_post( $value, $user_id );
            }, $data_id) );
            if( !empty( $has_errors ) ){
                $response = array(
                    'status' => 0,
                    'message' => sprintf( __( 'Something went wrong with your %d selected request. please reload and try again.','pz-frontend-manager'), count($has_errors) ),
                    'url' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page()
                );
            }else{
                foreach( $data_id as $post_id ){
                    wp_trash_post( $post_id );
                }
                $response = array(
                    'status' => 1,
                    'message' => sprintf( __( '%d posts successfully deleted.','pz-frontend-manager'), count($data_id) ),
                    'url' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page()
                );
            }	
		}else{
            if( is_user_post( $data_id, $user_id ) ){  
                $response = array(
                    'status' => 1,
                    'message' => sprintf( __( '%s successfully deleted.','pz-frontend-manager'), get_the_title($data_id) ),
                    'url' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page()
                );
                wp_trash_post( $data_id );
            }
		}
	}
    wp_send_json( $response );
    wp_die();
}

add_action( 'wp_ajax_pzfm_generate_password', 'pzfm_generate_password' );
add_action('wp_ajax_nopriv_pzfm_generate_password', 'pzfm_generate_password');
function pzfm_generate_password(){
    $results['gbsdf_get_password']  = pzfm_random_password();
    echo json_encode( $results );
    wp_die();
}

add_action( 'wp_ajax_pzfm_bg_images_remove', 'pzfm_bg_images_remove' );
function pzfm_bg_images_remove(){
    $type = sanitize_text_field( $_REQUEST['type'] );
    if($type == 'logo'){
        update_option('pzfm_site_logo', '');
    }else{
        update_option('pzfm_login_background', '');
    }
    wp_die();
}
add_action( 'wp_ajax_pzfm_get_categories', 'pzfm_get_categories' );
function pzfm_get_categories(){
    $term_id = sanitize_text_field( $_REQUEST['term_id'] );
    $term = get_term_by( 'id', $term_id, 'category' );
    $response = array(
        'term_id'       => $term->term_id,
        'name'          => $term->name,
        'slug'          => $term->slug,
        'parent'        => $term->parent,
        'description'   => $term->description
    );
    wp_send_json( $response );
    wp_die();
}
add_action( 'wp_ajax_pzfm_save_categories', 'pzfm_save_categories' );
function pzfm_save_categories(){
    $term_id        = (int)$_POST['term_id'];
    $taxonomy       = isset( $_POST['data_type'] ) ? sanitize_text_field( $_POST['data_type'] ) : 'category';
    $name           = isset( $_POST['name']) ? sanitize_text_field( $_POST['name'] ) : '';
    $parent         = isset( $_POST['parent']) ? (int)$_POST['parent'] : null;
    $slug           = isset( $_POST['slug']) && !empty($_POST['slug']) ? sanitize_text_field($_POST['slug']) : pzfm_slugify($name);
    $description    = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';

    $response = array(
        'status' => 0,
        'message' => __( 'Something went wrong with your request, please reload the page and try again.','pz-frontend-manager'),
        'url' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&action=categories'
    );

    if( $term_id ){
        $term_object = get_term( $term_id, $taxonomy );
        if( is_wp_error( $term_object ) ){
            $response['message'] = $term_object->get_error_message();
            wp_send_json( $response );
        }
        wp_update_term( $term_id, $taxonomy, array(
            'name'          => $name,
            'slug'          => $slug,
            'parent'        => $parent,
            'description'   => $description,
        ) );
        $response['status'] = 1;
        $response['message'] = sprintf( __('%s term successfully updated', 'pz-frontend-manager'), $name  );
    }else{
        $insert_data = wp_insert_term( $name, $taxonomy, array(
            'description' => $description,
            'parent'      => $parent,
            'slug'        => $slug,
        ) );

        if( is_wp_error($insert_data) ){
            $response ['message'] = $insert_data->get_error_message();
            wp_send_json(  $response );
        }
        $term_id = $insert_data['term_id'];
        $response['status'] = 1;
        $response['message'] = sprintf( __('%s term successfully added', 'pz-frontend-manager'), $name  );
    }
    do_action( 'pzfm_save_'.$taxonomy, $term_id );
    wp_send_json( $response );
    wp_die();
}
add_action( 'wp_ajax_pzfm_get_tag', 'pzfm_get_tag' );
function pzfm_get_tag(){
    $term_id = sanitize_text_field( $_REQUEST['term_id'] );
    $term = get_term_by( 'id', $term_id, 'post_tag' );
    $response = array(
        'term_id'       => $term->term_id,
        'name'          => $term->name,
        'slug'          => $term->slug,
        'description'   => $term->description
    );
    wp_send_json( $response );
    wp_die();
}
add_action( 'wp_ajax_pzfm_save_tag', 'pzfm_save_tag' );
function pzfm_save_tag(){
    $term_id        = (int)$_POST['term_id'];
    $name           = isset($_POST['name']) ? sanitize_text_field( $_POST['name'] ) : '';
    $slug           = isset($_POST['slug']) && !empty($_POST['slug']) ? sanitize_text_field($_POST['slug']) : pzfm_slugify($name);
    $description    = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';
    $taxonomy       = 'post_tag';
    $error_message  = __('Error request, please reload the page and try again.', 'pz-frontend-manager');
    $success_message  = __('Taxonomy successfully save.', 'pz-frontend-manager');

    $response = array(
        'status' => 0,
        'message' => __( 'Something went wrong with your request, please reload the page and try again.','pz-frontend-manager'),
        'url' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_posts_page().'&action=tags'
    );

    if($term_id){
        $term_object = get_term( $term_id, $taxonomy );
        if( is_wp_error( $term_object ) ){
            $response['message'] = $term_object->get_error_message();
            wp_send_json( $response );
        }

        wp_update_term( $term_id, $taxonomy, array(
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
        ) );
        $response['status'] = 1;
        $response['message'] = sprintf( __('%s successfully updated.'), $name );
    }else{
        $insert_data = wp_insert_term( $name, $taxonomy, array(
            'description' => $description,
            'slug'        => $slug,
        ) );

        if( is_wp_error($insert_data) ){
            $response['message'] = $insert_data->get_error_message();
            wp_send_json( $response );
        }
        $response['status'] = 1;
        $response['message'] = sprintf( __('%s successfully created.'), $name );
        $term_id = $insert_data['term_id'];
    }
    do_action( 'pzfm_save_'.$taxonomy, $term_id );
    wp_send_json( $response );
    wp_die();
}
add_action("wp_ajax_pzfm_user_activation_action", "pzfm_user_activation_action");
function pzfm_user_activation_action(){
    $user_id    = (int)$_REQUEST['userID'];
    $type       = sanitize_text_field( $_REQUEST['type'] );
    if( $type == 'activate' ){
        update_user_meta( $user_id, 'account_activated', 1 );
        $get_user_data	= get_userdata( $user_id );
        $headers        = array( 'Content-Type: text/html; charset=UTF-8' );
        $headers[]      = 'From: ' . get_bloginfo('name') .' <'.get_option( 'admin_email' ).'>';
        $subject        = __( 'Account Activated', 'pz-frontend-manager' );
        $send_to        = $get_user_data->user_email;
        $logo           = apply_filters('pzfm_activate_email_logo', pzfm_dashboard_logo());
        $color          = apply_filters('pzfm_activate_email_color', pzfm_base_color());
        $message        = pzfm_email_activation_content( $user_id, $logo, $color );
        wp_mail( $send_to, $subject, $message, $headers );
    }else{
        delete_user_meta( $user_id, 'account_activated' );
    }
    wp_die();
}
add_action("wp_ajax_pzfm_user_request_action", "pzfm_user_request_action_callback");
function pzfm_user_request_action_callback(){
    $data_id    = is_array( $_REQUEST['dataID'] ) ? array_map( function( $value ) { return (int) $value; }, $_REQUEST['dataID'] ) : (int)$_REQUEST['dataID'] ;
    $data_type  = sanitize_text_field( $_REQUEST['dataType'] );
    $response = array(
        'status' => 0,
        'message' => __( 'Something went wrong with your request, please reload the page and try again.','pz-frontend-manager'),
        'url' => get_the_permalink( pzfm_dashboard_page() ).'?dashboard='.pzfm_users_page()
    );
    if( $data_type == 'activate' ){
        if( is_array( $data_id ) ){
			foreach( $data_id as $user_id ){
				update_user_meta( $user_id, 'account_activated', 1 );
                $get_user_data	= get_userdata( $user_id );
                $headers        = array( 'Content-Type: text/html; charset=UTF-8' );
                $headers[]      = 'From: ' . get_bloginfo('name') .' <'.get_option( 'admin_email' ).'>';
                $subject        = __( 'Account Activated', 'pz-frontend-manager' );
                $send_to        = $get_user_data->user_email;
                $logo           = apply_filters('pzfm_activate_email_logo', pzfm_dashboard_logo());
                $color          = apply_filters('pzfm_activate_email_color', pzfm_base_color());
                $message        = pzfm_email_activation_content( $user_id,$logo,$color );
                wp_mail( $send_to, $subject, $message, $headers );
			}
            $response['status'] = 1;
            $response['message'] = sprintf( __('%d successfully Activated.'), count($data_id) );    
		}
    }elseif( $data_type == 'deactivate' ){
        if( is_array( $data_id ) ){
			foreach( $data_id as $user_id ){
				delete_user_meta( $user_id, 'account_activated' );
			}
            $response['status'] = 1;
            $response['message'] = sprintf( __('%d successfully deactivated.'), count($data_id) );    
		}
    }elseif( $data_type == 'delete' ){
        $has_error = false;
        if( is_array( $data_id ) ){
			foreach( $data_id as $user_id ){
                if( get_current_user_id() == (int)$user_id ){
                    continue;
                }
                $delete_user = wp_delete_user( (int)$user_id );
                if( !$delete_user ){
                    $has_error  = true;
                    break;
                }
            }   
            if( !$has_error ){
                $response['status']  = 1;
                $response['message'] = sprintf( __( '%d user successfully deleted.','pz-frontend-manager'), count($data_id) );
            }
		}
    }
    wp_send_json( $response );
    wp_die();
}
// Saving user AVATAR
add_action( 'wp_ajax_pzfm_upload_avatar', 'pzfm_upload_avatar_callback' );
function pzfm_upload_avatar_callback(){
	$upload_dir       = wp_upload_dir();

	// @new
	$upload_path        = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
	$img                = sanitize_text_field( $_POST['imageData'] );
    $user_id            = (int)$_POST['userID'];
	$img                = str_replace('data:image/png;base64,', '', $img);
	$img                = str_replace(' ', '+', $img);
	$decoded            = base64_decode($img) ;
	$filename           = get_current_user_id().'.png';
	$hashed_filename    = md5( $filename . microtime() ) . '_' . $filename;
	// @new
	$image_upload       = file_put_contents( $upload_path . $hashed_filename, $decoded );
	//HANDLE UPLOADED FILE
	if( !function_exists( 'wp_handle_sideload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	// Without that I'm getting a debug error!?
	if( !function_exists( 'wp_get_current_user' ) ) {
		require_once( ABSPATH . 'wp-includes/pluggable.php' );
	}
	// @new
	$file             = array();
	$file['error']    = '';
	$file['tmp_name'] = $upload_path . $hashed_filename;
	$file['name']     = $hashed_filename;
	$file['type']     = 'image/png';
	$file['size']     = filesize( $upload_path . $hashed_filename );
	// upload file to server
	// @new use $file instead of $image_upload
	$file_return      = wp_handle_sideload( $file, array( 'test_form' => false ) );
	$filename = $file_return['file'];
	$attachment = array(
		'post_mime_type' => $file_return['type'],
		'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		'post_content' => '',
		'post_status' => 'inherit',
		'guid' => $wp_upload_dir['url'] . '/' . basename($filename)
	);
	$attach_id = wp_insert_attachment( $attachment, $filename );
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	$avatar_url = wp_get_attachment_url( $attach_id );
    if( $user_id ){
        update_user_meta( $user_id, 'pzfm_user_avatar', $avatar_url );
    }
	
	wp_send_json( array(
        'id' => $attach_id,
        'url' => $avatar_url,
        'return' => $file_return
    ) );
	wp_die();
}