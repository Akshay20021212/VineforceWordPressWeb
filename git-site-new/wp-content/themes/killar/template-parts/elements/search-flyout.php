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
<div class="modal auto-off fade" id="search" tabindex="-1" role="dialog" aria-label="searchmodal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered search-pop-form" role="document">
		<div class="modal-content" id="searchmodal">
			<div class="modal-header">
				<?php get_search_form();?>
			</div>
		</div>
	</div>
</div>