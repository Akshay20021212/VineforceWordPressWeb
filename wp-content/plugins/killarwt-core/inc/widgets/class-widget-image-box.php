<?php
/**
 * Widget Image Box
 *
 * @package KillarWT
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class Killar_Widget_Image_Box extends WPH_Widget {

	public function __construct() {
	
		$target_param_list = array(
			esc_html__( 'Same window', 'killarwt-core' ) => '_self',
			esc_html__( 'New window', 'killarwt-core' ) => '_blank',
		);
		
		// Widget Backend information
		$args = array(
			'label' => __( '[KILLAR] Image Box', 'killarwt-core' ),
			'description' => __( 'Add Image Box', 'killarwt-core' ),
			'slug' => 'killar_widget_image_box',
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
				'type' 			=> 'attach_image',
				'heading' 		=> esc_html__( 'Image', 'killarwt-core' ),
				'param_name' 	=> 'image',
				'value' 		=> '',
				'description' 	=> esc_html__( 'Select image from media library.', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Image Size', 'killarwt-core' ),
				'param_name' 	=> 'thumbnail_size',
				'value' 		=> 'full',
				'description' 	=> esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title', 'killarwt-core' ),
				'param_name' 	=> 'inner_title',
				'description' 	=> esc_html__( 'Enter Title.', 'killarwt-core' ),
				'admin_label' 	=> true,
			),
			array(
				'type' 			=> 'textarea_html',
				'holder'	 	=> 'p',
				'heading' 		=> esc_html__( 'Content', 'killarwt-core' ),
				'param_name' 	=> 'content',
				'value' 		=> '',				
			),
			array(
				'type' 			=> 'href',
				'heading' 		=> esc_html__( 'Link', 'killarwt-core' ),
				'param_name' 	=> 'link',
				'description' 	=> esc_html__( 'Enter URL if you want this image to have a link (Note: parameters like "mailto:" are also accepted).', 'killarwt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Link Target', 'killarwt-core' ),
				'param_name' 	=> 'link_target',
				'value' 		=> $target_param_list,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Image Position', 'killarwt-core' ),
				'param_name' 	=> 'image_position',
				'value' 		=>  array(
										esc_html__( 'Left', 'killarwt-core' ) => 'left',
										esc_html__( 'Top', 'killarwt-core' ) => 'top',
										esc_html__( 'Right', 'killarwt-core' ) => 'right',
									),
				'std' 			=> 'top',
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
		
		echo killarwt_image_box( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

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
			echo "<script type='text/javascript'>
					jQuery(document).ready(function() {
						if ( typeof killarMediaInit !== 'undefined' ) {
							killarMediaInit('.". $id ." .killar-image-upload', '.". $id ." .killar-image-upload-btn', '.". $id ." .killar-image-src');
						}
						if ( typeof killarWidgetInit !== 'undefined' ) {
							killarWidgetInit('.". $id ."');
						}
					} );
				</script>";
		echo '</div>';
	}
}
