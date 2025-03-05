<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use KillarElementor\IconSelector_Control;

/*
 *  Elementor widget for Blockquote
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Blockquote extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-blockquote', KILLAR_ELEXTS_URL . 'assets/js/blockquote.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-blockquote';
	}
	
	public function get_title() {
		return __( 'Blockquote', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-blockquote';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'killarwt-core' ),
			]
		);
		$this->add_control(
			'blockquote_style',
			[
				'label' => __( 'Blockquote Style', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'bordered' => 'Bordered ( default )',
					'icon' => 'Icon',
					'' => 'None',
				],
				'default' => 'bordered',
			]
		);
		
		
		$this->add_control(
			'icon_type',
			[
				'label' => __( 'Icon Type', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'icon' => 'Icon',
					'text' => 'Text',
					'image' => 'Image',
				],
				'default' => 'icon',
				'condition' => array(
					'blockquote_style' => array( 'icon' ),
				),
			]
		);
	
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'killarwt-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'blockquote_style' => array( 'icon' ),
					'icon_type' => array( 'icon' ),
				),
			]
		);
		
		$this->add_control(
			'icon_image',
			[
				'label' => __( 'Image', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'     => array(
                    'active'  => true
                ),
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'icon_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'blockquote_style' => array( 'icon' ),
					'icon_type' => 'image',
				],
			]
		);
		
		$this->add_control(
			'icon_text',
			[
				'label' => __( 'Icon Text', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1', 'killarwt-core' ),
				'placeholder' => '',
				'condition' => [
					'icon_type' => 'text',
				],
			]
		);
		
		$this->add_control(
			'content',
			[
				'label' => 'Content',
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Enter your content', 'killarwt-core' ),
				'rows' => 8,
				'separator' => 'none',
				'show_label' => true,
			]
		);
		
		$this->add_responsive_control(
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'killarwt-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'killarwt-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'killarwt-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'killarwt-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'condition' => array(
					'blockquote_style' => array( 'icon' ),
					'icon_type!' => array( 'none' ),
				),
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
		
		// Border Style -------------------------------
		
		$this->start_controls_section(
			'section_style_devider',
			[
				'label' => esc_html__( 'Border', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'blockquote_style' => array( 'bordered' ),
				),
			]
		);
		
		$this->add_control(
			'bordered_size',
			[
				'label' => __( 'Border Size', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '3px',
				'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
				'placeholder' => '',
				'selectors' => [
					'{{WRAPPER}} .bq-style-borderd .bq-content' => 'border-left-width: {{VALUE}};'
				],
			]
		);
		
		$this->add_control(
			'bordered_style',
			[
				'label' => __( 'Border Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'Default', 'killarwt-core' ),
					'solid' => esc_html__( 'Solid', 'killarwt-core' ),
					'dotted' => esc_html__( 'dotted', 'killarwt-core' ),
					'dashed' => esc_html__( 'dashed', 'killarwt-core' ),
				],
				'selectors' => [
					'{{WRAPPER}} .bq-style-borderd .bq-content' => 'border-left-style: {{VALUE}};'
				],
			]
		);
		
		$this->add_control(
			'bordered_color',
			[
				'label' => __( 'Border Color', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .bq-style-borderd .bq-content' => 'border-left-color: {{VALUE}};'
				],
			]
		);
	
		$this->end_controls_section();
		
		// Icon Style -------------------------------
		$this->killarwt_style_icon_controls();
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_blockquote( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-blockquote-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Blockquote() );