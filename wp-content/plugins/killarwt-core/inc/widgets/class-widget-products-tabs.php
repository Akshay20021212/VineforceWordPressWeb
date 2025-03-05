<?php
/**
 * @package wtKillarWT/Widgets
 * @widget : Products
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class Killar_Widget_Products_Tabs extends WPH_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		
		//require_once( KILLARWT_CORE_INTEGRATIONS_DIR.'/vc/config/content/products-tabs.php' );
		
		if( ! function_exists( 'killarwt_get_products_tabs_params' ) ) return;
		
		// Widget Backend information
		$args = array(
			'label' => __( '[KILLAR] Products Tabs', 'killarwt-core' ),
			'description' => __( 'Display a list of your Products with Tabs on your site', 'killarwt-core' ),
			'slug' => 'killar_widget_products_tabs',
			'options' => array( 'cache' => false )
		);
		
		$args['fields'] = killarwt_get_products_tabs_params();
		
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
		
		echo killarwt_products_tabs( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

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
					if ( typeof killarWidgetInit !== 'undefined' ) {
						killarWidgetInit('.". $id ."');
					}
				} );
			</script>";
		echo '</div>';
	}
}
