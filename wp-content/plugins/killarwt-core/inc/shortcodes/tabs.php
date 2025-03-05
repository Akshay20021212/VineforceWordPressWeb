<?php
/*
Element Description: tabs
*/

if ( ! function_exists( 'killarwt_tabs' ) ) :

	function killarwt_tabs( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'items'							=> array(),
			'type'                          => '',
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
			'tab_nav_wrap_hor_alignment'	=> '',
			'tab_nav_wrap_hor_alignment_tablet' => '',
			'tab_nav_wrap_hor_alignment_mobile'	=> '',
			'tab_nav_wrap_el_classes'		=> '',
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
			'title_align'					=> '',
			'title_alignment'				=> '',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'title_animation'				=> '',
			'title_animation_durations'		=> '',
			'title_animation_delay'			=> '',
			'title_el_classes'				=> '',
			'title_wrap_el_classes'			=> '',
			'content_wrap_hor_alignment'	=> '',
			'content_wrap_hor_alignment_tablet' => '',
			'content_wrap_hor_alignment_mobile'	=> '',
			'content_wrap_el_classes'		=> '',
			'content_size'					=> 'div',
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
		$args['id']  				= killarwt_uniqid('killar-tabs-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-tabs' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-tabs w-100' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr, $items );
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';

			$tab_uid = killarwt_uniqid('twt-');

			$tab_nav_wrap_attr = array();
			$tab_nav_wrap_attr['id'] = 'nav-tab-'. $tab_uid;
			$tab_nav_wrap_attr['class'] = array('nav nav-tabs border-0 no-list-style');
			$tab_nav_wrap_attr['class'][] = (!empty($tab_nav_wrap_el_classes)) ? $tab_nav_wrap_el_classes : '';
			$tab_nav_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array('tab_nav_wrap_hor', $atts, 'hor');
			$tab_nav_wrap_attr['role'] = 'tablist';

			$args['sec_content'] .= '<ul ' . killarwt_stringify_atts($tab_nav_wrap_attr) . '>';
			
			
			$i = 1;
			foreach ( $items as $k => $item ) {

				$tab_item_uid = $tab_uid . '-'. $i;

				// Icon -----------------------------------------
				$icon_content = killarwt_get_shortcodes_icon_html( $atts, $item );

				// Title ----------------------------------------
				$title_content = killarwt_get_shortcodes_fields_html( 'title', $atts, $item, array( 'class' => 'review-title' ) );

				$tab_btn_attr = array();
				$tab_btn_attr['id'] = 'nav-'. $tab_item_uid .'-tab';
				$tab_btn_attr['class'] = array( 'nav-link d-flex');
				$tab_btn_attr['class'][] = $title_wrap_el_classes;
				$tab_btn_attr['data-bs-toggle'] = 'tab';
				$tab_btn_attr['data-bs-target'] = '#nav-'.$tab_item_uid;
				$tab_btn_attr['role'] = 'tab';
				$tab_btn_attr['aria-controls'] = 'nav-'.$tab_item_uid;
				$tab_btn_attr['aria-selected'] = 'false';

				if( $i == 1 ) {
					$tab_btn_attr['class'][] = 'active';
					$tab_btn_attr['aria-selected'] = 'true';
				}

				$args['sec_content'] .= '<li ' . killarwt_stringify_atts( $tab_btn_attr ) . '>';

				$args['sec_content'] .= $icon_content;
				$args['sec_content'] .= $title_content;

				$args['sec_content'] .= '</li>';
			
				$i++;
			}
			
			$args['sec_content'] .= '</ul>';

			$args['sec_content'] .= '<div class="tab-content" id="nav-tabContent">';

			$content_wrap_attr = array();
			$content_wrap_attr['id'] = 'nav-tabContent';
			$content_wrap_attr['class'] = array('tab-content');
			$content_wrap_attr['class'][] = (!empty($content_wrap_el_classes)) ? $content_wrap_el_classes : '';
			$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array('content_wrap_hor', $atts, 'hor');

			$args['sec_content'] .= '<div ' . killarwt_stringify_atts($content_wrap_attr) . '>';


			$i = 1;

			$atts['content_size'] = 'div';
			foreach ( $items as $k => $item ) {

				$tab_item_uid = $tab_uid . '-'. $i;

				// Content -----------------------------------------
				$tab_content = killarwt_get_shortcodes_fields_html( 'content', $atts, $item );
				
				$active = ($i == 1) ? 'show active' : '';

				$args['sec_content'] .= '<div class="tab-pane '.$active.' fade" id="nav-'. $tab_item_uid .'" role="tabpanel" aria-labelledby="nav-'.$tab_item_uid.'-tab" tabindex="0">';
				$args['sec_content'].= $tab_content;
				
				$args['sec_content'] .= '</div>';
				
				$i++;
			}
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

add_shortcode( 'killar_tabs', 'killarwt_tabs' );