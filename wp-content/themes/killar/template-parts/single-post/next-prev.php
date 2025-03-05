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

if ( get_post_type() != 'post' ) {
	return;
}

$next_post = get_next_post();
$prev_post = get_previous_post();

do_action( 'killar_before_single_post_next_prev' );
if ( !empty( $prev_post ) || !empty( $next_post ) ) {
?>
<div class="entry-next-prev other-posts single-author-post">
	<div id="op-row" class="next-prev-sec row d-flex align-items-top my-5" >
		<div class="col-md-5">
		<?php if ( !empty( $prev_post ) ) { ?>
			<div class="prev-post mb-3">
				<a href="<?php echo esc_url( get_permalink($prev_post->ID) ); ?>" class="secondary-color text-uppercase me-1 d-inline-block mb-2">
					<span class="black-color me-2"><i class="fas fa-long-arrow-alt-left"></i></span><?php esc_html_e( 'Prev Post', 'killar' ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink($prev_post->ID) ); ?>"><h4 class="f-700"><?php echo get_the_title($prev_post->ID); ?></h4></a>
			</div>
		<?php } ?>
		</div>
		<div class="archive-link col-md-2 justify-content-center align-items-center d-flex">
			<a href="<?php echo esc_url( get_post_type_archive_link( get_post_type() ) ); ?>"><i class="fas fa-th-large fa-2x text-muted"></i></a>
		</div>
		<div class="col-md-5 text-end">
		<?php if ( !empty( $next_post ) ) { ?>
			<div class="next-post mb-3">	
				<a href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>" class="secondary-color text-uppercase me-1 d-inline-block mb-2">
					<?php esc_html_e( 'Next Post', 'killar' ) ?><span class="black-color ms-2"><i class="fas fa-long-arrow-alt-right"></i></span>
				</a>
				<a href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>"><h4 class="f-700"><?php echo get_the_title($next_post->ID); ?></h4></a>
			</div>
		<?php } ?>
		</div>
	</div>
</div>
<?php
}

do_action( 'killar_after_single_post_next_prev' );