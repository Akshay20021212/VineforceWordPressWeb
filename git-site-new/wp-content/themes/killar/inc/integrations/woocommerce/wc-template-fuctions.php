<?php
/**
 * WooCommerce helper functions
 * This functions only load if WooCommerce is enabled because
 * @link https://woocommerce.com/
 *
 * @package KillarWT
 */

/**
 * Check is WooCommerce tax.
 */
if ( ! function_exists( 'killarwt_is_woo_tax' ) ) {

	function killarwt_is_woo_tax() {
		if ( ! KILLARWT_WOOCOMMERCE_ACTIVE ) {
			return false;
		} elseif ( ! is_tax() ) {
			return false;
		} elseif ( function_exists( 'is_product_taxonomy' ) ) {
			if ( is_product_taxonomy() ) {
				return true;
			}
		}
	}
}

/**
 * Display WooCommerce sidebar.
 */
if ( ! function_exists( 'killarwt_woo_sidebar' ) ) {

	function killarwt_woo_sidebar( $sidebar ) {

		if ( killarwt_is_catalog() || is_checkout() || is_cart() || is_account_page() ) {
			$sidebar = 'woo-archive-shop-sidebar';
		} elseif ( killarwt_is_woo_single_prod() ) {
			$sidebar = 'woo-single-prod-sidebar';
		}
		
		return $sidebar;
	}
}

/**
 * Woo before shop loop
 */
if ( ! function_exists( 'killarwt_woocommerce_before_shop_loop' ) ) {

	function killarwt_woocommerce_before_shop_loop() {

		?>
		<div class="wt-products-header d-flex align-items-center justify-content-between mb-4">
			<div class="col-left d-flex align-items-center">
				<?php 
				/**
				 * Hook: killar_woocommerce_shop_loop_header_left.
				 *
				 * @hooked pls_woocommerce_product_off_canvas_sidebar - 10
				 * @hooked woocommerce_result_count - 20
				 */
				do_action( 'killar_woocommerce_shop_loop_header_left' );
				?>
			</div>
			<div class="col-right d-flex align-items-center">
				<?php 
				/**
				 * Hook: killar_woocommerce_shop_loop_header_right.
				 *
				 * @hooked pls_woocommerce_product_loop_view - 10
				 * @hooked pls_woocommerce_product_loop_show - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'killar_woocommerce_shop_loop_header_right' );
				?>
			</div>
		</div>
		<?php
	}
}

/**
 * Loop : Add Grid/List buttons
 */
if ( ! function_exists( 'killarwt_woo_loop_gridlist' ) ) {

	function killarwt_woo_loop_gridlist() {

		if ( ! killarwt_is_catalog() ) {
			return;
		}

		$grid = $list ='';

		if ( killarwt_woo_loop_catalog_view_type()  == 'list' ) {
			$list = 'active ';
		} else {
			$grid = 'active ';
		}

		$output = sprintf( '<div class="view-mode row d-flex align-items-start gx-2 ms-2"><a href="#" id="killarwt-grid" title="%1$s" class="%2$sgrid-view col"><span class="fas fa-grid fs-5"></span></a><a href="#" id="killarwt-list" title="%3$s" class="%4$slist-view col"><span class="fas fa-list fs-5"></span></a></div>', esc_html__( 'Grid view', 'killar' ), esc_attr( $grid ), esc_html__( 'List view', 'killar' ), esc_attr( $list ) );

		echo wp_kses_post( apply_filters( 'killarwt_woo_loop_gridlist_output', $output ) );
	}
}

/**
 * Loop : Products per page variations
 */
if ( ! function_exists( 'killarwt_woo_loop_per_page_variations' ) ) {

	function killarwt_woo_loop_per_page_variations() {
		
		$per_page_list = killarwt_loop_show_per_page_dropdowns_list();
		$per_page = killarwt_loop_shop_per_page();
		$current_url = killarwt_get_current_url();

		echo '<div class="woo-perpage d-flex align-items-center flex-shrink-0">';
		echo '<span class="fil-label text-muted text-nowrap">'. esc_html__( 'Show :', 'killar' ).'</span>';
		echo '<select class="form-select form-select-flush py-0 fs-6 border-0" onchange="if (this.value) window.location.href=this.value">';
		foreach( $per_page_list as $value => $label ) {
			echo "<option ".selected( $per_page, $value )." value='".add_query_arg( 'perpage', $value, $current_url)."'>$label</option>";
		}
		echo '</select>';
		echo '</div>';
	}
}

/**
 * Minicart Icon Link
 */
if ( ! function_exists( 'get_cart_icon_link' ) ) {
	
	function get_cart_icon_link( $style = '' ) {
		
		if ( $style == '' ) {
			$style = killarwt_minicart_style();
		}
		
		$atts = array();

		$atts['class'] = array( 'nav-menu-icon', 'minicart-action' );
		$atts['href'] = esc_url( wc_get_cart_url() );
		
		if ( $style == 'flyout' ) {
			$atts['class'][] = 'flyout-action';
			$atts['data-action'] = 'minicart-flyout';
			$atts['data-bs-toggle'] = 'offcanvas';
			$atts['aria-controls'] = 'offcanvasProduct';
			$atts['href'] = '#offcanvasProduct';
		}
		
		$html = '';
		$html .= '<a ' . killarwt_stringify_atts( $atts ) . '>
				<span class="cart-icon">
					<i class="fa-solid fa-basket-shopping fs-6"></i>
					<span class="badge bg-theme fs-xs position-absolute end-0 top-0 circle">' . ( ( apply_filters( 'killar_woo_header_cart_total', true ) && null != WC()->cart ) ? WC()->cart->get_cart_contents_count() : '' ) . '</span>
				</span>
			</a>';
		
		return $html;
	}
}

/**
 * Header Shop Right Sidebar
 */
if (!function_exists('killarwt_header_shop_right_buttons')) {

	function killarwt_header_shop_right_buttons( $button = null ) {
		$buttons = get_theme_mod('killar_header_shop_right_buttons', array( 'register', 'signin-account', 'cart'));
		if ( !empty( $button ) ) {
			return (in_array($button, $buttons) ) ? true : false;
		}

		return $buttons;
	}
}

/**
 * Mobile Header Shop Right Sidebar
 */
if (!function_exists('killarwt_mobile_header_shop_right_buttons')) {

	function killarwt_mobile_header_shop_right_buttons($button = null){

		$buttons = get_theme_mod('killar_mobile_header_shop_right_buttons', array('register', 'signin-account', 'cart'));
		if (!empty($button)) {
			return (in_array($button, $buttons)) ? true : false;
		}

		return $buttons;
	}
}

/**
 * Adds cart icon to primary menu
 *
 */
if ( ! function_exists( 'header_menu_cart_icon' ) ) {
	
	function header_menu_cart_icon( $items, $args ) {

		// main menu
		if ( $args->theme_location == 'primary' ) {

			$style = killarwt_minicart_style();
			
			if ( ! $style ) {
				return $items;
			}
			
			$items .= get_minicart_markup();
		}

		return $items;
	}
}

/**
 * Minicart Markup
 *
 */
if ( ! function_exists( 'get_minicart_markup' ) ) {
	
	function get_minicart_markup() {

		$style = killarwt_minicart_style();
		
		if ( ! $style ) {
			return $items;
		}

		$atts = array();
		$atts['class'] = array('nav-minicart nav-link text-primary position-relative');
		$atts['class'][] = 'woo-minicart-'. $style;

		if ( $style == 'link' && ( is_cart() || is_checkout() ) ) {
			$atts['class'][] = 'no-click';
		} 
		
		ob_start(); ?>

		<li <?php echo killarwt_stringify_atts( $atts ); ?>>
			<?php echo get_cart_icon_link(); ?>
			<?php if ( $style == 'dropdown' ) { ?>
				<div class="dropdown-menu minicart-dropdown wc-minicart woocommerce">
					<div class="minicart-inner minicart-drpdwn-inner">
						<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
					</div>
				</div>
			<?php } ?>
		</li>

		<?php
		return ob_get_clean();
	}
}

/**
 * Minicart Flyout
 *
 */
if ( ! function_exists( 'killarwt_mincart_flyout' ) ) {

	function killarwt_mincart_flyout() {
	
		$style = killarwt_minicart_style();
		
		if ( $style == 'flyout' ) {
			?>
			<div id="offcanvasProduct" class="offcanvas offcanvas-end woocommerce">
				<div class="offcanvas-header">
					<div class="d-flex w-100 justify-content-between align-items-center border-bottom pb-3 pb-sm-4">
						<h2 class="offcanvas-title d-flex align-items-center mb-1"><i class="icon icon-shopping_cart"></i><?php echo esc_html__( 'My Cart', 'killar' ) ?></h2>
						<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php echo esc_html__( 'Close', 'killar' ) ?>"></button>
					</div>
				</div>
				<div class="offcanvas-body">
					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
				</div>
			</div>
			<?php
		}
	}

	add_action( 'killar_after_site', 'killarwt_mincart_flyout' );
}

/**
 * Minicart Style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'killarwt_minicart_style' ) ) {

	function killarwt_minicart_style() {

		if ( ! KILLARWT_WOOCOMMERCE_ACTIVE ) {
			return;
		}

		$style = get_theme_mod( 'killar_minicart_style', 'flyout' );

		// Return click style for these pages
		if ( is_cart() || is_checkout() ) {
			$style = 'link';
		}

		$style = apply_filters( 'killar_minicart_style', $style );

		$style = ( $style == '' ) ? 'dropdown' : $style;

		return $style;

	}
}

/**
 * SignIn Register Popup
 */
if ( !function_exists( 'killarwt_signin_register_popup' ) ) {

	function killarwt_signin_register_popup() {

		$current_user = wp_get_current_user();
		if ( !empty( $current_user->ID ) ) return;
		?>	
		<div id="login-register-popup" class="modal auto-off fade" tabindex="-1" role="dialog" aria-label="login-register-modal" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<span class="mod-close" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-close"></i></span>
					<div class="modal-body">
						<div class="modal-login-form">
							<?php echo do_shortcode( '[woocommerce_my_account]' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	add_action( 'killar_after_site', 'killarwt_signin_register_popup' );
}

/**
 * Woo post classes
 */
if ( ! function_exists( 'killarwt_woo_post_class' ) ) {

	function killarwt_woo_post_class( $class ) {
		$classes = array();
		if ( killarwt_is_woo_single_prod() ) {
			$classes[] = 'woo-single-prod';
			$classes[] = 'thumb-ly-'.killarwt_woo_single_prod_image_gal_layout();
		}

		if ( !empty ( $classes ) ) {
			$class = array_merge( $classes, $class );
		} 

		return $class;
	}
}

/**
 * Loop Products : Wrapper Attributes
 */
 
if ( ! function_exists( 'killarwt_woo_loop_wrapper_atts' ) ) {

	function killarwt_woo_loop_wrapper_atts() {

		global $woocommerce_loop;
		
		//micro products filters
		if ( function_exists( 'killarwt_woo_loop_product_micro' ) ) {
			killarwt_woo_loop_product_micro();
		}
		
		/* Single Product : Upsell/Related */
		if ( !empty( $woocommerce_loop['name'] ) && in_array ( $woocommerce_loop['name'], array('upsell', 'related') ) ) {
			
			if ( function_exists( 'killarwt_woo_single_prod_upsell_related_prods_config' ) ) {
				killarwt_set_loop_prop( killarwt_woo_single_prod_upsell_related_prods_config() );
			}
		}
		
		/* Loop Product : cross-sells */
		if ( !empty( $woocommerce_loop['name'] ) && in_array ( $woocommerce_loop['name'], array('cross-sells') ) ) {
			
			if ( function_exists( 'killarwt_woo_cart_prod_slider_config' ) ) {
				killarwt_set_loop_prop( killarwt_woo_cart_prod_slider_config() );
			}
			
		}
		
		$atts = array();
		$atts['class'] = killarwt_stringify_classes( killarwt_woo_loop_wrapper_calasses() );

		$p_atts = array(
			'view_type'			=> killarwt_woo_loop_products_view_type(),
			'carousel_nav'		=> killarwt_get_loop_prop('carousel_nav', true),
			'carousel_infinite'	=> killarwt_get_loop_prop('carousel_infinite', false),
			'carousel_dots' 	=> killarwt_get_loop_prop('carousel_dots', false),
			'carousel_speed' => killarwt_get_loop_prop('carousel_speed'),
			'carousel_autoplay' => killarwt_get_loop_prop('carousel_autoplay'),
			'carousel_autoplay_speed' => killarwt_get_loop_prop('carousel_autoplay_speed'),
			'carousel_center_mode' => killarwt_get_loop_prop('carousel_center_mode'),
			'carousel_variable_width' => killarwt_get_loop_prop('carousel_variable_width'),
			'carousel_variable_width_tablet' => killarwt_get_loop_prop('carousel_variable_width_tablet'),
			'carousel_variable_width_mobile' => killarwt_get_loop_prop('carousel_variable_width_mobile'),
			'carousel_adaptive_height' => killarwt_get_loop_prop('carousel_adaptive_height'),
			'items_col_xxl' 		=> killarwt_get_loop_prop('items_col_xxl'),
			'items_col_xl' 		=> killarwt_get_loop_prop('items_col_xl'),
			'items_col_lg' 		=> killarwt_get_loop_prop('items_col_lg'),
			'items_col_md' 		=> killarwt_get_loop_prop('items_col_md'),
			'items_col_sm' 		=> killarwt_get_loop_prop('items_col_sm'),
			'items_col_xs' 		=> killarwt_get_loop_prop('items_col_xs'),
			'items_col_xxs' 	=> killarwt_get_loop_prop('items_col_xxs', 1),
		);

		$atts = apply_filters( 'killar_blog_loop_post_wrapper_atts', array_merge($atts, killarwt_loop_atts($p_atts)) );
		
		return killarwt_stringify_atts( $atts );
	}
}

/**
 * Loop Products : Wrapper Classes
 */
if ( ! function_exists( 'killarwt_woo_loop_wrapper_calasses' ) ) {

	function killarwt_woo_loop_wrapper_calasses( $class = [] ) {

		$classes = array( 'products products-container products-wrap items-cen-cont');
		
		// Products Style
		if ( function_exists( 'killarwt_woo_loop_product_style' ) ) {
			$classes[] = 'prods-style-' . killarwt_woo_loop_product_style();
		}
		
		// Default Products View
		if ( function_exists( 'killarwt_woo_loop_catalog_view_type' ) ) {
			$classes[] = ( killarwt_woo_loop_catalog_view_type() == 'list' ) ? 'listing-view' : 'grid-view';
		}
		
		$view_type = killarwt_woo_loop_products_view_type();
		$classes[] = 'view-'.$view_type;
		$classes[] = 'products-'.$view_type;
		
		if ( in_array( $view_type, array( 'slider', 'micro_slider', 'carousel', 'micro_carousel' ) )  ) {
			
			$classes[] = 'kwt-slick-slider items-cen-cont nav-slider-middle nav-on-hover';
		} else {

			if ( in_array( $view_type, array( 'grid' ) ) ) {
				$classes[] = 'row align-items-start g-4';
			}
			
			/* Loop Product : Infinite Scroll */
			if ( killarwt_is_catalog() && in_array( killarwt_woo_shop_pagination_style(), array( 'infinite-scroll', 'load-more' ) ) ) {
				$classes[] = 'infinite-scroll-wrap';
			}
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}

		// Filter secondary div class names.
		$classes = apply_filters( 'killar_woo_loop_wrapper_calasses', $classes, $class );

		return array_unique( $classes );
	}
}

/**
 * Loop Products : Wrapper Product Attributes
 */
if ( ! function_exists( 'killarwt_woo_loop_product_atts' ) ) {

	function killarwt_woo_loop_product_atts() {		

		$atts = array();
		$atts['class'] = killarwt_stringify_classes( killar_woo_loop_product_calasses() );

		$atts = apply_filters( 'killar_blog_loop_post_wrapper_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
		
	}
	
}

/**
 * Loop Products : Wrapper Product Classes
 */
if ( ! function_exists( 'killar_woo_loop_product_calasses' ) ) {

	function killar_woo_loop_product_calasses( $class = array() ) {
		
		global $product;
		
		$classes = array();

		$view_type = killarwt_woo_loop_products_view_type();
		if ( in_array( $view_type, array( 'slider', 'micro_slider', 'carousel', 'micro_carousel' ) )  ) {
			
			$classes[] = 'item-slider';
			
		} else {
			//$nums_rows = killarwt_get_loop_prop('nums_rows');
			$classes[] = killarwt_get_loop_prop( 'killar_woo_loop_products_display_type' ) . '-item-entry';
			if ( !in_array( $view_type, array( 'slider', 'micro_slider', 'carousel', 'micro_carousel' ) )  ) {
				$classes[] = killarwt_cols_class( 'xxl', killarwt_get_loop_prop('items_col_xxl') ); 
				$classes[] = killarwt_cols_class( 'xl', killarwt_get_loop_prop('items_col_xl') ); 
				$classes[] = killarwt_cols_class( 'lg', killarwt_get_loop_prop('items_col_lg') ); 
				$classes[] = killarwt_cols_class( 'md', killarwt_get_loop_prop('items_col_md') );
				$classes[] = killarwt_cols_class( 'sm', killarwt_get_loop_prop('items_col_sm') );
				$classes[] = killarwt_cols_class( 'xs', killarwt_get_loop_prop('items_col_xs') );
			}
		}
		
		if ( in_array( $view_type, array( 'micro_slider', 'micro_grid' ) ) ) {
			$classes[] = 'product-micro';
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}
		
		$classes = wc_get_product_class( $classes, $product );

		// Filter secondary div class names.
		$classes = apply_filters( 'killar_woo_loop_product_calasses', $classes, $class );

		return array_unique( $classes );
	}
}

/**
 * Loop Products : Wrapper Product Cat Classes
 */
if ( ! function_exists( 'killar_woo_loop_product_cat_calasses' ) ) {

	function killar_woo_loop_product_cat_calasses( $class = array() ) {
		
		global $category;
		
		$classes = array();

		$view_type = killarwt_woo_loop_products_view_type();
		if ( in_array( $view_type, array('slider', 'micro_slider', 'carousel', 'micro_carousel' ) )  ) {
			
			$classes[] = 'item-slider';
			
		} else {
			$classes[] = killarwt_get_loop_prop( 'killar_woo_loop_products_display_type' ) . '-item-entry';
			if ( !in_array( $view_type, array( 'slider', 'micro_slider', 'carousel', 'micro_carousel' ) )  ) {
				$classes[] = killarwt_cols_class( 'xxl', killarwt_get_loop_prop('products_col_xxl') ); 
				$classes[] = killarwt_cols_class( 'xl', killarwt_get_loop_prop('products_col_xl') ); 
				$classes[] = killarwt_cols_class( 'lg', killarwt_get_loop_prop('products_col_lg') ); 
				$classes[] = killarwt_cols_class( 'md', killarwt_get_loop_prop('products_col_md') );
				$classes[] = killarwt_cols_class( 'sm', killarwt_get_loop_prop('products_col_sm') );
				$classes[] = killarwt_cols_class( 'xs', killarwt_get_loop_prop('products_col_xs') );
			}
		}
		
		if ( in_array( $view_type, array( 'micro_slider', 'micro_carousel', 'micro_grid' ) ) ) {
			$classes[] = 'product-micro';
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}
		
		$classes = wc_get_product_cat_class( $classes, $category );

		// Filter secondary div class names.
		$classes = apply_filters( 'killar_woo_loop_product_cat_calasses', $classes, $class );

		return array_unique( $classes );
	}
}

/**
 * Loop Products : Product Categories
 */
if ( ! function_exists( 'killarwt_woo_loop_product_cat_atts' ) ) {

	function killarwt_woo_loop_product_cat_atts() {		

		$atts = array();
		$atts['class'] = killarwt_stringify_classes( killar_woo_loop_product_cat_calasses() );

		$atts = apply_filters( 'killar_woo_loop_product_cat_wrapper_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
	}
}

/**
 * Products Loop : View Type
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'killarwt_woo_loop_products_view_type' ) ) {

	function killarwt_woo_loop_products_view_type() {

		return apply_filters( 'killar_woo_loop_products_view_type', killarwt_get_loop_prop('killar_woo_loop_products_view_type') );
	}
}

/**
 * Product Image Thumbnail
 */
if ( ! function_exists( 'killarwt_woo_loop_product_image_thumbnail' ) ) {

	function killarwt_woo_loop_product_image_thumbnail () {
		
		if ( function_exists( 'wc_get_template' ) ) {
			
			global $killar_woocommerce_loop;
		
			$style = get_theme_mod( 'killar_woo_loop_product_image_style' );
			$style = $style ? $style : 'image-swap';
			
			if ( isset( $killar_woocommerce_loop['killar_woo_loop_product_image_style'] ) ) {
				$style = $killar_woocommerce_loop['killar_woo_loop_product_image_style'];
			}
			
			$style = apply_filters( 'killar_woo_loop_product_image_style', $style );
			
			wc_get_template( 'loop/thumbnail/'.$style.'.php' );
			
		}
	}
}

/**
 * After Loop Product Image
 */
if ( ! function_exists( 'killarwt_woo_after_loop_product_image' ) ) {
	
	function killarwt_woo_after_loop_product_image () {

		do_action( 'killar_loop_product_image_badge' );
		
		do_action( 'killar_loop_product_image_actions' );
		
	}
}

/**
 * Product Image Actions
 */
if ( ! function_exists( 'killarwt_woo_loop_product_image_actions' ) ) {
	
	function killarwt_woo_loop_product_image_actions () {
	
		$loop_prd_style = killarwt_woo_loop_product_style();
		
		if ( get_theme_mod( 'killar_woo_loop_prod_actions_buttons', true) == false || $loop_prd_style == 'mprod-micro' ) {
			return;
		}

		echo '<div class="product-actions">';

		do_action( 'killar_before_loop_product_image_actions' );

		echo '<ul>';
		do_action( 'killar_loop_product_image_actions_content' );
		echo '</ul>';

		do_action( 'killar_after_loop_product_image_actions' );

		echo '</div>';
		
	}
}

/**
 * Product Image Badges
 */
if ( ! function_exists( 'killarwt_woo_loop_product_image_badge' ) ) {

	function killarwt_woo_loop_product_image_badge () {
		
		if ( killarwt_woo_loop_badge_status() == false ) {
			return;
		}
		
		global $message, $post, $product;
		
		$badges_html = '';
		
		do_action ( 'killar_before_loop_product_image_badge' );
		
		//Out of Stock Badge
		$availability = $product->get_availability();
		//check if availability in the array = string 'Out of Stock'
		//if so display on page.//if you want to display the 'in stock' messages as well just leave out this, == 'Out of stock'
		if ( $availability['availability'] == 'Out of stock' && get_theme_mod( 'killar_woo_loop_badges_outofstock', true) == true ) {
			$outofstockbadge_text = get_theme_mod( 'killar_woo_loop_badges_outofstock_text', 'Out of Stock');
			$badges_html .= '<span class="outofstock badge r-badge stock ' . esc_attr( $availability['class'] ) . '"></span>';
		}
			
		//Featured Badge
		if ( $product->is_featured() && get_theme_mod( 'killar_woo_loop_badges_featured', true) == true ) {
			$featuredbadge_text = get_theme_mod( 'killar_woo_loop_badges_featured_text', 'Hot');
			$badges_html .= '<span class="onfeatured badge l-badge">' . wp_kses_post( $featuredbadge_text ) . '</span>';
			
		}
		
		//Sale Badge
		if ( $product->is_on_sale() && get_theme_mod( 'killar_woo_loop_badges_sale', true) == true ) {
						
			$sale_html = killarwt_sale_flash_html( $product, get_theme_mod( 'killar_woo_loop_badges_sale_type', 'text'), get_theme_mod( 'killar_woo_loop_badges_sale_text', 'Sale'), get_theme_mod( 'killar_woo_loop_badges_sale_percentage_text', '-{percentage}')) ;
			
			$badges_html .=  ( $sale_html != '' ) ? '<span class="onsale badge l-badge">' . $sale_html . '</span>' : '';
			
		}
		
		//New Badge
		if ( get_theme_mod( 'killar_woo_loop_badges_new', true) == true ) {
		
			$newness_days = get_theme_mod( 'killar_woo_loop_badges_new_limit', 30);
			if ( $newness_days > 0 ) {
				$created = strtotime( $product->get_date_created() );
				if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
					$newbadge_text = get_theme_mod( 'killar_woo_loop_badges_new_text', 'New');
					$badges_html .= '<span class="onnew badge l-badge">' . wp_kses_post( $newbadge_text ) . '</span>';
				}
			}
		}
		
		if ( $badges_html ) {
			echo '<div class="badges position-absolute top-0 start-0 mt-3 ms-3">';
			echo apply_filters( 'woocommerce_sale_flash', $badges_html, $post, $product );
			echo '</div>';
		}
		
		do_action ( 'killar_after_loop_product_image_badge' );
	}
}

/**
 * Sale Label
 */
if ( ! function_exists( 'killarwt_sale_flash_html' ) ) {

	function killarwt_sale_flash_html ( $product, $dis_type, $sale_label_text = 'Sale', $sale_percentage_text = '-{percentage}' ) {
		
		$sale_html = '';
					
		$sale_html = wp_kses_post( $sale_label_text );
		
		if ( $dis_type == 'percentage' ) {
			
			$percent = '';
			
			if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {

				$reg_price 	= $product->get_regular_price();
				$sale_price = $product->get_sale_price();
				$percent 	= round( ( ( floatval( $reg_price ) - floatval( $sale_price ) ) / floatval( $reg_price ) ) * 100 );

			} else if ( $product->is_type( 'variable' ) ) {

				$available_variations = $product->get_available_variations();
				$max_per           = 0;

				for ( $i = 0; $i < count( $available_variations ); ++ $i ) {
					$variation_id     = $available_variations[ $i ]['variation_id'];
					$variable_product = new WC_Product_Variation( $variation_id );

					if ( ! $variable_product->is_on_sale() ) {
						continue;
					}

					$reg_price 	= $variable_product->get_regular_price();
					$sale_price    = $variable_product->get_sale_price();
					$percent 	= round( ( ( floatval( $reg_price ) - floatval( $sale_price ) ) / floatval( $reg_price ) ) * 100 );

					if ( $percent > $max_per ) {
						$max_per = $percent;
					}
				}

				$percent = sprintf( '%s', $max_per );
				
			}
			
			if ( !empty( $percent ) ) {
				$sale_percentage_text = str_ireplace('{percentage}', '%s', $sale_percentage_text);
				$sale_html = sprintf( wp_kses_post( $sale_percentage_text ), $percent.'%');
			}
			
		}
		
		return $sale_html;
	}
}

/**
 * Product Loop : Product Badge
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'killarwt_woo_loop_badge_status' ) ) {

	function killarwt_woo_loop_badge_status() {
				
		return apply_filters( 'killar_woo_loop_badges_status', killarwt_get_loop_prop('killar_woo_loop_badges_status') );
	}
}

/**
 * Product Loop : Product Style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'killarwt_woo_loop_product_style' ) ) {

	function killarwt_woo_loop_product_style() {
		
		return apply_filters( 'killar_woo_loop_product_style', killarwt_get_loop_prop('killar_woo_loop_product_style') );
	}
}

/**
 * Loop Product : Actions
 */
if ( ! function_exists( 'killarwt_woo_loop_product_actions' ) ) {
	
	function killarwt_woo_loop_product_actions () {
		

		if ( get_theme_mod( 'killar_woo_loop_prod_actions_buttons', true) == false ) {
			return;
		}
		
		$loop_prd_style = killarwt_woo_loop_product_style();
		
		if ( $loop_prd_style == 'mprod-s2' ) {
			
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_quickview', 40 );
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_wishlist', 20 );
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_compare', 30 );
			add_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_addtocart', 10 );
			remove_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_wishlist', 20 );
			remove_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_compare', 30 );
			
		} else if ( $loop_prd_style == 'mprod-s3' ) {
			
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_addtocart', 10 );
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_wishlist', 20 );
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_compare', 30 );
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_quickview', 40 );
			
		} else if ( $loop_prd_style == 'mprod-micro' ) {
			
			add_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_addtocart', 10 );
			add_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_wishlist', 20 );
			add_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_compare', 30 );
			
		} else {
			
			add_action( 'killar_loop_product_image_actions_content', 'killarwt_woo_loop_product_actions_quickview', 40 );
			add_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_addtocart', 10 );
			add_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_wishlist', 20 );
			add_action( 'killar_loop_product_content_actions_content', 'killarwt_woo_loop_product_actions_compare', 30 );
			
		}		
	}
}

/**
 * Product Loop : Content Actions
 */
if ( ! function_exists( 'killarwt_woo_loop_product_content_actions' ) ) {

	function killarwt_woo_loop_product_content_actions () {
	
		$loop_prd_style = killarwt_woo_loop_product_style();
		
		if ( get_theme_mod( 'killar_woo_loop_prod_actions_buttons', true) == false || $loop_prd_style == 'mprod-s3' ) {
			return;
		}
		
		echo '<div class="product-actions">';

		do_action( 'killar_before_loop_product_content_actions' );

		echo '<ul>';
		do_action( 'killar_loop_product_content_actions_content' );
		echo '</ul>';

		do_action( 'killar_after_loop_product_content_actions' );

		echo '</div>';
	}
}

/**
 * Product Loop : Content
 */
if ( ! function_exists( 'killarwt_woo_loop_product_content' ) ) {

	function killarwt_woo_loop_product_content () {

		if ( function_exists( 'wc_get_template' ) ) {
		
			wc_get_template( 'loop/wt-product-content.php' );
			
		}
	}
}

/**
 * Product Loop : Product Categories
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_categories' ) ) {

	function killarwt_woo_loop_prod_categories() {
	
		return apply_filters( 'killar_woo_loop_prod_categories', killarwt_get_loop_prop('killar_woo_loop_prod_categories') );
	}
}

/**
 * Product Loop : Categories
 */
if ( ! function_exists( 'killarwt_woo_loop_product_content_categories' ) ) {

	function killarwt_woo_loop_product_content_categories () {

		global $product;
		
		if ( killarwt_woo_loop_prod_categories() == false ) {
			return;
		}
		
		do_action ( 'killar_before_loop_product_content_categories' );
		
		echo wp_kses_post( wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-cats">', '</div>' ) );
		
		do_action ( 'killar_after_loop_product_content_categories' );
	}
}

/**
 * Product Loop : title
 */
if ( ! function_exists( 'killarwt_woo_loop_product_content_title' ) ) {

	function killarwt_woo_loop_product_content_title () {

		global $product;
		echo "<h3 class='" . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'product-name' ) ) . "'><a href='" .esc_url( get_permalink( $product->get_id() ) ) ."'>" .$product->get_title() . "</a></h3>";
	}
}

/**
 * Product Loop : Product Ratings
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_ratings' ) ) {

	function killarwt_woo_loop_prod_ratings() {
	
		return apply_filters( 'killar_woo_loop_prod_ratings', killarwt_get_loop_prop('killar_woo_loop_prod_ratings') );
	}
}

/**
 * Product Loop : Ratings
 */
if ( ! function_exists( 'killarwt_woo_loop_product_content_rating' ) ) {

	function killarwt_woo_loop_product_content_rating () {
				
		if ( killarwt_woo_loop_prod_ratings() == false ) {
			return;
		}

		add_action( 'killar_loop_product_content_rating', 'woocommerce_template_loop_rating', 10 );
		add_filter( 'killar_woo_loop_prod_after_star_rating', 'killarwt_woo_loop_prod_after_star_rating', 10, 3 );
	}
}

/**
 * Product Loop : Star Rating After
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_after_star_rating' ) ) {
	
	function killarwt_woo_loop_prod_after_star_rating ( $html, $rating, $count ) {

		if ( !empty (killarwt_woo_loop_prod_ratings_count() ) && $count > 0 ) {
			$html .= '<span class="count">('.$count.')</span>';
		}
		
		return $html;
	}
}

/**
 * Product Loop : Product Ratings Count
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_ratings_count' ) ) {

	function killarwt_woo_loop_prod_ratings_count() {

		return apply_filters( 'killar_woo_loop_prod_ratings_count', killarwt_get_loop_prop('killar_woo_loop_prod_ratings_count') );
	}
}

/**
 * Product Loop : Product Description
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_description' ) ) {

	function killarwt_woo_loop_prod_description() {
		
		return apply_filters( 'killar_woo_loop_prod_description', killarwt_get_loop_prop('killar_woo_loop_prod_description') );
	}
}

/**
 * Product Loop : Description
 */
if ( ! function_exists( 'killarwt_woo_loop_product_content_description' ) ) {
	
	function killarwt_woo_loop_product_content_description () {
		global $post;
		
		if ( killarwt_woo_loop_prod_description() == false ) {
			return;
		}

		if ( killarwt_is_catalog() && get_theme_mod( 'killar_woo_loop_gridlist', 'true' ) == true ) {
			$length = 60;
			$length = apply_filters( 'killar_woo_loop_excerpt_length', $length );
			echo '<div class="product-desc">';
				if ( ! $length ) {
					echo wp_kses_post( strip_shortcodes( $post->post_excerpt ) );
				} else {
					echo wp_trim_words( strip_shortcodes( $post->post_excerpt ), $length );
				}
			echo '</div>';
		}
	}
}

/**
 * Product Loop : Product Price
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_price' ) ) {

	function killarwt_woo_loop_prod_price() {
		
		return apply_filters( 'killar_woo_loop_prod_price', killarwt_get_loop_prop('killar_woo_loop_prod_price') );
	}
}

/**
 * Product Loop : Price
 */
if ( ! function_exists( 'killarwt_woo_loop_product_content_price' ) ) {

	function killarwt_woo_loop_product_content_price () {
		
		if ( killarwt_woo_loop_prod_price() == false ) {
			return;
		}
		
		do_action ( 'killar_before_loop_product_content_price' );
		
		echo '<div class="product-price">';
		do_action ( 'killar_loop_product_content_price_content' );
		echo '</div>';
		
		do_action ( 'killar_after_loop_product_content_price' );
	}
}

/**
 * Product Loop : Product AddtoCart
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_addtocart' ) ) {

	function killarwt_woo_loop_prod_addtocart() {
		
		return apply_filters( 'killar_woo_loop_prod_addtocart', killarwt_get_loop_prop('killar_woo_loop_prod_addtocart') );
	}
}

/**
 * Loop Product : Add to cart 
 */
if ( ! function_exists( 'killarwt_woo_loop_product_actions_addtocart' ) ) {

	function killarwt_woo_loop_product_actions_addtocart () {
		
		if ( killarwt_woo_loop_prod_addtocart() == true ) {
		
			echo '<li class="btn-li btn-li-cart">';
				do_action ( 'killar_product_content_actions_add_to_cart' );
			echo '</li>';
			
		}
	}
}

/**
 * Product Loop : Product Wishlist
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_wishlist' ) ) {

	function killarwt_woo_loop_prod_wishlist() {
		
		return apply_filters( 'killar_woo_loop_prod_wishlist', killarwt_get_loop_prop('killar_woo_loop_prod_wishlist') );
	}
}

/**
 * Loop Product : Wishlist 
 */
if ( ! function_exists( 'killarwt_woo_loop_product_actions_wishlist' ) ) {

	function killarwt_woo_loop_product_actions_wishlist () {
		
		if ( killarwt_woo_loop_prod_wishlist() == true ) {
		
			echo '<li class="btn-li btn-lnk li-wishlist">';
				if( function_exists( 'YITH_WCWL' ) ):
					echo do_shortcode('[yith_wcwl_add_to_wishlist]');
				endif;
			echo '</li>';
			
		}
	}
}

/**
 * Product Loop : Product Compare
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_compare' ) ) {

	function killarwt_woo_loop_prod_compare() {
		
		return apply_filters( 'killar_woo_loop_prod_compare', killarwt_get_loop_prop('killar_woo_loop_prod_compare') );
	}
}

/**
 * Loop Product : Compare 
 */
if ( ! function_exists( 'killarwt_woo_loop_product_actions_compare' ) ) {

	function killarwt_woo_loop_product_actions_compare () {
	
		if ( killarwt_woo_loop_prod_compare() == true ) {
		
			echo '<li class="btn-li btn-lnk li-compare">';
				if(defined( 'YITH_WOOCOMPARE' )):
					echo do_shortcode('[yith_compare_button]');
				endif;
			echo '</li>';
		}
	}
}

/**
 * Product Loop : Product Quickview
 */
if ( ! function_exists( 'killarwt_woo_loop_prod_quickview' ) ) {

	function killarwt_woo_loop_prod_quickview() {
		
		return apply_filters( 'killar_woo_loop_prod_quickview', killarwt_get_loop_prop('killar_woo_loop_prod_quickview') );
	}
}

/**
 * Loop Product : Quickview 
 */
if ( ! function_exists( 'killarwt_woo_loop_product_actions_quickview' ) ) {

	function killarwt_woo_loop_product_actions_quickview () {

		global $product;
		
		if ( killarwt_woo_loop_prod_quickview() == true ) {
		
			echo '<li class="btn-li btn-lnk li-qckview">';
				echo '<div class="quick-view-button"><a href="#" class="quickview-button quickview-action button" data-product_id="'.$product->get_id().'">' . esc_html__( 'Quick View', 'killar' ) . '</a></div>';
			echo '</li>';
			
		}
	}
}

/**
 * Loop Product : Quickview Ajax
 */
if ( ! function_exists( 'killarwt_woo_loop_product_quickview' ) ) {

	function killarwt_woo_loop_product_quickview() {
		
		ob_start();
		if ( isset( $_POST['product_id'] ) && ! empty( $_POST['product_id'] ) ) {
			$product_id      = $_POST['product_id'];
			$original_post   = $GLOBALS['post'];
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			get_template_part( 'woocommerce/content-quickview' );
			$GLOBALS['post'] = $original_post; // WPCS: override ok.

		}
		echo ob_get_clean();
		//wp_send_json_success( $output );
		die();
	}
}

/**
 * Helper method to get the version of the currently installed WooCommerce.
 * @return string woocommerce version number or null.
 */
if ( ! function_exists( 'killarwt_woo_add_to_wishlist_button_classes' ) ) {

	function killarwt_woo_add_to_wishlist_button_classes( $pre_classes ) {

		$classes = array();
		
		$classes[] = $pre_classes;
		
		$classes[] = 'button btn-lnk btn-wishlist';
		
		return esc_attr( implode( ' ', $classes ) );
	}
}


/**
 * Shop : Products Columns
 */
if ( ! function_exists( 'killarwt_woo_loop_def_opts' ) ) {

	function killarwt_woo_loop_def_opts() {

		$killar_def_woo_loop = array();
		
		$killar_def_woo_loop['prodgrid_col_lg'] = get_theme_mod( 'killar_woo_loop_products_col_lg', '4' );
		$killar_def_woo_loop['prodgrid_col_md'] = get_theme_mod( 'killar_woo_loop_products_col_md', '4' );
		$killar_def_woo_loop['prodgrid_col_sm'] = get_theme_mod( 'killar_woo_loop_products_col_sm', '3' );
		$killar_def_woo_loop['prodgrid_col_xs'] = get_theme_mod( 'killar_woo_loop_products_col_xs', '2' );
		$killar_def_woo_loop['prodgrid_col_xxs'] = get_theme_mod( 'killar_woo_loop_products_col_xxs', '1' );
		
		return $killar_def_woo_loop;
	}
}

/**
 * Shop : Default Grid/List
 */
if ( ! function_exists( 'killarwt_woo_loop_catalog_view_type' ) ) {

	function killarwt_woo_loop_catalog_view_type() {

		if ( ! killarwt_is_catalog() ) {
			return;
		}

		return apply_filters( 'killar_woo_loop_catalog_view_type', killarwt_get_loop_prop('killar_woo_loop_catalog_view_type') );
	}
}

/**
 * Loop Product : Get Availability
 */
if ( ! function_exists( 'killarwt_get_availability' ) ) {

	function killarwt_get_availability( $availability, $product ) {
		
		/* In Stock & Low Stock Qty */
		if ( $product->is_in_stock() ) {
			$availability['availability'] = get_theme_mod( 'killar_woo_single_prod_availability_instock_msg', 'In Stock' );
			$availability['class'] = 'in-stock';
			$LowStockQty = get_theme_mod( 'killar_woo_single_prod_availability_lowstock_qty', '10' );
			$product_qty = $product->get_stock_quantity();
			if ( !empty( $LowStockQty ) && !empty( $product_qty ) && $LowStockQty >=  $product_qty ) {
				$LowStockQtyMsg = get_theme_mod( 'killar_woo_single_prod_availability_lowstock_qty_msg', 'Hurry, Only {qty} left in stock' );
				$LowStockQtyMsg = str_replace( array('{qty}', '{QTY}'), $product_qty, $LowStockQtyMsg );
				$availability['availability'] = $LowStockQtyMsg;
				$availability['class'] = 'low-stock-qty';
			}
		}
		
		/* Out of Stock */
		if ( !$product->is_in_stock() ) {
			$availability['availability'] = get_theme_mod( 'killar_woo_single_prod_availability_outofstock_msg', 'Out of Stock' );
			$availability['class'] = 'out-of-stock';
		}
		
		$availability = apply_filters( 'killar_get_availability', $availability );

		return $availability;
		
	}
	
	add_filter( 'woocommerce_get_availability', 'killarwt_get_availability', 1, 2);
}

/**
 * Product Loop : Micro Products
 */
if ( ! function_exists( 'killarwt_woo_loop_product_micro' ) ) {

	function killarwt_woo_loop_product_micro() {
	
		$view_type = killarwt_woo_loop_products_view_type();

		if ( in_array( $view_type, array('micro_carousel', 'micro_grid') ) ) {
		
			killarwt_set_loop_prop( 'killar_woo_loop_product_style', 'mprod-micro' );
			killarwt_set_loop_prop( 'killar_woo_loop_badges_status', false );
			killarwt_set_loop_prop( 'killar_woo_loop_product_image_style', 'default' );
			killarwt_set_loop_prop( 'killar_woo_loop_prod_categories', false );
		}
	}
}

/**
 * Loop : Show per page dropdown list
 */
if ( ! function_exists( 'killarwt_loop_show_per_page_dropdowns_list' ) ) {

	function killarwt_loop_show_per_page_dropdowns_list() {
		$per_page_list = get_theme_mod( 'killar_woo_archive_prods_per_page_variations', '9,12,24,36,-1');
		$per_page_list = explode( ',', $per_page_list );
		$per_page_list_ar = array();
		if ( !empty( $per_page_list ) ) {
			foreach ( $per_page_list as $k => $v ) {
				if ( $v == '-1' ) {
					$per_page_list_ar[$v] = esc_html__( 'All', 'killar' );
				} else {
					$per_page_list_ar[$v] = $v;
				}
				
			}
		}
		return $per_page_list_ar;
	}
}

/**
 * Loop : Shop per page
 */
if ( ! function_exists( 'killarwt_loop_shop_per_page' ) ) {

	function killarwt_loop_shop_per_page() {

		if ( !empty( $_GET['perpage'] ) ) {
			$products = filter_input(INPUT_GET, 'perpage', FILTER_SANITIZE_NUMBER_INT);
		} else {
			$taxonomy_page_display = get_option( 'woocommerce_category_archive_display', false );
			if ( is_product_taxonomy() && 'subcats' === $taxonomy_page_display ) {
				$products = wp_count_posts( 'product' )->publish;
			} else {
				$products = get_theme_mod( 'killar_woo_archive_prods_per_page', '12');
			}
		}

		return $products;
	}

	add_filter( 'loop_shop_per_page', 'killarwt_loop_shop_per_page', 20 );
	add_filter( 'loop_shop_columns', 'killarwt_loop_shop_per_page' );
}

/**
 * Loop : Pagination style
 */
if ( ! function_exists( 'killarwt_woo_shop_pagination_style' ) ) {

	function killarwt_woo_shop_pagination_style() {

		$style = get_theme_mod( 'killar_woo_archive_pagination_style', 'default' );
		$style = apply_filters( 'killar_woo_archive_pagination_style', $style );
		return $style;
	}
}

/**
 * Output the pagination.
 */
if ( ! function_exists( 'killarwt_woo_pagination' ) ) {

	function killarwt_woo_pagination() {
		
		if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
			return;
		}

		$style = killarwt_woo_shop_pagination_style();
				
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			
			$args = array( 'style' => $style );
			$args['item-selector'] = '.'.killarwt_get_loop_prop( 'killar_woo_loop_products_display_type' ) . '-item-entry';
		
			// Last text
			$last = get_theme_mod( 'killar_woo_archive_pagination_last_text' );
			$last = killarwt_tm_translation( 'killar_woo_archive_pagination_last_text', $last );
			$last = $last ? $last: esc_html__( 'End of content', 'killar' );
			$args['last'] = $last;
			
			// Load more
			if ( $style == 'load-more' ) {
				$load_more = get_theme_mod( 'killar_woo_archive_load_more_button_text' );
				$load_more = killarwt_tm_translation( 'killar_woo_archive_load_more_button_text', $load_more );
				$load_more = $load_more ? $load_more: esc_html__( 'More Posts', 'killar' );
				$args['load_more'] = $load_more;
			
			}
			
			killarwt_infinite_scroll( $args );
		} else {
			killarwt_pagination();
		}		
	}
}

/**
 * Category Loop
 */
if (!function_exists('killarwt_wc_template_loop_category_title')) {

	function killarwt_wc_template_loop_category_title($category)	{

		?>
		<h3 class="woocommerce-loop-category__title">
			<?php
			echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">' . esc_html( $category->name ) . '</a>';

			if ( $category->count > 0 ) {
				echo sprintf(
					'<span class="product-count">%1$s</span>',
					sprintf(_n('%s Product', '%s Products', $category->count, 'killar'), $category->count)
				);
			}
			?>
		</h3>
		<?php
	}
}

/**
 * Single Product : Start Wrapper
 */
if ( ! function_exists( 'killarwt_woo_sing_prod_start_wrapper' ) ) {

	function killarwt_woo_sing_prod_start_wrapper() {
		echo '<div class="single-product-wrapper row">';
		do_action( 'killar_woo_single_product_before_single_product_wrapper' );
	}
}

/**
 * Single Product : End Wrapper
 */
if ( ! function_exists( 'killarwt_woo_single_prod_end_wrapper' ) ) {
	function killarwt_woo_single_prod_end_wrapper() {
		do_action( 'killar_woo_single_product_after_single_product_wrapper' );
		echo '</div>';
	}
}

/**
 * Single Product : Start Product Gallery Wrapper
 */
if ( ! function_exists( 'killarwt_woo_sing_prod_start_product_gallery_wrap' ) ) {

	function killarwt_woo_sing_prod_start_product_gallery_wrap() {
		
		$classes = array( 'product-gallery' );
		$columns_classes = killarwt_woo_sing_prod_gallery_columns();
		if ( !empty ( $columns_classes ) ) {
			$classes = array_merge( $classes, $columns_classes );
		}
		$classes = killarwt_stringify_classes($classes);
		echo '<div class="'.$classes.'">';
		do_action( 'killar_woo_single_product_before_product_gallery' );
	}
}

/**
 * Single Product : End Product Gallery Wrapper
 */
if ( ! function_exists( 'killarwt_woo_sing_prod_end_product_gallery_wrap' ) ) {

	function killarwt_woo_sing_prod_end_product_gallery_wrap() {
		do_action( 'killar_woo_single_product_after_product_gallery' );
		echo '</div>';
	}
}

/**
 * Single Product : Start Product Summary Wrapper
 */
if ( ! function_exists( 'killarwt_woo_sing_prod_start_product_summary_wrap' ) ) {

	function killarwt_woo_sing_prod_start_product_summary_wrap() {

		$classes = array( 'product-summary' );
		$columns_classes = killarwt_woo_sing_prod_summary_columns();
		if ( !empty ( $columns_classes ) ) {
			$classes = array_merge( $classes, $columns_classes );
		}
		$classes = killarwt_stringify_classes($classes);
		echo '<div class="'.$classes.'">';
		do_action( 'killar_woo_single_product_before_product_summary' );
	}
}

/**
 * Single Product : End Product Summary Wrapper
 */
if ( ! function_exists( 'killarwt_woo_sing_prod_end_product_summary_wrap' ) ) {

	function killarwt_woo_sing_prod_end_product_summary_wrap() {
		
		if( in_array( killarwt_woo_loop_product_style(), array('full-info' ) ) ) return;

		do_action( 'killar_woo_single_product_after_product_summary' );
		echo '</div>';
	}
}

/**
 * Single Product : Product Gallery Columns
 */
if ( ! function_exists( 'killarwt_woo_sing_prod_gallery_columns' ) ) {

	function killarwt_woo_sing_prod_gallery_columns() {

		$columns = array();
		$columns[] = 'col-12';
		$columns[] = 'col-sm-'.get_theme_mod( 'killar_woo_single_prod_mobile_image_width', '12');
		$columns[] = 'col-md-'.get_theme_mod( 'killar_woo_single_prod_tablet_image_width', '6');
		$columns[] = 'col-lg-'.get_theme_mod( 'killar_woo_single_prod_desktop_image_width', '6');
		$columns[] = 'col-xl-'.get_theme_mod( 'killar_woo_single_prod_desktop_image_width', '6');

		$columns = apply_filters( 'killarwt_woo_sing_prod_gallery_columns', $columns );

		return $columns;
	}
}

/**
 * Single Product : Product Summary Columns0
 */
if ( ! function_exists( 'killarwt_woo_sing_prod_summary_columns' ) ) {

	function killarwt_woo_sing_prod_summary_columns() {

		$columns = array();
		$columns[] = 'col-12';
		$columns[] = 'col-sm-'.get_theme_mod( 'killar_woo_single_prod_mobile_summary_width', '12');
		$columns[] = 'col-md-'.get_theme_mod( 'killar_woo_single_prod_tablet_summary_width', '6');
		$columns[] = 'col-lg-'.get_theme_mod( 'killar_woo_single_prod_desktop_summary_width', '6');
		$columns[] = 'col-xl-'.get_theme_mod( 'killar_woo_single_prod_desktop_summary_width', '6');
		$columns[] = 'px-xl-5';

		$columns = apply_filters( 'killarwt_woo_sing_prod_summary_columns', $columns );

		return $columns;
	}

}

/**
 * Single Product : Woo Localize array
 */
if ( ! function_exists( 'woo_theme_js_localize' ) ) {
	function woo_theme_js_localize ( $array ) {
		
		$array['productGalleryZoom'] = killarwt_woo_single_prod_gal_zoom();

		return $array;
	}
}

/**
 * Single Product : Product Gallery Zoom
 */
if ( ! function_exists( 'killarwt_woo_single_prod_gal_zoom' ) ) {

	function killarwt_woo_single_prod_gal_zoom() {

		return apply_filters( 'killar_woo_single_prod_gal_zoom', get_theme_mod( 'killar_woo_single_prod_gal_zoom', true ) );
	}
}


/**
 * Single Product : Gallery Lightbox
 */
if ( ! function_exists( 'killarwt_woo_single_prod_gal_lightbox' ) ) {

	function killarwt_woo_single_prod_gal_lightbox() {

		return apply_filters( 'killar_woo_single_prod_gal_lightbox', get_theme_mod( 'killar_woo_single_prod_gal_lightbox', true) );
	}

}

/**
 * Single Product : Thumbnails Gallery Layout
 */
if ( ! function_exists( 'killarwt_woo_single_prod_image_gal_layout' ) ) {

	function killarwt_woo_single_prod_image_gal_layout() {

		return apply_filters( 'killar_woo_single_prod_image_gal_layout', get_theme_mod( 'killar_woo_single_prod_image_gal_layout', 'hor') );
	}
}

/**
 * Single Product : Sale Label/Badge
 */
if ( ! function_exists( 'killarwt_woo_single_prod_sale_flash' ) ) {

	function killarwt_woo_single_prod_sale_flash() {
	
		$sale_label = get_theme_mod( 'killar_woo_single_prod_sale_label', 'after-price');
		
		global $post, $product;

		$sale_html = '';
		if ( !$product->is_on_sale() || $sale_label == 'hidden' ) {
			return;
		} else if ( $sale_label == 'after-price' ) {

			$sale_html = killarwt_sale_flash_html( $product, 'percentage', get_theme_mod( 'killar_woo_loop_badges_sale_text', 'Sale'), get_theme_mod( 'killar_woo_single_prod_sale_label_percentage_text', '{percentage} off')) ;
			$sale_html = '<div class="discount-price"><span class="onsale wt-single-prod">' . $sale_html . '</span></div>';
		} else {
			
			$sale_html = killarwt_sale_flash_html( $product, get_theme_mod( 'killar_woo_loop_badges_sale_type', 'text'), get_theme_mod( 'killar_woo_loop_badges_sale_text', 'Sale'), get_theme_mod( 'killar_woo_single_prod_sale_label_percentage_text', '{percentage} off')) ;
			$sale_html = '<div class="badges"><span class="onsale badge l-badge wt-single-prod">' . $sale_html . '</span></div>';
		}

		if ( !empty( $sale_html ) ) {
			echo wp_kses_post( apply_filters( 'killarwt_woo_single_prod_sale_flash', $sale_html, $post, $product ) );
		}
	}
}

/**
 * Single Product : Product Navigation
 */
if ( ! function_exists( 'killarwt_woo_single_prod_next_prev_nav' ) ) {
	
	function killarwt_woo_single_prod_next_prev_nav() {

		$next = get_next_post();
		$prev = get_previous_post();
		
		$next = ( ! empty( $next ) ) ? wc_get_product( $next->ID ) : false;
		$prev = ( ! empty( $prev ) ) ? wc_get_product( $prev->ID ) : false;
		?>
		<div class="prd-nav-wrap">
			<?php do_action( 'killarwt_woo_single_prod_before_next_prev_nav' ); ?>
			<div class="wt-prd-nav">
				<?php if ( !empty( $prev ) ) { ?>
					<div class="prd-nav-btn prd-prev">
						<a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="nav-btn-icon prev-icon"><span class="text"><?php echo esc_html__( 'Previous Product', 'killar' ); ?></span></a>
						<div class="prd-info-wrap">
							<div class="prd-img">
								<a title="<?php echo esc_attr( $prev->get_title() ); ?>" href="<?php echo esc_url( $prev->get_permalink() ); ?>"><?php echo get_the_post_thumbnail( $prev->get_id(), apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) ); ?></a>
							</div>
							<div class="prd-info">
								<div class='product-title'>
									<a title="<?php echo esc_attr( $prev->get_title() ); ?>" href="<?php echo esc_url( $prev->get_permalink() ); ?>"><?php echo esc_attr( $prev->get_title() ); ?></a>
								</div>
								<div class="prd-price">
									<?php echo wp_kses_post( $prev->get_price_html() ); ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if ( !empty( $next ) ) { ?>
					<div class="prd-nav-btn prd-next">
						<a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="nav-btn-icon next-icon"><span class="text"><?php echo esc_html__( 'Next Product', 'killar' ); ?></span></a>
						<div class="prd-info-wrap">
							<div class="prd-img">
								<a title="<?php echo esc_attr( $next->get_title() ); ?>" href="<?php echo esc_url( $next->get_permalink() ); ?>"><?php echo get_the_post_thumbnail( $next->get_id(), apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) ); ?></a>
							</div>
							<div class="prd-info">
								<div class='product-title'>
									<a title="<?php echo esc_attr( $next->get_title() ); ?>" href="<?php echo esc_url( $next->get_permalink() ); ?>"><?php echo wp_kses_post( $next->get_title() ); ?></a>
								</div>
								<div class="prd-price">
									<?php echo wp_kses_post( $next->get_price_html() ); ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php do_action( 'killarwt_woo_single_prod_after_next_prev_nav' ); ?>
		</div>
	<?php
	}
}

/**
 * Output the product rating.
 */
if ( ! function_exists( 'killarwt_woo_template_single_rating' ) ) {

	function killarwt_woo_template_single_rating() {
		
		if ( post_type_supports( 'product', 'comments' ) ) {
			wc_get_template( 'single-product/rating.php' );
		}
		
	}
}

/**
 * Rating Markup
 */
if ( ! function_exists( 'rating_markup' ) ) {

	function rating_markup( $html, $rating, $count ) {
		
		if ( killarwt_woo_loop_prod_ratings() == false ) {
			return;
		}

		$html = '<div class="prod-star-rating">';

			if ( 0 < $rating ) {
				/* translators: %s: rating */
				$label = sprintf( __( 'Rated %s out of 5', 'killar' ), $rating );
				$html  .= '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
				
			} else {
			
				$html  .= '<div class="star-rating">';
				$html .= wc_get_star_rating_html( $rating, $count );
				$html .= '</div>';
			}

			$html = apply_filters( 'killar_woo_loop_prod_after_star_rating', $html, $rating, $count );

		$html .= '</div>';

		return $html;
	}
}

/**
 * Single Product : SKU & Availability
 */
if ( ! function_exists( 'killarwt_woo_single_prod_mid_meta' ) ) {

	function killarwt_woo_single_prod_mid_meta() {
		
		echo '<div class="product-mid-meta product_meta">';
		do_action( 'killar_woo_single_product_product_summary_mid_meta' );
		echo '</div>';
	}
}

/**
 * Single Product : Availability
 */
if ( ! function_exists( 'killarwt_woo_single_prod_sum_availability' ) ) {

	function killarwt_woo_single_prod_sum_availability() {
		
		if ( get_theme_mod( 'killar_woo_single_prod_availability_enable', true) == false ) {
			return '';
		}
		
		global $product;
		$availability = $product->get_availability();

		if ( ! empty( $availability[ 'availability'] ) ) :
			echo sprintf( '<span class="availability stk-%s">%s<span class="val %s">%s</span></span>', esc_attr( $availability['class'] ), '', esc_attr( $availability['class'] ), $availability['availability']);
		endif;
		
	}
}

/**
 * Single Product : SKU
 */
if ( ! function_exists( 'killarwt_woo_single_prod_sum_sku' ) ) {

	function killarwt_woo_single_prod_sum_sku() {
		
		if ( get_theme_mod( 'killar_woo_single_prod_sku_enable', true) == false ) {
			return '';
		}
		
		global $product;
		if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) :
			echo '<span class="sku_wrapper"> '. esc_html__( 'SKU:', 'killar' ). ' <span class="sku">' . (( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'killar' )) . '</span></span>';
		endif;
	}
}

/**
 * Single Product : Upsell Products
 */
if ( ! function_exists( 'killarwt_woo_single_prod_upsell_prods' ) ) {

	function killarwt_woo_single_prod_upsell_prods() {

		// Count
		$count = get_theme_mod( 'killar_woo_single_prod_upsell_related_nums_of_products', '8' );
		$count = $count ? $count : '8';

		// Columns
		$columns = get_theme_mod( 'killar_woo_single_prod_upsell_related_products_col_xl', '3' );
		$columns = $columns ? $columns : '3';

		// Alter upsell display
		woocommerce_upsell_display( $count, $columns );

	}
}

/**
 * Single Product : Related Products
 */
if ( ! function_exists( 'killarwt_woo_single_prod_related_prods' ) ) {

	function killarwt_woo_single_prod_related_prods() {
		
		global $product, $orderby, $related;
		
		// Count
		$count = get_theme_mod( 'killar_woo_single_prod_upsell_related_nums_of_products', '8' );
		$count = $count ? $count : '8';

		// Columns
		$columns = get_theme_mod( 'killar_woo_single_prod_upsell_related_products_col_xl', '3' );
		$columns = $columns ? $columns : '3';

		// Return array
		return array(
			'posts_per_page' => $count,
			'columns'        => $columns,
		);
	}
}

/**
 * Cart : cart totals
 */
if ( ! function_exists( 'killarwt_woo_cart_totals' ) ) {
	
	function killarwt_woo_cart_totals() {

		echo '<div class="cart-totals col-lg-4">';
		do_action( 'killar_woo_cart_totals' );
		echo '</div>';
	}
}

/**
 * Cart Product : Cross-Sells Products
 */
if ( ! function_exists( 'killarwt_woo_cross_sells_total' ) ) {
 	
	function killarwt_woo_cross_sells_total() {

		// Count
		$limit = get_theme_mod( 'killar_woo_cart_prod_slider_nums_of_products', '6' );
		$limit = $limit ? $limit : '6';

		return apply_filters( 'killar_woo_cross_sells_total', $limit );
	}
}


/**
 * Global : Qty Before Input
 */
if ( ! function_exists( 'killarwt_woo_before_quantity_input_field' ) ) {
	function killarwt_woo_before_quantity_input_field() {
		echo '<button type="button" class="decrease qty-pm"><i class="fas fa-minus"></i></button>';
	}
}

/**
 * Global : Qty After Input
 */
if ( ! function_exists( 'killarwt_woo_after_quantity_input_field' ) ) {
	function killarwt_woo_after_quantity_input_field() {
		echo '<button type="button" class="increase qty-pm"><i class="fas fa-plus"></i></button>';
	}
}


/**
 * Helper method to get the version of the currently installed WooCommerce.
 *
 * @return string woocommerce version number or null.
 */
if ( ! function_exists( 'get_wc_version' ) ) {
	function get_wc_version() {
		return defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;
	}
}

/**
 * Single Product : Upsell/Related Products
 */
if ( ! function_exists( 'killarwt_woo_single_prod_upsell_related_prods_config' ) ) {

	function killarwt_woo_single_prod_upsell_related_prods_config() {
		
		$woo_loop_opt = array();
		$enable_carousel = get_theme_mod( 'killar_woo_single_prod_upsell_related_prods_slider_enable', '1' );
		$woo_loop_opt['killar_woo_loop_products_view_type'] = ( !empty( $enable_carousel ) ) ? 'slider' : 'grid';
		$woo_loop_opt['slider_autoplay'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_prods_slider_autoplay', '1' );
		$woo_loop_opt['slider_loop'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_prods_slider_loop', '1' );
		$woo_loop_opt['slider_nav'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_prods_slider_navigation', '1' );
		$woo_loop_opt['slider_nav_position'] = 'title-right';
		$woo_loop_opt['slider_nav_style'] = 'cir';
		$woo_loop_opt['slider_dots'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_prods_slider_dots_navigation', '1' );
		$woo_loop_opt['products_col_lg'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_products_col_lg', '3' );
		$woo_loop_opt['products_col_md'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_products_col_md', '3' );
		$woo_loop_opt['products_col_sm'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_products_col_sm', '3' );
		$woo_loop_opt['products_col_xs'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_products_col_xs', '2' );
		$woo_loop_opt['products_col_xxs'] = get_theme_mod( 'killar_woo_single_prod_upsell_related_products_col_xxs', '2' );
			
		return apply_filters( 'killar_woo_single_prod_upsell_related_prods_config', $woo_loop_opt );
	}

}

/**
 * Cart Product : Cross-Sells
 */
if ( ! function_exists( 'killarwt_woo_cart_prod_slider_config' ) ) {

	function killarwt_woo_cart_prod_slider_config() {
		
		
		$woo_loop_opt = array();
		
		$enable_carousel = get_theme_mod( 'killar_woo_cart_prod_slider_prods_slider_enable', '1' );
		$woo_loop_opt['killar_woo_loop_products_view_type'] = ( !empty( $enable_carousel ) ) ? 'slider' : 'grid';
		$woo_loop_opt['slider_autoplay'] = get_theme_mod( 'killar_woo_cart_prod_slider_prods_slider_autoplay', '1' );
		$woo_loop_opt['slider_loop'] = get_theme_mod( 'killar_woo_cart_prod_slider_prods_slider_loop', '1' );
		$woo_loop_opt['slider_nav'] = get_theme_mod( 'killar_woo_cart_prod_slider_prods_slider_navigation', '1' );
		$woo_loop_opt['slider_nav_position'] = 'title-right';
		$woo_loop_opt['slider_nav_style'] = 'cir';
		$woo_loop_opt['slider_dots'] = get_theme_mod( 'killar_woo_cart_prod_slider_prods_slider_dots_navigation', '1' );
		$woo_loop_opt['products_col_xl'] = get_theme_mod( 'killar_woo_cart_prod_slider_products_col_xl', '6' );
		$woo_loop_opt['products_col_lg'] = get_theme_mod( 'killar_woo_cart_prod_slider_products_col_lg', '4' );
		$woo_loop_opt['products_col_md'] = get_theme_mod( 'killar_woo_cart_prod_slider_products_col_md', '4' );
		$woo_loop_opt['products_col_sm'] = get_theme_mod( 'killar_woo_cart_prod_slider_products_col_sm', '3' );
		$woo_loop_opt['products_col_xs'] = get_theme_mod( 'killar_woo_cart_prod_slider_products_col_xs', '2' );
		$woo_loop_opt['products_col_xxs'] = get_theme_mod( 'killar_woo_cart_prod_slider_products_col_xxs', '2' );
			
		$woo_loop_opt = apply_filters( 'killar_woo_cart_prod_slider_config', $woo_loop_opt );

		return $woo_loop_opt;
	}
}

if ( ! function_exists( 'killarwt_woocommerce_before_customer_myaccount_form' ) ) {

	function killarwt_woocommerce_before_customer_myaccount_form() {
				
		if ( !is_account_page() ) return;

		echo '<div class="row justify-content-center">
			<div class="col-full ' . ( ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) ? 'col-xl-10 col-lg-11 com-md-11' : 'col-xl-5 col-lg-6 com-md-9' ) . '">
			<div class="card border-0 rounded-5 p-xl-4 p-lg-4 p-3">';
	}
}

if ( ! function_exists( 'killarwt_woocommerce_after_customer_myaccount_form' ) ) {

	function killarwt_woocommerce_after_customer_myaccount_form() {
	
		if ( !is_account_page() ) return;

		echo '</div></div></div>';
	}
}

if ( ! function_exists( 'killarwt_before_account_navigation' ) ) {
	
	function killarwt_before_account_navigation() {

		$current_user = wp_get_current_user();

		$name = apply_filters( 'killar_user_profile_name', ( !empty( $name = $current_user->display_name ) ) ?  $name : esc_html__( 'Welcome!', 'killar' ) );

		echo '<div class="offcanvas-body pt-0 pe-lg-4 mb-3 mb-md-0 woo-MyAccount-wrapper">';
		echo '<div class="position-relative px-lg-4 py-lg-5 py-3 rounded-4 bg-white">';
			echo '<div class="user-prfl text-center mx-auto mb-4">';
				echo '<div class="position-relative mb-2 user-avatar d-flex justify-content-center">'. get_avatar( $current_user->user_email, 128, '', '',  [ 'class' => "img-fluid circle" ] ) .'</div>';
				echo '<div class="user-caps">';
					echo '<h5 class="mb-0">'. esc_attr( $name ) .'</h5>';
				echo '</div>';
			echo '</div>';
	}
}

if ( ! function_exists( 'killarwt_after_account_navigation' ) ) {
	
	function killarwt_after_account_navigation() {
		echo '</div></div>';
	}
}

/**
 * Cart Fragments
 * Ensure cart contents update when products are added to the cart via AJAX
 *
 * @param  array $fragments Fragments to refresh via AJAX.
 * @return array            Fragments to refresh via AJAX
 * @since 1.0.0
 */
if ( ! function_exists( 'header_minicart_fragment' ) ) {

	function header_minicart_fragment( $fragments ) {
		
		ob_start();
		echo get_cart_icon_link();
		$fragments['a.minicart-action'] = ob_get_clean();

		return $fragments;
	}
}

/**
 * Output the view cart button.
 */
if ( ! function_exists( 'killarwt_woo_widget_shopping_cart_button_view_cart' ) ) {

	function killarwt_woo_widget_shopping_cart_button_view_cart() {
		echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button button3 wc-forward">' . esc_html__( 'View cart', 'killar' ) . '</a>';
	}
}

/**
 * Output the proceed to checkout button.
 */
if ( ! function_exists( 'killarwt_woo_widget_shopping_cart_proceed_to_checkout' ) ) {

	function killarwt_woo_widget_shopping_cart_proceed_to_checkout() {
		echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button button2 checkout wc-forward">' . esc_html__( 'Checkout', 'killar' ) . '</a>';
	}
}

/**
 * Loop Portfolio JS
 */
if ( ! function_exists( 'killarwt_woo_loop_theme_js' ) ) {

	function killarwt_woo_loop_theme_js() {
		
		$style = killarwt_woo_shop_pagination_style();
		
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			wp_enqueue_script( 'infinite-scroll', KILLARWT_JS_DIR_URI . 'third/' . 'infinite-scroll.pkgd.min.js', array( 'jquery' ) );
		}
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * AJAX add to cart for all product types
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'killar_ajax_add_to_cart' ) ) {

	function killar_ajax_add_to_cart() {
		// Get messages
		ob_start();

		wc_print_notices();

		$notices = ob_get_clean();


		// Get mini cart
		ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		// Fragments and mini cart are returned
		$data = array(
			'notices' => $notices,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
				)
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);

		wp_send_json( $data );

		die();
	}
	
	add_action( 'wp_ajax_killar_ajax_add_to_cart', 'killar_ajax_add_to_cart' );
	add_action( 'wp_ajax_nopriv_killar_ajax_add_to_cart', 'killar_ajax_add_to_cart' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Reset loop
 * ------------------------------------------------------------------------------------------------
 */

if (!function_exists('killarwt_reset_loop')) {

	function killarwt_reset_loop()
	{
		unset($GLOBALS['killarwt_loop']);
		woocommerce_product_loop_end();
	}

	add_action('woocommerce_after_shop_loop', 'killarwt_reset_loop', 1000);
	add_action('loop_end', 'killarwt_reset_loop', 1000);
}