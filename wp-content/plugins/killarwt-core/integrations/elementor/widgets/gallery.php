<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for ImageCarousel
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Gallery extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_script( 'kwt-gallery-handle', KILLAR_ELEXTS_URL . 'assets/js/gallery.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-gallery';
	}
	
	public function get_title() {
		return __( 'Gallery', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-gallery-justified';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_Gallery',
			[
				'label' => esc_html__( 'Gallery', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'gallery_style',
			[
				'label' => esc_html__( 'Gallery Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'grid' => esc_html__( 'Grid ( Default )', 'killarwt-core' ),
					'masonry' => esc_html__( 'Masonry', 'killarwt-core' ),
				],
				'default' => 'grid',
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
			'image_alt_text', [
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
		
		$repeater->add_control(
			'use_link',
			[
				'label' => esc_html__( 'Use link as', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'killarwt-core' ),
					'link' => esc_html__( 'Link', 'killarwt-core' ),
					'lightbox' => esc_html__( 'Lightbox', 'killarwt-core' ),
				],
				'default' => '',
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
			'grid_padding',
			[
				'label' => esc_html__( 'Grid Padding', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'With Padding ( Default )', 'killarwt-core' ),
					'gutter-0' => esc_html__( 'Without Padding', 'killarwt-core' ),
				],
				'default' => '',
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
		
		// Image Style -------------------------------
		$this->killarwt_style_image_controls();
		
		// Content Wrap Style -------------------------------
		$this->killarwt_content_wrap_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h3' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
		
		// Responsive Style -------------------------------
		$this->killarwt_responsive_controls( array( 'lg' => '3', 'md' => '3', 'sm' => '2', 'xs' => '1' ) );
		
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_gallery( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-gallery-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Gallery() );