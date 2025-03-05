<?php
namespace KillarElementor;
use Elementor\Controls_Manager;
use Elementor\Base_Data_Control;

/**
 * Elementor WT Autocomplete Control
 * @package  killarwt
 * @since    1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WTAutocomplete_Control extends Base_Data_Control {

	public function get_type() {
		return 'wt_autocomplete';
	}

	/**
	 * Get select2 control default settings.
	 *
	 * @since 1.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
			'multiple'    => false,
			'taxonomy'    => false,
			'post_type'   => false,
			'options'     => [],
			'callback'    => '',
		];
	}

	/**
	 * Enqueue control scripts and styles.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'wt-autocomplete-control', KILLAR_ELEXTS_URL.'assets/js/autocomplete.js', array('jquery'), KILLARWT_CORE_VERSION , true );
	}

	/**
	 * Render wd_autocomplete control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label
				}}}</label>
			<div class="elementor-control-input-wrapper">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php echo esc_attr( $control_uid ); ?>" class="elementor-select2" type="select2" {{ multiple }} data-setting="{{ data.name }}" data-post-type="{{ data.post_type }}" data-taxonomy="{{ data.taxonomy }}" data-placeholder="<?php echo esc_attr__( 'Search', 'killarwt-core' ); ?>">
					<# _.each( data.options, function( option_title, option_value ) {
					var value = data.controlValue;
					if ( typeof value == 'string' ) {
						var selected = ( option_value === value ) ? 'selected' : '';
					} else if ( null !== value ) {
						var value = _.values( value );
						var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
					}
					#>
					<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
