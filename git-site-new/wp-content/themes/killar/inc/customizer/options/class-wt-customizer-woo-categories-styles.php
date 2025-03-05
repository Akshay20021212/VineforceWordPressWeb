<?php
/**
 * WooCommerce Categories Styles Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_WooCommerce_Categories_Styles_Customizer' ) ) :

	class KillarWT_WooCommerce_Categories_Styles_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );

		}

		/**
		 * Customizer options
		 *
		 * @since 1.0.0
		 */
		public function options_register( $wp_customize ) {
			
			/**
			 * Woo Categories Styles Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_woo_categories_styles_section' , array(
				'title' 			=> __( 'Categories Styles', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_woocommerce_panel',
			) );

			/**
			 * Styles
			 */
			$wp_customize->add_setting( 'killar_woo_cats_styles', array(
				'default'        	    => 'cats-s1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_woo_cats_styles', array(
				'label'	   				=> __( 'Categories Styles', 'killar' ),
				'choices' 				=> array(
											'cats-s1'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/cats-s1.png',
											'cats-s2'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/cats-s2.png',
											'cats-s3'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/cats-s3.png',
											),
				'section'  				=> 'killar_woo_categories_styles_section',
				'settings' 				=> 'killar_woo_cats_styles',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Categories Styles : Show Products Count
			 */
			$wp_customize->add_setting( 'killar_woo_cats_prods_count_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_cats_prods_count_enable', array(
				'label'	   				=> __( 'Show Products Count', 'killar' ),
				'section'  				=> 'killar_woo_categories_styles_section',
				'settings' 				=> 'killar_woo_cats_prods_count_enable',
				'priority' 				=> 10,
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function add_customizer_css( $output ) {
			
			return $output;
		}

	}

endif;

return new KillarWT_WooCommerce_Categories_Styles_Customizer();