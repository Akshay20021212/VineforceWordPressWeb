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

$post_style = killarwt_get_loop_prop( 'killar_portfolio_loop_post_style' );	
$title_attr = array();
$title_attr['class'] = array( 'entry-title h5 mb-2 mt-2' );

$view_type = killarwt_portfolio_loop_view_type();
if ( in_array( $view_type, array( 'list-light', 'list-dark' ) ) ) {
	$title_attr['class'] = array( 'entry-title mb-3 lh-base' );
}

$title_html_tag = 'h2';
if ( in_array( $post_style, array( 'box3' ) ) ) {
	$title_html_tag = 'h5';
	$title_attr['class'] = 'font--bold fs-6 mb-2';
} else if ( in_array( $post_style, array( 'box1', 'box2' ) ) ) {
	$title_attr['class'] = 'text-white color-inherit fs-4';
}

the_title( sprintf( '<' . $title_html_tag . ' ' . killarwt_stringify_atts( $title_attr ) .'><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></' . $title_html_tag.'>' );