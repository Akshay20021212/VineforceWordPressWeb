<?php
/**
 * @package KillarWT/Elements
 * @shortcode : posts
 * @version 1.0.0
 */
 
if ( ! function_exists( 'killarwt_posts' ) ) :

	function killarwt_posts( $atts ) {
		$wrapperClass = $css = $el_classes = '';
		
		$atts = shortcode_atts(array(
			'display_type' 					=> 'shortcode',
			'posts_style'					=> 'style1',
			'posts_type'					=> 'post',
			'query_args'					=> array(),
			'title'							=> '',
			'categories'					=> '',
			'view_type'						=> '',
			'exclude_posts'					=> '',
			'orderby' 						=> 'name',
			'order' 						=> 'ASC',
			'limit'							=> '6',
			'nums_rows' 					=> '1',
			'animation'						=> '',
			'animation_durations'			=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'posts_thumbnail' 				=> true,
			'thumbnail_size'				=> 'custom',
			'thumbnail_custom_dimension'	=> array('90*auto'),
			'posts_date' 					=> true,
			'posts_categories' 				=> false,
			'posts_title' 					=> true,
			'posts_title_length' 			=> '',
			'posts_content' 				=> '',
			'posts_excerpt_length' 			=> 20,
			'remove_list_border'			=> false,
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
			'item_el_classes'				=> 'pb-3 mb-0',
			'image_rounded_cornors'			=> '',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'image_hover_overlay'			=> '',
			'image_el_classes' 				=> '',
			'image_wrap_el_classes' 		=> '',
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
			'content_wrap_el_classes'		=> '',
			'date_size'						=> 'h3',
			'date_font_size'				=> '',
			'date_custom_font_size'			=> '',
			'date_font_weight'				=> '',
			'date_font_style'				=> '',
			'date_text_transform'			=> '',
			'date_color'					=> '',
			'date_color_custom'				=> '',
			'date_line_height'				=> '',
			'date_letter_spacing'			=> '',
			'date_alignment'				=> '',
			'date_alignment_tablet'			=> '',
			'date_alignment_mobile'			=> '',
			'date_animation'				=> '',
			'date_animation_durations'		=> '',
			'date_animation_delay'			=> '',
			'date_el_classes'				=> 'text-sm-muted',
			'date_wrap_el_classes'			=> '',
		), $atts);
		extract($atts);
		

		$atts['nums_rows'] 						= ( in_array($atts['view_type'], array('grid') ) ) ? 1 :  $atts['nums_rows'];
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-posts-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array( 'killar-element', 'killar-posts wt-posts posts-section' );
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array( $atts, $args['wrap_atts'] );
		
		$args['wrap_atts']['class'][] = ( !empty( $remove_list_border ) ) ? 'removed-list-border' : '';
		$args['wrap_atts']['class'][] = ( ! empty( $posts_style ) ) ? 'rc-posts-'. $posts_style : '';
		
		// Args
		if ( empty( $query_args ) ) {
			$query_args = array(
				'post_type'          	=> $posts_type,
				'post_status'        	=> array('publish'),
				'posts_per_page'    	=> $limit,
				'ignore_sticky_posts'	=> true,
				'orderby'				=> $orderby,
				'order'					=> $order,
			);
		}
		
		// Categories
		$categories = trim($categories);
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
		if ( $title != '' ) {
			$wrap_classes[] = 'sec-title';
			$args['sec_heading'] =  ( $title != '' ) ? '<h2 class="sec-title">' . killarwt_js_remove_wpautop( $title, true ) . '</h2>' : '';
		}
		
		// Section Content --------------------------
		$query = new WP_Query( $query_args );
		
		// Section Content --------------------------
		
		if( !empty( $query ) ) {
			
			if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
			$data_attr['class'] = array( 'kwt-posts no-list-style' );
			$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
			$data_attr = killarwt_get_shortcodes_common_array( $atts, $data_attr );

			$args['sec_content'] .= '<ul ' . killarwt_stringify_atts( $data_attr ) . '>';
			
			while ( $query->have_posts() ) : $query->the_post();
			
				$item_attr = array();
				$item_attr['class'] = array( 'post-item d-flex flex-column flex-md-row');
				$item_attr['class'][] = ( ! empty( $item_wrap_el_classes ) ) ? $item_wrap_el_classes : '';
				$item_attr['class'][] = ( ! empty( $item_el_classes ) ) ? $item_el_classes : '';
							
				$args['sec_content'] .= '<li ' . killarwt_stringify_atts( $item_attr ) . '>';
				
				// Thumbnail -------------------------------------
				
				$show_image_flag = false;
				
				$post_image_html = '';
				if( has_post_thumbnail() && !empty( $posts_thumbnail ) ) {
					
					// Image ---------------------------------------
					$atts['image'] = array( 'id' => get_post_thumbnail_id() );
					$post_image_html = killarwt_get_shortcodes_image_html( $atts, array(), array( 'no_wrap' => true, 'class' => array( 'img-fluid post-image mb-3 mb-md-0' ) ) );
				}
				
				// Title ----------------------------------------
				$post_title_html = '';
				if( !empty( $posts_title ) ) {
					$posts_title_text = ( ( !empty( $posts_title_length ) ) ? killarwt_content_limit( get_the_title(), $posts_title_length ) : get_the_title() );
					if( !empty( $posts_title_text ) ) {
						$atts['title'] = $posts_title_text;
						$title_html = killarwt_get_shortcodes_fields_html( 'title', $atts, array(), array( 'class' => 'post-title color-inherit' ) );
						$post_title_html .= sprintf( '<a href="%s" rel="post">%s</a>', esc_url( get_permalink() ), $title_html );
					}
				}
				
				// Content ----------------------------------------
				$post_content_html = '';
				if( !empty( $posts_content ) ) {
					
					if ( has_excerpt() && ! empty( $post->post_excerpt ) ) {
						$content = get_the_excerpt();
					} else {
						$content = get_the_content();
					}
					$content = killarwt_content_limit( $content, $posts_excerpt_length );
					if( !empty( $content ) ) {
						
						if( in_array( $content_size, array( 'p' ) ) ) {
							$atts['content_size'] = 'div';
						}
						
						$atts['content'] = $content;
						$post_content_html .= killarwt_get_shortcodes_fields_html( 'content', $atts, array(), array( 'class' => 'post-content mb-2' ) );
					}
				}
				
				// Date ----------------------------------------
				$post_date_html = '';
				if( !empty( $posts_date ) ) {
					$atts['date'] = get_the_date('M d, Y');
					$post_date_html = killarwt_get_shortcodes_fields_html( 'date', array_merge( $atts, array( 'date_size' => 'span' ) ), array(), array( 'class' => 'post-list-date mb-2' ) );
				}
				
				// Categories -----------------------------------------
				
				$post_categories_html = '';
				if( !empty( $posts_categories ) ) {
					
					$categories_list = get_the_category_list( esc_html__( ', ', 'killarwt-core' ) );
					if( !empty( $categories_list ) ) {
						$post_categories_html .= '<span class="meta-cats mb-2">' . $categories_list . '</span>';
					}
				}
				
				$content_wrap_attr = array();
				$content_wrap_attr['class'] = array( 'bx-wrap-cont post-summary rbm-text ps-md-3 ps-0' );
				$content_wrap_attr['class'][] = ( !empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
				$content_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'content_wrap_hor', $atts, 'hor' );
				
				if( $posts_style == 'style2' ) {
					$args['sec_content'] .= $post_image_html;
					$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
					$args['sec_content'] .= $post_date_html;
					$args['sec_content'] .= $post_title_html;
					$args['sec_content'] .= $post_content_html;
					$args['sec_content'] .= $post_categories_html;
					$args['sec_content'] .= '</div>';
				} else {
					$args['sec_content'] .= $post_image_html;
					$args['sec_content'] .= '<div ' . killarwt_stringify_atts( $content_wrap_attr ) . '>';
					$args['sec_content'] .= $post_title_html;
					$args['sec_content'] .= $post_content_html;
					$args['sec_content'] .= $post_date_html;
					$args['sec_content'] .= $post_categories_html;
					$args['sec_content'] .= '</div>';
				}
				
				$args['sec_content'] .= '</li>';
				
			endwhile;
			
			wp_reset_postdata();
			
			$args['sec_content'] .= '</ul>';
		}
				
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/common', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'killar_posts', 'killarwt_posts' );