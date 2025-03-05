<?php
/**
 * Header Top Bar
 *
 * @package KillarWT
 * @since 1.0.0
 */
?>
<div class="header-topbar d-none d-xl-block d-lg-block">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 tbh-col top-header-left topbar-storeinfo">
				<?php if ( !empty( killarwt_topbar_store_info() ) ) {
						killarwt_get_template( 'template-parts/elements/store-info', array('store_info' => killarwt_topbar_store_info(), 'store_info_vals' => get_theme_mod( 'killar_topbar_store_info' ) ) );
					} ?>
			</div>
			<div class="col-lg-7 text-right top-header-right">
				<div class="topbar-social tbh-col topbar-links kwt-nav kwt-nav-rbor">
					<?php killarwt_get_template( 'template-parts/elements/topbar-menu', array( 'location' => 'topbar-menu' ) ); ?>
					<?php if ( function_exists( 'social_buttons' ) && get_theme_mod( 'killar_topbar_social', true ) ) { ?>
						<?php echo social_buttons( array( 'display_type' => 'widget', 'social_links' => killarwt_topbar_social_links(), 'el_class' => 'mb-0' ) ); ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>