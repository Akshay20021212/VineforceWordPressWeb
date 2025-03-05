<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use KillarElementor\IconSelector_Control;

/*
 *  Elementor widget for Progress Bar
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_ProgressBar extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-progress-bar', KILLAR_ELEXTS_URL . 'assets/js/progress-bar.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-progress-bar';
	}
	
	public function get_title() {
		return __( 'Progress Bar', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-skill-bar';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_progress_bar',
			[
				'label' => esc_html__( 'Progress Bar', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'progress_bar_style',
			[
				'label' => __( 'Style', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style1' => 'Style - 1 ( Default )',
					'style2' => 'Style - 2 ( Default )',
					'style3' => 'Style - 3 ( Default )',
				],
				'default' => 'style1',
				'separator' => 'before',
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'killarwt-core' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);
		
		$repeater->add_control(
			'unit',
			[
				'label' => esc_html__( 'Unit', 'killarwt-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'separator' => 'before',
			]
		);
		
		$repeater->add_control(
			'pb_bg_color',
			[
				'label' => __( 'Color', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(killarwt_bg_color_array()),
			]
		);
		
		$repeater->add_control(
			'pb_bg_color_custom',
			[
				'label' => __( 'Color Custom', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'pb_bg_color' => 'custom',
				],
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
			'progress_bar_stripe',
			[
				'label' => esc_html__( 'Add Stripe', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'progress_bar_stripe_animation',
			[
				'label' => esc_html__( 'Add Stripe Animation', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'progress_bar_stripe!' => '',
				],
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
		
		// Item Style -------------------------------
		$this->killarwt_style_Item_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h4', 'wrap_el_classes' => 'bar-title' ) );
		
		// Progress Bar Style -------------------------------
		$this->killarwt_style_fields_controls( 'progress_bar', array( 'label' => 'Progress Bar', 'class' => '.progress-bar', 'size' => 'div', 'color' => 'theme', 'wrap_el_classes' => '' ) );
		
		// Unit Style -------------------------------
		$this->killarwt_style_fields_controls( 'unit', array( 'label' => 'Unit', 'class' => '.bx-unit', 'size' => 'span' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_progress_bar( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-progress-bar' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_ProgressBar() );