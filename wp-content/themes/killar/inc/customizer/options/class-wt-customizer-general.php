<?php
/**
 * General Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_General_Customizer' ) ) :

	class KillarWT_General_Customizer {

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
			 * General Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_general_panel',  array(
				'title' 			=> __( 'General', 'killar' ),
				'priority' 			=> '-3000',
				'panel' 			=> 'killar_options_panel',
			) ) );
		
			/**
			 * General Settings: Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_general_settings' , array(
				'title' 			=> __( 'General Settings', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_general_panel',
			) );

			/**
			 * Layouts : Styles
			 */
			$wp_customize->add_setting( 'killar_main_layout_style', array(
				'default'           	=> 'wide',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_main_layout_style', array(
				'label'	   				=> __( 'Layout Style', 'killar' ),
				'section'  				=> 'killar_general_settings',
				'settings' 				=> 'killar_main_layout_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'wide' 		        => __( 'Wide', 'killar' ),
					'boxed' 			=> __( 'Boxed', 'killar' ),
					'predefine' 		=> __( 'Predefine', 'killar' ),
				),
			) ) );
			
			/**
			 * Layouts : Container Width
			 */
			$wp_customize->add_setting( 'killar_container_width', array(
				'default'          		=>  1200,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_container_width', array(
				'label'   				=> __( 'Container Width (px)', 'killar' ),
				'section' 				=> 'killar_general_settings',
				'settings'  			=> 'killar_container_width',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 1980,
											'step' => 1,
										),
				'active_callback' 		=> 'ctm_killar_is_container_width_active',
			) ) );
			
			/**
			 * Layouts : Boxed Layout Width
			 */
			$wp_customize->add_setting( 'killar_boxed_layout_width', array(
				'default'          		=>  1200,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_boxed_layout_width', array(
				'label'   				=> __( 'Boxed Width (px)', 'killar' ),
				'section' 				=> 'killar_general_settings',
				'settings'  			=> 'killar_boxed_layout_width',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 1980,
											'step' => 1,
										),
				'active_callback' 		=> 'ctm_killar_is_boxed_layout_active',
			) ) );
			
			/**
			 * General Settings : Outer Background Color
			 */
			$wp_customize->add_setting( 'killar_boxed_outer_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_boxed_outer_bg_color', array(
				'label'   			    => esc_html__( 'Outer Background Color', 'killar' ),
				'section'  			    => 'killar_general_settings',
				'settings' 			    => 'killar_boxed_outer_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_is_boxed_layout_active',
			) ) );
			
			/**
			 * General Settings : Inner Background Color
			 */
			$wp_customize->add_setting( 'killar_boxed_inner_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_boxed_inner_bg_color', array(
				'label'   			    => esc_html__( 'Inner Background Color', 'killar' ),
				'section'  			    => 'killar_general_settings',
				'settings' 			    => 'killar_boxed_inner_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_is_boxed_layout_active',
			) ) );
			
			/**
			 * General : Page Heading ================================
			 */
			$wp_customize->add_setting( 'killar_page_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_page_heading', array(
				'label'	   				=> __( 'Pages', 'killar' ),
				'section'  				=> 'killar_general_settings',
				'settings' 				=> 'killar_page_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Layout
			 */
			$wp_customize->add_setting( 'killar_page_layout', array(
				'default'        	    => 'full-width',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Radio_Image_Control( $wp_customize, 'killar_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'killar' ),
				'choices' 				=> array(
											'full-width'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => KILLARWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'killar_general_settings',
				'settings' 				=> 'killar_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * General Styling: Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_general_styling' , array(
				'title' 			=> __( 'General Styling', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_general_panel',
			) );
			
			/**
			 * Styling
			 */
			$wp_customize->add_setting( 'killar_customzer_styling', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'head',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );
			
			$wp_customize->add_control( 'killar_customzer_styling', array(
				'label'	   				=> esc_html__( 'Styling Options Location', 'killar' ),
				'description'	   		=> esc_html__( 'If you choose Custom File, a CSS file will be created in your uploads folder.', 'killar' ),
				'type'              	=> 'radio',
				'section'  				=> 'killar_general_styling',
				'settings' 				=> 'killar_customzer_styling',
				'priority'          	=> 10,
				'choices'           	=> array(
					'head' 		=> esc_html__( 'WP Head', 'killar' ),
					'file' 		=> esc_html__( 'Custom File', 'killar' ),
				)
			) );


			/**
			 * General Styling : Add Currency Flag Style
			 */
			$wp_customize->add_setting( 'killar_currency_flags_style', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_currency_flags_style', array(
				'label'	   				=> __( 'Add Currency Flags Style', 'killar' ),
				'description'	   		=> __( 'Add currency flags like home version 15.', 'killar' ),
				'section'  				=> 'killar_general_styling',
				'settings' 				=> 'killar_currency_flags_style',
				'priority' 				=> 10,
			) ) );
			

			/**
			 * General Styling : General Styling Heading ================================
			 */
			$wp_customize->add_setting( 'killar_general_styling_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_general_styling_heading', array(
				'label'	   				=> __( 'General Styling', 'killar' ),
				'section'  				=> 'killar_general_styling',
				'settings' 				=> 'killar_general_styling_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * General Styling : Theme Color
			 */
			$wp_customize->add_setting( 'killar_gen_sty_theme_color', array(
				'default'               => '#008aff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_sty_theme_color', array(
				'label'   			    => esc_html__( 'Theme Color', 'killar' ),
				'section'  			    => 'killar_general_styling',
				'settings' 			    => 'killar_gen_sty_theme_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Theme Text Color
			 */
			$wp_customize->add_setting( 'killar_gen_sty_theme_text_color', array(
				'default'               => '#666666',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_sty_theme_text_color', array(
				'label'   			    => esc_html__( 'Theme Text Color', 'killar' ),
				'section'  			    => 'killar_general_styling',
				'settings' 			    => 'killar_gen_sty_theme_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Theme Link Color
			 */
			$wp_customize->add_setting( 'killar_gen_sty_theme_link_color', array(
				'default'               => '#008aff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_sty_theme_link_color', array(
				'label'   			    => esc_html__( 'Link Color', 'killar' ),
				'section'  			    => 'killar_general_styling',
				'settings' 			    => 'killar_gen_sty_theme_link_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Theme Link Hover Color
			 */
			$wp_customize->add_setting( 'killar_gen_sty_theme_link_hover_color', array(
				'default'               => '#0172e2',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_sty_theme_link_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'killar' ),
				'section'  			    => 'killar_general_styling',
				'settings' 			    => 'killar_gen_sty_theme_link_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Site Background Heading ================================
			 */
			$wp_customize->add_setting( 'killar_general_site_bg_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_general_site_bg_heading', array(
				'label'	   				=> __( 'Site Background', 'killar' ),
				'section'  				=> 'killar_general_styling',
				'settings' 				=> 'killar_general_site_bg_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * General Settings : Background Color
			 */
			$wp_customize->add_setting( 'killar_gen_sty_site_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_sty_site_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_general_styling',
				'settings' 			    => 'killar_gen_sty_site_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Background Image
			 */
			$wp_customize->add_setting( 'killar_gen_sty_site_bg_image', array(
				'default'				=>  '',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_gen_sty_site_bg_image', array(
				'label'	   				=> __( 'Background Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for site background', 'killar' ),
				'section'  				=> 'killar_general_styling',
				'settings' 				=> 'killar_gen_sty_site_bg_image',
				'priority' 				=> 10,
			) ) );


			/**
			 * General: Buttons Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_general_buttons' , array(
				'title' 			=> __( 'Buttons', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_general_panel',
			) );

			/**
			 * Buttons : General Buttons Heading ================================
			 */
			$wp_customize->add_setting( 'killar_general_buttons_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_general_buttons_heading', array(
				'label'	   				=> __( 'General Buttons', 'killar' ),
				'section'  				=> 'killar_general_buttons',
				'settings' 				=> 'killar_general_buttons_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Buttons : Background Color
			 */
			$wp_customize->add_setting( 'killar_gen_btns_bg_color', array(
				'default'               => '#0264d6',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_btns_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_general_buttons',
				'settings' 			    => 'killar_gen_btns_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Background Color:hover
			 */
			$wp_customize->add_setting( 'killar_gen_btns_bg_hover_color', array(
				'default'               => '#188ef1',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_btns_bg_hover_color', array(
				'label'   			    => esc_html__( 'Background Hover Color', 'killar' ),
				'section'  			    => 'killar_general_buttons',
				'settings' 			    => 'killar_gen_btns_bg_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Text Color
			 */
			$wp_customize->add_setting( 'killar_gen_btns_text_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_btns_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'killar' ),
				'section'  			    => 'killar_general_buttons',
				'settings' 			    => 'killar_gen_btns_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Text Color:hover
			 */
			$wp_customize->add_setting( 'killar_gen_btns_text_hover_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_btns_text_hover_color', array(
				'label'   			    => esc_html__( 'Text Hover Color', 'killar' ),
				'section'  			    => 'killar_general_buttons',
				'settings' 			    => 'killar_gen_btns_text_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Border Color
			 */
			$wp_customize->add_setting( 'killar_gen_btns_border_color', array(
				'default'               => '#0264d6',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_btns_border_color', array(
				'label'   			    => esc_html__( 'Border Color', 'killar' ),
				'section'  			    => 'killar_general_buttons',
				'settings' 			    => 'killar_gen_btns_border_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Border Color:hover
			 */
			$wp_customize->add_setting( 'killar_gen_btns_border_hover_color', array(
				'default'               => '#188ef1',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_gen_btns_border_hover_color', array(
				'label'   			    => esc_html__( 'Border Hover Color', 'killar' ),
				'section'  			    => 'killar_general_buttons',
				'settings' 			    => 'killar_gen_btns_border_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * General: Buttons Sections
			 */
			$wp_customize->add_section( 'killar_general_buttons' , array(
				'title' 			=> __( 'Buttons', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_general_panel',
			) );
			
			
			/**
			 * General: Preloader Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_general_preloader_section' , array(
				'title' 			=> __( 'Preloader', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_general_panel',
			) );
			
			/**
			 * Preloader : Show Preloader
			 */
			$wp_customize->add_setting( 'killar_general_preloader', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_general_preloader', array(
				'label'	   				=> __( 'Show Preloader', 'killar' ),
				'section'  				=> 'killar_general_preloader_section',
				'settings' 				=> 'killar_general_preloader',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Preloader : Type
			 */
			$wp_customize->add_setting( 'killar_general_preloader_type', array(
				'default'           	=> 'predefine',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_general_preloader_type', array(
				'label'	   				=> __( 'Preloader Type', 'killar' ),
				'section'  				=> 'killar_general_preloader_section',
				'settings' 				=> 'killar_general_preloader_type',
				'priority' 				=> 10,
				'choices' 				=> array(
											'predefine' => __( 'Predefine', 'killar' ),
											'custom' => __( 'Custom', 'killar' ),
										),
				'active_callback' 		=> 'ctm_killar_general_preloader',
			) ) );
			
			/**
			 * Preloader : Color
			 */
			$wp_customize->add_setting( 'killar_general_preloader_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_general_preloader_color', array(
				'label'   			    => esc_html__( 'Preloader Color', 'killar' ),
				'section'  			    => 'killar_general_preloader_section',
				'settings' 			    => 'killar_general_preloader_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_general_preloader_type_is_predefine',
			) ) );
			
			/**
			 * Preloader : Custom
			 */
			$wp_customize->add_setting( 'killar_general_preloader_custom_bg_image', array(
				'default'				=>  '',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_general_preloader_custom_bg_image', array(
				'label'	   				=> __( 'Preloader Image', 'killar' ),
				'section'  				=> 'killar_general_preloader_section',
				'settings' 				=> 'killar_general_preloader_custom_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_general_preloader_type_is_custom',
			) ) );


			/**
			 * General: Newsletter Popup Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_general_newsletter_popup_section' , array(
				'title' 			=> __( 'Newsletter Popup', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_general_panel',
			) );

			/**
			* Newsletter Popup
			*/
			$wp_customize->add_setting( 'killar_general_newsletter_popup_layout', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_general_newsletter_popup_layout', array(
				'label'	   				=> __( 'Newsletter Popup Layout', 'killar' ),
				'type' 					=> 'select',
				'description'	   		=> __( 'Select newsletter popup layout from Layouts Builder', 'killar' ),
				'section'  				=> 'killar_general_newsletter_popup_section',
				'settings' 				=> 'killar_general_newsletter_popup_layout',
				'priority' 				=> 10,
				'choices' 				=> killarwt_newsletter_popup_layout_list(),
				
			) ) );

			/**
			 * Newsletter Popup: Delay
			 */
			$wp_customize->add_setting( 'killar_general_newsletter_popup_delay', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> '3600',
			) );

			$wp_customize->add_control( 'killar_general_newsletter_popup_delay', array(
				'label' 			=> esc_html__( 'Newsletter Delay', 'killar' ),
				'description' 		=> esc_html__( 'Add delay time in millisecond.', 'killar' ),
				'section' 			=> 'killar_general_newsletter_popup_section',
				'settings' 			=> 'killar_general_newsletter_popup_delay',
				'priority' 			=> 10,
				'active_callback' 	=> 'ctm_killar_general_newsletter_popup_is_enabled',
			) );

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {

			$killar_boxed_layout_width								= get_theme_mod( 'killar_boxed_layout_width', '1170px' );
			
			$killar_boxed_outer_bg_color							= get_theme_mod( 'killar_boxed_outer_bg_color', '' );
			$killar_boxed_inner_bg_color							= get_theme_mod( 'killar_boxed_inner_bg_color', '' );
			
			$killar_gen_sty_theme_color								= killarwt_theme_mod( 'killar_gen_sty_theme_color', '#008aff' );
			$killar_gen_sty_theme_text_color						= get_theme_mod( 'killar_gen_sty_theme_text_color', '#666666' );
			$killar_gen_sty_site_bg_color							= get_theme_mod( 'killar_gen_sty_site_bg_color', '' );
			$killar_gen_sty_site_bg_image							= get_theme_mod( 'killar_gen_sty_site_bg_image', '' );
			$killar_gen_sty_theme_link_color						= killarwt_theme_mod( 'killar_gen_sty_theme_link_color', '#008aff' );
			$killar_gen_sty_theme_link_hover_color					= killarwt_theme_mod( 'killar_gen_sty_theme_link_hover_color', '#0172e2' );

			$killar_gen_btns_bg_color								= killarwt_theme_mod( 'killar_gen_btns_bg_color', '#0264d6' );
			$killar_gen_btns_bg_hover_color							= killarwt_theme_mod( 'killar_gen_btns_bg_hover_color', '#188ef1' );
			$killar_gen_btns_text_color								= get_theme_mod( 'killar_gen_btns_text_color', '#ffffff' );
			$killar_gen_btns_text_hover_color						= killarwt_theme_mod( 'killar_gen_btns_text_hover_color', '#ffffff' );
			$killar_gen_btns_border_color							= killarwt_theme_mod( 'killar_gen_btns_border_color', '#0264d6' );
			$killar_gen_btns_border_hover_color						= killarwt_theme_mod( 'killar_gen_btns_border_hover_color', '#188ef1' );
			
			$killar_general_preloader								= ctm_killar_general_preloader();
			$killar_general_preloader_color							= killarwt_theme_mod( 'killar_general_preloader_color', '' );
			
			$killar_container_width 								= killarwt_container_width();
			
			
			/**
			* Variable
			*/
			$output .= killarwt_output_css( array( ':root' => array(
				'--container-width' => $killar_container_width.'px',
				'--theme-color' => $killar_gen_sty_theme_color,
				'--theme-text-color' => $killar_gen_sty_theme_text_color,
				'--theme-link-color' => $killar_gen_sty_theme_link_color,
				'--theme-link-hcolor' => $killar_gen_sty_theme_link_hover_color,
				'--btn-bg-color' => $killar_gen_btns_bg_color,
				'--btn-bg-hcolor' => $killar_gen_btns_bg_hover_color,
				'--btn-text-color' => $killar_gen_btns_text_color,
				'--btn-text-hcolor' => $killar_gen_btns_text_hover_color,
				'--btn-border-color' => $killar_gen_btns_border_color,
				'--btn-border-hcolor' => $killar_gen_btns_border_hover_color,
			) ) );	
			
			/**
			* Preloader
			*/
			if( ctm_killar_general_preloader() ) {
				$output .= killarwt_output_css( array( '#loader-wrapper #loader' => array(
					'background' => ( !killarwt_opt_chk_def_val( $killar_general_preloader_color ) ) ? $killar_general_preloader_color : '',
				) ) );
			}
			
			/**
			* General Settings
			*/
			if( killarwt_main_layout_style() == 'boxed' ) {
				
				$output .= killarwt_output_css( array( '.boxed-layout .main-wrap' => array(
					'max-width' => ( !killarwt_opt_chk_def_val( $killar_boxed_layout_width, '' ) ) ? $killar_boxed_layout_width.'px' : '',
					'background-color' => ( !killarwt_opt_chk_def_val( $killar_boxed_inner_bg_color, '' ) ) ? $killar_boxed_inner_bg_color : '',
				) ) );
				
				$output .= killarwt_output_css( array( 'body.boxed-layout' => array(
					'background-color' => ( !killarwt_opt_chk_def_val( $killar_boxed_outer_bg_color, '' ) ) ? $killar_boxed_outer_bg_color : '',
				) ) );
			}
			
			/**
			* General Styling
			*/
			$output .= killarwt_output_css( array( 'body' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_gen_sty_site_bg_color, '' ) ) ? $killar_gen_sty_site_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_gen_sty_theme_text_color, '#666666' ) ) ? $killar_gen_sty_theme_text_color : '',
				'background-image' => ( !empty( $killar_gen_sty_site_bg_image ) && !killarwt_opt_chk_def_val( $killar_gen_sty_site_bg_image, '' ) ) ? 'url(' . $killar_gen_sty_site_bg_image .')' : '',
			) ) );
			
			return $output;
		}
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( get_home_url() ) ) { ?>
					wp.customize.section( 'killar_general_settings', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_home_url() ); ?>" );
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

return new KillarWT_General_Customizer();