<?php
/**
 * Social Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Social_Customizer' ) ) :

	class KillarWT_Social_Customizer {

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
			 * Social Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_social_panel',  array(
				'title' 				=> __( 'Social', 'killar' ),
				'priority' 				=> '-2500',
				'panel' 				=> 'killar_options_panel',
			) ) );
			
			/**
			 * Social Links Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_social_links_section' , array(
				'title' 				=> __( 'Social Links', 'killar' ),
				'description'	   		=> __( 'Show social links icon on header and footer', 'killar' ),
				'priority' 				=> 110,
				'panel' 				=> 'killar_social_panel',
			) );
			
			/**
			 * Social Links : Status
			 */
			$wp_customize->add_setting( 'killar_social_links', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_social_links', array(
				'label'	   				=> __( 'Enable Social Links', 'killar' ),
				'section'  				=> 'killar_social_links_section',
				'settings' 				=> 'killar_social_links',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Social Links : Links Display Type
			 */
			$wp_customize->add_setting( 'killar_social_links_display_type', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_links_display_type', array(
				'label'	   				=> __( 'Links Display Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_links_section',
				'settings' 				=> 'killar_social_links_display_type',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Only Icon ( Default )', 'killar' ),
												'icon-label'    	=> esc_html__( 'Icon with Label', 'killar' ),
												'label'    			=> esc_html__( 'Only Label', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Icon Style
			 */
			$wp_customize->add_setting( 'killar_social_links_icon_style', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_links_icon_style', array(
				'label'	   				=> __( 'Icon Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_links_section',
				'settings' 				=> 'killar_social_links_icon_style',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'killar' ),
												'colored'    		=> esc_html__( 'Colored', 'killar' ),
												'bordered'    		=> esc_html__( 'Bordered', 'killar' ),
												'fill_colored'     => esc_html__( 'Fill Colored', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Icon Shape
			 */
			$wp_customize->add_setting( 'killar_social_links_icon_shape', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_links_icon_shape', array(
				'label'	   				=> __( 'Icon Shape', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_links_section',
				'settings' 				=> 'killar_social_links_icon_shape',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'killar' ),
												'rounded'    	=> esc_html__( 'Rounded', 'killar' ),
												'circle'    		=> esc_html__( 'Circle', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Icon Size
			 */
			$wp_customize->add_setting( 'killar_social_links_icon_size', array(
				'default'        	    => 'md',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_links_icon_size', array(
				'label'	   				=> __( 'Icon Size', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_links_section',
				'settings' 				=> 'killar_social_links_icon_size',
				'priority' 				=> 10,
				'choices' 				=> array(
												'xs'        		=> esc_html__( 'XSmall', 'killar' ),
												'sm'    			=> esc_html__( 'Small', 'killar' ),
												'md'    			=> esc_html__( 'Medium (Default)', 'killar' ),
												'lg'    			=> esc_html__( 'Large', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Social Links Heading ================================
			 */
			$wp_customize->add_setting( 'killar_social_links_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_social_links_heading', array(
				'label'	   				=> __( 'Social Links', 'killar' ),
				'section'  				=> 'killar_social_links_section',
				'settings' 				=> 'killar_social_links_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Links
			 */
			$social_links_data = killarwt_social_links_data();
			foreach ( $social_links_data as $soc_name => $soc_det ) {
				if ( 'email' == $soc_name ) {
					$sanitize = 'sanitize_email';
				} else {
					$sanitize = 'sanitize_text_field';
				}

				$wp_customize->add_setting( 'killar_social_links_settings[' . $soc_name .']', array(
					'type' 					=> 'theme_mod',
					'sanitize_callback' 	=> $sanitize,
					'transport' 			=> 'postMessage',
					'default' 				=> '#',
				) );

				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_links_settings[' . $soc_name .']', array(
					'label'	   				=> esc_html( $soc_det['label'] ),
					'description'	   		=> esc_html( $soc_det['description'] ),
					'type' 					=> 'text',
					'section'  				=> 'killar_social_links_section',
					'settings' 				=> 'killar_social_links_settings[' . $soc_name .']',
					'priority' 				=> 10,
					'active_callback' 		=> 'ctm_killar_social_links_enabled',
				) ) );
			}
			
			/**
			 * Social Share Links Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_social_share_links_section' , array(
				'title' 				=> __( 'Social Share Links', 'killar' ),
				'description'	  	 	=> __( 'Show social share links icon on blog, posts, products, portfolios etc..', 'killar' ),
				'priority' 				=> 110,
				'panel' 				=> 'killar_social_panel',
			) );
			
			/**
			 * Social Share Links : Status
			 */
			$wp_customize->add_setting( 'killar_social_share_links', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_social_share_links', array(
				'label'	   				=> __( 'Enable Social Share Links', 'killar' ),
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Social Share Links : Show Title
			 */
			$wp_customize->add_setting( 'killar_social_share_links_title', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_social_share_links_title', array(
				'label'	   				=> __( 'Show Social Title', 'killar' ),
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links_title',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Links Display Type
			 */
			$wp_customize->add_setting( 'killar_social_share_links_display_type', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_share_links_display_type', array(
				'label'	   				=> __( 'Links Display Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links_display_type',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Only Icon ( Default )', 'killar' ),
												'icon-label'    	=> esc_html__( 'Icon with Label', 'killar' ),
												'label'    			=> esc_html__( 'Only Label', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Icon Style
			 */
			$wp_customize->add_setting( 'killar_social_share_links_icon_style', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_share_links_icon_style', array(
				'label'	   				=> __( 'Icon Style', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links_icon_style',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'killar' ),
												'flat'    			=> esc_html__( 'Flat', 'killar' ),
												'bordered'    		=> esc_html__( 'Bordered', 'killar' ),
												'boxed'    			=> esc_html__( 'Boxed', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Icon Shape
			 */
			$wp_customize->add_setting( 'killar_social_share_links_icon_shape', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_share_links_icon_shape', array(
				'label'	   				=> __( 'Icon Shape', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links_icon_shape',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'killar' ),
												'rounded'    	=> esc_html__( 'Rounded', 'killar' ),
												'circle'    	=> esc_html__( 'Circle', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Icon Size
			 */
			$wp_customize->add_setting( 'killar_social_share_links_icon_size', array(
				'default'        	    => 'md',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_social_share_links_icon_size', array(
				'label'	   				=> __( 'Icon Size', 'killar' ),
				'type' 					=> 'select',
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links_icon_size',
				'priority' 				=> 10,
				'choices' 				=> array(
												'xs'        		=> esc_html__( 'XSmall', 'killar' ),
												'sm'    			=> esc_html__( 'Small', 'killar' ),
												'md'    			=> esc_html__( 'Medium (Default)', 'killar' ),
												'lg'    			=> esc_html__( 'Large', 'killar' ),
											),
				'active_callback' 		=> 'ctm_killar_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Social Share Links Heading ================================
			 */
			$wp_customize->add_setting( 'killar_social_share_links_heading', array(
				'sanitize_callback' 	=> 'killarwt_sanitize_select',
			) );

			$wp_customize->add_control( new KillarWT_Customizer_Heading_Control( $wp_customize, 'killar_social_share_links_heading', array(
				'label'	   				=> __( 'Social Share Links', 'killar' ),
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Links
			 */
			$wp_customize->add_setting( 'killar_social_share_links_settings', array(
				'default'        	    => apply_filters( 'killar_topbar_social_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = killarwt_social_share_links_data();
			
			$social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_social_share_links_settings', array(
				'label'	   				=> __( 'Social Share Links', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_social_share_links_choices',
												$social_share_links
											),
				'section'  				=> 'killar_social_share_links_section',
				'settings' 				=> 'killar_social_share_links_settings',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_social_share_links_enabled',
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
			
		}
	}

endif;

return new KillarWT_Social_Customizer();