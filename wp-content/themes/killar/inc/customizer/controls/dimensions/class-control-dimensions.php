<?php
/**
 * Customizer Control: Dimensions
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
 * Dimension control.
 *
 * @since 1.0
 */
class KillarWT_Customizer_Dimensions_Control extends KillarWT_Customizer_Base_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'killarwt-dimensions';

	/**
	 * The unit type.
	 *
	 * @access public
	 * @var array
	 */
	public $unit_choices = array( 'px' => 'px' );

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_script( 'killarwt-control-dimensions', KILLARWT_CUSTOMIZER_CONTROL_DIR_URI.'dimensions/dimensions.js',  array( 'jquery', 'customize-base', 'killarwt-base-control' ), KILLARWT_VERSION, true );
		wp_enqueue_style( 'killarwt-control-dimensions-style', KILLARWT_CUSTOMIZER_CONTROL_DIR_URI.'dimensions/dimensions.css', array(), KILLARWT_VERSION );
		wp_localize_script('killar-control-dimensions', 'dimensionskillarL10n', array('invalid-value' => esc_html__( 'Invalid Value', 'killar' )));
	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 *
	 * @see WP_Customize_Control::render()
	 */
	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control has-devices customize-control-' . $this->type;

		?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li><?php
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

		$this->json['unit_choices']   = $this->unit_choices;
		$this->json['title'] 	= esc_html__( 'Link values together', 'killar' );

		$this->json['desktop'] = array();
	    $this->json['tablet']  = array();
	    $this->json['mobile']  = array();

	    foreach ( $this->settings as $setting_key => $setting ) {

	    	list( $_key ) = explode( '_', $setting_key );

	        $this->json[ $_key ][ $setting_key ] = array(
	            'id'        => $setting->id,
	            'link'      => $this->get_link( $setting_key ),
	            'value'     => $this->value( $setting_key ),
	        );
		}
		
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
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}
				<ul class="devices-list">
					<li class="desktop">
						<button type="button" class="preview-desktop active" aria-pressed="true" data-device="desktop"><i class="dashicons dashicons-desktop"></i></button>
					</li>
					<li class="tablet">
						<button type="button" class="preview-tablet active" aria-pressed="true" data-device="tablet"><i class="dashicons dashicons-tablet"></i></button>
					</li>
					<li class="mobile">
						<button type="button" class="preview-mobile active" aria-pressed="true" data-device="mobile"><i class="dashicons dashicons-smartphone"></i></button>
					</li>
				</ul>
			</span>
		<# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		<div class="devices-wrapper">
			<ul class="desktop device-cont active">
				<li class="dimension-wrap">
					<div class="link-dimensions">
						<span class="dashicons dashicons-admin-links killarwt-connected" data-element="{{ data.id }}" title="{{ data.title }}"></span>
						<span class="dashicons dashicons-editor-unlink killarwt-disconnected" data-element="{{ data.id }}" title="{{ data.title }}"></span>
					</div>
				</li>
				<# _.each( data.desktop, function( args, key ) { #>
				<li class="dimension-wrap {{ key }}">
	                <input {{{ data.inputAttrs }}} type="number" class="dimension-{{ key }}" {{{ args.link }}} value="{{{ args.value }}}" />
	                <span class="dimension-label">{{ data.l10n[ key ] }}</span>
	            </li>
				<# } ); #>
			</ul>
			<ul class="tablet device-cont">
				<li class="dimension-wrap">
					<div class="link-dimensions">
						<span class="dashicons dashicons-admin-links killarwt-connected" data-element="{{ data.id }}" title="{{ data.title }}"></span>
						<span class="dashicons dashicons-editor-unlink killarwt-disconnected" data-element="{{ data.id }}" title="{{ data.title }}"></span>
					</div>
				</li>
				<# _.each( data.tablet, function( args, key ) { #>
				<li class="dimension-wrap {{ key }}">
	                <input {{{ data.inputAttrs }}} type="number" class="dimension-{{ key }}" {{{ args.link }}} value="{{{ args.value }}}" />
	                <span class="dimension-label">{{ data.l10n[ key ] }}</span>
	            </li>
				<# } ); #>
			</ul>
			<ul class="mobile device-cont">
				<li class="dimension-wrap">
					<div class="link-dimensions">
						<span class="dashicons dashicons-admin-links killarwt-connected" data-element="{{ data.id }}" title="{{ data.title }}"></span>
						<span class="dashicons dashicons-editor-unlink killarwt-disconnected" data-element="{{ data.id }}" title="{{ data.title }}"></span>
					</div>
				</li>
				<# _.each( data.mobile, function( args, key ) { #>
				<li class="dimension-wrap {{ key }}">
	                <input {{{ data.inputAttrs }}} type="number" class="dimension-{{ key }}" {{{ args.link }}} value="{{{ args.value }}}" />
	                <span class="dimension-label">{{ data.l10n[ key ] }}</span>
	            </li>
				<# } ); #>
			</ul>
		</div>
		<?php
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @param string|false $id The string-ID.
	 * @return string
	 */
	protected function l10n( $id = false ) {
		$translation_strings = array(
			'desktop_top' 		=> esc_attr__( 'Top', 'killar' ),
			'desktop_right' 	=> esc_attr__( 'Right', 'killar' ),
			'desktop_bottom' 	=> esc_attr__( 'Bottom', 'killar' ),
			'desktop_left' 		=> esc_attr__( 'Left', 'killar' ),
			'tablet_top' 		=> esc_attr__( 'Top', 'killar' ),
			'tablet_right' 		=> esc_attr__( 'Right', 'killar' ),
			'tablet_bottom' 	=> esc_attr__( 'Bottom', 'killar' ),
			'tablet_left' 		=> esc_attr__( 'Left', 'killar' ),
			'mobile_top' 		=> esc_attr__( 'Top', 'killar' ),
			'mobile_right' 		=> esc_attr__( 'Right', 'killar' ),
			'mobile_bottom' 	=> esc_attr__( 'Bottom', 'killar' ),
			'mobile_left' 		=> esc_attr__( 'Left', 'killar' ),
		);
		if ( false === $id ) {
			return $translation_strings;
		}
		return $translation_strings[ $id ];
	}
}
