<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KillarWT_Elementor_Widget_Base' ) ) {
			
	abstract class KillarWT_Elementor_Widget_Base extends Elementor\Widget_Base {
		
		protected function killarwt_animations_controls( $name = '' ) {
			
			$this->add_control(
				"{$name}animation",
				[
					'label' => __( 'AOS Animation', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => array_flip(killarwt_animations_array()),
					'separator' => 'before',
				]
			);
			
			$this->add_control(
				"{$name}animation_durations",
				[
					'label' => __( 'Animation Duration', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '0', 'killarwt-core' ),
					'placeholder' => '',
					'description' => __( 'Add animation duration values from 0 to 3000, with step 50ms', 'killarwt-core' ),
					'condition' => [
						"{$name}animation!" => '',
					],
				]
			);
			
			$this->add_control(
				"{$name}animation_delay",
				[
					'label' => __( 'Animation delay', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '0', 'killarwt-core' ),
					'placeholder' => '',
					'description' => __( 'Add animation delay values from 0 to 3000, with step 50ms', 'killarwt-core' ),
					'condition' => [
						"{$name}animation!" => '',
					],
					'separator' => 'after',
				]
			);
		}
		
		protected function killarwt_style_icon_controls( $default_ar = array() ) {

			$this->start_controls_section(
				"section_controls_icon",
				[
					'label' => $this->killarwt_set_control_default_value('tab_label', $default_ar, 'Icon'),
					'tab'   => $this->killarwt_set_control_default_value('tab', $default_ar, Controls_Manager::TAB_STYLE),
				] + (array)$this->killarwt_set_control_default_value('tab_condition', $default_ar, [])
			);

			// Icon Style -------------------------------
			// $this->start_controls_section(
			// 	'section_style_icon',
			// 	[
			// 		'label' => esc_html__( 'Icon', 'killarwt-core' ),
			// 		'tab'   => Controls_Manager::TAB_STYLE,
			// 		'conditions' => ( ( !empty( $default_ar['condition'] ) && $default_ar['condition'] == 'none' ) ? '' : [
			// 			'relation' => 'or',
			// 			'terms' => [
			// 				[
			// 					'name' => 'icon_type',
			// 					'operator' => '!=',
			// 					'value' => '',
			// 				],
			// 			],
			// 		] ),
			// 	]
			// );
			
			$this->add_control(
				'icon_view',
				[
					'label' => esc_html__( 'Icon View', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'killarwt-core' ),
						'stacked' => esc_html__( 'Stacked', 'killarwt-core' ),
						'framed' => esc_html__( 'Framed', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'view', $default_ar, 'default' ),
					'condition' => ( ( !empty( $default_ar['condition'] ) && $default_ar['condition'] == 'none' ) ? '' : [
						'icon_type!' => 'none',
					] ),
				]
			);
			
			$this->add_control(
				'icon_shape',
				[
					'label' => esc_html__( 'Icon Shape', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'circle' => esc_html__( 'Circle', 'killarwt-core' ),
						'square' => esc_html__( 'Square', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'shape', $default_ar, 'circle' ),
					'condition' => [
						'icon_view!' => 'default',
					],
				]
			);
			
			$this->add_control(
				'icon_size',
				[
					'label' => __( 'Icon Size', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'size', $default_ar ),
					'options' => array_flip( killarwt_icon_size_array() ),
					'condition' => ( ( !empty( $default_ar['condition'] ) && $default_ar['condition'] == 'none' ) ? '' : [
						'icon_type' => array('text', 'icon', 'image')
					] ),
				]
			);
			
			$this->add_control(
				'icon_size_custom',
				[
					'label' => __( 'Icon Size Custom', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '22px', 'killarwt-core' ),
					'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
					'placeholder' => '',
					'condition' => [
						'icon_size' => array('icon-custom')
					],
					'selectors' => [
						'{{WRAPPER}} .bx-ico-img' => 'font-size: {{VALUE}};width: calc({{VALUE}}*2.4;height: calc({{VALUE}}*2.4;'
					],
				]
			);

			$this->add_control(
				'icon_rounded_cornors',
				[
					'label' => esc_html__( 'Icon Rounded Cornors', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => array_flip( killarwt_border_radius_array() ),
					'default' => $this->killarwt_set_control_default_value( 'cornors', $default_ar ),
				]
			);
			
			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'color', $default_ar ),
					'options' => array_flip(killarwt_color_array()),
				]
			);
			
			$this->add_control(
				'icon_color_custom',
				[
					'label' => __( 'Icon Custom Color', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
						'icon_color' => 'custom',
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon' => 'color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'icon_bg_color',
				[
					'label' => __( 'Icon Background Color', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'bg_color', $default_ar, 'default' ),
					'options' => array_flip(killarwt_bg_color_array()),
				]
			);
			
			$this->add_control(
				'icon_bg_color_custom',
				[
					'label' => __( 'Icon Background Color Custom', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
						'icon_bg_color' => 'custom',
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon' => 'background-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_responsive_control(
				'icon_alignment',
				[
					'label' => __( 'Icon Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'alignment', $default_ar ),
					'options' => array_flip( killarwt_horizontal_alignment_array() ),
				]
			);
			
			$this->add_responsive_control(
				'icon_ver_alignment',
				[
					'label' => __( 'Vertical Icon Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'ver_alignment', $default_ar ),
					'options' => array_flip( killarwt_vertical_alignment_array() ),
				]
			);
			
			$this->add_control(
				'icon_image_rounded_cornors',
				[
					'label' => esc_html__( 'Rounded Cornors', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => array_flip( killarwt_border_radius_array() ),
					'default' => $this->killarwt_set_control_default_value( 'Cornors', $default_ar, 'rounded' ),
					'condition' => [
						'icon_type' => 'image',
					],
				]
			);
			
			$this->add_control(
				'icon_hover_overlay',
				[
					'label' => esc_html__( 'Hover Overlay Effect', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'overlay', $default_ar, '0' ),
					'condition' => [
						'icon_type' => 'image',
					],
				]
			);
			
			$this->add_control(
				'icon_el_classes',
				[
					'label' => __( 'Icon Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar ),
				]
			);
			
			$this->add_control(
				'icon_wrap_el_classes',
				[
					'label' => __( 'Icon Wrap Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'wrap_el_classes', $default_ar ),
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function killarwt_style_social_icons_controls( $default_ar = array() ) {
			
			// Icons Style -------------------------------

			$this->start_controls_section(
				'section_controls_social_icon',
				[
					'label' => $this->killarwt_set_control_default_value('tab_label', $default_ar, 'Social Icons'),
					'tab'   => $this->killarwt_set_control_default_value('tab', $default_ar, Controls_Manager::TAB_STYLE),
				] + (array)$this->killarwt_set_control_default_value('tab_condition', $default_ar, [])
			);

			$this->add_control(
				'icon_view',
				[
					'label' => esc_html__( 'View', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'killarwt-core' ),
						'stacked' => esc_html__( 'Stacked', 'killarwt-core' ),
						'framed' => esc_html__( 'Framed', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'view', $default_ar, 'default' ),
				]
			);
			
			$this->add_control(
				'icon_shape',
				[
					'label' => esc_html__( 'Shape', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'circle' => esc_html__( 'Circle', 'killarwt-core' ),
						'square' => esc_html__( 'Square', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'shape', $default_ar, 'circle' ),
					'condition' => [
						'icon_view!' => 'default',
					],
				]
			);
			
			$this->add_control(
				'icon_size',
				[
					'label' => __( 'Icon Size', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'size', $default_ar, 'ico-20' ),
					'options' => array_flip( killarwt_icon_size_array() ),
				]
			);
			
			$this->add_control(
				'icon_color',
				[
					'label' => __('Icon Color', 'killarwt-core'),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'color', $default_ar, 'colored' ),
					'options' => array( 'default'   => __('Default', 'killarwt-core'), 'colored'   => __('Colored', 'killarwt-core') ) + array_flip( killarwt_button_color_array() ) + array( 'custom'   => __('Custom', 'killarwt-core') ),
				]
			);
			
			$this->add_control(
				'icon_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'bg_color', $default_ar, '' ),
					'condition' => [
						'icon_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon' => 'background-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'icon_text_color',
				[
					'label' => esc_html__( 'Text Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'text_color', $default_ar, '' ),
					'condition' => [
						'icon_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon' => 'color: {{VALUE}};'
					],
					
				]
			);
			
			$this->add_control(
				'icon_border_color',
				[
					'label' => esc_html__( 'Border Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'border_color', $default_ar, '' ),
					'condition' => [
						'icon_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon' => 'border-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'heading_icon_hover',
				[
					'label' => esc_html__( 'Button Hover', 'killarwt-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			
			$this->add_control(
				'icon_hcolor',
				[
					'label' => __('Button Hover Color', 'killarwt-core'),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'hover_color', $default_ar, 'colored' ),
					'options' => array( 'default'   => __('Default', 'killarwt-core'), 'colored'   => __('Colored', 'killarwt-core') ) + array_flip( killarwt_button_hover_color_array() ) + array( 'custom'   => __('Custom', 'killarwt-core') ),
				]
			);
			
			$this->add_control(
				'icon_bg_hcolor',
				[
					'label' => esc_html__( 'Background Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'bg_hcolor', $default_ar, '' ),
					'condition' => [
						'icon_hover_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon:hover' => 'background-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'icon_text_hcolor',
				[
					'label' => esc_html__( 'Text Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'text_hcolor', $default_ar, '' ),
					'condition' => [
						'icon_hover_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon:hover' => 'color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'icon_border_hcolor',
				[
					'label' => esc_html__( 'Border Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'border_hcolor', $default_ar, '' ),
					'condition' => [
						'icon_hover_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .fbx-icon:hover' => 'border-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'icon_el_classes',
				[
					'label' => __( 'Icon Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar, '' ),
				]
			);
			
			$this->add_control(
				'icon_wrap_el_classes',
				[
					'label' => __( 'Icon Wrap Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'wrap_el_classes', $default_ar, '' ),
				]
			);
			
			$this->end_controls_section();
		}

		protected function killarwt_style_fields_controls( $name, $default_ar = array() ) {
			
			if ( !empty( $name ) ) {
				
				$label = ( !empty( $default_ar['label'] ) ) ? $default_ar['label'] : ucfirst( $name );
				$class = ( !empty( $default_ar['class'] ) ) ? $default_ar['class'] : '.bx-' . str_replace( '_', '-', $name );
				
				$this->start_controls_section(
					"section_style_{$name}",
					[
						'label' => esc_html__( $label, 'killarwt-core' ),
						'tab'   => Controls_Manager::TAB_STYLE,
					]
				);
				
				$this->add_control(
					"{$name}_size",
					[
						'label' => __( 'HTML Tag', 'killarwt-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => $this->killarwt_set_control_default_value( 'size', $default_ar, 'p' ),
						'options' => ( !empty( $default_ar['size_options'] ) ) ? $default_ar['size_options'] : [
							'h1' 				=> 'h1',
							'h2' 				=> 'h2',
							'h3' 				=> 'h3',
							'h4' 				=> 'h4',
							'h5' 				=> 'h5',
							'h6' 				=> 'h6',
							'div' 				=> 'div',
							'span' 				=> 'span',
							'p' 				=> 'p',
							'a' 				=> 'a',
							'sup' 				=> 'sup',
							'sub' 				=> 'sub',
							'blockquote' 		=> 'blockquote',
						],
						'separator' => 'top',
					]
				);

				$this->add_control(
					"{$name}_font_size",
					[
						'label' => __( 'Font Size', 'killarwt-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => $this->killarwt_set_control_default_value( 'font_size', $default_ar ),
						'options' => array_flip( killarwt_font_size_array() ),
						'separator' => 'top',
					]
				);

				$this->add_control(
					"{$name}_custom_font_size",
					[
						'label' => __( 'Custom Font Size', 'killarwt-core' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => __( '1em', 'killarwt-core' ),
						'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
						'placeholder' => '',
						'condition' => [
							"{$name}_font_size" => 'custom'
						],
						'selectors' => [
							"{{WRAPPER}} {$class}" => 'font-size: {{VALUE}};'
						],
					]
				);

				$this->add_control(
					"{$name}_font_weight",
					[
						'label' => __( 'Font Weight', 'killarwt-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => $this->killarwt_set_control_default_value( 'font_weight', $default_ar ),
						'options' => array_flip( killarwt_font_weight_array() ),
					]
				);

				$this->add_control(
					"{$name}_font_style",
					[
						'label' => __( 'Font Style', 'killarwt-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => $this->killarwt_set_control_default_value( 'font_style', $default_ar ),
						'options' => array_flip( killarwt_font_style_array() ),
					]
				);

				$this->add_control(
					"{$name}_text_transform",
					[
						'label' => __( 'Text Transform', 'killarwt-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => $this->killarwt_set_control_default_value( 'text_transform', $default_ar ),
						'options' => array_flip( killarwt_text_transform_array() ),
					]
				);

				$this->add_control(
					"{$name}_color",
					[
						'label' => __( 'Color', 'killarwt-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => $this->killarwt_set_control_default_value( 'color', $default_ar, 'default' ),
						'options' => array_flip(killarwt_color_array()),
					]
				);

				$this->add_control(
					"{$name}_color_custom",
					[
						'label' => __( 'Custom Color', 'killarwt-core' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => $this->killarwt_set_control_default_value( 'color_custom', $default_ar, '#222' ),
						'condition' => [
							"{$name}_color" => 'custom',
						],
						'selectors' => [
							"{{WRAPPER}} {$class}" => 'color: {{VALUE}};'
						],
					]
				);

				$this->add_control(
					"{$name}_line_height",
					[
						'label' => __( 'Line Height', 'killarwt-core' ),
						'type' => Controls_Manager::SELECT,
						'default' => $this->killarwt_set_control_default_value( 'line_height', $default_ar ),
						'options' => array_flip( killarwt_line_height_array() ),
						'separator' => 'top',
					]
				);

				$this->add_control(
					"{$name}_custom_line_height",
					[
						'label' => __( 'Custom Line Height', 'killarwt-core' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => $this->killarwt_set_control_default_value( 'custom_line_height', $default_ar ),
						'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'killarwt-core' ),
						'placeholder' => '',
						'condition' => [
							"{$name}_line_height" => 'custom'
						],
						'selectors' => [
							"{{WRAPPER}} {$class}" => 'line-height: {{VALUE}};'
						],
					]
				);

				$this->add_control(
					"{$name}_letter_spacing",
					[
						'label' => __( 'Letter Spacing', 'killarwt-core' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => $this->killarwt_set_control_default_value( 'letter_spacing', $default_ar ),
						'description' => __( 'You can add spacing in (px,em,rem,%)', 'killarwt-core' ),
						'placeholder' => '',
						'selectors' => [
							"{{WRAPPER}} {$class}" => 'letter-spacing: {{VALUE}};'
						],
					]
				);

				$this->add_responsive_control(
					"{$name}_alignment",
					[
						'label' => __( 'Alignment', 'killarwt-core' ),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => esc_html__( 'Left', 'elementor' ),
								'icon' => 'eicon-text-align-left',
							],
							'center' => [
								'title' => esc_html__( 'Center', 'elementor' ),
								'icon' => 'eicon-text-align-center',
							],
							'right' => [
								'title' => esc_html__( 'Right', 'elementor' ),
								'icon' => 'eicon-text-align-right',
							],
							'justify' => [
								'title' => esc_html__( 'Justified', 'elementor' ),
								'icon' => 'eicon-text-align-justify',
							],
						],
						'default' => $this->killarwt_set_control_default_value( 'alignment', $default_ar ),
					]
				);
				
				$this->killarwt_animations_controls( "{$name}_" );

				$this->add_control(
					"{$name}_el_classes",
					[
						'label' => __( "Extra Classes", 'killarwt-core' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar ),
					]
				);
				
				if( isset( $default_ar['wrap_el_classes'] )  ) {
				
					$this->add_control(
						"{$name}_wrap_el_classes",
						[
							'label' => __( "Wrap Extra Classes", 'killarwt-core' ),
							'type' => \Elementor\Controls_Manager::TEXT,
							'default' => $this->killarwt_set_control_default_value( 'wrap_el_classes', $default_ar ),
						]
					);
				}

				$this->end_controls_section();
			}
		}
		
		protected function killarwt_style_image_controls( $default_ar = array() ) {
			
			// Image Style -------------------------------
		
			$this->start_controls_section(
				'section_style_image',
				[
					'label' => esc_html__( 'Image', 'killarwt-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_control(
				'image_rounded_cornors',
				[
					'label' => esc_html__( 'Rounded Cornors', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => array_flip( killarwt_border_radius_array() ),
					'default' => $this->killarwt_set_control_default_value( 'cornors', $default_ar ),
				]
			);
			
			$this->add_responsive_control(
				'image_alignment',
				[
					'label' => __( 'Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => esc_html__( 'Left', 'elementor' ),
								'icon' => 'eicon-text-align-left',
							],
							'center' => [
								'title' => esc_html__( 'Center', 'elementor' ),
								'icon' => 'eicon-text-align-center',
							],
							'right' => [
								'title' => esc_html__( 'Right', 'elementor' ),
								'icon' => 'eicon-text-align-right',
							],
							'justify' => [
								'title' => esc_html__( 'Justified', 'elementor' ),
								'icon' => 'eicon-text-align-justify',
							],
						],
					'default' => $this->killarwt_set_control_default_value( 'alignment', $default_ar ),
				]
			);
			
			$this->add_control(
				'image_hover_overlay',
				[
					'label' => esc_html__( 'Hover Overlay Effect', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'overlay', $default_ar ),
				]
			);
		
			$this->add_control(
				'image_el_classes',
				[
					'label' => __( 'Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar ),
				]
			);
			
			$this->add_control(
				'image_wrap_el_classes',
				[
					'label' => __( 'Wrap Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'wrap_el_classes', $default_ar ),
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function killarwt_content_wrap_controls( $name = 'content_wrap', $default_ar = array() ) {

			// Content Wrap Style -------------------------------

			$this->start_controls_section(
				"section_controls_{$name}",
				[
					'label' => $this->killarwt_set_control_default_value('tab_label', $default_ar, 'Content Wrap'),
					'tab'   => $this->killarwt_set_control_default_value('tab', $default_ar, Controls_Manager::TAB_STYLE),
				] + (array)$this->killarwt_set_control_default_value('tab_condition', $default_ar, [])
			);
			
			$this->add_responsive_control(
				"{$name}_hor_alignment",
				[
					'label' => __( 'Horizontal Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'hor_alignment', $default_ar ),
					'options' => array_flip( killarwt_horizontal_alignment_array() ),
				]
			);
			
			$this->add_control(
				"{$name}_el_classes",
				[
					'label' => __( 'Wrap Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar ),
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function killarwt_style_general_controls( $default_ar = array() ) {
			
			// General Style -------------------------------
		
			$this->start_controls_section(
				'section_style_general',
				[
					'label' => esc_html__( 'General', 'killarwt-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_responsive_control(
				'wrap_hor_alignment',
				[
					'label' => __( 'Horizontal Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'hor_alignment', $default_ar ),
					'options' => array_flip( killarwt_horizontal_alignment_array() ),
				]
			);
			
			$this->add_responsive_control(
				'wrap_ver_alignment',
				[
					'label' => __( 'Vertical Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'ver_alignment', $default_ar ),
					'options' => array_flip( killarwt_vertical_alignment_array() ),
				]
			);
			
			$this->add_responsive_control(
				'wrap_text_alignment',
				[
					'label' => __( 'Text Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'elementor' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'default' => $this->killarwt_set_control_default_value( 'text_alignment', $default_ar ),
				]
			);
			
			$this->add_control(
				'wrap_el_classes',
				[
					'label' => __( 'Wrap Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar ),
				]
			);
			
			$this->add_control(
				'wrap_id',
				[
					'label' => __( 'Wrap ID', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'id', $default_ar ),
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function killarwt_style_button_controls( $default_ar = array() ) {
			
			// Button Style -------------------------------
		
			$this->start_controls_section(
				'section_style_button',
				[
					'label' => esc_html__( 'Button', 'killarwt-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_control(
				'button_style',
				[
					'label' => __('Style', 'killarwt-core'),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'flat' => esc_html__( 'Flat', 'killarwt-core' ),
						'line' => esc_html__( 'Line', 'killarwt-core' ),
						'outline' => esc_html__( 'Outline', 'killarwt-core' ),
						'underline' => esc_html__( 'Underline', 'killarwt-core' ),
						'text' => esc_html__( 'Text', 'killarwt-core' ),
						'link' => esc_html__( 'Link', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'style', $default_ar, 'flat' ),
					'frontend_available' => true,
				]
			);
			
			$this->add_control(
				'heading_button_normal',
				[
					'label' => esc_html__( 'Button Normal', 'killarwt-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			
			$this->add_control(
				'button_size',
				[
					'label' => __( 'Size', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'font_size', $default_ar, '' ),
					'options' => array_flip( killarwt_button_size_array() ),
					'separator' => 'top',
				]
			);

			$this->add_control(
				'button_font_size',
				[
					'label' => __( 'Font Size', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'font_size', $default_ar, '' ),
					'options' => array_flip( killarwt_font_size_array() ),
					'separator' => 'top',
				]
			);
			
			$this->add_control(
				'button_custom_font_size',
				[
					'label' => __( 'Custom Size', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'custom_font_size', $default_ar, '1em' ),
					'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
					'placeholder' => '',
					'condition' => [
						'button_font_size' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button' => 'font-size: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'button_font_weight',
				[
					'label' => __( 'Font Weight', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'font_weight', $default_ar ),
					'options' => array_flip( killarwt_font_weight_array() ),
				]
			);
			
			$this->add_control(
				'button_font_style',
				[
					'label' => __( 'Font Style', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'font_style', $default_ar ),
					'options' => array_flip( killarwt_font_style_array() ),
				]
			);
			
			$this->add_control(
				'button_text_transform',
				[
					'label' => __( 'Text Transform', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'text_transform', $default_ar ),
					'options' => array_flip( killarwt_text_transform_array() ),
				]
			);
					
			$this->add_control(
				'button_line_height',
				[
					'label' => __( 'Line Height', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'line_height', $default_ar ),
					'description' => __( 'You can add line height in (px,em,rem,%)', 'killarwt-core' ),
					'placeholder' => '',
					'selectors' => [
						'{{WRAPPER}} .kwt-button' => 'line-height: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'button_letter_spacing',
				[
					'label' => __( 'Letter Spacing', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'letter_spacing', $default_ar ),
					'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'killarwt-core' ),
					'placeholder' => '',
					'selectors' => [
						'{{WRAPPER}} .kwt-button' => 'letter-spacing: {{VALUE}};'
					],
				]
			);
			
			$this->add_responsive_control(
				'button_hor_alignment',
				[
					'label' => __( 'Button Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'hor_alignment', $default_ar ),
					'options' => array_flip( killarwt_horizontal_alignment_array() ),
				]
			);
			
			$this->add_responsive_control(
				'button_ver_alignment',
				[
					'label' => __( 'Button Vertical Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'ver_alignment', $default_ar ),
					'options' => array_flip( killarwt_vertical_alignment_array() ),
				]
			);
			
			$this->add_control(
				'button_rounded_cornors',
				[
					'label' => __('Button Corner', 'killarwt-core'),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'rounded_cornors', $default_ar, 'round' ),
					'options' => [
						'default'   => __('Default', 'killarwt-core'),
						'rounded-0'  => __('Rounded - 0', 'killarwt-core'),
						'rounded-1'  => __('Rounded - 1', 'killarwt-core'),
						'rounded-2'  => __('Rounded - 2', 'killarwt-core'),
						'rounded-3'  => __('Rounded - 3', 'killarwt-core'),
						'rounded-4'  => __('Rounded - 4', 'killarwt-core'),
						'rounded-5'  => __('Rounded - 5', 'killarwt-core'),
						'round' => __('Round', 'killarwt-core'),
						'custom' => __('Custom', 'killarwt-core'),
					],
				]
			);
			
			$this->add_responsive_control(
				'button_custom_radius',
				[
					'label' => __('Border Radius', 'killarwt-core'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%', 'rem', 'em'],
					'separator' => 'after',
					'label_block' => true,
					'condition' => [
						'button_rounded_cornors' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
				]
			);
			
			$this->add_control(
				'button_color',
				[
					'label' => __('Button Color', 'killarwt-core'),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'color', $default_ar, 'default' ),
					'options' => array( 'default'   => __('Default', 'killarwt-core') ) + array_flip( killarwt_button_color_array() ) + array( 'custom'   => __('Custom', 'killarwt-core') ),
				]
			);
			
			$this->add_control(
				'button_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'bg_color', $default_ar, '' ),
					'condition' => [
						'button_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button:not(:hover)' => 'background-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'button_text_color',
				[
					'label' => esc_html__( 'Text Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'text_color', $default_ar, '' ),
					'condition' => [
						'button_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button:not(:hover)' => 'color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'button_border_color',
				[
					'label' => esc_html__( 'Border Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'border_color', $default_ar, '' ),
					'condition' => [
						'button_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button:not(:hover)' => 'border-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'heading_button_hover',
				[
					'label' => esc_html__( 'Button Hover', 'killarwt-core' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			
			$this->add_control(
				'button_hover_color',
				[
					'label' => __('Button Hover Color', 'killarwt-core'),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'hover_color', $default_ar, 'default' ),
					'options' => array( 'default'   => __('Default', 'killarwt-core') ) + array_flip( killarwt_button_hover_color_array() ) + array( 'custom'   => __('Custom', 'killarwt-core') ),
				]
			);
			
			$this->add_control(
				'button_bg_hcolor',
				[
					'label' => esc_html__( 'Background Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'bg_hcolor', $default_ar, '' ),
					'condition' => [
						'button_hover_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button:hover' => 'background-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'button_text_hcolor',
				[
					'label' => esc_html__( 'Text Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'text_hcolor', $default_ar, '' ),
					'condition' => [
						'button_hover_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button:hover' => 'color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				'button_border_hcolor',
				[
					'label' => esc_html__( 'Border Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->killarwt_set_control_default_value( 'border_hcolor', $default_ar, '' ),
					'condition' => [
						'button_hover_color' => 'custom'
					],
					'selectors' => [
						'{{WRAPPER}} .kwt-button:hover' => 'border-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_control(
				"button_el_classes",
				[
					'label' => __( "Button Extra Classes", 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar ),
				]
			);
			
			if( isset( $default_ar['wrap_el_classes'] )  ) {
			
				$this->add_control(
					"button_wrap_el_classes",
					[
						'label' => __( "Button Wrap Extra Classes", 'killarwt-core' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => $this->killarwt_set_control_default_value( 'wrap_el_classes', $default_ar ),
					]
				);
			}
			
			$this->end_controls_section();
			
		}
			
		protected function killarwt_responsive_controls( $default_ar = array() ) {

			// Responsive Style -------------------------------

			$this->start_controls_section(
				"section_controls_responsive",
				[
					'label' => $this->killarwt_set_control_default_value('tab_label', $default_ar, 'Responsive'),
					'tab'   => $this->killarwt_set_control_default_value('tab', $default_ar, Controls_Manager::TAB_STYLE),
				] + (array)$this->killarwt_set_control_default_value('tab_condition', $default_ar, [])
			);
			
			$this->add_control(
				'items_col_xxl',
				[
					'label' => esc_html__( 'XX-Large devices', 'killarwt-core' ),
					'description' => __( 'Show numbers of items Large devices (larger desktops, 1400px and up)', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1 - Item', 'killarwt-core' ),
						'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
						'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
						'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
						'5' => esc_html__( '5 - Item(s)', 'killarwt-core' ),
						'6' => esc_html__( '6 - Item(s)', 'killarwt-core' ),
						'7' => esc_html__( '7 - Item(s)', 'killarwt-core' ),
						'8' => esc_html__( '8 - Item(s)', 'killarwt-core' ),
						'9' => esc_html__( '9 - Item(s)', 'killarwt-core' ),
						'10' => esc_html__( '10 - Item(s)', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'xxl', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'items_col_xl',
				[
					'label' => esc_html__( 'X-Large devices', 'killarwt-core' ),
					'description' => __( 'Show numbers of items Large devices (large desktops, 1200px and up)', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1 - Item', 'killarwt-core' ),
						'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
						'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
						'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
						'5' => esc_html__( '5 - Item(s)', 'killarwt-core' ),
						'6' => esc_html__( '6 - Item(s)', 'killarwt-core' ),
						'7' => esc_html__( '7 - Item(s)', 'killarwt-core' ),
						'8' => esc_html__( '8 - Item(s)', 'killarwt-core' ),
						'9' => esc_html__( '9 - Item(s)', 'killarwt-core' ),
						'10' => esc_html__( '10 - Item(s)', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'lg', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'items_col_lg',
				[
					'label' => esc_html__( 'Large devices', 'killarwt-core' ),
					'description' => __( 'Show numbers of items Large devices (desktops, 992px and up)', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1 - Item', 'killarwt-core' ),
						'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
						'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
						'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
						'5' => esc_html__( '5 - Item(s)', 'killarwt-core' ),
						'6' => esc_html__( '6 - Item(s)', 'killarwt-core' ),
						'7' => esc_html__( '7 - Item(s)', 'killarwt-core' ),
						'8' => esc_html__( '8 - Item(s)', 'killarwt-core' ),
						'9' => esc_html__( '9 - Item(s)', 'killarwt-core' ),
						'10' => esc_html__( '10 - Item(s)', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'lg', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'items_col_md',
				[
					'label' => esc_html__( 'Medium devices', 'killarwt-core' ),
					'description' => esc_html__( 'Show numbers of items Medium devices (tablets, less than 992px)', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1 - Item', 'killarwt-core' ),
						'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
						'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
						'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
						'5' => esc_html__( '5 - Item(s)', 'killarwt-core' ),
						'6' => esc_html__( '6 - Item(s)', 'killarwt-core' ),
						'7' => esc_html__( '7 - Item(s)', 'killarwt-core' ),
						'8' => esc_html__( '8 - Item(s)', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'md', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'items_col_sm',
				[
					'label' => esc_html__( 'Small devices', 'killarwt-core' ),
					'description' => esc_html__( 'Show numbers of items Small devices (landscape phones, 576px and up).', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1 - Item', 'killarwt-core' ),
						'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
						'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
						'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
						'5' => esc_html__( '5 - Item(s)', 'killarwt-core' ),
						'6' => esc_html__( '6 - Item(s)', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'sm', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'items_col_xs',
				[
					'label' => esc_html__( 'Extra small devices', 'killarwt-core' ),
					'description' => esc_html__( 'Show numbers of items Extra small devices (portrait phones, less than 576px).', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1 - Item', 'killarwt-core' ),
						'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
						'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'xs', $default_ar, '1' ),
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function killarwt_carousel_controls( $default_ar = array() ) {

			// Carousel -------------------------------

			$this->start_controls_section(
				"section_controls_carousel",
				[
					'label' => $this->killarwt_set_control_default_value('tab_label', $default_ar, 'Carousel Settings'),
					'tab'   => $this->killarwt_set_control_default_value('tab', $default_ar, Controls_Manager::TAB_STYLE),
				] + (array)$this->killarwt_set_control_default_value('tab_condition', $default_ar, [])
			);

			$this->add_control(
				'nums_rows',
				[
					'label' => esc_html__( 'Rows', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1', 'killarwt-core' ),
						'2' => esc_html__( '2', 'killarwt-core' ),
						'3' => esc_html__( '3', 'killarwt-core' ),
						'4' => esc_html__( '4', 'killarwt-core' ),
					],
					'default' => $this->killarwt_set_control_default_value( 'nums_rows', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'carousel_nav',
				[
					'label' => esc_html__( 'Navigation buttons', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'nav', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'carousel_infinite',
				[
					'label' => esc_html__( 'Infinite Scroll', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'infinite', $default_ar, '1' ),
				]
			);
			
			$this->add_control(
				'carousel_dots',
				[
					'label' => esc_html__( 'Dots', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'dots', $default_ar, '0' ),
				]
			);
			
			$this->add_control(
				'carousel_speed',
				[
					'label' => __( 'Speed', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'speed', $default_ar, '500' ),
					'placeholder' => '',
				]
			);
			
			$this->add_control(
				'carousel_autoplay',
				[
					'label' => esc_html__( 'Auto Play', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'autoplay', $default_ar, '0' ),
				]
			);
			
			$this->add_control(
				'carousel_autoplay_speed',
				[
					'label' => __( 'Autoplay time', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'autoplay_speed', $default_ar, '3500' ),
					'placeholder' => '',
					'condition' => [
						'carousel_autoplay' => '1',
					],
				]
			);
			
			$this->add_control(
				'carousel_center_mode',
				[
					'label' => esc_html__( 'Center Mode', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'center_mode', $default_ar, '0' ),
				]
			);
			
			$this->add_responsive_control(
				'carousel_variable_width',
				[
					'label' => esc_html__( 'Variable Width', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'variable_width', $default_ar, '0' ),
				]
			);
			
			$this->add_control(
				'carousel_adaptive_height',
				[
					'label' => esc_html__( 'Adaptive Height', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'killarwt-core' ),
					'label_off' => __( 'No', 'killarwt-core' ),
					'return_value' => '1',
					'default' => $this->killarwt_set_control_default_value( 'adaptive_height', $default_ar, '0' ),
				]
			);
			
			$this->add_control(
				'carousel_el_classes',
				[
					'label' => __( 'Carousel Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar, '' ),
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function killarwt_style_Item_controls( $default_ar = array() ) {
			
			// Item Style -------------------------------
			$this->start_controls_section(
				'section_style_item',
				[
					'label' => esc_html__( 'Item', 'killarwt-core' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_responsive_control(
				'item_ver_alignment',
				[
					'label' => __( 'Vertical Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'ver_alignment', $default_ar, '' ),
					'options' => array_flip( killarwt_vertical_alignment_array() ),
				]
			);
			
			$this->add_responsive_control(
				'item_hor_alignment',
				[
					'label' => __( 'Horizontal Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::SELECT,
					'default' => $this->killarwt_set_control_default_value( 'hor_alignment', $default_ar, '' ),
					'options' => array_flip( killarwt_horizontal_alignment_array() ),
				]
			);

			$this->add_responsive_control(
				"item_alignment",
				[
					'label' => __( 'Alignment', 'killarwt-core' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'elementor' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'default' => $this->killarwt_set_control_default_value( 'alignment', $default_ar ),
				]
			);
			
			$this->add_control(
				'item_el_classes',
				[
					'label' => __( 'Item Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'el_classes', $default_ar, '' ),
				]
			);
			
			$this->add_control(
				'item_wrap_el_classes',
				[
					'label' => __( 'Item Wrap Extra Classes', 'killarwt-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->killarwt_set_control_default_value( 'wrap_el_classes', $default_ar, '' ),
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function killarwt_set_control_default_value( $field, $default_ar, $default = '' ) {
			
			if( !empty( $field ) && !empty( $default_ar ) ) {
				return ( isset( $default_ar[$field] ) ) ? $default_ar[$field] : ( !empty( $default ) ? $default : '' );
			}
			return $default;
		}
	}
}