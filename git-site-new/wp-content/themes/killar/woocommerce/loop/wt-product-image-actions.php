<?php
/**
 * Loop Product : Image Actions Template
 *
 * @package KillarWT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php do_action( 'killar_outer_before_loop_product_image_actions' ); ?>

<div class="product-actions">

	<?php do_action( 'killar_before_loop_product_image_actions' ); ?>
	
	<?php do_action( 'killar_loop_product_image_actions_content' ); ?>
	
	<?php do_action( 'killar_after_loop_product_image_actions' ); ?>

</div>

<?php do_action( 'killar_outer_after_loop_product_image_actions' ); ?>

