<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Features Box
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class KillarWT_Elementor_Portfolio extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-portfolio-handle', KILLAR_ELEXTS_URL . 'assets/js/portfolio.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-portfolio';
	}
	
	public function get_title() {
		return __( 'Portfolio', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-posts-grid';
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
			'view_type',
			[
				'label' => esc_html__( 'Portfolio View', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'carousel' => esc_html__( 'Carousel (Default)', 'killarwt-core' ),
					'grid-dark' => esc_html__( 'Grid - Dark', 'killarwt-core' ),
					'grid-light' => esc_html__( 'Grid - Light', 'killarwt-core' ),
					'gallery-filter-dark' => esc_html__( 'Gallery Filter - Dark ', 'killarwt-core' ),
					'gallery-filter-light' => esc_html__( 'Gallery Filter - Light ', 'killarwt-core' ),
					'list-light' => esc_html__( 'List - Light', 'killarwt-core' ),
					'list-dark' => esc_html__( 'List - Dark', 'killarwt-core' ),
				],
				'default' => 'carousel',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_style',
			[
				'label' => esc_html__( 'Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'killarwt-core' ),
					'box1' => esc_html__( 'Box Style - 1', 'killarwt-core' ),
					'box2' => esc_html__( 'Box Style - 2', 'killarwt-core' ),
					'box3' => esc_html__( 'Box Style - 3', 'killarwt-core' ),
				],
				'default' => 'box2',
			]
		);
		
		$this->add_control(
			'portfolio_list',
			[
				'label' => __( 'Portfolio', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'multiple' => true,
				'options' => killarwt_portfolioes(),
				'separator' => 'before',
				'condition' => array(
					'view_type' => array( 'carousel', 'gallery-filter-light', 'gallery-filter-dark', 'grid-light', 'grid-dark' ),
				),
			]
		);
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Category', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => killarwt_categories( 'portfolio-cat', 'id' ),
				'condition' => array(
					'view_type' => array( 'carousel' ),
				),
			]
		);
		
		$this->add_control(
			'limit',
			[
				'label' => __( 'Posts Count', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 6,
				'placeholder' => '',
				'description' => __( 'Numbers of items show per page.', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array_flip( array(
                    __('Date','killarwt-core') => 'date',
                    __('Title','killarwt-core') => 'title',
                    __('Random','killarwt-core') => 'rand',
                    __('Number of comments','killarwt-core') => 'comment_count',
                    __('Last modified','killarwt-core') => 'modified',
                ) ),
			]
		);
		
		$this->add_control(
			'order',
			[
				'label' => __( 'Sort Order', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array_flip( array(
                    __('DESC','killarwt-core') => 'DESC',
                    __('ASC','killarwt-core') => 'ASC',
                ) ),
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

		// Portfolio Settings -----------
		
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => esc_html__( 'Portfolio Setttings', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_thumbnail',
			[
				'label' => esc_html__( 'Show Post Image', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'portfolio_loop_post_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'portfolio_loop_post_thumbnail' => '1',
				],
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_title',
			[
				'label' => esc_html__( 'Show Post Title', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_categories',
			[
				'label' => esc_html__( 'Show Category', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_content',
			[
				'label' => esc_html__( 'Post Content', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'excerpt'	=> esc_html__( 'Excerpt', 'killarwt-core' ),
					'0' 		=> esc_html__( 'Hide', 'killarwt-core' ),
				],
				'default' => '0',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 20,
				'placeholder' => '',
				'condition' => [
					'portfolio_loop_post_content' => 'excerpt',
				],
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_read_more',
			[
				'label' => esc_html__( 'Read More', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'link'	 => esc_html__( 'Link (Default)', 'killarwt-core' ),
					'button' => esc_html__( 'Button', 'killarwt-core' ),
					'icon-plus-popup' => esc_html__( 'Icon( Plus ) with Popup', 'killarwt-core' ),
					'icon-elink-popup' => esc_html__( 'Icon( External Link ) with Popup', 'killarwt-core' ),
					'icon-plus-link' => esc_html__( 'Icon( Plus ) with Link', 'killarwt-core' ),
					'icon-elink-link' => esc_html__( 'Icon( External Link ) with Link', 'killarwt-core' ),
					'0' 	 => esc_html__( 'Hide', 'killarwt-core' ),
				],
				'default' => 'icon-elink-popup',
			]
		);
		
		$this->end_controls_section();
		
		// General Style -------------------------------
		$this->killarwt_style_general_controls();
		
		// Item Style -------------------------------
		$this->killarwt_style_Item_controls();
		
		// Responsive Style -------------------------------
		$this->killarwt_responsive_controls( array( 'lg' => 3, 'md' => 2, 'sm' => 2, 'xs' => 1 ) );
		
		// Carousel Style -------------------------------
		$this->killarwt_carousel_controls();
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_portfolio( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-portfolio-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Portfolio() );