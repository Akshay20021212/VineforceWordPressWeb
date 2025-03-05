<?php
/**
 * Portfolio Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Pages_Customizer' ) ) :

	class KillarWT_Pages_Customizer {

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
			 * Pages Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_pages_panel',  array(
				'title' 			=> __( 'Pages', 'killar' ),
				'priority' 			=> '-2500',
				'panel' 			=> 'killar_options_panel',
			) ) );
			
			/**
			 * 404page Section
			 */
			$wp_customize->add_section( 'killar_pages_404page_section' , array(
				'title' 			=> __( '404 Page', 'killar' ),
				'priority' 			=> 110,
				'panel' 			=> 'killar_pages_panel',
			) );
			
			
			/**
			 * 404page : Heading Custom Title
			 */
			$wp_customize->add_setting( 'killar_pages_404page_heading_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'Page Not Found',
			) );

			$wp_customize->add_control( 'killar_pages_404page_heading_text', array(
				'label' 			=> esc_html__( 'Heading Text', 'killar' ),
				'section' 			=> 'killar_pages_404page_section',
				'settings' 			=> 'killar_pages_404page_heading_text',
				'priority' 			=> 10,
			) );
			
			/**
			 * 404page : Content
			 */
			$wp_customize->add_setting( 'killar_pages_404page_content', array(
				'default'          		=> __( 'The page you are looking for was moved, removed or might never existed.', 'killar' ),
				'transport'           	=> 'postMessage',
				'sanitize_callback'		=> 'wp_kses_post',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'killar_pages_404page_content', array(
				'label'	   				=> __( 'Content Body Text', 'killar' ),
				'type'       			=> 'textarea',
				'section'  				=> 'killar_pages_404page_section',
				'settings' 				=> 'killar_pages_404page_content',
				'priority' 				=> 20,
			) ) );
			
			/**
			 * 404page : Button Text
			 */
			$wp_customize->add_setting( 'killar_pages_404page_button_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'Back to Home',
			) );

			$wp_customize->add_control( 'killar_pages_404page_button_text', array(
				'label' 			=> esc_html__( 'Button Text', 'killar' ),
				'section' 			=> 'killar_pages_404page_section',
				'settings' 			=> 'killar_pages_404page_button_text',
				'priority' 			=> 10,
			) );
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

return new KillarWT_Pages_Customizer();