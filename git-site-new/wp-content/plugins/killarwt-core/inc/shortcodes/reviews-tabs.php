<?php
/*
Element Description: Reviews Tabs
*/

if ( ! function_exists( 'killarwt_reviews_tabs' ) ) :

	function killarwt_reviews_tabs( $atts = array(), $content = null ) {

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
			'rating_el_classes'			=> '',
			'items_col_xxl'					=> '3',
			'items_col_xl'					=> '3',
			'items_col_lg'					=> '3',
			'items_col_md'					=> '3',
			'items_col_sm'					=> '2',
			'items_col_xs'					=> '1',
			'items_col_xxs'					=> '1',
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
		$args['id']  				= killarwt_uniqid('killar-reviews-tabs-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-reviews-tabs' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
	

		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-reviews-tabs' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
						
			$items_wrap_atts = array();
		
			$args['sec_content'] .= '<div class="row justify-content-center">';
				$args['sec_content'] .= '<div class="tab-content py-5" id="pills-tabContent">';
				// $args['sec_content'] .= '<div ' . killarwt_stringify_atts( $items_wrap_atts ) . '>';

				$tab_uid = killarwt_uniqid('rtp-');
				$i = 1;
				foreach( $items as $k => $item ) {

					$tab_item_uid = $tab_uid . '-'. $i;
					
					$title = $item['title'];
					$name = $item['name'];
					$content = $item['content'];
					$rating = $item['rating'];
					
					$item_attr = array();
					// $item_attr['class'] = array( 'review-text');
					$item_attr['class'][] = ( ! empty( $item_wrap_el_classes ) ) ? $item_wrap_el_classes : '';
					
					// $args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_attr ) . '>';
					
					// Icon ---------------------------------------
					$icon_content = killarwt_get_shortcodes_icon_html( $atts, $item );
					
					// Image ---------------------------------------
					if ( $reviews_style == 'reviews_style1' ) {
						$image_content = killarwt_get_shortcodes_image_html( $atts, $item, array( 'wrap_class' => 'review-avatar mr-20 rounded-circle review-img overflow-hidden' ) );
					}
					
					// Content -----------------------------------------
					$content_text = '';
					if( !empty( $item['content'] ) ) {
						
						$content_wrap_attr = array();
						$content_wrap_attr['class'] = array( 'bx-wrap-cont review-content-warp' );
						$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
						$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
						
						$content_text .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
						$content_text .= killarwt_get_shortcodes_fields_html( 'content', $atts, $item );
						$content_text .= '</div>';
					}
					
					// Rating -----------------------------------------
					$rating_html = '';
					if( !empty( $rating ) ) {
						$rating_size = 'span';
						$rating_attr = array();
						$rating_attr['class'] = array( 'review-rate' );
						$rating_attr['class'][] = ( !in_array( $rating_font_size, array( '', 'custom' ) ) ) ?  killarwt_font_size_class( $rating_size, $rating_font_size ) : '';
						$rating_attr['class'][] = ( !in_array( $rating_font_weight, array( '' ) ) ) ? 'font--' . $rating_font_weight : '';
						$rating_attr['class'][] = ( !in_array( $rating_alignment, array( '', 'left' ) ) ) ? 'text-' . $rating_alignment : '';
						$rating_attr['class'][] = ( ! empty( $rating_el_classes ) ) ? $rating_el_classes : '';
						
						$rating_cont = '';
						for ( $i = 1; $i<= 5; $i++ ) {
							if( $i <= $rating ) {
								$rating_cont .= '<span class="fas fa-star rating-color"></span>';
							} else {
								$rating_cont .= '<span class="fas fa-star"></span>';
							}
						}
						
						
						$rating_html .= '<div ' . killarwt_stringify_atts( $rating_attr ) . '>' . $rating_cont . '</div>';
					}
					
					// Name ----------------------------------------
					$name_content = killarwt_get_shortcodes_fields_html( 'name', $atts, $item, array( 'class' => 'review-name' ) );
					
					// Title ----------------------------------------
					$title_content = killarwt_get_shortcodes_fields_html( 'title', $atts, $item, array( 'class' => 'review-title' ) );
					
					// Rating ----------------------------------------
					if( !empty( $item['rating'] ) ) {
						$rating_cont = '';
						for ( $i = 1; $i<= 5; $i++ ) {
							if( $i <= $rating ) {
								$rating_cont .= '<span class="fas fa-star text-warning mx-2"></span>';
							} else {
								$rating_cont .= '<span class="fas fa-star"></span>';
							}
						}
						if( !empty( $rating_cont ) ) $item['rating'] = $rating_cont;
					}
					

					$item_inn_attr = array();
					$item_inn_attr['id'] = $tab_item_uid;
					$item_inn_attr['class'] = array( 'tab-pane fade text-center');
					$item_inn_attr['class'][] = ( $i == 1 ) ? 'active show' : '';
					$item_inn_attr['class'][] = ( ! empty( $item_el_classes ) ) ? $item_el_classes : '';
					$item_inn_attr['class'] += killarwt_get_shortcodes_alignment_array( 'item_hor', $atts, 'hor' );
					$item_inn_attr['class'] += killarwt_get_shortcodes_alignment_array( 'item_ver', $atts, 'ver' );
					$item_inn_attr['role'] = 'tabpanel';
					$item_inn_attr['aria-labelledby'] = $item_inn_attr['id'] . '-tab';
					
					$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $item_inn_attr ) . '>';
					$args['sec_content'] .= '<div class="review-rate-wrapper">';
					$args['sec_content'] .= $icon_content;
					//$args['sec_content'] .= $rating_cont;
					$args['sec_content'] .= '</div>';
					$args['sec_content'] .= $content_text;
					$args['sec_content'] .= $name_content;
					$args['sec_content'] .= $title_content;
					
					$args['sec_content'] .= '</div>';

					$i++;
				}
				$args['sec_content'] .= '</div>';

				$i = 1;
				$args['sec_content'] .= '<ul class="nav nav-pills mt-3 text-center align-items-center justify-content-center" id="pills-tab" role="tablist">';
				foreach( $items as $k => $item ) {

					$atts['thumbnail_size'] = $item['image_thumbnail_size'];
					$atts['thumbnail_custom_dimension'] = $item['image_thumbnail_custom_dimension'];

					$tab_item_uid = $tab_uid . '-'. $i;

					$image_content = killarwt_get_shortcodes_image_html( $atts, $item, array( 'wrap_class' => 'p-2 border border-3 circle licroobr' ) );
						
					$args['sec_content'] .='<li class="nav-item p-2" role="presentation">';

					$link_attr = array();
					$link_attr['id'] = $tab_item_uid .'-tab';
					$link_attr['href'] = '#';
					$link_attr['class'] = array( 'm-0');
					$link_attr['class'][] = ( $i == 1 ) ? 'active' : '';
					$link_attr['data-bs-toggle'] = 'pill';
					$link_attr['data-bs-target'] = '#'. $tab_item_uid;
					$link_attr['type'] = 'button';
					$link_attr['role'] = 'tab';
					$link_attr['aria-controls'] = $tab_item_uid;
					$link_attr['aria-selected'] = ( $i == 1 ) ? 'true' : 'false';

					$args['sec_content'] .= '<a ' . killarwt_stringify_atts( $link_attr ) . '>';

					$args['sec_content'] .= $image_content;
					$args['sec_content'] .= '</a>';
					$args['sec_content'] .= '</li>';

					$i++;
				}
				$args['sec_content'] .= '</ul>';

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

add_shortcode( 'killar_reviews_tabs', 'killarwt_reviews_tabs' );