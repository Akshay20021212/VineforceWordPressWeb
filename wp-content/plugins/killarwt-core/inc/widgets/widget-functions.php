<?php
/**
 * Widget Functions
 *
 * Widget related functions and widget registration.
 *
 * @package KillarWT
 * @since 1.0.0
 */


if ( !defined( 'ABSPATH' ) ) exit;

define( 'KILLARWT_CORE_WIDGETS_DIR', KILLARWT_CORE_INC_DIR . 'widgets' );
require_once KILLARWT_CORE_WIDGETS_DIR . '/wph-widget-class.php';
require_once KILLARWT_CORE_WIDGETS_DIR . '/class-widget-image-box.php';
require_once KILLARWT_CORE_WIDGETS_DIR . '/class-widget-blog.php';
require_once KILLARWT_CORE_WIDGETS_DIR . '/class-widget-posts.php';

/**
 * Register Widgets.
 */
function killarwt_register_widgets() {
	
	register_widget( 'Killar_Widget_Image_Box' );
	register_widget( 'Killar_Widget_Blog' );
	register_widget( 'Killar_Widget_Posts' );
	
	if ( class_exists( 'WooCommerce' ) ) {
		require_once KILLARWT_CORE_WIDGETS_DIR . '/class-widget-brands.php';
		require_once KILLARWT_CORE_WIDGETS_DIR . '/class-widget-products.php';
		require_once KILLARWT_CORE_WIDGETS_DIR . '/class-widget-products-tabs.php';
		//register_widget( 'Killar_Widget_Brands' );
		//register_widget( 'Killar_Widget_Products' );
		//register_widget( 'Killar_Widget_Products_Tabs' );
	}
}
add_action( 'widgets_init', 'killarwt_register_widgets' );
