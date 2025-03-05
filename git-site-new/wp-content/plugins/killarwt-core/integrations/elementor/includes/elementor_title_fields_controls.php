<?php
namespace KillarElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Title Style -------------------------------

$this->start_controls_section(
	'section_style_title',
	[
		'label' => esc_html__( 'Title', 'killarwt-core' ),
		'tab'   => Controls_Manager::TAB_STYLE,
	]
);

$this->add_control(
	'title_size',
	[
		'label' => __( 'HTML Tag', 'killarwt-core' ),
		'type' => Controls_Manager::SELECT,
		'default' => 'h5',
		'options' => [
			'h1' 				=> 'h1',
			'h2' 				=> 'h2',
			'h3' 				=> 'h3',
			'h4' 				=> 'h4',
			'h5' 				=> 'h5',
			'h6' 				=> 'h6',
			'div' 				=> 'div',
			'span' 				=> 'span',
			'p' 				=> 'p',
		],
		'separator' => 'top',
	]
);

$this->add_control(
	'title_font_size',
	[
		'label' => __( 'Font Size', 'killarwt-core' ),
		'type' => Controls_Manager::SELECT,
		'default' => '',
		'options' => array_flip( killarwt_font_size_array() ),
		'separator' => 'top',
	]
);

$this->add_control(
	'title_custom_font_size',
	[
		'label' => __( 'Custom Font Size', 'killarwt-core' ),
		'type' => \Elementor\Controls_Manager::TEXT,
		'default' => __( '1em', 'killarwt-core' ),
		'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
		'placeholder' => '',
		'condition' => [
			'title_font_size' => 'custom'
		],
		'selectors' => [
			'{{WRAPPER}} .bx-title' => 'font-size: {{VALUE}};'
		],
	]
);

$this->add_control(
	'title_font_weight',
	[
		'label' => __( 'Font Weight', 'killarwt-core' ),
		'type' => Controls_Manager::SELECT,
		'default' => '',
		'options' => array_flip( killarwt_font_weight_array() ),
	]
);

$this->add_control(
	'title_font_style',
	[
		'label' => __( 'Font Style', 'killarwt-core' ),
		'type' => Controls_Manager::SELECT,
		'default' => '',
		'options' => array_flip( killarwt_font_style_array() ),
	]
);

$this->add_control(
	'title_text_transform',
	[
		'label' => __( 'Text Transform', 'killarwt-core' ),
		'type' => Controls_Manager::SELECT,
		'default' => '',
		'options' => array_flip( killarwt_text_transform_array() ),
	]
);

$this->add_control(
	'title_color',
	[
		'label' => __( 'Color', 'killarwt-core' ),
		'type' => Controls_Manager::SELECT,
		'default' => 'default',
		'options' => array_flip(killarwt_color_array()),
	]
);

$this->add_control(
	'title_color_custom',
	[
		'label' => __( 'Custom Color', 'killarwt-core' ),
		'type' => \Elementor\Controls_Manager::COLOR,
		'default' => '#222',
		'condition' => [
			'title_color' => 'custom',
		],
		'selectors' => [
			'{{WRAPPER}} .bx-title' => 'color: {{VALUE}};'
		],
	]
);

$this->add_control(
	'title_line_height',
	[
		'label' => __( 'Line Height', 'killarwt-core' ),
		'type' => \Elementor\Controls_Manager::TEXT,
		'default' => '',
		'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'killarwt-core' ),
		'placeholder' => '',
		'selectors' => [
			'{{WRAPPER}} .bx-title' => 'line-height: {{VALUE}};'
		],
	]
);

$this->add_control(
	'title_letter_spacing',
	[
		'label' => __( 'Letter Spacing', 'killarwt-core' ),
		'type' => \Elementor\Controls_Manager::TEXT,
		'default' => '',
		'description' => __( 'You can add spacing in (px,em,rem,%)', 'killarwt-core' ),
		'placeholder' => '',
		'selectors' => [
			'{{WRAPPER}} .bx-title' => 'letter-spacing: {{VALUE}};'
		],
	]
);

$this->add_responsive_control(
	'title_alignment',
	[
		'label' => __( 'Alignment', 'killarwt-core' ),
		'type' => Controls_Manager::SELECT,
		'default' => '',
		'options' => array_flip( killarwt_text_alignment_array() ),
	]
);

$this->add_control(
	'title_el_classes',
	[
		'label' => __( 'Title Extra Classes', 'killarwt-core' ),
		'type' => \Elementor\Controls_Manager::TEXT,
		'default' => '',
	]
);

$this->end_controls_section();