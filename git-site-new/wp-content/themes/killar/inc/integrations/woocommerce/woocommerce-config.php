<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * KillarWT WooCommerce Compatibility
 */
 
if ( ! class_exists( 'KillarWT_WooCommerce_Config' ) ) {
		
	class KillarWT_WooCommerce_Config {
		
		/**
		 * Constructor
		 */
		public function __construct() {
			
			//Woo Theme Setup
			add_action( 'after_setup_theme', array( $this, 'woo_theme_setup' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'killarwt_woo_enqueue_scripts' ), 0 );
			//add_filter( 'woocommerce_enqueue_styles', array( $this, 'woo_filter_style' ) );
			add_filter( 'body_class', array( $this, 'woo_body_class' ) );

			// Register Store Sidebars.
			add_filter( 'widgets_init', array( $this, 'killarwt_register_woo_sidebar' ) );

			//Add filter button
			add_action( 'killar_after_content_wrap', array( $this, 'killarwt_woo_filter_button' ) );

			if ( ! apply_filters( 'killar_woo_archive_structure_override', false ) ) {
				//Include helper functions
				require_once KILLARWT_INC_DIR .'integrations/woocommerce/wc-template-hooks.php';
				require_once KILLARWT_INC_DIR .'integrations/woocommerce/wc-template-fuctions.php';
	
			}
		}

		/**
		 * Woo Theme Setup
		 *
		 * @since 1.0.0
		 */
		public static function woo_theme_setup() {
			
			add_theme_support( 'woocommerce' );

			//Enable Gallery Zoom
			if ( killarwt_woo_single_prod_gal_zoom()) {
				add_theme_support( 'wc-product-gallery-zoom' );
			}
			
			//Enable Gallery Lightbox
			if ( killarwt_woo_single_prod_gal_lightbox()) {
				add_theme_support( 'wc-product-gallery-lightbox' );
			}
		}

		/**
		 * Woo Enqueu Scripts
		 */
		public static function killarwt_woo_enqueue_scripts() {

			//Deregister wishlist font-awesome css
			if ( function_exists( 'YITH_WCWL' ) ):
				wp_deregister_style( 'yith-wcwl-font-awesome' );
			endif;
			
		}
		
		/**
		 * WooCommerce Style
		 *
		 * @param  array $styles  Css files.
		 *
		 * @return array
		 */
		function woo_filter_style( $styles ) {

			$css_uri = KILLARWT_CSS_DIR_URI.'third/woocommerce/';

			$styles = array(
				'woocommerce-layout'      => array(
					'src'     => $css_uri.'woocommerce-layout.css',
					'deps'    => '',
					'version' => KILLARWT_VERSION,
					'media'   => 'all',
					'has_rtl' => true,
				),
				'woocommerce-general'     => array(
					'src'     => $css_uri.'woocommerce.css',
					'deps'    => '',
					'version' => KILLARWT_VERSION,
					'media'   => 'all',
					'has_rtl' => true,
				),
			);

			return $styles;
		}
		
		/**
		 * WooCommerce Classes
		 *
		 * @return array
		 */
		function woo_body_class ( $classes ) {
			return $classes;
		}
		
		/**
		 * Breadcrumb
		 */
		public static function killarwt_breadcrumb() {
			get_template_part( 'template-parts/breadcrumb' );
		}

		/**
		 * Register WooCommerce sidebar.
		 */
		public static function killarwt_register_woo_sidebar() {

			// Register new woo_sidebar widget area
			register_sidebar(
				apply_filters(
					'killar_woo_archive_sidebar_init',
					array(
						'name'          => esc_html__( 'WooCommerce Sidebar', 'killar' ),
						'id'            => 'woo-archive-shop-sidebar',
						'description'   => __( 'This sidebar will be used on Product archive, Cart, Checkout and My Account pages.', 'killar' ),
						'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>',
					)
				)
			);

			register_sidebar(
				apply_filters(
					'killar_woo_single_sidebar_init',
					array(
						'name'          => esc_html__( 'WooCommerce Product Sidebar', 'killar' ),
						'id'            => 'woo-single-prod-sidebar',
						'description'   => __( 'This sidebar will be used on Single Product page.', 'killar' ),
						'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>',
					)
				)
			);

		}

		/**
		 * Loop : open filter wrapper
		 */
		public static function killarwt_open_div_shop_loop() {
			echo '<div class="filter-row d-flex align-items-center justify-content-between mb-4">';
		}

		/**
		 * Loop : close filter wrapper
		 */
		public static function killarwt_close_div_shop_loop() {
			echo '</div>';
		}

		public function killarwt_woo_filter_button() {
			if( killarwt_is_catalog() ) {
				echo '<button type="button" class="d-lg-none btn btn-md btn-primary w-100 rounded-0 fixed-bottom" data-bs-toggle="offcanvas" data-bs-target="#Sidebarshop"><i class="fa-solid fa-filter me-2"></i>'.esc_html__( 'Filter Shop', 'killar' ).'</button>';
			}
		}
	}

	new KillarWT_WooCommerce_Config();
}