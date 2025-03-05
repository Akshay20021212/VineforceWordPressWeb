<?php
/*
Element Description: Blockquote
*/

if ( ! function_exists( 'killarwt_blockquote' ) ) :

	function killarwt_blockquote( $atts  ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'blockquote_style'				=> '',
			'icon_type'						=> 'icon',
			'icon'							=> array(),
			'icon_image'					=> '',
			'icon_thumbnail_size'			=> 'thumbnail',
			'icon_thumbnail_custom_dimension'=> array(),
			'icon_text'						=> '',
			'content'						=> '',
			'icon_position'					=> 'left',
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
			'wrap_text_alignment'			=> '',
			'wrap_text_alignment_tablet'	=> '',
			'wrap_text_alignment_mobile'	=> '',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
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
		$args['id']  				= killarwt_uniqid('killar-blockquote-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-blockquote' );
		$args['wrap_atts']['class'][] = ( !empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts'] += killarwt_get_shortcodes_animations_array( $atts );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-blockquote quote' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_hor', $atts, 'hor' );
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_ver', $atts, 'ver' );
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_text', $atts, 'text' );
		$data_attr = killarwt_get_shortcodes_icon_classes_array( $atts, $data_attr );
		
		$data_attr['class'][] = ( !empty( $blockquote_style ) ) ? 'bq-style-' . $blockquote_style : '';
		
		
		if( !empty( $link['url'] ) ) {
			$data_attr = $data_attr + killarwt_get_url_data( $link );
		}
				
		$args['sec_content'] .= ( ( !empty( $link['url'] ) ) ? '<a' : '<div' ) . ' ' .  killarwt_stringify_atts( $data_attr ) . '>';
		
		// Icon ---------------------------------------
		if( $blockquote_style == 'icon' ) {
			$args['sec_content'] .= killarwt_get_shortcodes_icon_html( $atts );
		}
	
		// Content ----------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts, '', array( 'class' => 'bq-content blockquote' ) );
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/blockquote', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_blockquote', 'killarwt_blockquote' );