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

global $product, $items_count, $woocommerce_loop;

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

$view_type = killarwt_get_loop_prop('killar_woo_loop_products_view_type');
$nums_rows = killarwt_get_loop_prop('nums_rows');
if ($nums_rows > 1 && (!in_array($view_type, array('grid', 'micro_grid'))) && $items_count % $nums_rows == 0) {
	echo '<div class="products">';
}
?>
<div <?php echo killarwt_woo_loop_product_atts(); ?>>
	<div class="wt-quickview wt-product-full-info">
		<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
			<?php
			/**
			 * Hook: woocommerce_before_single_product.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 */
			do_action('woocommerce_before_single_product');
			?>
			<div class="row">
				<?php if ( !empty( $args['show_image']  ) ) { ?>
				<div class="product-gallery col-12 col-sm-6">
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
						<div class="product-gallery-wrapper">
							<?php do_action('killar_before_product_gallery_wrapper'); ?>
							<div class="product-gallery-image no-zoom items-cen-cont kwt-slick-slider nav-slider-middle" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "fade":true, "dots" : false, "responsive":[{"breakpoint": 992,"settings":{"slidesToShow": 1}}] }'>
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
				<?php } ?>
				<div class="product-summary <?php echo (!empty($args['show_image'])) ? 'col-12 col-sm-6' : ''; ?>">
					<div class="product-inner-summary summary entry-summary">
						<?php
						do_action('killar_before_woo_single_product_summery');

						if (!empty($args['show_title']) && function_exists('woocommerce_template_single_title')) {
							echo woocommerce_template_single_title();
						}
						if (!empty($args['show_ratings']) && function_exists('woocommerce_template_single_rating')) {
							echo woocommerce_template_single_rating();
						}
						if (!empty($args['show_price']) && function_exists('woocommerce_template_single_price')) {
							echo woocommerce_template_single_price();
						}
						if (!empty($args['show_short_description']) && function_exists('woocommerce_template_single_excerpt')) {
							echo woocommerce_template_single_excerpt();
						}
						if (!empty($args['show_addtocart']) && function_exists('woocommerce_template_single_add_to_cart')) {
							echo woocommerce_template_single_add_to_cart();
						}
						if (!empty($args['show_meta']) && function_exists('woocommerce_template_single_meta')) {
							echo woocommerce_template_single_meta();
						}
						if (!empty($args['show_sharing']) && function_exists('woocommerce_template_single_sharing')) {
							echo woocommerce_template_single_sharing();
						}
						if (!empty($args['show_product_link'])) {
							echo sprintf(
								'<a href="%s" class="%s">%s</a>',
								esc_url(get_permalink(get_the_ID())),
								esc_attr(isset($args['class']) ? $args['class'] : 'button mt-2'),
								esc_html__('View Product', 'killar')
							);
						}

						do_action('killar_after_woo_single_product_summery');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if ($nums_rows > 1 && (!in_array($view_type, array('grid', 'micro_grid'))) && ($items_count % $nums_rows == ($nums_rows - 1) || ($items_count == ($woocommerce_loop['total'] - 1)))) {
	echo '</div>';
}
$items_count++;
