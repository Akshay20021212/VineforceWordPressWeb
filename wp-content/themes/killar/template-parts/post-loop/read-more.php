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
$post_style = killarwt_get_loop_prop( 'killar_blog_loop_post_style' );
if( empty( $read_more_style ) ) return;
$classes = array( 'read-more-'.$read_more_style, 'font--bold' );
if( in_array( $post_style, array( 'box' ) ) ) {
	$classes[] = 'text-white';
} else {
	$classes[] = 'text-seegreen';
}
?>
<div class="entry-read-more article-links mt-3 <?php echo esc_attr( ( $post_style == 'gallery' || $read_more_style == 'icon' )? 'post-link ico-20' : '' ); ?>">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) );?>" class="<?php echo killarwt_stringify_classes( $classes ); ?>">
		<?php if( $read_more_style == 'icon' ) { ?>
		<span class="fa fas fa-arrow-right-long"></span>
		<?php } else { ?>
		<?php echo esc_html__( 'Continue Reading', 'killar' );?><i class="fa-solid fa-arrow-right ms-1"></i>
		<?php } ?>
	</a>
</div>