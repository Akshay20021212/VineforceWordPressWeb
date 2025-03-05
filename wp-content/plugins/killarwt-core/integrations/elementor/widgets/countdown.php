<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use KillarElementor\IconSelector_Control;

/*
 *  Elementor widget for Countdown
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Countdown extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-countdown-handle', KILLAR_ELEXTS_URL . 'assets/js/countdown.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-countdown';
	}
	
	public function get_title() {
		return __( 'Countdown', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-countdown';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_countdown',
			[
				'label' => esc_html__( 'Countdown', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'launch_date',
			[
				'label' => __( 'Launch Date', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'default' => '',
			]
		);
		
		$this->add_control(
			'days_text',
			[
				'label' => esc_html__( 'Days Text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'default' => esc_html__( 'DAYS', 'killarwt-core' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'hours_text',
			[
				'label' => esc_html__( 'Hours Text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'default' => esc_html__( 'HRS', 'killarwt-core' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'mins_text',
			[
				'label' => esc_html__( 'Mins Text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'default' => esc_html__( 'MIN', 'killarwt-core' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'secs_text',
			[
				'label' => esc_html__( 'Secs Text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'default' => esc_html__( 'SEC', 'killarwt-core' ),
				'label_block' => true,
			]
		);
		
		$this->killarwt_animations_controls();
		
		$this->add_control(
			'el_classes',
			[
				'label' => __( 'Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->end_controls_section();
		
		// General Style -------------------------------
		$this->killarwt_style_general_controls();
		
		// Content Wrap Style -------------------------------
		
		$this->start_controls_section(
			'section_style_counter_wrap',
			[
				'label' => esc_html__( 'Counter Wrap', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'counter_wrap_hor_alignment',
			[
				'label' => __( 'Horizontal Alignment', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( killarwt_horizontal_alignment_array() ),
			]
		);
		
		$this->add_responsive_control(
			'counter_wrap_ver_alignment',
			[
				'label' => __( 'Vertical Alignment', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( killarwt_vertical_alignment_array() ),
			]
		);
		
		$this->add_responsive_control(
			'counter_wrap_alignment',
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
				'default' => '',
			]
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
				'default' => 'default',
			]
		);
		
		$this->add_control(
			'show_counter_devider',
			[
				'label' => esc_html__( 'Show Counter Devider', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'icon_view' => 'default',
				],
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
				'default' => 'circle',
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
				'default' => 'ico-20',
				'options' => array_flip( killarwt_icon_size_array() ),
			]
		);
		
		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'black',
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
				'default' => 'default',
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
		
		$this->add_control(
			'icon_border_color',
			[
				'label' => esc_html__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom'
				],
				'selectors' => [
					'{{WRAPPER}} .fbx-icon' => 'border-color: {{VALUE}};'
				],
			]
		);
		
		$this->add_control(
			'icon_el_classes',
			[
				'label' => __( 'Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'icon_wrap_el_classes',
			[
				'label' => __( 'Icon Wrap Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Devider Style -------------------------------
		$this->start_controls_section(
			'section_style_devider',
			[
				'label' => esc_html__( 'Devider', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'show_counter_devider',
							'operator' => '=',
							'value' => '1',
						],
					],
				],
			]
		);
		
		$this->add_control(
			'devider_size',
			[
				'label' => __( 'Devider Size', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '1px',
				'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
				'placeholder' => '',
				'selectors' => [
					'{{WRAPPER}} .bx-cbox:after' => 'border-size: {{VALUE}};'
				],
			]
		);
		
		$this->add_control(
			'devider_style',
			[
				'label' => __( 'Devider Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'killarwt-core' ),
					'solid' => esc_html__( 'Solid', 'killarwt-core' ),
					'dotted' => esc_html__( 'dotted', 'killarwt-core' ),
					'dashed' => esc_html__( 'dashed', 'killarwt-core' ),
				],
				'selectors' => [
					'{{WRAPPER}} .bx-cbox:after' => 'border-style: {{VALUE}};'
				],
			]
		);
		
		$this->add_control(
			'devider_color_custom',
			[
				'label' => __( 'Custom Color', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bx-cbox:after' => 'border-color: {{VALUE}};'
				],
			]
		);
	
		$this->end_controls_section();
		
		// Counter Style -------------------------------
		$this->killarwt_style_fields_controls( 'number', array( 'label' => 'Number', 'class'=> '.bx-number', 'size' => 'span', 'font-size' => 'xl', 'font_weight' => 'bold' ) );
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'span', 'size' => 'sm', 'font_weight' => 'medium', 'color' => 'gray' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_countdown( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-countdown-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Countdown() );