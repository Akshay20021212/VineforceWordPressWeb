<?php
/**
 * Footer Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */
if( empty( $args['layout'] ) ) return;
?>
<footer <?php echo killarwt_stringify_atts( $args['atts'] ); ?>>
	<?php do_action( 'killar_before_footer' ); ?>
	<div class="footer-bottom py-3">
		<div class="copyright-area">
			<div class="container">
				<div class="row align-items-center justify-content-between">
					<div class="col-12">
						<div class="copyright-text text-center mt-20 mb-20">
							<p class="mb-0 secondary-color2"><?php echo wp_kses_post( apply_filters( 'killar_footer_copyright', get_theme_mod( 'killar_footer_copyright', 'Copyright &copy; 2023. All rights reserved.' ) ) ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php do_action( 'killar_after_footer' ); ?>
</footer>