<?php
/**
 * Page Header v2
 *
 * @package KillarWT
 * @since 1.0.0
 */

$atts = array();
$atts['id'] = 'header';
$atts['class'] = apply_filters( 'killar_header_classes', array( 'header header-v2 header-wrapper change-logo' ) );
$atts = apply_filters( 'killar_header_atts', $atts );
?>
<header <?php echo killarwt_stringify_atts( $atts ); ?>>
	<?php do_action( 'killar_topbar' ); ?>
	<div class="header-mid-area header-wrap menu">
		<div class="container header-container menu-container">
			<div id="navigation" class="navigation navigation-landscape">
				<div class="nav-header">
					<?php do_action( 'killar_header_logo' ); ?>
					<?php do_action( 'killar_mobile_header_right_content' ); ?>
				</div>
				<div class="main-menu nav-menus-wrapper">
					<?php do_action( 'killar_header_primary_navigation' ); ?>
					<?php do_action( 'killar_header_right_content' ); ?>
				</div>
			</div>
		</div>
	</div>
</header>