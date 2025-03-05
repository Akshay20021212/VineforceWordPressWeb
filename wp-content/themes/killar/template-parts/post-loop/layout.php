<?php
/**
 * Post Loop Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$sections = killarwt_blog_loop_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}

if( !isset( $GLOBALS['items_count'] ) ) $GLOBALS['items_count'] = 0;
$view_type = killarwt_get_loop_prop( 'killar_blog_loop_view_type' );
$post_style = killarwt_get_loop_prop( 'killar_blog_loop_post_style' );

$nums_rows = killarwt_get_loop_prop( 'nums_rows' );
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && $GLOBALS['items_count'] % $nums_rows == 0 ) {
	echo '<div class="products">';
}

$sub_atts = array();
$sub_atts['class'] = array( 'entry-post', 'blog-post', 'blog-page1-content-wrapper' );
$sub_atts['class'][] = ( ! empty( $args['el_classes'] ) ) ? $args['el_classes'] : '';
if ( !in_array( $view_type, array( 'grid', 'micro_grid', 'slider' ) ) ) {
	$sub_atts['class'][] = 'b-bottom';
}
if( in_array( $view_type, array( 'full-center' ) ) ) {
	$sub_atts['class'][] = 'text-center';
}


$content_args = $thumbnail_args = array();
$thumbnail_args['class'] = array( 'thumbnail-wrap' );
$content_args['class'] = array( 'entry-content-wrapper article-caption py-2' );

if( $post_style == 'box' ) {
	$sub_atts['class'][] = 'blog-portfolio blog-portfolio-overly position-relative overflow-hidden';
	$sub_atts['class'][] = ( !in_array( $view_type, array( 'gallery-filter-dark', 'gallery-filter-light' ) ) ) ? 'mb-3' : '';
	$content_args['class'][] = 'blog-post-txt blog-portfolio-content blog-portfolio-over-content position-absolute left-0 right-0 py-3 px-4 transition5 z-1 text-white';
} else if( in_array( $view_type, array( 'full-center' ) ) ) {
	$content_args['class'][] ='text-center d-flex flex-column align-items-center';
} else if( in_array( $view_type, array( 'modern' ) ) ) {
	$sub_atts['class'][] = 'row d-flex align-items-center';
}

if ( in_array( $view_type, array( 'list' ) ) || in_array( $post_style, array( 'verticle-blog' ) ) ) {
	$thumbnail_args['class'][] = 'col-sm-6';
	$content_args['class'][] = ( has_post_thumbnail() ) ? 'col-md-6' : '';
} else if ( in_array( $view_type, array( 'list', 'modern' ) ) ) {
	$thumbnail_args['class'][] = 'col-xl-5 col-lg-5 col-md-6 col-sm-12 col-12';
	$content_args['class'][] = ( has_post_thumbnail() ) ? 'col-xl-6 offset-lg-1 col-lg-6 col-md-6 col-12 pe-125' : '';
}

if ( in_array( $view_type, array( 'grid', 'list', 'modern', 'full', 'full-center' ) ) ) {

	$sub_atts['class'][] = 'entry-post-inner verticle-blog-wrap bg-white py-2 rounded-2 border h-100';
	if ( !in_array( $view_type, array( 'modern' ) ) ) $sub_atts['class'][] = 'px-2';
}

$footer_content_args = array();
$footer_content_args['class'] = array( 'blog-page-footer d-sm-flex align-items-center justify-content-between' );

$sections = array_values(array_filter($sections));

$GLOBALS['display_type'] = ( isset( $GLOBALS['display_type'] ) ) ?  $GLOBALS['display_type'] : 'loop';

if( ( $paged = (get_query_var('paged')) ? get_query_var('paged') : 1 ) && $paged == 1 ) {
	
	$flt_args = array( 'items_count' => $GLOBALS['items_count'], 'exclude_posts' => wp_list_pluck( $wp_query->posts, 'ID' ), 'display_type' => $GLOBALS['display_type'] );

	do_action( 'killar_outer_before_loop_post_start', $flt_args );

	$sub_atts = apply_filters( 'killar_loop_post_subatts', $sub_atts, $flt_args );
}
?>
<article <?php echo killarwt_blog_loop_post_atts(); ?>>
	
	<?php do_action( 'killar_after_loop_post_start' ); ?>
	
	<div <?php echo killarwt_stringify_atts( $sub_atts ); ?>>
		<?php
		
		$show_row = ( in_array( $view_type, array( 'list' ) ) || in_array( $post_style, array( 'verticle-blog' ) ) ) ? true : false;
		
		if ( !empty( $show_row ) ) { 
			echo '<div class="row align-items-center">'; 
		}
		$i = 0;
		foreach ( $sections as $section_key => $section ) :
		
			if ( $sections[0] == 'thumbnail' && $sections[1] == $section ) {
				echo '<div ' . killarwt_stringify_atts( $content_args ) . '>';
			}
			
			if ( $sections[$section_key] =='read-more' && !empty( $sections[$section_key+1] ) && $sections[$section_key+1] == 'social-links' ) {
				echo '<div ' . killarwt_stringify_atts( $footer_content_args ) . '>';
			}
			
			get_template_part( 'template-parts/post-loop/'. $section  );
			
			if ( !empty( $sections[$section_key-1] ) && $sections[$section_key-1] =='read-more' && $sections[$section_key] == 'social-links' ) {
				echo '</div>';
			}

			if ( $sections[0] == 'thumbnail' && end($sections) == $section ) {
				echo '</div>';
			}
			
		endforeach;
		
		if ( !empty( $show_row ) ) echo '</div>';
	?>
	</div>
	<?php do_action( 'killar_before_loop_post_end' ); ?>
</article>
<?php
do_action( 'killar_outer_after_loop_post_end', array( 'items_count' => $GLOBALS['items_count'], 'exclude_posts' => wp_list_pluck( $wp_query->posts, 'ID' ) ) );

if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && ( $GLOBALS['items_count'] % $nums_rows == ( $nums_rows-1 ) || ( $GLOBALS['items_count'] == ( $wp_query->post_count - 1) ) ) ) {
	echo '</div>';
}
$GLOBALS['items_count']++;