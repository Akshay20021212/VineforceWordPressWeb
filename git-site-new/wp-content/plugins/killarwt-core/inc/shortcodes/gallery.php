<?php
/*
Element Description: Gallery
*/

if ( ! function_exists( 'killarwt_gallery' ) ) :

	function killarwt_gallery( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'gallery_style'					=> '',
			'thumbnail_size'				=> 'medium',
			'thumbnail_custom_dimension'	=> array(),
			'items'							=> array(),
			'grid_padding'					=> '',
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
			'item_hor_alignment'			=> '',
			'item_hor_alignment_tablet'		=> '',
			'item_hor_alignment_mobile'		=> '',
			'item_ver_alignment'			=> '',
			'item_ver_alignment_tablet'		=> '',
			'item_ver_alignment_mobile'		=> '',
			'item_alignment'			=> '',
			'item_alignment_tablet'		=> '',
			'item_alignment_mobile'		=> '',
			'item_el_classes'				=> '',
			'item_wrap_el_classes'			=> '',
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
			'items_col_xxl'					=> '3',
			'items_col_xl'					=> '3',
			'items_col_lg'					=> '3',
			'items_col_md'					=> '3',
			'items_col_sm'					=> '2',
			'items_col_xs'					=> '1',
			'items_col_xxs'					=> '1',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-gallery-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-gallery' );
		$args['wrap_atts']['class'][] 	= ( !empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-gallery', 'row' );
		$data_attr['class'][] = 'gal-style-' . $gallery_style;
		$data_attr['class'][] = ( $gallery_style == 'masonry' ) ? 'masonry-wrap grid-loaded row g-xl-4 g-lg-3 g-3' : '';
		$data_attr['class'][] = ( !empty( $grid_padding ) && $grid_padding == 'gutter-0' ) ? 'ml-0 mr-0' : '';
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'][] = ( !empty( $item_wrap_el_classes ) ) ? $item_wrap_el_classes : '';
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_hor', $atts, 'hor' );
		$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_ver', $atts, 'ver' );
		$data_attr += killarwt_get_shortcodes_animations_array( $atts );
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
	
			foreach( $items as $k => $item ) {
				
				$title = $item['title'];
				$content = $item['content'];
				$use_link = ( !empty( $item['use_link'] ) ) ? $item['use_link'] : '';

				$item_attr = array();
				$item_attr['class'] = array( 'gal-item d-flex flex-column');
				$item_attr['class'][] = ( !empty( $icon_type ) ) ? 'icon-type-'. $icon_type : '';
				$item_attr['class'][] = ( $gallery_style == 'masonry' ) ? 'masonry-item' : '';
				$item_attr['class'][] = ( !empty( $grid_padding ) && $grid_padding == 'gutter-0' ) ? 'px-0' : '';
				$item_attr['class'][] = ( !empty( $item_el_classes ) ) ? $item_el_classes : '';
				$item_attr['class'] += killarwt_get_shortcodes_alignment_array( 'item_hor', $atts, 'hor' );
				$item_attr['class'] += killarwt_get_shortcodes_alignment_array( 'item_ver', $atts, 'ver' );
				$item_attr['class'] += killarwt_get_shortcodes_alignment_array( 'item', $atts, 'text' );
				
				$item_attr['class'][] = ( !empty( $use_link ) ) ? 'lnk-' . $use_link : '';
				
				if( $gallery_style == 'grid' ) {
					$item_attr['class'][] = killarwt_cols_class( 'xxl', $items_col_xxl );
					$item_attr['class'][] = killarwt_cols_class( 'xl', $items_col_xl );
					$item_attr['class'][] = killarwt_cols_class( 'lg', $items_col_lg );
					$item_attr['class'][] = killarwt_cols_class( 'md', $items_col_md );
					$item_attr['class'][] = killarwt_cols_class( 'sm', $items_col_sm );
					$item_attr['class'][] = killarwt_cols_class( 'xs', $items_col_xs );						
				}
				
				$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_attr ) . '>';

				if( $use_link == 'link' & !empty( $item['link']['url'] ) ) {
					$args['sec_content'] .= '<a ' . killarwt_stringify_atts( killarwt_get_url_data( $item['link'] ) ) . '>';
				} else if( $use_link == 'lightbox' ) {
					$args['sec_content'] .= '<a class="image-link position-relative" href="' . $item['image']['url'] . '">';
				}

				// Image ---------------------------------------
				$args['sec_content'] .= killarwt_get_shortcodes_image_html( $atts, $item );
				
				// Content Wrap -------------------------------				
				if( !empty( $title ) || !empty( $content ) ) {
						
					$content_wrap_attr = array();
					$content_wrap_attr['class'] = array();
					$content_wrap_attr['class'][] = 'bx-wrap-cont';
					$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
					$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
					
					$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
												
					// Title ----------------------------------------
					$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'title', $atts, $item );
							
					// Content -----------------------------------------
					$args['sec_content'] .= killarwt_get_shortcodes_fields_html( 'content', $atts, $item );
					
					$args['sec_content'] .= '</div>';
				}
				
				if( ( !empty( $item['link']['url'] ) || !empty( $item['image']['url'] ) ) && !empty( $use_link ) ) {
					$args['sec_content'] .= '</a>';
				}
				
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

add_shortcode( 'killar_image_carousel', 'killarwt_image_carousel' );