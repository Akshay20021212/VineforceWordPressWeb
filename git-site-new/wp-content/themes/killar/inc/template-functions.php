<?php
/**
 * Functions
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

/**
 * Sets up the killarwt_loop global from the passed args or from the main query.
 */
function killarwt_setup_loop( $args = array() ) {
	
	$default_args = array(
		'killar_blog_loop_display_type' 			=> 'full',
		'killar_blog_loop_view_type' 				=> get_theme_mod( 'killar_blog_loop_view_type', 'list' ),
		'killar_blog_loop_post_style' 				=> get_theme_mod( 'killar_blog_loop_post_style', 'default' ),
		'killar_blog_loop_items_col_xxl' 			=> get_theme_mod( 'killar_blog_loop_items_col_xxl', 2 ),
		'killar_blog_loop_items_col_xl' 			=> get_theme_mod( 'killar_blog_loop_items_col_xl', 2 ),
		'killar_blog_loop_items_col_lg' 			=> get_theme_mod( 'killar_blog_loop_items_col_lg', 2 ),
		'killar_blog_loop_items_col_md' 			=> get_theme_mod( 'killar_blog_loop_items_col_md', 2 ),
		'killar_blog_loop_items_col_sm' 			=> get_theme_mod( 'killar_blog_loop_items_col_sm', 1 ),
		'killar_blog_loop_items_col_xs' 			=> get_theme_mod( 'killar_blog_loop_items_col_xs', 1 ),
		'killar_blog_loop_items_col_xxs' 			=> get_theme_mod( 'killar_blog_loop_items_col_xxs', 1 ),
		'killar_blog_loop_post_sections_positioning'=> get_theme_mod( 'killar_blog_loop_post_sections_positioning', array( 'thumbnail', 'categories', 'title', 'meta', 'content', 'read-more', 'social-links' ) ),
		'killar_blog_loop_post_meta' 				=> get_theme_mod( 'killar_blog_loop_post_meta', array('date' ) ),
		'killar_blog_loop_post_read_more' 			=> get_theme_mod( 'killar_blog_loop_post_read_more', 'button' ),
		'killar_blog_loop_post_image_size' 			=> get_theme_mod( 'killar_blog_loop_post_image_size', 'large' ),
		'killar_blog_loop_post_fancy_date'			=> get_theme_mod( 'killar_blog_loop_post_fancy_date', false ),
		'killar_blog_loop_post_content' 			=> get_theme_mod( 'killar_blog_loop_post_content', 'excerpt' ),
		'killar_blog_loop_post_excerpt_length' 		=> get_theme_mod( 'killar_blog_loop_post_excerpt_length', '50' ),
		'killar_blog_loop_post_pagination_style' 	=> get_theme_mod( 'killar_blog_loop_post_pagination_style', 'default' ),
		'killar_blog_loop_post_pagination_last_text'	=> get_theme_mod( 'killar_blog_loop_post_pagination_last_text', 'End of content' ),
		'killar_blog_loop_post_load_more_button_text' 	=> get_theme_mod( 'killar_blog_loop_post_load_more_button_text', 'Read More Articles' ),
		'nums_rows' 								=> 1,
		'carousel_nav' 								=> true,
		'carousel_infinite' 						=> false,
		'carousel_dots' 							=> true,
		'carousel_speed' 							=> '',
		'carousel_autoplay' 						=> false,
		'carousel_autoplay_speed' 					=> '',
		'carousel_center_mode' 						=> false,
		'carousel_variable_width' 					=> '',
		'carousel_variable_width_tablet' 			=> '',
		'carousel_variable_width_mobile' 			=> '',
		'carousel_adaptive_height' 					=> '',
		'carousel_nav_style' 						=> 'cir',
		'carousel_el_classes' 						=> '',
		'items_col_xxl' 							=> 4,
		'items_col_xl' 								=> 4,
		'items_col_lg' 								=> 3,
		'items_col_md' 								=> 3,
		'items_col_sm' 								=> 2,
		'items_col_xs' 								=> 1,
		'items_col_xxs' 							=> 1,
	);

	if ( KILLARWT_WOOCOMMERCE_ACTIVE ) {

		$woo_default_args = array(
			'killar_woo_loop_products_display_type' 	=> 'grid',
			'killar_woo_loop_products_view_type' 		=> 'grid',
			'killar_woo_loop_catalog_view_type' 		=> get_theme_mod( 'killar_woo_loop_catalog_view_type', 'grid' ),
			'killar_woo_loop_product_style'				=> get_theme_mod( 'killar_woo_loop_product_style', 'mprod-s1' ),
			'killar_woo_loop_badges_status' 			=> get_theme_mod( 'killar_woo_loop_badges_status', true ),
			'killar_woo_loop_prod_categories' 			=> get_theme_mod( 'killar_woo_loop_prod_categories', true ),
			'killar_woo_loop_prod_ratings' 				=> get_theme_mod( 'killar_woo_loop_prod_ratings', true ),
			'killar_woo_loop_prod_ratings_count' 		=> get_theme_mod( 'killar_woo_loop_prod_ratings_count', true ),
			'killar_woo_loop_prod_description' 			=> get_theme_mod( 'killar_woo_loop_prod_description', true ),
			'killar_woo_loop_prod_price' 				=> get_theme_mod( 'killar_woo_loop_prod_price', true ),
			'killar_woo_loop_prod_addtocart' 			=> get_theme_mod( 'killar_woo_loop_prod_addtocart', true ),
			'killar_woo_loop_prod_wishlist' 			=> get_theme_mod( 'killar_woo_loop_prod_wishlist', false ),
			'killar_woo_loop_prod_compare' 				=> get_theme_mod( 'killar_woo_loop_prod_compare', false ),
			'killar_woo_loop_prod_quickview' 			=> get_theme_mod( 'killar_woo_loop_prod_quickview', false ),
		);
		$default_args = array_merge( $default_args, $woo_default_args );
	}
	
	
	if ( !in_array( $default_args['killar_blog_loop_view_type'], array( 'grid' ) ) ) {
		$default_args['killar_blog_loop_post_style'] = 'default';
	}
	
	if ( post_type_exists( 'portfolio' ) ) {
		
		$portfolio_default_args = array(
			'killar_portfolio_loop_display_type' 			=> 'grid',
			'killar_portfolio_loop_type' 					=> 'list',
			'killar_portfolio_loop_post_section_show_title' => get_theme_mod( 'killar_portfolio_loop_post_section_show_title', false ),
			'killar_portfolio_loop_view_type' 				=> get_theme_mod( 'killar_portfolio_loop_view_type', 'grid'),
			'killar_portfolio_loop_post_style' 				=> get_theme_mod( 'killar_portfolio_loop_post_style', 'default' ),
			'killar_portfolio_loop_post_carousel_classes' 	=> get_theme_mod( 'killar_portfolio_loop_post_carousel_classes', '' ),
			'killar_portfolio_loop_post_item_classes' 		=> get_theme_mod( 'killar_portfolio_loop_post_item_classes', '' ),
			'killar_portfolio_loop_items_col_xxl' 			=> get_theme_mod( 'killar_portfolio_loop_items_col_xxl', 2 ),
			'killar_portfolio_loop_items_col_xl' 			=> get_theme_mod( 'killar_portfolio_loop_items_col_xg', 2 ),
			'killar_portfolio_loop_items_col_lg' 			=> get_theme_mod( 'killar_portfolio_loop_items_col_lg', 2 ),
			'killar_portfolio_loop_items_col_md' 			=> get_theme_mod( 'killar_portfolio_loop_items_col_md', 2 ),
			'killar_portfolio_loop_items_col_sm' 			=> get_theme_mod( 'killar_portfolio_loop_items_col_sm', 1 ),
			'killar_portfolio_loop_items_col_xs' 			=> get_theme_mod( 'killar_portfolio_loop_items_col_xs', 1 ),
			'killar_portfolio_loop_items_col_xxs' 			=> get_theme_mod( 'killar_portfolio_loop_items_col_xxs', 1 ),
			'killar_portfolio_loop_post_sections_positioning' => get_theme_mod( 'killar_portfolio_loop_post_sections_positioning', array( 'thumbnail', 'tags', 'title', 'meta', 'content', 'categories', 'social-links', 'read-more' ) ),
			'killar_portfolio_loop_post_meta' 				=> get_theme_mod( 'killar_portfolio_loop_post_meta', array( 'date', 'author' ) ),
			'killar_portfolio_loop_post_read_more' 			=> get_theme_mod( 'killar_portfolio_loop_post_read_more', 'icon-elink-link' ),
			'killar_portfolio_loop_post_image_size' 			=> get_theme_mod( 'killar_portfolio_loop_post_image_size', 'large' ),
			'killar_portfolio_loop_post_content' 			=> get_theme_mod( 'killar_portfolio_loop_post_content', 'excerpt' ),
			'killar_portfolio_loop_post_excerpt_length' 		=> get_theme_mod( 'killar_portfolio_loop_post_excerpt_length', '70' ),
		);
		$default_args = array_merge( $default_args, $portfolio_default_args );
	}

	// Merge any existing values.
	if ( isset( $GLOBALS['killarwt_loop'] ) ) {
		$default_args = array_merge( $default_args, $GLOBALS['killarwt_loop'] );
	}

	$GLOBALS['killarwt_loop'] = wp_parse_args( $args, $default_args );
}
add_action( 'woocommerce_before_shop_loop', 'killarwt_setup_loop' );
add_action( 'wp', 'killarwt_setup_loop', 10 );

/**
 * Resets the killarwt_loop global.
 */
function killarwt_reset_loop() {
	unset( $GLOBALS['killarwt_loop'] );
	unset( $GLOBALS['items_count'] );
}

/**
 * Gets a property from the killarwt_loop global.
 */
function killarwt_get_loop_prop( $prop, $default = '' ) {
	killarwt_setup_loop(); // Ensure shop loop is setup.

	return isset( $GLOBALS['killarwt_loop'], $GLOBALS['killarwt_loop'][ $prop ] ) ? $GLOBALS['killarwt_loop'][ $prop ] : $default;
}

/**
 * Sets a property in the killarwt_loop global.
 */
function killarwt_set_loop_prop( $prop, $value = '' ) {
	if ( ! isset( $GLOBALS['killarwt_loop'] ) ) {
		killarwt_setup_loop();
	}
	if ( is_array( $prop ) && !empty( $prop ) ) {
		foreach( $prop as $pk => $pv ) {
			$GLOBALS['killarwt_loop'][ $pk ] = $pv;	
		}
	} else {
		$GLOBALS['killarwt_loop'][ $prop ] = $value;	
	}
}

/**
 * Filters theme options
 */
function killarwt_theme_mod( $name, $default = false ) {
	
	return apply_filters( $name, get_theme_mod( $name, $default ) );
}


/**
 * Display the post header with a link to the post
 */
if ( ! function_exists( 'killarwt_excerpt_length' ) ) {
	function killarwt_excerpt_length() {
		return get_theme_mod( 'killar_excerpt_length', 40 );
	}
}

/**
 * Post : Header
 */
if ( ! function_exists( 'killarwt_post_header' ) ) {
	function killarwt_post_header() {
		get_template_part( 'template-parts/post/header' );
	}
}

/**
 * Post : Categories
 */	
if ( ! function_exists( 'killarwt_post_categories' ) ) {
	function killarwt_post_categories() {
		get_template_part( 'template-parts/post/categories' );
	}
}

/**
 * Post : Thumbnail
 */	
if ( ! function_exists( 'killarwt_single_post_thumbnail' ) ) {
	function killarwt_single_post_thumbnail() {
		get_template_part( 'template-parts/single-post/thumbnail', get_post_format() );
	}
}

/**
 * Post : Content
 */
if ( ! function_exists( 'killarwt_post_content' ) ) {
	function killarwt_post_content() {
		get_template_part( 'template-parts/post/content' );
	}
}

/**
 * Post : Category
 */
if ( ! function_exists( 'killarwt_single_post_category' ) ) {
	function killarwt_single_post_category() {
		get_template_part( 'template-parts/single-post/category' );		
	}
}

/**
 * Post : Title
 */
if ( ! function_exists( 'killarwt_post_title' ) ) {
	function killarwt_post_title() {
		get_template_part( 'template-parts/post/title' );		
	}
}

/**
 * Post : Meta
 */
if ( ! function_exists( 'killarwt_post_meta' ) ) {
	function killarwt_post_meta() {
		get_template_part( 'template-parts/post/meta' );		
	}
}

/**
 * Post : Author Info
 */
if ( ! function_exists( 'killarwt_post_author_info' ) ) {
	function killarwt_post_author_info() {
		get_template_part( 'template-parts/single-post/author-bio' );
	}
}

/**
 * Post : Post Tags
 */
if ( ! function_exists( 'killarwt_post_tags' ) ) {
	function killarwt_post_tags() {
		get_template_part( 'template-parts/post/tags' );
	}
}

/**
 * Post : Social Links
 */
if ( ! function_exists( 'killarwt_post_social_links' ) ) {
	
	function killarwt_post_social_links() {
		
		if ( is_single() ) {
			if ( !get_theme_mod( 'killar_blog_single_post_social_share', true ) )	return;
		} else {
			if ( !get_theme_mod( 'killar_blog_archive_post_tags', true ) )	return;
		}
		get_template_part( 'template-parts/post/social-buttons' );		
	}
	
}

/**
 * Post : Next/Prev Links
 */
if ( ! function_exists( 'killarwt_post_next_prev' ) ) {
	
	function killarwt_post_next_prev() {
		get_template_part( 'template-parts/post/next-prev' );		
	}
}

/**
 * Post : Related Posts
 */
if ( ! function_exists( 'killarwt_post_related_posts' ) ) {
	
	function killarwt_post_related_posts( $args = array() ) {
		
		// Only display for standard posts.
		if ( !function_exists( 'killarwt_blog' ) || get_post_type() !== 'post' ) {
			return;
		}
		
		// Args
		$taxonomy = get_theme_mod( 'killar_blog_single_post_related_posts_taxonomy', 'category' );
		$taxonomy = $taxonomy ? $taxonomy : 'category';

		$default_args = array(
			'posts_per_page' => apply_filters( 'killar_blog_single_post_related_posts_number', absint( get_theme_mod( 'killar_blog_single_post_related_posts_number', '6' ) ) ),
			'orderby'        => 'rand',
			'no_found_rows'  => true,
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
					'field' => 'id',
					'terms' => $terms_ids
				)
			);
		}

		$args = apply_filters( 'killar_blog_single_post_related_posts_query_args', $args );
		
		$atts = array(); 
		$atts['display_type'] 			= 'related_posts';
		$atts['query_args'] 			= $args;
		$atts['sec_title'] 				= '';
		$atts['exclude_posts'] 			= array( get_the_ID() );
		$atts['view_type'] 				= 'carousel';
		$atts['items_col_lg'] 			= apply_filters( 'killar_blog_single_post_related_posts_columns', absint( get_theme_mod( 'killar_blog_single_post_related_posts_columns', '2' ) ) );
		$atts['el_class'] 				= 'related-posts';
				
		if ( is_single() )  {
			$atts['blog_loop_post_style'] = get_theme_mod( 'killar_blog_single_post_related_style', 'default' );
			$atts['blog_loop_post_image_size'] = get_theme_mod( 'killar_blog_single_post_image_size', 'large' );
			$atts['blog_loop_post_content'] = get_theme_mod( 'killar_blog_single_post_related_content', 'excerpt' );
			$atts['blog_loop_post_excerpt_length'] = get_theme_mod( 'killar_blog_single_post_related_excerpt_length', 20 );
			$atts['blog_loop_post_read_more'] = get_theme_mod( 'killar_blog_single_post_related_read_more', 'icon' );
		}

		echo killarwt_blog( $atts );
	}
}

/**
 * Post : Comments
 */
if ( ! function_exists( 'killarwt_post_comments' ) ) {
	function killarwt_post_comments() {
		get_template_part( 'template-parts/post/comments' );
	}
}

/**
 * Post : Read More
 */
if ( ! function_exists( 'killarwt_post_read_more' ) ) {
	function killarwt_post_read_more() {
		get_template_part( 'template-parts/post/read-more' );
	}
}

/**
 * Loop Post : Start Wrapper
 */
if ( ! function_exists( 'killarwt_before_loop_post' ) ) {
	function killarwt_before_loop_post() {
		
		do_action( 'killar_before_blog_loop_post_start' );
		
		echo '<div '.killarwt_blog_loop_post_wrapper_atts() .'>';
		
		do_action( 'killar_after_blog_loop_post_start' );
		
	}
}

/**
 * Loop Post : End Wrapper
 */
if ( ! function_exists( 'killarwt_after_loop_post' ) ) {
	function killarwt_after_loop_post() {
		
		do_action( 'killar_before_blog_loop_post_end' );
		
		echo '</div>';
		
		do_action( 'killar_after_blog_loop_post_end' );
	}
}

/**
 * Loop Post : Reset Looop
 */
if ( ! function_exists( 'killarwt_after_loop_post_reset' ) ) {
	function killarwt_after_loop_post_reset() {
		
		killarwt_reset_loop();		
	}
}

/**
 * Page : Content
 */
if ( ! function_exists( 'killarwt_template_page_content' ) ) {
	function killarwt_template_page_content() {
		
		get_template_part( 'template-parts/page/content' );
	}
}

/**
 * Loop Post Pagination
 */
if ( ! function_exists( 'killarwt_blog_loop_post_pagination' ) ) {

	function killarwt_blog_loop_post_pagination() {
		
		$style = killarwt_blog_loop_post_pagination_style();
		
		// Category based settings
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term       = get_query_var( 'cat' );
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
			$args['item-selector'] = '.'.killarwt_get_loop_prop( 'killar_blog_loop_display_type' ) . '-item-entry';
			
			// Last text
			$last = get_theme_mod( 'killar_blog_loop_post_pagination_last_text' );
			$last = killarwt_tm_translation( 'killar_blog_loop_post_pagination_last_text', $last );
			$last = $last ? $last: esc_html__( 'End of content', 'killar' );
			$args['last'] = $last;
			
			// Load more
			if ( $style == 'load-more' ) {
				
				$load_more = killarwt_tm_translation( 'killar_blog_loop_post_load_more_button_text', get_theme_mod( 'killar_blog_loop_post_load_more_button_text' ) );
				
				$args['load_more'] = $load_more ?? esc_html__( 'Load More Articles', 'killar' );;
			}
			
			killarwt_infinite_scroll( $args );
		} else {
			killarwt_pagination();
		}
	}
}

/**
 * Get Post Types List
 */
if ( ! function_exists( 'killarwt_get_post_type_posts' ) ) {

	function killarwt_get_post_type_posts( $args = null, $select_option = '' ) {
		
		$results = array();
		
		if( !empty( $select_option ) ) {
			$results[] = $select_option;
		}
		
		$posts = get_posts( $args );
		if( !empty( $posts ) ) {
			foreach( $posts as $p ) {
				$results[$p->ID] = $p->post_title;
			}
		}
		
		return $results;
	}
}

/**
 * Is Verified
 */
if ( ! function_exists( 'theme_license_verified' ) ) {
	function theme_license_verified( $redirect = false ) {
		$verified = ( get_option( WT_THEME_SLUG . '_license_verified' ) && get_option( 'envato_purchase_code_50099740' ) ) ? true : false;
		if( !$verified && $redirect == true ) {
			wp_redirect(admin_url('?page=killar-dashboard'));
		}
		return $verified;
	}
}

if ( ! function_exists( 'killarwt_comments' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own killarwt_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function killarwt_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p class="comment-body"><?php esc_html_e( 'Pingback:', 'killar' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'killar' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li class=" <?php if($depth == '1') {echo "border-bottom";} ?>"  id="comment-<?php comment_ID(); ?>">
    	<div class="comment">            
            <div class="media">            	
                
                <div class="py-4 mt-2 mb-2">
					<div class="d-flex align-items-center pb-1 mb-2">
						<div>
						<a href="<?php echo esc_url(get_comment_author_link()); ?>" class="img-fluid circle"><?php echo get_avatar( $comment, 100 ); ?></a>
						</div>
						<div class="ps-3">
							<h6 class="mb-0"><?php comment_author(); ?></h6>
							<span class="d-flex mr-2"><?php echo human_time_diff( get_comment_time( 'U' ), current_time('timestamp') ) . esc_html__(' ago', 'killar'); ?></span>
						</div>
						      
					</div>
                    <div class="pb-2 mb-0"><?php comment_text(); ?></div>          
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'killar' ); ?></p>
                    <?php endif; ?> 
					<?php 
					if ($depth == '1') { ?>
					<div>
						<span class="border-0 fs-sm font--semibold px-0 py-0 bg-white">
							<?php		
							// edit_comment_link( esc_html__( 'Edit', 'killar' ), '<span class="edit-link">', '</span>' );
							comment_reply_link( array_merge( $args, array( 'reply_text' =>  esc_html__( 'Reply', 'killar' ). '<i class="fa-solid fa-reply ms-2"></i>&nbsp;', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
							?>
						</span> 
					</div>
					<?php
					}
					?>
                </div>
            </div>
        </div>							
	<?php
		break;
	endswitch; // end comment_type check
}
endif;