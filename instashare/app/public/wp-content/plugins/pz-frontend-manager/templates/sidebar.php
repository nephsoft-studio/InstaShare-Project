<ul class="shadow navbar-nav sidebar sidebar-light accordion bg-white" id="accordionSidebar">
    <div class="sidebar-brand-text">
        <a class="p-2 d-flex align-items-center justify-content-center" href="<?php echo get_home_url(); ?>">
            <?php if(pzfm_display_logo() == 0 ){ ?>
                <img class="site-logo shadow" src="<?php echo pzfm_dashboard_logo(); ?>" />
            <?php }else{ ?>
                <img class="site-logo shadow" src="<?php echo pzfm_user_avatar_url( get_current_user_id() ); ?>" />
            <?php } ?>
        </a>
    </div>
    <hr class="sidebar-divider">
    <?php do_action( 'pzfm_before_sidebar_menu_item' ); ?>
    <li class="nav-item">
        <a class="nav-link <?php echo get_the_ID() == pzfm_dashboard_page() && !isset( $_GET['dashboard'] ) ? 'active' : ''; ?>" href="<?php echo get_the_permalink( pzfm_dashboard_page() ); ?>">
            <i class="fas fa-fw fa-tachometer-alt pzfm-icon-color"></i>
            <span><?php echo get_the_title( pzfm_dashboard_page() ); ?></span>
        </a>
    </li>
    <?php if( !empty( pzfm_after_sidebar_menu_items() ) ): ?>
        <?php foreach( pzfm_after_sidebar_menu_items() as $menu_key => $menu_data ): ?>
            <?php
                $is_active = '';
                $is_show = '';
                $is_collapsed = 'collapsed';
                if(isset( $_GET['dashboard'] ) && $menu_key == $_GET['dashboard']){
                  $is_active = 'active';
                  $is_show = 'show';
                  $is_collapsed = '';
                }
                if( !empty($menu_data['submenu']) ){
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo esc_attr( $is_collapsed ); ?> <?php echo esc_attr( $is_active ); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr( $menu_data['title'] ); ?>" aria-expanded="<?php echo ($is_show == 'show') ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo esc_attr( $menu_data['title'] ); ?>">
                                <i class="<?php echo esc_attr( $menu_data['icon'] ); ?>"></i><span><?php echo esc_html( $menu_data['title'] ); ?></span>
                            </a>
                            <div id="collapse<?php echo esc_attr( $menu_data['title'] ); ?>" class="m-0 collapse <?php echo esc_attr( $is_show ); ?>" aria-labelledby="heading<?php echo esc_attr( $menu_data['title'] ); ?>" data-parent="#accordionSidebar">
                                <div class="pt-0 pb-2 collapse-inner rounded">
                                    <?php foreach( $menu_data['submenu_items'] as $sub_menu_key => $sub_menu_value ): ?>
                                        <?php
                                            $active_sub = '';
                                            if ($sub_menu_key == 0) {
                                                $link_menus = $menu_data['permalink'];
                                                $active_sub = !empty($is_active) && !isset( $_GET['action'] ) ? 'active' : '';
                                            }else{
                                                $link_menus = $menu_data['permalink'].'&action='.pzfm_slugify(strtolower($sub_menu_value));
                                                $active_sub = !empty($is_active) && isset( $_GET['action'] ) && strtolower($sub_menu_value) == $_GET['action'] ? 'active' : '';
                                            }
                                        ?>
                                        <a class="collapse-item m-0 px-4 rounded-0 text-capitalize <?php echo esc_attr( $active_sub ); ?>" href="<?php echo esc_url_raw( $link_menus ); ?>"><?php echo esc_html( $sub_menu_value ); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </li>
                    <?php
                }else{
                    echo sprintf(
                        '<li class="nav-item %s"><a class="nav-link" href="%s"><i class="%s"></i><span>%s</span></a></li>',
                        $is_active,
                        $menu_data['permalink'],
                        $menu_data['icon'],
                        $menu_data['title']
                    );
                }
            ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php do_action( 'pzfm_after_sidebar_menu_item' ); ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <div class="sidebar-footer-section">
        <a class="nav-link tooltiplink" href="<?php echo get_permalink( pzfm_dashboard_page() ); ?>?dashboard=profile" title="<?php esc_html_e( 'Profile', 'pz-frontend-manager' ); ?>">
            <span class="profile"><i class="fas fa-user pzfm-icon-color"></i></span>
            <span class="tooltiptext"><?php esc_html_e('Profile', 'pz-frontend-manager'); ?></span>
        </a>
        <?php if( is_pzfm_admin_user() ): ?>
            <a class="nav-link tooltiplink" href="<?php echo get_the_permalink( pzfm_dashboard_page() ).'?dashboard=settings'; ?>" title="<?php esc_html_e( 'Settings', 'pz-frontend-manager' ); ?>">
                <span class="settings"><i class="fas fa-gear pzfm-icon-color"></i></span>
                <span class="tooltiptext"><?php esc_html_e('Settings', 'pz-frontend-manager'); ?></span>
            </a>
        <?php endif; ?>
        <a class="nav-link tooltiplink" href="<?php echo wp_logout_url( pzfm_logout_url() ); ?>" title="<?php esc_html_e( 'Logout', 'pz-frontend-manager' ); ?>">
            <span class="logout"><i class="fas fa-power-off pzfm-icon-color"></i></span>
            <span class="tooltiptext"><?php esc_html_e('Logout', 'pz-frontend-manager'); ?></span>
        </a>
    </div>
   

    
</ul>
<style>
.sidebar-footer-section {
    position: fixed;
    bottom: 0;
    height: 55px;
    border-top: 1px solid <?php echo pzfm_base_color(); ?>;
    padding: 15px;
    width: 14rem!important;
    align-items: center;
    text-align: center;
}
.sidebar-footer-section .pzfm-icon-color{
    color: <?php echo pzfm_base_color(); ?> !important;
    font-size:  18px;
    margin: 0 20px;
}
.sidebar-footer-section .nav-link{
    padding: 0 !important;
}
.tooltiplink {
  position: relative;
  display: inline-block;
}
.tooltiplink .tooltiptext {
  visibility: hidden;
  width: 65px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: -3px;
  left: 85%;
  font-size: 12px;
}
.tooltiplink .tooltiptext::after {
  content: "";
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent black transparent transparent;
}
.tooltiplink:hover .tooltiptext {
  visibility: visible;
}
@media screen and (max-width: 767px) {
    .tooltiplink {
        display: block;
    }
    .sidebar-footer-section .nav-link {
        padding: 1rem !important;
    }
    .sidebar-footer-section {
        width: 6.5rem !important;
        height: unset;
        padding: 0;
    }
    .toggled .sidebar-footer-section {
        display: none;
    }
}
@media screen and (max-width: 500px) {
    .toggled .sidebar-footer-section {
        display: block !important;
        width: 100% !important;
    }
    .shadow.navbar-nav .sidebar-footer-section {
        display: none;
    }
    .tooltiplink {
        display: inline-block;
    }
}
</style>