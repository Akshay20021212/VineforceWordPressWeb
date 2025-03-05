<?php
/**
 * Footer Middle Widgets Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Footer_Customizer' ) ) :

	class KillarWT_Footer_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );

		}

		public function options_register( $wp_customize ) {
			
			/**
			 * Footer: Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'killar_footer_section' , array(
				'title' 				=> __( 'Footer', 'killar' ),
				'priority' 				=> 10,
				'panel' 				=> 'killar_options_panel',
			) );
			
			/**
			* Footer: Layout
			*/
			$wp_customize->add_setting( 'killar_footer_layout', array(
				'default'           	=> 'simple',
				'sanitize_callback' 	=> 'killarwt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_footer_layout', array(
				'label'	   				=> __( 'Footer Layout', 'killar' ),
				'type' 					=> 'select',
				'description'	   		=> __( 'Select custom footer from Layouts Builder', 'killar' ),
				'section'  				=> 'killar_footer_section',
				'settings' 				=> 'killar_footer_layout',
				'priority' 				=> 10,
				'choices' 				=> killarwt_footer_layout_list(),
			) ) );
			
			/**
			 * Footer Copyright : Text
			 */
			$wp_customize->add_setting( 'killar_footer_copyright', array(
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> __( 'Copyright &copy; 2023. All rights reserved.', 'killar' ),
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_footer_copyright', array(
				'label'	   				=> __( 'Copyright Text', 'killar' ),
				'type'       			=> 'textarea',
				'section'  				=> 'killar_footer_section',
				'settings' 				=> 'killar_footer_copyright',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_killar_is_footer_layout_simple',
			) ) );
			
			/**
			 * Footer Copyright : BG Color
			 */
			$wp_customize->add_setting( 'killar_footer_copyright_bg_color', array(
				'default'               => '#202942',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_footer_copyright_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'killar' ),
				'section'  			    => 'killar_footer_section',
				'settings' 			    => 'killar_footer_copyright_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_is_footer_layout_simple',
			) ) );
			
			/**
			 * Footer Copyright : Text Color
			 */
			$wp_customize->add_setting( 'killar_footer_copyright_text_color', array(
				'default'               => '#adb5bd',
				'sanitize_callback'     => 'killarwt_sanitize_color',
				) );
			
			$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_footer_copyright_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'killar' ),
				'section'  			    => 'killar_footer_section',
				'settings' 			    => 'killar_footer_copyright_text_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_killar_is_footer_layout_simple',
			) ) );
		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			$killarwt_footer_layout						= killarwt_footer_layout();
			$killar_footer_copyright_bg_color			= get_theme_mod( 'killar_footer_copyright_bg_color' );
			$killar_footer_copyright_text_color			= get_theme_mod( 'killar_footer_copyright_text_color' );
			
			/**
			* Footer Copyright
			*/
			if( $killarwt_footer_layout == 'simple' ) {
				$output .= killarwt_output_css( array( '.footer-layout-simple' => array(
					'background-color' => ( !killarwt_opt_chk_def_val( $killar_footer_copyright_bg_color ) ) ? $killar_footer_copyright_bg_color : '',
					'color' => ( !killarwt_opt_chk_def_val( $killar_footer_copyright_text_color ) ) ? $killar_footer_copyright_text_color : '',
				) ) );
			}
			
			return $output;
		}
	}

endif;

return new KillarWT_Footer_Customizer();