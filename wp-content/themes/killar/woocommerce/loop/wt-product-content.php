<?php
/**
 * Product Content template
 *
 * @package KillarWT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;

?>
<div class="product-content card-footer border-0 bg-white px-1 pt-3 pb-0">
	
	<?php do_action( 'killar_before_loop_product_content' ); ?>
	
	<?php do_action( 'killar_loop_product_content_categories' ); ?>

	<?php do_action( 'killar_loop_product_content_title' ); ?>
	
	<?php do_action( 'killar_loop_product_content_rating' ); ?>

	<?php do_action( 'killar_loop_product_content_description' ); ?>
	
	<?php do_action( 'killar_loop_product_content_price' ); ?>
	
	<?php do_action( 'killar_loop_product_content_actions' ); ?>
	
	<?php do_action( 'killar_after_loop_product_content' ); ?>

</div>

