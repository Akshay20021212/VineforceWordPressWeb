<?php
/**
 * Widget Blog
 *
 * @package KillarWT
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class Killar_Widget_Blog extends WPH_Widget {

	public function __construct() {
				
		$args = array(
			'label' => __( '[KILLAR] Blog', 'killarwt-core' ),
			'description' => __( 'Display a list of your blog on your site', 'killarwt-core' ),
			'slug' => 'killar_widget_blog',
			'options' => array( 'cache' => false )
		);
		
		$args['fields'] = array(
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title', 'killarwt-core' ),
				'param_name' 	=> 'title',
				'description' 	=> esc_html__( 'Enter Widget Title.', 'killarwt-core' ),
				'admin_label' 	=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Style', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_style',
				'value' 		=>  array(
										esc_html__( 'Default', 'killarwt-core' ) => 'default',
										esc_html__( 'Fancy', 'killarwt-core' ) => 'fancy',
										esc_html__( 'Box', 'killarwt-core' ) => 'box',
									),
				'std' 			=> 'default',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Category', 'killarwt-core' ),
				'param_name' 	=> 'categories',
				'value' 		=>  array_flip( killarwt_categories( 'category' ) ),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'View', 'killarwt-core' ),
				'param_name' 	=> 'view_type',
				'value' 		=>  array(
										esc_html__( 'Grid (Default)', 'killarwt-core' ) => 'grid',
										esc_html__( 'Slider', 'killarwt-core' ) => 'slider',
										esc_html__( 'list', 'killarwt-core' ) => 'list',
									),
				'std' 			=> 'grid',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Posts Count', 'killarwt-core' ),
				'param_name' 	=> 'limit',
				'value' 		=> '3',
				'description' 	=> esc_html__( 'Numbers of items show per page.', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Order by', 'killarwt-core' ),
				'param_name' 	=> 'orderby',
				'value' 		=>  array(
										esc_html__( 'Date', 'killarwt-core' ) => 'date',
										esc_html__( 'Title', 'killarwt-core' ) => 'title',
										esc_html__( 'Random', 'killarwt-core' ) => 'random',
										esc_html__( 'Number of comments', 'killarwt-core' ) => 'comment_count',
										esc_html__( 'Last modified', 'killarwt-core' ) => 'modified',
									),
				'std' 			=> 'date',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Sort Order', 'killarwt-core' ),
				'param_name' 	=> 'order',
				'value' 		=>  array(
										esc_html__( 'ASC', 'killarwt-core' ) => 'ASC',
										esc_html__( 'DESC', 'killarwt-core' ) => 'DESC',
									),
				'std' 			=> 'DESC',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Image', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_image',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Image', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_thumbnail',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Title', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_title',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Meta', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_meta',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Tags', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_tags',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Post Content', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_content',
				'value' 		=>  array(
										esc_html__( 'Excerpt', 'killarwt-core' ) => 'excerpt',
										esc_html__( 'Full', 'killarwt-core' ) => 'full',
										esc_html__( 'Hide', 'killarwt-core' ) => false,										
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Excerpt Length', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_excerpt_length',
				'value' 		=> '20',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Read More', 'killarwt-core' ),
				'param_name' 	=> 'blog_loop_post_read_more',
				'value' 		=>  array(
										esc_html__( 'Link (Default)', 'killarwt-core' ) => 'link',
										esc_html__( 'Button', 'killarwt-core' ) => 'button',
										esc_html__( 'Icon', 'killarwt-core' ) => 'icon',
										esc_html__( 'Hide', 'killarwt-core' ) => false,
									),
				'std' 			=> 'link',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Rows', 'killarwt-core' ),
				'param_name' 	=> 'nums_rows',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'killarwt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Navigation', 'killarwt-core' ),
				'param_name' 	=> 'carousel_nav',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Navigation Style', 'killarwt-core' ),
				'param_name' 	=> 'carousel_nav_style',
				'value' 		=>  array(
										esc_html__( 'Circle (default)', 'killarwt-core' ) => 'cir',
										esc_html__( 'Rectangle', 'killarwt-core' ) => 'rec',
									),
				'std' 			=> 'cir',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Navigation Position', 'killarwt-core' ),
				'param_name' 	=> 'carousel_nav_position',
				'value' 		=>  array(
										esc_html__( 'Slider Middle (Default)', 'killarwt-core' ) => 'slider-middle',
										esc_html__( 'Title Right', 'killarwt-core' ) => 'title-right',
									),
				'std' 			=> 'title-right',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Loop', 'killarwt-core' ),
				'param_name' 	=> 'carousel_infinite',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Dots', 'killarwt-core' ),
				'param_name' 	=> 'carousel_dots',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Auto Play', 'killarwt-core' ),
				'param_name' 	=> 'carousel_autoplay',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Large devices', 'killarwt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Large devices (desktops, 992px and up)', 'killarwt-core' ),
				'param_name' 	=> 'items_col_lg',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'killarwt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
											'5' => esc_html__( '5 - Item(s)', 'killarwt-core' ),
											'6' => esc_html__( '6 - Item(s)', 'killarwt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Medium devices', 'killarwt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Medium devices (tablets, less than 992px)', 'killarwt-core' ),
				'param_name' 	=> 'items_col_md',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'killarwt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
											'5' => esc_html__( '5 - Item(s)', 'killarwt-core' ),
											'6' => esc_html__( '6 - Item(s)', 'killarwt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Small devices', 'killarwt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Small devices (landscape phones, 576px and up).', 'killarwt-core' ),
				'param_name' 	=> 'items_col_sm',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'killarwt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'killarwt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Extra small devices', 'killarwt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Extra small devices (portrait phones, less than 576px).', 'killarwt-core' ),
				'param_name' 	=> 'items_col_xs',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'killarwt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'killarwt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'killarwt-core' ),
										)
									),
				'std' 			=> '1',
			),
		);
		
		$this->create_widget( $args );

	}

	/**
	 * Output widget.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	public function widget( $args, $instance ) {
		
		$instance['display_type'] = 'widget';
		
		extract($args);
			
		echo wp_kses_post( $before_widget );
		
		if(!empty($instance['title'])) { echo wp_kses_post( $before_title ) . $instance['title'] . wp_kses_post( $after_title ); };
		
		echo killarwt_blog( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

		echo wp_kses_post( $after_widget );

	}
	
	/**
	 * Output widget.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	function form( $instance ) {
		$id = killarwt_uniqid('killar-widget-');
		echo '<div class="' . $id . '">';
			parent::form( $instance );
		echo '</div>';
	}
}
