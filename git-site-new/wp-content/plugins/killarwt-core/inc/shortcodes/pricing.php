<?php
/*
Element Description: Pricing
*/

if ( ! function_exists( 'killarwt_pricing' ) ) :

	function killarwt_pricing( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'pricing_box_style'				=> '',
			'pricing_box_type'				=> 'monthly',
			'icon_type'						=> 'icon',
			'icon'							=> array(),
			'image'							=> '',
			'icon_thumbnail_size'			=> 'thumbnail',
			'icon_thumbnail_custom_dimension'=> array(),
			'icon_text'						=> '',
			'icon_class'					=> '',
			'title'							=> '',
			'content'						=> '',
			'content_items'					=> array(),
			'price_amount_m'				=> '',
			'price_amount_y'				=> '',
			'price_currency'				=> '',
			'price_prefix'					=> '',
			'price_validity'				=> '',
			'button_text'					=> '',
			'button_link'					=> '',
			'button_link_target'			=> '',
			'icon_position'					=> 'top',
			'animation'						=> '',
			'animation_durations'			=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'add_pricing_box_shadow' 		=> '0',
			'pricing_box_bg_color' 			=> '',
			'pricing_box_bg_color_custom' 	=> '',
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
			'content_size'					=> 'span',
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
			'content_list_size'				=> 'p',
			'content_list_font_size'		=> '',
			'content_list_custom_font_size'	=> '',
			'content_list_font_weight'		=> '',
			'content_list_font_style'		=> '',
			'content_list_text_transform'	=> '',
			'content_list_color'			=> '',
			'content_list_color_custom'		=> '',
			'content_list_line_height'		=> '',
			'content_list_letter_spacing'	=> '',
			'content_list_alignment'		=> '',
			'content_list_alignment_tablet'	=> '',
			'content_list_alignment_mobile'	=> '',
			'content_list_animation'		=> '',
			'content_list_animation_durations'=> '',
			'content_list_animation_delay'	=> '',
			'content_list_el_classes'		=> '',
			'price_size'					=> 'p',
			'price_font_size'				=> '',
			'price_custom_font_size'		=> '',
			'price_font_weight'				=> '',
			'price_font_style'				=> '',
			'price_text_transform'			=> '',
			'price_color'					=> '',
			'price_color_custom'			=> '',
			'price_line_height'				=> '',
			'price_letter_spacing'			=> '',
			'price_alignment'				=> '',
			'price_alignment_tablet'		=> '',
			'price_alignment_mobile'		=> '',
			'price_animation'				=> '',
			'price_animation_durations'		=> '',
			'price_animation_delay'			=> '',
			'price_el_classes'				=> '',
			'price_wrap_el_classes'			=> '',
			'period_size'					=> 'span',
			'period_font_size'				=> '',
			'period_custom_font_size'		=> '',
			'period_font_weight'			=> '',
			'period_font_style'				=> '',
			'period_text_transform'			=> '',
			'period_color'					=> '',
			'period_color_custom'			=> '',
			'period_line_height'			=> '',
			'period_letter_spacing'			=> '',
			'period_alignment'				=> '',
			'period_alignment_tablet'		=> '',
			'period_alignment_mobile'		=> '',
			'period_animation'				=> '',
			'period_animation_durations'	=> '',
			'period_animation_delay'		=> '',
			'period_el_classes'				=> '',
			'period_wrap_el_classes'		=> '',
			'price_prefix_size'				=> 'sup',
			'price_prefix_font_size'		=> '',
			'price_prefix_custom_font_size'	=> '',
			'price_prefix_font_weight'		=> '',
			'price_prefix_font_style'		=> '',
			'price_prefix_text_transform'	=> '',
			'price_prefix_color'			=> '',
			'price_prefix_color_custom'		=> '',
			'price_prefix_line_height'		=> '',
			'price_prefix_letter_spacing'	=> '',
			'price_prefix_alignment'		=> '',
			'price_prefix_alignment_tablet'	=> '',
			'price_prefix_alignment_mobile'	=> '',
			'price_prefix_animation'		=> '',
			'price_prefix_animation_durations'	=> '',
			'price_prefix_animation_delay'	=> '',
			'price_prefix_el_classes'		=> '',
			'price_prefix_wrap_el_classes'	=> '',
			'price_currency_size'				=> 'sup',
			'price_currency_font_size'		=> '',
			'price_currency_custom_font_size'	=> '',
			'price_currency_font_weight'		=> '',
			'price_currency_font_style'		=> '',
			'price_currency_text_transform'	=> '',
			'price_currency_color'			=> '',
			'price_currency_color_custom'		=> '',
			'price_currency_line_height'		=> '',
			'price_currency_letter_spacing'	=> '',
			'price_currency_alignment'		=> '',
			'price_currency_alignment_tablet'	=> '',
			'price_currency_alignment_mobile'	=> '',
			'price_currency_animation'		=> '',
			'price_currency_animation_durations'	=> '',
			'price_currency_animation_delay'	=> '',
			'price_currency_el_classes'		=> '',
			'price_currency_wrap_el_classes'	=> '',
			'button_style'					=> 'flat',
			'button_size'					=> '',
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
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-pricing-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-pricing' );
		$args['wrap_atts'] += killarwt_get_shortcodes_wrap_common_array( $atts,  $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-pricing radius-06' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'][] = ( !empty( $add_pricing_box_shadow ) ) ? 'bx-shadow' : '';
		$data_attr['class'][] = ( !empty( $pricing_box_style ) ) ? $pricing_box_style : 'pricing-1-table';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		if( !empty( $link['url'] ) ) {
			$data_attr = $data_attr + killarwt_get_url_data( $link );
		}
				
		$args['sec_content'] .= ( ( !empty( $link['url'] ) ) ? '<a' : '<div' ) . ' ' .  killarwt_stringify_atts( $data_attr ) . '>';
		
		$content_wrap_attr = array();
		$content_wrap_attr['class'] = array( 'pricing-wrap' );
		// $content_wrap_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : 'packages transition5 text-center pt-60 pb-60 mb-40';
		
		$args['sec_content'] .= killarwt_get_shortcodes_icon_html( $atts );
		
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
			
		// Title ----------------------------------------
		$title_html = killarwt_get_shortcodes_fields_html( 'title', $atts );
		
		// Content -----------------------------------------
		$content_html = killarwt_get_shortcodes_fields_html( 'content', $atts );
		
		// Content Items -----------------------------------------
		$content_items_html = '';
		
		if( !empty( $content_items ) ) {
			
			$data_attr = array();
			$data_attr['class'] = array( 'p-0 m-0' );
			$data_attr['class'][] = ( !empty( $content_list_wrap_el_classes ) ) ? $content_list_wrap_el_classes : '';
			

			$content_items_html .= '<div class="prcs-list mb-3"> ';
			$content_items_html .= '<ul ' . killarwt_stringify_atts( $data_attr ) . '>';

			$icon_el_classes = $atts['icon_el_classes'];
	
			foreach( $content_items as $k => $item ) {

				// Add Icon classes
				$atts['icon_el_classes'] = $icon_el_classes;
				$atts['icon_el_classes'] .= ' ' . $item['icon_class'];

				$icon_content = killarwt_get_shortcodes_icon_html( $atts, $item );
				
				$content_list_attr = array();
				$content_list_attr['class'] = array( 'item' );
				$content_list_attr['class'][] = ( !in_array( $content_list_font_size, array( '', 'custom' ) ) ) ?  killarwt_font_size_class( $content_list_size. '-' . $content_list_font_size ) : '';
				$content_list_attr['class'][] = ( !in_array( $content_list_font_weight, array( '', 'medium' ) ) ) ? 'font--' . $content_list_font_weight : '';
				$content_list_attr['class'][] = ( !in_array( $content_list_font_style, array( '', 'normal', 'default' ) ) ) ? 'fst-' . $content_list_font_style : '';
				$content_list_attr['class'][] = ( !in_array( $content_list_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_list_text_transform : '';
				$content_list_attr['class'][] = ( !in_array( $content_list_alignment, array( '' ) ) ) ? 'text-' . $content_list_alignment : '';
				$content_list_attr['class'][] = ( !in_array( $content_list_color, array( '', 'custom', 'default' ) ) ) ? 'text-' . $content_list_color : '';
				$content_list_attr['class'][] = ( ! empty( $content_list_el_classes ) ) ? $content_list_el_classes : '';
				
				$content_items_html .= '<li ' . killarwt_stringify_atts( $content_list_attr ) . '>';
				
				$content_items_html .= $icon_content;
	
				if( in_array( $content_list_size, array( '', 'span' ) ) ) {
					$content_items_html .= '<span>' . wp_kses_post( $item['title'] ) . '</span>';
				} else {
					$content_items_html .= '<'. $content_list_size .'>' . wp_kses_post( $item['title'] ) . '</'. $content_list_size .'>';
				}
				
				$content_items_html .= '</li>';
			}
			$content_items_html .= '</ul>';
			$content_items_html .= '</div>';
		}
		
		// Pricing -----------------------------------------
		
		$pricing_html = '';
		
		if( $price_amount_m != '' || $price_amount_y != '' ) {
			
			$price_wrap_attr = array();
			$price_wrap_attr['class'] = array( 'prcs-currency py-3 price' );
			$price_wrap_attr['class'][] = ( !empty( $price_wrap_el_classes ) ) ? $price_wrap_el_classes : '';
			
			$pricing_html .= '<div ' . killarwt_stringify_atts( $price_wrap_attr ) . '>';

			// Price Prefix -----------------------------------------
			$price_prefix_html = killarwt_get_shortcodes_fields_html( 'price_prefix', $atts,  array( 'class' => 'price-prefix' ) );

			// Currency -----------------------------------------
			$price_currency_html = killarwt_get_shortcodes_fields_html( 'price_currency', $atts,  array( 'class' => 'price-currency' ) );

			// Monthly Price -----------------------------------------
			if ( in_array( $pricing_box_type, array( 'monthly', 'monthly-annualy' ) ) ) {

				$atts['price'] = $price_currency_html . $price_amount_m . $price_prefix_html;
				$pricing_html .= killarwt_get_shortcodes_fields_html( 'price', $atts, array(), array( 'class' => 'price mb-1 js-montlypricing' ) );
			}

			// Annualy Price -----------------------------------------
			if ( in_array( $pricing_box_type, array( 'monthly', 'monthly-annualy' ) ) ) {

				$atts['price'] = $price_currency_html . $price_amount_y . $price_prefix_html;
				$pricing_html .= killarwt_get_shortcodes_fields_html( 'price', $atts, array(), array( 'class' => 'price mb-1 js-yearlypricing' ) );
			}
			
			$pricing_html .= ( $price_validity ) ? '<span class="validity">' . $price_validity . '</span>' : '';


			// Period -----------------------------------------
			$pricing_html .= killarwt_get_shortcodes_fields_html( 'period', $atts );
			
			$pricing_html .= '</div>';
		}
		
		$button_html = '';
		
		// Button -----------------------------------------
		$button_html = killarwt_get_shortcodes_button_html( $atts, array() ,array('class' => 'full-width'));
		
		if( in_array( $pricing_box_style, array( 'pricing-2-table' ) ) ) {
			$args['sec_content'] .= $title_html . '<div class="content px-1">' . $content_html . '</div>' . $pricing_html . $content_items_html . '<div class="my-btn d-block mb-3">' . $button_html . '</div>';
		} else {
			$args['sec_content'] .= '<div class="prcs-headlines py-3">' . $title_html . $content_html . '</div>' . $pricing_html . '<div class="prcs-body bg-white py-4 px-lg-4 px-md-2 px-4 rounded-3">' . $content_items_html . '<div class="prcs-buttons">' . $button_html . '</div> </div>';
		}
			
		$args['sec_content'] .= '</div>';
		
		$args['sec_content'] .= '</div>';
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'killar_pricing', 'killarwt_pricing' );