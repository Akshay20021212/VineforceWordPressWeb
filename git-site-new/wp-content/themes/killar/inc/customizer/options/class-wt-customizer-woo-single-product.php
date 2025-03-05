<?php
/**
 * WooCommerce Single Product Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_WooCommerce_Single_Product_Customizer' ) ) :

	class KillarWT_WooCommerce_Single_Product_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_customizer_scripts' ), 30 );

		}

		/**
		 * Customizer options
		 *
		 * @since 1.0.0
		 */
		public function options_register( $wp_customize ) {
			
			/**
			 * Single Product Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_woo_single_prod_section' , array(
				'title' 			=> __( 'Single Product', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_woocommerce_panel',
			) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_layout', array(
				'default'        	    => 'mprod-s1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_woo_single_prod_layout', array(
				'label'	   				=> __( 'Product Layout', 'killar' ),
				'choices' 				=> array(
											'full-width'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_layout',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Product : Sidebar
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_sidebar', array(
				'default'        	    => 'woo-single-prod-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'killar' ),
				'description'	   		=> __( 'Choose sidebar for display on the single product page.', 'killar' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_killar_get_registered_sidebars(),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_sidebar',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Product : Image Width
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_desktop_image_width', array(
				'default' 				=> '6',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );
			$wp_customize->add_setting( 'killar_woo_single_prod_tablet_image_width', array(
				'default' 				=> '6',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );
			$wp_customize->add_setting( 'killar_woo_single_prod_mobile_image_width', array(
				'default' 				=> '12',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Media_Columns_Control( $wp_customize, 'killar_woo_single_prod_image_width', array(
				'label'	   				=> esc_html__( 'Image Width (Column)', 'killar' ),
				'description'	   		=> esc_html__( 'Select number of bootstrap columns want to show for image width.', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',				
				'settings'  		    => array(
					'desktop_width' 	=> 'killar_woo_single_prod_desktop_image_width',
					'tablet_width' 		=> 'killar_woo_single_prod_tablet_image_width',
					'mobile_width' 		=> 'killar_woo_single_prod_mobile_image_width',
				),
				'priority' 				=> 10,
				'input_attrs' 			=> array(
					'min'   => 1,
					'max'   => 12,
					'step'  => 1,
				),
			) ) );

			/**
			 * Single Product : Summary Width
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_desktop_summary_width', array(
				'default' 				=> '6',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );
			$wp_customize->add_setting( 'killar_woo_single_prod_tablet_summary_width', array(
				'default' 				=> '6',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );
			$wp_customize->add_setting( 'killar_woo_single_prod_mobile_summary_width', array(
				'default' 				=> '12',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Media_Columns_Control( $wp_customize, 'killar_woo_single_prod_summary_width', array(
				'label'	   				=> esc_html__( 'Summary Width (Column)', 'killar' ),
				'description'	   		=> esc_html__( 'Select number of bootstrap columns want to show for summary width.', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',				
				'settings'  		    => array(
					'desktop_width' 	=> 'killar_woo_single_prod_desktop_summary_width',
					'tablet_width' 		=> 'killar_woo_single_prod_tablet_summary_width',
					'mobile_width' 		=> 'killar_woo_single_prod_mobile_summary_width',
				),
				'priority' 				=> 10,
				'input_attrs' 			=> array(
					'min'   => 1,
					'max'   => 12,
					'step'  => 1,
				),
			) ) );
			
			/**
			 * Single Product : Sale Label/Badge
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_sale_label', array(
				'default'           	=> 'after-price',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_sale_label', array(
				'label'	   				=> __( 'Sale Label/Badge', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_sale_label',
				'priority' 				=> 10,
				'choices' 				=> array(
											'on-image' 				=> __( 'On Product Image', 'killar' ),
											'after-price' 			=> __( 'After Price', 'killar' ),
											'hidden' 				=> __( 'Hide', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Product : Sale Percentage Text
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_sale_label_percentage_text', array(
				'default'           	=> '{percentage} off',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( 'killar_woo_single_prod_sale_label_percentage_text', array(
				'label' 			=> esc_html__( 'Sale Percentage Text', 'killar' ),
				'description' 		=> esc_html__( 'Display sale percentage text like 10% off, "{percentage}" is dynamic value.', 'killar' ),
				'section' 			=> 'killar_woo_single_prod_section',
				'settings' 			=> 'killar_woo_single_prod_sale_label_percentage_text',
				'priority' 			=> 10,
				'active_callback' 	=> 'ctm_killar_woo_single_prod_sale_label_after_price',
			) );
			
			/**
			 * Pro
			 * Single Product Product Image Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_image_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_single_prod_image_heading', array(
				'label'	   				=> __( 'Image', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_image_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Product Image : Product Gallery Zoom
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_image_gal_zoom', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_image_gal_zoom', array(
				'label'	   				=> __( 'Enable Product Gallery Zoom', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_image_gal_zoom',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Product Image : Gallery Lightbox
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_gal_lightbox', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_gal_lightbox', array(
				'label'	   				=> __( 'Enable Gallery Lightbox', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_gal_lightbox',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Product Image : Gallery Layout
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_image_gal_layout', array(
				'default'           	=> 'hor',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_image_gal_layout', array(
				'label'	   				=> __( 'Gallery Layout', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_image_gal_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hor' 				=> __( 'Horizontal', 'killar' ),
											'ver' 				=> __( 'Verticle', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Product : Summary Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_summary_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_single_prod_summary_heading', array(
				'label'	   				=> __( 'Summary', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_summary_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product : Product Rating
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_rating_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_rating_enable', array(
				'label'	   				=> __( 'Product Rating', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_rating_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product : Product Availability
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_availability_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_availability_enable', array(
				'label'	   				=> __( 'Product Availability', 'killar' ),
				'description'	   		=> esc_html__( 'Show Product availability message like In Stock, Out of Stock, Hurry left, etc...', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_availability_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product : In Stock Message
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_availability_instock_msg', array(
				'default'           	=> 'In Stock',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_availability_instock_msg', array(
				'label'	   				=> __( 'In Stock Message', 'killar' ),
				'type' 					=> 'text',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_availability_instock_msg',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_single_prod_availability_enable',
			) ) );
			
			/**
			 * Single Product : Low Stock Qty
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_availability_lowstock_qty', array(
				'default'          		=>  10,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_woo_single_prod_availability_lowstock_qty', array(
				'label'   				=> __( 'Low Stock Qty', 'killar' ),
				'description'	   		=> esc_html__( 'Display numbers of quentity in low stock qty message like Hurry, Only {qty} left in stock. if you want to hide then set "0".', 'killar' ),
				'section' 				=> 'killar_woo_single_prod_section',
				'settings'  			=> 'killar_woo_single_prod_availability_lowstock_qty',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 100,
											'step' => 1,
										),
				'priority' 			=> 10,
			) ) );
			
			/**
			 * Single Product : Low Stock Qty Message
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_availability_lowstock_qty_msg', array(
				'default'           	=> 'Hurry, Only {qty} left in stock',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_availability_lowstock_qty_msg', array(
				'label'	   				=> __( 'Low Stock Qty Message', 'killar' ),
				'description'	   		=> esc_html__( 'Display Low stock Message Hurry, Only {qty} left in stock. {qty} is the dynamic value of the low stock quentity value.', 'killar' ),
				'type' 					=> 'text',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_availability_lowstock_qty_msg',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_single_prod_availability_enable',
			) ) );
			
			/**
			 * Single Product : Out of Stock Message
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_availability_outofstock_msg', array(
				'default'           	=> 'Out of Stock',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_availability_outofstock_msg', array(
				'label'	   				=> __( 'Out of Stock Message', 'killar' ),
				'type' 					=> 'text',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_availability_outofstock_msg',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_single_prod_availability_enable',
			) ) );
			
			/**
			 * Single Product : Product Short Description
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_short_description_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_short_description_enable', array(
				'label'	   				=> __( 'Product Short Description', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_short_description_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product : Product Meta
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_meta_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_meta_enable', array(
				'label'	   				=> __( 'Product Meta', 'killar' ),
				'description'	   		=> esc_html__( 'Show/Hide SKU, Cateatory, Tags etc..', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_meta_enable',
				'priority' 				=> 10,
			) ) );

			/**
			 * Shop : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_title_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_single_prod_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Shop : Page Title Section
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Shop : Page Title Alignment
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_title_alignment', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_single_prod_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_title_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 		=> __( 'Default', 'killar' ),
											'left' 			=> __( 'Left', 'killar' ),
											'centered' 		=> __( 'Center', 'killar' ),
											'right' 		=> __( 'Right', 'killar' ),
										),
			) ) );
			
			/**
			 * Shop : Page Title
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_single_prod_page_title', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'killar' ),
											'custom' 			=> __( 'Custom Text', 'killar' ),
											'post_title' 		=> __( 'Post Title', 'killar' ),
										),
			) ) );
			
			/**
			 * Shop : Page Custom Title
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_title_custom', array(
				'type' 					=> 'theme_mod',
				'sanitize_callback' 	=> 'sanitize_text_field',
				'default' 				=> 'Single Product',
			) );

			$wp_customize->add_control( 'killar_woo_single_prod_page_title_custom', array(
				'label' 				=> esc_html__( 'Page Title Custom Text', 'killar' ),
				'section' 				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_title_custom',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_woo_single_prod_page_title_custom',
			) );
			
			/**
			 * Shop : Page Title Background Image
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_single_prod_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'featured_image' 	=> __( 'Featured Image', 'killar' ),
											'custom'		 	=> __( 'Custom', 'killar' ),
											'hide' 				=> __( 'Hide', 'killar' ),
										),
			) ) );
			
			/**
			 * Shop : Background Image
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_title_bg_image', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_woo_single_prod_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_woo_single_prod_page_title_background_custom',
			) ) );
			
			/**
			 * Shop : Breadcrumb
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product Tabs Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_tabs_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_single_prod_tabs_heading', array(
				'label'	   				=> __( 'Tabs', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_tabs_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Product Tabs : Tabs Layout
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_tabs_layout', array(
				'default'           	=> 'fancy',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_tabs_layout', array(
				'label'	   				=> __( 'Tabs Layout', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_tabs_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
											'def' 				=> __( 'Default Layout', 'killar' ),
											'fancy' 				=> __( 'Fancy Layout', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Product Upsell/Related Product Heading =========================================================================
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_heading', array(
				'label'	   				=> __( 'Upsell/Related Products', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product Upsell : Display
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsells_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_upsells_enable', array(
				'label'	   				=> __( 'Enable Upsell Products', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsells_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product Related : Display
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_related_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_related_enable', array(
				'label'	   				=> __( 'Enable Related Products', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_related_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product Upsell/Related : Show nums of products
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_nums_of_products', array(
				'default'          		=>  8,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_nums_of_products', array(
				'label'   				=> __( 'Show Number of Products', 'killar' ),
				'section' 				=> 'killar_woo_single_prod_section',
				'settings'  			=> 'killar_woo_single_prod_upsell_related_nums_of_products',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 100,
											'step' => 1,
										),
				'priority' 			=> 10,
			) ) );
			
			/**
			 * Single Product Upsell/Related : Columns  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_columns_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_columns_heading', array(
				'label'	   				=> '',
				'description'	   		=> __( '<b>Show numbers of products below list of screen size.</b>', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_columns_heading',
				'priority' 				=> 10,
			) ) );
			

			/**
			 * Single Product Upsell/Related : LG Columns
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_products_col_lg', array(
				'default'           	=> '4',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_products_col_lg', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_products_col_lg',
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
			 * Single Product Upsell/Related : MD Columns
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_products_col_md', array(
				'default'           	=> '4',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_products_col_md', array(
				'label'	   				=> __( 'Medium devices (tablets, less than 992px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_products_col_md',
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
			 * Single Product Upsell/Related : SM Columns
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_products_col_sm', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_products_col_sm', array(
				'label'	   				=> __( 'Small devices (landscape phones, less than 768px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_products_col_sm',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
										),
			) ) );

			/**
			 * Single Product Upsell/Related : XS Columns
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_products_col_xs', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_products_col_xs', array(
				'label'	   				=> __( 'Extra small devices (portrait phones, less than 576px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_products_col_xs',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Product Upsell/Related : Enable Carousel
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_prods_slider_enable', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_prods_slider_enable', array(
				'label'	   				=> __( 'Enable Carousel', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_prods_slider_enable',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Product Upsell/Related : Enable Carousel Autoplay
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_prods_slider_autoplay', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_prods_slider_autoplay', array(
				'label'	   				=> __( 'Carousel Autoplay', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_prods_slider_autoplay',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_single_prod_upsells_related_prods_slider_enable',
			) ) );
			
			/**
			 * Single Product Upsell/Related : Enable Carousel Loop
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_prods_slider_loop', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_prods_slider_loop', array(
				'label'	   				=> __( 'Carousel Loop', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_prods_slider_loop',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_single_prod_upsells_related_prods_slider_enable',
			) ) );
			
			/**
			 * Single Product Upsell/Related : Enable Carousel Navigation
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_prods_slider_navigation', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_prods_slider_navigation', array(
				'label'	   				=> __( 'Carousel Navigation', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_prods_slider_navigation',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_single_prod_upsells_related_prods_slider_enable',
			) ) );
			
			/**
			 * Single Product Upsell/Related : Enable Carousel Dots Navigation
			 */
			$wp_customize->add_setting( 'killar_woo_single_prod_upsell_related_prods_slider_dots_navigation', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_single_prod_upsell_related_prods_slider_dots_navigation', array(
				'label'	   				=> __( 'Carousel Dots Navigation', 'killar' ),
				'section'  				=> 'killar_woo_single_prod_section',
				'settings' 				=> 'killar_woo_single_prod_upsell_related_prods_slider_dots_navigation',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_woo_single_prod_upsells_related_prods_slider_enable',
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
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			$products = get_posts( array( 'post_type' => 'product', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( $products[0] ) ) { ?>
					wp.customize.section( 'killar_woo_single_prod_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_permalink($products[0]) ); ?>" );
							}
						} );
					} );
					<?php } ?>
				} );
			</script>
			<?php
		}

	}

endif;

return new KillarWT_WooCommerce_Single_Product_Customizer();