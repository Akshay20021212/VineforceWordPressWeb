<?php
/*
Element Description: Reviews Carousel
*/

if ( ! function_exists( 'killarwt_reviews_carousel' ) ) :

	function killarwt_reviews_carousel( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'items'							=> array(),
			'thumbnail_size'				=> 'large',
			'thumbnail_custom_dimension'	=> array(),
			'reviews_style'					=> 'reviews-style1',
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
			'image_rounded_cornors'			=> '',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'image_hover_overlay'			=> '',
			'image_el_classes' 				=> '',
			'content_wrap_hor_alignment'	=> '',
			'content_wrap_hor_alignment_tablet' => '',
			'content_wrap_hor_alignment_mobile'	=> '',
			'content_wrap_el_classes'		=> '',
			'name_size'						=> 'h3',
			'name_font_size'				=> '',
			'name_custom_font_size'			=> '',
			'name_font_weight'				=> '',
			'name_font_style'				=> '',
			'name_text_transform'			=> '',
			'name_color'					=> '',
			'name_color_custom'				=> '',
			'name_line_height'				=> '',
			'name_letter_spacing'			=> '',
			'name_alignment'				=> '',
			'name_alignment_tablet'			=> '',
			'name_alignment_mobile'			=> '',
			'name_animation'				=> '',
			'name_animation_durations'		=> '',
			'name_animation_delay'			=> '',
			'name_el_classes'				=> '',
			'name_wrap_el_classes'			=> '',
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
			'rating_size'					=> 'p',
			'rating_font_size'				=> '',
			'rating_custom_font_size'		=> '',
			'rating_font_weight'			=> '',
			'rating_font_style'			=> '',
			'rating_text_transform'		=> '',
			'rating_color'					=> '',
			'rating_color_custom'			=> '',
			'rating_line_height'			=> '',
			'rating_letter_spacing'		=> '',
			'rating_alignment'				=> '',
			'rating_alignment_tablet'		=> '',
			'rating_alignment_mobile'		=> '',
			'rating_animation'				=> '',
			'rating_animation_durations'	=> '',
			'rating_animation_delay'		=> '',
			'rating_el_classes'				=> '',
			'rating_wrap_el_classes'			=> '',
			'items_col_xxl'					=> '3',
			'items_col_xl'					=> '3',
			'items_col_lg'					=> '3',
			'items_col_md'					=> '3',
			'items_col_sm'					=> '2',
			'items_col_xs'					=> '1',
			'items_col_xxs'					=> '1',
			'nums_rows'						=> '1',
			'carousel_nav'					=> '1',
			'carousel_infinite'				=> '1',
			'carousel_dots'					=> '0',
			'carousel_speed'				=> '1000',
			'carousel_autoplay'				=> '1',
			'carousel_autoplay_speed'		=> '3500',
			'carousel_center_mode'			=> '0',
			'carousel_variable_width'		=> '0',
			'carousel_variable_width_tablet' => '0',
			'carousel_variable_width_mobile' => '0',
			'carousel_adaptive_height'		=> '0',
			'carousel_as_nav_for'			=> '',
			'carousel_el_classes'			=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-reviews-carosel-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-reviews-carousel' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-reviews-carousel' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
						
			$items_car_atts = array();
			$items_car_atts = killarwt_get_shortcodes_carousel_atts( $atts, $items_car_atts );
		
			$args['sec_content'] .= '<div class="kwt-owl-slider-wrapper">';
				$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $items_car_atts ) . '>';
				
					$rating_color = ( !empty( $atts['rating_color'] ) && !in_array( $atts['rating_color'], array( '', 'custom', 'default' ) ) ) ? 'text-' . $atts['rating_color'] : '';
					foreach( $items as $k => $item ) {
				
						$title = $item['title'];
						$name = $item['name'];
						$content = $item['content'];
						$rating = $item['rating'];
						
						$item_attr = array();
						$item_attr['class'] = array( 'review-text');
						$item_attr['class'][] = ( ! empty( $item_wrap_el_classes ) ) ? $item_wrap_el_classes : '';
						$item_attr['class'][] = ( ! empty( $item['item_wrap_el_classes'] ) ) ? $item['item_wrap_el_classes'] : '';
						
						$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_attr ) . '>';
						
						$item_inn_attr = array();
						$item_inn_attr['class'] = array( 'testi-inn-text');
						$item_inn_attr['class'][] = ( ! empty( $item_el_classes ) ) ? $item_el_classes : '';
						$item_inn_attr['class'] += killarwt_get_shortcodes_alignment_array( 'item_hor', $atts, 'hor' );
						$item_inn_attr['class'] += killarwt_get_shortcodes_alignment_array( 'item_ver', $atts, 'ver' );
						
						$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_inn_attr ) . '>';
						
						// Icon ---------------------------------------
						$icon_content = killarwt_get_shortcodes_icon_html( $atts, $item );
						
						// Image ---------------------------------------
						$atts['thumbnail_size'] = $item['image_thumbnail_size'];
						$atts['thumbnail_custom_dimension'] = $item['image_thumbnail_custom_dimension'];
						$image_content = killarwt_get_shortcodes_image_html( $atts, $item, array( 'wrap_class' => 'boxl-revws-thumb overflow-hidden' ) );
						
						// Content -----------------------------------------
						$content_text = '';
						if( !empty( $item['content'] ) ) {
							
							$content_wrap_attr = array();
							$content_wrap_attr['class'] = array( 'boxl-revws-cpas bx-wrap-cont review-content-warp' );
							$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
							$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
							
							$content_text .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
							$content_text .= killarwt_get_shortcodes_fields_html( 'content', $atts, $item );
							$content_text .= '</div>';
						}
						
						// Rating -----------------------------------------
						$rating_html = '';
						if( !empty( $rating ) ) {
							$rating_attr = array();
							$rating_attr['class'] = array( 'review-rate d-flex' );
							$rating_attr['class'][] = ( !in_array( $rating_font_size, array( '', 'custom' ) ) ) ?  killarwt_font_size_class( $rating_size, $rating_font_size ) : '';
							$rating_attr['class'][] = ( !in_array( $rating_font_weight, array( '' ) ) ) ? 'fw-' . $rating_font_weight : '';
							$rating_attr['class'][] = ( !in_array( $rating_alignment, array( '', 'left' ) ) ) ? 'text-' . $rating_alignment : '';
							$rating_attr['class'][] = ( ! empty( $rating_wrap_el_classes ) ) ? $rating_wrap_el_classes : '';
							
							$rating_cont = '';
							for ( $i = 1; $i <= 5; $i++ ) {
								$rating_item_attr = array();
								$rating_item_attr['class'] = array( 'fas fa-star' );
								$rating_item_attr['class'][] = ( ! empty( $rating_el_classes ) ) ? $rating_el_classes : '';
								if ( $i <= $rating ) {
									$rating_item_attr['class'][] = $rating_color;
								}

								$rating_cont .= '<i ' . killarwt_stringify_atts( $rating_item_attr ) . '></i>';
							}

							$item['rating'] = $rating_cont;
							$atts['rating_color'] = $atts['rating_el_classes'] = '';
							
							$rating_html .= killarwt_get_shortcodes_fields_html( 'rating', $atts, $item, $rating_attr );
						}
						
						// Name ----------------------------------------
						$name_content = killarwt_get_shortcodes_fields_html( 'name', $atts, $item, array( 'class' => 'review-name' ) );
						
						// Title ----------------------------------------
						$title_content = killarwt_get_shortcodes_fields_html( 'title', $atts, $item, array( 'class' => 'review-title mb-0' ) );

						if ( $reviews_style == 'reviews-style1' ) {
							$args['sec_content'] .= '<div class="boxl-revws text-center position-relative px-xl-5 px-lg-3 px-2">';
							$args['sec_content'] .= $icon_content;
							$args['sec_content'] .= $rating_html;
							$args['sec_content'] .= $content_text;
							$args['sec_content'] .= '<div class="testi-info mt-35 d-flex align-items-center justify-content-center mb-20">';
							$args['sec_content'] .= $image_content;
							$args['sec_content'] .= '<div class="ms-2 testi-info-content">';
							$args['sec_content'] .= $name_content;
							$args['sec_content'] .= $title_content;
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= '</div>';
						
						} else if ( $reviews_style == 'reviews-style3' ) {

							$args['sec_content'] .= $icon_content;
							$args['sec_content'] .= '<div class="d-flex align-items-center mb-3">';
							$args['sec_content'] .= $image_content;
							$args['sec_content'] .= '<div class="ms-2 testi-info-content">';
							$args['sec_content'] .= $name_content;
							$args['sec_content'] .= $title_content;
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= $rating_html;
							$args['sec_content'] .= $content_text;

						} else if ( $reviews_style == 'reviews-style4' ) {

							$args['sec_content'] .= $icon_content;
							$args['sec_content'] .= '<div class="d-flex align-items-center mb-3">';
							$args['sec_content'] .= $image_content;
							$args['sec_content'] .= '<div class="ms-2 testi-info-content">';
							$args['sec_content'] .= $name_content;
							$args['sec_content'] .= $title_content;
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= $content_text;	
							$args['sec_content'] .= '<div class="d-flex align-items-center"><h6 class="fw-bold m-0">Rating:</h6>'.$rating_html.'</div>';
							
						} else {
							$args['sec_content'] .= '<div class="review-rate-wrapper text-center mb-4 pt-4 pt-sm-0">';
							$args['sec_content'] .= '<div class="mb-4">';
							$args['sec_content'] .= killarwt_get_shortcodes_image_html( $atts, $item, array( 'wrap_class' => 'review-avatar review-img overflow-hidden border border-2 mb-3 p-2 mb-0 circle d-inline-flex' ) );
							$args['sec_content'] .= $name_content;
							$args['sec_content'] .= $title_content;
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= $rating_html;
							$args['sec_content'] .= $content_text;
							$args['sec_content'] .= $icon_content;
							$args['sec_content'] .= '</div>';
						}
						
						$args['sec_content'] .= '</div>';
						$args['sec_content'] .= '</div>';
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

add_shortcode( 'killar_image_carousel', 'killarwt_image_carousel' );