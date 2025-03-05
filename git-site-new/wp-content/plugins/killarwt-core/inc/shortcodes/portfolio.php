<?php
/**
 * @package KillarWT/Elements
 * @widget : Portfolio
 * @version 1.0.0
 */
 
if ( ! function_exists( 'killarwt_portfolio' ) ) :

	function killarwt_portfolio( $atts ) {
				
		$atts = shortcode_atts( array(
			'display_type' 						=> 'shortcode',
			'sub_title'							=> '',
			'title'								=> '',
			'query_args'						=> array(),
			'categories'						=> '',
			'exclude_posts'						=> '',
			'orderby' 							=> 'name',
			'order' 							=> 'ASC',
			'limit'								=> '6',
			'nums_rows' 						=> '1',
			'animation'							=> '',
			'animation_durations'				=> '',
			'animation_delay'					=> '',
			'el_classes' 						=> '',
			'view_type' 						=> 'grid-light',
			'portfolio_list' 					=> array(),
			'portfolio_loop_post_style' 					=> 'default',
			'portfolio_loop_post_thumbnail' 				=> true,
			'portfolio_loop_post_image_custom_dimension' 	=> array(),
			'portfolio_loop_post_fancy_date' 				=> false,
			'portfolio_loop_post_image_size' 			 	=> 'full',
			'portfolio_loop_post_categories' 				=> true,
			'portfolio_loop_post_title' 					=> true,
			'portfolio_loop_post_content' 					=> 'excerpt',
			'portfolio_loop_post_excerpt_length' 			=> 30,
			'portfolio_loop_post_read_more' 				=> 'icon',
			'portfolio_loop_post_remove_items_padding' 		=> false,
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
			'items_col_xxl'					=> '2',
			'items_col_xl'					=> '2',
			'items_col_lg'					=> '2',
			'items_col_md'					=> '2',
			'items_col_sm'					=> '1',
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
		), $atts );
		
		extract( $atts );
			
		$atts['nums_rows'] 						= ( in_array($atts['view_type'], array('grid') ) ) ? 1 : $atts['nums_rows'];
		
		$args = array();
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-portfolio-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= ( ! empty( $wrap_id ) ) ? $wrap_id : $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element killar-portfolio portfolio-area kwt-portfolio' );
		$args['wrap_atts'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		$args['wrap_atts'] += killarwt_get_shortcodes_animations_array( $atts );
		if( $portfolio_loop_post_remove_items_padding == 'yes' ) {
			$args['wrap_atts']['class'][] = 'remove-items-padding';
		}
				
		// Args
		if ( empty( $query_args ) ) {
			$query_args = array(
				'post_type'      		=> 'portfolio',
				'post_status'        	=> array('publish'),
				'posts_per_page'    	=> $limit,
				'ignore_sticky_posts'	=> true,
				'orderby'				=> $orderby,
			);
		}
		
		// Categories
		$categories = trim($categories);
		if( !empty( $categories ) ){
			$categories_ar = explode(',', $categories);
			if( !empty( $categories_ar ) ){
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'portfolio-cat',
						'field'    => 'term_id',
						'operator' => 'IN',
						'terms'    => $categories_ar
					)
				);
			}	
		}
		
		// Include Posts
		if( !empty( $portfolio_list ) ) {
			if( !is_array( $portfolio_list ) ) {
				$portfolio_list = explode( ',', $portfolio_list );	
			}
			if ( !empty( $portfolio_list ) ) {
				$query_args['post__in'] = $portfolio_list;	
			}
		}

		// Exclude Posts
		if( !empty( $exclude_posts ) ) {
			if( !is_array( $exclude_posts ) ) {
				$exclude_posts = explode( ',', $exclude_posts );	
			}
			if ( !empty( $exclude_posts ) ) {
				$query_args['post__not_in'] = $exclude_posts;	
			}
		}
				
		// Section Heading --------------------------
		if ( !empty( $title ) ) {
			$wrap_classes[] = 'sec-title';
			$args['sec_heading'] =  ( $title != '' ) ? '<h2 class="sec-title">' . killarwt_js_remove_wpautop( $title, true ) . '</h2>' : '';
		}
		
		// Section Content --------------------------
		$args['query'] = new WP_Query( $query_args );
		
		if( in_array( $portfolio_loop_post_style, array( 'box1', 'box2' ) ) ) {
			$post_sections_positioning = array( 'thumbnail', 'categories', 'title', 'content', 'social_links', 'meta', 'read-more' );
		} else if( in_array( $portfolio_loop_post_style, array( 'box3' ) ) ) {
			$post_sections_positioning = array( 'thumbnail', 'title', 'categories', 'content', 'social_links', 'meta', 'read-more' );
		} else {
			$post_sections_positioning = array( 'thumbnail', 'categories',  'title', 'content', 'social_links', 'meta', 'read-more' );
		}
		
		$unset_sections_positioning = array('social_links');
		if ( empty( $portfolio_loop_post_thumbnail ) ) $unset_sections_positioning[] = 'thumbnail';
		if ( empty( $portfolio_loop_post_title ) ) $unset_sections_positioning[] = 'title';
		if ( empty( $portfolio_loop_post_categories ) ) $unset_sections_positioning[] = 'categories';
		if ( empty( $portfolio_loop_post_content ) ) $unset_sections_positioning[] = 'content';
		if ( empty( $portfolio_loop_post_meta ) ) $unset_sections_positioning[] = 'meta';
		if ( empty( $portfolio_loop_post_read_more ) ) $unset_sections_positioning[] = 'read-more';
				
        $post_sections_positioning = array_diff( $post_sections_positioning, $unset_sections_positioning );
		
		$item_attr_classes = array( 'port-carousel-item');
		$item_attr_classes[] = ( !in_array( $item_ver_alignment, array( '' ) ) ) ? 'align-items-' . $item_ver_alignment : '';
		$item_attr_classes[] = ( !in_array( $item_ver_alignment_tablet, array( '' ) ) ) ? 'align-items-md-' . $item_ver_alignment_tablet : '';
		$item_attr_classes[] = ( !in_array( $item_ver_alignment_mobile, array( '' ) ) ) ? 'align-items-sm-' . $item_ver_alignment_mobile : '';
		$item_attr_classes[] = ( !in_array( $item_hor_alignment, array( '' ) ) ) ? 'justify-content-' . $item_hor_alignment : '';
		$item_attr_classes[] = ( !in_array( $item_hor_alignment_tablet, array( '' ) ) ) ? 'justify-content-md-' . $item_hor_alignment_tablet : '';
		$item_attr_classes[] = ( !in_array( $item_hor_alignment_mobile, array( '' ) ) ) ? 'justify-content-sm-' . $item_hor_alignment_mobile : '';
		$item_attr_classes[] = ( ! empty( $item_el_classes ) ) ? $item_el_classes : '';
		
		$loop_prop = array (
			'killar_portfolio_loop_display_type' 			=> $display_type,
			'killar_portfolio_loop_view_type' 				=> $view_type,
			'killar_portfolio_loop_post_style' 				=> $portfolio_loop_post_style,
			'killar_portfolio_loop_post_section_show_title' => false,
			'killar_portfolio_loop_post_item_classes' 		=> killarwt_stringify_classes( $item_attr_classes ),
			'killar_portfolio_loop_post_item_classes' 		=> killarwt_stringify_classes( $item_attr_classes ),
			'killar_portfolio_loop_post_carousel_classes' 	=> $carousel_el_classes,
			'killar_portfolio_loop_carousel_nav'				=> killarwt_bool_text( (int)$carousel_nav ),
			'killar_portfolio_loop_carousel_infinite'		=> killarwt_bool_text( (int)$carousel_infinite ),
			'killar_portfolio_loop_carousel_dots' 			=> killarwt_bool_text( (int)$carousel_dots ),
			'killar_portfolio_loop_carousel_speed' 			=> $carousel_speed,
			'killar_portfolio_loop_carousel_autoplay' 		=> killarwt_bool_text( (int)$carousel_autoplay ),
			'killar_portfolio_loop_carousel_center_mode' 	=> killarwt_bool_text( (int)$carousel_center_mode ),
			'killar_portfolio_loop_carousel_variable_width' 	=> killarwt_bool_text( (int)$carousel_variable_width ),
			'killar_portfolio_loop_carousel_variable_width_tablet' 	=> killarwt_bool_text( (int)$carousel_variable_width_tablet ),
			'killar_portfolio_loop_carousel_variable_width_mobile' 	=> killarwt_bool_text( (int)$carousel_variable_width_mobile ),
			'killar_portfolio_loop_carousel_adaptive_height' => killarwt_bool_text( (int)$carousel_adaptive_height),
			'killar_portfolio_loop_items_col_xxl'				=> $items_col_xxl,
			'killar_portfolio_loop_items_col_xl'				=> $items_col_xl,
			'killar_portfolio_loop_items_col_lg'				=> $items_col_lg,
			'killar_portfolio_loop_items_col_md' 			=> $items_col_md,
			'killar_portfolio_loop_items_col_sm' 			=> $items_col_sm,
			'killar_portfolio_loop_items_col_xs' 			=> $items_col_xs,
			'killar_portfolio_loop_items_col_xxs' 			=> $items_col_xxs,
			'nums_rows' 									=> $nums_rows,
			'killar_portfolio_loop_post_sections_positioning' => $post_sections_positioning,
			'killar_portfolio_loop_post_thumbnail' => $portfolio_loop_post_thumbnail,
			'killar_portfolio_loop_post_meta' => array( 'categories' ),
		);
		
		if ( $portfolio_loop_post_thumbnail ) {
			$loop_prop['killar_portfolio_loop_post_fancy_date'] = $portfolio_loop_post_fancy_date;
			$image_size = '';
			if ( $portfolio_loop_post_image_size == 'custom' && !empty( $portfolio_loop_post_image_custom_dimension['width'] ) && !empty( $portfolio_loop_post_image_custom_dimension['height'] )  ) {
				$image_size = $portfolio_loop_post_image_custom_dimension['width'].'x'.$portfolio_loop_post_image_custom_dimension['height'];
			} else {
				$image_size = $portfolio_loop_post_image_size;
			}
			$loop_prop['killar_portfolio_loop_post_image_size'] = $image_size;
		}
		
		if ( $portfolio_loop_post_content != '' ) {
			$loop_prop['killar_portfolio_loop_post_content'] = $portfolio_loop_post_content;
			$loop_prop['killar_portfolio_loop_post_excerpt_length'] = $portfolio_loop_post_excerpt_length;
		}
		
		if ( !empty( $portfolio_loop_post_read_more ) ) {
			$loop_prop['killar_portfolio_loop_post_read_more'] = $portfolio_loop_post_read_more;
		}
		
		killarwt_set_loop_prop( $loop_prop );
				
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/portfolio', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'killar_portfolio', 'killarwt_portfolio' );