<?php
/**
 * Post Title
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$view_type = killarwt_get_loop_prop( 'killar_blog_loop_view_type' );
$post_style = killarwt_get_loop_prop( 'killar_blog_loop_post_style' );

$title_attr = array();
$title_attr['class'] = array( 'article-heads font--bold mb-1' );
$title_html_tag = 'h4';
if( in_array( $post_style, array( 'box' ) ) ) {
	$title_attr['class'][] = 'mb-0 text-white';
} else if( in_array( $post_style, array( 'modern' ) ) ) {
	$title_html_tag = 'h3';
} else if( in_array( $view_type, array( 'full', 'modern' ) ) ) {
	$title_html_tag = 'h3';
} else {
	$title_attr['class'][] = 'mb-22';
}

the_title( sprintf( '<'. $title_html_tag . ' class="entry-title"><a href="%s" ' . killarwt_stringify_atts( $title_attr ) .' rel="bookmark">', esc_url( get_permalink() ) ), '</a></' . $title_html_tag . '>' );