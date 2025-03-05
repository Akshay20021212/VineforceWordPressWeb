<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Woo Products
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Woo_Products extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      	parent::__construct($data, $args);

		wp_register_script('kwt-woo-products-handle', KILLAR_ELEXTS_URL . 'assets/js/woo-products.js', ['elementor-frontend'], KILLARWT_CORE_VERSION, true);
   	}
	
	public function get_name() {
		return 'killar-products';
	}
	
	public function get_title() {
		return __( 'Products ( Grid & Carousel )', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'eicon-products killar-icon';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}

	public function get_keywords()
	{
		return ['woocommerce', 'product', 'grid', 'slider'];
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
			'product_style',
			[
				'label'       => esc_html__('Products Style', 'killarwt-core'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''     => esc_html__('Default', 'killarwt-core'),
					'full-info' => esc_html__('Full Info', 'killarwt-core'),
					'horizontal' => esc_html__('Horizontal', 'killarwt-core'),
				),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__('Show Title', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'product_style' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => esc_html__('Show Image', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'product_style' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'image_style',
			[
				'label'       => esc_html__('Image Swap Style', 'killarwt-core'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''     => esc_html__('Default', 'killarwt-core'),
					'image-swap' => esc_html__('Image Swap', 'killarwt-core'),
					'image-slider'  => esc_html__('Image Slider', 'killarwt-core'),
				),
				'condition' => [
					'product_style!' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'image_swap_style',
			[
				'label'       => esc_html__('Image Swap Effect', 'killarwt-core'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'fade',
				'options'     => array(
					'fade'     => esc_html__('Fade', 'killarwt-core'),
					'flip' => esc_html__('Flip', 'killarwt-core'),
					'vslide'  => esc_html__('Verticle Slide', 'killarwt-core'),
				),
				'condition'		=> [
					'image_style'	=> 'image-swap',
					'product_style!' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_badges',
			[
				'label' => esc_html__('Show Badges', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
				'condition' => [
					'product_style!' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_categories',
			[
				'label' => esc_html__('Show Categories', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
				'condition' => [
					'product_style!' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_ratings',
			[
				'label' => esc_html__('Show Ratings', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
			]
		);

		$this->add_control(
			'show_ratings_count',
			[
				'label' => esc_html__('Show Ratings Count', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'product_style!' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_price',
			[
				'label' => esc_html__('Show Price', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
				
			]
		);

		$this->add_control(
			'show_short_description',
			[
				'label' => esc_html__('Show Short Description(Excerpt)', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
				'condition' => [
					'product_style' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_addtocart',
			[
				'label' => esc_html__('Show AddtoCart', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
				'condition' => [
					'product_style' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_quickview',
			[
				'label' => esc_html__('Show Quickview', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'product_style!' => array('full-info' ) ,
				],
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label' => esc_html__('Show Meta', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
				'condition' => [
					'product_style' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_sharing',
			[
				'label' => esc_html__('Show Sharing', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '1',
				'condition' => [
					'product_style' => array('full-info'),
				],
			]
		);

		$this->add_control(
			'show_product_link',
			[
				'label' => esc_html__('Show Product Link', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'killarwt-core'),
				'label_off' => __('No', 'killarwt-core'),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'product_style' => array('full-info'),
				],
			]
		);	

		$this->killarwt_animations_controls();

		$this->add_control(
			'el_classes',
			[
				'label' => __('Extra Classes', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_products_query',
			[
				'label' => esc_html__( 'Products Query', 'killarwt-core' ),
			]
		);

		$this->add_control(
			'data_source',
			[
				'label' => esc_html__( 'Data Source', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'all_products' => esc_html__( 'All Products', 'killarwt-core' ),
					'featured_products' => esc_html__( 'Featured', 'killarwt-core' ),
					'sale_products' => esc_html__( 'Sale', 'killarwt-core' ),
					'best_selling_products' => esc_html__( 'Best Selling', 'killarwt-core' ),
					'top_rated_products' => esc_html__( 'Top Rated', 'killarwt-core' ),
					'products_ids' => esc_html__( 'Manual Selection', 'killarwt-core' ),
				],
				'default' => 'all_products',
			]
		);

		$this->add_control(
			'include',
			[
				'label'       => esc_html__('Include only', 'killarwt-core' ),
				'description' => esc_html__('Add products by title.', 'killarwt-core' ),
				'type'        => 'wt_autocomplete',
				'search'      => 'killar_get_posts_by_query',
				'render'      => 'killar_get_posts_title_by_id',
				'post_type'   => 'product',
				'multiple'    => true,
				'label_block' => true,
				'condition' => [
					'data_source' => 'products_ids',
				],
				'wpml' => false
			]
		);

		$this->add_control(
			'categories',
			[
				'label' 		=> esc_html__('Categories', 'killarwt-core'),
				'description' => esc_html__('List of product categories.', 'killarwt-core'),
				'type' 		  	=> 'wt_autocomplete',
				'search'      	=> 'killar_get_taxonomies_by_query',
				'render'      	=> 'killar_get_taxonomies_title_by_id',
				'taxonomy'		=> [ 'product_cat', 'product_tag' ],
				'label_block' 	=> true,
				'multiple'		=> true,
				'default'    	=> [],
				'condition'		=> [
					'data_source!'	=> 'products_ids',
				],
			]
		);

		$this->add_control(
			'tags',
			[
				'label' 		=> esc_html__('Tags', 'killarwt-core'),
				'description' => esc_html__('List of product tags.', 'killarwt-core'),
				'type' 		  	=> 'wt_autocomplete',
				'search'      	=> 'killar_get_taxonomies_by_query',
				'render'      	=> 'killar_get_taxonomies_title_by_id',
				'taxonomy'		=> ['product_tag'],
				'label_block' 	=> true,
				'multiple'		=> true,
				'default'    	=> [],
				'condition'		=> [
					'data_source!'	=> 'products_ids',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__('Order by', 'killarwt-core'),
				'description' => esc_html__('Select order type.', 'killarwt-core'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'date',
				'options'     => array(
					''               => '',
					'date'           => esc_html__('Date', 'killarwt-core'),
					'id'             => esc_html__('ID', 'killarwt-core'),
					'author'         => esc_html__('Author', 'killarwt-core'),
					'title'          => esc_html__('Title', 'killarwt-core'),
					'modified'       => esc_html__('Last modified date', 'killarwt-core'),
					'comment_count'  => esc_html__('Number of comments', 'killarwt-core'),
					'menu_order'     => esc_html__('Menu order', 'killarwt-core'),
					'rand'           => esc_html__('Random order', 'killarwt-core'),
					'price'          => esc_html__('Price', 'killarwt-core'),
				),
				'condition'   => array(
					'data_source!' => array('recently_viewed', 'top_rated_products'),
				),
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__('Sort order', 'killarwt-core'),
				'description' => 'Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.',
				'type'        => Controls_Manager::SELECT,
				'default'     => 'DESC',
				'options'     => array(
					'DESC' => esc_html__('Descending', 'killarwt-core'),
					'ASC'  => esc_html__('Ascending', 'killarwt-core'),
				),
				'condition' => [
					'data_source!' => 'products_ids',
				],
				
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
			'limit',
			[
				'label' => __('Posts Count', 'killarwt-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 6,
				'placeholder' => '',
				'description' => __('Numbers of items show per page.', 'killarwt-core'),
			]
		);

		$this->end_controls_section();

		// Carousel Settings -------------------------------
		$this->killarwt_carousel_controls( [ 'tab' => '', 'tab_condition' => [ 'condition' => ['view_type' => ['carousel', 'micro_slider']] ] ] );

		// Responsive Style -------------------------------
		$this->killarwt_responsive_controls(['tab' => '', 'xxl' => 4, 'xl' => 4, 'lg' => 4, 'md' => 3, 'sm' => 2, 'xs' => 1] );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_products( $settings );
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-woo-products-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Woo_Products() );