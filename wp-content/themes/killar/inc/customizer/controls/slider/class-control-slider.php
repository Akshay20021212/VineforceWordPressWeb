<?php
/**
 * Customizer Control: Slider
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
class KillarWT_Customizer_Slider_Control extends KillarWT_Customizer_Base_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'killarwt-slider';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_script( 'killarwt-control-slider', KILLARWT_CUSTOMIZER_CONTROL_DIR_URI.'slider/slider.js',  array( 'jquery', 'customize-base', 'killarwt-base-control' ), KILLARWT_VERSION, true );
		wp_enqueue_style( 'killarwt-control-slider-style', KILLARWT_CUSTOMIZER_CONTROL_DIR_URI.'slider/slider.css', array(), KILLARWT_VERSION );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['choices'] = wp_parse_args(
			$this->json['choices'],
			array(
				'min'    => '0',
				'max'    => '100',
				'step'   => '1',
				'suffix' => '',
			)
		);
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="wrapper">
				<input {{{ data.inputAttrs }}} type="range" min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" value="{{ data.value }}" {{{ data.link }}} />
				<span class="value">
					<input {{{ data.inputAttrs }}} type="text"/>
					<span class="suffix">{{ data.choices['suffix'] }}</span>
				</span>
				<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_html_e( 'Reset', 'killar' ); ?></span></span>
			</div>
		</label>
		<?php
	}
}
