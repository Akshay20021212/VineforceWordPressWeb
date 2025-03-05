<?php
/**
 * Product Image Slider
 *
 * @package KillarWT
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Globals
global $product;

$attachment_id = get_post_thumbnail_id();

// Get Second Image in Gallery
$attachment_ids   = $product->get_gallery_image_ids();

$attachments_count = count( $attachment_ids );

if ( $attachment_ids ) {
	$nums_imgs = get_theme_mod( 'killar_woo_loop_product_image_slider_slides' );
	$nums_imgs = (in_array( $nums_imgs, array(1,2,3,4,5))) ? ((int)$nums_imgs) : 3;
	
	$data_atts = array();
	$data_atts['class'] = 'products-slider items-cen-cont pnwt-slick-slider nav-on-hover';
	$data_atts['data-item'] = 1;
	$data_atts['data-lg'] = 1;
	$data_atts['data-md'] = 1;
	$data_atts['data-sm'] = 1;
	$data_atts['data-autoplay'] = ( !empty(get_theme_mod('killar_woo_loop_product_image_slider_autoplay') ) ) ? 1 : 0;
	$data_atts['data-autoplay-speed'] = get_theme_mod('killar_woo_loop_product_image_slider_autoplay_speed', 5000);
	$data_atts['data-infinite'] = (!empty(get_theme_mod('killar_woo_loop_product_image_slider_loop'))) ? 1 : 0;
	$data_atts['data-nav'] = (!empty(get_theme_mod('killar_woo_loop_product_image_slider_nav'))) ? 1 : 0;
	$data_atts['data-dots'] = (!empty(get_theme_mod('killar_woo_loop_product_image_slider_dots'))) ? 1 : 0;
		
?>
<div class="product-image">
	
	<?php do_action( 'killar_before_loop_product_image' ); ?>
	
	<div class="wt-owl-slider nav-on-hover owl-nav-cir owl-nav-small owl-carousel" <?php echo esc_attr( implode( ' ', $data_atts ) ); ?>>
		<div class="img-item">
			<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link prd-img-lnk">
			<?php echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', array( 'class' => 'prod-img attachment-shop-catalog wp-post-image', 'alt' => get_the_title()) );  ?>
			</a>
		</div>
		<?php
		$img_count = 0;
		if ( $attachments_count > 0 ) :
			foreach ( $attachment_ids as $attachment_id ) :
				$img_count++;
				if ( $img_count < $nums_imgs ) : ?>
					<div class="img-item">
						<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link prd-img-lnk">
							<?php echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', array( 'class' => 'prod-img attachment-shop-catalog wp-post-image', 'alt' => get_the_title()) );  ?>
						</a>
					</div>
				<?php
				endif;

			endforeach;

		endif;
		?>
	</div>
	
	<?php do_action( 'killar_after_loop_product_image' ); ?>
	
</div>

<?php
} else {
	wc_get_template(  'loop/thumbnail/default.php' );
}
?>