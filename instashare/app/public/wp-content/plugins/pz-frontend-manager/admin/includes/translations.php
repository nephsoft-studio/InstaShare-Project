<?php
function pzfm_unable_to_access_error(){
	return apply_filters( 'pzfm_unable_to_access_error', esc_html__( 'You are not allowed to access this page. Contact the system administrator to request for access.', 'pz-frontend-manager' ) );
}
function pzfm_profile_page(){
	$label = esc_html__( 'profile', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_profile_page', $label );
}
function pzfm_users_page(){
	$label = esc_html__( 'pzfm_users', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_users_page', $label );
}
function pzfm_users_label(){
	$label = esc_html__( 'Users', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_users_label', $label );
}
function pzfm_singular_user_label(){
	$label = esc_html__( 'User', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_singular_user_label', $label );
}
function pzfm_posts_label(){
	$label =  esc_html__( 'Posts', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_posts_label', $label );
}
function pzfm_posts_page(){
	$label = esc_html__( 'pzfm_posts', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_posts_page', $label );
}
function pzfm_categories_label(){
	$label = esc_html__( 'Categories', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_categories_label', $label );
}
function pzfm_tags_label(){
	$label = esc_html__( 'Tags', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_tags_label', $label );
}
function pzfm_download_label(){
	$label = esc_html__( 'Download', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_download_label', $label );
}
function pzfm_announcment_label(){
	$label = esc_html__( 'Announcment', 'pz-frontend-manager' );
	return apply_filters( 'pzfm_announcement_label', $label );
}
/* ICONS */
function pzfm_posts_icon(){
	$icon = 'fas fa-lightbulb pzfm-icon-color';
	return apply_filters( 'pzfm_posts_icon', $icon );
}