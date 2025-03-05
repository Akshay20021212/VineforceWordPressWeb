<?php
/**
 * WooCommerce Cart Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_WooCommerce_Cart_Customizer' ) ) :

	class KillarWT_WooCommerce_Cart_Customizer {

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
			 * Cart Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_woo_cart_section' , array(
				'title' 			=> __( 'Cart', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_woocommerce_panel',
			) );
			
			/**
			 * Cart : Product Slider Heading =========================================================================
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_cart_prod_slider_heading', array(
				'label'	   				=> __( 'Products Slider', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product Upsell : Display
			 */
			$wp_customize->add_setting( 'killar_woo_cart_cross_sells_prod_slider_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_cart_cross_sells_prod_slider_enable', array(
				'label'	   				=> __( 'Enable Cross Sells Products', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_cross_sells_prod_slider_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Cart : Product Slider : Show nums of products
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_nums_of_products', array(
				'default'          		=>  8,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_woo_cart_prod_slider_nums_of_products', array(
				'label'   				=> __( 'Show Number of Products', 'killar' ),
				'section' 				=> 'killar_woo_cart_section',
				'settings'  			=> 'killar_woo_cart_prod_slider_nums_of_products',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 100,
											'step' => 1,
										),
				'priority' 			=> 10,
			) ) );
			
			/**
			 * Cart : Product Slider : Columns  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_columns_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_cart_prod_slider_columns_heading', array(
				'label'	   				=> '',
				'description'	   		=> __( '<b>Show numbers of products below list of screen size.</b>', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_columns_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Cart : Product Slider : xl Columns
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_products_col_xl', array(
				'default'           	=> '6',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_cart_prod_slider_products_col_xl', array(
				'label'	   				=> __( 'Extra Extra large devices (extra large desktops, 1740px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_products_col_xl',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
											'7' 				=> __( '7 - Item(s)', 'killar' ),
											'8' 				=> __( '8 - Item(s)', 'killar' ),
											
										),
			) ) );

			/**
			 * Cart : Product Slider : LG Columns
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_products_col_lg', array(
				'default'           	=> '4',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_cart_prod_slider_products_col_lg', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_products_col_lg',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
			) ) );

			/**
			 * Cart : Product Slider : MD Columns
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_products_col_md', array(
				'default'           	=> '4',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_cart_prod_slider_products_col_md', array(
				'label'	   				=> __( 'Medium devices (tablets, less than 992px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_products_col_md',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
			) ) );

			/**
			 * Cart : Product Slider : SM Columns
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_products_col_sm', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_cart_prod_slider_products_col_sm', array(
				'label'	   				=> __( 'Small devices (landscape phones, less than 768px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_products_col_sm',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
										),
			) ) );

			/**
			 * Cart : Product Slider : XS Columns
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_products_col_xs', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_cart_prod_slider_products_col_xs', array(
				'label'	   				=> __( 'Extra small devices (portrait phones, less than 576px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_products_col_xs',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
										),
			) ) );
			
			/**
			 * Cart : Product Slider : Enable Carousel
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_prods_slider_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_cart_prod_slider_prods_slider_enable', array(
				'label'	   				=> __( 'Enable Carousel', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_prods_slider_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Cart : Product Slider : Enable Carousel Autoplay
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_prods_slider_autoplay', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_cart_prod_slider_prods_slider_autoplay', array(
				'label'	   				=> __( 'Carousel Autoplay', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_prods_slider_autoplay',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_cart_prod_slider_slider_enable',
			) ) );
			
			/**
			 * Cart : Product Slider : Enable Carousel Loop
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_prods_slider_loop', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_cart_prod_slider_prods_slider_loop', array(
				'label'	   				=> __( 'Carousel Loop', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_prods_slider_loop',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_cart_prod_slider_slider_enable',
			) ) );
			
			/**
			 * Cart : Product Slider : Enable Carousel Navigation
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_prods_slider_navigation', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_cart_prod_slider_prods_slider_navigation', array(
				'label'	   				=> __( 'Carousel Navigation', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_prods_slider_navigation',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_cart_prod_slider_slider_enable',
			) ) );
			
			/**
			 * Cart : Product Slider : Enable Carousel Dots Navigation
			 */
			$wp_customize->add_setting( 'killar_woo_cart_prod_slider_prods_slider_dots_navigation', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_cart_prod_slider_prods_slider_dots_navigation', array(
				'label'	   				=> __( 'Carousel Dots Navigation', 'killar' ),
				'section'  				=> 'killar_woo_cart_section',
				'settings' 				=> 'killar_woo_cart_prod_slider_prods_slider_dots_navigation',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_cart_prod_slider_slider_enable',
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

return new KillarWT_WooCommerce_Cart_Customizer();