<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;
// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}

$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters('woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ($product->get_image_id() ? 'with-images' : 'without-images'),
	'woocommerce-product-gallery--columns-' . absint($columns),
	'images',
));
wp_enqueue_script('wc-add-to-cart-variation');
?>
<div class="woocommerce">
	<div class="wt-quickview quickview-wrap-<?php echo esc_attr(the_ID()); ?> product">
		<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
			<div class="row mx-0">
				<div class="product-gallery col-12 col-sm-6 px-0">
					<?php
					/**
					 * Hook: woocommerce_before_single_product_summary.
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					//do_action( 'woocommerce_before_single_product_summary' );
					?>
					<figure class="woocommerce-product-gallery__wrapper mb-0">
						<div class="product-gallery-wrapper overflow-hidden">
							<?php do_action('killar_before_product_gallery_wrapper'); ?>
							<div class="product-gallery-image no-zoom items-cen-cont kwt-slick-slider nav-slider-middle nav-on-hover" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "fade":true, "dots" : false, "responsive":[{"breakpoint": 992,"settings":{"slidesToShow": 1}}] }'>
								<?php
								if ($product->get_image_id()) {
									$html = wc_get_gallery_image_html($post_thumbnail_id, true);
								} else {
									$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_attr__('Awaiting product image', 'killar'));
									$html .= '</div>';
								}
								echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
								do_action('woocommerce_product_thumbnails');
								?>
							</div>
							<?php do_action('killar_afer_product_gallery_wrapper'); ?>
						</div>
					</figure>
				</div>
				<div class="product-summary col-12 col-sm-6">
					<div class="product-inner-summary summary entry-summary">
						<?php
						/**
						 * Hook: woocommerce_single_product_summary.
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 * @hooked WC_Structured_Data::generate_product_data() - 60
						 */
						do_action('woocommerce_single_product_summary');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>