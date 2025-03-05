<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/*
 *  Elementor widget for Text
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Text extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
	  parent::__construct($data, $args);

	  wp_register_script( 'kwt-text-handle', KILLAR_ELEXTS_URL . 'assets/js/text.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
	}
	
	public function get_name() {
		return 'killar-text';
	}
	
	public function get_title() {
		return __( 'Text', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-text';
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
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_text( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-text-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Text() );