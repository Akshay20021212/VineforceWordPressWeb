<?php
/**
 * Portfolio Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Portfolio_Customizer' ) ) :

	class KillarWT_Portfolio_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_customizer_scripts' ), 30 );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {
			
			/**
			 * Portfolio Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_portfolio_panel',  array(
				'title' 			=> __( 'Portfolio', 'killar' ),
				'priority' 			=> '-2500',
				'panel' 			=> 'killar_options_panel',
			) ) );
			
			/**
			 * Portfolio / Archive Section
			 */
			$wp_customize->add_section( 'killar_portfolio_loop_post_section' , array(
				'title' 			=> __( 'Portfolio / Archive', 'killar' ),
				'priority' 			=> 110,
				'panel' 			=> 'killar_portfolio_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_portfolio_loop_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'killar' ),
				'choices' 				=> array(
											'full-width'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sidebar
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_sidebar', array(
				'default'        	    => 'portfolio-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'killar' ),
				'description'	   		=> __( 'Choose sidebar for display on the Portfolio / Archive page.', 'killar' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_killar_get_registered_sidebars(),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Portfolio View : Grid
			 */


			// $wp_customize->add_setting( 'killar_portfolio_loop_view_type', array(
			// 	'default'           	=> 'Grid-1',
			// 	'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			// ) );

			// $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_view_type', array(
			// 	'label'	   				=> __( 'Grid Style', 'killar' ),
			// 	'description'	   		=> __( 'Choose Grid Style for display on the Portfolio / Archive page.', 'killar' ),
			// 	'type' 					=> 'select',
			// 	'choices' 				=>  array(
			// 		'gallery-filter-1' 	=> __( 'Grid-1', 'killar' ),
			// 		'gallery-filter' 	=> __( 'Grid-2', 'killar' ),
			// 								),
			// 	'section'  				=> 'killar_portfolio_loop_post_section',
			// 	'settings' 				=> 'killar_portfolio_loop_view_type',
			// 	'priority' 				=> 10,
			// ) ) );




			$wp_customize->add_setting( 'killar_portfolio_loop_view_type', array(
				'default'           	=> 'grid-light',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_loop_view_type', array(
				'label'	   				=> __( 'Portfolio View', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_view_type',
				'priority' 				=> 10,
				'choices' 				=> array(
											'gallery-filter-light' 			=> __( 'Gallery Filter - Light', 'killar' ),
											'gallery-filter-dark' 			=> __( 'Gallery Filter - Dark', 'killar' ),
											'grid-light' 					=> __( 'Grid - Light', 'killar' ),
											'grid-dark' 					=> __( 'Grid - Dark', 'killar' ),
											'list-light' 					=> __( 'List - Light', 'killar' ),
											'list-dark' 					=> __( 'List - Dark', 'killar' ),
										),
			) ) );



			// /**
			//  * Loop Post : Portfolio View : List
			//  */


			//  $wp_customize->add_setting( 'killar_portfolio_loop_view_type_list', array(
			// 	'default'           	=> 'List-1',
			// 	'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			// ) );

			// $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_view_type_list', array(
			// 	'label'	   				=> __( 'List Style', 'killar' ),
			// 	'description'	   		=> __( 'Choose List Style for display on the Portfolio / Archive page.', 'killar' ),
			// 	'type' 					=> 'select',
			// 	'choices' 				=>  array(
			// 				'list-1' 	=> __( 'List-1', 'killar' ),
			// 				'list-2' 	=> __( 'List-2', 'killar' ),
			// 								),
			// 	'section'  				=> 'killar_portfolio_loop_post_section',
			// 	'settings' 				=> 'killar_portfolio_loop_view_type_list',
			// 	'priority' 				=> 10,
			// ) ) );

			
			/**
			 * Loop Post : Post Style
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_loop_post_style', array(
				'label'	   				=> __( 'Post Style', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'box1' 				=> __( 'Box Style - 1', 'killar' ),
											'box2' 				=> __( 'Box Style - 2', 'killar' ),
											'box3' 				=> __( 'Box Style - 3', 'killar' ),
										),
			) ) );

			/**
			 * Loop Post : Section Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_section_show_title', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_portfolio_loop_post_section_show_title', array(
				'label'	   				=> __( 'Show Section Title', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_section_show_title',
				'priority' 				=> 10,
			) ) );

			/**
			 * Loop Portfolio : Sub Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_section_sub_title', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Our Portfolio',
			) );

			$wp_customize->add_control( 'killar_portfolio_loop_post_section_sub_title', array(
				'label' 			=> esc_html__( 'Sub Title', 'killar' ),
				'section' 			=> 'killar_portfolio_loop_post_section',
				'settings' 			=> 'killar_portfolio_loop_post_section_sub_title',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_post_section_show_title',
			) );

			/**
			 * Loop Portfolio : Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_section_title', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Our Case Studies',
			) );

			$wp_customize->add_control( 'killar_portfolio_loop_post_section_title', array(
				'label' 			=> esc_html__( 'Title', 'killar' ),
				'section' 			=> 'killar_portfolio_loop_post_section',
				'settings' 			=> 'killar_portfolio_loop_post_section_title',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_post_section_show_title',
			) );
			
			/**
			 * Loop Post : Columns Heading ================================
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_columns_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_portfolio_loop_columns_heading', array(
				'label'	   				=> __( 'Portfolio Columns', 'killar' ),
				'description'	   		=> __( 'Show numbers of items below list of screen size. Portfolio columns settings apply only grid and slider.', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_columns_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : XXL Columns
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_items_col_xxl', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_items_col_xxl', array(
				'label'	   				=> __( 'Large devices (larger desktops, 1400px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_items_col_xxl',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : XL Columns
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_items_col_xl', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_items_col_xl', array(
				'label'	   				=> __( 'Large devices (large desktops, 1200px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_items_col_xl',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : LG Columns
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_items_col_lg', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_items_col_lg', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_items_col_lg',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : MD Columns
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_items_col_md', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_items_col_md', array(
				'label'	   				=> __( 'Medium devices (tablets, less than 992px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_items_col_md',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : SM Columns
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_items_col_sm', array(
				'default'           	=> '1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_items_col_sm', array(
				'label'	   				=> __( 'Small devices (landscape phones, 576px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_items_col_sm',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : XS Columns
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_items_col_xs', array(
				'default'           	=> '1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_items_col_xs', array(
				'label'	   				=> __( 'Extra small devices (portrait phones, less than 576px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_items_col_xs',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_portfolio_loop_view_type_is_grid',
			) ) );
			
			/**
			 * Loop Post : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_title_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_portfolio_loop_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Section
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_portfolio_loop_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_title_alignment', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_loop_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_title_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 		=> __( 'Default', 'killar' ),
											'left' 			=> __( 'Left', 'killar' ),
											'centered' 		=> __( 'Center', 'killar' ),
											'right' 		=> __( 'Right', 'killar' ),
										),
			) ) );
			
			/**
			 * Loop Post : Page Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_loop_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'killar' ),
											'custom' 			=> __( 'Custom Text', 'killar' ),
											'post_title' 		=> __( 'Post Title', 'killar' ),
										),
			) ) );
			
			/**
			 * Loop Post : Page Custom Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_title_custom', array(
				'type' 					=> 'theme_mod',
				'sanitize_callback' 	=> 'sanitize_text_field',
				'default' 				=> 'Portfolio',
			) );

			$wp_customize->add_control( 'killar_portfolio_loop_post_page_title_custom', array(
				'label' 				=> esc_html__( 'Page Title Custom Text', 'killar' ),
				'section' 				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_title_custom',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_post_page_title',
			) );
			
			/**
			 * Loop Post : Page Title Background Image
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_loop_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'custom' 			=> __( 'Custom', 'killar' ),
											'hide' 				=> __( 'Hide', 'killar' ),
										),
			) ) );
			
			/**
			 * Loop Post : Background Image
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_title_bg_image', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_portfolio_loop_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_post_page_title_background',
			) ) );
			
			/**
			 * Loop Post : Breadcrumb
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_portfolio_loop_post_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_page_content_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_portfolio_loop_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_sections_positioning', array(
				'default'        	    => apply_filters( 'killar_portfolio_loop_post_sections_positioning_default', array( 'thumbnail', 'categories', 'title', 'content', 'social_links', 'meta', 'read-more' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_portfolio_loop_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'killar' ),
				'description' 			=>  esc_html__( 'Section positioning working only default post style view.', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_portfolio_loop_post_meta_choices',
												array(
													'thumbnail'     => esc_html__( 'Thumbnail', 'killar' ),
													'categories'    => esc_html__( 'Categories', 'killar' ),
													'title'    		=> esc_html__( 'Title', 'killar' ),
													'content'    	=> esc_html__( 'Content', 'killar' ),
													'social-links'  => esc_html__( 'Social Links', 'killar' ),
													'meta'    		=> esc_html__( 'Meta', 'killar' ),
													'read-more'  	=> esc_html__( 'Read More', 'killar' ),
												)
											),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Post Content
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_content', array(
				'default'           	=> 'excerpt',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_loop_post_content', array(
				'label'	   				=> __( 'Post Content', 'killar' ),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'killar' ),
											'full' 				=> __( 'Full', 'killar' ),
										),
			) ) );
			
			/**
			 * Loop Post : Excerpt Length
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_excerpt_length', array(
				'default'          		=>  40,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_portfolio_loop_post_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'killar' ),
				'description'	   		=> __( 'Show Portfolio / Archive Post Content Summery.', 'killar' ),
				'section' 				=> 'killar_portfolio_loop_post_section',
				'settings'  			=> 'killar_portfolio_loop_post_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Loop Post : Social Share Links
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_social_share_links', array(
				'default'        	    => apply_filters( 'killar_portfolio_loop_post_social_share_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = killarwt_social_share_links_data();
			$portfolio_loop_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$portfolio_loop_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_portfolio_loop_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_portfolio_loop_post_social_share_links_choices',
												$portfolio_loop_post_social_share_links
											),
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_post_social_share',
			) ) );
			
			/**
			 * Loop Post : Read More
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_read_more', array(
				'default'           	=> 'icon-elink-link',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_post_read_more', array(
				'label'	   				=> __( 'Read More', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link'	 			=> __( 'Link (Default)', 'killar' ),
					'button' 			=> __( 'Button', 'killar' ),
					'icon-plus-popup'	=> __( 'Icon( Plus ) with Popup', 'killar' ),
					'icon-elink-popup' 	=> __( 'Icon( External Link ) with Popup', 'killar' ),
					'icon-plus-link' 	=> __( 'Icon( Plus ) with Link', 'killar' ),
					'icon-elink-link'	=> __( 'Icon( External Link ) with Link', 'killar' ),
					'0' 	 			=> __( 'Hide', 'killar' ),
				),
			) ) );
			
			/**
			 * Loop Post : Portfolio Per Page
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_per_page', array(
				'default'          		=>  6,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_portfolio_loop_post_per_page', array(
				'label'   				=> __( 'Portfolio Per Page', 'killar' ),
				'section' 				=> 'killar_portfolio_loop_post_section',
				'settings'  			=> 'killar_portfolio_loop_post_per_page',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 50,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Loop Post : Pagination Style
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_pagination_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_loop_post_pagination_style', array(
				'label'	   				=> __( 'Pagination Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_loop_post_section',
				'settings' 				=> 'killar_portfolio_loop_post_pagination_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 			=> __( 'Default', 'killar' ),
					'infinite-scroll' 	=> __( 'Infinite Scroll', 'killar' ),
					'load-more' 		=> __( 'Load More', 'killar' ),
				),
			) ) );
			
			/**
			 * Loop Post : Pagination Last Text
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_pagination_last_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'End of content',
			) );

			$wp_customize->add_control( 'killar_portfolio_loop_post_pagination_last_text', array(
				'label' 			=> esc_html__( 'Pagination Last Text', 'killar' ),
				'section' 			=> 'killar_portfolio_loop_post_section',
				'settings' 			=> 'killar_portfolio_loop_post_pagination_last_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_post_pagination_style_not_default',
			) );
			
			/**
			 * Loop Post : Load More Button Text
			 */
			$wp_customize->add_setting( 'killar_portfolio_loop_post_load_more_button_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'More Posts',
			) );

			$wp_customize->add_control( 'killar_portfolio_loop_post_load_more_button_text', array(
				'label' 			=> esc_html__( 'Load More Button Text', 'killar' ),
				'section' 			=> 'killar_portfolio_loop_post_section',
				'settings' 			=> 'killar_portfolio_loop_post_load_more_button_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_loop_post_pagination_style_not_default',
			) );
			
			
			/**
			 * Single Portfolio Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_portfolio_single_post_section' , array(
				'title' 			=> __( 'Single Portfolio', 'killar' ),
				'priority' 			=> 110,
				'panel' 			=> 'killar_portfolio_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_portfolio_single_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'killar' ),
				'choices' 				=> array(
											'full-width'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Sidebar
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_sidebar', array(
				'default'        	    => 'single-post-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_single_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'killar' ),
				'description'	   		=> __( 'Choose sidebar for display on singlular page.', 'killar' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_killar_get_registered_sidebars(),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_title_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_portfolio_single_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Page Title Section
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_portfolio_single_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_title_alignment', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_single_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_title_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 		=> __( 'Default', 'killar' ),
											'left' 			=> __( 'Left', 'killar' ),
											'centered' 		=> __( 'Center', 'killar' ),
											'right' 		=> __( 'Right', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Post : Page Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_title', array(
				'default'           	=> 'hidden',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_single_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'killar' ),
											'custom' 			=> __( 'Custom Text', 'killar' ),
											'post_title' 		=> __( 'Post Title', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Portfolio : Page Header Custom Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_title_custom', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Portfolio',
			) );

			$wp_customize->add_control( 'killar_portfolio_single_post_page_title_custom', array(
				'label' 			=> esc_html__( 'Page Title Custom Text', 'killar' ),
				'section' 			=> 'killar_portfolio_single_post_section',
				'settings' 			=> 'killar_portfolio_single_post_page_title_custom',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_page_title',
			) );
			
			/**
			 * Single Portfolio : Page Title Background Image
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_single_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'featured_image' 	=> __( 'Featured Image', 'killar' ),
											'custom'		 	=> __( 'Custom', 'killar' ),
											'hide' 				=> __( 'Hide', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Portfolio : Background Image
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_title_bg_image', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_portfolio_single_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_page_title_background',
			) ) );
			
			/**
			 * Single Portfolio : Breadcrumb
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_portfolio_single_post_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_page_content_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_portfolio_single_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_sections_positioning', array(
				'default'        	    => apply_filters( 'killar_portfolio_single_post_sections_positioning', array( 'title', 'content', 'highlights', 'skills', 'social-links' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_portfolio_single_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_portfolio_single_post_meta_choices',
												array(
													'categories'    => esc_html__( 'Categories', 'killar' ),
													'thumbnail'     => esc_html__( 'Thumbnail', 'killar' ),
													'title'    		=> esc_html__( 'Title', 'killar' ),
													'content'    	=> esc_html__( 'Content', 'killar' ),
													'highlights'	=> esc_html__( 'Highlights', 'killar' ),
													'skills'  		=> esc_html__( 'Skills', 'killar' ),
													'social-links'  => esc_html__( 'Social Links', 'killar' ),
													// 'related-portfolio'	=> esc_html__( 'Related Portfolios', 'killar' ),
												)
											),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Social Share Links
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_social_share_links', array(
				'default'        	    => apply_filters( 'killar_portfolio_single_post_social_share_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = killarwt_social_share_links_data();
			
			$single_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$single_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_portfolio_single_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_portfolio_single_post_social_share_links_choices',
												$single_post_social_share_links
											),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_social_share',
			) ) );
			
			/**
			 * Single Portfolio : Related Portfolios Heading ================================
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_posts_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_portfolio_single_post_related_posts_heading', array(
				'label'	   				=> __( 'Related Portfolios', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_related_posts_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Show/Hide Related Portfolio
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_posts', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_portfolio_single_post_related_posts', array(
				'label'	   				=> __( 'Show Related Portfolio', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_related_posts',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Portfolio : Sub Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_sub_title', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Similar Portfolio',
			) );

			$wp_customize->add_control( 'killar_portfolio_single_post_related_sub_title', array(
				'label' 			=> esc_html__( 'Sub Title', 'killar' ),
				'section' 			=> 'killar_portfolio_single_post_section',
				'settings' 			=> 'killar_portfolio_single_post_related_sub_title',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) );

			/**
			 * Single Portfolio : Title
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_title', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'More Case Studies',
			) );

			$wp_customize->add_control( 'killar_portfolio_single_post_related_title', array(
				'label' 			=> esc_html__( 'Title', 'killar' ),
				'section' 			=> 'killar_portfolio_single_post_section',
				'settings' 			=> 'killar_portfolio_single_post_related_title',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) );
			
			
			/**
			 * Single Portfolio : Posts Styles
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_style', array(
				'default'           	=> 'box',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_single_post_related_style', array(
				'label'	   				=> __( 'Post Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_related_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 		=> __( 'Default', 'killar' ),
					'box' 			=> __( 'Box', 'killar' ),
				),
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Post Content
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_content', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_portfolio_single_post_related_content', array(
				'label'	   				=> __( 'Post Content', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_related_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'killar' ),
											'full' 				=> __( 'Full', 'killar' ),
											'' 					=> __( 'Hidden', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Excerpt Length
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_excerpt_length', array(
				'default'          		=>  20,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_portfolio_single_post_related_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'killar' ),
				'description'	   		=> __( 'Show Post Content Summery.', 'killar' ),
				'section' 				=> 'killar_portfolio_single_post_section',
				'settings'  			=> 'killar_portfolio_single_post_related_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Read More
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_read_more', array(
				'default'           	=> 'icon-elink-link',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_portfolio_single_post_related_read_more', array(
				'label'	   				=> __( 'Read More', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_post_related_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link'	 			=> __( 'Link (Default)', 'killar' ),
					'button' 			=> __( 'Button', 'killar' ),
					'icon-plus-popup'	=> __( 'Icon( Plus ) with Popup', 'killar' ),
					'icon-elink-popup' 	=> __( 'Icon( External Link ) with Popup', 'killar' ),
					'icon-plus-link' 	=> __( 'Icon( Plus ) with Link', 'killar' ),
					'icon-elink-link'	=> __( 'Icon( External Link ) with Link', 'killar' ),
					'0' 	 			=> __( 'Hide', 'killar' ),
				),
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Remove Items Padding
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_related_remove_items_padding', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_portfolio_single_related_remove_items_padding', array(
				'label'	   				=> __( 'Remove Items Padding', 'killar' ),
				'section'  				=> 'killar_portfolio_single_post_section',
				'settings' 				=> 'killar_portfolio_single_related_remove_items_padding',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Show Numbers Related Portfolios
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_posts_number', array(
				'default'          		=>  6,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_portfolio_single_post_related_posts_number', array(
				'label'   				=> __( 'Show Numbers of Related Portfolios', 'killar' ),
				'section' 				=> 'killar_portfolio_single_post_section',
				'settings'  			=> 'killar_portfolio_single_post_related_posts_number',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 20,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Show Related Portfolios Columns
			 */
			$wp_customize->add_setting( 'killar_portfolio_single_post_related_posts_columns', array(
				'default'          		=>  2,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_portfolio_single_post_related_posts_columns', array(
				'label'   				=> __( 'Show Related Portfolios Columns', 'killar' ),
				'section' 				=> 'killar_portfolio_single_post_section',
				'settings'  			=> 'killar_portfolio_single_post_related_posts_columns',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 12,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_portfolio_single_post_related_posts',
			) ) );
			
		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			return $output;
		}
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			$categories = get_categories( array( 'taxonomy' => 'portfolio-cat', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			$posts_id = get_posts( array('post_type' => 'portfolio', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( $categories[0] ) ) { ?>
					wp.customize.section( 'killar_portfolio_loop_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_permalink('/portfolio') ); ?>" );
							}
						} );
					} );
					<?php } ?>
					<?php if ( !empty( $posts_id[0] ) ) { ?>
					wp.customize.section( 'killar_portfolio_single_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_permalink( $posts_id[0] ) ); ?>" );
							}
						} );
					<?php } ?>
					} );
				} );
			</script>
			<?php
		}
	}

endif;

return new KillarWT_Portfolio_Customizer();