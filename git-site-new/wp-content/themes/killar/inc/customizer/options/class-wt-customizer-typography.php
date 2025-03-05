<?php
/**
 * Typography Customizer Options
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'KillarWT_Typography_Customizer' ) ) :

	class KillarWT_Typography_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_fonts' ) );
			
			if ( is_customize_preview() ) {
				add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'live_customizer_css' ), 999 );
			} else {
				add_action( 'killar_head_css', array( $this, 'add_customizer_css' ), 130 );
			}

		}
		
		/**
		 * Array of Typography settings to add to the customizer
		 */
		public static function typo_elements() {

			// Return typography settings
			return apply_filters( 'killar_typography_settings', array(
				'body' 						=> array(
					'label' 				=> esc_html__( 'Body', 'killar' ),
					'target' 				=> 'body',
					'defaults' 				=> array(
						'font-family' 		=> 'Jost',
						'font-style' 		=> 'normal',
						'font-weight' 		=> '300',
						'font-size' 		=> '15px',
						'color' 			=> '#5d6f7d',
						'line-height' 		=> '1.8',
					),
				),
				'headings' 					=> array(
					'label' 				=> esc_html__( 'All Headings', 'killar' ),
					'target' 				=> 'h1, h2, h3, h4, h5, h6, legend, .theme-heading, .widget-title, .killarwt-widget-recent-posts-title, .comment-reply-title, .entry-title, .sidebar-box .widget-title, .kwt-heading',
					'exclude' 				=> array( 'font-size' ),
					'defaults' 				=> array(
						'font-family' 		=> 'Jost',
						'font-weight' 		=> '600',
						'color' 			=> '#05264e',
						'line-height' 		=> '1.2',
					),
				)
			) );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {
			
			// Get typo_elements
			$typo_elements = self::typo_elements();
			
			/**
			 * Typography Panel
			 */
			$wp_customize->add_panel( new KillarWT_Customizer_Module_Panels( $wp_customize, 'killar_typography_panel',  array(
				'title' 			=> __( 'Typography', 'killar' ),
				'priority' 			=> '-2600',
				'panel' 			=> 'killar_options_panel',
			) ) );

			/**
			 * Body Section
			 */
			$wp_customize->add_section( 'killar_body_settings' , array(
				'title' 			=> __( 'Body', 'killar' ),
				'priority' 			=> 10,
				'panel' 			=> 'killar_typography_panel',
			) );

			
			
			// Lopp through typo_elements
			$priority = '10';
			foreach( $typo_elements as $element => $array ) {
				$priority++;

				// Get label
				$label              	= ! empty( $array['label'] ) ? $array['label'] : null;
				$exclude_attributes 	= ! empty( $array['exclude'] ) ? $array['exclude'] : false;
				$active_callback    	= isset( $array['active_callback'] ) ? $array['active_callback'] : null;
				$transport          	= 'postMessage';

				// Get attributes
				if ( ! empty ( $array['attributes'] ) ) {
					$attributes = $array['attributes'];
				} else {
					$attributes = array(
						'font-family',
						'font-weight',
						'font-style',
						'text-transform',
						'font-size',
						'line-height',
						'letter-spacing',
						'font-color',
					);
				}

				// Set keys equal to vals
				$attributes = array_combine( $attributes, $attributes );

				// Exclude attributes for specific options
				if ( $exclude_attributes ) {
					foreach ( $exclude_attributes as $key => $val ) {
						unset( $attributes[ $val ] );
					}
				}

				// Register new setting
				if ( $label ) {

					/**
					 * Add Dynamic Section
					 */
					$wp_customize->add_section( 'killar_typography_'. $element , array(
						'title' 	=> $label,
						'priority' 	=> $priority,
						'panel' 	=> 'killar_typography_panel',
					) );

					/**
					 * Font Family
					 */
					if ( in_array( 'font-family', $attributes ) ) {
						
						// Get default
						$default = ! empty( $array['defaults']['font-family'] ) ? $array['defaults']['font-family'] : NULL;

						$wp_customize->add_setting( 'killar_'. $element .'_typography[font-family]', array(
							'default'           => $default,
							'type' 				=> 'theme_mod',
							'transport' 		=> $transport,
							'sanitize_callback' => 'sanitize_text_field',
						) );

						$wp_customize->add_control( new KillarWT_Customizer_Typography_Control( $wp_customize, 'killar_'. $element .'_typography[font-family]', array(
								'label' 			=> esc_html__( 'Font Family', 'killar' ),
								'section' 			=> 'killar_typography_'. $element,
								'settings' 			=> 'killar_'. $element .'_typography[font-family]',
								'priority' 			=> 10,
								'type' 				=> 'select',
								'active_callback' 	=> $active_callback,
						) ) );

					}
					
					/**
					 * Font Weight
					 */
					if ( in_array( 'font-weight', $attributes ) ) {
						
						// Get default
						$default = ! empty( $array['defaults']['font-weight'] ) ? $array['defaults']['font-weight'] : NULL;

						$wp_customize->add_setting( 'killar_'. $element .'_typography[font-weight]', array(
							'type' 				=> 'theme_mod',
							'sanitize_callback' => 'killarwt_sanitize_select',
							'transport' 		=> $transport,
							'$default' 			=> $default,
						) );

						$wp_customize->add_control( 'killar_'. $element .'_typography[font-weight]', array(
							'label' 			=> esc_html__( 'Font Weight', 'killar' ),
							'description'	   		=> __( 'Important: Not all fonts support every font-weight.', 'killar' ),
							'section' 			=> 'killar_typography_'. $element,
							'settings' 			=> 'killar_'. $element .'_typography[font-weight]',
							'priority' 			=> 10,
							'type' 				=> 'select',
							'active_callback' 	=> $active_callback,
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
					}

					/**
					 * Font Style
					 */
					if ( in_array( 'font-style', $attributes ) ) {
						
						// Get default
						$default = ! empty( $array['defaults']['font-style'] ) ? $array['defaults']['font-style'] : NULL;

						$wp_customize->add_setting( 'killar_'. $element .'_typography[font-style]', array(
							'type' 				=> 'theme_mod',
							'sanitize_callback' => 'killarwt_sanitize_select',
							'transport' 		=> $transport,
							'$default' 			=> $default,
						) );

						$wp_customize->add_control( 'killar_'. $element .'_typography[font-style]', array(
							'label' 			=> esc_html__( 'Font Style', 'killar' ),
							'section' 			=> 'killar_typography_'. $element,
							'settings' 			=> 'killar_'. $element .'_typography[font-style]',
							'priority' 			=> 10,
							'type' 				=> 'select',
							'active_callback' 	=> $active_callback,
							'choices' 			=> array(
								'' => esc_html__( 'Default', 'killar' ),
								'normal' => esc_html__( 'Normal', 'killar' ),
								'italic' => esc_html__( 'Italic', 'killar' ),
							),
						) );

					}

					/**
					 * Text Transform
					 */
					if ( in_array( 'text-transform', $attributes ) ) {
						
						// Get default
						$default = ! empty( $array['defaults']['text-transform'] ) ? $array['defaults']['text-transform'] : NULL;

						$wp_customize->add_setting( 'killar_'. $element .'_typography[text-transform]', array(
							'type' 				=> 'theme_mod',
							'sanitize_callback' => 'killarwt_sanitize_select',
							'transport' 		=> $transport,
							'default' 			=> $default,
						) );

						$wp_customize->add_control( 'killar_'. $element .'_typography[text-transform]', array(
							'label' 			=> esc_html__( 'Text Transform', 'killar' ),
							'section' 			=> 'killar_typography_'. $element,
							'settings' 			=> 'killar_'. $element .'_typography[text-transform]',
							'priority' 			=> 10,
							'type' 				=> 'select',
							'active_callback' 	=> $active_callback,
							'choices' 			=> array(
								'' 			 => esc_html__( 'Default', 'killar' ),
								'capitalize' => esc_html__( 'Capitalize', 'killar' ),
								'lowercase'  => esc_html__( 'Lowercase', 'killar' ),
								'uppercase'  => esc_html__( 'Uppercase', 'killar' ),
								'none'  	 => esc_html__( 'None', 'killar' ),
							),
						) );

					}

					/**
					 * Font Size
					 */
					if ( in_array( 'font-size', $attributes ) ) {

						// Get default
						$default = ! empty( $array['defaults']['font-size'] ) ? $array['defaults']['font-size'] : NULL;

						$wp_customize->add_setting( 'killar_'. $element .'_typography[font-size]', array(
							'type' 				=> 'theme_mod',
							'sanitize_callback' => 'sanitize_text_field',
							'transport' 		=> $transport,
							'default' 			=> $default,
						) );

						$wp_customize->add_control( 'killar_'. $element .'_typography[font-size]', array(
							'label' 			=> esc_html__( 'Font Size', 'killar' ),
							'description' 		=> esc_html__( 'You can add size in (px,em,%)', 'killar' ),
							'section' 			=> 'killar_typography_'. $element,
							'settings' 			=> 'killar_'. $element .'_typography[font-size]',
							'priority' 			=> 10,
							'active_callback' 	=> $active_callback,
						) );

					}

					/**
					 * Line Height
					 */
					if ( in_array( 'line-height', $attributes ) ) {

						// Get default
						$default = ! empty( $array['defaults']['line-height'] ) ? $array['defaults']['line-height'] : NULL;
						
						$wp_customize->add_setting( 'killar_'. $element .'_typography[line-height]', array(
							'type' 				=> 'theme_mod',
							'sanitize_callback' => 'killarwt_sanitize_number',
							'transport' 		=> $transport,
							'default' 			=> $default,
						) );

						$wp_customize->add_control( 'killar_'. $element .'_typography[line-height]', array(
							'label' 			=> esc_html__( 'Line Height', 'killar' ),
							'section' 			=> 'killar_typography_'. $element,
							'settings' 			=> 'killar_'. $element .'_typography[line-height]',
							'priority' 			=> 10,
							'active_callback' 	=> $active_callback,
						    'input_attrs' 		=> array(
						        'min'   => 0,
						        'max'   => 4,
						        'step'  => 0.1,
						    ),
						) );

					}


					/**
					 * Font Color
					 */
					if ( in_array( 'font-color', $attributes ) ) {

						// Get default
						$default = ! empty( $array['defaults']['color'] ) ? $array['defaults']['color'] : NULL;
						
						$wp_customize->add_setting( 'killar_'. $element .'_typography[color]', array(
							'type' 				=> 'theme_mod',
							'default' 			=> '',
							'sanitize_callback' => 'killarwt_sanitize_color',
							'transport' 		=> $transport,
							'default' 			=> $default,
						) );
						$wp_customize->add_control( new KillarWT_Customizer_Color_Control( $wp_customize, 'killar_'. $element .'_typography[color]', array(
							'label' 			=> esc_html__( 'Font Color', 'killar' ),
							'section' 			=> 'killar_typography_'. $element,
							'settings' 			=> 'killar_'. $element .'_typography[color]',
							'priority' 			=> 10,
							'active_callback' 	=> $active_callback,
						) ) );

					}

					
				}
			}

		}
		
		/**
		 * Enqueue scripts for our Customizer preview
		 */
		public function customize_preview_init(){
			wp_enqueue_script( 'killarwt-typography-customize-preview', KILLARWT_INC_DIR_URI . 'customizer/assets/js/typography-customize-preview.js', array( 'customize-preview', 'jquery' ), KILLARWT_VERSION, true );
			wp_localize_script( 'killarwt-typography-customize-preview', 'killarTypography', array(
				'googleFontsUrl' 	=> '//fonts.googleapis.com',
				'googleFontsWeight' => '100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i',
			) );
		}
		
		/**
		 * Typo settings
		 */
		public static function typo_settings( $return = 'css' ) {

			// Define Vars
			$css            = '';
			$fonts          = array();
			$typo_elements       = self::typo_elements();
			$preview_styles = array();

			// Typo Settings through each typo_elements that need typography styling applied to them
			foreach( $typo_elements as $element => $array ) {

				// Add empty css var
				$add_css 	= '';

				// Get target and current mod
				$target  		= isset( $array['target'] ) ? $array['target'] : '';
				$get_mod 		= killarwt_theme_mod( 'killar_'. $element .'_typography' );

				// Attributes to typo settings through
				if ( ! empty( $array['attributes'] ) ) {
					$attributes = $array['attributes'];
				} else {
					$attributes = array(
						'font-family',
						'font-weight',
						'font-style',
						'font-size',
						'color',
						'line-height',
						'letter-spacing',
						'text-transform',
					);
				}

				// Typo Settings through attributes
				foreach ( $attributes as $attribute ) {

					// Define val
					$default 		= isset( $array['defaults'][$attribute] ) ? $array['defaults'][$attribute] : NULL;
					$val     		= isset( $get_mod[$attribute] ) ? $get_mod[$attribute] : $default;
					
					if ( $val && $default == $val && $attribute == 'font-family' ) {
						$fonts[] = $val;
					}

					// If there is a value lets do something
					if ( $val && $default != $val ) {

						// Sanitize
						$val = str_replace( '"', '', $val );

						// Add px if font size or letter spacing
						$px = '';
						if ( ( $attribute == 'font-size'
								&& is_numeric( $val ) )
							|| $attribute == 'letter-spacing' ) {
							$px = 'px';
						}

						// Add quotes around font-family && font family to scripts array
						if ( $attribute == 'font-family' ) {
							$fonts[] = $val;

							// No brackets can be added as it cause issue with sans serif fonts
							$val = $val;
						}

						// Add css
						if (  $return == 'css' ) {
							$add_css .= $attribute .':'. $val . $px .';';
						} elseif ( $return == 'preview_styles' ) {
							$preview_styles['customizer-typography-'. $element .'-'. $attribute] = $target .'{'. $attribute .':'. $val . $px .';}';
						}

					}

				}

				// Front-end inline CSS
				if ( $add_css && $return == 'css' ) {
					$css .= $target .'{'. $add_css .'}';
				}
			}

			// Return CSS
			if ( $return == 'css' && ! empty( $css ) ) {
				return $css;
			}

			// Return styles
			if ( $return == 'preview_styles' && ! empty( $preview_styles ) ) {
				return $preview_styles;
			}

			// Return Fonts Array
			if ( $return == 'fonts' && ! empty( $fonts ) ) {
				return array_unique( $fonts );
			}

		}

		/**
		 * Returns customizer CSS
==		 */
		public function live_customizer_css() {

			$live_customizer_css = self::typo_settings( 'preview_styles' );

			if ( $live_customizer_css ) {
				foreach ( $live_customizer_css as $key => $val ) {
					if ( ! empty( $val ) ) {
						echo '<style class="'. esc_attr( $key ) .'"> '. wp_kses_post( $val ) .'</style>';
					}
				}
			}

		}

		/**
		 * Loads Google fonts
		 */
		public function load_fonts() {

			// Get fonts
			$fonts = self::typo_settings( 'fonts' );

			// Typo Settings through and enqueue fonts
			if ( ! empty( $fonts ) && is_array( $fonts ) ) {
				foreach ( $fonts as $font ) {
					killarwt_enqueue_google_font( $font );
				}
			}

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
					
			$typography_css = self::typo_settings( 'css' );

			if ( $typography_css ) {
				$output .= $typography_css;
			}

			return $output;

		}

	}

endif;

return new KillarWT_Typography_Customizer();