<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size; 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Video extends KillarWT_Elementor_Widget_Base {
	
	public function get_name() {
		return 'killar-video';
	}
	
	public function get_title() {
		return __( 'Video', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-video';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		public function __construct($data = [], $args = null) {
		  parent::__construct($data, $args);

		  wp_register_script( 'kwt-video-handle', KILLAR_ELEXTS_URL . 'assets/js/video.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
		}
		
		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__( 'Video', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Url', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => esc_html__( 'Enter your URL', 'elementor' ) . ' (YouTube)',
				'default' => '',
				'label_block' => true,
				'frontend_available' => true,
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
			'image_rounded_cornors',
			[
				'label' => esc_html__( 'Rounded Cornors', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' 				=> esc_html__( 'Default', 'killarwt-core' ),
					'rounded-0' 	=> esc_html__( 'No', 'killarwt-core' ),
					'rounded' 		=> esc_html__( 'Rounded', 'killarwt-core' ),
					'rounded-sm'	=> esc_html__( 'Rounded Small', 'killarwt-core' ),
					'rounded-lg' 	=> esc_html__( 'Rounded Large', 'killarwt-core' ),
				],
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
			'animation',
			[
				'label' => __( 'Animation', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => array_flip(killarwt_animations_array()),
			]
		);
		$this->add_control(
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
		$this->add_control(
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
		
		$this->add_control(
			'wrap_el_classes',
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
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-video-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Video() );