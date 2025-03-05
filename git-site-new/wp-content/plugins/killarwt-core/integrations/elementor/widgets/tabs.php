<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Tabs
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Tabs extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-tabs', KILLAR_ELEXTS_URL . 'assets/js/tabs.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-tabs';
	}
	
	public function get_title() {
		return __( 'Tabs', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-tabs';
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
		
		require KILLARWT_CORE_INC_DIR.'/icons_list.php';
		
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
				'type' => Controls_Manager::TEXTAREA,
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

		$this->add_responsive_control(
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'killarwt-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
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

		// Tab Nav Style -------------------------------
		$this->killarwt_content_wrap_controls( 'tab_nav_wrap', ['tab_label' => 'Tab Nav', 'hor_alignment' => 'center' ] );
		
		// Icon Style -------------------------------
		$this->killarwt_style_icon_controls( ['tab_label' => 'Tab Nav Icon'] );
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', ['label' => 'Tab Nav Title', 'size' => 'h6'] );

		// Content Wrap Style -------------------------------
		$this->killarwt_content_wrap_controls('content_wrap', ['tab_label' => 'Tab Content Wrap'] );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', ['label' => 'Tab Content', 'size' => 'div'] );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_tabs( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-icon-list' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Tabs() );