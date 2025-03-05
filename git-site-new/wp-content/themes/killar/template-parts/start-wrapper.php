<?php
/**
 * Before Content Wrapper
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<?php do_action( 'killar_before_content_wrap' ); ?>
<section <?php echo killarwt_main_section_atts(); ?>>
	<div id="content-wrap" class="container content-wrap">
		<?php do_action( 'killar_before_primary' ); ?>
		<div class="row justify-content-between">
			<div <?php echo killarwt_primary_col_atts(); ?>>
				<?php do_action( 'killar_before_content' ); ?>
				<div id="content" class="site-content">
					<?php do_action( 'killar_before_content_inner' ); ?>