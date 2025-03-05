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

$args = array();
$args['class'][] = 'entry-title display-6 font--bold pb-3 pb-md-4';
$args['class'][] = ( killarwt_get_post_meta( 'portfolio_single_layout' ) == 'compact' ) ? 'col-xl-10 offset-xl-1' : '';

the_title( '<h1 '. killarwt_stringify_atts( $args ) .'>', '</h1>' );