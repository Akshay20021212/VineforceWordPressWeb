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

class KillarWT_Elementor_Blog extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-blog-handle', KILLAR_ELEXTS_URL . 'assets/js/blog.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-blog';
	}
	
	public function get_title() {
		return __( 'Blog', 'killarwt-core' );
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
				'label' => __( 'General', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'view_type',
			[
				'label' => __( 'View', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'grid' => __( 'Grid (Default)', 'killarwt-core' ),
					'slider' => __( 'Slider', 'killarwt-core' ),
					'full' => __( 'Full', 'killarwt-core' ),
					'full-center' => __( 'Full Center', 'killarwt-core' ),
					'list' => __( 'List', 'killarwt-core' ),
					'modern' => __( 'modern', 'killarwt-core' ),
					'gallery-filter' => __( 'Gallery Filter', 'killarwt-core' ),
				],
				'default' => 'grid',
			]
		);
		
		$this->add_control(
			'blog_loop_post_style',
			[
				'label' => __( 'Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'killarwt-core' ),
					'verticle-blog' => __( 'Verticle Blog', 'killarwt-core' ),
					'box' => __( 'Box', 'killarwt-core' ),
				],
				'default' => 'default',
				'condition' => [
					'view_type!' => array( 'list', 'modern', 'full' ),
				],
			]
		);
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Category', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => killarwt_categories( 'category', 'id' ),
				'condition' => [
					'view_type!' => array( 'gallery-filter-dark', 'gallery-filter-light' ),
				],
			]
		);
		
		$this->add_control(
			'include_posts',
			[
				'label' => __( 'Include Posts', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'default' => '',
				'options' => killarwt_blog_posts(),
			]
		);
		
		$this->add_control(
			'exclude_posts',
			[
				'label' => __( 'Exclude Posts', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'default' => '',
				'options' => killarwt_blog_posts(),
			]
		);
		
		$this->add_control(
			'filter_categories',
			[
				'label' => __( 'Categories Filter', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'options' => killarwt_categories( 'category', 'id' ),
				'condition' => [
					'view_type' => array( 'gallery-filter-dark', 'gallery-filter-light' ),
				],
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
		
		// Blog Settings -------------------------------
		
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => __( 'Blog Setttings', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'blog_loop_post_thumbnail',
			[
				'label' => __( 'Show Post Image', 'killarwt-core' ),
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
				'name' => 'blog_loop_post_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'blog_loop_post_thumbnail' => '1',
				],
			]
		);

		$this->add_control(
			'blog_loop_post_categories',
			[
				'label' => __( 'Show Post Category', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'blog_loop_post_title',
			[
				'label' => __( 'Show Post Title', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'blog_loop_post_meta',
			[
				'label' => __( 'Show Post Meta', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'author'        => __( 'Author', 'killarwt-core' ),
					'categories'    => __( 'Categories', 'killarwt-core' ),
					'tags'    		=> __( 'Tags', 'killarwt-core' ),
					'comments'      => __( 'Comments', 'killarwt-core' ),
					'date'          => __( 'Date', 'killarwt-core' ),
					'reading-time'  => __( 'Reading Time', 'killarwt-core' ),
				],
				'default' => [ 'categories', 'date' ],
			]
		);
		
		$this->add_control(
			'blog_loop_post_tags',
			[
				'label' => __( 'Show Post Tags', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'blog_loop_post_content',
			[
				'label' => __( 'Post Content', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'excerpt'	=> __( 'Excerpt', 'killarwt-core' ),
					'full' 		=> __( 'Full', 'killarwt-core' ),
					'0' 		=> __( 'Hide', 'killarwt-core' ),
				],
				'default' => 'excerpt',
			]
		);
		
		$this->add_control(
			'blog_loop_post_excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 20,
				'placeholder' => '',
				'condition' => [
					'blog_loop_post_content' => 'excerpt',
				],
			]
		);
		
		$this->add_control(
			'blog_loop_post_read_more',
			[
				'label' => __( 'Read More', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'link'	 => __( 'Link (Default)', 'killarwt-core' ),
					'button' => __( 'Button', 'killarwt-core' ),
					'icon' => __( 'Icon', 'killarwt-core' ),
					'0' 	 => __( 'Hide', 'killarwt-core' ),
				],
				'default' => 'link',
			]
		);

		$this->add_control(
			'blog_loop_post_pagination_style',
			[
				'label' => __( 'Pagination', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default'			=> __( 'Default', 'killarwt-core' ),
					'infinite-scroll' 	=> __( 'Infinite Scroll', 'killarwt-core' ),
					'load-more' 		=> __( 'Load More', 'killarwt-core' ),
					'0' 				=> __( 'Hide', 'killarwt-core' ),
				],
				'default' => '0',
			]
		);

		$this->add_control(
			'blog_loop_post_pagination_last_text',
			[
				'label' => __( 'Pagination Last Text', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'End of content', 'killarwt-core' ),
				'placeholder' => '',
				'condition' => [
					'blog_loop_post_pagination_style' => array('infinite-scroll', 'load-more'),
				],
			]
		);

		$this->add_control(
			'blog_loop_post_load_more_button_text',
			[
				'label' => __( 'Load More Button Text', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Load More Articles', 'killarwt-core' ),
				'placeholder' => '',
				'condition' => [
					'blog_loop_post_pagination_style' => array('infinite-scroll', 'load-more'),
				],
			]
		);
		
		$this->end_controls_section();
		
		// General Style -------------------------------
		$this->killarwt_style_general_controls();
		
		// Responsive Style -------------------------------
		$this->killarwt_responsive_controls( array( 'lg' => '3', 'md' => '3', 'sm' => '2', 'xs' => '1' ) );
		
		// Carousel Style -------------------------------
		$this->killarwt_carousel_controls();
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_blog( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-blog-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Blog() );