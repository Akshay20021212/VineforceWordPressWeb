<?php
/**
 * Customizer Module: Panles
 *
 * @package   KillarWT
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slider control (range).
 *
 * @since 1.0
 */
class KillarWT_Customizer_Module_Panels extends WP_Customize_Panel {
	
	/**
	 * The parent panel.
	 *
	 * @access public
	 * @since 3.0.0
	 * @var string
	 */
	public $panel;

	/**
	 * Type of this panel.
	 *
	 * @access public
	 * @since 3.0.0
	 * @var string
	 */
	public $type = 'killar-nested';

	/**
	 * Gather the parameters passed to client JavaScript via JSON.
	 *
	 * @access public
	 * @since 3.0.0
	 * @return array The array to be exported to the client as JSON.
	 */
	public function json() {
		$array = wp_array_slice_assoc(
			(array) $this, array(
				'id',
				'description',
				'priority',
				'type',
				'panel',
			)
		);

		$array['title']          = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$array['content']        = $this->get_content();
		$array['active']         = $this->active();
		$array['instanceNumber'] = $this->instance_number;
		
		return $array;
	}

}

// Enqueue our scripts and styles
function killarwt_customize_controls_scripts() {
	wp_enqueue_script( 'killarwt-customize-controls', KILLARWT_CUSTOMIZER_MODULES_DIR_URI . 'panels/panels.js' , array('jquery', 'customize-base', 'customize-controls'), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'killarwt_customize_controls_scripts' );

/*
function killarwt_customize_controls_styles() {
	wp_enqueue_style( 'killarwt-customize-controls', KILLARWT_CUSTOMIZER_MODULES_DIR_URI . 'panels/panels.css' , array(), '1.0' );
}
add_action( 'customize_controls_print_styles', 'killarwt_customize_controls_styles' );*/