<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package KillarWT
 * @since 1.0.0
 */

$sidebar = killarwt_get_sidebar_name();

// Retunr if full width or full screen
if ( !is_active_sidebar( $sidebar ) &&  in_array( killarwt_get_layout(), array( 'full-width' ) ) ) {
	return;
}

$inner_sidebar_atts = [];
$inner_sidebar_atts['class'] = ['sidebar-inner'];
?>
<aside <?php echo killarwt_sidebar_atts(); ?>>
	<?php
	//is catalog woo layout
	if ( !empty( killarwt_is_woo_layout() )  ) {
		$inner_sidebar_atts['class'][] = 'offcanvas-body pt-0 pe-lg-4';	
	?>
	<div class="offcanvas-header">
		<h5 class="offcanvas-title"><?php echo esc_html__( 'Filters', 'killar' ); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="offcanvas" data-bs-target="#Sidebarshop"></button>
	</div>
	<?php }	?>
	<div <?php echo killarwt_stringify_atts( $inner_sidebar_atts ); ?>>
	<?php
	if ( $sidebar ) {
		dynamic_sidebar( $sidebar );
	} ?>
	</div>
</aside>
