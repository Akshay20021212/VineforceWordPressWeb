<?php
/**
 * Customizer Helpers
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( !function_exists( 'killarwt_customizer_options_val' ) ) {
	
	function killarwt_opt_chk_def_val( $val = '', $def_val = '' ) {
		
		if ( $val != '' && $val == $def_val ) {
			return true;
		}
		return false;
	}
}

function ctm_killar_general_preloader() {
	return get_theme_mod( 'killar_general_preloader', true );
}

function ctm_killar_general_preloader_type_is_predefine() {
	$type = get_theme_mod( 'killar_general_preloader_type', 'predefine' );
	if ( ctm_killar_general_preloader() && $type == 'predefine' ) {
		return true;
	}
	return false;
}

function ctm_killar_general_preloader_type_is_custom() {
	$type = get_theme_mod( 'killar_general_preloader_type', 'predefine' );
	if ( ctm_killar_general_preloader() && $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killar_general_newsletter_popup_is_enabled() {
	$status = get_theme_mod( 'killar_general_newsletter_popup_layout' );
	if ( !empty( $status ) ) {
		return true;
	}
	return false;
}
 
function ctm_killar_is_topbar_enable() {
	$status = get_theme_mod( 'killar_topbar', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_killar_display_topbar_social() {
	return ( ctm_killar_is_topbar_enable() && get_theme_mod( 'killar_topbar_social' ) ) ? true : false;
}

function ctm_killar_page_title_background_enabled() {
	$style = get_theme_mod( 'killar_page_title_background', 'image' );
	if ($style == 'image') {
		return true;
	}
	return false;
}

function ctm_killar_page_title_scene_enabled() {
	$style = get_theme_mod( 'killar_page_title_background', 'scene' );
	if ($style == 'scene') {
		return true;
	}
	return false;
}

function ctm_killar_is_container_width_active() {
	$page_layout = get_theme_mod( 'killar_main_layout_style', true );
	if ($page_layout == 'predefine') {
		return true;
	}
	return false;
}

function ctm_killar_is_boxed_layout_active() {
	$page_layout = get_theme_mod( 'killar_main_layout_style', true );
	if ($page_layout == 'boxed') {
		return true;
	}
	return false;
}


function ctm_killar_get_registered_sidebars() {
	global $wp_registered_sidebars;
	$sidebars = array();
	if ( !empty( $wp_registered_sidebars ) ) {
		foreach( $wp_registered_sidebars as $sk => $sv ) {
			$sidebars[$sv['id']] = $sv['name'];
		}
	}
	return $sidebars;
}

function ctm_killar_blog_loop_post_page_title() {
	$page_title = get_theme_mod( 'killar_blog_loop_post_page_title', 'custom' );
	if ( $page_title == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killarwt_blog_loop_post_page_title_background() {
	$type = get_theme_mod( 'killar_blog_loop_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killarwt_blog_loop_view_type_is_grid() {
	$style = get_theme_mod( 'killar_blog_loop_view_type', 'default' );
	if ( $style == 'grid' ) {
		return true;
	}
	return false;
}

function ctm_killarwt_blog_loop_post_social_share() {
	$sections = get_theme_mod( 'killar_blog_loop_post_sections_positioning');
	if ( in_array( 'social_links', $sections ) ) {
		return true;
	}
	return false;
}

function ctm_killarwt_blog_loop_post_pagination_style_not_default() {
	$style = get_theme_mod( 'killar_blog_loop_post_pagination_style', 'default' );
	if ($style != 'default') {
		return true;
	}
	return false;
}

function ctm_killarwt_blog_loop_latest_articles_section() {
	$status = get_theme_mod( 'killar_blog_loop_latest_articles_section', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_killarwt_blog_loop_mostread_articles_section() {
	$status = get_theme_mod( 'killar_blog_loop_mostread_articles_section', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_killar_blog_single_post_page_title() {
	$page_title = get_theme_mod( 'killar_blog_single_post_page_title', 'custom' );
	if ($page_title == 'custom') {
		return true;
	}
	return false;
}

function ctm_killar_blog_single_post_page_title_background() {
	$type = get_theme_mod( 'killar_blog_single_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killar_blog_single_post_social_share() {
	$enabled = get_theme_mod( 'killar_blog_single_post_social_share', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_killar_blog_single_post_related_posts() {
	$enabled = get_theme_mod( 'killar_blog_single_post_related_posts', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_killar_social_links_enabled() {
	$enabled = get_theme_mod( 'killar_social_links', true );
	if ( $enabled == true) {
		return true;
	}
	return false;
}

function ctm_killar_social_share_links_enabled() {
	$enabled = get_theme_mod( 'killar_social_share_links', true );
	if ( $enabled == true) {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_loop_post_page_title() {
	$page_title = get_theme_mod( 'killar_portfolio_loop_post_page_title', 'custom' );
	if ($page_title == 'custom') {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_loop_post_page_title_background() {
	$type = get_theme_mod( 'killar_portfolio_loop_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_loop_post_section_show_title() {
	$enabled = get_theme_mod( 'killar_portfolio_loop_post_section_show_title', true );
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_loop_view_type_is_grid() {
	$style = get_theme_mod( 'killar_portfolio_loop_view_type', 'default' );
	if ( in_array( $style, array( 'gallery-filter-dark', 'gallery-filter-light', 'grid' ) ) ) {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_loop_post_social_share() {
	$sections = get_theme_mod( 'killar_portfolio_loop_post_sections_positioning');
	if ( in_array( 'social_links', $sections ) ) {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_loop_post_pagination_style_not_default() {
	$style = get_theme_mod( 'killar_portfolio_loop_post_pagination_style', 'default' );
	if ($style != 'default') {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_single_post_page_title() {
	$page_title = get_theme_mod( 'killar_portfolio_single_post_page_title', 'custom' );
	if ($page_title == 'custom') {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_single_post_page_title_background() {
	$type = get_theme_mod( 'killar_portfolio_single_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_single_post_social_share() {
	$enabled = get_theme_mod( 'killar_portfolio_single_post_social_share', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_killar_portfolio_single_post_related_posts() {
	$enabled = get_theme_mod( 'killar_portfolio_single_post_related_posts', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_killar_is_footer_layout_simple() {
	$type = get_theme_mod( 'killar_footer_layout', 'simple');
	if ($type == 'simple') {
		return true;
	}
	return false;
}

