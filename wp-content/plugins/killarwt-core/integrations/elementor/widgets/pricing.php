<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use KillarElementor\IconSelector_Control;

/*
 *  Elementor widget for Team Member
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Pricing extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-pricing', KILLAR_ELEXTS_URL . 'assets/js/pricing.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-pricing';
	}
	
	public function get_title() {
		return __( 'Pricing', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-price-table';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'pricing_box_type',
			[
				'label' => __( 'Pricing Box Type', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'monthly' => 'Monthly',
					'annualy' => 'Annualy',
					'monthly-annualy' => 'Monthly - Annualy',
				],
				'default' => 'monthly',
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
				'default' => 'none',
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

		$this->add_control(
			'icon_class',
			[
				'label' => __( 'Icon Class', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1', 'killarwt-core' ),
				'placeholder' => '',
				'condition' => [
					'icon_type' => 'text',
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
				'default' => esc_html__( 'Starter', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Enter the title', 'killarwt-core' ),
				'label_block' => true,
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
				'default' => esc_html__( 'For individual use', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Enter the description', 'killarwt-core' ),
				'rows' => 10,
				'separator' => 'after',
				'label_block' => true,
			]
		);
		
		// Content List -------------------------------
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
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
	
		$repeater->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'killarwt-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-strong',
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
					'icon_type' => 'image',
				],
			]
		);
		
		$repeater->add_group_control(
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
		
		$repeater->add_control(
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
		 
		$repeater->add_control(
			'icon_alt', [
				'label' => __( 'Icon alternative text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'icon_class',
			[
				'label' => __( 'Icon Class', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
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
				'default' => '',
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'content_items',
			[
				'label' => __( 'Content List', 'killarwt-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => esc_html__( '5 dashboard panel', 'killarwt-core' ),
					],
					[
						'title' => esc_html__( '50 widge area', 'killarwt-core' ),
					],
					[
						'title' => esc_html__( '30 tool intigration', 'killarwt-core' ),
					],
					[
						'title' => esc_html__( 'Lifetime Updates', 'killarwt-core' ),
					],
					[
						'title' => esc_html__( '2 tb storage', 'killarwt-core' ),
					],
				],
			]
		);
		
		$this->add_control(
			'price_amount_m',
			[
				'label' => 'Monthly Price',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( '0', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Ex: 199', 'killarwt-core' ),
				'separator' => 'before',
				'condition' => [
					'pricing_box_type' => array( 'monthly', 'monthly-annualy' ),
				],
			]
		);

		$this->add_control(
			'price_amount_y',
			[
				'label' => 'Yearly Price',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( '0', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Ex: 199', 'killarwt-core' ),
				'separator' => 'after',
				'condition' => [
					'pricing_box_type' => array( 'annualy', 'monthly-annualy' ),
				],
			]
		);
		
		$this->add_control(
			'price_currency',
			[
				'label' => 'Currency',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( '$', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Ex: $', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'price_prefix',
			[
				'label' => 'Prefix',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( '.99', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Ex: 99', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'price_validity',
			[
				'label' => 'Validity',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Per Month', 'killarwt-core' ),
				'placeholder' => esc_html__( 'Ex: /mo', 'killarwt-core' ),
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Sign Up', 'killarwt-core' ),
				
			]
		);
		
		$this->add_control(
			'button_link',
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
		
		// Price Box Wrap Section -------------------------------
		
		$this->start_controls_section(
			'section_style_pricing_box_wrap',
			[
				'label' => esc_html__( 'Price Box', 'killarwt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'add_pricing_box_shadow',
			[
				'label' => esc_html__( 'Add Box Shadow', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'pricing_box_bg_color',
			[
				'label' => __( 'Icon Color', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'white',
				'options' => array_flip(killarwt_bg_color_array()),
			]
		);
		
		$this->end_controls_section();
		
		// Icon Style -------------------------------
		$this->killarwt_style_icon_controls( array( 'color' => 'theme' ) );
		
		// Content Wrap Style -------------------------------
		$this->killarwt_content_wrap_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'h5' ) );
		
		// Content List Style --------------------------------------
		$this->killarwt_style_fields_controls( 'content_list', array( 'label' => 'Content List', 'class'=> '.bx-content-list', 'size' => 'span', 'el_classes' => 'd-flex align-items-center mb-12' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'span' ) );
		
		// Price Style --------------------------------------
		$this->killarwt_style_fields_controls( 'price', array( 'label' => 'Price', 'class'=> '.bx-price', 'size' => 'h3', 'font_size' => 'xl', 'el_classes' => '', 'wrap_el_classes' => 'mb-35' ) );

		// Currency Style --------------------------------------
		$this->killarwt_style_fields_controls( 'price_currency', array( 'label' => 'Price Currency', 'class'=> '.bx-price-currency', 'size' => 'span', 'el_classes' => '' ) );
		
		// Price Prefix Style --------------------------------------
		$this->killarwt_style_fields_controls( 'price_prefix', array( 'label' => 'Price Prefix', 'class'=> '.bx-price-prefix', 'size' => 'span', 'el_classes' => '' ) );
		
		// Button Style -------------------------------
		$this->killarwt_style_button_controls( array( 'color' => 'tra-theme' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_pricing( $settings, $settings['content'] );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-pricing-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Pricing() );