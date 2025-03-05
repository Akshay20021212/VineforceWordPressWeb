<?php
/**
 * @package killarwt/Elements
 * @widget : Products
 * @version 1.0.0
 */

if ( ! function_exists( 'killarwt_product_categories' ) ) {

	function killarwt_product_categories( $atts ) {
		
		$atts = shortcode_atts(array(
			'display_type' 					=> 'shortcode',
			'title' 						=> '',
			'view_type'             		=> 'grid',
			'category_style'             	=> 'default',
			'animation'						=> '',
			'animation_durations'			=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'category_ids' 					=> '',
			'show_subcategories'         	=> '',
			'hide_empty'                 	=> '',
			'orderby' 						=> 'name',
			'order' 						=> 'ASC',
			'number' 						=> '6',
			'el_class'						=> '',
			'nums_rows'						=> '1',
			'carousel_nav'					=> '1',
			'carousel_nav_onhover'			=> '0',
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
			'items_col_xxl' 				=> '4',
			'items_col_xl' 					=> '4',
			'items_col_lg' 					=> '4',
			'items_col_md' 					=> '4',
			'items_col_sm' 					=> '3',
			'items_col_xs' 					=> '3',
			'items_col_xxs' 				=> '2',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'show_category_title' 			=> true,
			'show_category_product_count' 	=> true,
			'css' 							=> '',
		), $atts);

		//extract($atts);

		$atts['nums_rows'] = ( in_array($atts['view_type'], array('grid','micro_grid') ) ) ? 1 :  $atts['nums_rows'];
		
		$args = array();
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-product-categories-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array('killar-element', 'killar-product-categories');
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array($atts, $args['wrap_atts']);
		$args['wrap_atts'] = killarwt_get_shortcodes_common_array($atts, $args['wrap_atts']);

		// Section Heading --------------------------
		if ( !empty( $atts['title'] )  ) {
			$args['wrap_atts']['class'][] = 'sec-title';
			$args['sec_heading'] =  ($atts['title'] != '') ? '<h2 class="sec-title">' . killarwt_js_remove_wpautop($atts['title'], true) . '</h2>' : '';
		}

		// Section Content --------------------------
		wc_set_loop_prop('name', 'product-categories');

		// $loop_prop = array(
		// 	'killar_woo_loop_products_display_type' 	=> $atts['display_type'],
		// 	'killar_woo_loop_products_view_type' 	=> $atts['view_type'],
		// 	'slider_autoplay' 							=> $atts['slider_autoplay'],
		// 	'slider_loop' 								=> $atts['slider_loop'],
		// 	'slider_dots' 								=> $atts['slider_dots'],
		// 	'slider_nav'								=> $atts['slider_nav'],
		// 	'slider_nav_style'							=> $atts['slider_nav_style'],
		// 	'slider_nav_position' 						=> $atts['slider_nav_position'],
		// 	'products_col_lg' 							=> $atts['items_col_lg'],
		// 	'products_col_md' 							=> $atts['items_col_md'],
		// 	'products_col_sm' 							=> $atts['items_col_sm'],
		// 	'products_col_xs' 							=> $atts['items_col_xs'],
		// 	'products_col_xxs' 							=> $atts['items_col_xxs'],
		// 	'slider_rows' 								=> $atts['slider_rows'],
		// 	'killar_woo_loop_product_style' 			=> $atts['product_style'],
		// 	'killar_woo_loop_product_image_style' 	=> $atts['image_style'],
		// 	'killar_woo_loop_product_image_swap_style' => $atts['image_swap_style'],
		// 	'killar_woo_loop_badges_status' 			=> $atts['show_badges'],
		// 	'killar_woo_loop_prod_categories' 		=> $atts['show_categories'],
		// 	'killar_woo_loop_prod_ratings' 			=> $atts['show_ratings'],
		// 	'killar_woo_loop_prod_ratings_count' 	=> $atts['show_ratings_count'],
		// 	'killar_woo_loop_prod_description' 		=> $atts['show_description'],
		// 	'killar_woo_loop_prod_price' 			=> $atts['show_price'],
		// 	'killar_woo_loop_prod_addtocart' 		=> $atts['show_addtocart'],
		// 	'killar_woo_loop_prod_wishlist' 			=> $atts['show_wishlist'],
		// 	'killar_woo_loop_prod_compare'			=> $atts['show_compare'],
		// 	'killar_woo_loop_prod_quickview' 		=> $atts['show_quickview'],
		// );
		// killarwt_set_loop_prop($loop_prop);

		// Query.
		$query_args = array(
			'taxonomy'   => 'product_cat',
			'order'      => $atts['order'],
			'hide_empty' => 'yes' === $atts['hide_empty'],
			'include'    => $atts['category_ids'],
			'pad_counts' => true,
			'number'     => $atts['number'],
		);

		if ( !empty( $atts['orderby'] ) ) {
			$query_args['orderby'] = $atts['orderby'];
		}

		$product_categories 			= get_terms($query_args);
		$args['product_categories'] 	= $product_categories;
		$args['cat_wrap_atts'] 			= [];

		if( count( $product_categories ) > 0 ) {

			$cat_wrap_classes = array('product-categories items-cen-cont');

			$cat_wrap_classes[] = 'view-' . $atts['view_type'];
			$cat_wrap_classes[] = 'cats-' . $atts['view_type'];
			$cat_wrap_classes[] = 'cat-style-' . $atts['category_style'];

			if (in_array($atts['view_type'], array('carousel', 'micro_carousel'))) {
				$cat_wrap_classes[] = 'nav-slider-middle items-cen-cont kwt-slick-slider nav-on-hover';
			} else {

				if (in_array($atts['view_type'], array('grid'))) {
					$cat_wrap_classes[] = 'row align-items-start g-4';
				}
			}

			$args['cat_wrap_atts']['class'] = $cat_wrap_classes;
			$args['cat_wrap_atts'] += killarwt_loop_atts($atts);

			$args['cat_item_atts']  = array();
			$cat_item_classes = array('product-category product');
			if (in_array($atts['view_type'], array('grid'))) {
				$cat_item_classes[] = killarwt_cols_class('lg', $atts['items_col_xxl']);
				$cat_item_classes[] = killarwt_cols_class('lg', $atts['items_col_xl']);
				$cat_item_classes[] = killarwt_cols_class('lg', $atts['items_col_lg']);
				$cat_item_classes[] = killarwt_cols_class('md', $atts['items_col_md']);
				$cat_item_classes[] = killarwt_cols_class('sm', $atts['items_col_sm']);
				$cat_item_classes[] = killarwt_cols_class('xs', $atts['items_col_xs']);
				$cat_item_classes[] = killarwt_cols_class('xxs', $atts['items_col_xxs']);
			}
			$args['cat_item_atts']['class'] = $cat_item_classes;
		}
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/woo-product-categories', $args );
		$html = ob_get_clean();
		
		return $html;
	}
}

add_shortcode( 'killar_product_categories', 'killarwt_product_categories' );