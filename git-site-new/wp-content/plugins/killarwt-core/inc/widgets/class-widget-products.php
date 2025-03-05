<?php
/**
 * @package wtKillarWT/Widgets
 * @widget : Products
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class Killar_Widget_Products extends WPH_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		
		// Widget Backend information
		$args = array(
			'label' => __( '[KILLAR] Products', 'killarwt-core' ),
			'description' => __( 'Display a list of your Products on your site', 'killarwt-core' ),
			'slug' => 'killar_widget_products',
			'options' => array( 'cache' => false )
		);
		
		$args['fields'] = self::killarwt_get_products_params();
		
		$this->create_widget( $args );

	}
	
	
	public 	function killarwt_get_products_params() {
			
		$data_sources = $product_categories_dropdown = array();
	
		$data_sources = array(
			esc_html__( 'All Products', 'killarwt-core' ) => 'all_products',
			esc_html__( 'Recent', 'killarwt-core' ) => 'recent_products',
			esc_html__( 'Featured', 'killarwt-core' ) => 'featured_products',
			esc_html__( 'Sale', 'killarwt-core' ) => 'sale_products',
			esc_html__( 'New', 'killarwt-core' ) => 'new_products',
			esc_html__( 'Best Selling', 'killarwt-core' ) => 'best_selling_products',
			esc_html__( 'Top Rated', 'killarwt-core' ) => 'top_rated_products',
			esc_html__( 'List of Products', 'killarwt-core' ) => 'products_ids',
		);

		$order_by_values = array(
			'' => '',
			esc_html__( 'Date', 'killarwt-core' ) => 'date',
			esc_html__( 'ID', 'killarwt-core' ) => 'ID',
			esc_html__( 'Author', 'killarwt-core' ) => 'author',
			esc_html__( 'Title', 'killarwt-core' ) => 'title',
			esc_html__( 'Modified', 'killarwt-core' ) => 'modified',
			esc_html__( 'Random', 'killarwt-core' ) => 'rand',
			esc_html__( 'Comment count', 'killarwt-core' ) => 'comment_count',
			esc_html__( 'Menu order', 'killarwt-core' ) => 'menu_order',
			esc_html__( 'Menu order & title', 'killarwt-core' ) => 'menu_order title',
		);

		$order_way_values = array(
			'' => '',
			esc_html__( 'Descending', 'killarwt-core' ) => 'DESC',
			esc_html__( 'Ascending', 'killarwt-core' ) => 'ASC',
		);
		$settings = array();

		$slider_navigation_style = array(
			esc_html__( 'Rectangle', 'killarwt-core' ) => 'rec',
			esc_html__( 'Circle', 'killarwt-core' ) => 'cir',
		);
		
		$slider_navigation_position = array(
			esc_html__( 'Slider Middle', 'killarwt-core' ) => 'slider-middle',
			esc_html__( 'Title Right', 'killarwt-core' ) => 'title-right',
		);
		
		$categories = get_categories( array(
			'type' => 'post',
			'child_of' => 0,
			'parent' => '',
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'number' => '',
			'taxonomy' => 'product_cat',
			'pad_counts' => false,

		) );

		$product_categories_dropdown = array( array( 
			'label' => esc_html__( 'Select Category', 'killarwt-core' ), 'value' =>''
		) );
		
		getCategoryChildsFull( 0, $categories, 0, $product_categories_dropdown );
				
		return apply_filters( 'killar_get_products_params', array(
			array(
				'type' =>	'textfield',
				'heading' => esc_html__( 'Title', 'killarwt-core' ),
				'param_name' =>	'title',
				'description' => esc_html__( 'Enter Title', 'killarwt-core' ),
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Data Source', 'killarwt-core' ),
				'value' => $data_sources ,
				'param_name' => 'data_source',
				'save_always' => true,
				'description' => esc_html__( 'Select types to shown Products.', 'killarwt-core' ),
				'admin_label' => true,
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Include Products Ids', 'killarwt-core' ),
				'param_name' => 'products_ids',
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
					'groups' => true
				),
				'save_always' => true,
				'description' => esc_html__( 'Add Products Ids.', 'killarwt-core' ),
				'dependency' =>	array(
									'element' => 'data_source',
									'value' => 'products_ids',
								),
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Categories', 'killarwt-core' ),
				'param_name' => 'categories',
				'settings' => array(
						'multiple' => true,
						// is multiple values allowed? default false
						// 'sortable' => true, // is values are sortable? default false
						'min_length' => 1,
						// min length to start search -> default 2
						// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
					),
				'save_always' => true,
				'description' => esc_html__( 'Enter categories.', 'killarwt-core' ),
				
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Exclude Products', 'killarwt-core' ),
				'param_name' => 'exclude',
				'settings' => array(
					'multiple' => true,
				),
				'save_always' => true,
				'description' => esc_html__( 'Input product ID or product SKU or product title to exclude products.', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Order by', 'killarwt-core' ),
				'param_name' => 'orderby',
				'value' => $order_by_values,
				'std' => 'date',
				'save_always' => true,
				'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'killarwt-core' ), '<a href="https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Sort order', 'killarwt-core' ),
				'param_name' => 'order',
				'value' => $order_way_values,
				'std' => 'ASC',
				'save_always' => true,
				'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'killarwt-core' ), '<a href="https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Number of Products', 'killarwt-core' ),
				'param_name' => 'limit',
				'description' => esc_html__( 'Number of products to show per page.', 'killarwt-core' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'killarwt-core' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'killarwt-core' ),
				'param_name' => 'view_type',
				'value' => array(
							esc_html__( 'Carousel', 'killarwt-core' ) => 'slider',
							esc_html__( 'Micro Carousel', 'killarwt-core' ) => 'micro_slider',
							esc_html__( 'Grid', 'killarwt-core' ) => 'grid',
							esc_html__( 'Micro Grid', 'killarwt-core' ) => 'micro_grid',
							
						),
				'admin_label' => true,
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Rows', 'killarwt-core' ),
				'value' => 1,
				'save_always' => true,
				'param_name' => 'rows',
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'micro_slider'),
									),
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Auto Play', 'killarwt-core' ),
				'param_name' => 'slider_autoplay',
				'value' => array(
							esc_html__( 'Yes', 'killarwt-core' ) => 1,
							esc_html__( 'No (Default)', 'killarwt-core' ) => 0,
						),
				'std' => 0,
				'save_always' => true,
				'description' => esc_html__( 'If yes, Slider item autoplay.', 'killarwt-core' ),
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'micro_slider'),
									),
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Loop', 'killarwt-core' ),
				'param_name' => 'slider_loop',
				'value' => array(
							esc_html__( 'Yes', 'killarwt-core' ) => 1,
							esc_html__( 'No (Default)', 'killarwt-core' ) => 0,
						),
				'std' => 0,
				'save_always' => 1,
				'description' => esc_html__( 'If yes, Infinity loop. Duplicate last and first items to get loop illusion.', 'killarwt-core' ),
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'micro_slider'),
									),
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation', 'killarwt-core' ),
				'param_name' => 'slider_nav',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'description' => esc_html__( 'If yes, Show next/prev buttons.', 'killarwt-core' ),
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'micro_slider'),
									),
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation Style', 'killarwt-core' ),
				'param_name' => 'slider_nav_style',
				'value' => $slider_navigation_style,
				'std' => 'cir',
				'save_always' => true,
				'description' => esc_html__( 'Display Navigation Rectangle or Circle Style.', 'killarwt-core' ),
				'dependency' 		=>	array(
										'element' => 'slider_nav',
										'value' => '1',
									),
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Navigation Position', 'killarwt-core' ),
				'param_name' => 'slider_nav_position',
				'value' => $slider_navigation_position,
				'std' => 'slider-middle',
				'save_always' => true,
				'description' => esc_html__( 'Display Navigation on Slider Middle or Title Right position.', 'killarwt-core' ),
				'dependency' 		=>	array(
										'element' => 'slider_nav',
										'value' => '1',
									),
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Dots', 'killarwt-core' ),
				'param_name' => 'slider_dots',
				'value' => array(
							esc_html__( 'Yes', 'killarwt-core' ) => 1,
							esc_html__( 'No (Default)', 'killarwt-core' ) => 0,
						),
				'std' => 0,
				'save_always' => true,
				'description' => esc_html__( 'If yes, Show dots navigation.', 'killarwt-core' ),
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'micro_slider'),
									),
				'group' => esc_html__( 'Layout', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Large devices (desktops, 992px and up)', 'killarwt-core' ),
				'param_name' => 'products_col_lg',
				'value' => array(
							esc_html__( '1 - Item', 'killarwt-core' ) => '1',
							esc_html__( '2 - Item(s)', 'killarwt-core' ) => '2',
							esc_html__( '3 - Item(s)', 'killarwt-core' ) => '3',
							esc_html__( '4 - Item(s)', 'killarwt-core' ) => '4',
							esc_html__( '5 - Item(s)', 'killarwt-core' ) => '5',
							esc_html__( '6 - Item(s)', 'killarwt-core' ) => '6',
							esc_html__( '7 - Item(s)', 'killarwt-core' ) => '7',
							esc_html__( '8 - Item(s)', 'killarwt-core' ) => '8',
						),
				'description' => esc_html__( 'Show numbers of items Large devices (desktops, 992px and up).', 'killarwt-core' ),
				'std' => '4',
				'group' => esc_html__( 'Responsive', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Medium devices (tablets, less than 992px)', 'killarwt-core' ),
				'param_name' => 'products_col_md',
				'value' => array(
							esc_html__( '1 - Item', 'killarwt-core' ) => '1',
							esc_html__( '2 - Item(s)', 'killarwt-core' ) => '2',
							esc_html__( '3 - Item(s)', 'killarwt-core' ) => '3',
							esc_html__( '4 - Item(s)', 'killarwt-core' ) => '4',
							esc_html__( '5 - Item(s)', 'killarwt-core' ) => '5',
							esc_html__( '6 - Item(s)', 'killarwt-core' ) => '6',
						),
				'description' => esc_html__( 'Show numbers of items Large devices (desktops, 992px and up)', 'killarwt-core' ),
				'std' => '4',
				'group' => esc_html__( 'Responsive', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Small devices (landscape phones, less than 768px)', 'killarwt-core' ),
				'param_name' => 'products_col_sm',
				'value' => array(
							esc_html__( '1 - Item', 'killarwt-core' ) => '1',
							esc_html__( '2 - Item(s)', 'killarwt-core' ) => '2',
							esc_html__( '3 - Item(s)', 'killarwt-core' ) => '3',
							esc_html__( '4 - Item(s)', 'killarwt-core' ) => '4',
						),
				'description' => esc_html__( 'Show numbers of items Small devices (landscape phones, less than 768px).', 'killarwt-core' ),
				'std' => '3',
				'group' => esc_html__( 'Responsive', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Extra small devices (portrait phones, less than 576px)', 'killarwt-core' ),
				'param_name' => 'products_col_xs',
				'value' => array(
							esc_html__( '1 - Item', 'killarwt-core' ) => '1',
							esc_html__( '2 - Item(s)', 'killarwt-core' ) => '2',
							esc_html__( '3 - Item(s)', 'killarwt-core' ) => '3',
						),
				'description' => esc_html__( 'Show numbers of items Extra small devices (portrait phones, less than 576px).', 'killarwt-core' ),
				'std' => '2',
				'group' => esc_html__( 'Responsive', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Style', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_product_style',
				'value' => array(
							esc_html__( 'Product Style - 1 (Default)', 'killarwt-core' ) => 'mprod-s1',
							esc_html__( 'Product Style - 2', 'killarwt-core' ) => 'mprod-s2',
							esc_html__( 'Product Style - 3', 'killarwt-core' ) => 'mprod-s3',
						),
				'std' => 'mprod-s1',
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'micro_slider'),
									),
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Image Style', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_product_image_style',
				'value' => array(
							esc_html__( 'Default', 'killarwt-core' ) => 'default',
							esc_html__( 'Image Swap', 'killarwt-core' ) => 'image-swap',
							esc_html__( 'Image Slider', 'killarwt-core' ) => 'image-slider',
						),
				'std' => 'default',
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'grid'),
									),
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Image Swap Effect', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_product_image_swap_style',
				'value' => array(
							esc_html__( 'Fade (Default)', 'killarwt-core' ) => 'fade',
							esc_html__( 'Flip', 'killarwt-core' ) => 'flip',
							esc_html__( 'Verticle Slide', 'killarwt-core' ) => 'vslide',
						),
				'std' => 'default',
				'dependency' 		=>	array(
										'element' => 'killar_woo_loop_product_image_style',
										'value' => 'image-swap',
									),
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Badges/Labels', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_badges_status',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'grid'),
									),
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Categories', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_categories',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'grid'),
									),
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Ratings', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_ratings',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Ratings Count', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_ratings_count',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Product Price', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_price',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Add to Cart Button', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_addtocart',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Wishlist Button', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_wishlist',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Compare Button', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_compare',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Quickview Button', 'killarwt-core' ),
				'param_name' => 'killar_woo_loop_prod_quickview',
				'value' => array(
							esc_html__( 'Yes (Default)', 'killarwt-core' ) => 1,
							esc_html__( 'No', 'killarwt-core' ) => 0,
						),
				'std' => 1,
				'save_always' => true,
				'dependency' 		=>	array(
										'element' => 'view_type',
										'value' => array('slider', 'grid'),
									),
				'group' => esc_html__( 'Product', 'killarwt-core' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => esc_html__( 'CSS box', 'killarwt-core' ),
				'param_name' => 'css',
				'group' => esc_html__( 'Design Options', 'killarwt-core' ),
			),
			
		) );
		
	}

	/**
	 * Output widget.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	public function widget( $args, $instance ) {
		
		$instance['display_type'] = 'widget';
		
		extract($args);
			
		echo wp_kses_post( $before_widget );
		
		if(!empty($instance['title'])) { echo wp_kses_post( $before_title ) . $instance['title'] . wp_kses_post( $after_title ); };
		
		echo killarwt_products( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

		echo wp_kses_post( $after_widget );

	}
	
	/**
	 * Output widget.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	function form( $instance ) {
		$id = killarwt_uniqid('killar-widget-');
		echo '<div class="' . $id . '">';
		parent::form( $instance );
		echo "<script type='text/javascript'>
				jQuery(document).ready(function() {
					if ( typeof killarWidgetInit !== 'undefined' ) {
						killarWidgetInit('.". $id ."');
					}
				} );
			</script>";
		echo '</div>';
	}
}
