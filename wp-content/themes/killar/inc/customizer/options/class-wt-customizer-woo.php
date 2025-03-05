<?php
/**
 * WooCommerce Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_WooCommerce_Customizer' ) ) :

	class KillarWT_WooCommerce_Customizer {

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
			 * Product Styles Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_woo_archive_gen_section' , array(
				'title' 			=> __( 'Shop / Archive Page', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_woocommerce_panel',
			) );

			/**
			 * Shop / Archive : General  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_archive_gen_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_archive_gen_heading', array(
				'label'	   				=> __( 'Shop / Archive : General', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_gen_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'killar_woo_archive_layout', array(
				'default'        	    => 'mprod-s1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_woo_archive_layout', array(
				'label'	   				=> __( 'Shop Layout', 'killar' ),
				'choices' 				=> array(
											'full-width'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_layout',
				'priority' 				=> 10,
			) ) );

			/**
			 * Shop / Archive : Sidebar
			 */
			$wp_customize->add_setting( 'killar_woo_archive_sidebar', array(
				'default'        	    => 'woo-archive-shop-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_archive_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'killar' ),
				'description'	   		=> __( 'Choose sidebar for display on the Shop / Archive page.', 'killar' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_killar_get_registered_sidebars(),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Shop Page Display
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_display', array(
				'default'           	=> 'prods',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_archive_page_display', array(
				'label'	   				=> __( 'Shop page display', 'killar' ),
				'description'	   		=> __( 'Choose what to display on the main shop page.', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_display',
				'priority' 				=> 10,
				'choices' 				=> array(
											'prods' 				=> __( 'Show products', 'killar' ),
											'subcats' 					=> __( 'Show categories', 'killar' ),
											'prods_subcats' 			=> __( 'Show categories and products', 'killar' ),
										),
			) ) );

			/**
			 * Category Page Display
			 */
			$wp_customize->add_setting( 'killar_woo_category_page_display', array(
				'default'           	=> 'prods',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_category_page_display', array(
				'label'	   				=> __( 'Category page display', 'killar' ),
				'description'	   		=> __( 'Choose what to display on the main category page.', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_category_page_display',
				'priority' 				=> 10,
				'choices' 				=> array(
											'prods' 				=> __( 'Show products', 'killar' ),
											'subcats' 				=> __( 'Show subcategories', 'killar' ),
											'prods_subcats' 		=> __( 'Show subcategories and products', 'killar' ),
										),
			) ) );

			/**
			 * Default product sorting
			 */
			$wp_customize->add_setting( 'killar_woo_def_prods_sorting', array(
				'default'           	=> 'menu_order',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_def_prods_sorting', array(
				'label'	   				=> __( 'Default products sorting', 'killar' ),
				'description'	   		=> __( 'How should products be sorted in the catalog by default?', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_def_prods_sorting',
				'priority' 				=> 10,
				'choices' 				=> apply_filters( 'woocommerce_default_catalog_orderby_options', array(
											'menu_order' => __( 'Default sorting (custom ordering + name)', 'killar' ),
											'popularity' => __( 'Popularity (sales)', 'killar' ),
											'rating'     => __( 'Average rating', 'killar' ),
											'date'       => __( 'Sort by most recent', 'killar' ),
											'price'      => __( 'Sort by price (asc)', 'killar' ),
											'price-desc' => __( 'Sort by price (desc)', 'killar' ),
										) ),
			) ) );

			/**
			 * Shop / Archive : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_title_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_archive_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Shop / Archive : Page Title Section
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_archive_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Shop / Archive : Page Title Alignment
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_title_alignment', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_archive_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_title_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 		=> __( 'Default', 'killar' ),
											'left' 			=> __( 'Left', 'killar' ),
											'centered' 		=> __( 'Center', 'killar' ),
											'right' 		=> __( 'Right', 'killar' ),
										),
			) ) );
			
			/**
			 * Shop / Archive : Page Title
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_archive_page_title', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'killar' ),
											'custom' 			=> __( 'Custom Text', 'killar' ),
											'post_title' 		=> __( 'Post Title', 'killar' ),
										),
			) ) );
			
			/**
			 * Shop / Archive : Page Custom Title
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_title_custom', array(
				'type' 					=> 'theme_mod',
				'sanitize_callback' 	=> 'sanitize_text_field',
				'default' 				=> 'Shop',
			) );

			$wp_customize->add_control( 'killar_woo_archive_page_title_custom', array(
				'label' 				=> esc_html__( 'Page Title Custom Text', 'killar' ),
				'section' 				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_title_custom',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_woo_archive_page_title_custom',
			) );
			
			/**
			 * Shop / Archive : Page Title Background Image
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_archive_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'custom' 			=> __( 'Custom', 'killar' ),
											'hide' 				=> __( 'Hide', 'killar' ),
										),
			) ) );
			
			/**
			 * Shop / Archive : Background Image
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_title_bg_image', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_woo_archive_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_woo_archive_page_title_background_custom',
			) ) );
			
			/**
			 * Shop / Archive : Breadcrumb
			 */
			$wp_customize->add_setting( 'killar_woo_archive_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_archive_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Shop / Archive : Columns  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_archive_columns_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_archive_columns_heading', array(
				'label'	   				=> __( 'Shop / Archive : Columns', 'killar' ),
				'description'	   		=> __( 'Show numbers of items below list of screen size.', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_columns_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Shop XXL Columns
			 */
			$wp_customize->add_setting( 'killar_woo_loop_products_col_xxl', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_products_col_xxl', array(
				'label'	   				=> __( 'Large devices (larger desktops, 1400px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_products_col_xxl',
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
			 * Shop XL Columns
			 */
			$wp_customize->add_setting( 'killar_woo_loop_products_col_xl', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_products_col_xl', array(
				'label'	   				=> __( 'Large devices (large desktops, 1200px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_products_col_xl',
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
			 * Shop LG Columns
			 */
			$wp_customize->add_setting( 'killar_woo_loop_products_col_lg', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_products_col_lg', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_products_col_lg',
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
			 * Shop MD Columns
			 */
			$wp_customize->add_setting( 'killar_woo_loop_products_col_md', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_products_col_md', array(
				'label'	   				=> __( 'Medium devices (tablets, less than 992px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_products_col_md',
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
			 * Shop SM Columns
			 */
			$wp_customize->add_setting( 'killar_woo_loop_products_col_sm', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_products_col_sm', array(
				'label'	   				=> __( 'Small devices (landscape phones, 576px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_products_col_sm',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
										),
			) ) );

			/**
			 * Shop XS Columns
			 */
			$wp_customize->add_setting( 'killar_woo_loop_products_col_xs', array(
				'default'           	=> '1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_products_col_xs', array(
				'label'	   				=> __( 'Extra small devices (portrait phones, less than 576px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_products_col_xs',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
										),
			) ) );

			/**
			 * Shop / Archive : Toolbar  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_archive_toolbar_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_archive_toolbar_heading', array(
				'label'	   				=> __( 'Toolbar', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_toolbar_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Toolbar : Shop sort
			 */
			$wp_customize->add_setting( 'killar_woo_loop_sort', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_sort', array(
				'label'	   				=> __( 'Shop Sort', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_sort',
				'priority' 				=> 10,
			) ) );

			/**
			 * Toolbar : Result count
			 */
			$wp_customize->add_setting( 'killar_woo_loop_result_count', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_result_count', array(
				'label'	   				=> __( 'Shop Result Count', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_result_count',
				'priority' 				=> 10,
			) ) );


			/**
			 * Products per page
			 */
			$wp_customize->add_setting( 'killar_woo_archive_prods_per_page', array(
				'default'          		=>  12,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_woo_archive_prods_per_page', array(
				'label'   				=> __( 'Products Per Page', 'killar' ),
				'section' 				=> 'killar_woo_archive_gen_section',
				'settings'  			=> 'killar_woo_archive_prods_per_page',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 100,
											'step' => 1,
										),
				'priority' 			=> 10,
			) ) );
			
			/**
			 * Shop / Archive : Pagination Style
			 */
			$wp_customize->add_setting( 'killar_woo_archive_pagination_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_archive_pagination_style', array(
				'label'	   				=> __( 'Pagination Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_archive_pagination_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 			=> __( 'Default', 'killar' ),
					'infinite-scroll' 	=> __( 'Infinite Scroll', 'killar' ),
					'load-more' 		=> __( 'Load More', 'killar' ),
				),
			) ) );
			
			/**
			 * Shop / Archive : Pagination Last Text
			 */
			$wp_customize->add_setting( 'killar_woo_archive_pagination_last_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'End of content',
			) );

			$wp_customize->add_control( 'killar_woo_archive_pagination_last_text', array(
				'label' 			=> esc_html__( 'Pagination Last Text', 'killar' ),
				'section' 			=> 'killar_woo_archive_gen_section',
				'settings' 			=> 'killar_woo_archive_pagination_last_text',
				'priority' 			=> 10,
				'active_callback' 	=> 'ctm_killarwt_woo_loop_pagination_style_not_default',
			) );
			
			/**
			 * Shop / Archive : Load More Button Text
			 */
			$wp_customize->add_setting( 'killar_woo_archive_load_more_button_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'Load More Products',
			) );

			$wp_customize->add_control( 'killar_woo_archive_load_more_button_text', array(
				'label' 			=> esc_html__( 'Load More Button Text', 'killar' ),
				'section' 			=> 'killar_woo_archive_gen_section',
				'settings' 			=> 'killar_woo_archive_load_more_button_text',
				'priority' 			=> 10,
				'active_callback' 	=> 'ctm_killarwt_woo_loop_pagination_style_not_default',
			) );
			
			/**
			 * Archove / Shop : Product Image Heading ====================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_product_image_heading', array(
				'label'	   				=> __( 'Archove / Shop : Image', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Archove / Shop : Product Image Hover Style
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_style', array(
				'default'           	=> 'image-swap',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_loop_product_image_style', array(
				'label'	   				=> __( 'Product Image Style', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'image-swap' 		=> __( 'Image Swape', 'killar' ),
											'image-slider'     => __( 'Image Slider', 'killar' ),
										),
			) ) );
			
			/**
			 * Archove / Shop : Product Image Swap Style
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_swap_style', array(
				'default'           	=> 'swap',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_loop_product_image_swap_style', array(
				'label'	   				=> __( 'Product Image Swap Effect', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_swap_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'swap' 				=> __( 'Fade', 'killar' ),
											'flip' 				=> __( 'Flilp', 'killar' ),
											'vslide'            => __( 'Verticle Slide', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_is_product_image_swap_style',
			) ) );
			
			/**
			 * Archove / Shop : Product Image Slider
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_slider_slides', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_product_image_slider_slides', array(
				'label'	   				=>  __( 'Product Images Slider Nums of Images', 'killar' ),
				'type' 					=> 'number',
				'input_attrs' => array(
									'min' => 1,
									'max' => 5,
									'step' => 1,
									'class' => 'number-class',
									'style' => 'width: 100%;',
									'placeholder' => '',
									'pattern' => '[0-9]+',
								),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_slider_slides',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_product_image_slider_style',
			) ) );
				
			/**
			 * Archove / Shop : Product Image Slider Auto Play
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_slider_autoplay', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_product_image_slider_autoplay', array(
				'label'	   				=> __( 'Product Image Slider Auto Play', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_slider_autoplay',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_product_image_slider_style',
			) ) );
			
			/**
			 * Archove / Shop : Product Image Slider Loop
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_slider_loop', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_product_image_slider_loop', array(
				'label'	   				=> __( 'Product Image Slider Loop', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_slider_loop',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_product_image_slider_style',
			) ) );

			/**
			 * Archove / Shop : Product Image Slider Show Navigation
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_slider_nav', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_product_image_slider_nav', array(
				'label'	   				=> __( 'Product Image Slider Show Navigation', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_slider_nav',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_product_image_slider_style',
			) ) );
			
			/**
			 * Archove / Shop : Product Image Slider Show Dots
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_slider_dots', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_product_image_slider_dots', array(
				'label'	   				=> __( 'Product Image Slider Show Dots Navigation', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_slider_dots',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_product_image_slider_style',
			) ) );

			/**
			 * Archove / Shop : Product Image Lazy Load
			 */
			$wp_customize->add_setting( 'killar_woo_loop_product_image_lazyload', array(
				'default'           	=> 'disable',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_woo_loop_product_image_lazyload', array(
				'label'	   				=> __( 'Lazy Load', 'killar' ),
				'description'	   		=> __( 'Enable Lazy Load for Product Image', 'killar' ),
				'input_attrs' => array(
										'class' => 'yes-no-buttons switch-input screen-reader-text',
									),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_product_image_lazyload',
				'priority' 				=> 10,
				'choices' 				=> array(
											'enable' 				=> __( 'Enable', 'killar' ),
											'disable' 				=> __( 'Disable', 'killar' ),
										),
			) ) );
			
			
			/**
			 * Archove / Shop : Category Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_category_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_prod_category_heading', array(
				'label'	   				=> __( 'Archove / Shop : Category', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_category_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Product Categories
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_categories', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_prod_categories', array(
				'label'	   				=> __( 'Show Product Categories', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_categories',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Category Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_cat_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_cat_color', array(
				'label'   			    => esc_html__( 'Category Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_cat_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Category Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_cat_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_cat_hover_color', array(
				'label'   			    => esc_html__( 'Category Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_cat_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Archove / Shop : Title  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_title_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_prod_title_heading', array(
				'label'	   				=> __( 'Archove / Shop : Title', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Title Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_title_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_title_color', array(
				'label'   			    => esc_html__( 'Title Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_title_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Title Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_title_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_title_hover_color', array(
				'label'   			    => esc_html__( 'Title Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_title_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Archove / Shop : Ratings  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_ratings_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_prod_ratings_heading', array(
				'label'	   				=> __( 'Archove / Shop : Ratings', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_ratings_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop : Product Ratings
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_ratings', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_prod_ratings', array(
				'label'	   				=> __( 'Show Product Ratings', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_ratings',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop : Product Ratings Count
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_ratings_count', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_prod_ratings_count', array(
				'label'	   				=> __( 'Show Product Ratings Count', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_ratings_count',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_product_content_ratings_enable',
			) ) );
			
			/**
			 * Ratings Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_ratings_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_ratings_color', array(
				'label'   			    => esc_html__( 'Ratings Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_ratings_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_is_product_content_ratings_enable',
			) ) );
			
			/**
			 * Ratings Color : Active
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_ratings_active_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_ratings_active_color', array(
				'label'   			    => esc_html__( 'Ratings Color : Active', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_ratings_active_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_is_product_content_ratings_enable',
			) ) );

			/**
			 * Archove / Shop : Description  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_description_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_prod_description_heading', array(
				'label'	   				=> __( 'Archove / Shop : Description', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_description_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop : Product Description
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_description', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_prod_description', array(
				'label'	   				=> __( 'Show Product Description', 'killar' ),
				'description'	   		=> __( 'Short description display only product listing view', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_description',
				'priority' 				=> 10,
			) ) );

			/**
			 * Description Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_description_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_description_color', array(
				'label'   			    => esc_html__( 'Description Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_description_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_is_product_content_description_enable',
			) ) );

			
			/**
			 * Archove / Shop : Price  Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_price_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_prod_price_heading', array(
				'label'	   				=> __( 'Archove / Shop : Price', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_price_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Loop : Product Price
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_price', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_prod_price', array(
				'label'	   				=> __( 'Show Product Price', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_price',
				'priority' 				=> 10,
			) ) );
		
			/**
			 * Loop : Price Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_price_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_price_color', array(
				'label'   			    => esc_html__( 'Price Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_price_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Loop : Price Del Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_price_del_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_price_del_color', array(
				'label'   			    => esc_html__( 'Old Price Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_price_del_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Product Style: Add to Cart Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_heading', array(
				'label'	   				=> __( 'Archove / Shop : Add to Cart Button', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_addtocart_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Product Actions Buttons : Add to Cart
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_prod_addtocart', array(
				'label'	   				=> __( 'Show Add to Cart Button', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_addtocart',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_product_content_action_buttons_enable',
			) ) );
			
			/**
			 * Add to Cart Background Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_bg_color', array(
				'label'   			    => esc_html__( 'Add to Cart Background Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Add to Cart Border Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_border_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_border_color', array(
				'label'   			    => esc_html__( 'Add to Cart Border Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_border_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Add to Cart Text Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_text_color', array(
				'label'   			    => esc_html__( 'Add to Cart Text Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_text_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Add to Cart Background Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_bg_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_bg_hover_color', array(
				'label'   			    => esc_html__( 'Add to Cart Background Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_bg_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Add to Cart Border Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_border_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_border_hover_color', array(
				'label'   			    => esc_html__( 'Add to Cart Border Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_border_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Add to Cart Text Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_text_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_text_hover_color', array(
				'label'   			    => esc_html__( 'Add to Cart Text Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_text_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Add to Cart Background Color : Active
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_bg_active_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_bg_active_color', array(
				'label'   			    => esc_html__( 'Add to Cart Background Color : Active', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_bg_active_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Add to Cart Border Color : Active
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_border_active_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_border_active_color', array(
				'label'   			    => esc_html__( 'Add to Cart Border Color : Active', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_border_active_color',
				'priority'              => 10,
			) ) );

			/**
			 * Add to Cart Text Color : Active
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_addtocart_text_active_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_addtocart_text_active_color', array(
				'label'   			    => esc_html__( 'Add to Cart Text Color : Active', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_addtocart_text_active_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Product Style: Quickview Button Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_prods_quickview_btn_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_prod_prods_quickview_btn_heading', array(
				'label'	   				=> __( 'Archove / Shop : Quickview Button', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_prods_quickview_btn_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Product Quickview
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_quickview', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_prod_quickview', array(
				'label'	   				=> __( 'Show Quickview', 'killar' ),
				'section'  				=> 'killar_woo_archive_gen_section',
				'settings' 				=> 'killar_woo_loop_prod_quickview',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Quickview Background Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_quickview_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_quickview_bg_color', array(
				'label'   			    => esc_html__( 'Quickview Background Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_quickview_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_loop_prod_quickview_enable',
			) ) );
			
			/**
			 * Quickview Border Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_quickview_border_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_quickview_border_color', array(
				'label'   			    => esc_html__( 'Quickview Border Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_quickview_border_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_loop_prod_quickview_enable',
			) ) );
			
			/**
			 * Quickview Text Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_quickview_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_quickview_text_color', array(
				'label'   			    => esc_html__( 'Quickview Text Color', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_quickview_text_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_loop_prod_quickview_enable',
			) ) );
			
			/**
			 * Quickview Background Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_quickview_bg_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_quickview_bg_hover_color', array(
				'label'   			    => esc_html__( 'Quickview Background Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_quickview_bg_hover_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_loop_prod_quickview_enable',
			) ) );
			
			/**
			 * Quickview Border Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_quickview_border_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_quickview_border_hover_color', array(
				'label'   			    => esc_html__( 'Quickview Border Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_quickview_border_hover_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_loop_prod_quickview_enable',
			) ) );
			
			/**
			 * Quickview Text Color : Hover
			 */
			$wp_customize->add_setting( 'killar_woo_loop_prod_quickview_text_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_prod_quickview_text_hover_color', array(
				'label'   			    => esc_html__( 'Quickview Text Color : Hover', 'killar' ),
				'section'  			    => 'killar_woo_archive_gen_section',
				'settings' 			    => 'killar_woo_loop_prod_quickview_text_hover_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_loop_prod_quickview_enable',
			) ) );
			
			/**
			 * Labels/Badges Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_woo_loop_badges_section' , array(
				'title' 			=> __( 'Badges / Labels', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_woocommerce_panel',
			) );
			
			/**
			 * Product Labels/Badge
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_status', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_badges_status', array(
				'label'	   				=> __( 'Show Product Badges / Labels ', 'killar' ),
				'description'	   		=> __( 'Show Badges like Sale, Fatured, Out of Stock etc.', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_status',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * New Badge Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_new_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_badges_new_heading', array(
				'label'	   				=> __( 'New Badge', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_new_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Product badge : New
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_new', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_badges_new', array(
				'label'	   				=> __( 'Show Badge New', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_new',
				'priority' 				=> 10,
				'active_callback' 		=> 'killarwt_woo_general_badges_enable',
			) ) );

			/**
			 * Product badge : New Badge Text
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_new_text', array(
				'default'           	=> 'New',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( 'killar_woo_loop_badges_new_text', array(
				'label' 			=> esc_html__( 'New Label Text', 'killar' ),
				'section' 			=> 'killar_woo_loop_badges_section',
				'settings' 			=> 'killar_woo_loop_badges_new_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_new_enable',
			) );
			
			/**
			 * Product badge : New Badge Limit
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_new_limit', array(
				'default'           	=> '30',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( 'killar_woo_loop_badges_new_limit', array(
				'label' 			=> esc_html__( 'Newness Product Day(s)', 'killar' ),
				'description' 		=> esc_html__( 'You can add numbers of days want to display New badge', 'killar' ),
				'section' 			=> 'killar_woo_loop_badges_section',
				'settings' 			=> 'killar_woo_loop_badges_new_limit',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_new_enable',
			) );
			
			/**
			 * Product badge : New Badge Background Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_new_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_new_bg_color', array(
				'label'   			    => esc_html__( 'New Badge Background Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_new_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_new_enable',
			) ) );
			
			/**
			 * Product badge : New Badge Text Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_new_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_new_text_color', array(
				'label'   			    => esc_html__( 'New Badge Text Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_new_text_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_new_enable',
			) ) );
			
			/**
			 * Sale Badge Heading ================================
			 */
			 
			$wp_customize->add_setting( 'killar_woo_loop_badges_sale_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_badges_sale_heading', array(
				'label'	   				=> __( 'Sale Badge', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_sale_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Product badge : Sale
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_sale', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_badges_sale', array(
				'label'	   				=> __( 'Show Badge Sale', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_sale',
				'priority' 				=> 10,
				'active_callback' 		=> 'killarwt_woo_general_badges_enable',
			) ) );
			
			/**
			 * Product badge : Sale Type
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_sale_type', array(
				'default'           	=> 'text',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_woo_loop_badges_sale_type', array(
				'label'	   				=> __( 'Sale Badge Type', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_sale_type',
				'priority' 				=> 10,
				'choices' 				=> array(
											'text' 				=> __( 'Sale Text', 'killar' ),
											'percentage' 		=> __( 'Percentage', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_woo_general_badges_sale_enable',
			) ) );
			
			/**
			 * Product badge : Sale Badge Text
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_sale_text', array(
				'default'           	=> 'Sale',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( 'killar_woo_loop_badges_sale_text', array(
				'label' 			=> esc_html__( 'Sale Label Text', 'killar' ),
				'section' 			=> 'killar_woo_loop_badges_section',
				'settings' 			=> 'killar_woo_loop_badges_sale_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_sale_enable',
			) );
			
			/**
			 * Product badge : Sale Badge Percentage Text
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_sale_percentage_text', array(
				'default'           	=> '-{percentage}',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( 'killar_woo_loop_badges_sale_percentage_text', array(
				'label' 			=> esc_html__( 'Sale Percentage Text', 'killar' ),
				'description' 		=> esc_html__( 'Display sale percentage text like 10% off, "{percentage}" is dynamic value.', 'killar' ),
				'section' 			=> 'killar_woo_loop_badges_section',
				'settings' 			=> 'killar_woo_loop_badges_sale_percentage_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_sale_enable',
			) );
			
			/**
			 * Product badge : Sale Badge Background Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_sale_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_sale_bg_color', array(
				'label'   			    => esc_html__( 'Sale Badge Background Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_sale_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_sale_enable',
			) ) );
			
			/**
			 * Product badge : Sale Badge Text Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_sale_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_sale_text_color', array(
				'label'   			    => esc_html__( 'Sale Badge Text Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_sale_text_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_sale_enable',
			) ) );
			
			/**
			 * Featured Badge Heading ================================
			 */
			 
			$wp_customize->add_setting( 'killar_woo_loop_badges_featured_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_badges_featured_heading', array(
				'label'	   				=> __( 'Featured Badge', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_featured_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Product badge : Featured
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_featured', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_badges_featured', array(
				'label'	   				=> __( 'Show Badge Featured', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_featured',
				'priority' 				=> 10,
				'active_callback' 		=> 'killarwt_woo_general_badges_enable',
			) ) );
			
			/**
			 * Product badge : Featured Badge Text
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_featured_text', array(
				'default'           	=> 'Hot',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( 'killar_woo_loop_badges_featured_text', array(
				'label' 			=> esc_html__( 'Featured Label Text', 'killar' ),
				'section' 			=> 'killar_woo_loop_badges_section',
				'settings' 			=> 'killar_woo_loop_badges_featured_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_featured_enable',
			) );
			
			/**
			 * Product badge : Featured Badge Background Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_featured_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_featured_bg_color', array(
				'label'   			    => esc_html__( 'Featured Badge Background Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_featured_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_featured_enable',
			) ) );
			
			/**
			 * Product badge : Featured Badge Text Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_featured_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_featured_text_color', array(
				'label'   			    => esc_html__( 'Featured Badge Text Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_featured_text_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_featured_enable',
			) ) );
			
			/**
			 * Out of Stock Badge Heading ================================
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_outofstock_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_woo_loop_badges_outofstock_heading', array(
				'label'	   				=> __( 'Out of Stock Badge', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_outofstock_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Product badge : Out of Stock
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_outofstock', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_woo_loop_badges_outofstock', array(
				'label'	   				=> __( 'Show Badge Out of Stock', 'killar' ),
				'section'  				=> 'killar_woo_loop_badges_section',
				'settings' 				=> 'killar_woo_loop_badges_outofstock',
				'priority' 				=> 10,
				'active_callback' 		=> 'killarwt_woo_general_badges_enable',
			) ) );
			
			/**
			 * Product badge : OutofStock Badge Text
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_outofstock_text', array(
				'default'           	=> 'Sold Out',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( 'killar_woo_loop_badges_outofstock_text', array(
				'label' 			=> esc_html__( 'OutofStock Label Text', 'killar' ),
				'section' 			=> 'killar_woo_loop_badges_section',
				'settings' 			=> 'killar_woo_loop_badges_outofstock_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_outofstock_enable',
			) );
			
			/**
			 * Product badge : OutofStock Badge Background Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_outofstock_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_outofstock_bg_color', array(
				'label'   			    => esc_html__( 'OutofStock Badge Background Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_outofstock_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_outofstock_enable',
			) ) );
			
			/**
			 * Product badge : OutofStock Badge Text Color
			 */
			$wp_customize->add_setting( 'killar_woo_loop_badges_outofstock_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'sanitize_hex_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'killar_woo_loop_badges_outofstock_text_color', array(
				'label'   			    => esc_html__( 'OutofStock Badge Text Color', 'killar' ),
				'section'  			    => 'killar_woo_loop_badges_section',
				'settings' 			    => 'killar_woo_loop_badges_outofstock_text_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_woo_general_badges_outofstock_enable',
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function add_customizer_css( $output ) {
			
			//New Badge
			$killar_woo_loop_badges_new_bg_color							= get_theme_mod( 'killar_woo_loop_badges_new_bg_color', '' );
			$killar_woo_loop_badges_new_text_color							= get_theme_mod( 'killar_woo_loop_badges_new_text_color', '' );
			$killar_woo_loop_badges_sale_bg_color							= get_theme_mod( 'killar_woo_loop_badges_sale_bg_color', '' );
			$killar_woo_loop_badges_sale_text_color							= get_theme_mod( 'killar_woo_loop_badges_sale_text_color', '' );
			$killar_woo_loop_badges_featured_bg_color						= get_theme_mod( 'killar_woo_loop_badges_featured_bg_color', '' );
			$killar_woo_loop_badges_featured_text_color						= get_theme_mod( 'killar_woo_loop_badges_featured_text_color', '' );
			$killar_woo_loop_badges_outofstock_bg_color						= get_theme_mod( 'killar_woo_loop_badges_outofstock_bg_color', '' );
			$killar_woo_loop_badges_outofstock_text_color					= get_theme_mod( 'killar_woo_loop_badges_outofstock_text_color', '' );
		
			/**
			* Shop / Archive : New Badge
			*/
			$output .= killarwt_output_css( array( 'span.badge.onnew' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_new_bg_color, '' ) ) ? $killar_woo_loop_badges_new_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_new_text_color, '' ) ) ? $killar_woo_loop_badges_new_text_color : '',
			) ) );

			/**
			* Shop / Archive : Sale Badge
			*/
			$output .= killarwt_output_css( array( 'span.badge.onsale' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_sale_bg_color, '' ) ) ? $killar_woo_loop_badges_sale_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_sale_text_color, '' ) ) ? $killar_woo_loop_badges_sale_text_color : '',
			) ) );
			
			/**
			* Shop / Archive : Featured Badge
			*/
			$output .= killarwt_output_css( array( 'span.badge.onfeatured' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_featured_bg_color, '' ) ) ? $killar_woo_loop_badges_featured_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_featured_text_color, '' ) ) ? $killar_woo_loop_badges_featured_text_color : '',
			) ) );

			/**
			* Shop / Archive : Outofstock Badge
			*/
			$output .= killarwt_output_css( array( 'span.badge.outofstock' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_outofstock_bg_color, '' ) ) ? $killar_woo_loop_badges_outofstock_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_badges_outofstock_text_color, '' ) ) ? $killar_woo_loop_badges_outofstock_text_color : '',
			) ) );
		
			
			
			//Product Styles
			$killar_woo_loop_prod_bg_color									= get_theme_mod( 'killar_woo_loop_prod_bg_color', '' );
			$killar_woo_loop_prod_cat_color									= get_theme_mod( 'killar_woo_loop_prod_cat_color', '' );
			$killar_woo_loop_prod_cat_hover_color							= get_theme_mod( 'killar_woo_loop_prod_cat_hover_color', '' );
			$killar_woo_loop_prod_title_color								= get_theme_mod( 'killar_woo_loop_prod_title_color', '' );
			$killar_woo_loop_prod_title_hover_color							= get_theme_mod( 'killar_woo_loop_prod_title_hover_color', '' );
			$killar_woo_loop_prod_ratings_color								= get_theme_mod( 'killar_woo_loop_prod_ratings_color', '' );
			$killar_woo_loop_prod_ratings_active_color						= get_theme_mod( 'killar_woo_loop_prod_ratings_active_color', '' );
			$killar_woo_loop_prod_description_color							= get_theme_mod( 'killar_woo_loop_prod_description_color', '' );
			$killar_woo_loop_prod_price_color								= get_theme_mod( 'killar_woo_loop_prod_price_color', '' );
			$killar_woo_loop_prod_price_del_color							= get_theme_mod( 'killar_woo_loop_prod_price_del_color', '' );
			$killar_woo_loop_prod_addtocart_bg_color						= get_theme_mod( 'killar_woo_loop_prod_addtocart_bg_color', '' );
			$killar_woo_loop_prod_addtocart_border_color					= get_theme_mod( 'killar_woo_loop_prod_addtocart_border_color', '' );
			$killar_woo_loop_prod_addtocart_text_color						= get_theme_mod( 'killar_woo_loop_prod_addtocart_text_color', '' );
			$killar_woo_loop_prod_addtocart_bg_hover_color					= get_theme_mod( 'killar_woo_loop_prod_addtocart_bg_hover_color', '' );
			$killar_woo_loop_prod_addtocart_border_hover_color				= get_theme_mod( 'killar_woo_loop_prod_addtocart_border_hover_color', '' );
			$killar_woo_loop_prod_addtocart_text_hover_color				= get_theme_mod( 'killar_woo_loop_prod_addtocart_text_hover_color', '' );
			$killar_woo_loop_prod_addtocart_bg_active_color					= get_theme_mod( 'killar_woo_loop_prod_addtocart_bg_active_color', '' );
			$killar_woo_loop_prod_addtocart_border_active_color				= get_theme_mod( 'killar_woo_loop_prod_addtocart_border_active_color', '' );
			$killar_woo_loop_prod_addtocart_text_active_color				= get_theme_mod( 'killar_woo_loop_prod_addtocart_text_active_color', '' );
			$killar_woo_loop_prod_wishlist_bg_color							= get_theme_mod( 'killar_woo_loop_prod_wishlist_bg_color', '' );
			$killar_woo_loop_prod_wishlist_border_color						= get_theme_mod( 'killar_woo_loop_prod_wishlist_border_color', '' );
			$killar_woo_loop_prod_wishlist_text_color						= get_theme_mod( 'killar_woo_loop_prod_wishlist_text_color', '' );
			$killar_woo_loop_prod_wishlist_bg_hover_color					= get_theme_mod( 'killar_woo_loop_prod_wishlist_bg_hover_color', '' );
			$killar_woo_loop_prod_wishlist_border_hover_color				= get_theme_mod( 'killar_woo_loop_prod_wishlist_border_hover_color', '' );
			$killar_woo_loop_prod_wishlist_text_hover_color					= get_theme_mod( 'killar_woo_loop_prod_wishlist_text_hover_color', '' );
			$killar_woo_loop_prod_wishlist_bg_active_color					= get_theme_mod( 'killar_woo_loop_prod_wishlist_bg_active_color', '' );
			$killar_woo_loop_prod_wishlist_border_active_color				= get_theme_mod( 'killar_woo_loop_prod_wishlist_border_active_color', '' );
			$killar_woo_loop_prod_wishlist_text_active_color				= get_theme_mod( 'killar_woo_loop_prod_wishlist_text_active_color', '' );
			$killar_woo_loop_prod_compare_bg_color							= get_theme_mod( 'killar_woo_loop_prod_compare_bg_color', '' );
			$killar_woo_loop_prod_compare_border_color						= get_theme_mod( 'killar_woo_loop_prod_compare_border_color', '' );
			$killar_woo_loop_prod_compare_text_color						= get_theme_mod( 'killar_woo_loop_prod_compare_text_color', '' );
			$killar_woo_loop_prod_compare_bg_hover_color					= get_theme_mod( 'killar_woo_loop_prod_compare_bg_hover_color', '' );
			$killar_woo_loop_prod_compare_border_hover_color				= get_theme_mod( 'killar_woo_loop_prod_compare_border_hover_color', '' );
			$killar_woo_loop_prod_compare_text_hover_color					= get_theme_mod( 'killar_woo_loop_prod_compare_text_hover_color', '' );
			$killar_woo_loop_prod_compare_bg_active_color					= get_theme_mod( 'killar_woo_loop_prod_compare_bg_active_color', '' );
			$killar_woo_loop_prod_compare_border_active_color				= get_theme_mod( 'killar_woo_loop_prod_compare_border_active_color', '' );
			$killar_woo_loop_prod_compare_text_active_color					= get_theme_mod( 'killar_woo_loop_prod_compare_text_active_color', '' );
			$killar_woo_loop_prod_quickview_bg_color						= get_theme_mod( 'killar_woo_loop_prod_quickview_bg_color', '' );
			$killar_woo_loop_prod_quickview_border_color					= get_theme_mod( 'killar_woo_loop_prod_quickview_border_color', '' );
			$killar_woo_loop_prod_quickview_text_color						= get_theme_mod( 'killar_woo_loop_prod_quickview_text_color', '' );
			$killar_woo_loop_prod_quickview_bg_hover_color					= get_theme_mod( 'killar_woo_loop_prod_quickview_bg_hover_color', '' );
			$killar_woo_loop_prod_quickview_border_hover_color				= get_theme_mod( 'killar_woo_loop_prod_quickview_border_hover_color', '' );
			$killar_woo_loop_prod_quickview_text_hover_color				= get_theme_mod( 'killar_woo_loop_prod_quickview_text_hover_color', '' );
			$killar_woo_loop_prod_quickview_bg_active_color					= get_theme_mod( 'killar_woo_loop_prod_quickview_bg_active_color', '' );
			$killar_woo_loop_prod_quickview_border_active_color				= get_theme_mod( 'killar_woo_loop_prod_quickview_border_active_color', '' );
			$killar_woo_loop_prod_quickview_text_active_color				= get_theme_mod( 'killar_woo_loop_prod_quickview_text_active_color', '' );
			
			/**
			* Loop : Product Color
			*/
			$output .= killarwt_output_css( array( '.product .product-wrap' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_bg_color, '' ) ) ? $killar_woo_loop_prod_bg_color : '',
			) ) );

			/**
			* Loop : Product Category Color
			*/
			$output .= killarwt_output_css( array( '.product .product-cats a' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_cat_color, '' ) ) ? $killar_woo_loop_prod_cat_color : '',
			) ) );

			/**
			* Loop : Product Category Hover Color
			*/
			$output .= killarwt_output_css( array( '.product .product-cats a:hover' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_cat_hover_color, '' ) ) ? $killar_woo_loop_prod_cat_hover_color : '',
			) ) );

			/**
			* Loop : Product Name Color
			*/
			$output .= killarwt_output_css( array( '.product .product-name > a' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_title_color, '' ) ) ? $killar_woo_loop_prod_title_color : '',
			) ) );

			/**
			* Loop : Product Name Hover Color
			*/
			$output .= killarwt_output_css( array( '.product .product-name > a:hover' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_title_hover_color, '' ) ) ? $killar_woo_loop_prod_title_hover_color : '',
			) ) );
			
			/**
			* Loop : Product Rating Color
			*/
			$output .= killarwt_output_css( array( '.product .rating-box:before' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_ratings_color, '' ) ) ? $killar_woo_loop_prod_ratings_color : '',
			) ) );
			
			/**
			* Loop : Product Rating Active Color
			*/
			$output .= killarwt_output_css( array( '.product .rating-box .rating:before' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_ratings_active_color, '' ) ) ? $killar_woo_loop_prod_ratings_active_color : '',
			) ) );

			/**
			* Loop : Product Description Color
			*/
			$output .= killarwt_output_css( array( '.product .product-desc' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_description_color, '' ) ) ? $killar_woo_loop_prod_description_color : '',
			) ) );
	
			/**
			* Loop : Product Price Color
			*/
			$output .= killarwt_output_css( array( '.product .product-price .price' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_woo_loop_prod_price_color, '' ) ) ? $killar_woo_loop_prod_price_color : '',
			) ) );

			/**
			* Loop : Product Price Dele Color
			*/
			$output .= killarwt_output_css( array( '.product .product-price .price del' => array(
				'color' => ( !empty( $killar_woo_loop_prod_price_del_color ) ) ? $killar_woo_loop_prod_price_del_color : '',
			) ) );
			
			/**
			* Loop : Product AddtoCart
			*/
			$output .= killarwt_output_css( array( '.product-actions .add_to_cart_button' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_addtocart_bg_color ) ) ? $killar_woo_loop_prod_addtocart_bg_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_addtocart_border_color ) ) ? $killar_woo_loop_prod_addtocart_border_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_addtocart_text_color ) ) ? $killar_woo_loop_prod_addtocart_text_color : '',
			) ) );

			/**
			* Loop : Product AddtoCart Hover
			*/
			$output .= killarwt_output_css( array( '.product-actions .add_to_cart_button:hover' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_addtocart_bg_hover_color ) ) ? $killar_woo_loop_prod_addtocart_bg_hover_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_addtocart_border_hover_color ) ) ? $killar_woo_loop_prod_addtocart_border_hover_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_addtocart_text_hover_color ) ) ? $killar_woo_loop_prod_addtocart_text_hover_color : '',
			) ) );

			/**
			* Loop : Product AddtoCart Active
			*/
			$output .= killarwt_output_css( array( '.product-actions .add_to_cart_button.added' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_addtocart_bg_active_color ) ) ? $killar_woo_loop_prod_addtocart_bg_active_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_addtocart_border_active_color ) ) ? $killar_woo_loop_prod_addtocart_border_active_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_addtocart_text_active_color ) ) ? $killar_woo_loop_prod_addtocart_text_active_color : '',
			) ) );
			
			if ( killarwt_woo_loop_product_style() == 'mprod-s3' ) {
				
				/**
				* Loop : Product Wishlist Hover
				*/
				$output .= killarwt_output_css( array( '.mprod-s3 .product-actions .add_to_wishlist:hover' => array(
					'color' => ( !empty( $killar_woo_loop_prod_wishlist_text_hover_color ) ) ? $killar_woo_loop_prod_wishlist_text_hover_color : '',
				) ) );
				
				/**
				* Loop : Product Wishlist Active
				*/
				$output .= killarwt_output_css( array( '.mprod-s3 .product-actions .yith-wcwl-wishlistaddedbrowse > a, .mprod-s3 .product-actions .yith-wcwl-wishlistexistsbrowse > a' => array(
					'color' => ( !empty( $killar_woo_loop_prod_wishlist_text_active_color ) ) ? $killar_woo_loop_prod_wishlist_text_active_color : '',
				) ) );
				
			} else {
				
				/**
				* Loop : Product Wishlist
				*/
				$output .= killarwt_output_css( array( '.product-actions .add_to_wishlist' => array(
					'background-color' => ( !empty( $killar_woo_loop_prod_wishlist_bg_color ) ) ? $killar_woo_loop_prod_wishlist_bg_color : '',
					'border-color' => ( !empty( $killar_woo_loop_prod_wishlist_border_color ) ) ? $killar_woo_loop_prod_wishlist_border_color : '',
					'color' => ( !empty( $killar_woo_loop_prod_wishlist_text_color ) ) ? $killar_woo_loop_prod_wishlist_text_color : '',
				) ) );

				/**
				* Loop : Product Wishlist Hover
				*/
				$output .= killarwt_output_css( array( '.product-actions .add_to_wishlist:hover' => array(
					'background-color' => ( !empty( $killar_woo_loop_prod_wishlist_bg_hover_color ) ) ? $killar_woo_loop_prod_wishlist_bg_hover_color : '',
					'border-color' => ( !empty( $killar_woo_loop_prod_wishlist_border_hover_color ) ) ? $killar_woo_loop_prod_wishlist_border_hover_color : '',
					'color' => ( !empty( $killar_woo_loop_prod_wishlist_text_hover_color ) ) ? $killar_woo_loop_prod_wishlist_text_hover_color : '',
				) ) );

				/**
				* Loop : Product Wishlist Active
				*/
				$output .= killarwt_output_css( array( '.product-actions .yith-wcwl-wishlistexistsbrowse > a, .product-actions .yith-wcwl-wishlistaddedbrowse > a' => array(
					'background-color' => ( !empty( $killar_woo_loop_prod_wishlist_bg_active_color ) ) ? $killar_woo_loop_prod_wishlist_bg_active_color : '',
					'border-color' => ( !empty( $killar_woo_loop_prod_wishlist_border_active_color ) ) ? $killar_woo_loop_prod_wishlist_border_active_color : '',
					'color' => ( !empty( $killar_woo_loop_prod_wishlist_text_active_color ) ) ? $killar_woo_loop_prod_wishlist_text_active_color : '',
				) ) );
				
			}

			/**
			* Loop : Product Compare
			*/
			$output .= killarwt_output_css( array( '.product-actions .compare' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_compare_bg_color ) ) ? $killar_woo_loop_prod_compare_bg_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_compare_border_color ) ) ? $killar_woo_loop_prod_compare_border_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_compare_text_color ) ) ? $killar_woo_loop_prod_compare_text_color : '',
			) ) );

			/**
			* Loop : Product Compare Hover
			*/
			$output .= killarwt_output_css( array( '.product-actions .compare:hover' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_compare_bg_hover_color ) ) ? $killar_woo_loop_prod_compare_bg_hover_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_compare_border_hover_color ) ) ? $killar_woo_loop_prod_compare_border_hover_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_compare_text_hover_color ) ) ? $killar_woo_loop_prod_compare_text_hover_color : '',
			) ) );
			
			/**
			* Loop : Product Compare Added
			*/
			$output .= killarwt_output_css( array( '.product-actions .compare.added' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_compare_bg_active_color ) ) ? $killar_woo_loop_prod_compare_bg_active_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_compare_border_active_color ) ) ? $killar_woo_loop_prod_compare_border_active_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_compare_text_active_color ) ) ? $killar_woo_loop_prod_compare_text_active_color : '',
			) ) );
			
			/**
			* Loop : Product Quickview
			*/
			$output .= killarwt_output_css( array( '.product-actions .quickview-button' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_quickview_bg_color ) ) ? $killar_woo_loop_prod_quickview_bg_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_quickview_border_color ) ) ? $killar_woo_loop_prod_quickview_border_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_quickview_text_color ) ) ? $killar_woo_loop_prod_quickview_text_color : '',
			) ) );

			/**
			* Loop : Product Quickview Hover
			*/
			$output .= killarwt_output_css( array( '.product-actions .quickview-button:hover' => array(
				'background-color' => ( !empty( $killar_woo_loop_prod_quickview_bg_hover_color ) ) ? $killar_woo_loop_prod_quickview_bg_hover_color : '',
				'border-color' => ( !empty( $killar_woo_loop_prod_quickview_border_hover_color ) ) ? $killar_woo_loop_prod_quickview_border_hover_color : '',
				'color' => ( !empty( $killar_woo_loop_prod_quickview_text_hover_color ) ) ? $killar_woo_loop_prod_quickview_text_hover_color : '',
			) ) );

			// Return output css
			return $output;

		}

		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					wp.customize.section( 'killar_woo_archive_gen_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( '<?php echo esc_js( wc_get_page_permalink( 'shop' ) ); ?>' );
							}
						} );
					} );
				} );
			</script>
			<?php
		}

	}

endif;

return new KillarWT_WooCommerce_Customizer();