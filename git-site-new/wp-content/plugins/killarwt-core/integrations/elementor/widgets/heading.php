<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

/*
 *  Elementor widget for Heading
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Heading extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-heading', KILLAR_ELEXTS_URL . 'assets/js/heading.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-heading';
	}
	
	public function get_title() {
		return __( 'Heading', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-heading';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Heading', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'sub_title',
			[
				'label' => 'Sub Title',
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'rows' => 2,
				'separator' => 'none',
				'show_label' => true,
			]
		);
		
		$this->add_control(
			'title',
			[
				'label' => 'Title',
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Enter your title', 'killarwt-core' ),
				'rows' => 3,
				'separator' => 'none',
				'show_label' => true,
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
				'default' => '',
				'rows' => 8,
				'separator' => 'none',
				'show_label' => true,
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
		
		// Sub Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'sub_title', array( 'label' => 'Sub Title', 'size' => 'span', 'font_weight' => 'bold' ) );
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h3' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_heading( $settings, $settings['content'] );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-heading' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Heading() );