<?php
/**
 * Displays related portfolio
 *
 * @package KillarWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_singular('portfolio') && function_exists( 'killarwt_post_related_portfolio' ) )   {

	$portfolio = killarwt_post_related_portfolio();
	if( !empty( $portfolio ) ) {
		$title = get_theme_mod( 'killar_portfolio_single_post_related_title');
		$sub_title = get_theme_mod( 'killar_portfolio_single_post_related_sub_title');
		?>
		<section class="section gray-simple">
			<div id="content-wrap" class="container content-wrap">
				<div class="row justify-content-center">
					<div class="col-xl-6 col-lg-10 col-md-12 col-sm-12 mb-5">
						<?php if( !empty( $sub_title ) || !empty( $title ) ) { ?>
						<div class="sec-heading center">
							<?php if( !empty( $sub_title ) ) { ?>
								<div class="d-inline-flex px-4 py-1 rounded-5 text-info bg-light-info font--medium mb-2"><span><?php echo wp_kses_post( $sub_title ); ?></span></div>
							<?php } ?>
							<?php if( !empty( $title ) ) { ?>
								<h2><?php echo wp_kses_post( $title ); ?></h2>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="row justify-content-center gy-xl-5 gy-lg-4 gy-5 gx-xl-5 gx-lg-4 gx-3">
				<?php echo wp_kses_post( $portfolio ); ?>
				</div>
			</div>
		</section>
	<?php
	}
}
?>
