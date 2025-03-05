<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$atts = array();

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$atts['class']   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

$atts['data-columns'] = $columns;

?>
<div <?php echo killarwt_stringify_atts( $atts ); ?>>
	<figure class="woocommerce-product-gallery__wrapper">
		<div class="product-gallery-wrapper shop_thumb p-3 gray-simple rounded-4 mb-4">
			<?php do_action( 'killar_before_product_gallery_wrapper' ); ?>
			<div class="product-gallery-image ewt-slick-slider nav-slider-middle nav-on-hover" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "asNavFor": ".product-gallery-thumbnails", "fade":true, "dots" : false, "responsive":[{"breakpoint": 992,"settings":{"slidesToShow": 1}}] }'>
		<?php
		if ( $post_thumbnail_id ) {
			$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
		} else {
			
			$wrapper_classname = $product->is_type( 'variable' ) && ! empty( $product->get_available_variations( 'image' ) ) ?
				'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
				'woocommerce-product-gallery__image--placeholder';
			$html = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'killar' ) );
			$html .= '</div>';
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

		do_action( 'woocommerce_product_thumbnails' );
		?>
	</div>
			<?php echo (killarwt_woo_single_prod_gal_lightbox()) ?	'<a href="#" class="woocommerce-product-gallery__trigger"><i class="fa fas fa-expand-arrows-alt"></i></a>' : ''; ?>
			<?php do_action( 'killar_afer_product_gallery_wrapper' ); ?>
		</div>
		<div class="product-gallery-thumbnails ewt-slick-slider nav-slider-middle nav-on-hover" data-slick='{"slidesToShow":4,"slidesToScroll": 1,"asNavFor": ".product-gallery-image","arrows": true, "dots" : false, "focusOnSelect": true, "vertical": <?php echo (killarwt_woo_single_prod_image_gal_layout() == 'ver') ? 'true': 'false'; ?>, "responsive":[{"breakpoint": 992,"settings":{"slidesToShow": 4, "vertical":false }}]}'>
			<?php do_action( 'killar_before_product_gallery_thumbnails' ); ?>
			<?php 
				$attachment_ids = $product->get_gallery_image_ids();

				if ( $attachment_ids && $post_thumbnail_id ) {
					$attachment_ids = array_merge(array($post_thumbnail_id), $attachment_ids);
					foreach ( $attachment_ids as $attachment_id ) {
						$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
						$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
						$image_size        = apply_filters( 'woocommerce_gallery_image_size', $thumbnail_size );
						$thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
						$alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
						$image             = wp_get_attachment_image(
							$attachment_id,
							$image_size
						);
						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="gal-thumb">' . $image . '</div>', $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
					}
				}
			?>
			<?php do_action( 'killar_after_product_gallery_thumbnails' ); ?>
		</div>
	</figure>
</div>
