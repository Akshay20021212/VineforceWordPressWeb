<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Woo Product Categories
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Woo_Product_Categories extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      	parent::__construct($data, $args);

		wp_register_script('kwt-woo-product-categories-handle', KILLAR_ELEXTS_URL . 'assets/js/woo-product-categories.js', ['elementor-frontend'], KILLARWT_CORE_VERSION, true);
   	}
	
	public function get_name() {
		return 'killar-product-categories';
	}
	
	public function get_title() {
		return __( 'Products Categories', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'eicon-product-categories killar-icon';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}

	public function get_keywords()
	{
		return ['woocommerce', 'categories', 'grid', 'slider'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'killarwt-core' ),
			]
		);

		$this->add_control(
			'view_type',
			[
				'label' => esc_html__( 'Layout', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'grid' => esc_html__( 'Grid', 'killarwt-core' ),
					'carousel' => esc_html__( 'Carousel', 'killarwt-core' ),
				],
				'default' => 'grid',
			]
		);

		$this->add_control(
			'category_style',
			[
				'label'       => esc_html__('Category Style', 'killarwt-core'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'options'     => array(
					'default'     => esc_html__('Default', 'killarwt-core'),
					'box-middle' => esc_html__('Box Middle Style', 'killarwt-core'),
					'box-bottom' => esc_html__('Box Bottom Style', 'killarwt-core'),
				),
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

		$this->start_controls_section(
			'section_product_categories_query',
			[
				'label' => esc_html__( 'Categories Query', 'killarwt-core' ),
			]
		);

		$this->add_control(
			'category_ids',
			array(
				'label'       => esc_html__('Categories', 'killar-core'),
				'description' => esc_html__('List of product categories.', 'killar-core'),
				'type'        => 'wt_autocomplete',
				'search'      => 'killar_get_taxonomies_by_query',
				'render'      => 'killar_get_taxonomies_title_by_id',
				'taxonomy'    => 'product_cat',
				'multiple'    => true,
				'label_block' => true,
			)
		);

		$this->add_control(
			'show_subcategories',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__('Show Subcategories', 'powernode-core'),
			)
		);

		$this->add_control(
			'hide_empty',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__('Hide Empty', 'powernode-core'),
			)
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__('Order by', 'killarwt-core'),
				'description' => esc_html__('Select order type.', 'killarwt-core'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'date',
				'options'     => array(
					''           => '',
					'id'         => esc_html__('ID', 'killarwt-core'),
					'date'       => esc_html__('Date', 'killarwt-core'),
					'title'      => esc_html__('Title', 'killarwt-core'),
					'menu_order' => esc_html__('Menu order', 'killarwt-core'),
					'modified'   => esc_html__('Last modified date', 'killarwt-core'),
				),
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__('Sort order', 'killarwt-core'),
				'description' => 'Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.',
				'type'        => Controls_Manager::SELECT,
				'default'     => 'desc',
				'options'     => array(
					''     => esc_html__('Inherit', 'killarwt-core'),
					'desc' => esc_html__('Descending', 'killarwt-core'),
					'asc'  => esc_html__('Ascending', 'killarwt-core'),
				),
			]
		);

		$this->add_control(
			'exclude',
			[
				'label'			=> esc_html__('Exclude Products', 'killarwt-core'),
				'type'			=> 'wt_autocomplete',
				'search'		=> 'killar_get_posts_by_query',
				'render'		=> 'killar_get_posts_title_by_id',
				'post_type'		=> 'product',
				'multiple'		=> true,
				'label_block'	=> true,
				'description' 	=> esc_html__('Exclude some products which you do not want to display.', 'killarwt-core'),
				'condition'		=> [
					'data_source!'	=> 'products_ids',
				],
			]
		);

		$this->add_control(
			'number',
			[
				'label' => __('Categories Count', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 4,
				'placeholder' => '',
				'description' => __('Numbers of categories show per page.', 'killarwt-core'),
			]
		);

		$this->end_controls_section();
		
		// Categories Settings -------------------------------
		
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => esc_html__( 'Categories Setttings', 'killarwt-core' ),
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'thumbnail',
				'separator' => 'none',
			]
		);
		
		$this->add_control(
			'show_category_title',
			[
				'label' => esc_html__( 'Show Category Title', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);

		$this->add_control(
			'show_category_product_count',
			[
				'label' => esc_html__('Show Product Count', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->end_controls_section();
		
		// Carousel Settings -------------------------------
		$this->killarwt_carousel_controls(['tab' => '', 'tab_condition' => ['condition' => ['view_type' => ['carousel', 'micro_slider']]]]);

		// Responsive Style -------------------------------
		$this->killarwt_responsive_controls(['tab' => '', 'xxl' => 4, 'xl' => 4, 'lg' => 4, 'md' => 3, 'sm' => 2, 'xs' => 1]);
		
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_product_categories( $settings );
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-woo-product-categories-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Woo_Product_Categories() );