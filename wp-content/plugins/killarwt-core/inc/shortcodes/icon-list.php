<?php
/*
Element Description: Icon List
*/

if ( ! function_exists( 'killarwt_icon_list' ) ) :

	function killarwt_icon_list( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'items'							=> array(),
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
			'item_alignment'				=> 'ver',
			'item_ver_alignment'			=> 'start',
			'item_ver_alignment_tablet' 	=> '',
			'item_ver_alignment_mobile' 	=> '',
			'item_hor_alignment'			=> '',
			'item_hor_alignment_tablet'		=> '',
			'item_hor_alignment_mobile'		=> '',
			'show_item_devider'				=> 0,
			'item_color'					=> '',
			'item_color_custom'				=> '',
			'item_wrap_el_classes'			=> '',
			'item_el_classes'				=> '',
			'item_inn_el_classes'			=> '',
			'devider_size'					=> '1px',
			'devider_style'					=> 'solid',
			'devider_color_custom'			=> '',
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
			'icon_position'					=> 'left',
			'icon_position_tablet'			=> '',
			'icon_position_mobile'			=> '',
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
		
		// Add icon type
		if( !empty( $items ) ) {
			$icon_type_ar = array();
			$icon_types = array_column( $items, 'icon_type' );
			foreach( $icon_types as $tk => $type ) {
				if( $type != 'none' ) $icon_type_ar[] = $type;
			}
			if( !empty( $icon_type_ar ) ) $atts['icon_type'] = 'icon';
		}
		
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-icon-list-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-icon-list' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-icon-list w-100' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr, $items );
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
			
			$items_wrap_atts = array();
			$items_wrap_atts['class'][] = 'kwt-list no-list-style';
			$items_wrap_atts['class'][] = 'list-align-' . $item_alignment;
			$items_wrap_atts['class'] += killarwt_get_shortcodes_alignment_array( 'item_hor', $atts, 'hor' );
			$items_wrap_atts['class'] += killarwt_get_shortcodes_alignment_array( 'item_ver', $atts, 'ver' );
			$items_wrap_atts['class'][] = ( !in_array( $item_color, array( '', 'custom', 'default' ) ) ) ? 'text-' . $item_color : '';
			$items_wrap_atts['class'][] = ( $show_item_devider == 1 ) ? 'item-devider' : '';
			$items_wrap_atts['class'][] = ( ! empty( $item_wrap_el_classes ) ) ? $item_wrap_el_classes : '';
			
			$args['sec_content'] .= '<ul ' . killarwt_stringify_atts( $items_wrap_atts ) . '>';
			
				
				$icon_type_ar = array();
				
				foreach( $items as $k => $item ) {
					
					$icon 		= $item['icon'];
					$title 		= $item['title'];
					$content 	= $item['content'];
											
					$item_attr = array();
					$item_attr['class'] = array( 'list-item');
					$item_attr['class'][] = ( ! empty( $item['icon_type'] ) ) ? 'icon-type-' . $item['icon_type'] : '';
					$item_attr['class'][] = ( ! empty( $item_el_classes ) ) ? $item_el_classes : '';
					
					$args['sec_content'] .= '<li ' . killarwt_stringify_atts( $item_attr ) . '>';
					
					
					if( !empty( $item_inn_el_classes ) ) {
						$item_inn_attr = array();
						$item_inn_attr['class'] = array();
						$item_inn_attr['class'][] = ( ! empty( $item_inn_el_classes ) ) ? $item_inn_el_classes : '';
						$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_inn_attr ) . '>';
					}

					if ( empty( $title ) && empty( $content )) {
						if( !empty( $item['link']['url'] ) && $title_size != 'a' ) {
							$args['sec_content'] .= '<a ' . killarwt_stringify_atts( killarwt_get_url_data( $item['link'] ) ) . '>';
						}	
					}
					
					// Icon ---------------------------------------
					$args['sec_content'] .= killarwt_get_shortcodes_icon_html( $atts, $item );
					
					if ( empty( $title ) && empty( $content )) {
						if( !empty( $item['link']['url'] ) && $title_size != 'a' ) {
							$args['sec_content'] .= '</a>';
						}
					}

					// Content Wrap -------------------------------				
					if( !empty( $title ) || !empty( $content ) ) {
							
						$content_wrap_attr = array();
						$content_wrap_attr['class'] = array( 'bx-wrap-cont', 'fbox-list-txt' );
						$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
						$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
						
						// if content empty and title show as link then hide wrap
						if ( empty( $item['link']['url'] ) && $title_size != 'a' && !empty( $content ) ) {
						
							$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
							$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
						}

						if( !empty( $item['link']['url'] ) && $title_size != 'a' ) {
							$args['sec_content'] .= '<a ' . killarwt_stringify_atts( killarwt_get_url_data( $item['link'] ) ) . '>';
						}
						
						// Title ----------------------------------------
						$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'title', $atts, $item );
						
						// Content ----------------------------------------
						$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts, $item );
						
						if( !empty( $item['link']['url'] ) && $title_size != 'a' ) {
							$args['sec_content'] .= '</a>';
						}
					
						// if content empty and title show as link then hide wrap
						if ( empty( $item['link']['url'] ) && $title_size != 'a' && !empty( $content ) ) {
							$args['sec_content'] .= '</div>';
						}
					}
					
					if( !empty( $item_inn_el_classes ) ) {
						$args['sec_content'] .= '</div>';
					}
					
					$args['sec_content'] .= '</li>';	
				}
					
				$args['sec_content'] .= '</ul>';
			
			$args['sec_content'] .= '</div>';
		}
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_icon_list', 'killarwt_icon_list' );