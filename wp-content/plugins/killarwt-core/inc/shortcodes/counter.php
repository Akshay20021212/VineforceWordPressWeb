<?php
/*
Element Description: Counter
*/
if ( ! function_exists( 'killarwt_counter' ) ) :

	function killarwt_counter( $atts = array()) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'icon_type'						=> 'flat-icon',
			'icon'							=> array(),
			'icon_image'					=> '',
			'icon_thumbnail_size'			=> 'thumbnail',
			'icon_thumbnail_custom_dimension'=> array(),
			'icon_text'						=> '',
			'counter_number'				=> '',
			'counter_number_prefix'			=> '',
			'counter_number_sufix'			=> '',
			'counter_animation_duration'	=> '2000',
			'title'							=> '',
			'content'						=> '',
			'link'							=> '',
			'icon_position'					=> 'top',
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
			'sufix_color' 					=> '',
			'prefix_color' 					=> '',
		    'icon_view'						=> 'default',
			'icon_shape'					=> 'circle',
			'icon_size'						=> '',
			'icon_size_custom'				=> '',
			'icon_color'					=> '',
			'icon_color_custom'				=> '',
			'icon_bg_color'					=> '',
			'icon_bg_color_custom'			=> '',
			'icon_alignment'				=> '',
			'icon_alignment_tablet'			=> '',
			'icon_alignment_mobile'			=> '',
			'icon_ver_alignment'			=> '',
			'icon_ver_alignment_tablet'		=> '',
			'icon_ver_alignment_mobile'		=> '',
			'icon_image_rounded_cornors'	=> '',
			'icon_hover_overlay'			=> '',
			'icon_el_classes' 				=> '',
			'icon_wrap_el_classes' 			=> '',
			'image_rounded_cornors'			=> 'rounded',
			'image_below_padding'			=> '',
			'title_size'					=> 'h3',
			'title_font_size'				=> '',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> '',
			'title_color_custom'			=> '',
			'title_line_height'				=> '',
			'title_letter_spacing'			=> '',
			'title_alignment'				=> '',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'title_animation'				=> '',
			'title_animation_durations'		=> '',
			'title_animation_delay'			=> '',
			'title_el_classes'				=> '',
			'title_wrap_el_classes'			=> '',
			'counter_num_size'				=> 'h3',
			'counter_num_font_size'			=> '',
			'counter_num_custom_font_size'	=> '',
			'counter_num_font_weight'		=> '',
			'counter_num_font_style'		=> '',
			'counter_num_text_transform'	=> '',
			'counter_num_color'				=> '#222',
			'counter_num_line_height'		=> '',
			'counter_num_letter_spacing'	=> '',
			'counter_num_alignment'			=> 'left',
			'counter_num_el_classes'			=> '',
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
			'shortcode_from'				=> 'shortcode'
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-counter-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-counter' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-counter' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '<a ' . killarwt_stringify_atts( killarwt_get_url_data( $link ) ) . '>';
		}
		
		// Icon ---------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_icon_html( $atts );
		
		// Title ----------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'title', $atts );
		
		// Counter ----------------------------------------
		
		if( !empty( $counter_number ) ) {
			$counter_num_attr = array();
			$counter_num_attr['class'] = array( 'bx-counter statistic-number' );
			$counter_num_attr['class'][] = ( !in_array( $counter_num_font_size, array( '', 'custom' ) ) ) ?  killarwt_font_size_class( $counter_num_size, $counter_num_font_size ) : '';
			$counter_num_attr['class'][] = ( !in_array( $counter_num_font_weight, array( '', 'medium' ) ) ) ? 'font--' . $counter_num_font_weight : '';
			$counter_num_attr['class'][] = ( !in_array( $counter_num_font_style, array( '', 'normal', 'default' ) ) ) ? 'fst-' . $counter_num_font_style : '';
			$counter_num_attr['class'][] = ( !in_array( $counter_num_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $counter_num_text_transform : '';
			$counter_num_attr['class'][] = ( !in_array( $counter_num_alignment, array( '', 'left' ) ) ) ? 'text-' . $counter_num_alignment : '';
			$counter_num_attr['class'][] = ( !in_array( $counter_num_color, array( '', 'custom', 'default' ) ) ) ? 'text-' . $counter_num_color : '';
			$counter_num_attr['class'][] = ( ! empty( $counter_num_el_classes ) ) ? $counter_num_el_classes : '';
			
			$counter_number_prefix = ( !empty( $counter_number_prefix ) ) ? '<span class="pre text-'. $prefix_color .'">' . $counter_number_prefix . '</span>' : '';
			$counter_number_sufix = ( !empty( $counter_number_sufix ) ) ? '<span class="suf text-'. $sufix_color .'">' . $counter_number_sufix . '</span>' : '';
			
			if( in_array( $counter_num_size, array( '', 'h3' ) ) ) {
				$args['sec_content'] .= '<h3 ' . killarwt_stringify_atts( $counter_num_attr ) . '>' . $counter_number_prefix . '<span class="counter">' . do_shortcode( $counter_number ) . '</span>' . $counter_number_sufix . '</h3>';
			} else {
				$args['sec_content'] .= '<'. $counter_num_size .' ' . killarwt_stringify_atts( $counter_num_attr ) . '>' . $counter_number_prefix . '<span class="counter">' . do_shortcode( $counter_number ) . '</span>' . $counter_number_sufix . '</'. $counter_num_size .'>';
			}
		}
		
		// Content ----------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts );		
		
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

add_shortcode( 'killar_counter', 'killarwt_counter' );