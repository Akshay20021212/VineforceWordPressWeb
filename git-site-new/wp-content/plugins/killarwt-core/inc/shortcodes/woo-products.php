<?php
/**
 * @package killarwt/Elements
 * @widget : Products
 * @version 1.0.0
 */

if ( ! function_exists( 'killarwt_products' ) ) {

	function killarwt_products( $atts ) {

		$atts = shortcode_atts(array(
			'display_type' 					=> 'shortcode',
			'title' 						=> '',
			'post_type'                    	=> 'product',
			'view_type'               		=> 'grid',
			'product_style' 				=> '',
			'show_title' 					=> true,
			'show_image' 					=> true,
			'image_style' 					=> 'default',
			'image_swap_style' 				=> 'fade',
			'show_badges' 					=> true,
			'show_categories' 				=> true,
			'show_ratings' 					=> true,
			'show_ratings_count'			=> true,
			'show_price' 					=> true,
			'show_short_description' 		=> false,
			'show_quickview' 				=> true,
			'show_addtocart' 				=> true,
			'show_meta' 					=> true,
			'show_sharing' 					=> true,
			'show_product_link' 			=> false,
			'show_wishlist' 				=> true,
			'show_compare' 					=> true,
			'animation'						=> '',
			'animation_durations'			=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'data_source' 					=> '',
			'include' 						=> '',
			'categories' 					=> '',
			'tags' 							=> '',
			'exclude' 						=> '',
			'orderby' 						=> 'name',
			'order' 						=> 'ASC',
			'limit' 						=> '6',
			'el_class'						=> '',
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
			'items_col_xxl' 				=> '4',
			'items_col_xl' 					=> '4',
			'items_col_lg' 					=> '4',
			'items_col_md' 					=> '4',
			'items_col_sm' 					=> '3',
			'items_col_xs' 					=> '3',
			'items_col_xxs' 				=> '2',
			'css' 							=> '',
		), $atts);

		//extract($atts);

		$atts['nums_rows'] = ( in_array($atts['view_type'], array('grid','micro_grid') ) ) ? 1 :  $atts['nums_rows'];
		
		$args = array();

		$args						= $atts;
		$args['id']  				= killarwt_uniqid('killar-products-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		$args['wrap_atts']['id'] 		= $args['id'];
		$args['wrap_atts']['class'] 	= array('killar-element', 'killar-products');
		$args['wrap_atts'] = killarwt_get_shortcodes_wrap_common_array($atts, $args['wrap_atts']);
		$args['wrap_atts'] = killarwt_get_shortcodes_common_array($atts, $args['wrap_atts']);

		// Section Heading --------------------------
		if (!empty($atts['title'])) {
			$args['wrap_atts']['class'][] = 'sec-title';
			$args['sec_heading'] =  ($atts['title'] != '') ? '<h2 class="sec-title">' . killarwt_js_remove_wpautop($atts['title'], true) . '</h2>' : '';
		}

		// Section Content --------------------------
		wc_set_loop_prop('name', 'products');
		
		$args['query'] = new WP_Query( killarwt_products_query( $atts ) );
		
		$loop_prop = array (
			'killar_woo_loop_products_display_type' 	=> $atts['display_type'],
			'killar_woo_loop_products_view_type' 		=> $atts['view_type'],
			'nums_rows' 								=> $atts['nums_rows'],
			'carousel_nav' 								=> $atts['carousel_nav'],
			'carousel_infinite' 						=> $atts['carousel_infinite'],
			'carousel_dots' 							=> $atts['carousel_dots'],
			'carousel_speed' 							=> $atts['carousel_speed'],
			'carousel_autoplay' 						=> $atts['carousel_autoplay'],
			'carousel_autoplay_speed' 					=> $atts['carousel_autoplay_speed'],
			'carousel_center_mode' 						=> $atts['carousel_center_mode'],
			'carousel_variable_width' 					=> $atts['carousel_variable_width'],
			'carousel_adaptive_height' 					=> $atts['carousel_adaptive_height'],
			'carousel_el_classes' 						=> $atts['carousel_el_classes'],
			'items_col_xxl'								=> $atts['items_col_xxl'],
			'items_col_xl'								=> $atts['items_col_xl'],
			'items_col_lg'								=> $atts['items_col_lg'],
			'items_col_md'								=> $atts['items_col_md'],
			'items_col_sm'								=> $atts['items_col_sm'],
			'items_col_xs'								=> $atts['items_col_xs'],
			'items_col_xxs'								=> $atts['items_col_xxs'],
			'killar_woo_loop_product_style' 			=> $atts['product_style'],
			'killar_woo_loop_product_image_style' 		=> $atts['image_style'],
			'killar_woo_loop_product_image_swap_style' 	=> $atts['image_swap_style'],
			'killar_woo_loop_badges_status' 			=> $atts['show_badges'],
			'killar_woo_loop_prod_categories' 			=> $atts['show_categories'],
			'killar_woo_loop_prod_ratings' 				=> $atts['show_ratings'],
			'killar_woo_loop_prod_ratings_count' 		=> $atts['show_ratings_count'],
			'killar_woo_loop_prod_description' 			=> $atts['show_short_description'],
			'killar_woo_loop_prod_price' 				=> $atts['show_price'],
			'killar_woo_loop_prod_addtocart' 			=> $atts['show_addtocart'],
			'killar_woo_loop_prod_wishlist' 			=> $atts['show_wishlist'],
			'killar_woo_loop_prod_compare'				=> $atts['show_compare'],
			'killar_woo_loop_prod_quickview' 			=> $atts['show_quickview'],
		);

		killarwt_set_loop_prop( $loop_prop );
		
		$html = '';
		ob_start();
		killarwt_exts_get_template( 'shortcodes/woo-products', $args );
		$html = ob_get_clean();
		
		return $html;
	}
}

add_shortcode( 'killar_products', 'killarwt_products' );