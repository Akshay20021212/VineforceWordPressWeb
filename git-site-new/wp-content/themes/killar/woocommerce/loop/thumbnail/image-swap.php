<?php
/**
 * Product Swap Image
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


$attachment_ids[] = $attachment_id; // Add featured image to the array

$secondary_img_id = '';

if ( ! empty( $attachment_ids ) ) {
	$attachment_ids = array_unique( $attachment_ids ); // remove duplicate images
	if ( count( $attachment_ids ) > '1' ) {
		if ( $attachment_ids['0'] !== $attachment_id ) {
			$secondary_img_id = $attachment_ids['0'];
		} elseif ( $attachment_ids['1'] !== $attachment_id ) {
			$secondary_img_id = $attachment_ids['1'];
		}
	}
}

$swap_lnk_classes = array();

if ( !empty( $secondary_img_id ) ) {
	$swap_style = killarwt_get_loop_prop( 'killar_woo_loop_product_image_swap_style' );
	
	$swap_style = $swap_style ? $swap_style : 'swap';
	$swap_lnk_classes[] = ($swap_style) ? 'image-'.$swap_style.'-effect' : '';

}

?>
<div class="product-image">
	
	<?php do_action( 'killar_before_loop_product_image' ); ?>
	
	<a class="<?php echo esc_attr( implode( ' ', $swap_lnk_classes ) ); ?>" href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link prd-img-lnk">
		<?php
		if ( $secondary_img_id ) {
			
			echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', array( 'class' => 'prod-img attachment-shop-catalog wp-post-image primary', 'alt' => get_the_title()) ); 
			
			echo wp_get_attachment_image( $secondary_img_id, 'shop_catalog', '', array( 'class' => 'prod-img attachment-shop-catalog wp-post-image secondary', 'alt' => get_the_title()) ); 
		
		} else {
		
			if ( $attachment_id ) { 
				echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', array( 'class' => 'prod-img attachment-shop-catalog wp-post-image', 'alt' => get_the_title()) ); 
			} else { 
				echo ( wc_placeholder_img_src() ) ? wc_placeholder_img() : '';
			}
		}
		?>
	</a>
	
	<?php do_action( 'killar_after_loop_product_image' ); ?>
	
</div>