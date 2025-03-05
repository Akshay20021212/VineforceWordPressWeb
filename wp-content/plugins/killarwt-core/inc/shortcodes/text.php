<?php
/*
Element Description: Text
*/

if ( ! function_exists( 'killarwt_text' ) ) :

	function killarwt_text( $atts ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'content'						=> '',
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
			'content_size'					=> 'p',
			'content_font_size'				=> '',
			'content_custom_font_size'		=> '',
			'content_font_weight'			=> '',
			'content_font_style'			=> '',
			'content_text_transform'		=> '',
			'content_color'					=> '',
			'content_color_custom'			=> '',
			'content_line_height'			=> '',
			'content_letter_spacing'		=> '',
			'content_alignment'				=> '',
			'content_alignment_tablet'		=> '',
			'content_alignment_mobile'		=> '',
			'content_animation'				=> '',
			'content_animation_durations'	=> '',
			'content_animation_delay'		=> '',
			'content_el_classes'			=> '',
			'content_wrap_el_classes' 		=> '',
			'shortcode_from'				=> 'shortcode'
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-text-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-text', 'kwt-text' );
		$args['wrap_atts']['class'][] 	= ( !empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		$args['wrap_atts'] = killarwt_get_shortcodes_common_array( $atts, $args['wrap_atts'] );
		
		// Content -----------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts );
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_text', 'killarwt_text' );