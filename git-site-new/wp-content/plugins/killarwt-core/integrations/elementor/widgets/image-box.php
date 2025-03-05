<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Image Box
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_ImageBox extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-image-box', KILLAR_ELEXTS_URL . 'assets/js/image-box.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-image-box';
	}
	
	public function get_title() {
		return __( 'Image Box', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-image-box';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image Box', 'killarwt-core' ),
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
		
		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'     => array(
                    'active'  => true
                ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);
		
		$this->add_control(
			'image_alt_text', [
				'label' => __( 'Image alternative text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'This is the heading', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Enter your title', 'killarwt-core' ),
				'label_block' => true,
				'separator' => 'before',
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
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
			]
		);
		
		$this->add_control(
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
		
		// Image Style -------------------------------
		$this->killarwt_style_image_controls();
		
		// Content Wrap Style -------------------------------
		$this->killarwt_content_wrap_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h3' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_image_box( $settings, $settings['content'] );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-image-box-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_ImageBox() );