<?php
/**
 * The Footer for our theme.
 *
 * @package KillarWT
 * @since 1.0.0
 */
?>
		<?php do_action( 'killar_after_main' );  ?>
	</div>
	<?php do_action( 'killar_after_outer_main' ); ?>
	<?php do_action( 'killar_footer' ); ?>
	<?php do_action( 'killar_after_main_wrap' ); ?>
</div>
<?php do_action( 'killar_after_site' ); ?>
<?php wp_footer(); ?>
<?php do_action( 'killar_before_body_end' ); ?>
</body>
</html>