<?php
/**
 * @package KillarWT/Elements
 * @widget : Products
 * @version 1.0.0
 */
 
if ( ! function_exists( 'killarwt_blog' ) ) :

	function killarwt_blog( $atts ) {
		
		$atts = shortcode_atts(array(
			'display_type' 				=> 'shortcode',
			'query_args'				=> array(),
			'sec_title'					=> '',
			'categories'				=> '',
			'filter_categories'			=> '',
			'include_posts'				=> '',
			'exclude_posts'				=> '',
			'orderby' 					=> 'name',
			'order' 					=> 'ASC',
			'limit'						=> '6',
			'animation'					=> '',
			'animation_durations'		=> '',
			'animation_delay'			=> '',
			'el_classes' 				=> '',
			'view_type' 				=> 'grid',
			'blog_loop_post_style' 					=> 'default',
			'blog_loop_post_thumbnail' 				=> true,
			'blog_loop_post_image_size' 			=> 'medium',
			'blog_loop_post_image_custom_dimension' => array(),
			'blog_loop_post_fancy_date' 			=> false,
			'blog_loop_post_meta' 					=> array(),
			'blog_loop_post_categories' 			=> true,
			'blog_loop_post_title' 					=> true,
			'blog_loop_post_content' 				=> 'excerpt',
			'blog_loop_post_tags' 					=> false,
			'blog_loop_post_excerpt_length' 		=> 30,
			'blog_loop_post_read_more' 				=> '',
			'blog_loop_post_pagination_style' 		=> '0',
			'blog_loop_post_pagination_last_text' 	=> '',
			'blog_loop_post_load_more_button_text' 	=> '',
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
		), $atts);
	
		extract($atts);
		
		// Set Post style when view style is list etc.
		if( in_array( $view_type, array( 'list', 'full', 'full-center', 'modern' ) ) ) {
			$blog_loop_post_style = 'default';
		}
		
		$atts['rows'] 						= ( in_array($atts['view_type'], array('grid') ) ) ? 1 :  $atts['nums_rows'];
		
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-blog-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= ( ! empty( $wrap_id ) ) ? $wrap_id : $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element killar-blog kwt-blog' );
		$args['wrap_atts'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		$args['wrap_atts'] += killarwt_get_shortcodes_animations_array( $atts );
		
		// Args
		if ( empty( $query_args ) ) {
			$query_args = array(
				'post_type'          	=> 'post',
				'post_status'        	=> array('publish'),
				'posts_per_page'    	=> $atts['limit'],
				'ignore_sticky_posts'	=> true,
				'orderby'				=> $orderby,
				'order'					=> $order,
			);
		}
		
		// Categories
		$categories = ( $view_type == 'gallery-filter') ? trim( $filter_categories ) : trim( $categories );
		if( !empty( $categories ) ){
			$categories_ar = explode(',', $categories);
			if( !empty( $categories_ar ) ){
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $categories_ar
					)
				);
			}	
		}
		
		// Include Posts
		if( !empty( $include_posts ) && !in_array( 'all', $include_posts ) ) {
			if( !is_array( $include_posts ) ) {
				$include_posts = explode( ',', $include_posts );	
			}
			if ( !empty( $include_posts ) ) {
				$query_args['post__in'] = $include_posts;	
			}
		}
		
		// Exclude Posts
		if( !empty( $exclude_posts ) && in_array( 'all', $exclude_posts ) ) {
			if( !is_array( $exclude_posts ) ) {
				$exclude_posts = explode( ',', $exclude_posts );	
			}
			if ( !empty( $exclude_posts ) ) {
				$query_args['post__not_in'] = $exclude_posts;	
			}
		}
				
		// Section Heading --------------------------
		if ( $sec_title != '' ) {
			$wrap_classes[] = 'sec-title';
			$args['sec_heading'] = $sec_title;
		}
				
		// Section Content --------------------------
		$args['query'] = new WP_Query( $query_args );
		
		$post_sections_positioning = array( 'thumbnail', 'categories', 'title', 'meta', 'content', 'tags', 'read-more' );
		$post_meta_positioning = array('date');
		
		
		$unset_sections_positioning = array('social_links');
		if ( empty( $blog_loop_post_thumbnail ) ) $unset_sections_positioning[] = 'thumbnail';
		if ( empty( $blog_loop_post_categories ) ) $unset_sections_positioning[] = 'categories';
		if ( empty( $blog_loop_post_title ) ) $unset_sections_positioning[] = 'title';
		if ( empty( $blog_loop_post_meta ) ) $unset_sections_positioning[] = 'meta';
		if ( empty( $blog_loop_post_content ) ) $unset_sections_positioning[] = 'content';
		if ( empty( $blog_loop_post_tags ) ) $unset_sections_positioning[] = 'tags';
		if ( empty( $blog_loop_post_read_more ) ) $unset_sections_positioning[] = 'read-more';
        $post_sections_positioning = array_diff( $post_sections_positioning, $unset_sections_positioning );
		
		$loop_prop = array (
			'killar_blog_loop_display_type' 				=> $display_type,
			'killar_blog_loop_view_type' 				=> $view_type,
			'killar_blog_loop_post_style' 				=> $blog_loop_post_style,
			'killar_blog_loop_carousel_nav'				=> $carousel_nav,
			'killar_blog_loop_carousel_infinite' 		=> $carousel_infinite,
			'killar_blog_loop_carousel_autoplay' 		=> $carousel_autoplay,
			'killar_blog_loop_carousel_dots' 			=> $carousel_dots,
			'killar_blog_loop_items_col_xxl'				=> $items_col_xxl,
			'killar_blog_loop_items_col_xl'				=> $items_col_xl,
			'killar_blog_loop_items_col_lg'				=> $items_col_lg,
			'killar_blog_loop_items_col_md' 				=> $items_col_md,
			'killar_blog_loop_items_col_sm' 				=> $items_col_sm,
			'killar_blog_loop_items_col_xs' 				=> $items_col_xs,
			'killar_blog_loop_items_col_xxs' 			=> $items_col_xxs,
			'nums_rows' 									=> $nums_rows,
			'killar_blog_loop_post_sections_positioning' => $post_sections_positioning,
			'killar_blog_loop_post_meta' => $blog_loop_post_meta,
			'killar_blog_loop_post_pagination_style' => $blog_loop_post_pagination_style,
			'killar_blog_loop_post_pagination_last_text' => $blog_loop_post_pagination_last_text,
			'killar_blog_loop_post_load_more_button_text' => $blog_loop_post_load_more_button_text,
		);
		
		// Widget Set Meta
		if( in_array( $view_type, array( 'list' ) ) && in_array( $display_type, array( 'widget' ) )   ) {
			$loop_prop['killar_blog_loop_post_meta'] = array('date');
		}
		
		if ( $blog_loop_post_thumbnail ) {
			$loop_prop['killar_blog_loop_post_fancy_date'] = $blog_loop_post_fancy_date;
			$image_size = '';
			if ( $blog_loop_post_image_size == 'custom' && !empty( $blog_loop_post_image_custom_dimension['width'] ) && !empty( $blog_loop_post_image_custom_dimension['height'] )  ) {
				$image_size = $blog_loop_post_image_custom_dimension['width'].'x'.$blog_loop_post_image_custom_dimension['height'];
			} else {
				$image_size = $blog_loop_post_image_size;
			}
			$loop_prop['killar_blog_loop_post_image_size'] = $image_size;
		}
				
		if ( $blog_loop_post_content ) {
			$loop_prop['killar_blog_loop_post_content'] = $blog_loop_post_content;
			$loop_prop['killar_blog_loop_post_excerpt_length'] = $blog_loop_post_excerpt_length;
		}
		
		if ( !empty( $blog_loop_post_read_more ) ) {
			$loop_prop['killar_blog_loop_post_read_more'] = $blog_loop_post_read_more;
		}
		killarwt_set_loop_prop( $loop_prop );
			
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/blog', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'killar_blog', 'killarwt_blog' );