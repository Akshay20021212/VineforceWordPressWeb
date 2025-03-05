<?php
/**
 * Single Post Content
 *
 * @package KillarWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$view_type = killarwt_get_loop_prop( 'killar_blog_loop_view_type' );
$display_type = killarwt_get_loop_prop( 'killar_blog_loop_display_type' );
$content_type = apply_filters( 'killar_blog_loop_post_content', killarwt_get_loop_prop( 'killar_blog_loop_post_content' ) );
if ( ( is_singular( 'post' ) && !in_array( $display_type, array('widget') ) ) && !in_array( $view_type, array( 'slider', 'grid' ) ) ) {
	$content_type = 'full';
}

$content_attr = array();
$content_attr['class'] = array( 'entry-content article-desc' );
if( !in_array( $display_type, array( 'grid', 'related_posts' ) ) || !in_array( $view_type, array( 'slider', 'grid' ) ) ) {
	$content_attr['class'][] = 'mb-0';
}

?>
<div <?php echo killarwt_stringify_atts( $content_attr ); ?>>
	<?php
	
	if ( $content_type == 'excerpt' ) {
		
		if ( has_excerpt() && ! empty( $post->post_excerpt ) ) {
			$content = get_the_excerpt();
		} else {
			$content = get_the_content();
		}
		$content = killarwt_content_limit( $content, apply_filters( 'killar_blog_loop_post_excerpt_length', killarwt_get_loop_prop( 'killar_blog_loop_post_excerpt_length' ) ) );
		
	} else {
		$content = get_the_content(); 
	}
	
	echo apply_filters( 'killar_blog_loop_content', $content );
		
	if ( $content_type == 'full' ) {
		wp_link_pages(
			array(
				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'killar' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);
	}
	?>	
</div>
