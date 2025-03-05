<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use KillarElementor\IconSelector_Control;

/*
 *  Elementor widget for Features Box
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_FeaturesBox extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-features-box', KILLAR_ELEXTS_URL . 'assets/js/features-box.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-features-box';
	}
	
	public function get_title() {
		return __( 'Features Box', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-icon-box';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_features',
			[
				'label' => esc_html__( 'Features Box', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'icon_type',
			[
				'label' => __( 'Icon Type', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'icon' => 'Icon',
					'text' => 'Text',
					'image' => 'Image',
				],
				'default' => 'icon',
			]
		);
	
		$this->add_control(
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
		
		$this->add_control(
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
					'icon_type' => 'image',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'icon_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);
		
		$this->add_control(
			'icon_text',
			[
				'label' => __( 'Icon Text', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1', 'killarwt-core' ),
				'placeholder' => '',
				'condition' => [
					'icon_type' => 'text',
				],
			]
		);

		$this->add_responsive_control(
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'killarwt-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'killarwt-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'killarwt-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'killarwt-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'icon_type',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
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
				'default' => esc_html__( 'Add Your Title Text Here', 'killarwt-core' ),
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
				'separator' => 'before',
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
		
		// Icon Style -------------------------------
		$this->killarwt_style_icon_controls();
		
		// Content Wrap Style -------------------------------
		$this->killarwt_content_wrap_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h6' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_features_box( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-features-box' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_FeaturesBox() );