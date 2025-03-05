<?php
/**
 * Product Featured Image
 *
 * @package KillarWT
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$attachment_id = get_post_thumbnail_id();
?>
<div class="product-image card-body p-3 rounded-4 gray-simple">
	
	<?php do_action( 'killar_before_loop_product_image' ); ?>
	
	<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link prd-img-lnk">
		<?php 
		if ( $attachment_id ) { 
			echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', array( 'class' => 'prod-img attachment-shop-catalog wp-post-image', 'alt' => get_the_title()) ); 
		} else { 
			echo ( wc_placeholder_img_src() ) ? wc_placeholder_img() : '';
		}
		?>
	</a>
	
	<?php do_action( 'killar_after_loop_product_image' ); ?>
	
</div>