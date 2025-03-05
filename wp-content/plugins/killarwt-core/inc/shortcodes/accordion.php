<?php
/*
Element Description: Accordion
*/

if ( ! function_exists( 'killarwt_accordion' ) ) :

	function killarwt_accordion( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'accordion_style'				=> '',
			'items'							=> array(),
			'icon'							=> '',
			'icon_active'					=> '',
			'active_first_accordion'		=> '',
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
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-accordion-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-accordion' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-accordion', 'accordion-section', 'faq-area' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'][] = ( !empty( $accordion_style ) ) ? 'accordion-' . $accordion_style : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
			
			$data_inn_attr = array();
			$data_inn_attr['class']	= array( 'faq-wrapper' );
			$data_inn_attr['class'][]	= ( $accordion_style == 'fancy' ) ? 'mt-10 mb-3' : '';
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_inn_attr ) . '>';
			
			
			$items_wrap_atts = array();
			$items_wrap_atts['class'][] = 'accordion';
			$items_wrap_atts['class'][] = ( ! empty( $item_wrap_el_classes ) ) ? $item_wrap_el_classes : '';
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $items_wrap_atts ) . '>';
			
			$atts['icon_type'] = 'icon';
			
			// Icon ---------------------------------------
			$icon_content = killarwt_get_shortcodes_icon_html( $atts );
			
			// Accordion Style
			if( $accordion_style == 'fancy' ) {
				$atts['title_el_classes'] = 'accordion-header ';
			} else if( $accordion_style == 'box' ) {
				$atts['title_el_classes'] = 'card-header py-3';
			}
			
			$i = 1;
			foreach( $items as $k => $item ) {
				
				$icon_type = 'icon';
				$item_uniqid = killarwt_uniqid('collapse-') . '-' .$i;
				
												
				$item_attr = array();
				$item_attr['class'] = array( 'card ');
				$item_attr['class'][]	= ( $accordion_style == 'fancy' ) ? 'border-0' : 'accordion-item mb-3 border rounded-3 overflow-hidden';
				$item_attr['class'][] = ( !empty( $icon_type ) ) ? 'icon-type-'. $icon_type : '';
				$item_attr['class'][] = ( ! empty( $item_el_classes ) ) ? $item_el_classes : '';
				
				$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_attr ) . '>';
				
				// Title ----------------------------------------
				$extra_attr = array();
				$extra_attr['data-bs-toggle'] = 'collapse';
				$extra_attr['data-bs-target'] = '#' . $item_uniqid;
				$extra_attr['aria-expanded'] = ( $i == 1 && $active_first_accordion == true ) ? 'true' :'false';
				$extra_attr['class'] = array( 'accordion-button collapsed' );

				if( !empty( $icon_content ) ) $item['title'] = $icon_content . $item['title'];
				
				$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'title', $atts, $item, $extra_attr );
				
				$content_wrap_attr = array();
				$content_wrap_attr['id'] = $item_uniqid;
				$content_wrap_attr['class'] = array( 'fbox-list-txt', 'collapse' );
				$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
				$content_wrap_attr['class'][] = ( $i == 1 && $active_first_accordion == true ) ? 'show' : '';
				
				$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
				
				// Content ----------------------------------------
				$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts, $item, array( 'class' => 'accordion-body' ) );
				
				$args['sec_content'] .= '</div>';
				
				$args['sec_content'] .= '</div>';
				
				$i++;
			}
				$args['sec_content'] .= '</div>';
			$args['sec_content'] .= '</div>';
			$args['sec_content'] .= '</div>';
		}
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_accordion', 'killarwt_accordion' );