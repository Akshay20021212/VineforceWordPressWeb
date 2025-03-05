<?php
/*
Element Description: Button
*/

if ( ! function_exists( 'killarwt_button' ) ) :

	function killarwt_button( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'button_text'					=> '',
			'icon_type'						=> 'flat-icon',
			'icon'							=> array(),
			'icon_image'					=> '',
			'icon_thumbnail_size'			=> 'thumbnail',
			'icon_thumbnail_custom_dimension'	=> array(),
			'icon_text'						=> '',
			'link'							=> '',
			'link_popup'					=> '',
			'icon_position'					=> '',
			'icon_position_tablet'			=> '',
			'icon_position_mobile'			=> '',
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
			'button_style'					=> 'flat',
			'button_size'					=> '',
			'button_font_size'				=> '',
			'button_custom_font_size'		=> '',
			'button_font_weight'			=> '500',
			'button_font_style'				=> 'default',
			'button_text_transform'			=> 'default',
			'button_line_height'			=> '',
			'button_letter_spacing'			=> '',
			'button_hor_alignment'			=> '',
			'button_hor_alignment_tablet'	=> '',
			'button_hor_alignment_mobile'	=> '',
			'button_ver_alignment'			=> '',
			'button_ver_alignment_tablet'	=> '',
			'button_ver_alignment_mobile'	=> '',
			'button_rounded_cornors'		=> 'rounded',
			'button_custom_radius'			=> '',
			'button_color'					=> 'default',
			'button_bg_color'				=> '',
			'button_text_color'				=> '',
			'button_border_color'			=> '',
			'button_hover_color'			=> 'default',
			'button_bg_hcolor'				=> '',
			'button_text_hcolor'			=> '',
			'button_border_hcolor'			=> '',
			'button_el_classes'				=> '',
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
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-fatures-box-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-button' );
		$args['wrap_atts']['class'][] 	= ( !empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_hor', $atts, 'hor' );
		$args['wrap_atts']['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_ver', $atts, 'ver' );
		$args['wrap_atts']['class'][] = in_array( $button_style, array( 'link' ) ) ? 'btn-2' : '';
		$args['wrap_atts'] += killarwt_get_shortcodes_animations_array( $atts );
		
		$button_extra_attr = array();
		$button_extra_attr['class'] = array();
		$button_extra_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$button_extra_attr['class'][] = ( !empty( $button_el_classes ) ) ? $button_el_classes : '';
		if( ! empty( $wrap_id ) ) $button_extra_attr['id'] = $wrap_id;
		$args['sec_content'] .= killarwt_get_shortcodes_button_html( $atts, '', $button_extra_attr );
	
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_button', 'killarwt_button' );