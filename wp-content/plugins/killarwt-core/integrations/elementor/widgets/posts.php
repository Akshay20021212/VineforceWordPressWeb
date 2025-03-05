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

class KillarWT_Elementor_Posts extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-posts', KILLAR_ELEXTS_URL . 'assets/js/posts.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-posts';
	}
	
	public function get_title() {
		return __( 'Posts', 'killarwt-core' );
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
			'posts_style',
			[
				'label' => esc_html__( 'Post Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style1' => esc_html__( 'Style - 1( default )', 'killarwt-core' ),
					'style2' => esc_html__( 'Style - 2', 'killarwt-core' ),
				],
				'default' => 'style1',
			]
		);
		
		$this->add_control(
			'posts_type',
			[
				'label' => esc_html__( 'Post Type', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'post' => esc_html__( 'Post', 'killarwt-core' ),
					'portfolio' => esc_html__( 'Portfolio', 'killarwt-core' ),
				],
				'default' => 'post',
			]
		);
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Category', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => killarwt_categories( 'category' ),
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
		
		// Posts Settings -------------------------------
		
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => esc_html__( 'Posts Setttings', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'posts_thumbnail',
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
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'medium',
				'separator' => 'none',
				'condition' => [
					'posts_thumbnail' => '1',
				],
			]
		);
		
		$this->add_control(
			'posts_title',
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
			'posts_title_length',
			[
				'label' => __( 'Title Length', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'posts_title' => '1',
				],
			]
		);
		
		$this->add_control(
			'posts_date',
			[
				'label' => esc_html__( 'Show Post date', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'posts_categories',
			[
				'label' => esc_html__( 'Show Post Categories', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'posts_content',
			[
				'label' => esc_html__( 'Post Content', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'excerpt'	=> esc_html__( 'Excerpt', 'killarwt-core' ),
					'full' 		=> esc_html__( 'Full', 'killarwt-core' ),
					'0' 		=> esc_html__( 'Hide', 'killarwt-core' ),
				],
				'default' => 'excerpt',
			]
		);
		
		$this->add_control(
			'posts_excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 20,
				'placeholder' => '',
				'condition' => [
					'posts_content' => 'excerpt',
				],
			]
		);
		
		$this->add_control(
			'remove_list_border',
			[
				'label' => esc_html__( 'Removed List Border', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'killarwt-core' ),
				'label_off' => __( 'No', 'killarwt-core' ),
				'default' => '0',
			]
		);
		
		$this->end_controls_section();
		
		// General Style -------------------------------
		$this->killarwt_style_general_controls();
				
		// Item Style -------------------------------
		$this->killarwt_style_Item_controls();
		
		// Image Style -------------------------------
		$this->killarwt_style_image_controls();
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'class' => '.post-title', 'size' => 'h6' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'class' => '.post-content', 'size' => 'p') );
		
		// Date Style -------------------------------
		$this->killarwt_style_fields_controls( 'date', array( 'class' => '.post-date', 'size' => 'span' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_posts( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-posts-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_Posts() );