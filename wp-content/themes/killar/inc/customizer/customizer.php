<?php
/**
 * Customizer Class
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KillarWT_Customizer' ) ) :

	class KillarWT_Customizer {

		public function __construct() {
			add_action( 'customize_register', array( $this, 'customizer_controls' ) );
			add_action( 'after_setup_theme', array( $this, 'customizer_includes' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ), 15 );
			add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'custom_customize_enqueue' ), 7 );
		}
		
		/**
		 * Customizer Controls
		 */
		public function customizer_controls( $wp_customize ){
			
			theme_license_verified(true);
	
			define( 'KILLARWT_CUSTOMIZER_CONTROL_DIR', KILLARWT_INC_DIR . 'customizer/controls/' );
			define( 'KILLARWT_CUSTOMIZER_MODULES_DIR', KILLARWT_INC_DIR . 'customizer/modules/' );
			define( 'KILLARWT_CUSTOMIZER_CONTROL_DIR_URI', KILLARWT_INC_DIR_URI . 'customizer/controls/' );
			define( 'KILLARWT_CUSTOMIZER_MODULES_DIR_URI', KILLARWT_INC_DIR_URI . 'customizer/modules/' );

			require_once KILLARWT_CUSTOMIZER_MODULES_DIR . 'panels/class-module-panels.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'base/class-control-base.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'slider/class-control-slider.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'radio-image/class-control-radio-image.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'buttonset/class-control-buttonset.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'typography/class-control-typography.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'heading/class-control-heading.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'dimensions/class-control-dimensions.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'media-columns/class-control-media-columns.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'checkbox-toggle/class-control-checkbox-toggle.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'sortable/class-control-sortable.php';
			require_once KILLARWT_CUSTOMIZER_CONTROL_DIR . 'color/class-control-color.php';
			
			$wp_customize->register_panel_type( 'KillarWT_Customizer_Module_Panels' );

			$wp_customize->register_control_type( 'KillarWT_Customizer_Slider_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Radio_Image_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Buttonset_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Typography_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Heading_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Dimensions_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Media_Columns_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Checkbox_Toggle_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Sortable_Control' );
			$wp_customize->register_control_type( 'KillarWT_Customizer_Color_Control' );
			
		}
		
		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			$wp_customize->add_panel( 'killar_options_panel' , array(
				'title' 			=> __( 'Killar Options', 'killar' ),
				'priority' 			=> '-3000',
			) );
			
			// Selective refresh.
			if ( function_exists( 'add_partial' ) ) {
				$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
			}

			// Move custom logo setting
			$wp_customize->get_control( 'custom_logo' )->section 		= 'killar_header_logo_section';

			if ( KILLARWT_WOOCOMMERCE_ACTIVE ) {
				
				/**
				 * WooCommerce Panel
				 */
				$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_woocommerce_panel',  array(
					'title' 			=> __( 'WooCommerce', 'killar' ),
					'priority' 			=> '-2400',
					'panel' 			=> 'killar_options_panel',
				) ) );
			}
			
		}
		
		/**
		 * Customizer Includes
		 */
		public function customizer_includes( $wp_customize ){
			
			require_once KILLARWT_INC_DIR . 'customizer/customizer-helpers.php';
			require_once KILLARWT_INC_DIR . 'customizer/customizer-sanitizes.php';
			
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-general.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-topbar.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-header.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-typography.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-footer.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-page-title.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-blog-post.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-portfolio.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-social.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-pages.php';
			require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-mobile.php';
			
			if ( KILLARWT_WOOCOMMERCE_ACTIVE ) {
				require_once KILLARWT_INC_DIR . 'customizer/customizer-woo-helpers.php';
				require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-woo.php';
				require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-woo-single-product.php';
				require_once KILLARWT_INC_DIR . 'customizer/options/class-wt-customizer-woo-cart.php';				
			}
			
		}
		
		/**
		 * Enqueue scripts for our Customizer preview
		 */
		public function customize_preview_init(){
			wp_enqueue_script( 'killarwt-customizer-preview', KILLARWT_INC_DIR_URI . 'customizer/assets/js/customizer-preview.js', array( 'customize-preview', 'jquery' ) );
		}
		
		/**
		 * Enqueue Style
		 */
		public function custom_customize_enqueue() {
			wp_enqueue_style( 'killarwt-customizer-style', KILLARWT_INC_DIR_URI.'customizer/assets/css/customizer.css', array(), KILLARWT_VERSION );
			wp_enqueue_script( 'killarwt-customizer-script', KILLARWT_INC_DIR_URI . 'customizer/assets/js/customizer.js', array( 'jquery' ), KILLARWT_VERSION );
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_killarwt_theme_mods()
		 * @return array $styles the css
		 */
		public function get_css() {
		
			$styles = '';
			return apply_filters( 'killarwt_customizer_css', $styles );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {
			wp_add_inline_style( 'killarwt-style', self::get_css() );
		}

		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since  1.0.0
		 */
		public function layout_class( $classes ) {
			$left_or_right = get_theme_mod( 'killarwt_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}
	}

endif;

return new KillarWT_Customizer();
