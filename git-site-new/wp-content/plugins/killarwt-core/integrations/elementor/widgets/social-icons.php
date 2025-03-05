<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use KillarElementor\IconSelector_Control;

/*
 *  Elementor widget for ImageCarousel
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_SocialIcons extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-social-icons-handle', KILLAR_ELEXTS_URL . 'assets/js/social-icons.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-social-icons';
	}
	
	public function get_title() {
		return __( 'Social Icons', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-social-icons';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_social_icons',
			[
				'label' => esc_html__( 'Icons', 'killarwt-core' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'facebook',
				'options' => array_flip(killarwt_social_icons_array()),
			]
		);
		
		$repeater->add_control(
			'icon_alt_custom', [
				'label' => __( 'Image alternative text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'condition' => [
					'icon' => 'custom',
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
			'icon_items',
			[
				'label' => __( 'Icons', 'killarwt-core' ),
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
				'default' => '',
			]
		);

		$this->end_controls_section();
		
		// General Style -------------------------------
		$this->killarwt_style_general_controls();
		
		// Social Icon Style -------------------------------
		$this->killarwt_style_social_icons_controls();
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_social_icons( $settings );
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-social-icons' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_SocialIcons() );