<?php
/*
Element Description: Features Box
*/
if ( ! function_exists( 'killarwt_features_box' ) ) :

	function killarwt_features_box( $atts = array() ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'icon_type'						=> 'icon',
			'icon'							=> array(),
			'icon_image'					=> '',
			'icon_thumbnail_size'			=> 'thumbnail',
			'icon_thumbnail_custom_dimension'=> array(),
			'icon_text'						=> '',
			'icon_position'					=> 'left',
			'icon_position_tablet'			=> '',
			'icon_position_mobile'			=> '',
			'title'							=> '',
			'content'						=> '',
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
			'wrap_text_alignment'			=> '',
			'wrap_text_alignment_tablet'	=> '',
			'wrap_text_alignment_mobile'	=> '',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'icon_view'						=> 'default',
			'icon_shape'					=> 'circle',
			'icon_size'						=> '',
			'icon_size_custom'				=> '',
			'icon_rounded_cornors'			=> '',
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
			'content_wrap_hor_alignment'	=> '',
			'content_wrap_hor_alignment_tablet' => '',
			'content_wrap_hor_alignment_mobile'	=> '',
			'content_wrap_el_classes'		=> '',
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
		$args['id']  				= killarwt_uniqid('killar-fatures-box-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-features-box' );
		$args['wrap_atts']['class'][] = ( !empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts'] += killarwt_get_shortcodes_animations_array( $atts );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-features-box' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_hor', $atts, 'hor' );
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_ver', $atts, 'ver' );
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_text', $atts, 'text' );
		$data_attr = killarwt_get_shortcodes_icon_classes_array( $atts, $data_attr );
		
		if( !empty( $link['url'] ) ) {
			$data_attr = $data_attr + killarwt_get_url_data( $link );
		}
				
		$args['sec_content'] .= ( ( !empty( $link['url'] ) ) ? '<a' : '<div' ) . ' ' .  killarwt_stringify_atts( $data_attr ) . '>';
		
		// Icon ---------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_icon_html( $atts );
		
		// Content Wrap -------------------------------				
		if( !empty( $title ) || !empty( $content ) ) {
				
			$content_wrap_attr = array();
			$content_wrap_attr['class'] = array( 'bx-wrap-cont' );
			$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
			$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
			
			// Title ----------------------------------------
			$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'title', $atts );
			
			// Content ----------------------------------------
			$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts );
		
			$args['sec_content'] .= '</div>';
		}
		
		$args['sec_content'] .= ( ( !empty( $link['url'] ) ) ? '</a>' : '</div>' );
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_features_box', 'killarwt_features_box' );