<?php
/*
Element Description: Heading
*/

if ( ! function_exists( 'killarwt_heading' ) ) :

	function killarwt_heading( $atts ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'title'							=> '',
			'sub_title'						=> '',
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
			'sub_title_size'				=> 'span',
			'sub_title_font_size'			=> '',
			'sub_title_custom_font_size'	=> '',
			'sub_title_font_weight'			=> '',
			'sub_title_font_style'			=> '',
			'sub_title_text_transform'		=> '',
			'sub_title_color'				=> '',
			'sub_title_color_custom'		=> '',
			'sub_title_line_height'			=> '',
			'sub_title_custom_line_height'	=> '',
			'sub_title_letter_spacing'		=> '',
			'sub_title_alignment'			=> '',
			'sub_title_alignment_tablet'	=> '',
			'sub_title_alignment_mobile'	=> '',
			'sub_title_animation'			=> '',
			'sub_title_animation_durations'	=> '',
			'sub_title_animation_delay'		=> '',
			'sub_title_el_classes'			=> '',
			'sub_title_wrap_el_classes'		=> '',
			'title_size'					=> 'h3',
			'title_font_size'				=> '',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> '',
			'title_color_custom'			=> '',
			'title_line_height'				=> '',
			'title_custom_line_height'		=> '',
			'title_letter_spacing'			=> '',
			'title_alignment'				=> '',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'title_animation'				=> '',
			'title_animation_durations'		=> '',
			'title_animation_delay'			=> '',
			'title_el_classes'				=> '',
			'title_wrap_el_classes'			=> '',
			'content_size'					=> 'p',
			'content_font_size'				=> '',
			'content_custom_font_size'		=> '',
			'content_font_weight'			=> '',
			'content_font_style'			=> '',
			'content_text_transform'		=> '',
			'content_color'					=> '',
			'content_color_custom'			=> '',
			'content_line_height'			=> '',
			'content_custom_line_height'	=> '',
			'content_letter_spacing'		=> '',
			'content_alignment'				=> '',
			'content_alignment_tablet'		=> '',
			'content_alignment_mobile'		=> '',
			'content_animation'				=> '',
			'content_animation_durations'	=> '',
			'content_animation_delay'		=> '',
			'content_el_classes'			=> '',
			'content_wrap_el_classes' 		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
			
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-heading-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-heading' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
				
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-heading' );
		$data_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
		
		// Sub Title ----------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'sub_title', $atts );
		
		// Title ----------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'title', $atts );
				
		// Content -----------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts );
		
		$args['sec_content'] .= '</div>';
	
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_heading', 'killarwt_heading' );