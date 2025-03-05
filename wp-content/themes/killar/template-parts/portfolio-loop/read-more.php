<?php
/**
 * Display Post
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_style = killarwt_get_loop_prop( 'killar_portfolio_loop_post_style' );
$read_more_style = killarwt_get_loop_prop( 'killar_portfolio_loop_post_read_more' );
if( empty( $read_more_style ) ) return;

$read_more_wrap_atts = array();
$read_more_wrap_atts['class'] = array( 'entry-read-more d-flex align-items-center' );
$read_more_link_atts = array();
$read_more_link_atts['href'] = esc_url( get_permalink( get_the_ID() ) );
$read_more_link_atts['class'] = array( 'read-more-'.$read_more_style );

if( in_array( $read_more_style, array( 'icon-plus-popup', 'icon-elink-popup' ) ) ) {
	$read_more_link_atts['class'][] = 'portfolio-ajx-action';
	$read_more_link_atts['data-toggle'] = 'modal';
	$read_more_link_atts['data-target'] = '#portfolio-'. get_the_ID();
}

if( in_array( $read_more_style, array( 'icon-plus-popup', 'icon-plus-link' ) ) ) {
	$read_more_wrap_atts['class'][] = 'project-content text-center position-absolute transition5 z-1';
	$read_more_link_atts['class'][] = 'text-white d-inline-block';
} else if( in_array( $read_more_style, array( 'icon-elink-popup', 'icon-elink-link' ) ) ) {
	$read_more_wrap_atts['class'][] = 'port-content text-center position-absolute transition5 z-1';
	$read_more_link_atts['class'][] = 'theme-color d-inline-block';
} else if( in_array( $read_more_style, array( 'link', 'button' ) ) ) {
	$read_more_wrap_atts['class'][] = 'mt-4';
}

if( in_array( $post_style, array( 'box3' ) ) ) {
	$read_more_link_atts['class'][] = 'btn btn-md btn-primary';
} else if( $read_more_style == 'button' ) {
	$read_more_link_atts['class'][] = 'btn btn-outline-primary btn-md font--medium rounded-5';
}
?>
<div <?php echo killarwt_stringify_atts( $read_more_wrap_atts ); ?>>
	<a <?php echo killarwt_stringify_atts( $read_more_link_atts ); ?>>
		<?php if ( in_array( $post_style, array( 'box3' ) ) ) { ?>
		<i class="fa-regular fa-circle-right"></i>
		<?php } else if( in_array( $read_more_style, array( 'icon-plus-popup', 'icon-plus-link' ) ) ) { ?>
		<i class="fas fa-plus"></i>
		<?php } else if( in_array( $read_more_style, array( 'icon-elink-popup', 'icon-elink-link' ) ) ) { ?>
		<i class="fas fa-external-link-alt"></i>
		<?php } else { ?>
		<?php echo esc_html__( 'Read More', 'killar' );?>
		<i class="fa-regular fa-circle-right ms-2"></i>
		<?php } ?> 
	</a>
</div>