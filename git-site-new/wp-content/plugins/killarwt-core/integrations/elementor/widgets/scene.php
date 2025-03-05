<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Scene
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Scene extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_script( 'kwt-scene-handle', KILLAR_ELEXTS_URL . 'assets/js/scene.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-scene';
	}
	
	public function get_title() {
		return __( 'Scene', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-animated-headline';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_Gallery',
			[
				'label' => esc_html__( 'Scene', 'killarwt-core' ),
			]
		);
		
		
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image', [
				'label' => __( 'Image', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);
		
		$repeater->add_control(
			'alt', [
				'label' => __( 'Image alternative text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your title', 'killarwt-core' ),
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'animation',
			[
				'label' => __( 'AOS Animation', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip(killarwt_animations_array()),
				'separator' => 'before',
			]
		);
		
		$repeater->add_control(
			'animation_durations',
			[
				'label' => __( 'Animation Duration', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '0', 'killarwt-core' ),
				'placeholder' => '',
				'description' => __( 'Add animation duration values from 0 to 3000, with step 50ms', 'killarwt-core' ),
				'condition' => [
					'animation!' => '',
				],
			]
		);
		
		$repeater->add_control(
			'animation_delay',
			[
				'label' => __( 'Animation delay', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '0', 'killarwt-core' ),
				'placeholder' => '',
				'description' => __( 'Add animation delay values from 0 to 3000, with step 50ms', 'killarwt-core' ),
				'condition' => [
					'animation!' => '',
				],
				'separator' => 'after',
			]
		);
		
		$repeater->add_control(
			'classes',
			[
				'label' => esc_html__( 'Classes', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'label_block' => true,
			]
		);
		
	
		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'killarwt-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);
		
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
		$this->killarwt_style_general_controls( array( 'el_classes' => 'killar-scene w-100' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_scene( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-scene-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Scene() );