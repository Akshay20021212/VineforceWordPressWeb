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

class KillarWT_Elementor_TeamMember extends KillarWT_Elementor_Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'kwt-team-member-accordion', KILLAR_ELEXTS_URL . 'assets/js/team-member.js', [ 'elementor-frontend' ], KILLARWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'killar-team-member';
	}
	
	public function get_title() {
		return __( 'Team Member', 'killarwt-core' );
	}
	
	public function get_icon() {
		return 'killar-icon eicon-user-circle-o';
	}
	
	public function get_categories() {
		return ['killar-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'killarwt-core' ),
			]
		);
		
		$this->add_control(
			'team_style',
			[
				'label' => esc_html__( 'Style', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'team-1' => esc_html__( 'Style-1', 'killarwt-core' ),
					'team-2' => esc_html__( 'Style-2', 'killarwt-core' ),
					'team-3' => esc_html__( 'Style-3', 'killarwt-core' ),
				],
				'default' => 'team-1',
			]
		);
		
		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'killarwt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'     => array(
                    'active'  => true
                ),
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
			'name',
			[
				'label' => esc_html__( 'Name', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Enter the name', 'killarwt-core' ),
				'label_block' => true,
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
				'default' => '',
				'placeholder' => esc_html__( 'Enter the title', 'killarwt-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'content',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Enter the description', 'killarwt-core' ),
				'rows' => 10,
				'separator' => 'none',
				'label_block' => true,
			]
		);
		
		// Icons
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'killarwt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'facebook',
				'options' => array_flip(killarwt_social_icons_array()),
			]
		);
		
		$repeater->add_control(
			'icon_alt', [
				'label' => __( 'Image alternative text', 'killarwt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'condition' => [
					'icon' => 'custom',
				],
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

		$this->add_control(
			'icon_items',
			[
				'label' => __( 'Icons', 'killarwt-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
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
		$this->killarwt_style_general_controls( array( 'el_classes' => 'our-team-wrapper position-relative mt-50' ) );
		
		// Item Style -------------------------------
		$this->killarwt_style_Item_controls();
		
		// Content Wrap Style -------------------------------
		$this->killarwt_content_wrap_controls('content_wrap', array( 'el_classes' => 'our-team-info transition5 position-absolute left-0 right-0 white-bg pl-25 pt-90 pb-15 pr-25' ) );
		
		// Social Icon Style -------------------------------
		$this->killarwt_style_social_icons_controls();
		
		// Image Style -------------------------------
		$this->killarwt_style_image_controls( array( 'wrap_el_classes' => 'single-team-img position-relative z-index1' ) );
		
		// Name Style -------------------------------
		$this->killarwt_style_fields_controls( 'name', array( 'size' => 'h3' ) );
		
		// Title Style -------------------------------
		$this->killarwt_style_fields_controls( 'title', array( 'size' => 'span' ) );
		
		// Content Style -------------------------------
		$this->killarwt_style_fields_controls( 'content', array( 'size' => 'p' ) );
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo killarwt_team_member( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'kwt-global', 'kwt-team-member-handle' ];
		return [];
	}
}
$widgets_manager->register_widget_type( new KillarWT_Elementor_TeamMember() );