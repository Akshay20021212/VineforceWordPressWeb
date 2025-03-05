<?php
/*
Element Description: Progress Bar
*/
if ( ! function_exists( 'killarwt_progress_bar' ) ) :

	function killarwt_progress_bar( $atts = array(), $content = null ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'progress_bar_style'			=> '',
			'items'							=> '',
			'progress_bar_stripe'			=> '',
			'progress_bar_stripe_animation'	=> '',
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
			'progress_bar_size'				=> 'h3',
			'progress_bar_font_size'		=> '',
			'progress_bar_custom_font_size'	=> '',
			'progress_bar_font_weight'		=> '',
			'progress_bar_font_style'		=> '',
			'progress_bar_text_transform'	=> '',
			'progress_bar_color'			=> '',
			'progress_bar_color_custom'		=> '',
			'progress_bar_line_height'		=> '',
			'progress_bar_letter_spacing'	=> '',
			'progress_bar_alignment'		=> '',
			'progress_bar_alignment_tablet'	=> '',
			'progress_bar_alignment_mobile'	=> '',
			'progress_bar_animation'		=> '',
			'progress_bar_animation_durations'	=> '',
			'progress_bar_animation_delay'	=> '',
			'progress_bar_el_classes'		=> '',
			'progress_bar_wrap_el_classes'	=> '',
			'unit_size'				=> 'span',
			'unit_font_size'			=> '',
			'unit_custom_font_size'	=> '',
			'unit_font_weight'		=> '',
			'unit_font_style'			=> '',
			'unit_text_transform'		=> '',
			'unit_color'				=> '',
			'unit_color_custom'		=> '',
			'unit_line_height'		=> '',
			'unit_letter_spacing'		=> '',
			'unit_alignment'			=> '',
			'unit_alignment_tablet'	=> '',
			'unit_alignment_mobile'	=> '',
			'unit_animation'			=> '',
			'unit_animation_durations'=> '',
			'unit_animation_delay'	=> '',
			'unit_el_classes'			=> '',
			'unit_wrap_el_classes'	=> '',
			'shortcode_from'				=> 'shortcode'
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-progress-bar-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-progress-bar' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-progress-bar progess-wrapper' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'][] = ( !empty( $item_wrap_el_classes ) ) ? $item_wrap_el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		$data_attr['class'][] = ( !empty( $progress_bar_style ) ) ? 'progress-bar-' . $progress_bar_style : '';
	
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
		
		if( !empty( $items ) ) {
			
			foreach( $items as $k => $item ) {
				
				$item_attr = array();
				$item_attr['class'] = array( 'pb-item');
				$item_attr['class'][] = ( ! empty( $item_el_classes ) ) ? $item_el_classes : '';
				$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_attr ) . '>';
				
				$content_wrap_attr = array();
				$content_wrap_attr['class'] = array( 'single-skill mb-20', 'over-hidden' );
				$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
				$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
					
				// Title ----------------------------------------
				$title_html = '';
				if( !empty( $item['title'] ) ) {
					
					$title_wrap_attr = array();
					$title_wrap_attr['class'] = array( 'bar-title' );
					$title_wrap_attr['class'][] = ( ! empty( $title_wrap_el_classes ) ) ? $title_wrap_el_classes : '';
					
					$title_html .= '<div ' . killarwt_stringify_atts( $title_wrap_attr ) . '>';
					$title_html .= killarwt_get_shortcodes_fields_html( 'title', $atts, $item );
					$title_html .= '</div>';
				}
				
				// Unit ----------------------------------------
				$unit_text = '';
				if( !empty( $item['unit']['size'] ) ) {
					$unit_text = ( $item['unit']['unit'] == 'custom' ) ? $item['unit']['size'] : $item['unit']['size'] . $item['unit']['unit'];
				}
				$unit_html = '';

				if( $progress_bar_style == 'style3' ) {
					$unit_html .= $title_html;
				} else {
					$args['sec_content'] .= $title_html;
				}
				
				if( !empty( $unit_text ) ) {
					$atts['unit'] = $unit_text;
					$unit_html .= killarwt_get_shortcodes_fields_html( 'unit', $atts );
				}
				
				if( !empty( $unit_text ) ) {
					
					$progress_bar_wrap_attr = array();
					$progress_bar_wrap_attr['class'] = array( 'bx-progress', 'progress' );
					$progress_bar_wrap_attr['class'][] = ( ! empty( $progress_bar_wrap_el_classes ) ) ? $progress_bar_wrap_el_classes : '';
					
					$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $progress_bar_wrap_attr ) . '>';
					
					$progress_bar_etx_atts = array();
					$progress_bar_etx_atts['class'] = array('progress-bar');
					$progress_bar_etx_atts['class'][] = ( !in_array( $item['pb_bg_color'], array( '', 'custom', 'default' ) ) ) ? 'bg-' . $item['pb_bg_color'] : '';
					$progress_bar_etx_atts['class'][] = ( !empty( $progress_bar_stripe ) ) ? 'progress-bar-striped' : '';
					$progress_bar_etx_atts['class'][] = ( !empty( $progress_bar_stripe_animation ) ) ? 'progress-bar-animated' : '';
					if( empty( $atts['progress_bar_animation'] ) ) {
						$progress_bar_etx_atts['data-aos'] = 'fade-right';
						$progress_bar_etx_atts['aos-delay'] = '600';
						$progress_bar_etx_atts['aos-duration'] = '1000';
					}
					$progress_bar_etx_atts['role'] = 'progressbar';
					//$progress_bar_etx_atts['aria-valuenow'] = $unit['size'];
					$progress_bar_etx_atts['aria-valuemin'] = 0;
					$progress_bar_etx_atts['aria-valuemax'] = 100;
					$pb_ext_inline_css_ar = array( 'width' => $unit_text );
					if( !empty( $item['pb_bg_color'] == 'custom' ) && !empty( $item['pb_bg_color_custom'] ) ) {
						$pb_ext_inline_css_ar['background-color'] = $item['pb_bg_color_custom'];
					}
					
					$progress_bar_etx_atts['style'] = killarwt_inline_output_css( $pb_ext_inline_css_ar );
					$atts['progress_bar'] = $unit_html;
					$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'progress_bar', $atts, $item, $progress_bar_etx_atts );
					
					$args['sec_content'] .= '</div>';
					
				}
					
				$args['sec_content'] .= '</div>';
				
				$args['sec_content'] .= '</div>';
				
			}
			
			$args['sec_content'] .= '</div>';
			
		}
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_progress_bar', 'killarwt_progress_bar' );