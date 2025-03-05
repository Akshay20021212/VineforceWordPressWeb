<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for ScreenshotsCarousel
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_ScreenshotsCarousel extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-screenshots-carousel-handle', KILLAR_ELEXTS_URL . 'assets/js/screenshots-carousel.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-screenshots-carousel';
	}
	
	public function get_title() {
		return __( 'Screenshots Carousel', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-slider-push';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_screenshots_carousel',
			[
				'label' => esc_html__( 'Screenshot Carousel', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'image_box_style',
			[
				'label' => esc_html__( 'Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'killarwt-core' ),
					'style-1' => esc_html__( 'Style - 1', 'killarwt-core' ),
					'style-2' => esc_html__( 'Style - 2', 'killarwt-core' ),
				],
				'default' => 'default',
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
			'link',
			[
				'label' => esc_html__( 'Link', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( '//your-link.com', 'killarwt-core' ),
				'default' => [
					'url' => '',
				],
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
			'content',
			[
				'label' => esc_html__( 'Content', 'killarwt-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your content', 'killarwt-core' ),
				'rows' => 6,
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
		
		$this->killarwt_animations_controls();
		
		$this->add_control(
			'el_classes',
			[
				'label' => __( 'Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'pt-200',
			]
		);

		$this->end_controls_section();
		
		// General Style -------------------------------
		$this->killarwt_style_general_controls( );
		
		// Item Style -------------------------------
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'List Item', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'item_ver_alignment',
			[
				'label' => __( 'Vertical Alignment', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( killarwt_vertical_alignment_array() ),
			]
		);
		
		$this->add_responsive_control(
			'item_hor_alignment',
			[
				'label' => __( 'Horizontal Alignment', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( killarwt_horizontal_alignment_array() ),
			]
		);
		
		$this->add_control(
			'item_wrap_el_classes',
			[
				'label' => __( 'Item Wrap Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'item_el_classes',
			[
				'label' => __( 'Item Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Image Style -------------------------------
		$this->killarwt_style_image_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h5' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_screenshots_carousel( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-screenshots-carousel-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_ScreenshotsCarousel() );