<?php
/*
Element Description: Social Icons
*/

if ( ! function_exists( 'killarwt_social_icons' ) ) :

	function killarwt_social_icons( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'icon_type'						=> 'icon',
			'icon_items'					=> array(),
			'animation'						=> '',
			'animation_durations'			=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'wrap_ver_alignment'			=> '',
			'wrap_ver_alignment_tablet'		=> '',
			'wrap_ver_alignment_mobile'		=> '',
			'wrap_hor_alignment'			=> '',
			'wrap_hor_alignment_tablet'		=> '',
			'wrap_hor_alignment_mobile'		=> '',
			'wrap_text_alignment'			=> '',
			'wrap_text_alignment_tablet'	=> '',
			'wrap_text_alignment_mobile'	=> '',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'item_ver_alignment'			=> '',
			'item_ver_alignment_tablet'		=> '',
			'item_ver_alignment_mobile'		=> '',
			'item_hor_alignment'			=> '',
			'item_hor_alignment_tablet'		=> '',
			'item_hor_alignment_mobile'		=> '',
			'item_wrap_el_classes'			=> '',
			'item_el_classes'				=> '',
			'icon_view'						=> '',
			'icon_shape'					=> 'circle',
			'icon_size'						=> 'a',
			'icon_font_size'				=> '',
			'icon_font_size_custom'			=> '',
			'icon_color'					=> 'default',
			'icon_bg_color'					=> '',
			'icon_text_color'				=> '',
			'icon_border_color'				=> '',
			'icon_hcolor'					=> 'default',
			'icon_bg_hcolor'				=> '',
			'icon_text_hcolor'				=> '',
			'icon_border_hcolor'			=> '',
			'icon_el_classes' 				=> '',
			'icon_wrap_el_classes' 			=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-social-icons-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-social-icons social-links' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-social-icons fbx-icons fbx-soc-icons' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'][] = ( !empty( $icon_wrap_el_classes ) ) ? $icon_wrap_el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		// Items --------------------------------------------------
		
		if( !empty( $icon_items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
			$args['sec_content'] .= killarwt_get_shortcodes_social_icon_html( $atts, $icon_items );
			$args['sec_content'] .= '</div>';
		}
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_social_icons', 'killarwt_social_icons' );