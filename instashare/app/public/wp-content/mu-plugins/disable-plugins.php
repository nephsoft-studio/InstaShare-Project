<?php
/*
Plugin Name: FM Disable Plugin for URl
Plugin URI: https://www.proj-z.com/
Description: Disable plugins for for front end dashboard.
Author: https://www.proj-z.com/.
Version: 1.0.0
*/
if( !is_admin() && empty( $_POST ) ){
    $slug = get_post_field( 'post_name', get_option('pzfm_dashboard') );
    $uri = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $uriArr = explode( '?',$uri );
    $uri = $uriArr[0];
    $home_uri = str_replace( 'https://','',str_replace( 'http://','',home_url( '/'.$slug.'/' ) ) );
    if ( $uri === $home_uri ) {
        $paths = (get_option('pzfm_deactivate_plugins')) ? get_option('pzfm_deactivate_plugins') : array();
        global $paths;
        add_filter( 'option_active_plugins', 'pzfm_option_active_plugins' );
    }
}

function pzfm_option_active_plugins( $plugins ){
    global $paths;
    foreach( $paths as $path ){
        $k = array_search( $path, $plugins );
        if( false !== $k ){
            unset( $plugins[$k] );
        }
    }

    return $plugins;
}