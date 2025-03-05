<?php
/**
 * Helpers
 *
 * @package KillarWT
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! function_exists( 'killarwt_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function killarwt_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

function ctm_killarwt_header_shop_right_buttons() {
	$layout = get_theme_mod('killar_header_right_layout', true);
	if ($layout == 'shop') {
		return true;
	}
	return false;
}

function ctm_killarwt_mobile_header_shop_right_buttons() {
	$layout = get_theme_mod('killar_mobile_header_right_layout', true);
	if ($layout == 'mobile-shop') {
		return true;
	}
	return false;
}

function ctm_killar_is_product_image_swap_style() {
	$style = get_theme_mod( 'killar_woo_loop_product_image_style', true );
	if ($style == 'image-swap') {
		return true;
	}
	return false;
}

function ctm_killar_is_product_image_slider_style() {
	$style = get_theme_mod( 'killar_woo_loop_product_image_style', true );
	if ($style == 'image-slider') {
		return true;
	}
	return false;
}

function killarwt_woo_general_badges_enable() {
	$style = get_theme_mod( 'killar_woo_loop_product_badges_status', true );
	if ($style == true) {
		return true;
	}
	return false;
}

function ctm_killar_woo_general_badges_sale_enable() {
	$style = get_theme_mod( 'killar_woo_loop_product_badges_sale', true );
	if ($style == true && (killarwt_woo_general_badges_enable() == true) ) {
		return true;
	}
	return false;
}

function ctm_killar_woo_general_badges_new_enable() {
	$style = get_theme_mod( 'killar_woo_loop_product_badges_new', true );
	if ($style == true) {
		return true;
	}
	return false;
}

function ctm_killar_woo_loop_prod_quickview_enable() {
	$status = get_theme_mod( 'killar_woo_loop_prod_quickview', true );
	if ($status == true) {
		return true;
	}
	return false;
}

/**
 * Loop : Enable Product Ratting
 */
function ctm_killar_is_product_content_ratings_enable() {
	$value = get_theme_mod( 'killar_woo_loop_prod_ratings', true );
	if ($value == true) {
		return true;
	}
	return false;
}

/**
 * Loop : Enable Product Description
 */
function ctm_killar_is_product_content_description_enable() {
	$value = get_theme_mod( 'killar_woo_loop_prod_description', true );
	if ($value == true) {
		return true;
	}
	return false;
}

function ctm_killar_is_product_content_action_buttons_enable() {
	$style = get_theme_mod( 'killar_woo_loop_prod_actions_buttons', true );
	if ($style == true) {
		return true;
	}
	return false;
}

function ctm_killar_woo_general_badges_featured_enable() {
	$style = get_theme_mod( 'killar_woo_loop_product_badges_featured', true );
	if ($style == true && (killarwt_woo_general_badges_enable() == true) ) {
		return true;
	}
	return false;
}

function ctm_killar_woo_general_badges_outofstock_enable() {
	$style = get_theme_mod( 'killar_woo_loop_product_badges_outofstock', true );
	if ($style == true && (killarwt_woo_general_badges_enable() == true) ) {
		return true;
	}
	return false;
}

function ctm_killar_woo_loop_gridlist_enable() {
	$status = get_theme_mod( 'killar_woo_loop_gridlist', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_killar_woo_loop_show_perpage_dropdown_enable() {
	$status = get_theme_mod( 'killar_is_woo_loop_show_perpage_dropdown', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_killar_is_woo_single_prod_availability_enable() {
	$status = get_theme_mod( 'killar_woo_single_prod_availability_enable', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_killar_is_woo_single_prod_upsells_related_prods_slider_enable() {
	$status = get_theme_mod( 'killar_woo_single_prod_upsell_related_prods_slider_enable', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_killar_woo_single_prod_sale_label_after_price() {
	$status = get_theme_mod( 'killar_woo_single_prod_sale_label', 'after-price' );
	if ($status == 'after-price') {
		return true;
	}
	return false;
}


function ctm_killar_is_woo_cart_prod_slider_slider_enable() {
	$status = get_theme_mod( 'killar_woo_cart_prod_slider_slider_enable', true );
	if ( $status == true ) {
		return true;
	}
	return false;
}

function ctm_killar_woo_archive_page_title_custom() {
	$style = get_theme_mod( 'killar_woo_archive_page_title', 'post_title' );
	if ( $style == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killar_woo_archive_page_title_background_custom() {
	$style = get_theme_mod( 'killar_woo_archive_page_title_background', 'default' );
	if ( $style == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killarwt_woo_loop_pagination_style_not_default() {
	$style = get_theme_mod( 'killar_woo_archive_pagination_style', true );
	if ( $style != 'default' ) {
		return true;
	}
	return false;
}

function ctm_killar_woo_single_prod_page_title_custom() {
	$style = get_theme_mod( 'killar_woo_single_prod_page_title', 'post_title' );
	if ( $style == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killar_woo_single_prod_page_title_background_custom() {
	$style = get_theme_mod( 'killar_woo_single_prod_page_title_background', 'default' );
	if ( $style == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_killarwt_woo_single_prod_pagination_style_not_default() {
	$style = get_theme_mod( 'killar_woo_single_prod_pagination_style', true );
	if ( $style != 'default' ) {
		return true;
	}
	return false;
}