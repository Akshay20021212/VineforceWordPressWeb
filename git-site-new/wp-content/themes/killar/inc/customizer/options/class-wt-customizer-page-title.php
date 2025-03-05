<?php
/**
 * Header Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Page_Title_Customizer' ) ) :

	class KillarWT_Page_Title_Customizer {

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
			 * Page Title : Section
			 */
			$wp_customize->add_section( 'killar_paget_title_section' , array(
				'title' 			=> __( 'Page Title', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_options_panel',
			) );
			
			/**
			 * Page Title : Show Page Title Section
			 */
			$wp_customize->add_setting( 'killar_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_page_title_section', array(
				'label'	   				=> __( 'Show Page Title', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Title : Style
			 */
			$wp_customize->add_setting( 'killar_page_title_style', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_page_title_style', array(
				'label'	   				=> __( 'Page Title Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'left' 			=> __( 'Left Alignment', 'killar' ),
					'centered' 		=> __( 'Center Alignment', 'killar' ),
					'right' 		=> __( 'Right Alignment', 'killar' ),
				),
			) ) );

			/**
			 * Page Title : Show Page Title
			 */
			$wp_customize->add_setting( 'killar_page_title', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_page_title', array(
				'label'	   				=> __( 'Show Page Title Heading', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title',
				'priority' 				=> 10,
			) ) );
			

			/**
			 * Page Title : Padding
			 */
			$wp_customize->add_setting( 'killar_page_title_desktop_top_padding', array(
				'default' 				=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_desktop_right_padding', array(
				'default'	 			=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_desktop_bottom_padding', array(
				'default' 				=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_desktop_left_padding', array(
				'default'	 			=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_tablet_top_padding', array(
				'default' 				=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_tablet_right_padding', array(
				'default'	 			=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_tablet_bottom_padding', array(
				'default' 				=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_tablet_left_padding', array(
				'default'	 			=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_mobile_top_padding', array(
				'default' 				=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_mobile_right_padding', array(
				'default'	 			=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_mobile_bottom_padding', array(
				'default' 				=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );

			$wp_customize->add_setting( 'killar_page_title_mobile_left_padding', array(
				'default'	 			=> '',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'killarwt_sanitize_number',
			) );
			

			$wp_customize->add_control( new KillarWT_Customizer_Dimensions_Control( $wp_customize, 'killar_page_title_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'killar' ),
				'section'  				=> 'killar_paget_title_section',				
				'settings'  		    => array(
					'desktop_top' 		=> 'killar_page_title_desktop_top_padding',
					'desktop_right' 	=> 'killar_page_title_desktop_right_padding',
					'desktop_bottom' 	=> 'killar_page_title_desktop_bottom_padding',
					'desktop_left' 		=> 'killar_page_title_desktop_left_padding',
					'tablet_top' 		=> 'killar_page_title_tablet_top_padding',
					'tablet_right' 		=> 'killar_page_title_tablet_right_padding',
					'tablet_bottom' 	=> 'killar_page_title_tablet_bottom_padding',
					'tablet_left' 		=> 'killar_page_title_tablet_left_padding',
					'mobile_top' 		=> 'killar_page_title_mobile_top_padding',
					'mobile_right' 		=> 'killar_page_title_mobile_right_padding',
					'mobile_bottom' 	=> 'killar_page_title_mobile_bottom_padding',
					'mobile_left' 		=> 'killar_page_title_mobile_left_padding',
				),
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Title : Background Style
			 */
			
			$wp_customize->add_setting( 'killar_page_title_background', array(
				'default'           	=> 'image',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_page_title_background', array(
				'label'	   				=> __( 'Background Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
					'hide' 					=> __( 'Hide', 'killar' ),
					'image' 				=> __( 'Image', 'killar' ),
					'scene' 				=> __( 'Scene', 'killar' ),
				),
			) ) );

			/**
			 * Page Title : Background Image
			 */
			$wp_customize->add_setting( 'killar_page_title_bg_image', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
				'transport'				=> 'postMessage'
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_page_title_bg_image', array(
				'label'	   				=> __( 'Background Image', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Background Position
			 */
			$wp_customize->add_setting( 'killar_page_title_bg_position', array(
				'default'           	=> 'center center',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
				'transport'				=> 'postMessage'
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_page_title_bg_position', array(
				'label'	   				=> __( 'Background Position', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_bg_position',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'killar' ),
					'top left' 		=> __( 'Top Left', 'killar' ),
					'top center' 	=> __( 'Top Center', 'killar' ),
					'top right' 	=> __( 'Top Right', 'killar' ),
					'center left' 	=> __( 'Center Left', 'killar' ),
					'center center' => __( 'Center Center', 'killar' ),
					'center right' 	=> __( 'Center Right', 'killar' ),
					'bottom left' 	=> __( 'Bottom Left', 'killar' ),
					'bottom center' => __( 'Bottom Center', 'killar' ),
					'bottom right' 	=> __( 'Bottom Right', 'killar' ),
				),
				'active_callback' 		=> 'ctm_killar_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Background Attachment
			 */
			$wp_customize->add_setting( 'killar_page_title_bg_attachment', array(
				'default'           	=> 'initial',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
				'transport'				=> 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_page_title_bg_attachment', array(
				'label'	   				=> __( 'Background Attachment', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_bg_attachment',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'killar' ),
					'Fixed' 		=> __( 'fixed', 'killar' ),
					'Scroll' 		=> __( 'scroll', 'killar' ),
				),
				'active_callback' 		=> 'ctm_killar_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Repeat
			 */
			$wp_customize->add_setting( 'killar_page_title_bg_repeat', array(
				'default'           	=> 'no-repeat',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
				'transport'				=> 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_page_title_bg_repeat', array(
				'label'	   				=> __( 'Background Repeat', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_bg_repeat',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'killar' ),
					'no-repeat' 	=> __( 'No-repeat', 'killar' ),
					'repeat' 		=> __( 'Repeat', 'killar' ),
					'repeat-x' 		=> __( 'Repeat-x', 'killar' ),
					'repeat-y' 		=> __( 'Repeat-y', 'killar' ),
				),
				'active_callback' 		=> 'ctm_killar_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Background Size
			 */
			$wp_customize->add_setting( 'killar_page_title_bg_size', array(
				'default'           	=> 'cover',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
				'transport'				=> 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_page_title_bg_size', array(
				'label'	   				=> __( 'Background Size', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_bg_size',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'killar' ),
					'auto' 	=> __( 'Auto', 'killar' ),
					'contain' 		=> __( 'Contain', 'killar' ),
					'cover' 		=> __( 'Cover', 'killar' ),
					'unset' 		=> __( 'Unset', 'killar' ),
				),
				'active_callback' 		=> 'ctm_killar_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Overlay Opacity
			 */
			$wp_customize->add_setting( 'killar_page_title_bg_overlay_opacity', array(
				'default'          		=>  '0',
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_page_title_bg_overlay_opacity', array(
				'label'   				=> __( 'Background Overlay Opacity', 'killar' ),
				'section' 				=> 'killar_paget_title_section',
				'settings'  			=> 'killar_page_title_bg_overlay_opacity',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 1,
											'step' => 0.1,
										),
				'active_callback' 		=> 'ctm_killar_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Overlay Background Color
			 */
			$wp_customize->add_setting( 'killar_page_title_overlay_bg_color', array(
				'default'               => '#000000',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_page_title_overlay_bg_color', array(
				'label'   			    => esc_html__( 'Overlay Background Color', 'killar' ),
				'section'  			    => 'killar_paget_title_section',
				'settings' 			    => 'killar_page_title_overlay_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_page_title_background_enabled',
			) ) );
			
			/**
			 * Page Title : Scene
			 */
			$wp_customize->add_setting( 'killar_page_title_scene', array(
				'default'           	=> 'style-1',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_page_title_scene', array(
				'label'	   				=> __( 'Scene', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_scene',
				'priority' 				=> 10,
				'choices' 				=> array(
					'hide' 			=> __( 'Hide', 'killar' ),
					'style-1' 		=> __( 'Style - 1 (Default)', 'killar' ),
					'style-2' 		=> __( 'Style - 2', 'killar' ),
				),
				'active_callback' 		=> 'ctm_killar_page_title_scene_enabled',
			) ) );
			
			/**
			 * Breadcrumbs Heading ================================
			 */
			$wp_customize->add_setting( 'killar_page_title_breadcrumbs_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_page_title_breadcrumbs_heading', array(
				'label'	   				=> __( 'Breadcrumbs', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_breadcrumbs_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Breadcrumbs : Enable/Disable
			 */
			$wp_customize->add_setting( 'killar_page_title_breadcrumbs_display', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_page_title_breadcrumbs_display', array(
				'label'	   				=> __( 'Enable Breadcrumbs', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_breadcrumbs_display',
				'priority' 				=> 10,
			) ) );

			/**
			 * Breadcrumbs : Show Item Title
			 */
			$wp_customize->add_setting( 'killar_page_title_breadcrumbs_item_title_display', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_page_title_breadcrumbs_item_title_display', array(
				'label'	   				=> __( 'Show Item Title', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_breadcrumbs_item_title_display',
				'priority' 				=> 10,
			) ) );

			/**
			 * Breadcrumbs : Home Item
			 */
			$wp_customize->add_setting( 'killar_page_title_breadcrumb_home_style', array(
				'default'           	=> 'text',
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Buttonset_Control( $wp_customize, 'killar_page_title_breadcrumb_home_style', array(
				'label'	   				=> __( 'Home Item Style', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_breadcrumb_home_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'icon' 				=> __( 'Icon', 'killar' ),
											'text' 				=> __( 'Text', 'killar' ),
										),
				'active_callback' 		=> 'killarwt_page_title_breadcrumbs_display',
			) ) );

			/**
			 * Page Title : Style Heading ================================
			 */
			$wp_customize->add_setting( 'killar_page_title_styling_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_page_title_styling_heading', array(
				'label'	   				=> __( 'Styling', 'killar' ),
				'section'  				=> 'killar_paget_title_section',
				'settings' 				=> 'killar_page_title_styling_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Title : Font Size
			 */
			$wp_customize->add_setting( 'killar_page_title_font_size', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> '',
			) );

			$wp_customize->add_control( 'killar_page_title_font_size', array(
				'label' 			=> esc_html__( 'Page Title Font Size', 'killar' ),
				'description' 		=> esc_html__( 'You can add size in (px,em,%)', 'killar' ),
				'section' 			=> 'killar_paget_title_section',
				'settings' 			=> 'killar_page_title_font_size',
				'priority' 			=> 10,
			) );

			/**
			 * Page Title : Background Color
			 */
			$wp_customize->add_setting( 'killar_page_title_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_page_title_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_paget_title_section',
				'settings' 			    => 'killar_page_title_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * Page Title : Text Color
			 */
			$wp_customize->add_setting( 'killar_page_title_text_color', array(
				'default'               => '#008aff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_page_title_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'killar' ),
				'section'  			    => 'killar_paget_title_section',
				'settings' 			    => 'killar_page_title_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * Page Title : Separator Color
			 */
			$wp_customize->add_setting( 'killar_page_title_separator_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_page_title_separator_color', array(
				'label'   			    => esc_html__( 'Separator Color', 'killar' ),
				'section'  			    => 'killar_paget_title_section',
				'settings' 			    => 'killar_page_title_separator_color',
				'priority'              => 10,
			) ) );

			/**
			 * Page Title : Link Color
			 */
			$wp_customize->add_setting( 'killar_page_title_link_color', array(
				'default'               => '#008aff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_page_title_link_color', array(
				'label'   			    => esc_html__( 'Link Color', 'killar' ),
				'section'  			    => 'killar_paget_title_section',
				'settings' 			    => 'killar_page_title_link_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Page Title : Link Hover Color
			 */
			$wp_customize->add_setting( 'killar_page_title_link_hover_color', array(
				'default'               => '#0172e2',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_page_title_link_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'killar' ),
				'section'  			    => 'killar_paget_title_section',
				'settings' 			    => 'killar_page_title_link_hover_color',
				'priority'              => 10,
			) ) );

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			$killar_page_title_bg_style							= killarwt_page_title_background();get_theme_mod( 'killar_page_title_bg_style', 'scene' );
			$killar_page_title_desktop_top_padding				= get_theme_mod( 'killar_page_title_desktop_top_padding', '' );
			$killar_page_title_desktop_right_padding			= get_theme_mod( 'killar_page_title_desktop_right_padding', '' );
			$killar_page_title_desktop_bottom_padding			= get_theme_mod( 'killar_page_title_desktop_bottom_padding', '' );
			$killar_page_title_desktop_left_padding				= get_theme_mod( 'killar_page_title_desktop_left_padding', '' );
			$killar_page_title_tablet_top_padding				= get_theme_mod( 'killar_page_title_tablet_top_padding', '' );
			$killar_page_title_tablet_right_padding				= get_theme_mod( 'killar_page_title_tablet_right_padding', '' );
			$killar_page_title_tablet_bottom_padding			= get_theme_mod( 'killar_page_title_tablet_bottom_padding', '' );
			$killar_page_title_tablet_left_padding				= get_theme_mod( 'killar_page_title_tablet_left_padding', '' );
			$killar_page_title_mobile_top_padding				= get_theme_mod( 'killar_page_title_mobile_top_padding', '' );
			$killar_page_title_mobile_right_padding				= get_theme_mod( 'killar_page_title_mobile_right_padding', '' );
			$killar_page_title_mobile_bottom_padding			= get_theme_mod( 'killar_page_title_mobile_bottom_padding', '' );
			$killar_page_title_mobile_left_padding				= get_theme_mod( 'killar_page_title_mobile_left_padding', '' );
			$killar_page_title_font_size						= killarwt_page_title_font_size();
			$killar_page_title_bg_color							= killarwt_page_title_bg_color();
			$killar_page_title_text_color						= killarwt_page_title_text_color();
			$killar_page_title_separator_color					= killarwt_page_title_separator_color();
			$killar_page_title_link_color						= killarwt_page_title_link_color();
			$killar_page_title_link_hover_color					= killarwt_page_title_link_hover_color();
			$killar_page_title_bg_image							= killarwt_page_title_bg_image();
			$killar_page_title_bg_position						= killarwt_page_title_bg_position();
			$killar_page_title_bg_attachment					= killarwt_page_title_bg_attachment();
			$killar_page_title_bg_repeat						= killarwt_page_title_bg_repeat();
			$killar_page_title_bg_size							= killarwt_page_title_bg_size();
			$killar_page_title_bg_overlay_opacity				= killarwt_page_title_bg_overlay_opacity();
			$killar_page_title_overlay_bg_color					= killarwt_page_title_overlay_bg_color();

			/**
			* Desktop Page title padding
			*/
			$page_title_wrap_ar = array();
			if ( ((!empty($killar_page_title_desktop_top_padding) && $killar_page_title_desktop_top_padding != '' ))
			||	((!empty($killar_page_title_desktop_right_padding) && $killar_page_title_desktop_right_padding != '' ))
			||	((!empty($killar_page_title_desktop_bottom_padding) && $killar_page_title_desktop_bottom_padding != '' ))
			||	((!empty($killar_page_title_desktop_left_padding) && $killar_page_title_desktop_left_padding != ''))
			){
				$page_title_wrap_ar['.page-title-wrap'] = array(
					'padding' => $killar_page_title_desktop_top_padding . 'px ' . $killar_page_title_desktop_right_padding . 'px ' . $killar_page_title_desktop_bottom_padding . 'px ' . $killar_page_title_desktop_left_padding . 'px; ',
				);
			}
			
			$page_title_wrap_ar['.page-title-wrap']['background-color'] = ( !killarwt_opt_chk_def_val( $killar_page_title_bg_color , '' ) ) ? $killar_page_title_bg_color : '';
			$page_title_wrap_ar['.page-title-wrap']['color'] = ( !killarwt_opt_chk_def_val( $killar_page_title_text_color , '' ) ) ? $killar_page_title_text_color : '';
			if( !empty( $page_title_wrap_ar ) ) {
				$output .= killarwt_output_css( $page_title_wrap_ar );
			}

			/**
			* Tablet Page title padding
			*/
			if ( ((!empty($killar_page_title_tablet_top_padding) && $killar_page_title_tablet_top_padding != ''))
			||	((!empty($killar_page_title_tablet_right_padding) && $killar_page_title_tablet_right_padding != ''))
			||	((!empty($killar_page_title_tablet_bottom_padding) && $killar_page_title_tablet_bottom_padding != ''))
			||	((!empty($killar_page_title_tablet_left_padding) && $killar_page_title_tablet_left_padding != ''))
			){
				$output .= killarwt_output_css( array( '.page-title-wrap' => array(
					'padding' => $killar_page_title_tablet_top_padding . 'px ' . $killar_page_title_tablet_right_padding . 'px ' . $killar_page_title_tablet_bottom_padding . 'px ' . $killar_page_title_tablet_left_padding . 'px;',
				) ), 767, 1024 );

				
			}

			/**
			* Mobile Page title padding
			*/
			if ( ((!empty($killar_page_title_mobile_top_padding) && $killar_page_title_mobile_top_padding != ''))
			||	((!empty($killar_page_title_mobile_right_padding) && $killar_page_title_mobile_right_padding != ''))
			||	((!empty($killar_page_title_mobile_bottom_padding) && $killar_page_title_mobile_bottom_padding != ''))
			||	((!empty($killar_page_title_mobile_left_padding) && $killar_page_title_mobile_left_padding != ''))
			){
				$output .= killarwt_output_css( array( '.page-title-wrap' => array(
					'padding' => $killar_page_title_mobile_top_padding . 'px ' . $killar_page_title_mobile_right_padding . 'px ' . $killar_page_title_mobile_bottom_padding . 'px ' . $killar_page_title_mobile_left_padding . 'px;',
				) ), '', 768 );
			}

			/**
			* Breadcrumbs : Separator color
			*/
			$output .= killarwt_output_css( array( '.breadcrumb-sep' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_page_title_separator_color, '' ) ) ? $killar_page_title_separator_color : '',
			) ) );

			/**
			* Page title link color
			*/
			$output .= killarwt_output_css( array( '.page-title-wrap a:not(:hover)' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_page_title_link_color, '' ) ) ? $killar_page_title_link_color : '',
			) ) );

			/**
			* Page Title : Font Size
			*/
			$output .= killarwt_output_css( array( '.page-header-title' => array(
				'font-size' => ( !killarwt_opt_chk_def_val( $killar_page_title_font_size, '' ) ) ? $killar_page_title_font_size : '',
			) ) );
			
			/**
			* Page Title : Is Background Image
			*/
			
			if ( in_array($killar_page_title_bg_style, array('featured_image', 'image', 'custom')) ) {
				$output .= killarwt_output_css( array( '.bgimg-page-header' => array(
					'background-image' => ( !empty( $killar_page_title_bg_image ) ) ? 'url('.$killar_page_title_bg_image.')' : '',
					'background-position' => ( !killarwt_opt_chk_def_val( $killar_page_title_bg_position , 'center center' ) ) ? $killar_page_title_bg_position : '',
					'background-attachment' => ( !killarwt_opt_chk_def_val( $killar_page_title_bg_attachment, 'initial' ) ) ? $killar_page_title_bg_attachment : '',
					'background-repeat' => ( !killarwt_opt_chk_def_val( $killar_page_title_bg_repeat, 'no-repeat' ) ) ? $killar_page_title_bg_repeat : '',
					'background-size' => ( !killarwt_opt_chk_def_val( $killar_page_title_bg_size, 'cover' ) ) ? $killar_page_title_bg_size : '',
				) ) );
			}
	
			/**
			* Page Title : Background Image Overlay
			*/
			if ( in_array($killar_page_title_bg_style, array('featured_image', 'image', 'custom')) ) {
				$output .= killarwt_output_css( array( '.page-header-bgimg-overlay' => array(
					'background-color' => ( !killarwt_opt_chk_def_val( $killar_page_title_overlay_bg_color, '#000000' ) ) ? $killar_page_title_overlay_bg_color : '',
					'opacity' => ( $killar_page_title_bg_overlay_opacity != 0 ) ? $killar_page_title_bg_overlay_opacity : '',
				) ) );
			}
			
			return $output;

		}
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			$posts_id = get_posts( array('post_type' => 'post', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( $posts_id[0] ) ) { ?>
					wp.customize.section( 'killar_paget_title_section', function( section ) {
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

return new KillarWT_Page_Title_Customizer();