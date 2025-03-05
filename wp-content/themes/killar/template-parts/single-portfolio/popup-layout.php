<?php
/**
 * Portfolio Popup Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$sections = killarwt_portfolio_popup_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}

$classes[] = 'item-entry';
$classes[] = 'portfolio-popup';
$classes[] = 'single_portfolio';
$classes[] = 'single-portfolio-wrapper';
$classes[] = 'single-post-txt';
if( !empty( $portfolio_single_layout = killarwt_get_post_meta( 'portfolio_single_layout' ) ) ) $classes[] = 'portfolio-layout-'. $portfolio_single_layout;
?>
<?php do_action( 'killarwt_before_single_portfolio_content' ); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div id="single-portfolio" class="entry-post">
	<?php do_action( 'killarwt_before_single_portfolio_inner_content' ); ?>
		<div class="row">
			<div class=" col-12">
				<?php killarwt_get_template( 'template-parts/single-portfolio/title'  ); ?>
				<?php killarwt_get_template( 'template-parts/single-portfolio/content'  ); ?>
				<?php killarwt_get_template( 'template-parts/single-portfolio/highlights', array( 'show_read_more_button' => true )  ); ?>
			</div>
		</div>
		<div class="pro-modal-footer mt-30 mb-45">
			<div class="row">
				<div class="col-12 post-share-links d-flex align-items-center justify-content-md-between">
					<?php killarwt_get_template( 'template-parts/single-portfolio/skills'  ); ?>
					<?php killarwt_get_template( 'template-parts/single-portfolio/social-links'  ); ?>
				</div>
			</div>
		</div>
		<?php do_action( 'killarwt_after_single_portfolio_inner_content' ); ?>
	</div>
</div>
<?php do_action( 'killarwt_after_single_portfolio_content' ); ?>