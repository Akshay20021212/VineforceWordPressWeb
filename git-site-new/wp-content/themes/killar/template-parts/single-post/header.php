<?php
/**
 * Single Post Header
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<header class="entry-header">
<?php	
	do_action( 'killar_before_post_header' );

	do_action( 'killar_post_header' );

	do_action( 'killar_after_post_header' );
?>
</header>