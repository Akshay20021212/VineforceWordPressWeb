<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for List
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_IconList extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-icon-list', KILLAR_ELEXTS_URL . 'assets/js/icon-list.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-icon-list';
	}
	
	public function get_title() {
		return __( 'List', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-bullet-list';
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
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'List Item', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'item_alignment',
			[
				'label' => __( 'List Alignment', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ver',
				'options' => array_flip( killarwt_alignment_array() ),
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
			'show_item_devider',
			[
				'label' => esc_html__( 'Show Items Devider', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'item_color',
			[
				'label' => __( 'Color', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(killarwt_color_array()),
			]
		);
		
		$this->add_control(
			'item_color_custom',
			[
				'label' => __( 'Custom Color', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'item_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .kwt-list li' => 'color: {{VALUE}};'
				],
			]
		);
		
		$this->add_control(
			'item_gap',
			[
				'label' => __( 'List Item Gap', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
				'placeholder' => '',
				'selectors' => [
					'{{WRAPPER}} .kwt-list li' => 'margin-bottom: {{VALUE}};'
				],
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
		
		$this->add_control(
			'item_inn_el_classes',
			[
				'label' => __( 'Item Inn Extra Classes', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Devider Style -------------------------------
		
		$this->start_controls_section(
			'section_style_devider',
			[
				'label' => esc_html__( 'Devider', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'show_item_devider',
							'operator' => '=',
							'value' => '1',
						],
					],
				],
			]
		);
		
		$this->add_control(
			'devider_size',
			[
				'label' => __( 'Devider Size', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '1px',
				'description' => __( 'You can add size in (px,em,rem,%)', 'killarwt-core' ),
				'placeholder' => '',
				'condition' => [
					'item_alignment' => array('ver'),
				],
			]
		);
		
		$this->add_control(
			'devider_style',
			[
				'label' => __( 'Devider Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'killarwt-core' ),
					'solid' => esc_html__( 'Solid', 'killarwt-core' ),
					'dotted' => esc_html__( 'dotted', 'killarwt-core' ),
					'dashed' => esc_html__( 'dashed', 'killarwt-core' ),
				],
				'condition' => [
					'item_alignment' => array('ver'),
				],
			]
		);
		
		$this->add_control(
			'devider_color_custom',
			[
				'label' => __( 'Custom Color', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .item-devider.list-align-hor li:after' => 'color: {{VALUE}};'
				],
			]
		);
	
		$this->end_controls_section();
		
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
		echo killarwt_icon_list( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-icon-list' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_IconList() );