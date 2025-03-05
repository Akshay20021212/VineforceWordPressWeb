<?php
/**
*	Register portfolio content type
*/
function killarwt_portfolio_post_type() {
	
	$singular_name = get_option('portfolio-singular-name', 'Portfolio');
	$name = get_option('portfolio-name', 'Portfolio');
	$slug = get_option('portfolio-slug', 'portfolio');
	$category_name = sprintf( __('%s Categorie','killarwt-core'), $singular_name );
	$categories_name = sprintf( __('%s Categories','killarwt-core'), $singular_name );
	$category_slug = get_option('killar-portfolio-categories', 'portfolio-cat');
	$skill_name = sprintf( __('%s Skill','killarwt-core'), $singular_name );
	$skills_name = sprintf( __('%s Skills','killarwt-core'), $singular_name );
	$skill_slug = get_option('killar-portfolio-skill', 'portfolio-skill');
	
	$args = array(
		'labels' 				=> killarwt_posttype_labels( $singular_name, $name ),
		'menu_icon'				=> 'dashicons-images-alt2',
		'public' 				=> true,
		'has_archive' 			=> true,
		'with_front'            => true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export' 			=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'show_in_menu' 			=> true,
		'show_in_rest' 			=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'killarwt_core_portfolio_slug', $slug ) ),
		'supports' 				=> array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'elementor' ),
	);
	
	register_post_type( 'portfolio', $args );
	
	register_taxonomy( 'portfolio-cat', 'portfolio', array(
		'hierarchical' 			=> true,
		'labels' 				=> killarwt_texonomy_labels( $categories_name, $category_name ),
		'exclude_from_search' 	=> true,
		'public' 				=> true,
		'show_ui' 				=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'killar_core_portfolio_cat_slug', $category_slug ) ),
		'menu_icon' 			=> 'dashicons-images-alt2',
		'supports' 				=> array('title', 'editor'),
		'query_var' 			=> true,
		'show_in_nav_menus' 	=> false,
		'show_admin_column'     => true,
		'show_tagcloud'         => true,
		'show_in_rest'			=> true,
	) );
	
	register_taxonomy( 'portfolio-skills', 'portfolio', array(
		'hierarchical' 			=> true,
		'labels' 				=> killarwt_texonomy_labels( $skills_name, $skill_name ),
		'exclude_from_search' 	=> true,
		'public' 				=> true,
		'show_ui' 				=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'killar_core_portfolio_skills_slug', $skill_slug ) ),
		'menu_icon' 			=> 'dashicons-images-alt2',
		'supports' 				=> array('title', 'editor'),
		'query_var' 			=> true,
		'show_in_nav_menus' 	=> false,
		'show_admin_column'     => true,
		'show_tagcloud'         => true,
		'show_in_rest'			=> true,
	) );
}	
add_action( 'init', 'killarwt_portfolio_post_type' );

/**
 *	Single Portfolio Sidebar
 */
register_sidebar( array(
	'name'          => __( 'Single Portfolio Sidebar', 'killarwt-core' ),
	'id'            => 'single-portfolio-sidebar',
	'description'   => 'Single Portfolio Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
	'before_widget' => '<div id="%1$s" class="sidebar-widget sidebar-div mb-50 %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h6 class="widget-title">',
	'after_title'   => '</h6>'
) );

/**
 *	Portfolio Sidebar
 */
register_sidebar( array(
	'name'          => __( 'Portfolio Sidebar', 'killarwt-core' ),
	'id'            => 'portfolio-sidebar',
	'description'   => 'Portfolio Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
	'before_widget' => '<div id="%1$s" class="sidebar-widget sidebar-div mb-50 %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h6 class="widget-title">',
	'after_title'   => '</h6>'
) );


/**
 *	Portfolio Main Meta Boxes
 */

if( ! function_exists( 'killarwt_portfolio_main_metaboxes' ) ) {
	
    function killarwt_portfolio_main_metaboxes( $posttypes )
    {
		if( !empty( $posttypes ) ) {
			$posttypes = array_merge( $posttypes, array( 'portfolio' ) );
		}
		return $posttypes;
    }
}
add_filter( 'killar_main_metaboxes_post_types', 'killarwt_portfolio_main_metaboxes' );

/**
 *	Portfolio Meta Boxes Content
 */
if( ! function_exists( 'killarwt_portfolio_meta_boxes_content' ) )
{
    function killarwt_portfolio_meta_boxes_content( $array )
    {
		$prefix = KILLARWT_PREFIX;
		
		if( !empty( $array ) ) {
			$portfolio_meta[] =  array(
				'id'       => "{$prefix}portfolio_settings",
				'title'    => esc_html__( 'Portfolio', 'killarwt-core' ),
				'pages'    => 'portfolio',
				'context'  => 'normal',
				'autosave' => true,
				'fields'   => array(
					array(
						'name'			=> esc_html__( 'Portfolio Layout', 'killarwt-core' ),
						'id'			=> "{$prefix}portfolio_single_layout",
						'type'			=> 'select_advanced',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'killarwt-core' ),
											'compact' 		=> esc_html__( 'Compact', 'killarwt-core' ),
										),
						'placeholder'	=> 'Default',
					),
					array(
						'type' 			=> 'heading',
						'name' 			=> 'Portfolio Options',
					),
					array(
						'id'      => "{$prefix}portfolio_show_title",
						'type'    => 'radio',
						'name'    => __( 'Show Title?', 'killarwt-core' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'killarwt-core'),
							'0'  => __('No', 'killarwt-core'),
						),
					),
					array(
						'id'      => "{$prefix}portfolio_show_categories",
						'type'    => 'radio',
						'name'    => __( 'Show Categories?', 'killarwt-core' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'killarwt-core'),
							'0'  => __('No', 'killarwt-core'),
						),
					),
					array(
						'id'      => "{$prefix}portfolio_show_share",
						'type'    => 'radio',
						'name'    => __( 'Show Social Share?', 'killarwt-core' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'killarwt-core'),
							'0'  => __('No', 'killarwt-core'),
						),
					),
					array(
						'id'      => "{$prefix}portfolio_show_related",
						'type'    => 'radio',
						'name'    => __( 'Show Related Portfolio?', 'killarwt-core' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'killarwt-core'),
							'0'  => __('No', 'killarwt-core'),
						),
					),
					array(
						'type' 			=> 'heading',
						'name' 			=> 'Portfolio Highlights',
					),
					array(
						'id'         => "{$prefix}portfolio_highlights",
						'type'       => 'group',
						'clone'      => true,
						'sort_clone' => true,
						'fields'     => array(
							array(
								'id'   => "{$prefix}portfolio_highlights_title",
								'type' => 'text',
								'name' => __( 'Title:', 'killarwt-core' ),
								'columns' => 6,
							),
							array(
								'id'   => "{$prefix}portfolio_highlights_value",
								'type' => 'text',
								'name' => __( 'Value:', 'killarwt-core' ),
								'columns' => 6,
							),
						),
					),
				),
			);
			
			
			$array = array_merge( ( $portfolio_meta ), $array );
		}
		return $array;
    }
}
add_filter( 'killar_meta_boxes_content', 'killarwt_portfolio_meta_boxes_content' );


/*
 * Portfolio/Post
 */
add_action( 'killar_before_portfolio_loop_post', 'killarwt_before_portfolio_loop_post', 10 );
add_action( 'killar_after_portfolio_loop_post', 'killarwt_after_portfolio_loop_post', 10 );
add_action( 'killar_after_portfolio_loop_post', 'killarwt_after_loop_post_reset', 999 );
add_action( 'killar_portfolio_loop_pagination', 'killarwt_portfolio_loop_post_pagination', 10 );
add_action( 'wp_enqueue_scripts', 'killarwt_portfolio_loop_post_theme_js' );
add_action( 'killar_before_portfolio_loop_post_start', 'killarwt_before_portfolio_loop_post_start', 10 );
add_action( 'wp_ajax_killar_portfolio_popup', 'killarwt_portfolio_popup' );
add_action( 'wp_ajax_nopriv_killar_portfolio_popup', 'killarwt_portfolio_popup' );


/**
 * Loop Portfolio : Start Wrapper
 */
if ( ! function_exists( 'killarwt_before_portfolio_loop_post' ) ) {
	
	function killarwt_before_portfolio_loop_post() {
		
		do_action( 'killar_before_portfolio_loop_post_start' );
		
		echo '<div '.killarwt_portfolio_loop_post_wrapper_atts() .'>';
		
		do_action( 'killar_after_portfolio_loop_post_start' );
		
	}
}

/**
 * Loop Portfolio : End Wrapper
 */
if ( ! function_exists( 'killarwt_after_portfolio_loop_post' ) ) {
	
	function killarwt_after_portfolio_loop_post() {
		
		do_action( 'killar_before_portfolio_loop_post_end' );
		
		echo '</div>';
		
		do_action( 'killar_after_portfolio_loop_post_end' );
		
	}
}

/**
 * Portfolio Loop Wrapper Classes
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_wrapper_classes' ) ) {

	function killarwt_portfolio_loop_post_wrapper_classes( $class = '' ) {
		
		$classes = array();
		$classes[] = 'portfolio-posts';
		
		$view_type = killarwt_portfolio_loop_view_type();
		$classes[] = 'view-'.$view_type;
		$classes[] = 'portfolio-'.$view_type;
		
		$classes[] = 'portfolio-style-'.killarwt_get_loop_prop( 'killar_portfolio_loop_post_style' );
		
		if ( in_array( $view_type, array( 'slider', 'micro-slider', 'carousel' ) )  ) {
			
			$classes[] = 'items-cen-cont';
			$classes[] = 'kwt-slick-slider';
			$classes[] = killarwt_get_loop_prop( 'killar_portfolio_loop_post_carousel_classes' );
			$classes = array_merge( $classes, killarwt_get_nav_classes( array( 'carousel_nav' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_nav' ), 'carousel_nav_position' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_nav_position' ), 'carousel_nav_style' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_nav_style' ) ) ) );
		} else if ( in_array( $view_type, array( 'gallery-filter-dark', 'gallery-filter-light' ) )  ) {
			$classes[] = 'portfolio-area';	
		} else {
			
			if ( in_array( $view_type, array( 'grid-dark', 'grid-light', 'gallery-filter-dark', 'gallery-filter-light' ) ) ) {
				$portfolio_grid_columns = killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_lg', 2 );
				$classes[] = 'row gy-4 gx-lg-4 shuffle';
				$classes[] = 'portfolio-grid-'.$portfolio_grid_columns.'cols';
			}
			
			if ( killarwt_is_portfolio_archive() && in_array( killarwt_portfolio_loop_post_pagination_style(), array( 'infinite-scroll', 'load-more' ) ) ) {
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
		$classes = apply_filters( 'killar_portfolio_loop_post_wrapper_classes', $classes, $class );
		return array_unique( $classes );
		
	}

}

/**
 * Portfolio Loop Wrapper Attributes
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_wrapper_atts' ) ) {

	function killarwt_portfolio_loop_post_wrapper_atts() {

		$atts = array();
		
		$post_style = killarwt_get_loop_prop( 'killar_portfolio_loop_post_style', true );
		$view_type = killarwt_portfolio_loop_view_type();
		$atts['class'] = killarwt_stringify_classes( killarwt_portfolio_loop_post_wrapper_classes() );
		
		$p_atts = array(
			'view_type'			=> $view_type,
			'carousel_nav'		=> killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_nav', true ),
			'carousel_infinite'	=> killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_infinite', false ),
			'carousel_dots' 	=> killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_dots', false ),
			'carousel_speed' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_speed' ),
			'carousel_autoplay' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_autoplay' ),
			'carousel_center_mode' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_center_mode' ),
			'carousel_variable_width' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_variable_width' ),
			'carousel_variable_width_tablet' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_variable_width_tablet' ),
			'carousel_variable_width_mobile' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_variable_width_mobile' ),
			'carousel_adaptive_height' => killarwt_get_loop_prop( 'killar_portfolio_loop_carousel_adaptive_height' ),
			'items_col_xxl' 		=> killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xxl' ),
			'items_col_xl' 		=> killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xl' ),
			'items_col_lg' 		=> killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_lg' ),
			'items_col_md' 		=> killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_md' ),
			'items_col_sm' 		=> killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_sm' ),
			'items_col_xs' 		=> killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xs' ),
			'items_col_xxs' 	=> killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xxs', 1 ),
		);

		$atts = array_merge( $atts, killarwt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'killar_portfolio_loop_post_wrapper_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
		
	}
	
}

/**
 * Portfolio Loop Portfolio Classes
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_classes' ) ) {

	function killarwt_portfolio_loop_post_classes( $class = '' ) {
		
		$classes = array();		
		$display_type = killarwt_get_loop_prop( 'killar_portfolio_loop_display_type' );
		$view_type = killarwt_portfolio_loop_view_type();
		if ( in_array( $view_type, array( 'slider', 'micro-slider' ) )  ) {
			$classes[] = 'slider-item rounded-4 bg-white p-3';
		} else {
			
			if ( in_array( $view_type, array( 'grid-dark', 'grid-light', 'gallery-filter-dark', 'gallery-filter-light' ) )  ) {
				$portfolio_cat = get_the_terms( get_the_ID(), 'portfolio-cat' );
				if( !empty( $portfolio_cat ) ) {
					$cat_ar = array_column( get_the_terms( get_the_ID(), 'portfolio-cat' ), 'slug');
					$classes[] = 'masonry-item';
					$classes[] = ( !empty( $cat_ar ) ) ? implode( ' ', $cat_ar ) : '';
				}
			}
			
			$nums_rows = killarwt_get_loop_prop('nums_rows');
			$classes[] = 'item-entry';
			$classes[] = $display_type . '-item-entry';
			$classes[] = killarwt_get_loop_prop( 'killar_portfolio_loop_post_item_classes' );
			if ( in_array( $view_type, array( 'gallery-filter-dark', 'gallery-filter-light', 'grid-dark', 'grid-light' ) ) ) {
				$classes[] = killarwt_cols_class( 'xxl', killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xxl' ) );
				$classes[] = killarwt_cols_class( 'xl', killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xl' ) );
				$classes[] = killarwt_cols_class( 'lg', killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_lg' ) );
				$classes[] = killarwt_cols_class( 'md', killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_md' ) );
				$classes[] = killarwt_cols_class( 'sm', killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_sm' ) );
				$classes[] = killarwt_cols_class( 'xs', killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xs' ) );
				$classes[] = killarwt_cols_class( 'xxs', killarwt_get_loop_prop( 'killar_portfolio_loop_items_col_xxs' ) );
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
		
		
		$classes = array_merge( $classes, get_post_class() );

		// Filter secondary div class names.
		$classes = apply_filters( 'killar_portfolio_loop_post_wrapper_classes', $classes, $class );

		//$classes = array_map( 'sanitize_html_class', $classes );

		return array_unique( $classes );
		
	}

}

/**
 * Portfolio Loop Portfolio Attributes
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_atts' ) ) {

	function killarwt_portfolio_loop_post_atts() {

		$atts = array();

		$atts['class'] = killarwt_portfolio_loop_post_classes();
		
		$p_atts = array(
			'id'			=> 'post-'.get_the_ID(),
		);

		$atts = array_merge( $atts, killarwt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'killar_portfolio_loop_post_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
		
	}
	
}

/**
 * Portfolio Loop View Type
 */
if ( ! function_exists( 'killarwt_portfolio_loop_view_type' ) ) {

	function killarwt_portfolio_loop_view_type() {
		
		$view_type = killarwt_get_loop_prop( 'killar_portfolio_loop_view_type' );
		if ( empty( $view_type ) ) {
			$view_type = get_theme_mod( 'killar_portfolio_loop_view_type', array( 'gallery-filter-dark', 'gallery-filter-light' ));
		}
		
		return apply_filters( 'killar_portfolio_loop_view_type', $view_type );
	}
}

/**
 * Post : Related Portfolio
 */
if ( ! function_exists( 'killarwt_post_related_portfolio' ) ) {
	
	function killarwt_post_related_portfolio( $args = array() ) {
		
		$show_related = killarwt_get_post_meta( 'portfolio_show_related' );
		if ( empty( $show_related ) ) {
			$show_related = get_theme_mod( 'killar_portfolio_single_post_related_posts', true );
		}
		if( !$show_related ) return;
		
		// Only display for standard posts.
		if ( !function_exists( 'killarwt_portfolio' ) || get_post_type() !== 'portfolio' ) {
			return;
		}
		
		// Args
		$taxonomy = get_theme_mod( 'killar_portfolio_single_post_related_posts_taxonomy', 'portfolio-cat' );
		$taxonomy = $taxonomy ? $taxonomy : 'portfolio-cat';

		$default_args = array(
			'post_type'      		=> 'portfolio',
			'post_status'        	=> array('publish'),
			'ignore_sticky_posts'	=> true,
			'order'					=> 'date',
			'posts_per_page' 		=> apply_filters( 'killar_portfolio_single_post_related_posts_number', absint( get_theme_mod( 'killar_portfolio_single_post_related_posts_number', '2' ) ) ),
			'orderby'        		=> 'rand',
			'no_found_rows'  		=> true,
		);
		
		$args = wp_parse_args( $args, $default_args );

		$terms     = wp_get_post_terms( get_the_ID(), $taxonomy );
		$terms_ids = array();
		foreach ( $terms as $term ) {
			$terms_ids[] = $term->term_id;
		}

		if( !empty( $terms_ids ) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'operator' => 'IN',
					'terms' => $terms_ids
				)
			);
		}

		$args = apply_filters( 'killar_portfolio_single_post_related_posts_query_args', $args );
				
		$atts = array(); 
		$atts['query_args'] 			= $args;
		$atts['title'] 					= '';
		$atts['exclude_posts'] 			= array( get_the_ID() );
		$atts['view_type'] 				= 'slider';
		$atts['items_col_lg'] 			= apply_filters( 'killar_portfolio_single_post_related_posts_columns', absint( get_theme_mod( 'killar_portfolio_single_post_related_posts_columns', '2' ) ) );
		$atts['portfolio_loop_post_content']  = '';
		$atts['wrap_el_classes'] 		= 'entry-related-portfolio mt-4';

		killarwt_set_loop_prop( [ 'killar_portfolio_loop_type' => 'related_portfolio' ] );
		
		if ( is_singular( 'portfolio' ) )  {
			$atts['killar_portfolio_loop_post_section_show_title'] = false;
			$atts['portfolio_loop_post_style'] = get_theme_mod( 'killar_portfolio_single_post_related_style', 'box1' );
			$atts['portfolio_loop_post_style'] = get_theme_mod( 'killar_portfolio_single_post_related_style', 'box1' );
			$atts['portfolio_loop_post_content'] = get_theme_mod( 'killar_portfolio_single_post_related_content', 'hidden' );
			$atts['portfolio_loop_post_excerpt_length'] = get_theme_mod( 'killar_portfolio_single_post_related_excerpt_length', 0 );
			$atts['portfolio_loop_post_read_more'] = get_theme_mod( 'killar_portfolio_single_post_related_read_more', 'icon-elink-link' );
			$atts['portfolio_loop_post_remove_items_padding'] = get_theme_mod( 'killar_portfolio_single_related_remove_items_padding', 'box' );
		}
		
		return killarwt_portfolio( $atts );		
	}
	
}


/**
 * View Related Portfolio
 */
if ( ! function_exists( 'killarwt_view_related_portfolio' ) ) {

	function killarwt_view_related_portfolio() {
		
		get_template_part( 'template-parts/single-portfolio/related-portfolio'  );
	}

	add_action( 'killar_after_content_wrap', 'killarwt_view_related_portfolio', 10  );
}




/**
 * Returns portfolio meta
 */
if ( ! function_exists( 'killarwt_portfolio_post_meta' ) ) {

	function killarwt_portfolio_post_meta() {

		$sections = array( 'categories' );
		$option_name = 'killar_portfolio_loop_post_meta';
		
		if ( is_singular( 'portfolio' ) ) {
			$option_name = 'killar_portfolio_single_post_meta';
		}

		$sections = killarwt_get_loop_prop( $option_name, $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		$sections = apply_filters( $option_name, $sections );

		return $sections;

	}
}

/**
 * Returns the pagination style
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_pagination_style' ) ) {

	function killarwt_portfolio_loop_post_pagination_style() {

		$style = get_theme_mod( 'killar_portfolio_loop_post_pagination_style', 'default' );
		$style = apply_filters( 'killar_portfolio_loop_post_pagination_style', $style );
		return $style;
	}

}

/**
 * Portfolio Gallery
 */
if ( ! function_exists( 'killarwt_after_portfolio_loop_post_start' ) ) {

	function killarwt_after_portfolio_loop_post_start() {
		
		$html = '';
		$view_type = killarwt_portfolio_loop_view_type();
		if ( in_array( $view_type, array( 'gallery-filter-dark', 'gallery-filter-light' ) ) ) {
			$categories = killarwt_categories( 'portfolio-cat' );
			
			unset($categories['']);
			if( !empty( $categories ) ) {
				$html .= '<div class="row">
							<div class="col-md-12 text-center">
								<div class="masonry-filter ' . ( ( in_array( $view_type, array( 'gallery-filter-light' ) ) ) ? 'lights' : '' ) . ' port-button mb-60 mt-55 portfolio-menu masonry-filters nav nav-pills justify-content-center fs-sm overflow-auto text-nowrap w-100 mx-auto pb-4 mb-2 mb-sm-3">
									<button data-filter="*" class="active btn-link nav-link border">' . esc_html__( 'All' ) . '</button>';
				foreach( $categories as $key => $name ) {
					$html .= '<button class="btn-link nav-link border" data-filter=".'.$key.'">' . $name . '</button>';
				}
				$html .= '		</div>
							</div>
						  </div>';
			}
		}
		echo $html;
	}
	
	add_action( 'killar_after_portfolio_loop_post_start', 'killarwt_after_portfolio_loop_post_start', 10 );
}

/**
 * Portfolio Gallery Filter
 */

if ( ! function_exists( 'killarwt_portfolio_gallery_filter_start' ) ) {

	function killarwt_portfolio_gallery_filter_start() {
		
		$view_type = killarwt_portfolio_loop_view_type();
		$html = '';
		if ( in_array( $view_type, array( 'gallery-filter-dark', 'gallery-filter-light' ) ) ) {
			$html = '<div class="row">	
						<div class="col-md-12 gallery-items-list">
							<div class="masonry-wrap grid-loaded row g-xl-4 g-lg-3 g-3 shuffle">';
			}
			echo $html;
	}
	
	add_action( 'killar_after_portfolio_loop_post_start', 'killarwt_portfolio_gallery_filter_start', 20 );
}

if ( ! function_exists( 'killarwt_portfolio_gallery_filter_end' ) ) {

	function killarwt_portfolio_gallery_filter_end() {
		
		$view_type = killarwt_portfolio_loop_view_type();
		$html = '';
		if ( in_array( $view_type, array( 'gallery-filter-dark', 'gallery-filter-light' ) ) ) {
			$html = '</div></div></div>';
		}
		echo $html;
	}
	
	add_action( 'killar_before_portfolio_loop_post_end', 'killarwt_portfolio_gallery_filter_end', 20 );
}

/**
 * Loop Portfolio Pagination
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_pagination' ) ) {

	function killarwt_portfolio_loop_post_pagination() {
		
		$style = killarwt_portfolio_loop_post_pagination_style();
		
		// Category based settings
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term       = get_query_var( 'portfolio-cat' );
			$term_data  = get_option( 'category_'. $term );
			$term_style = $term_pagination = '';
			
			if ( isset( $term_data['killar_term_style'] ) ) {
				$term_style = $term_data['killar_term_style'] ? $term_data['killar_term_style'] .'' : $term_style;
			}
			
			if ( isset( $term_data['killar_term_pagination'] ) ) {
				$term_pagination = $term_data['killar_term_pagination'] ? $term_data['killar_term_pagination'] .'' : '';
			}
			
			if ( $term_pagination ) {
				$style = $term_pagination;
			}
			
		}
		
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			
			$args = array( 'style' => $style );
			$args['item-selector'] = '.'.killarwt_get_loop_prop( 'killar_portfolio_loop_display_type' ) . '-item-entry';
			
			// Last text
			$last = get_theme_mod( 'killar_portfolio_loop_post_pagination_last_text' );
			$last = killarwt_tm_translation( 'killar_portfolio_loop_post_pagination_last_text', $last );
			$last = $last ? $last: esc_html__( 'End of content', 'killarwt-core' );
			$args['last'] = $last;
			
			// Load more
			if ( $style == 'load-more' ) {
				$load_more = get_theme_mod( 'killar_portfolio_loop_post_load_more_button_text' );
				$load_more = killarwt_tm_translation( 'killar_portfolio_loop_post_load_more_button_text', $load_more );
				$load_more = $load_more ? $load_more: esc_html__( 'More Posts', 'killarwt-core' );
				$args['load_more'] = $load_more;
			
			}
			
			killarwt_infinite_scroll( $args );
		} else {
			killarwt_pagination();
		}

	}

}

/**
 * Loop Portfolio JS
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_theme_js' ) ) {

	function killarwt_portfolio_loop_post_theme_js() {
		
		$style = killarwt_portfolio_loop_post_pagination_style();
		
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			wp_enqueue_script( 'infinite-scroll', KILLARWT_JS_DIR_URI . 'third/' . 'infinite-scroll.pkgd.min.js', array( 'jquery' ) );
		}
	}
}

/**
 * Loop Portfolio Main Content
 */
if ( ! function_exists( 'killarwt_before_portfolio_loop_post_start' ) ) {

	function killarwt_before_portfolio_loop_post_start() {

		$show_title = killarwt_get_loop_prop( 'killar_portfolio_loop_post_section_show_title' );
		$loop_type = killarwt_get_loop_prop( 'killar_portfolio_loop_type' );
		$html = '';
		if ( !empty( $show_title ) && ( !empty( $loop_type ) && !in_array( $loop_type, array( 'related_portfolio' ) ) ) ) {
			$section_title = get_theme_mod( 'killar_portfolio_loop_post_section_title', 'Our Portfolio' );
			$section_sub_title = get_theme_mod( 'killar_portfolio_loop_post_section_sub_title', 'Our Case Studies' );
			if( !empty( $section_title ) || !empty( $section_sub_title ) ) {
				$html = '<div class="row justify-content-center">
							<div class="col-xl-6 col-lg-10 col-md-12 col-sm-12 mb-5">
								<div class="sec-heading center">
									' . ( ( !empty( $section_sub_title ) ) ? '<div class="d-inline-flex px-4 py-1 rounded-5 text-info bg-light-info font--medium mb-2"><span>'. esc_html__( $section_sub_title ) .'</span></div>' : '' ) . '
									' . ( ( !empty( $section_title ) ) ? '<h2>'. esc_html__( $section_title ) .'</h2>' : '' ) . '
								</div>
							</div>
						</div> ';
			}
		}

		echo wp_kses_post($html);

		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ( !empty( $term->description ) ): ?>
		<div class="archive-description mb-4">
		  <?php echo wp_kses_post($term->description); ?>
		</div>
		<?php endif;
	}
}

/**
 * Portfolio Popup
 */
if ( ! function_exists( 'killarwt_portfolio_popup' ) ) {

	function killarwt_portfolio_popup() {
		if ( ! isset( $_REQUEST['target'] ) ) {
			die();
		}
		
		$id = str_replace( '#portfolio-', '', $_REQUEST['target'] );
		if( !empty( $id ) ) {
			
			$query_args = array(
				'post_type'	=> 'portfolio',
				'post_status' => array('publish'),
				'post__in'	=> array( $id )
			);
			
			$query = new WP_Query( $query_args );
			
			if( !empty( $query ) ) {
				while ( $query->have_posts() ) : $query->the_post();

					killarwt_get_template( 'template-parts/single-portfolio/popup-layout', array( 'view_type' => 'portfolio-popup' ) );

				endwhile;
				
				wp_reset_postdata();
			}
			die();
		}
	}
}