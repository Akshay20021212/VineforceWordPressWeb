<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Reviews Tabs
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_ReviewsTabs extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-reviews-tabs-handle', KILLAR_ELEXTS_URL . 'assets/js/reviews-tabs.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-reviews-tabs';
	}
	
	public function get_title() {
		return __( 'Reviews Tabs', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-review';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_reviews_tabs',
			[
				'label' => esc_html__( 'Reviews Tabs', 'killarwt-core' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'icon_type',
			[
				'label' => __( 'Icon Type', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'disc' => 'Disc ( Default )',
					'number' => 'Number',
					'icon' => 'Icon',
					'image' => 'Image',
					'none' => 'None',
				],
				'default' => 'disc',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'killarwt-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'icon_type' => array( 'icon' ),
				),
			]
		);
		
		$repeater->add_control(
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
					'icon_type' => array( 'image' ),
				],
			]
		);
		
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'icon_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'thumbnail',
				'separator' => 'none',
				'condition' => [
					'icon_type' => array( 'image' ),
				],
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
			'name',
			[
				'label' => esc_html__( 'Name', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your name', 'killarwt-core' ),
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
			'image', [
				'label' => __( 'Author Image', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				/* 'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				] */
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'thumbnail',
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
			'rating',
			[
				'label' => __( 'Rating', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'1' 				=> '1',
					'2' 				=> '2',
					'3' 				=> '3',
					'4' 				=> '4',
					'5' 				=> '5',
					'' 					=> 'None',
				],
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
		

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'killarwt-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);
		
		$this->add_control(
			'reviews_style',
			[
				'label' => esc_html__( 'Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'reviews-style1' => esc_html__( 'Style - 1 ( Default )', 'killarwt-core' ),
					'reviews-style2' => esc_html__( 'Style - 2', 'killarwt-core' ),
				],
				'default' => 'review-1',
			]
		);
		
		$this->killarwt_animations_controls();
		
		$this->add_control(
			'el_classes',
			[
				'label' => __( 'Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'col-xl-9 col-lg-12 col-md-12',
			]
		);

		$this->end_controls_section();
		
		// General Style -------------------------------
		$this->killarwt_style_general_controls( array( 'el_classes' => 'testimonial-text5 bg-white text-center pt-70 pb-50 pl-45 pr-45 mb-20 transition5' ) );
				
		// Item Style -------------------------------
		$this->killarwt_style_Item_controls();
		
		// Content Wrap Style -------------------------------
		$this->killarwt_content_wrap_controls();
		
		// Icon Style -------------------------------
		$this->killarwt_style_icon_controls( array('el_classes' => 'mb-0' ) );
		
		// Image Style -------------------------------
		$this->killarwt_style_image_controls();
		
		// Name Style -------------------------------
		$this->killarwt_style_fields_controls( 'name', array( 'class' => '.review-name', 'size' => 'h6', 'el_classes' => 'mb-1' ) );
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'class' => '.review-title', 'size' => 'p' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'class' => '.review-content', 'size' => 'p') );
		
		// Ratings Style -------------------------------
		$this->killarwt_style_fields_controls( 'rating', array( 'class' => '.review-rating', 'size' => 'span', 'color' => 'warning', 'el_classes' => 'review-rate mt-30 mb-22 d-flex justify-content-center align-items-center', 'wrap_el_classes' => '' ) );
		
		// Responsive Style -------------------------------
		$this->killarwt_responsive_controls( array( 'lg' => 3, 'md' => 2, 'sm' => 1, 'xs' => 1 ) );
		
		// Carousel Style -------------------------------
		$this->killarwt_carousel_controls();
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_reviews_tabs( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-reviews-tabs-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_ReviewsTabs() );