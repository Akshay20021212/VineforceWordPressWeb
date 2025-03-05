<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for accordion
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Accordian extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-accordion', KILLAR_ELEXTS_URL . 'assets/js/accordion.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-accordion';
	}
	
	public function get_title() {
		return __( 'Accordion', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-accordion';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_list',
			[
				'label' => esc_html__( 'General', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'accordion_style',
			[
				'label' => esc_html__( 'Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'fancy' => esc_html__( 'Fancy ( Default )', 'killarwt-core' ),
					'box' => esc_html__( 'Box', 'killarwt-core' ),
				],
				'default' => 'fancy',
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
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'content',
			[
				'label' => 'Content',
				'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Enter your content', 'killarwt-core' ),
				'rows' => 10,
				'separator' => 'none',
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
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'killarwt-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
				),
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'icon_active',
			[
				'label'     => esc_html__( 'Active Icon', 'killarwt-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-minus',
					'library' => 'fa-solid',
				),
			]
		);
		
		$this->add_control(
			'active_first_accordion',
			[
				'label'     => esc_html__( 'Active First Accordion', 'killarwt-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 0,				
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
		$this->killarwt_style_general_controls( );
		
		// Item Style -------------------------------
		$this->killarwt_style_Item_controls();
		
		// Icon Style -------------------------------
		$this->killarwt_style_icon_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h6', 'el_classes' => 'btn btn-custom card-header card-header-top rounded-0 bg-transparent mb-0' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'div' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_accordion( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-accordion' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Accordian() );