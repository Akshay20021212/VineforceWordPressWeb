<?php
/**
 * Displays the post entry categories
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$post_style = killarwt_get_loop_prop( 'killar_blog_loop_post_style' );
$classes = array( 'd-inline-flex label  mb-2' );

$color_ar = array( 'success', 'warning', 'danger', 'info' );

$categories = get_the_category();
if( !empty( $categories[0]->term_id ) ) {

	if( in_array( $post_style, array( 'box' ) ) ) {
		$classes[] = 'text-black bg-light';
	} else {
		$rand_key = array_rand( $color_ar );
		$classes[] = 'text-'. $color_ar[$rand_key] .' bg-light-'. $color_ar[$rand_key] .'';
	}

	echo '<div class="post-categories"><a class="'. killarwt_stringify_classes( $classes ) . '" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></div>';
}