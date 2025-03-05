<?php
/**
 * Widget Posts
 *
 * @package KillarWT
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class Killar_Widget_Posts extends WPH_Widget {
	
	public function __construct() {
		
		$args = array(
			'label' => __( '[KILLAR] Posts', 'killarwt-core' ),
			'description' => __( 'Display a list of your posts on your site', 'killarwt-core' ),
			'slug' => 'killar_widget_posts',
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
				'heading' 		=> esc_html__( 'Post Type', 'killarwt-core' ),
				'param_name' 	=> 'posts_type',
				'value' 		=>  array(
										esc_html__( 'Post', 'killarwt-core' ) => 'post',
										esc_html__( 'Portfolio', 'killarwt-core' ) => 'portfolio',
									),
				'std' 			=> 'post',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Category', 'killarwt-core' ),
				'param_name' 	=> 'categories',
				'value' 		=> array_flip ( killarwt_categories( 'category', 'id' ) ),
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
				'param_name' 	=> 'posts_thumbnail',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Title', 'killarwt-core' ),
				'param_name' 	=> 'posts_title',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post date', 'killarwt-core' ),
				'param_name' 	=> 'posts_date',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Categories', 'killarwt-core' ),
				'param_name' 	=> 'posts_categories',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Post Content', 'killarwt-core' ),
				'param_name' 	=> 'Post Content',
				'value' 		=>  array(
										esc_html__( 'Excerpt', 'killarwt-core' ) => 'excerpt',
										esc_html__( 'Full', 'killarwt-core' ) => 'full',
										esc_html__( 'Hide', 'killarwt-core' ) => false,										
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Excerpt Length', 'killarwt-core' ),
				'param_name' 	=> 'posts_excerpt_length',
				'value' 		=> '20',
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'General', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Removed List Border', 'killarwt-core' ),
				'param_name' 	=> 'remove_list_border',
				'value' 		=>  array(
										esc_html__( 'Yes', 'killarwt-core' ) => true,
										esc_html__( 'No', 'killarwt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'Image', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Image Size', 'killarwt-core' ),
				'param_name' 	=> 'thumbnail_size',
				'value' 		=> '90xauto',
				'description' 	=> esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Rounded Cornors', 'killarwt-core' ),
				'param_name' 	=> 'image_rounded_cornors',
				'value' 		=>  killarwt_border_radius_array(),
				'std' 			=> 'rounded-2',
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'Title', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'HTML Tag', 'killarwt-core' ),
				'param_name' 	=> 'title_size',
				'value' 		=>  array(
										'h1' 				=> 'h1',
										'h2' 				=> 'h2',
										'h3' 				=> 'h3',
										'h4' 				=> 'h4',
										'h5' 				=> 'h5',
										'h6' 				=> 'h6',
										'div' 				=> 'div',
										'span' 				=> 'span',
										'p' 				=> 'p',
									),
				'std' 			=> 'h4',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Size', 'killarwt-core' ),
				'param_name' 	=> 'title_font_size',
				'value' 		=> killarwt_font_size_array(),
				'std' 			=> 'xs',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Weight', 'killarwt-core' ),
				'param_name' 	=> 'title_font_weight',
				'value' 		=> killarwt_font_weight_array(),
				'std' 			=> '400',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Style', 'killarwt-core' ),
				'param_name' 	=> 'title_font_style',
				'value' 		=> killarwt_font_style_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Text Transform', 'killarwt-core' ),
				'param_name' 	=> 'title_text_transform',
				'value' 		=> killarwt_text_transform_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Color', 'killarwt-core' ),
				'param_name' 	=> 'title_color',
				'value' 		=> killarwt_color_array(),
				'std' 			=> 'grey',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Alignment', 'killarwt-core' ),
				'param_name' 	=> 'title_alignment',
				'value' 		=> killarwt_text_alignment_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title Length', 'killarwt-core' ),
				'param_name' 	=> 'posts_title_length',
				'value' 		=> '5',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title Extra Classes', 'killarwt-core' ),
				'param_name' 	=> 'title_el_classes',
				'std' 			=> 'h6 mb-2',
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'Content', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'HTML Tag', 'killarwt-core' ),
				'param_name' 	=> 'content_size',
				'value' 		=>  array(
										'h1' 				=> 'h1',
										'h2' 				=> 'h2',
										'h3' 				=> 'h3',
										'h4' 				=> 'h4',
										'h5' 				=> 'h5',
										'h6' 				=> 'h6',
										'div' 				=> 'div',
										'span' 				=> 'span',
										'p' 				=> 'p',
									),
				'std' 			=> 'p',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Size', 'killarwt-core' ),
				'param_name' 	=> 'content_font_size',
				'value' 		=> killarwt_font_size_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Weight', 'killarwt-core' ),
				'param_name' 	=> 'content_font_weight',
				'value' 		=> killarwt_font_weight_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Style', 'killarwt-core' ),
				'param_name' 	=> 'content_font_style',
				'value' 		=> killarwt_font_style_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Text Transform', 'killarwt-core' ),
				'param_name' 	=> 'content_text_transform',
				'value' 		=> killarwt_text_transform_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Color', 'killarwt-core' ),
				'param_name' 	=> 'content_color',
				'value' 		=> killarwt_color_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Alignment', 'killarwt-core' ),
				'param_name' 	=> 'content_alignment',
				'value' 		=> killarwt_text_alignment_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Content Extra Classes', 'killarwt-core' ),
				'param_name' 	=> 'content_el_classes',
				'value' 		=> '',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Content Wrap Extra Classes', 'killarwt-core' ),
				'param_name' 	=> 'content_wrap_el_classes',
				'value' 		=> 'ps-3',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Item Extra Classes', 'killarwt-core' ),
				'param_name' 	=> 'item_el_classes',
				'value' 		=> 'mb-2',
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
		
		echo killarwt_posts( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

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
