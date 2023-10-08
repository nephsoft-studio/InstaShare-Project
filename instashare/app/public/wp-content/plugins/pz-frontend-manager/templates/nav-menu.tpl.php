<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
	<!-- Sidebar Toggle (Topbar) -->
	 <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-pzfm">
    	<i class="fa fa-bars"></i>
	</button>
		<div class="container-fluid">
			<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
				<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'gbs-frontend-dashboard' ); ?></span>
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
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
				</ul>
				<?php do_action( 'pzfm_after_navbar', get_current_user_id() ); ?>
			</div>
		</div>
</nav>