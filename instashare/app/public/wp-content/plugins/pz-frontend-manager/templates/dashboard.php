<?php include( pzfm_include_template( 'header' ) ); ?>
<?php //if ( isset($_GET['omg']) ): ?>
<div id="pzfm-loader">
    <div class="loader-wrapper text-center mb-3 d-flex">
        <div class="m-auto">
            <div class="spinner-grow text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-info" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
<?php //endif; ?>
    <div id="wrapper" class="min-vh-100">
		<?php if( is_page_template( 'dashboard.php' ) && !is_user_logged_in() ): ?>
			<?php
                $uri_path       = parse_url( sanitize_text_field( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH);
                $uri_segments   = explode('/', $uri_path);
				$redirect_to    = apply_filters('pzfm_register_redirec_to', get_the_permalink( get_the_id() ));
				if( isset( $_GET['register'] ) && $_GET['register'] == 'true' || in_array('register', $uri_segments)){
                    ?>
                    <div class="registration-page d-flex flex-row min-vh-100 w-100">
	                    <div id="login-bg" class="container-fluid" style="background-image: url(<?php echo pzfm_login_dashboard_background(); ?>) ">
		                    <section class="row my-5">
                                <?php require_once( pzfm_include_template( 'registration-form.tpl' )); ?>
                            </section>
                        </div>
                    </div>
                    <?php
				}else{
					require_once( pzfm_include_template( 'login.tpl' ) );
				}
			?>
		<?php else: ?>
			 <!-- Sidebar TPL -->
			<?php require_once( pzfm_include_template( 'sidebar' ) );?>
			<div id="content-wrapper" class="d-flex flex-column bg-white">
				<div id="content">
					<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
						 <!-- Sidebar Toggle (Topbar) -->
						 <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-pzfm">
                        	<i class="fa fa-bars"></i>
                    	</button>
						<div class="container-fluid">
							<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
								<span class="sr-only"><?php esc_html( 'Toggle navigation', 'gbs-frontend-dashboard' ); ?></span>
								<span class="navbar-toggler-icon icon-bar"></span>
								<span class="navbar-toggler-icon icon-bar"></span>
								<span class="navbar-toggler-icon icon-bar"></span>
							</button>
							<div class="collapse navbar-collapse justify-content-start">
								<?php do_action( 'pzfm_left_topbar', get_current_user_id() ); ?>
							</div>
							<div class="collapse navbar-collapse justify-content-end">
								<?php do_action( 'pzfm_before_topbar', get_current_user_id() ); ?>
								<ul class="topbar-menu">
									<?php
										$pzfm_top_menu_args = array(
											'echo' 			 => FALSE,
											'theme_location' => 'gbjfd-topbar-menu',
											'menu_class'     => 'nav navbar-nav nav-flex-icons ml-auto',
											'link_before'    => '',
											'link_after'     => '',
											'walker'        => new PZFM_Dashboard_Top_Menu(),
											'fallback_cb'   => false,
											'container'     => ''
										);
										echo wp_nav_menu( $pzfm_top_menu_args );
									?>
								</ul>
								<?php do_action( 'pzfm_after_topbar', get_current_user_id() ); ?>
								<?php do_action( 'pzfm_before_navbar', get_current_user_id() ); ?>
								<ul class="navbar-nav">
                                    <?php do_action( 'pzfm_navbar_li_begin', get_current_user_id() ); ?>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" role="button" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="nav-user-avatar" style="background-image:url(<?php echo pzfm_user_avatar_url( get_current_user_id() ); ?>)"></span>
											<span class="pzfm-username"><?php echo pzfm_user_full_name( get_current_user_id() ); ?></span>
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
											<a class="dropdown-item" href="<?php echo get_permalink( pzfm_dashboard_page() ); ?>?dashboard=profile"><?php esc_html_e( 'Profile', 'pz-frontend-manager' ); ?></a>
                                            <?php if( is_pzfm_admin_user() ): ?>
                                                <a class="dropdown-item" href="<?php echo get_permalink( pzfm_dashboard_page() ); ?>?dashboard=settings"><?php esc_html_e( 'Settings', 'pz-frontend-manager' ); ?></a>
                                            <?php endif; ?>
											<a class="dropdown-item" href="<?php echo wp_logout_url( pzfm_logout_url() ); ?> "><?php esc_html_e( 'Logout', 'pz-frontend-manager' ); ?></a>
										</div>
									</li>
                                    <?php do_action( 'pzfm_navbar_li_end', get_current_user_id() ); ?>
								</ul>
								<?php do_action( 'pzfm_after_navbar', get_current_user_id() ); ?>
							</div>
						</div>
					</nav>
					<div class="container-fluid bg-white">
						<?php
							if( $post->ID == pzfm_dashboard_page() ){
								if( pzfm_parameters('dashboard') ){
									if( pzfm_parameters('dashboard') == 'profile' ){
										require_once( pzfm_include_template( 'users/profile.tpl' ) );
									}elseif( pzfm_parameters('dashboard') == 'settings' ){
										if( in_array( 'administrator', pzfm_current_user_role() ) || can_access_pzfm_settings() ){
											require_once( pzfm_include_template( 'settings.tpl' ) );
										}else{
											$error_message = pzfm_unable_to_access_error();
											require_once( pzfm_include_template( 'error.tpl' ) );
										}
									}elseif( pzfm_parameters('dashboard') == pzfm_users_page() ){
										$user_roles = '';
										if( !can_access_pzfm_users() ){
                                            $error_message = pzfm_unable_to_access_error();
                                            require_once( pzfm_include_template( 'error.tpl' ) );
                                        }elseif( !empty($_GET['action']) 
                                            && ( $_GET['action'] == 'update' || $_GET['action'] == 'view' || $_GET['action'] == 'add-user'  ) ){
                                            $user_id            = isset( $_GET['id'] ) && (int)$_GET['id'] ? (int)$_GET['id'] : false;
                                            $user_meta          = get_userdata($user_id);
                                            $generate_password  = '';
                                            $customer_list      = apply_filters( 'manage_order_customer_list', array() );
                                            // Check if request is view update
                                            if( $_GET['action'] == 'view' && $user_meta ){
                                                $user_roles         = $user_meta->roles;
                                                require_once( pzfm_include_template( 'users/view.tpl' ) );
                                            }elseif( $_GET['action'] == 'update' && pzfm_can_edit_user() && $user_meta ){
                                                $user_roles         = $user_meta->roles;
                                                require_once( pzfm_include_template( 'users/form.tpl' ) );
                                            }elseif( $_GET['action'] == 'add-user' && pzfm_can_add_user() ){
                                                $generate_password =  wp_generate_password();
                                                require_once( pzfm_include_template( 'users/form.tpl' ) );
                                            }else{
                                                $error_message = pzfm_unable_to_access_error();
                                                require_once( pzfm_include_template( 'error.tpl' ) );
                                            }
                                        }else{
                                            global $wp_roles;
                                            $bulk_actions = pzfm_table_bulk_actions();
                                            if (get_option('pzfm-activation')){
                                                $bulk_actions['activate'] = esc_html__('Activate', 'pz-frontend-manager');
                                                $bulk_actions['deactivate'] = esc_html__('Deactivate', 'pz-frontend-manager');
                                            }
                                            $pzfm_personal_info_fields = pzfm_personal_info_fields();
                                            unset($pzfm_personal_info_fields['first_name']);
                                            unset($pzfm_personal_info_fields['last_name']);
                                            unset($pzfm_personal_info_fields['user_latitude']);
                                            unset($pzfm_personal_info_fields['user_longitude']);
                                            $search_value   = '';
                                            $email_query   = array();
                                            $meta_query     = array();
                                            $users_per_page = 10;
                                            $table_actions = pzfm_table_actions();
                                            
                                            if( !pzfm_can_edit_user() ){
                                                unset( $table_actions['edit'] );
                                            }
                                            if( !pzfm_can_delete_user() ){
                                                unset( $table_actions['delete'] );
                                            }
                                            if(is_front_page()) {
                                                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
                                            }else {
                                                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                                            }
                                            $offset   = ( $paged - 1 ) * $users_per_page;

                                            $args = array(
                                                'offset'		=> $offset,
                                                'number'		=> $users_per_page,
                                                'orderby'       => 'user_registered',
                                                'order'         => 'DESC',
                                                'role__not_in'	=> array( 'administrator' ),
                                                'meta_query'	=> array(
                                                    'relation'	=> 'OR',
                                                ),
                                            );
                                            if( isset($_GET['filter']) && !empty($_GET['filter']) ){
                                                unset($args['role__not_in']);
                                                $args['role__in'] = array( sanitize_text_field($_GET['filter']) );
                                            }
                                            if( isset( $_GET['user-search'] ) && !empty( $_GET['user-search'] ) ){
                                                $search_value = sanitize_text_field( $_GET['user-search'] );
                                                $args['meta_query'][] = array(
                                                    'key'       => 'first_name',
                                                    'value'     => $search_value,
                                                    'compare'   => 'LIKE'
                                                );
                                                $args['meta_query'][] = array(
                                                    'key'       => 'last_name',
                                                    'value'     => $search_value,
                                                    'compare'   => 'LIKE'
                                                );
                                                $args['meta_query'][] = array(
                                                    'key'       => 'email',
                                                    'value'     => $search_value,
                                                    'compare'   => 'LIKE'
                                                );

                                                $email_query = new WP_User_Query(
                                                  array(
                                                    'offset'		     => $offset,
                                                    'number'		     => $users_per_page,
                                                    'orderby'        => 'user_registered',
                                                    'order'          => 'DESC',
                                                    'role__not_in'	 => array( 'administrator' ),
                                                    'search'         => "*{$search_value}*",
                                                    'search_columns' => array(
                                                      'user_login',
                                                      'user_email',
                                                  ),
                                                ) );
                                                $email_results = $email_query->get_results();
                                            }
                                            $users_args     = apply_filters( 'pzfm_users_args', $args );
                                            $user_query     = new WP_User_Query( $users_args );
                                            $user_results   = $user_query->get_results();

                                            if ( isset($email_results) && !empty($email_results) ){
                                              $total_query = array_merge($user_results, $email_results);
                                              $user_results = array_unique($total_query, SORT_REGULAR);
                                            }

                                            $total_users    = !empty($email_results) ? max( $email_query->total_users, $user_query->total_users ) : $user_query->total_users;
                                            $total_pages    = ceil(  $total_users / $users_per_page );

                                            require_once( pzfm_include_template( 'users/users.tpl' ) );
                                        }
									}elseif( pzfm_parameters('dashboard') == pzfm_posts_page() ){
                                        $error_message = pzfm_unable_to_access_error();
                                        if( !pzfm_can_manage_posts() ){
											require_once( pzfm_include_template( 'error.tpl' ) );
										}else{
                                            $big			= 999999999;
                                            if( isset( $_GET['action'] ) ){                                               
                                                if($_GET['action'] == 'categories' || $_GET['action'] == 'update-categories'){
                                                    if( !is_pzfm_admin_user() ){
                                                        require_once( pzfm_include_template( 'error.tpl' ) );
                                                    }else{
                                                        include_once( pzfm_include_template( 'posts/categories.tpl' ) );
                                                    }
                                                }elseif($_GET['action'] == 'tags' || $_GET['action'] == 'update-tags' ){
                                                    if( !is_pzfm_admin_user() ){
                                                        require_once( pzfm_include_template( 'error.tpl' ) );
                                                    }else{
                                                        include_once( pzfm_include_template( 'posts/tags.tpl' ) );
                                                    }
                                                }else{
                                                    include_once( pzfm_include_template( 'posts/form.tpl' ) );
                                                }
                                            }else{
                                                $paged          = get_query_var('paged') ? get_query_var('paged') : 1;
                                                $posts_per_page	= get_option( 'posts_per_page' );
                                                $searched       = '';
                                                $meta_query     = array();
                                                $args = array(
                                                    'post_type'			=> 'post',
                                                    'orderby'			=> 'date',
                                                    'order'				=> 'DESC',
                                                    'posts_per_page'	=> $posts_per_page,
                                                    'paged'				=> $paged
                                                );
                                                if( !in_array( 'administrator', pzfm_current_user_role() ) ){
                                                    $args['author'] = get_current_user_id();
                                                }
                                                if( isset( $_GET['pzfm-search'] ) && !empty( $_GET['pzfm-search'] ) ){
                                                    $args['s'] = sanitize_text_field( $_GET['pzfm-search'] );
                                                    $searched = $args['s'];
                                                }
                                                if( isset( $_GET['cat'] ) && (int)$_GET['cat'] ){
                                                    $args['cat'] = (int)$_GET['cat'];
                                                }
                                                if( isset( $_GET['tag'] ) && $_GET['tag'] ){
                                                    $args['tag'] = sanitize_text_field( $_GET['tag'] );
                                                }
                                                if( isset( $_GET['ym'] ) && (int)$_GET['ym'] ){
                                                    $year   = substr( (int)$_GET['ym'], 0, 4);
                                                    $month  = substr( (int)$_GET['ym'], 4, 2);
                                                    $args['year'] = (int)$year;
                                                    $args['monthnum'] = (int)$month;
                                                }
                                                $args['post_status'] = array('publish', 'draft', 'private');
                                                $args = apply_filters( 'pzfm_post_query_args', $args );

                                                $posts = new WP_Query( $args );
                                                $total_pages = $posts->max_num_pages;
                                                $search_width = 12;
                                                require_once( pzfm_include_template( 'posts/posts.tpl' ) );

                                                wp_reset_postdata();
                                            }
                                        }
                                    }else{
										do_action( 'pzfm_dashboard_page' );
									}
								}else{
									do_action( 'pzfm_dashboard_content' );
								}
							}else{
								while ( have_posts() ) : the_post();
									the_content();
								endwhile;
							}
						?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php include( pzfm_include_template( 'footer' ) ); ?>