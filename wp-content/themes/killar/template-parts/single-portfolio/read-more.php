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

$read_more_style = killarwt_get_loop_prop( 'killar_blog_loop_post_read_more' );
if( empty( $read_more_style ) ) return;
$classes =array( 'read-more-'.$read_more_style );
if( $read_more_style == 'button' ) {
	$classes[] = 'btn button';
}
?>
<div class="entry-read-more">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) );?>" class="<?php echo killarwt_stringify_classes( $classes ); ?>"><?php echo esc_html__( 'Read More', 'killar' );?> </a>
</div>