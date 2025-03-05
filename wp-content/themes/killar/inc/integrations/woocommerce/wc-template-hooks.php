<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !function_exists('killarwt_woocommerce_init_hooks') ) {
	function killarwt_woocommerce_init_hooks() {

		$loop_prod_style = killarwt_woo_loop_product_style();
		
		add_action( 'wp_enqueue_scripts', 'killarwt_woo_loop_theme_js' );

		/*Header*/
		add_action( 'killar_header_right_sidebar_list_before', 'killarwt_header_search_icon' );
		//add_action( 'killar_header_right_sidebar_list_after', 'header_right_sidebar_cart_icon' );

		/*Breadcrumb*/
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		/*Sidebar*/
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		add_filter( 'killar_get_sidebar', 'killarwt_woo_sidebar' );

		/*Filters*/
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );

		add_filter( 'woocommerce_product_get_rating_html', 'rating_markup', 10, 3 );
		add_filter( 'killar_theme_js_localize', 'woo_theme_js_localize' );

		/*Layout*/
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', 'killarwt_start_wrapper', 10 );
		add_action( 'woocommerce_after_main_content', 'killarwt_end_wrapper', 10 );

		/**
		 * Products Loop.
		 *
		 * @see woocommerce_result_count()
		 * @see woocommerce_catalog_ordering()
		 */
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		add_filter( 'woocommerce_post_class', 'killarwt_woo_post_class' );
		add_action( 'woocommerce_before_shop_loop', 'killarwt_woocommerce_before_shop_loop', 20 );
		add_action( 'killar_woocommerce_shop_loop_header_left', 'woocommerce_result_count', 20 );
		add_action( 'killar_woocommerce_shop_loop_header_right', 'woocommerce_catalog_ordering', 10 );


		add_action( 'woocommerce_before_shop_loop_item', 'killarwt_woo_loop_product_image_thumbnail', 5 );
		add_action( 'killar_after_loop_product_image', 'killarwt_woo_after_loop_product_image', 5 );
		add_action( 'killar_loop_product_image_badge', 'killarwt_woo_loop_product_image_badge', 5 );
		add_action( 'killar_loop_product_image_actions', 'killarwt_woo_loop_product_actions', 5 );
		add_action( 'killar_loop_product_image_actions', 'killarwt_woo_loop_product_image_actions', 10 );
		add_action( 'woocommerce_after_shop_loop_item', 'killarwt_woo_loop_product_content', 5 );
		add_action( 'killar_loop_product_content_categories', 'killarwt_woo_loop_product_content_categories', 5 );
		add_action( 'killar_loop_product_content_title', 'killarwt_woo_loop_product_content_title', 10 );
		add_action( 'killar_loop_product_content_rating', 'killarwt_woo_loop_product_content_rating', 10 );
		add_action( 'killar_loop_product_content_description', 'killarwt_woo_loop_product_content_description', 10 );
		add_action( 'killar_loop_product_content_price', 'killarwt_woo_loop_product_content_price', 10 );
		add_action( 'killar_loop_product_content_price_content', 'woocommerce_template_loop_price', 10 );
		add_action( 'killar_loop_product_content_actions', 'killarwt_woo_loop_product_actions', 5 );
		add_action( 'killar_loop_product_content_actions', 'killarwt_woo_loop_product_content_actions', 10 );
		add_action( 'killar_product_content_actions_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );
		add_action( 'wp_ajax_killar_product_quickview', 'killarwt_woo_loop_product_quickview' );
		add_action( 'wp_ajax_nopriv_killar_product_quickview', 'killarwt_woo_loop_product_quickview' );

		/* Pagination after shop loops */
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
		add_action( 'woocommerce_after_shop_loop', 'killarwt_woo_pagination', 10  );

		add_action( 'woocommerce_before_customer_login_form', 'killarwt_woocommerce_before_customer_myaccount_form' );
		add_action( 'woocommerce_before_lost_password_form', 'killarwt_woocommerce_before_customer_myaccount_form' );
		add_action( 'woocommerce_after_customer_login_form', 'killarwt_woocommerce_after_customer_myaccount_form' );
		add_action( 'woocommerce_after_lost_password_form', 'killarwt_woocommerce_after_customer_myaccount_form' );
		add_action( 'woocommerce_before_account_navigation', 'killarwt_before_account_navigation' );
		add_action( 'woocommerce_after_account_navigation', 'killarwt_after_account_navigation' );

		/* Pagination after shop loops */
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
		add_action( 'woocommerce_after_shop_loop', 'killarwt_woo_pagination', 10  );

		/*Woo Filters*/

		/*category-loop*/
		remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
		remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
		remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

		/*Single Product*/
		add_action( 'woocommerce_before_single_product_summary', 'killarwt_woo_sing_prod_start_wrapper', 0 );
		add_action( 'woocommerce_before_single_product_summary', 'killarwt_woo_sing_prod_start_product_gallery_wrap', 5 );
		add_action( 'woocommerce_before_single_product_summary', 'killarwt_woo_sing_prod_end_product_gallery_wrap', 50 );
		add_action( 'woocommerce_before_single_product_summary', 'killarwt_woo_sing_prod_start_product_summary_wrap', 60 );
		add_action('woocommerce_single_product_summary', 'killarwt_woo_sing_prod_end_product_summary_wrap', 100);
		add_action( 'woocommerce_after_single_product_summary', 'killarwt_woo_single_prod_end_wrapper', 5 );

		// Add Flash Sale
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		if ( get_theme_mod( 'killar_woo_single_prod_sale_label', 'after-price') == 'on-image' ) {
			add_action( 'killar_before_product_gallery_wrapper', 'killarwt_woo_single_prod_sale_flash', 10 );
		} else if ( get_theme_mod( 'killar_woo_single_prod_sale_label', 'after-price') == 'after-price' ) {
			add_action( 'woocommerce_single_product_summary', 'killarwt_woo_single_prod_sale_flash', 11 );
		}

		// Add product navigation
		if ( get_theme_mod( 'killar_woo_single_prod_rating_enable', true) == false ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		}
						
		if ( get_theme_mod( 'killar_woo_single_prod_availability_enable', true) == true ) {
			add_action( 'woocommerce_single_product_summary', 'killarwt_woo_single_prod_mid_meta', 15 );
			add_action( 'killar_woo_single_product_product_summary_mid_meta', 'killarwt_woo_single_prod_sum_availability', 10 );
			//add_action( 'killar_woo_single_product_product_summary_mid_meta', 'killarwt_woo_single_prod_sum_sku', 10 );
		}

		if ( get_theme_mod( 'killar_woo_single_prod_short_description_enable', true) == false ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}

		/* Remove woocommerce stock html*/
		add_filter( 'woocommerce_get_stock_html', '__return_empty_string', 10, 2 );

		if ( get_theme_mod( 'killar_woo_single_prod_meta_enable', true) == false ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}

		if ( get_theme_mod( 'killar_woo_single_prod_share_enable', true) == false ) {
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		}

		/*Global Input Qty*/
		add_action( 'woocommerce_before_quantity_input_field', 'killarwt_woo_before_quantity_input_field', 10 );
		add_action( 'woocommerce_after_quantity_input_field', 'killarwt_woo_after_quantity_input_field', 10 );

		/*Upsell Products*/
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		if ( get_theme_mod( 'killar_woo_single_prod_upsells_enable', '1' ) != 0 ) {
			add_action( 'woocommerce_after_single_product_summary', 'killarwt_woo_single_prod_upsell_prods', 15 );
		}

		/*Related Products*/
		if ( get_theme_mod( 'killar_woo_single_prod_related_enable', '1' ) != 1 ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		} else {
			add_filter( 'woocommerce_output_related_products_args', 'killarwt_woo_single_prod_related_prods' );
		}

		/*cart*/
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
		add_action( 'woocommerce_before_cart_collaterals', 'killarwt_woo_cart_totals', 10 );
		add_action( 'killar_woo_cart_totals', 'woocommerce_cart_totals', 10 );

		/*Minicart*/
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
			add_filter( 'woocommerce_add_to_cart_fragments', 'header_minicart_fragment' );
		} else {
			add_filter( 'add_to_cart_fragments', 'header_minicart_fragment' );
		}
		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
		add_action( 'woocommerce_widget_shopping_cart_buttons', 'killarwt_woo_widget_shopping_cart_button_view_cart', 10 );
		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
		add_action( 'woocommerce_widget_shopping_cart_buttons', 'killarwt_woo_widget_shopping_cart_proceed_to_checkout', 20 );

		/*cross-sells products*/
		if ( get_theme_mod( 'killar_woo_cart_cross_sells_prod_slider_enable', '1' ) != 1 ) {
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		}
		add_filter( 'woocommerce_cross_sells_total', 'killarwt_woo_cross_sells_total' );
	}

	//Init hook
	add_action('init', 'killarwt_woocommerce_init_hooks', 1000);
	add_action('load-post.php', 'killarwt_woocommerce_init_hooks');
}