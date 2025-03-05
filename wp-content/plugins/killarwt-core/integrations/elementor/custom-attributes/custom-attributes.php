<?php
namespace KillarElementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Version PRO Elementor, on sort
if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
	return;
}

use Elementor\Controls_Manager;
use Elementor\Element_Base;

class ELEWT_Custom_Attributes {

	/**
	 * Add Action hook
	 */
	public function __construct() {
		add_action( 'elementor/element/after_section_end', array( $this, 'elkwt_attributes_controls_section' ), 10, 3 );
		add_action( 'elementor/frontend/before_render', array( $this, 'elkwt_render_attributes' ) );
	}

	/**
	 * elkwt_attributes_controls_section
	 *
	 * Supprime le control 'custom_attributes_pro' de la version PRO
	 * Ajout de la nouvelle section et du control
	 *
	 * @param Element_Base $element        abstract class Element_Base extends Controls_Stack
	 * @param String       $section_id
	 * @param Array        $args
	 */
	public function elkwt_attributes_controls_section( $element, $section_id, $args ) {

		if ( ! $element instanceof Element_Base ) {
			return;
		}

		// The control exists
		if ( 'section_custom_attributes_pro' === $section_id ) {
			// $element->remove_control('section_custom_attributes_pro');  // Controls_Stack
			\Elementor\Plugin::$instance->controls_manager->remove_control_from_stack( $element->get_unique_name(), array( 'section_custom_attributes_pro', 'custom_attributes_pro' ) );

			$element->start_controls_section(
				'elkwt_custom_element_attributes', // @since 1.8.9 'elkwt_section_attributes'
				array(
					'label' => esc_html__( 'WT Custom Attributes', 'killarwt-core' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				)
			);

			$element->add_control(
				'elkwt_attributes',
				array(
					'label'       => esc_html__( 'Add Attributes', 'killarwt-core' ),
					'type'        => Controls_Manager::TEXTAREA,
					'placeholder' => esc_html__( 'Key|Value', 'killarwt-core' ),
					'description' => esc_html__( "Separate the key from its value with the pipe character '|'. Each attribute on a separate line.", 'killarwt-core' ),
					'dynamic'     => array(
						'active' => true,
					),
					'render_type' => 'none',
					'classes'     => 'elementor-control-direction-ltr',
				)
			);

			$element->end_controls_section();
		}
	}

	/**
	* elkwt_render_attributes
	*
	* Assign Key|Value to wrapper of Section, Column or Widget element
	*
	* @param Element_Base $element
	* @since 1.6.6
	*/
	public function elkwt_render_attributes( $element ) {
		/*highlight_string("<?php\n\WC =\n" . var_export($element, true) . ";\n?>");*/

		$settings = $element->get_settings_for_display();

		// The control exists and it is populated
		if ( isset( $settings['elkwt_attributes'] ) && ! empty( $settings['elkwt_attributes'] ) ) {
			// console_log('Element name::' . $element->get_name() . "::" . $element->get_type() . "::" . json_encode($element->get_raw_data()));

			// Analysis of the content of the control
			$attributes = $this->parse_custom_attributes( $settings['elkwt_attributes'] );

			// The list of forbidden attributes
			$black_list = $this->get_black_list_attributes();

			foreach ( $attributes as $attribute => $value ) {
				if ( ! in_array( $attribute, $black_list, true ) ) {
					$element->add_render_attribute( '_wrapper', $attribute, $value );
				}
			}
		}
	}

	/**
	* parse_custom_attributes
	*
	* Returns a filtered array of Key|Value
	*
	* @param String $attributes_string The array of attributes to parse
	* @param String $delimiter The separator of 'Key|Value'
	*
	* @since 1.6.6
	*/
	private function parse_custom_attributes( $attributes_string, $delimiter = ',' ) {
		$attributes = explode( $delimiter, $attributes_string );
		$result     = array();

		foreach ( $attributes as $attribute ) {
			$attr_key_value = explode( '|', $attribute );

			$attr_key = mb_strtolower( $attr_key_value[0] );

			// Find the allowed characters in the key
			preg_match( '/[-_a-z0-9]+/', $attr_key, $attr_key_matches );

			if ( empty( $attr_key_matches[0] ) ) {
				continue;
			}

			$attr_key = $attr_key_matches[0];

			// Avoid Javascript events and unescaped href.
			if ( 'href' === $attr_key || 'on' === substr( $attr_key, 0, 2 ) ) {
				continue;
			}

			if ( isset( $attr_key_value[1] ) ) {
				$attr_value = trim( $attr_key_value[1] );
			} else {
				$attr_value = '';
			}
			$result[ $attr_key ] = $attr_value;
		}
		return $result;
	}

	/**
	 * get_black_list_attributes
	 *
	 * Retourne la liste des attributs interdits utilisés dans les section, colonne et widget Elementor
	 *
	 * @since 1.6.6
	 */
	private function get_black_list_attributes() {
		static $black_list = null;

		if ( null === $black_list ) {
			$black_list = array( 'id', 'class', 'data-id', 'data-settings', 'data-element_type', 'data-widget_type', 'data-model-cid' );

			/**
			* List of Elementor attributes that are not allowed
			*
			* Filter/Exclude attributes used as standard by Elementor
			*
			* Protect Elementor from attributes that cannot be used to avoid crash
			*
			* @since 1.6.6
			*
			* @param array $black_list List of attributes to avoid.
			*/
			// $black_list = apply_filters('element/element/attributes/black_list', $black_list);
		}
		return $black_list;
	}
}
new ELEWT_Custom_Attributes();
