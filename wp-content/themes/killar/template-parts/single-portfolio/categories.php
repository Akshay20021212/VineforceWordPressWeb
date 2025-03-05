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

$categories_obj = wp_get_object_terms(get_the_ID(), 'portfolio-cat' );
if ( $categories_obj ) {

	$color_ar = array( 'success', 'warning', 'danger', 'info' );

	$html = '<div class="poftfolio-cats mb-3">';

	foreach( $categories_obj as $k => $category ) {

		$rand_key = array_rand( $color_ar );

		$args = array();
		$args['class'] = array('label mb-2 me-2');
		$args['class'][] = ( killarwt_get_post_meta( 'portfolio_single_layout' ) == 'compact' ) ? 'col-xl-10 offset-xl-1' : '';
		$args['class'][] = 'text-'. $color_ar[$rand_key] .' bg-light-'. $color_ar[$rand_key] .'';

		$args['href'] = esc_url( get_category_link( $category->term_id ) );

		$html .= '<a '. killarwt_stringify_atts( $args ) . '>' . esc_html( $category->name ) . '</a>';
	}

	$html .= '</div>';

	echo wp_kses_post( $html );
}