<?php
/**
 * Blog/Post Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Blog_Post_Customizer' ) ) :

	class KillarWT_Blog_Post_Customizer {

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
			 * Blog/Post Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_blog_post_panel',  array(
				'title' 			=> __( 'Blog / Post', 'killar' ),
				'priority' 			=> '-2500',
				'panel' 			=> 'killar_options_panel',
			) ) );
			
			/**
			 * Blog / Archive Section
			 */
			$wp_customize->add_section( 'killar_blog_loop_post_section' , array(
				'title' 			=> __( 'Blog / Archive', 'killar' ),
				'priority' 			=> 110,
				'panel' 			=> 'killar_blog_post_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_blog_loop_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'killar' ),
				'choices' 				=> array(
											'full-width'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sidebar
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_sidebar', array(
				'default'        	    => 'blog-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_loop_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'killar' ),
				'description'	   		=> __( 'Choose sidebar for display on the Blog / Archive page.', 'killar' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_killar_get_registered_sidebars(),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Blog View
			 */
			$wp_customize->add_setting( 'killar_blog_loop_view_type', array(
				'default'           	=> 'list',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_loop_view_type', array(
				'label'	   				=> __( 'Blog View', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_view_type',
				'priority' 				=> 10,
				'choices' 				=> array(
											'full' 			=> __( 'Full', 'killar' ),
											'full-center' 	=> __( 'Full Center', 'killar' ),
											'list' 			=> __( 'List', 'killar' ),
											'grid' 			=> __( 'Grid', 'killar' ),
											'modern' 		=> __( 'Modern', 'killar' ),
										),
			) ) );
			
			/**
			 * Loop Post : Post Style
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_loop_post_style', array(
				'label'	   				=> __( 'Post Style', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'box' 				=> __( 'Box', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killarwt_blog_loop_view_type_is_grid',
			) ) );
			
			/**
			 * Loop Post : Columns Heading ================================
			 */
			$wp_customize->add_setting( 'killar_blog_loop_columns_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_blog_loop_columns_heading', array(
				'label'	   				=> __( 'Blog Columns', 'killar' ),
				'description'	   		=> __( 'Show numbers of items below list of screen size. Blog columns settings apply only grid and slider.', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_columns_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killarwt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : LG Columns
			 */
			$wp_customize->add_setting( 'killar_blog_loop_items_col_lg', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_loop_items_col_lg', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_items_col_lg',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killarwt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : MD Columns
			 */
			$wp_customize->add_setting( 'killar_blog_loop_items_col_md', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_loop_items_col_md', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_items_col_md',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
											'5' 				=> __( '5 - Item(s)', 'killar' ),
											'6' 				=> __( '6 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killarwt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : SM Columns
			 */
			$wp_customize->add_setting( 'killar_blog_loop_items_col_sm', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_loop_items_col_sm', array(
				'label'	   				=> __( 'Small devices (landscape phones, less than 768px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_items_col_sm',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
											'4' 				=> __( '4 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killarwt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : XS Columns
			 */
			$wp_customize->add_setting( 'killar_blog_loop_items_col_xs', array(
				'default'           	=> '1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_loop_items_col_xs', array(
				'label'	   				=> __( 'Extra small devices (portrait phones, less than 576px)', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_items_col_xs',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'killar' ),
											'2' 				=> __( '2 - Item(s)', 'killar' ),
											'3' 				=> __( '3 - Item(s)', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killarwt_blog_loop_view_type_is_grid',
			) ) );
						
			/**
			 * Loop Post : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_page_title_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_blog_loop_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Section
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_blog_loop_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_page_title_alignment', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_loop_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_title_alignment',
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
			$wp_customize->add_setting( 'killar_blog_loop_post_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_loop_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_title',
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
			$wp_customize->add_setting( 'killar_blog_loop_post_page_title_custom', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'Blog',
			) );

			$wp_customize->add_control( 'killar_blog_loop_post_page_title_custom', array(
				'label' 			=> esc_html__( 'Page Title Custom Text', 'killar' ),
				'section' 			=> 'killar_blog_loop_post_section',
				'settings' 			=> 'killar_blog_loop_post_page_title_custom',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_blog_loop_post_page_title',
			) );
			
			/**
			 * Loop Post : Page Title Background Image
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_loop_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_title_background',
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
			$wp_customize->add_setting( 'killar_blog_loop_post_page_title_bg_image', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_blog_loop_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killarwt_blog_loop_post_page_title_background',
			) ) );
			
			/**
			 * Loop Post : Breadcrumb
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_blog_loop_post_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_page_content_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_blog_loop_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_sections_positioning', array(
				'default'        	    => apply_filters( 'killar_blog_loop_post_sections_positioning_default', array( 'thumbnail', 'categories', 'title', 'meta', 'content', 'read-more' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_blog_loop_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_blog_loop_post_meta_choices',
												array(
													'thumbnail'     => esc_html__( 'Thumbnail', 'killar' ),
													'title'    		=> esc_html__( 'Title', 'killar' ),
													'meta'    		=> esc_html__( 'Meta', 'killar' ),
													'content'    	=> esc_html__( 'Content', 'killar' ),
													'categories'    => esc_html__( 'Categories', 'killar' ),
													'tags'			=> esc_html__( 'Tags', 'killar' ),
													'social-links'  => esc_html__( 'Social Links', 'killar' ),
													'read-more'  => esc_html__( 'Read More', 'killar' ),
												)
											),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Blog Meta
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_meta', array(
				'default'        	    => apply_filters( 'killar_blog_loop_post_meta_default', array('date') ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_blog_loop_post_meta', array(
				'label'	   				=> __( 'Meta', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_blog_loop_post_meta_choices',
												array(
													'author'        => esc_html__( 'Author', 'killar' ),
													'categories'    => esc_html__( 'Categories', 'killar' ),
													'tags'    		=> esc_html__( 'Tags', 'killar' ),
													'comments'      => esc_html__( 'Comments', 'killar' ),
													'date'          => esc_html__( 'Date', 'killar' ),
													'reading-time'  => esc_html__( 'Reading Time', 'killar' ),
												)
											),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_meta',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Post Content
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_content', array(
				'default'           	=> 'excerpt',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_loop_post_content', array(
				'label'	   				=> __( 'Post Content', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'killar' ),
											'full' 				=> __( 'Full', 'killar' ),
										),
			) ) );
			
			/**
			 * Loop Post : Excerpt Length
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_excerpt_length', array(
				'default'          		=>  15,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_blog_loop_post_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'killar' ),
				'description'	   		=> __( 'Show Blog / Archive Post Content Summery.', 'killar' ),
				'section' 				=> 'killar_blog_loop_post_section',
				'settings'  			=> 'killar_blog_loop_post_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Loop Post : Social Share Links
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_social_share_links', array(
				'default'        	    => apply_filters( 'killar_blog_loop_post_social_share_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = killarwt_social_share_links_data();
			$blog_loop_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$blog_loop_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_blog_loop_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_blog_loop_post_social_share_links_choices',
												$blog_loop_post_social_share_links
											),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killarwt_blog_loop_post_social_share',
			) ) );
			
			/**
			 * Loop Post : Show Facy Date
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_fancy_date', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_blog_loop_post_fancy_date', array(
				'label'	   				=> __( 'Show Facy Date', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_fancy_date',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Show Read Time With Tags
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_readtime_with_tag', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_blog_loop_post_readtime_with_tag', array(
				'label'	   				=> __( 'Show Read Time With Tags', 'killar' ),
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_readtime_with_tag',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Read More
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_read_more', array(
				'default'           	=> 'link',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_loop_post_read_more', array(
				'label'	   				=> __( 'Read More', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link' 				=> __( 'Link (Default)', 'killar' ),
					'button' 			=> __( 'Button', 'killar' ),
					'0' 				=> __( 'Hide', 'killar' ),
				),
			) ) );
			
			/**
			 * Loop Post : Pagination Style
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_pagination_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_loop_post_pagination_style', array(
				'label'	   				=> __( 'Pagination Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_loop_post_section',
				'settings' 				=> 'killar_blog_loop_post_pagination_style',
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
			$wp_customize->add_setting( 'killar_blog_loop_post_pagination_last_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'End of content',
			) );

			$wp_customize->add_control( 'killar_blog_loop_post_pagination_last_text', array(
				'label' 			=> esc_html__( 'Pagination Last Text', 'killar' ),
				'section' 			=> 'killar_blog_loop_post_section',
				'settings' 			=> 'killar_blog_loop_post_pagination_last_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killarwt_blog_loop_post_pagination_style_not_default',
			) );
			
			/**
			 * Loop Post : Load More Button Text
			 */
			$wp_customize->add_setting( 'killar_blog_loop_post_load_more_button_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'Read More Articles',
			) );

			$wp_customize->add_control( 'killar_blog_loop_post_load_more_button_text', array(
				'label' 			=> esc_html__( 'Load More Button Text', 'killar' ),
				'section' 			=> 'killar_blog_loop_post_section',
				'settings' 			=> 'killar_blog_loop_post_load_more_button_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killarwt_blog_loop_post_pagination_style_not_default',
			) );	
			
			/**
			 * Single Post Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_blog_single_post_section' , array(
				'title' 			=> __( 'Single Post', 'killar' ),
				'priority' 			=> 110,
				'panel' 			=> 'killar_blog_post_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_blog_single_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'killar' ),
				'choices' 				=> array(
											'full-width'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Sidebar
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_sidebar', array(
				'default'        	    => 'single-post-sidebar',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_single_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'killar' ),
				'description'	   		=> __( 'Choose sidebar for display on singlular page.', 'killar' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_killar_get_registered_sidebars(),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_title_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_blog_single_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Page Title Section
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_blog_single_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			
			/**
			 * Single Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_title_alignment', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_single_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_title_alignment',
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
			$wp_customize->add_setting( 'killar_blog_single_post_page_title', array(
				'default'           	=> 'hidden',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_single_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'killar' ),
											'custom' 			=> __( 'Custom Text', 'killar' ),
											'post_title' 		=> __( 'Post Title', 'killar' ),
										),
			) ) );
		
			
			/**
			 * Single Post : Page Header Custom Title
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_title_custom', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Blog',
			) );

			$wp_customize->add_control( 'killar_blog_single_post_page_title_custom', array(
				'label' 			=> esc_html__( 'Page Title Custom Text', 'killar' ),
				'section' 			=> 'killar_blog_single_post_section',
				'settings' 			=> 'killar_blog_single_post_page_title_custom',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_killar_blog_single_post_page_title',
			) );
			
			/**
			 * Single Post : Page Title Background Image
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_title_background', array(
				'default'           	=> 'featured_image',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_single_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'killar' ),
											'featured_image' 	=> __( 'Featured Image', 'killar' ),
											'custom' 			=> __( 'Custom', 'killar' ),
											'hide' 				=> __( 'Hide', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Post : Background Image
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_title_bg_image', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_blog_single_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_blog_single_post_page_title_background',
			) ) );
			
			/**
			 * Single Post : Page Title
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_title_inner_content', array(
				'default'           	=> 'breadcrumbs',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_single_post_page_title_inner_content', array(
				'label'	   				=> __( 'Page Title Content', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_title_inner_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'breadcrumbs' 		=> __( 'Breadcrumbs', 'killar' ),
											'meta' 				=> __( 'Post Meta', 'killar' ),
											'hidden' 			=> __( 'Hidden', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Post : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_page_content_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_blog_single_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_sections_positioning', array(
				'default'        	    => killarwt_blog_single_post_sections_positioning_array('title', 'meta' ,'content', 'thumbnail', 'comments'),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_blog_single_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_blog_single_post_meta_choices',
												array(
													'categories'    => esc_html__( 'Categories', 'killar' ),
													'thumbnail'     => esc_html__( 'Thumbnail', 'killar' ),
													'title'    		=> esc_html__( 'Title', 'killar' ),
													'meta'    		=> esc_html__( 'Meta', 'killar' ),
													'content'    	=> esc_html__( 'Content', 'killar' ),
													'tags'			=> esc_html__( 'Tags', 'killar' ),
													'social-links'  => esc_html__( 'Social Links', 'killar' ),
													'author-info'  	=> esc_html__( 'Author Info', 'killar' ),
													'next-prev' 	=> esc_html__( 'Next/Prev', 'killar' ),
													'related-posts'	=> esc_html__( 'Related Posts', 'killar' ),
													'comments' 		=> esc_html__( 'Comments', 'killar' ),
												)
											),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
		
			/**
			 * Single Post : Blog Meta
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_meta', array(
				'default'        	    => apply_filters( 'killar_blog_single_post_meta_default', array( 'author', 'comments', 'date' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_blog_single_post_meta', array(
				'label'	   				=> __( 'Meta', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_blog_single_post_meta_choices',
												array(
													'author'        => esc_html__( 'Author', 'killar' ),
													'categories'    => esc_html__( 'Categories', 'killar' ),
													'tags'    => esc_html__( 'Tags', 'killar' ),
													'comments'      => esc_html__( 'Comments', 'killar' ),
													'date'          => esc_html__( 'Date', 'killar' ),
													'reading-time'  => esc_html__( 'Reading Time', 'killar' ),
												)
											),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_meta',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Social Share Links
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_social_share_links', array(
				'default'        	    => apply_filters( 'killar_blog_single_post_social_share_links_default', array( 'facebook', 'twitter', 'linkedin' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = killarwt_social_share_links_data();
			
			$single_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$single_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_blog_single_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_blog_single_post_social_share_links_choices',
												$single_post_social_share_links
											),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_blog_single_post_social_share',
			) ) );
			
			/**
			 * Single Post : Related Posts Heading ================================
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_posts_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_blog_single_post_related_posts_heading', array(
				'label'	   				=> __( 'Related Posts', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_related_posts_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_blog_single_post_related_posts',
			) ) );
			
			/**
			 * Single Post : Related Posts
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_blog_single_post_related', array(
				'label'	   				=> __( 'Show Related Posts', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_related',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Posts Styles
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_single_post_related_style', array(
				'label'	   				=> __( 'Post Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_related_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 		=> __( 'Default', 'killar' ),
					'box' 			=> __( 'Box', 'killar' ),
				),
			) ) );
			
			/**
			 * Single Post : Post Content
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_content', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_single_post_related_content', array(
				'label'	   				=> __( 'Post Content', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_related_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'killar' ),
											'full' 				=> __( 'Full', 'killar' ),
											'' 					=> __( 'Hidden', 'killar' ),
										),
			) ) );
			
			/**
			 * Single Post : Excerpt Length
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_excerpt_length', array(
				'default'          		=>  20,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_blog_single_post_related_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'killar' ),
				'description'	   		=> __( 'Show Post Content Summery.', 'killar' ),
				'section' 				=> 'killar_blog_single_post_section',
				'settings'  			=> 'killar_blog_single_post_related_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Single Post : Read More
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_read_more', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_blog_single_post_related_read_more', array(
				'label'	   				=> __( 'Read More', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_related_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link' 				=> __( 'Link (Default)', 'killar' ),
					'button' 			=> __( 'Button', 'killar' ),
					'icon' 				=> __( 'Icon', 'killar' ),
					'0' 				=> __( 'Hide', 'killar' ),
				),
			) ) );
			
			/**
			 * Single Post : Show Numbers Related Posts
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_posts_number', array(
				'default'          		=>  6,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_blog_single_post_related_posts_number', array(
				'label'   				=> __( 'Show Numbers of Related Posts', 'killar' ),
				'section' 				=> 'killar_blog_single_post_section',
				'settings'  			=> 'killar_blog_single_post_related_posts_number',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 20,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_blog_single_post_related_posts',
			) ) );
			
			/**
			 * Single Post : Show Related Posts Columns
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_posts_columns', array(
				'default'          		=>  2,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_blog_single_post_related_posts_columns', array(
				'label'   				=> __( 'Show Related Posts Columns', 'killar' ),
				'section' 				=> 'killar_blog_single_post_section',
				'settings'  			=> 'killar_blog_single_post_related_posts_columns',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 12,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_blog_single_post_related_posts',
			) ) );
			
			/**
			 * Single Post : Related Posts Taxonomy
			 */
			$wp_customize->add_setting( 'killar_blog_single_post_related_posts_taxonomy', array(
				'default'           	=> 'category',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_blog_single_post_related_posts_taxonomy', array(
				'label'	   				=> __( 'Related Posts Taxonomy', 'killar' ),
				'section'  				=> 'killar_blog_single_post_section',
				'settings' 				=> 'killar_blog_single_post_related_posts_taxonomy',
				'priority' 				=> 10,
				'choices' 				=> array(
											'category' 			=> __( 'Category', 'killar' ),
											'post_tag' 			=> __( 'Tags', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_blog_single_post_related_posts',
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
			$ctegories = get_categories( array('post_type' => 'post', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			$posts_id = get_posts( array('post_type' => 'post', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( $ctegories[0] ) ) { ?>
					wp.customize.section( 'killar_blog_loop_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_category_link( $ctegories[0] ) ); ?>" );
							}
						} );
					} );
					<?php } ?>
					<?php if ( !empty( $posts_id[0] ) ) { ?>
					wp.customize.section( 'killar_blog_single_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_permalink( $posts_id[0] ) ); ?>" );
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

return new KillarWT_Blog_Post_Customizer();