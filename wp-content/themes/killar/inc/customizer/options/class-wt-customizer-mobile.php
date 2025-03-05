<?php
/**
 * Blog/Post Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Mobile_Customizer' ) ) :

	class KillarWT_Mobile_Customizer {

		public function __construct() {

			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {

			/**
			 * Mobile Section
			 */
			$wp_customize->add_section( 'killar_mobile_section' , array(
				'title' 			=> __( 'Mobile', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_options_panel',
			) );
			
			/**
			 * Mobile Header Heading ================================
			 */
			$wp_customize->add_setting( 'killar_mob_header_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_mob_header_heading', array(
				'label'	   				=> __( 'Mobile Header', 'killar' ),
				'section'  				=> 'killar_mobile_section',
				'settings' 				=> 'killar_mob_header_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Mobile : Logo
			 */
			$wp_customize->add_setting( 'killar_mob_header_logo', array(
				'default'				=>  KILLARWT_IMAGES_DIR_URI . 'logo.png',
				'sanitize_callback'		=> 'esc_url_raw',
				'transport'				=> 'postMessage'
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'killar_mob_header_logo', array(
				'label'	   				=> __( 'Mobile Logo', 'killar' ),
				'description'	   		=> __( 'Select the image to be used for mobile header logo.', 'killar' ),
				'section'  				=> 'killar_mobile_section',
				'settings' 				=> 'killar_mob_header_logo',
				'priority' 				=> 10
			) ) );

			$wp_customize->add_setting( 'killar_mob_header_logo_width', array(
				'default'          		=>  150,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_mob_header_logo_width', array(
				'label'   				=> __( 'Max Width(px)', 'killar' ),
				'section' 				=> 'killar_mobile_section',
				'settings'  			=> 'killar_mob_header_logo_width',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 200,
											'step' => 1,
										),
			) ) );

			$wp_customize->add_setting( 'killar_mob_header_logo_height', array(
				'default'          		=>  42,
				'sanitize_callback' 	=> 'killarwt_sanitize_number_range',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Slider_Control( $wp_customize, 'killar_mob_header_logo_height', array(
				'label'   				=> __( 'Max Height(px)', 'killar' ),
				'section' 				=> 'killar_mobile_section',
				'settings'  			=> 'killar_mob_header_logo_height',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 200,
											'step' => 1,
										),
			) ) );

			/**
			* Mobile: Mobile Right Layout
			*/
			$wp_customize->add_setting( 'killar_mobile_header_right_layout', array(
				'default'           	=> 'mobile-shop',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_mobile_header_right_layout', array(
				'label'	   				=> __( 'Mobile Header Right Layout', 'killar' ),
				'type' 					=> 'select',
				'description'	   		=> __( 'Select right mobile header layout from Layouts Builder or Predefined Layouts ', 'killar' ),
				'section'  				=> 'killar_mobile_section',
				'settings' 				=> 'killar_mobile_header_right_layout',
				'priority' 				=> 10,
				'choices' 				=> killarwt_mobile_layout_list(),
			) ) );


			if ( !empty( KILLARWT_WOOCOMMERCE_ACTIVE ) ) {

				/**
				 * Mobile : Shop Right Sidebar
				 */
				$wp_customize->add_setting('killar_mobile_header_shop_right_buttons', array(
					'default'        	    => apply_filters('killar_header_shop_right_buttons_default', array('register', 'signin-account', 'cart')),
					'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
				));

				$wp_customize->add_control(new KillarWT_Customizer_Sortable_Control($wp_customize, 'killar_mobile_header_shop_right_buttons', array(
					'label'	   				=> __('Header Shop Right Buttons', 'killar'),
					'choices' 				=>  apply_filters(
						'killar_mobile_header_shop_right_buttons',
						array(
							'register'    	=> esc_html__('Register Button', 'killar'),
							'signin-account' => esc_html__('SignIn - Account Button', 'killar'),
							'cart'    		=> esc_html__('Cart Icon', 'killar'),
						)
					),
					'section'  				=> 'killar_mobile_section',
					'settings' 				=> 'killar_mobile_header_shop_right_buttons',
					'priority' 				=> 10,
					'active_callback' 		=> 'ctm_killarwt_mobile_header_shop_right_buttons',
				)));
			}

			/**
			 * Mobile Flayout Heading ================================
			 */
			$wp_customize->add_setting( 'killar_mob_flyout_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_mob_flyout_heading', array(
				'label'	   				=> __( 'Flyout', 'killar' ),
				'section'  				=> 'killar_mobile_section',
				'settings' 				=> 'killar_mob_flyout_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Mobile : Menu Title
			 */
			$wp_customize->add_setting( 'killar_mob_flyout_title', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Menu',
			) );

			$wp_customize->add_control( 'killar_mob_flyout_title', array(
				'label' 			=> esc_html__( 'Flyout Title', 'killar' ),
				'section' 			=> 'killar_mobile_section',
				'settings' 			=> 'killar_mob_flyout_title',
				'priority' 			=> 10,
			) );

			/**
			 * Mobile : Show Search Content
			 */
			$wp_customize->add_setting( 'killar_show_mob_header_search', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_show_mob_header_search', array(
				'label'	   				=> __( 'Show Search Content', 'killar' ),
				'section'  				=> 'killar_mobile_section',
				'settings' 				=> 'killar_show_mob_header_search',
				'priority' 				=> 10,
			) ) );
			
			/**
			* Mobile: Menu Layout
			*/
			$wp_customize->add_setting( 'killar_mob_end_layout', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_mob_end_layout', array(
				'label'	   				=> __( 'Mobile Flyout Bottom Content', 'killar' ),
				'type' 					=> 'select',
				'description'	   		=> __( 'Select custom layout for show mobile flyout bottom content from Layouts Builder', 'killar' ),
				'section'  				=> 'killar_mobile_section',
				'settings' 				=> 'killar_mob_end_layout',
				'priority' 				=> 10,
				'choices' 				=> killarwt_megamenu_layout_list(),
			) ) );

			/**
			 * Mobile Header Style ================================
			 */
			$wp_customize->add_setting( 'killar_mob_header_style_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_mob_header_style_heading', array(
				'label'	   				=> __( 'Mobile Header Style', 'killar' ),
				'section'  				=> 'killar_mobile_section',
				'settings' 				=> 'killar_mob_header_style_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Mobile : Background Color
			 */
			$wp_customize->add_setting( 'killar_mob_header_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_mob_header_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_mobile_section',
				'settings' 			    => 'killar_mob_header_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * Mobile : Text Color
			 */
			$wp_customize->add_setting( 'killar_mob_header_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_mob_header_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'killar' ),
				'section'  			    => 'killar_mobile_section',
				'settings' 			    => 'killar_mob_header_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * Mobile : Link Color
			 */
			$wp_customize->add_setting( 'killar_mob_header_link_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_mob_header_link_color', array(
				'label'   			    => esc_html__( 'Link Color', 'killar' ),
				'section'  			    => 'killar_mobile_section',
				'settings' 			    => 'killar_mob_header_link_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Mobile : Link Hover Color
			 */
			$wp_customize->add_setting( 'killar_mob_header_link_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_mob_header_link_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'killar' ),
				'section'  			    => 'killar_mobile_section',
				'settings' 			    => 'killar_mob_header_link_hover_color',
				'priority'              => 10,
			) ) );
		

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			$killar_mob_header_logo_width							= get_theme_mod( 'killar_mob_header_logo_width', '150' );
			$killar_mob_header_logo_height							= get_theme_mod( 'killar_mob_header_logo_height', '42' );

			$killar_mob_header_bg_color								= get_theme_mod( 'killar_mob_header_bg_color', '' );
			$killar_mob_header_text_color							= get_theme_mod( 'killar_mob_header_text_color', '' );
			$killar_mob_header_link_color							= get_theme_mod( 'killar_mob_header_link_color', '' );
			$killar_mob_header_link_hover_color						= get_theme_mod( 'killar_mob_header_link_hover_color', '' );

			/**
			* Mobile Logo
			*/
			$output .= killarwt_output_css( array( '.nav-brand.mob-logo img' => array(
				'max-width' => ( !killarwt_opt_chk_def_val( $killar_mob_header_logo_width, '150' ) ) ? $killar_mob_header_logo_width.'px' : '',
				'max-height' => ( !killarwt_opt_chk_def_val( $killar_mob_header_logo_height, '42' ) ) ? $killar_mob_header_logo_height.'px' : '',
			) ), '', 920 );
			
			/**
			* Mobile Header
			*/
			$output .= killarwt_output_css( array( '.header-wrapper, .header.header-fixed' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_mob_header_bg_color , '' ) ) ? $killar_mob_header_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_mob_header_text_color , '' ) ) ? $killar_mob_header_text_color : '',
			) ), '', 920 );
		
			
			/**
			* Page title link color
			*/
			$output .= killarwt_output_css( array( '.header-wrapper a:not(:hover), .header.header-fixed a:not(:hover)' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_mob_header_link_color, '' ) ) ? $killar_mob_header_link_color : '',
			) ), '', 920 );

			/**
			* Page title link hover color
			*/
			$output .= killarwt_output_css( array( '.header-wrapper a:hover, .header-wrapper a:active, .header.header-fixed a:hover, .header.header-fixed a:active' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_mob_header_link_hover_color, '' ) ) ? $killar_mob_header_link_hover_color : '',
			) ), '', 920 );
			
			return $output;

		}

	}

endif;

return new KillarWT_Mobile_Customizer();