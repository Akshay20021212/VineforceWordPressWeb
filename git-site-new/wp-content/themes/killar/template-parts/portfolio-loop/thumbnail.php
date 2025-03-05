<?php
/**
 * Single Portfolio Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( has_post_thumbnail()) :

$post_style = killarwt_get_loop_prop( 'killar_portfolio_loop_post_style' );
$image_size = killarwt_get_loop_prop( 'killar_portfolio_loop_post_image_size' );
$view_type = killarwt_portfolio_loop_view_type();

$args = array();
$args['class'][] = 'entry-thumbnail-wrapper portfolio-post-img overflow-hidden';
if ( ( in_array( $view_type, array( 'list-light', 'list-dark' ) ) ) ) {
	$args['class'][] = 'col-xl-5 col-lg-5 col-md-12 col-sm-12';
} else if ( ( in_array( $view_type, array( 'modern' ) ) ) ) {
	$args['class'][] = 'col-lg-8';
}

$image_classes = 'img-fluid rounded-4';
if ( in_array( $post_style, array( 'box3' ) ) ) {
	$args['class'][] = 'position-relative mx-auto mb-3';
	$image_classes = 'img-fluid rounded-2';
}

?>
<div <?php echo killarwt_stringify_atts( $args ); ?>>
	<?php
		$post_image = ( !empty( get_post_thumbnail_id() ) ) ? killarwt_get_post_thumbnail( $image_size, $image_classes ) : '<img class="img-fluid rounded-4" src="' . killarwt_placeholder_img_src( $image_size, KILLARWT_IMAGES_DIR_URI. 'placeholder-portfolio.png' ) . '" />';
		if ( !empty( $post_image ) ) {
			echo '<a href="' . esc_url( get_the_permalink() ) . '"> ' . wp_kses_post( $post_image ) . '</a>';
		}
	?>
</div>
<?php endif; ?>