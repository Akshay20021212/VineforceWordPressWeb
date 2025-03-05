<?php
/**
 * Display Post Next/Prev Links
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( get_post_type() != 'portfolio' ) {
	return;
}

$next_post = get_next_post();
$prev_post = get_previous_post();

do_action( 'killar_before_portfolio_single_post_next_prev' );
if ( !empty( $prev_post ) || !empty( $next_post ) ) {
?>
<div class="entry-next-prev other-posts">
	<div id="op-row" class="next-prev-sec row d-flex align-items-top my-5">
		<div class="col-md-5">
		<?php if ( !empty( $prev_post ) ) { ?>
			<div class="prev-post mb-3">				
				<h4 class="f-700"><?php esc_html_e( 'Previous Post', 'killar' ) ?></h4>
				<a href="<?php echo esc_url( get_permalink($prev_post->ID) ); ?>" rel="next"><?php echo get_the_title($prev_post->ID); ?></a>
			</div>
		<?php } ?>
		</div>
		<div class="archive-link col-md-2 justify-content-center align-items-center d-flex">
			<a href="<?php echo esc_url( get_post_type_archive_link( get_post_type() ) ); ?>"><span class="fal fa-th-large fa-2x text-muted"></span></a>
		</div>
		<div class="col-md-5 text-end">
		<?php if ( !empty( $next_post ) ) { ?>
			<div class="next-post mb-3">		
				<h4 class="f-700"><?php esc_html_e( 'Next Post', 'killar' ) ?></h4>
				<a href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>" rel="next"><?php echo get_the_title($next_post->ID); ?></a>
			</div>
		<?php } ?>
		</div>
	</div>
</div>
<?php
}

do_action( 'killar_after_portfolio_single_post_next_prev' );