<?php
/*
Element Description: Team Member
*/

if ( ! function_exists( 'killarwt_team_member' ) ) :

	function killarwt_team_member( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'team_style'					=> 'team-1',
			'icon_type'						=> 'icon',
			'image'							=> '',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'name'							=> '',
			'icon_items'					=> array(),
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
			'icon_hcolor'					=> '',
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
			'image_wrap_el_classes' 		=> '',
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
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-team-member-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-team-member' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-team-member fbx-soc-icons' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		$data_attr['class'][] = ( !empty( $team_style ) ) ? 'bx-' . $team_style : 'bx-team-1';
		if( $team_style == 'team-2' ) {
			$data_attr['class'][] = 'home6-team-wrapper';
		}
		
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
		
		$data_inner_attr = array();
		$data_inner_attr['class'] 			= array( 'team-member' );
		if( !empty( $link['url'] ) ) {
			$data_inner_attr['role'] 		= 'button';
			$data_inner_attr['onclick'] 	= 'window.location="'.$link['url'].'"';
		}
		
		$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_inner_attr ) . '>';
		
		// Image ---------------------------------------
		$image_html = killarwt_get_shortcodes_image_html( $atts, array( 'class' => 'team-member-photo bx-img' ) );
		
		// Icons -----------------------------------------
		$social_icon_html = killarwt_get_shortcodes_social_icon_html( $atts, $icon_items );
		
		// Title ----------------------------------------
		$title_html = killarwt_get_shortcodes_fields_html( 'title', $atts );
		
		// Name ----------------------------------------
		$name_html = killarwt_get_shortcodes_fields_html( 'name', $atts );

		// Content ----------------------------------------
		$content_html = killarwt_get_shortcodes_fields_html( 'content', $atts );
		
		$content_wrap_attr = array();
		$content_wrap_attr['class'] = array( 'bx-wrap-cont tm-meta' );
		$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
		$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
		
		if( $team_style == 'team-2' ) {
			$args['sec_content'] .= $image_html;
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
			$args['sec_content'] .= $name_html;
			$args['sec_content'] .= $title_html;
			$args['sec_content'] .= $content_html;
			$args['sec_content'] .= $social_icon_html;
			$args['sec_content'] .= '</div>';
		} else if( $team_style == 'team-3' ) {
			$args['sec_content'] .= $image_html;
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
			$args['sec_content'] .= $title_html;
			$args['sec_content'] .= $name_html;
			$args['sec_content'] .= $content_html;
			$args['sec_content'] .= $social_icon_html;
			$args['sec_content'] .= '</div>';
		} else {
			$args['sec_content'] .= $image_html;
			$args['sec_content'] .= $social_icon_html;
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
			$args['sec_content'] .= $name_html;
			$args['sec_content'] .= $title_html;
			$args['sec_content'] .= $content_html;
			$args['sec_content'] .= '</div>';
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

add_shortcode( 'killar_team_member', 'killarwt_team_member' );