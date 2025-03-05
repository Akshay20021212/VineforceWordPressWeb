<?php
/*
Element Description: Image Box
*/

if ( ! function_exists( 'killarwt_image' ) ) :

	function killarwt_image( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'image'							=> '',
			'thumbnail_size'				=> 'full',
			'thumbnail_custom_dimension'	=> array(),
			'image_alt_text'				=> '',
			'link'							=> '',
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
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'image_rounded_cornors'			=> '',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'image_hover_overlay'			=> '',
			'image_el_classes' 				=> '',
			'image_wrap_el_classes' 		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-image-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-image' );
		$args['wrap_atts']['class'][] 	= ( !empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
				
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-image' );
		$data_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_hor', $atts, 'hor' );
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_ver', $atts, 'ver' );
		$data_attr += killarwt_get_shortcodes_animations_array( $atts );
		
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '<a ' . killarwt_stringify_atts( killarwt_get_url_data( $link ) ) . '>';
		}
		
		// Image ---------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_image_html( $atts );
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '</a>';
		}
		
		$args['sec_content'] .= '</div>';
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_image', 'killarwt_image' );