<?php
/**
 * Advance Navigation Sidebar
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-label="offcanvasScrollingLabel" aria-modal="true">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="offcanvasScrollingLabel"><?php echo esc_html__( 'Advance Navigation', 'killar' ); ?></h5>
		<a href="#" data-bs-dismiss="offcanvas" aria-label="Close">
			<span class="svg-icon text-primary svg-icon-2hx">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"></rect>
					<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"></rect>
					<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"></rect>
				</svg>
			</span>
		</a>
	</div>
	<div class="offcanvas-body">
		<?php echo killarwt_do_shortcode( 'killar_layout', array( 'id' =>  killarwt_show_advance_navigation() ) )?>
	</div>
</div>