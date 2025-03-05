<?php
/**
 * Topbar Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Topbar_Customizer' ) ) :

	class KillarWT_Topbar_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );
		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {

			/**
			 * Topbar Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_topbar_panel',  array(
				'title' 			=> __( 'Top Bar', 'killar' ),
				'priority' 			=> '-2900',
				'panel' 			=> 'killar_options_panel',
			) ) );
			
			/**
			 * General Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_topbar_general' , array(
				'title' 			=> __( 'General', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_topbar_panel',
			) );
			
			/**
			 * Topbar : Enable
			 */
			$wp_customize->add_setting( 'killar_topbar', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_topbar', array(
				'label'	   				=> __( 'Enable Top Bar', 'killar' ),
				'section'  				=> 'killar_topbar_general',
				'settings' 				=> 'killar_topbar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Topbar : Store Info
			 */
			$store_info = killarwt_topbar_store_info();
			foreach ( $store_info as $key => $val ) {
			
				$wp_customize->add_setting( 'killar_topbar_store_info[' . $key .']', array(
					'sanitize_callback' 	=> 'wp_kses_post',
				) );

				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_topbar_store_info[' . $key .']', array(
					'label'	   				=> esc_html( $val['label'] ),
					'type' 					=> 'text',
					'section'  				=> 'killar_topbar_general',
					'settings' 				=> 'killar_topbar_store_info[' . $key .']',
					'priority' 				=> 10,
					'active_callback' 		=> 'ctm_killar_is_topbar_enable',
				) ) );
			}
			
			/**
			 * Topbar : Bg Color
			 */
			$wp_customize->add_setting( 'killar_topbar_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_topbar_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_topbar_general',
				'settings' 			    => 'killar_topbar_bg_color',
				'priority'              => 100,
				'active_callback' 		=> 'ctm_killar_is_topbar_enable',
			) ) );
			
			/**
			 * Topbar : Text Color
			 */
			$wp_customize->add_setting( 'killar_topbar_text_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_topbar_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'killar' ),
				'section'  			    => 'killar_topbar_general',
				'settings' 			    => 'killar_topbar_text_color',
				'priority'              => 200,
				'active_callback' 		=> 'ctm_killar_is_topbar_enable',
			) ) );
			

			/**
			 * Topbar : Links Color
			 */
			$wp_customize->add_setting( 'killar_topbar_links_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_topbar_links_color', array(
				'label'   			    => esc_html__( 'Link Color', 'killar' ),
				'section'  			    => 'killar_topbar_general',
				'settings' 			    => 'killar_topbar_links_color',
				'priority'              => 300,
				'active_callback' 		=> 'ctm_killar_is_topbar_enable',
			) ) );
			
			
			/**
			 * Topbar : Links Hover Color
			 */
			$wp_customize->add_setting( 'killar_topbar_links_hover_color', array(
				'default'               => '#6c63ff',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_topbar_links_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'killar' ),
				'section'  			    => 'killar_topbar_general',
				'settings' 			    => 'killar_topbar_links_hover_color',
				'priority'              => 400,
				'active_callback' 		=> 'ctm_killar_is_topbar_enable',
			) ) );
			
			/**
			 * Topbar : Border Color
			 */
			$wp_customize->add_setting( 'killar_topbar_border_color', array(
				'default'               => '#eeeeee',
				'sanitize_callback'     => 'killarwt_sanitize_color',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_topbar_border_color', array(
				'label'   			    => esc_html__( 'Border Color', 'killar' ),
				'section'  			    => 'killar_topbar_general',
				'settings' 			    => 'killar_topbar_border_color',
				'priority'              => 500,
				'active_callback' 		=> 'ctm_killar_is_topbar_enable',
			) ) );
			
			
			/**
			 * Topbar Social Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_topbar_social' , array(
				'title' 			=> __( 'Topbar Social', 'killar' ),
				'priority' 			=> 20,
				'panel' 			=> 'killar_topbar_panel',
			) );
			
			$wp_customize->add_setting( 'killar_topbar_social', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'killarwt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'killar_topbar_social', array(
				'label'	   				=> __( 'Enable Top Bar Social', 'killar' ),
				'section'  				=> 'killar_topbar_social',
				'settings' 				=> 'killar_topbar_social',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_topbar_enable',
			) ) );
			
			/**
			 * Topbar Social : Social Links
			 */
			$wp_customize->add_setting( 'killar_topbar_social_links', array(
				'default'        	    => apply_filters( 'killar_topbar_social_links_default', array( 'facebook', 'twitter', 'instagram', 'google_plus' ) ),
				'sanitize_callback' 	=> 'killarwt_sanitize_multi_choices',
			) );
			
			$social_links_data = killarwt_social_links_data();
			
			$topbar_social_links = array();
			foreach ( $social_links_data as $soc_name => $soc_det ) {
				$topbar_social_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new KillarWT_Customizer_Sortable_Control( $wp_customize, 'killar_topbar_social_links', array(
				'label'	   				=> __( 'Social Links', 'killar' ),
				'choices' 				=>  apply_filters(
												'killar_topbar_social_links_choices',
												$topbar_social_links
											),
				'section'  				=> 'killar_topbar_social',
				'settings' 				=> 'killar_topbar_social_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_display_topbar_social',
			) ) );

		}

		/**
		 * CSS
		 */
		public static function add_customizer_css( $output ) {
			
			$killar_topbar										= get_theme_mod( 'killar_topbar', false );
			if( !$killar_topbar ) return $output;
			$killar_topbar_bg_color								= get_theme_mod( 'killar_topbar_bg_color', '' );
			$killar_topbar_text_color							= get_theme_mod( 'killar_topbar_text_color', '#ffffff' );
			$killar_topbar_links_color							= get_theme_mod( 'killar_topbar_links_color', '#ffffff' );
			$killar_topbar_links_hover_color						= get_theme_mod( 'killar_topbar_links_hover_color', '#6c63ff' );
			$killar_topbar_border_color							= get_theme_mod( 'killar_topbar_border_color', '#eeeeee' );
			
			
			/**
			* Topbar
			*/
			$output .= killarwt_output_css( array( '.header-topbar' => array(
				'background-color' => ( !killarwt_opt_chk_def_val( $killar_topbar_bg_color, '' ) ) ? $killar_topbar_bg_color : '',
				'color' => ( !killarwt_opt_chk_def_val( $killar_topbar_text_color, '#ffffff' ) ) ? $killar_topbar_text_color : '',
			) ) );
			
			$output .= killarwt_output_css( array( '.topbar-links a, .social-links ' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_topbar_links_color, '#ffffff' ) ) ? $killar_topbar_links_color : '',
			) ) );
			
			$output .= killarwt_output_css( array( '.header-topbar a:hover' => array(
				'color' => ( !killarwt_opt_chk_def_val( $killar_topbar_links_hover_color, '#6c63ff' ) ) ? $killar_topbar_links_hover_color : '',
			) ) );
			
			$output .= killarwt_output_css( array( '.header-topbar, .header-topbar ul' => array(
				'border-color' => ( !killarwt_opt_chk_def_val( $killar_topbar_border_color, '#eeeeee' ) ) ? $killar_topbar_border_color : '',
			) ) );
			
			return $output;

		}

	}

endif;

return new KillarWT_Topbar_Customizer();