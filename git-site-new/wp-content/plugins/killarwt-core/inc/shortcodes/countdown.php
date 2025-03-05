<?php
/*
Element Description: Countdown
*/
if ( ! function_exists( 'killarwt_countdown' ) ) :

	function killarwt_countdown( $atts = array() ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'icon_type'						=> 'html',
			'icon_html'						=> '',
			'launch_date'					=> '',
			'days_text'						=> 'DAYS',
			'hours_text'					=> 'HRS',
			'mins_text'						=> 'MIN',
			'secs_text'						=> 'SEC',
			'show_counter_devider'			=> '1',
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
			'counter_wrap_ver_alignment'			=> '',
			'counter_wrap_ver_alignment_tablet'		=> '',
			'counter_wrap_ver_alignment_mobile'		=> '',
			'counter_wrap_hor_alignment'			=> '',
			'counter_wrap_hor_alignment_tablet'		=> '',
			'counter_wrap_hor_alignment_mobile'		=> '',
			'counter_wrap_alignment'		=> '',
			'counter_wrap_alignment_tablet'	=> '',
			'counter_wrap_alignment_mobile'	=> '',
			'counter_el_classes'			=> '',
			'counter_wrap_el_classes'		=> '',
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
			'devider_size'					=> '1px',
			'devider_style'					=> 'solid',
			'number_size'					=> 'h5',
			'number_font_size'				=> '',
			'number_custom_font_size'		=> '',
			'number_font_weight'				=> '',
			'number_font_style'				=> '',
			'number_text_transform'			=> '',
			'number_color'					=> 'default',
			'number_color_custom'			=> '',
			'number_line_height'				=> '',
			'number_letter_spacing'			=> '',
			'number_alignment'				=> 'left',
			'number_alignment_tablet'		=> '',
			'number_alignment_mobile'		=> '',
			'number_el_classes'				=> '',
			'title_size'					=> 'h5',
			'title_font_size'				=> '',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> 'default',
			'title_color_custom'			=> '',
			'title_line_height'				=> '',
			'title_letter_spacing'			=> '',
			'title_alignment'				=> 'left',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'title_el_classes'				=> '',
			'shortcode_from'				=> 'shortcode'
		), $atts);
				
		extract($atts);
		
		// Custom Settings
		$atts['icon_wrap_el_classes'] .= 'col bx-wrap-cbox';
		$atts['icon_el_classes'] .= 'bx-cbox';
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-countdown-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-countdown d-flex' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'kwt-countdown clock-wrap' );
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );
		
		$data_attr['class'][] = ( ! empty( $show_counter_devider ) ) ? 'cbox-devider' : '';
		
		if( !empty( $launch_date ) ) {
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $data_attr ) . '>';
			
			$counter_wrap_attr = array();
			$counter_wrap_attr['id'] = 'bx-cbox';
			$counter_wrap_attr['class'] = array( 'bx-main-cbox row g-xl-2 g-lg-1 g-1' );
			$counter_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'counter_wrap_hor', $atts, 'hor' );
			$counter_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'counter_wrap_ver', $atts, 'ver' );
			$counter_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'counter_wrap', $atts, 'text' );
			
			$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $counter_wrap_attr ) . '>';
			
			$countdowns = array( 
				'days' => array( 'number' => '%D', 'text' => $days_text ),
				'hours' => array( 'number' => '%H', 'text' => $hours_text ), 
				'mins' => array( 'number' => '%M', 'text' => $mins_text ), 
				'secs' => array( 'number' => '%S', 'text' => $secs_text ), 
			);
			
			$countdown_html = '';
			foreach( $countdowns as $k => $countdown  ) {
				
				
				$countdown_cont = '';
				
				// Number ----------------------------------------
				$atts['number'] = $countdown['number'];
				$countdown_cont .= killarwt_get_shortcodes_fields_html( 'number', $atts );
				
				// Title ----------------------------------------
				$atts['title'] = $countdown['text'];
				$countdown_cont .= killarwt_get_shortcodes_fields_html( 'title', $atts );
				
				if( !empty( $countdown_cont ) ) {
					$atts['icon_html'] = $countdown_cont;
				}
				
				$countdown_html .= killarwt_get_shortcodes_icon_html( $atts );
			}
			
			if( !empty( $launch_date ) && !empty( $countdown_html ) ) {
				$args['sec_content'] .= "<script>
				jQuery(document).ready(function() {
					jQuery('#" . $args['id'] . " #bx-cbox').countdown('". $launch_date ."', function(event) {
					jQuery(this).html( event.strftime('".$countdown_html."'));
					});
				});
				</script>";
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

add_shortcode( 'killar_countdown', 'killarwt_countdown' );