<?php
/**
 * Header Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Header_Customizer' ) ) :

	class KillarWT_Header_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {

			/**
			 * Header Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_header_panel',  array(
				'title' 			=> __( 'Header', 'killar' ),
				'priority' 			=> '-2800',
				'panel' 			=> 'killar_options_panel',
			) ) );
			
			/**
			 * Header Section -----------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_header_general' , array(
				'title' 			=> __( 'Header Settings', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_header_panel',
			) );

			/**
			* Header: Layout
			*/
			$wp_customize->add_setting( 'killar_header_style', array(
				'default'           	=> 'header_v1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_header_style', array(
				'label'	   				=> __( 'Header Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_header_general',
				'settings' 				=> 'killar_header_style',
				'priority' 				=> 10,
				'choices' 				=> killarwt_header_style_list(),
			) ) );
			
			/**
			 * Header : Transparent Header
			 */
			$wp_customize->add_setting( 'killar_transparent_header', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_transparent_header', array(
				'label'	   				=> __( 'Transparent Header', 'killar' ),
				'section'  				=> 'killar_header_general',
				'settings' 				=> 'killar_transparent_header',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Menu : Show Search Content
			 */
			$wp_customize->add_setting( 'killar_show_header_search', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_show_header_search', array(
				'label'	   				=> __( 'Show Search Content', 'killar' ),
				'section'  				=> 'killar_header_general',
				'settings' 				=> 'killar_show_header_search',
				'priority' 				=> 10,
			) ) );
			
			/**
			* Header: Right Layout
			*/
			$wp_customize->add_setting( 'killar_header_right_layout', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_header_right_layout', array(
				'label'	   				=> __( 'Header Right Layout', 'killar' ),
				'type' 					=> 'select',
				'description'	   		=> __( 'Select header right layout from Layouts Builder', 'killar' ),
				'section'  				=> 'killar_header_general',
				'settings' 				=> 'killar_header_right_layout',
				'priority' 				=> 10,
				'choices' 				=> killarwt_header_right_layout_list(),
			) ) );

			if ( !empty( KILLARWT_WOOCOMMERCE_ACTIVE ) ) {

				/**
				 * Header : Shop Right Sidebar
				 */
				$wp_customize->add_setting('killar_header_shop_right_buttons', array(
					'default'        	    => apply_filters('killar_header_shop_right_buttons_default', array('register', 'signin-account', 'cart')),
					'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
				));

				$wp_customize->add_control(new KillarWT_Customizer_Sortable_Control($wp_customize, 'killar_header_shop_right_buttons', array(
					'label'	   				=> __('Header Shop Right Button', 'killar'),
					'choices' 				=>  apply_filters(
						'killar_header_shop_right_buttons',
						array(
							'register'    	=> esc_html__('Register Button', 'killar'),
							'signin-account' => esc_html__('SignIn - Account Button', 'killar'),
							'cart'    		=> esc_html__('Cart Icon', 'killar'),
						)
					),
					'section'  				=> 'killar_header_general',
					'settings' 				=> 'killar_header_shop_right_buttons',
					'priority' 				=> 10,
					'active_callback' 		=> 'ctm_killarwt_header_shop_right_buttons',
				)));
			}

			/**
			* Header: Show Advance Navigation
			*/
			$wp_customize->add_setting( 'killar_show_advance_navigation', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_show_advance_navigation', array(
				'label'	   				=> __( 'Advance Navigation Layout', 'killar' ),
				'type' 					=> 'select',
				'description'	   		=> __( 'Select header advance manu from Layouts Builder', 'killar' ),
				'section'  				=> 'killar_header_general',
				'settings' 				=> 'killar_show_advance_navigation',
				'priority' 				=> 10,
				'choices' 				=> killarwt_advance_navigation_layout_list(),
			) ) );
			
			/**
			 * Header Style ================================
			 */
			$wp_customize->add_setting( 'killar_header_style_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_header_style_heading', array(
				'label'	   				=> __( 'Style', 'killar' ),
				'section'  				=> 'killar_header_general',
				'settings' 				=> 'killar_header_style_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			* Header: BgColor
			*/
			$wp_customize->add_setting( 'killar_header_bg_color', array(
				'default'               => '#ffffff                                                                                                                                                                                                                                                                                                                                                                                                         ',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_header_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_header_general',
				'settings' 			    => 'killar_header_bg_color',
				'priority'              => 100,
			) ) );
			
			/**
			* Header: Text Color
			*/
			$wp_customize->add_setting( 'killar_header_text_color', array(
				'default'               => '#008aff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_header_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'killar' ),
				'section'  			    => 'killar_header_general',
				'settings' 			    => 'killar_header_text_color',
				'priority'              => 200,
			) ) );


			/**
			 * Site Identity Section -----------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_header_logo_section', array(
				'title' 			=> __( 'Logo', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_header_panel',
			) );

			$wp_customize->add_setting( 'killar_header_logo_width', array(
				'default'          		=>  150,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_header_logo_width', array(
				'label'   				=> __( 'Max Width(px)', 'killar' ),
				'section' 				=> 'killar_header_logo_section',
				'settings'  			=> 'killar_header_logo_width',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 200,
											'step' => 1,
										),
			) ) );

			$wp_customize->add_setting( 'killar_header_logo_height', array(
				'default'          		=>  42,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_header_logo_height', array(
				'label'   				=> __( 'Max Height(px)', 'killar' ),
				'section' 				=> 'killar_header_logo_section',
				'settings'  			=> 'killar_header_logo_height',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 200,
											'step' => 1,
										),
			) ) );
			
			/* ------------------------------------------------------------------------------------------------------------------------- */
			
			/**
			 * Sticky Header Section -----------------------------------------------------------------------
			 */ 
			$wp_customize->add_section( 'killar_header_sticky_section', array(
				'title' 			=> __( 'Sticky Header', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_header_panel',
			) );
			
			/**
			 * Sticky
			 */
			$wp_customize->add_setting( 'killar_header_sticky', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_header_sticky', array(
				'label'	   				=> __( 'Sticky Header', 'killar' ),
				'section'  				=> 'killar_header_sticky_section',
				'settings' 				=> 'killar_header_sticky',
				'priority' 				=> 10,
			) ) );

			/**
			 * Sticky : Logo
			 */
			$wp_customize->add_setting( 'killar_header_sticky_logo', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/logo.png',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_header_sticky_logo', array(
				'label'	   				=> __( 'Sticky Logo', 'killar' ),
				'section'  				=> 'killar_header_sticky_section',
				'settings' 				=> 'killar_header_sticky_logo',
				'priority' 				=> 10
			) ) );
			
			/**
			 * Sticky : BGColor
			 */
			$wp_customize->add_setting( 'killar_header_sticky_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_header_sticky_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_header_sticky_section',
				'settings' 			    => 'killar_header_sticky_bg_color',
				'priority'              => 100,
			) ) );
			
			/**
			 * Sticky : Text Color
			 */
			$wp_customize->add_setting( 'killar_header_sticky_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_header_sticky_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'killar' ),
				'section'  			    => 'killar_header_sticky_section',
				'settings' 			    => 'killar_header_sticky_text_color',
				'priority'              => 200,
			) ) );
			
			
			/**
			 * Menu Section -----------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_header_nav_menu' , array(
				'title' 			=> __( 'Menu', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_header_panel',
			) );
			
			/**
			 * Menu Style ================================
			 */
			$wp_customize->add_setting( 'killar_header_nav_menu_style_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_header_nav_menu_style_heading', array(
				'label'	   				=> __( 'Style', 'killar' ),
				'section'  				=> 'killar_header_nav_menu',
				'settings' 				=> 'killar_header_nav_menu_style_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Menu : Font Size
			 */
			$wp_customize->add_setting( 'killar_nav_menu_font_size', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> '',
			) );

			$wp_customize->add_control( 'killar_nav_menu_font_size', array(
				'label' 			=> esc_html__( 'NavBar Menu Font Size', 'killar' ),
				'description' 		=> esc_html__( 'You can add size in (px,em,%)', 'killar' ),
				'section' 			=> 'killar_header_nav_menu',
				'settings' 			=> 'killar_nav_menu_font_size',
				'priority' 			=> 10,
			) );
			
			/**
			 * Menu : Font Weight
			 */
			$wp_customize->add_setting( 'killar_nav_menu_font_weight', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( 'killar_nav_menu_font_weight', array(
				'label' 			=> esc_html__( 'NavBar Menu Font Weight', 'killar' ),
				'section' 			=> 'killar_header_nav_menu',
				'settings' 			=> 'killar_nav_menu_font_weight',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'choices' 			=> array(
					'' => esc_html__( 'Default', 'killar' ),
					'100' => esc_html__( 'Thin: 100', 'killar' ),
					'200' => esc_html__( 'Light: 200', 'killar' ),
					'300' => esc_html__( 'Book: 300', 'killar' ),
					'400' => esc_html__( 'Normal: 400', 'killar' ),
					'500' => esc_html__( 'Medium: 500', 'killar' ),
					'600' => esc_html__( 'Semibold: 600', 'killar' ),
					'700' => esc_html__( 'Bold: 700', 'killar' ),
					'800' => esc_html__( 'Extra Bold: 800', 'killar' ),
					'900' => esc_html__( 'Black: 900', 'killar' ),
				),
			) );
			
			/**
			 * Menu : Text Transform
			 */
			$wp_customize->add_setting( 'killar_nav_menu_text_transform', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( 'killar_nav_menu_text_transform', array(
				'label' 			=> esc_html__( 'NavBar Menu Text Transform', 'killar' ),
				'section' 			=> 'killar_header_nav_menu',
				'settings' 			=> 'killar_nav_menu_text_transform',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'choices' 			=> array(
					'' 			 => esc_html__( 'Default', 'killar' ),
					'capitalize' => esc_html__( 'Capitalize', 'killar' ),
					'lowercase'  => esc_html__( 'Lowercase', 'killar' ),
					'uppercase'  => esc_html__( 'Uppercase', 'killar' ),
					'none'  	 => esc_html__( 'None', 'killar' ),
				),
			) );
			
			
			/**
			 * Menu : BG Color
			 */
			$wp_customize->add_setting( 'killar_nav_menu_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_menu_bg_color', array(
				'label'   			    => esc_html__( 'NavBar Background Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_menu_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Menu : Hover BG Color
			 */
			$wp_customize->add_setting( 'killar_nav_menu_hover_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_menu_hover_bg_color', array(
				'label'   			    => esc_html__( 'NavBar Menu Hover Background Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_menu_hover_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Menu : Text Color
			 */
			$wp_customize->add_setting( 'killar_nav_menu_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_menu_text_color', array(
				'label'   			    => esc_html__( 'NavBar Text Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_menu_text_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Menu : Text Hover Color
			 */
			$wp_customize->add_setting( 'killar_nav_menu_text_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_menu_text_hover_color', array(
				'label'   			    => esc_html__( 'NavBar Menu Text Hover Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_menu_text_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu Heading ================================
			 */
			$wp_customize->add_setting( 'killar_nav_megamenu_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_nav_megamenu_heading', array(
				'label'	   				=> __( 'Megamenu', 'killar' ),
				'section'  				=> 'killar_header_nav_menu',
				'settings' 				=> 'killar_nav_megamenu_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Megamenu : BG Color
			 */
			$wp_customize->add_setting( 'killar_nav_megamenu_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_megamenu_bg_color', array(
				'label'   			    => esc_html__( 'Megamenu Background Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_megamenu_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Text Color
			 */
			$wp_customize->add_setting( 'killar_nav_megamenu_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_megamenu_text_color', array(
				'label'   			    => esc_html__( 'Megamenu Text Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_megamenu_text_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Columns Heading Color
			 */
			$wp_customize->add_setting( 'killar_nav_megamenu_cols_heading_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_megamenu_cols_heading_color', array(
				'label'   			    => esc_html__( 'Megamenu Columns Heading Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_megamenu_cols_heading_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Border Color
			 */
			$wp_customize->add_setting( 'killar_nav_megamenu_border_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_megamenu_border_color', array(
				'label'   			    => esc_html__( 'Megamenu Border Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_megamenu_border_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Link Color
			 */
			$wp_customize->add_setting( 'killar_nav_megamenu_link_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_megamenu_link_color', array(
				'label'   			    => esc_html__( 'Megamenu Link Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_megamenu_link_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Link Hover Color
			 */
			$wp_customize->add_setting( 'killar_nav_megamenu_link_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_nav_megamenu_link_hover_color', array(
				'label'   			    => esc_html__( 'Megamenu Link Hover Color', 'killar' ),
				'section'  			    => 'killar_header_nav_menu',
				'settings' 			    => 'killar_nav_megamenu_link_hover_color',
				'priority'              => 10,
			) ) );

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
				
			$killar_header_bg_color								= get_theme_mod( 'killar_header_bg_color', '' );
			$killar_header_text_color							= get_theme_mod( 'killar_header_text_color', '' );

			$killar_header_logo_width							= get_theme_mod( 'killar_header_logo_width', '150' );
			$killar_header_logo_height							= get_theme_mod( 'killar_header_logo_height', '42' );
			
			$killar_header_sticky_bg_color						= get_theme_mod( 'killar_header_sticky_bg_color', '' );
			$killar_header_sticky_text_color					= get_theme_mod( 'killar_header_sticky_text_color', '' );
		
			$killar_nav_menu_font_size							= get_theme_mod( 'killar_nav_menu_font_size', '' );
			$killar_nav_menu_font_weight							= get_theme_mod( 'killar_nav_menu_font_weight', '' );
			$killar_nav_menu_text_transform						= get_theme_mod( 'killar_nav_menu_text_transform', '' );
			$killar_nav_menu_bg_color							= get_theme_mod( 'killar_nav_menu_bg_color', '' );
			$killar_nav_menu_text_color							= get_theme_mod( 'killar_nav_menu_text_color', '' );
			
			$killar_nav_menu_hover_bg_color						= get_theme_mod( 'killar_nav_menu_hover_bg_color', '' );
			$killar_nav_menu_text_hover_color					= get_theme_mod( 'killar_nav_menu_text_hover_color', '' );
			
			$killar_nav_megamenu_bg_color						= get_theme_mod( 'killar_nav_megamenu_bg_color', '' );
			$killar_nav_megamenu_text_color						= get_theme_mod( 'killar_nav_megamenu_text_color', '' );
			$killar_nav_megamenu_border_color					= get_theme_mod( 'killar_nav_megamenu_border_color', '' );
			
			$killar_nav_megamenu_cols_heading_color				= get_theme_mod( 'killar_nav_megamenu_cols_heading_color', '' );
			
			$killar_nav_megamenu_link_color						= get_theme_mod( 'killar_nav_megamenu_link_color', '' );
			$killar_nav_megamenu_link_hover_color				= get_theme_mod( 'killar_nav_megamenu_link_hover_color', '' );
			
			/**
			* Header
			*/
			$output .= killarwt_output_css( array( '.header-wrapper' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_header_bg_color, '' ) ) ? $killar_header_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_header_text_color, '' ) ) ? $killar_header_text_color : '',
			) ) );

			/**
			* Site Identity Header
			*/
			$output .= killarwt_output_css( array( '.nav-brand img' => array(
				'max-width' => ( !killarwt_opt_chk_def_val( $killar_header_logo_width, '150' ) ) ? $killar_header_logo_width.'px' : '',
				'max-height' => ( !killarwt_opt_chk_def_val( $killar_header_logo_height, '42' ) ) ? $killar_header_logo_height.'px' : '',
			) ) );
	
			
			/**
			* Sticky Header
			*/
			$output .= killarwt_output_css( array( '.header-wrapper.sticky-menu' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_header_sticky_bg_color, '' ) ) ? $killar_header_sticky_bg_color . ' !important' : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_header_sticky_text_color, '' ) ) ? $killar_header_sticky_text_color . ' !important' : '',
			) ) );
	
			/**
			* NavBar Menu Item
			*/
			$output .= killarwt_output_css( array( '.header' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_nav_menu_bg_color, '' ) ) ? $killar_nav_menu_bg_color : '',
			) ) );
			
			$output .= killarwt_output_css( array( '.kwt-menu>li>a, .header.header-transparent.dark .nav-menu>li>a' => array(
				'font-size' => ( !killarwt_opt_chk_def_val( $killar_nav_menu_font_size, '' ) ) ? $killar_nav_menu_font_size : '',
				'font-weight' => ( !killarwt_opt_chk_def_val( $killar_nav_menu_font_weight, '' ) ) ? $killar_nav_menu_font_weight : '',
				'text-transform' => ( !killarwt_opt_chk_def_val( $killar_nav_menu_text_transform, '' ) ) ? $killar_nav_menu_text_transform : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_nav_menu_text_color, '' ) ) ? $killar_nav_menu_text_color : '',
			) ) );
			
			/**
			* NavBar Menu Item Hover
			*/
			$output .= killarwt_output_css( array( '.kwt-menu>li:hover>a, .header.header-transparent.dark .nav-menu>li:hover>a ' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_nav_menu_hover_bg_color, '' ) ) ? $killar_nav_menu_hover_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_nav_menu_text_hover_color, '' ) ) ? $killar_nav_menu_text_hover_color : '',
			) ) );
			
			/**
			* Megamenu
			*/
			$output .= killarwt_output_css( array( '.kwt-menu>li .kwt-megamenu' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_nav_megamenu_bg_color, '' ) ) ? $killar_nav_megamenu_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_nav_megamenu_text_color, '' ) ) ? $killar_nav_megamenu_text_color : '',
			) ) );
		
			/**
			* Megamenu Columns Heading
			*/
			$output .= killarwt_output_css( array( '.mega-menu.lvl-1>li> a' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_nav_megamenu_cols_heading_color, '' ) ) ? $killar_nav_megamenu_cols_heading_color : '',
			) ) );
			
			/**
			* Megamenu Link
			*/
			$output .= killarwt_output_css( array( '.kwt-menu li a' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_nav_megamenu_link_color, '' ) ) ? $killar_nav_megamenu_link_color : '',
				'border-color' => ( !killarwt_opt_chk_def_val( $killar_nav_megamenu_border_color, '' ) ) ? $killar_nav_megamenu_border_color : '',
			) ) );
			
			/**
			* Megamenu Link Hover
			*/
			$output .= killarwt_output_css( array( '.kwt-menu li a:hover, .kwt-menu > li:hover > a' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_nav_megamenu_link_hover_color, '' ) ) ? $killar_nav_megamenu_link_hover_color : '',
			) ) );
						
			return $output;

		}

	}

endif;

return new KillarWT_Header_Customizer();