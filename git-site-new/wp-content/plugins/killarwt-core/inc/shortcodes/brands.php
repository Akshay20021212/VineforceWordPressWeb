<?php
/*
Element Description: Brands
*/

if ( ! function_exists( 'killarwt_brands' ) ) :

	function killarwt_brands( $atts, $content = null  ) {

		global $killar_woocommerce_atts;

		$products_types = $category_default = $killar_woocommerce_atts = array();

		$wrapperClass = $css = $el_class = $cpt_error_msg = '';

		$products_types = array(
			esc_html__( 'Recent', 'killarwt-core' ) => 'recent_products',
			esc_html__( 'Featured', 'killarwt-core' ) => 'featured_products',
			esc_html__( 'Sale', 'killarwt-core' ) => 'sale_products',
			esc_html__( 'Best Selling', 'killarwt-core' ) => 'best_selling_products',
			esc_html__( 'Top Reviews', 'killarwt-core' ) => 'top_rated_products',
		);

		$category_default = array('label' => esc_html__( 'Select Category', 'killarwt-core' ), 'value' => '' );

		$atts = shortcode_atts(array(
			'display_type' => 'shortcode',
			'title'	  => '',
			'brands'  => '',
			'limit'  => '8',
			'orderby' => 'name',
			'order'   => 'ASC',
			'hide_empty' => false,
			'rows' => '1',
			'display_brand_title' => false,
			'el_class' => '',
			'view_type' => 'slider',
			'slider_autoplay' => '',
			'slider_loop' => '',
			'slider_nav' => 'yes',
			'slider_nav_style' => '',
			'slider_nav_position' => 'slider-middle',
			'slider_dots' => '',
			'items_col_xl' => '8',
			'items_col_lg' => '6',
			'items_col_md' => '4',
			'items_col_sm' => '4',
			'items_col_xs' => '3',
			'items_col_xxs' => '2',
			'css'		=> '',
			'show_child_of' => 0,
		), $atts);

		extract($atts);


		$query_args = array(
			'taxonomy'  	=> 'product_brand',
			'number'    	=> $atts['limit'],
			'orderby'    	=> $atts['orderby'],
			'order'      	=> $atts['order'],
			'hide_empty' 	=> $atts['hide_empty'],
		);		
		
		$ids = array();
		if ( !empty( $atts['brands'] ) ) {
			$ids = explode( ',', $atts[ 'brands' ] );
			$ids = array_map( 'trim', $ids );			
			$query_args['include'] = $ids;			
		} 
		
		$product_brands = get_terms( $query_args );		

		$killar_woocommerce_atts = $atts;
		
		$args = $wrap_classes = array();
		$css_output = '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-product-brands-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_heading'] 	    = '';
		$args['sec_content'] 	    = '';

		$wrap_classes[] = 'killar-element killar-product-brands';
		$wrap_classes[] = $el_class;
		$wrap_classes[] = killarwt_vc_shortcode_custom_css_class( $css, ' ' );
		$nav_classes 	= killarwt_get_nav_classes( $atts );
		if( !empty( $nav_classes ) ) {
			$wrap_classes = array_merge( $wrap_classes, $nav_classes );
		}

		if ( $product_brands ) {
			$args['product_brands']	= $product_brands;
		}

		//Section Heading --------------------------
		if ( $title != '' ) {
			$wrap_classes[] = 'title-with-prds';
			$args['sec_heading'] .=  ( $title != '' ) ? '<h2 class="sec-title">' . killarwt_js_remove_wpautop( $title, true ) . '</h2>' : '';
		}
		
		//Section Content --------------------------
		if ( !empty( $product_brands ) ) {
			$classes = array( 'products', 'products-wrap', 'products-container' );
			$brand_item_classes = array( 'brand-item' );			
			$wrap_attr = array();
			
			if ( in_array( $view_type, array('slider', 'micro_slider' ) ) ) {
				
				$classes[] = 'brand-carousel wt-owl-slider owl-carousel nav-on-hover';
				
				if ( in_array($view_type, array('micro_slider') ) ) {
					$classes[] = 'micro-brands';
				}
				
			} else {
				
				$classes[] = 'grid-view';
				$classes[] = 'row';
								
				$brand_item_classes[] = killarwt_cols_class( 'lg', $items_col_lg );
				$brand_item_classes[] = killarwt_cols_class( 'md', $items_col_md );
				$brand_item_classes[] = killarwt_cols_class( 'sm', $items_col_sm );
				$brand_item_classes[] = killarwt_cols_class( 'xs', $items_col_xs );
				$brand_item_classes[] = killarwt_cols_class( 'xxs', $items_col_xxs );
			}
			
			$wrap_attr['class'] = killarwt_stringify_classes( $classes );
			
			$data_atts = array(
				'view_type'			=> $view_type,
				'slider_nav'		=> $slider_nav,
				'slider_loop'		=> $slider_loop,
				'slider_autoplay' 	=> $slider_autoplay,
				'slider_dots' 		=> $slider_dots,
				'items_col_lg' 		=> $items_col_lg,
				'items_col_md' 		=> $items_col_md,
				'items_col_sm' 		=> $items_col_sm,
				'items_col_xs' 		=> $items_col_xs,
				'items_col_xxs' 	=> $items_col_xxs,
			);
		
			$wrap_attr = array_merge( $wrap_attr, killarwt_loop_atts( $data_atts ) );
						
			$args['sec_content'] .= '<div '.killarwt_stringify_atts( $wrap_attr ).'>';
			
			$i = 0;
			$total_count = count($product_brands);
			//print_r($product_brands);exit;
			foreach ( $product_brands as $bk => $brand ) {

				$image = $brand_link = '';
				$size = 'full';
				$thumbnail_id = absint( get_term_meta( $brand->term_id, 'thumbnail_id', true ) );
				$brand_link = get_term_link( $brand ); 
				$brand_title = $brand->name;
				if ( $thumbnail_id ) {
					$image = killarwt_get_image_html( array('attach_id' => $thumbnail_id, 'size' => 'full', 'alt' => $brand_title, 'title' => $brand_title ) );
					if ( empty ( $image ) ) {
						$image = killarwt_placeholder_img_src();
					}
				}

				if ( $image ) {
										
					$args['sec_content'] .= ( $atts['rows'] > 1 && ( $i % $atts['rows'] == 0 ) ) ? '<div class="brands">' : '';
					$args['sec_content'] .= '<div class="' . killarwt_stringify_classes( $brand_item_classes ) . '">';
					$args['sec_content'] .= '<a href="' . esc_url( $brand_link ) . '">';
					$args['sec_content'] .= $image;
					$args['sec_content'] .= ( $atts['display_brand_title'] == true && !empty( $brand_title ) ) ? '<h4 class="brand-title">' . esc_html__( $brand_title, 'killarwt' ) . '</h4>' : '';
					$args['sec_content'] .= '</a>';
					$args['sec_content'] .= '</div>';
					$args['sec_content'] .= ( $atts['rows'] > 1 && ( ( $i % $atts['rows'] == ( $atts['rows']-1 ) ) || ( $i == ( $total_count -1 ) ) ) ) ? '</div>' : '';

					$i++;
				}

			}
			
			$args['sec_content'] .= '</div>';
		}
		
		if ( ! empty( $args['id'] ) ) {
			$args['wrap_atts']['id'] = $args['id'];
		}
		
		$wrap_classes = array_filter($wrap_classes);
		if ( ! empty( $wrap_classes ) ) {
			$args['wrap_atts']['class'] = killarwt_stringify_classes( $wrap_classes );
		}

		if ( ! empty( $args['wrap_style_css'] ) ) {
			$args['wrap_atts']['style'] = killarwt_stringify_classes( $args['wrap_style_css'] );
			unset($args['wrap_style_css']);
		}

		//Output Css
		if ( ! empty( $css_output ) ) {
			killarwt_exts_css_output( $css_output );
		}

		//print_r($args);
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/brands', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'killar_brands', 'killarwt_brands' );