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

$image_size = killarwt_get_loop_prop( 'killar_blog_loop_post_image_size' );
$view_type = killarwt_get_loop_prop( 'killar_blog_loop_view_type' );
$post_style = killarwt_get_loop_prop( 'killar_blog_loop_post_style' );

$args = array();
$args['class'][] = 'entry-thumbnail-wrapper overflow-hidden';
if( $post_style == 'modern' || in_array( $view_type, array( 'modern', 'list' ) ) ) {
	$args['class'][] = 'blog-page3-img position-relative transition5';
} else {
	$args['class'][] = 'blog-img';
}

?>
<?php if ( has_post_thumbnail()) : ?>
<?php
if ( in_array( $view_type, array( 'list' ) ) || in_array( $post_style, array( 'verticle-blog' ) ) ) {
	$args['class'][] = 'col-sm-6';
} else if ( in_array( $view_type, array( 'modern' ) ) ) {
	$args['class'][] = 'col-xl-5 col-lg-5 col-md-6 col-sm-12 col-12';
}
?>
<div <?php echo killarwt_stringify_atts( $args ); ?>>
	<?php
	$post_image = killarwt_get_post_thumbnail( $image_size, 'img-fluid rounded-2' );
	if( $post_style == 'modern' ) {
		$post_image .= '<div class="blog-port-hover-icon text-center position-absolute transition5 z-index11"><span class="white-color d-inline-block"><i class="fas fa-plus"></i></span></div>';
	}
	if ( !empty( $post_image ) ) {
		echo '<a href="' . esc_url( get_the_permalink() ) . '"> ' . wp_kses_post( $post_image ) . '</a>';
	}
	?>
</div>
<?php endif; ?>
