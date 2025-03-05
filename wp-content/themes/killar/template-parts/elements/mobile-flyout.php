<?php
/**
 * Mobile FlyOut Sidebar
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<div id="offcanvasMobileFlyout"  class="mobile-menu-flyout white-bg offcanvas offcanvas-start px-3 py-2" aria-modal="true">
	<div class="offcanvas-header px-0">
		<div class="d-flex w-100 justify-content-between align-items-center">
			<h2 class="offcanvas-title d-flex align-items-center"><?php echo wp_kses_post( get_theme_mod( 'killar_mob_flyout_title' ) ); ?></h2>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
	</div>
	<?php if( apply_filters( 'killar_show_mob_header_search', get_theme_mod( 'killar_show_mob_header_search', true ) ) ) { ?>
	<div class="header-search-content mob-search my-3 w-100">
		<?php get_search_form();?>
	</div>
	<?php } ?>
	<div class="w-100 d-flex flex-column navigation-portrait">
		<?php do_action( 'killar_mob_header_navigation' ); ?>
	</div>
	<div class="mob-cust-layout mt-3">
		<?php echo killarwt_do_shortcode( 'killar_layout', array( 'id' => apply_filters( 'killar_mob_end_layout', get_theme_mod( 'killar_mob_end_layout' ) ) ) )?>
	</div>
</div>