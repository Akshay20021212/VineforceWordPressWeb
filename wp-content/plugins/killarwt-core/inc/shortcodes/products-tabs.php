<?php
/**
 * @package KillarWT/Elements
 * @widget : Products Tab
 * @version 1.0.0
 */

if (!function_exists('killarwt_products_tabs')){

    function killarwt_products_tabs($atts, $content = null)
	{
		
		$data_sources_ar = array(
			esc_html__( 'All Products', 'killarwt-core' ) => 'all_products',
			esc_html__( 'Recent', 'killarwt-core' ) => 'recent_products',
			esc_html__( 'Featured', 'killarwt-core' ) => 'featured_products',
			esc_html__( 'Sale', 'killarwt-core' ) => 'sale_products',
			esc_html__( 'New', 'killarwt-core' ) => 'new_products',
			esc_html__( 'Best Selling', 'killarwt-core' ) => 'best_selling_products',
			esc_html__( 'Top Rated', 'killarwt-core' ) => 'top_rated_products',
			esc_html__( 'List of Products', 'killarwt-core' ) => 'products_ids',
		);

        $css = $el_class = $cpt_error_msg = '';

        $atts = shortcode_atts(array(
            'display_type' => 'shortcode',
			'title' => '',
            'tab_type' => 'data_sources',
            'categories' => '',
            'data_sources' => 'products_all',
			'products_ids' => '',
			'exclude' => '',
			'orderby' => 'name',
			'order' => 'ASC',
			'limit' => '6',
			'el_class' => '',
			'display_tab_align' => 'right',
			'view_type' => 'slider',
			'rows' => '1',
			'slider_autoplay' => false,
			'slider_loop' => false,
			'slider_nav' => true,
			'slider_nav_style' => 'cir',
			'slider_nav_position' => 'slider-middle',
			'slider_dots' => false,
			'products_col_lg' => '4',
			'products_col_md' => '4',
			'products_col_sm' => '3',
			'products_col_xs' => '3',
			'products_col_xxs' => '2',
			'killar_woo_loop_product_style' => 'mprod-s1',
			'killar_woo_loop_product_image_style' => 'default',
			'killar_woo_loop_product_image_swap_style' => 'fade',
			'killar_woo_loop_badges_status' => true,
			'killar_woo_loop_prod_categories' => true,
			'killar_woo_loop_prod_ratings' => true,
			'killar_woo_loop_prod_ratings_count' => true,
			'killar_woo_loop_prod_description' => false,
			'killar_woo_loop_prod_price' => true,
			'killar_woo_loop_prod_addtocart' => true,
			'killar_woo_loop_prod_wishlist' => true,
			'killar_woo_loop_prod_compare' => true,
			'killar_woo_loop_prod_quickview' => true,
            'css' => '',
        ), $atts);

        extract($atts);

        $atts['categories'] = ($atts['categories'] == $category_default['label']) ? '' : $atts['categories'];
        $atts['rows'] = (in_array($atts['view_type'], array('grid', 'micro_grid'))) ? 1 : $atts['rows'];
	
		$args = $wrap_classes = array();

		$css_output 				= '';
		$args						= $atts;
		$args['id']  				= killarwt_uniqid('product-tab-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_heading'] 	    = '';
		$args['sec_content'] 	    = '';

		$wrap_classes[] = 'killar-element';
		$wrap_classes[] = 'killar-cat-prods-tab';
		$wrap_classes[] = 'wt-nav-tabs';
		$wrap_classes[] = 'killar-products';
		$wrap_classes[] = $el_class;
		$wrap_classes[] = ($tab_type) ? str_replace('_', '-', $tab_type) : '';
		$wrap_classes[] = killarwt_vc_shortcode_custom_css_class( $css, ' ' );
		$nav_classes 	= killarwt_get_nav_classes( $atts );
		if( !empty( $nav_classes ) ) {
			$wrap_classes = array_merge( $wrap_classes, $nav_classes );
		}
		// Products Type or Category
		$products_data_ar = array();
		if ( in_array( $atts['tab_type'] , array( 'data_sources' ) ) ) {
			if ( !empty( $atts['data_sources'] ) ) {
				$data_sources_exp = explode(',', $atts['data_sources']);
				if ( !empty( $data_sources_exp ) ) {
					foreach ( $data_sources_exp as $tk => $tv) {
                        $products_data_ar[$tv] = array_search($tv, $data_sources_ar);
					}
				}
			}
				
			$cpt_error_msg = ( empty( $products_data_ar ) ) ? esc_html__( 'There are not selected data source', 'killarwt-core' ) : '';
			
		} else if ( in_array( $atts['tab_type'] , array( 'sub_categories' ) ) ) {
			$products_data_ar = killarwt_woo_subcats_from_parentcat_by_name( $atts['categories'] );
			$cpt_error_msg = ( empty( $products_data_ar ) ) ? esc_html__( 'There are no sub categories in this categores', 'killarwt-core' ) : '';
		}

		//Section Heading --------------------------
		if ( !empty( $title ) ) {
			$wrap_classes[] = 'tab-title-cat-prds';
			$args['sec_heading'] .= ($title != '') ? '<h2 class="sec-title">' . killarwt_js_remove_wpautop($title, true) . '</h2>' : '';
		} else {
			$wrap_classes[] = 'tab-cat-prds';
		}

		if ( !empty( $slider_nav_position ) ) {
			$wrap_classes[] = 'nav-' . $slider_nav_position;
		}

		if ( !empty( $products_data_ar ) ) {
			$tab_div_classes = array( 'nav-tabs-wrap' );
			if (!empty($display_tab_align)) {
				$tab_div_classes[] = 'tab-align-' . $display_tab_align;
			}
			$tab_ul_classes = array('nav nav-tabs');

			$args['sec_heading'] .= '<div class = "' . killarwt_stringify_classes( $tab_div_classes ) . '">';
			$args['sec_heading'] .= '<ul class="' . killarwt_stringify_classes( $tab_ul_classes ) . '">';
			$i = 0;
			foreach ( $products_data_ar as $type_key => $type_name ) {
				$type_key = ( is_array( $type_name ) ) ? $type_name['slug'] : $type_key;
				$type_name = ( is_array( $type_name ) ) ? $type_name['name'] : $type_name;
				$args['sec_heading'] .= ( $type_name != '' ) ? '<li class="' . ( ($i == 0) ? 'active' : '' ) . '"><a href="#' . $type_key . '_' . $args['id'] . $i . '" data-toggle="tab" class="' . (( $i == 0 ) ? 'active' : '') . '">' . $type_name . '</a></li>' : '';
				$i++;
			}
			$args['sec_heading'] .= '</ul>';
			$args['sec_heading'] .= '</div>';
		}

		//Section Content --------------------------
		if ( !empty( $products_data_ar ) ) {
			$atts['title'] = '';
			$i = 0;
			foreach ( $products_data_ar as $type_key => $type_name ) {
				
				switch ( $atts['tab_type']  ) {
					case 'data_sources' :
						$atts['data_source'] = $type_key;
						$atts['categories'] = '';
						break;
					case 'sub_categories' :
						$atts['data_source'] = '';
						$atts['categories'] = $type_key;
						break;
				}
				
				$products_content = killarwt_products( $atts );
				$type_key = ( is_array( $type_name ) ) ? $type_name['slug'] : $type_key;
				$type_name = ( is_array( $type_name ) ) ? $type_name['name'] : $type_name;
				if ( !empty( $products_content ) ) {
					$args['sec_content'] .= '<div class="tab-pane ' . (($i == 0) ? 'active' : '') . '" id="' . $type_key . '_' . $args['id'] . $i . '">';
					$args['sec_content'] .= '<div class="prods-tab-cont">';
					$args['sec_content'] .= $products_content;
					$args['sec_content'] .= '</div>';
					$args['sec_content'] .= '</div>';
				}
				$i++;
			}
		} else {
			$args['sec_content'] = '<div class="alert alert-danger alert-dismissable">' . $cpt_error_msg . '</div>';
		}

		if (!empty($args['id'])) {
			$args['wrap_atts']['id'] = $args['id'];
		}

		$wrap_classes = array_filter($wrap_classes);
		if (!empty($wrap_classes)) {
			$args['wrap_atts']['class'] = killarwt_stringify_classes($wrap_classes);
		}

		if (!empty($args['wrap_style_css'])) {
			$args['wrap_atts']['style'] = killarwt_stringify_classes($args['wrap_style_css']);
			unset($args['wrap_style_css']);
		}

		//Output Css
		if (!empty($css_output)) {
			killarwt_exts_css_output($css_output);
		}

		$html = '';
		ob_start();
		killarwt_exts_get_template('shortcodes/products-tabs', $args);
		$html = ob_get_clean();

		return $html;
	}
}

add_shortcode('killar_products_tabs', 'killarwt_products_tabs');
