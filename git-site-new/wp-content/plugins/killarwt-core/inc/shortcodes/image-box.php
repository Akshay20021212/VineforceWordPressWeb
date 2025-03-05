<?php
/*
Element Description: Image Box
*/

if ( ! function_exists( 'killarwt_image_box' ) ) :

	function killarwt_image_box( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'image'							=> '',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'title'							=> '',
			'content'						=> '',
			'inner_title'					=> '',
			'link'							=> '',
			'link_target'					=> 'Yes',
			'image_box_style'				=> 'default',
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
			'image_rounded_cornors'			=> '',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'image_hover_overlay'			=> '',
			'image_el_classes' 				=> '',
			'image_wrap_el_classes' 		=> '',
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
		
		// Display Type Widget
		if( $display_type == 'widget' ) {
			$atts['image'] = $image = array( 'id' => preg_replace( '/[^\d]/', '', $image ) );
			$title = $inner_title;
		}
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-image-box-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-image-box' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-image-box' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		$data_attr['class'][] = 'imgbx-s-' . ( ( !empty( $image_box_style ) ) ? $image_box_style : 'default' );
				
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '<a ' . killarwt_stringify_atts( killarwt_get_url_data( $link ) ) . '>';
		}
		
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
		
		// Image ---------------------------------------
		$args['sec_content'] .= killarwt_get_shortcodes_image_html( $atts );
		
		if( !empty( $title ) || !empty( $content ) ) {
			
			$content_wrap_attr = array();
			$content_wrap_attr['class'] = array( 'bx-img bx-cont' );
			$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
			$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
				
			if( $image_box_style == 'style-1' ) {
				$content_wrap_attr['class'][] = 'fbox-13-txt';
			} else if( $image_box_style == 'style-2' ) { 
				$content_wrap_attr['class'][] = 'image-description';
			} else {
				$content_wrap_attr['class'][] = 'bx-wrap-cont';
			}
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
			
			// Image Gallery Style
			if( $image_box_style == 'style-2' ) { 
				$sub_content_wrap_attr = array();
				$sub_content_wrap_attr['class'] = array('image-data');
				$args['sec_content'] .= '<div class="item-overlay"></div>';
				$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $sub_content_wrap_attr ) . '>';
			}
					
			// Title ----------------------------------------
			$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'title', array_merge( $atts, array( 'title_size' => 'h6', 'title_font_size' => 'md' ) ) );
					
			// Content -----------------------------------------
			$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts );
			
			// Image Gallery Style
			if( $image_box_style == 'style-2' ) { 
				$args['sec_content'] .= '</div>';
			}
			
			$args['sec_content'] .= '</div>';
		}
		
		$args['sec_content'] .= '</div>';
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '</a>';
		}
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_image_box', 'killarwt_image_box' );