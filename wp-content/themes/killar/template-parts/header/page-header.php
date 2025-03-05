<?php
/**
 * Page Header
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! killarwt_display_page_title() ) {
	return;
}

$page_title = killarwt_page_title();
$page_title_bg = killarwt_page_title_background();

$show_title = ( !empty( $page_title ) && $page_title != 'hidden' ) ? true : false;

// Get header style
$style = killarwt_page_title_style();

$wrap_attr = array();
$wrap_attr['class'] = array( 'page-header page-title-wrap breadcrumb-wraps position-relative' );
$wrap_attr['class'][] = ( !empty( $style ) ) ? $style.'-page-header' : '';
$wrap_attr['class'][] = ( !empty( killarwt_page_title_background() ) ) ? 'bgimg-page-header' : '';

$page_title_attr = array();
if ( !empty( $show_title ) ) {
	$wrap_attr['class'][] = 'section';
	$page_title_attr['class'] = array( 'page-header-title text-capitalize f-700 mt-1 mb-2' );
} else {
	$wrap_attr['class'][] = 'py-3';
}

if( !empty( $page_title_bg ) && $page_title_bg == 'scene' ) {
	$wrap_attr['class'][] = 'scene-bg-header bg-cover bg-primary text-light';
}
?>
<?php do_action( 'killar_outer_before_page_header' ); ?>
<section <?php echo killarwt_stringify_atts( $wrap_attr ); ?> >
	<?php
		if ( $page_title_bg == 'scene' ) {
			$scene_ar = killarwt_page_title_scene();
			if( !empty( $scene_ar ) ) {
				foreach( $scene_ar as $k => $item ) {
					echo '<div '. killarwt_stringify_atts( $item['parent_div'] ) .'><img '. killarwt_stringify_atts( $item['image'] ) .' /></div>';
				}
			}
		}
	?>
	<?php do_action( 'killar_before_page_header' ); ?>
	<div class="single-page d-flex align-items-center text-center w-100">
		<div class="container">
			<div class="row">
				<div class="col col-xl-12 col-lg-12 col-12">
					<?php if ( !empty( $show_title ) ) { ?>
					<h1 <?php echo killarwt_stringify_atts( $page_title_attr ); ?>><?php echo wp_kses_post( $page_title ); ?></h1>
					<?php } ?>
					<?php if ( function_exists( 'killarwt_page_title_content' ) ) {
						echo killarwt_page_title_content();
					} ?>
				</div>
			</div>
		</div>
	</div>
	<?php do_action( 'killar_after_page_header' ); ?>
</section>
<?php do_action( 'killar_outer_after_page_header' ); ?>