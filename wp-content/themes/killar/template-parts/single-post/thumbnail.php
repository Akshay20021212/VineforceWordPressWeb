<?php
/**
 * Single Post Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$args = array();
$args['class'][] = 'entry-thumbnail-wrapper';
$args['class'][] = 'blog-post-img';
$args['class'][] = 'mb-3';

$image_size = killarwt_get_loop_prop( 'killar_blog_loop_post_image_size' );
$fancy_date = killarwt_get_loop_prop( 'killar_blog_loop_post_fancy_date' );
?>
<?php if ( has_post_thumbnail()) : ?>
<div <?php echo killarwt_stringify_atts( $args ); ?>>
	<?php
	$post_image = killarwt_get_post_thumbnail( $image_size ); 
	if ( !empty( $post_image ) ) {
		echo '<a href="' . esc_url( get_the_permalink() ) . '"> ' . wp_kses_post( $post_image ) . '</a>';
	}
	if ( $fancy_date ) {
		echo sprintf( '<div class="date-tag"><span class="date-time">%s</span></div>', esc_html( get_the_date( 'M d' ) ) );
	}
	?>
</div>
<?php endif; ?>