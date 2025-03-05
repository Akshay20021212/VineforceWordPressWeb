<?php
/**
 * Loop Product : Content Actions Template
 *
 * @package KillarWT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php do_action( 'killar_outer_before_loop_product_content_actions' ); ?>

<div class="product-actions">

	<?php do_action( 'killar_before_loop_product_content_actions' ); ?>
	
	<?php do_action( 'killar_loop_product_content_actions_content' ); ?>
	
	<?php do_action( 'killar_after_loop_product_content_actions' ); ?>
	
	<?php echo 'content'; ?>

</div>

<?php do_action( 'killar_outer_after_loop_product_content_actions' ); ?>

