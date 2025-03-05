<?php
/*
Element Description: Scene Animation
*/

if ( ! function_exists( 'killarwt_scene_animation' ) ) :

	function killarwt_scene_animation( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'items'							=> array(),
			'thumbnail_size'				=> 'large',
			'thumbnail_custom_dimension'	=> array(),
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
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-scene-animation-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-scene-animation' );
		$args['wrap_atts']['class'][] = ( !empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
				
		// Section Content -----------------------------------------------------------------------------------------------
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 	= ( ! empty( $el_classes ) ) ? array( $el_classes ) : array( 'position-absolute w-100 h-100' );
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
	
			foreach( $items as $k => $item ) {
				
				// Image ---------------------------------------
				$args['sec_content'] .= killarwt_get_shortcodes_image_html( $atts, $item, array( 'no_wrap' => true, 'data-depth' => '0.20' ) );
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

add_shortcode( 'killar_scene_animation', 'killarwt_scene_animation' );