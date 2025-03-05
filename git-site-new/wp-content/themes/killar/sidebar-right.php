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
?>
<aside <?php echo killarwt_sidebar_atts(); ?>>
	<div class="sidebar-inner">
	<?php
	if ( $sidebar ) {
		dynamic_sidebar( $sidebar );
	} ?>
	</div>
</aside>