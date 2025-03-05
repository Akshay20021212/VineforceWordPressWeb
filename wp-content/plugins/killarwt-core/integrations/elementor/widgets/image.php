<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Image
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Image extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-image', KILLAR_ELEXTS_URL . 'assets/js/image.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-image';
	}
	
	public function get_title() {
		return __( 'Image', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-image';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'     => array(
                    'active'  => true
                ),
			]
		);
		
		$this->add_control(
			'image_alt_text',
			[
				'label' => esc_html__( 'Image Alternative Text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'label_block' => true,
				'separator' => 'before',
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
		
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'image_rounded_cornors',
			[
				'label' => esc_html__( 'Rounded Cornors', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => array_flip( killarwt_border_radius_array() ),
				'default' => '',
			]
		);
		
		$this->add_responsive_control(
			'image_alignment',
			[
				'label' => __( 'Alignment', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( killarwt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'image_hover_overlay',
			[
				'label' => esc_html__( 'Hover Overlay Effect', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
	
		$this->add_control(
			'image_el_classes',
			[
				'label' => __( 'Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'image_wrap_el_classes',
			[
				'label' => __( 'Wrap Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_image( $settings );
		
	}
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-image' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Image() );