<?php
/**
 * Displays Hightlists
 *
 * @package KillarWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$highlights = killarwt_get_post_meta( 'portfolio_highlights' );
if( !empty( $highlights ) ) {
	?>
	<div class="entry-highlight meta-wrapper primary-bg portfolio-highlights pt-40 pb-45 pr-20 pl-45 mt-20">
		<ul class="item-meta no-list-style mb-0">
			<?php foreach( $highlights as $key => $highlight ) {
				if( !empty( $highlight['_killar_portfolio_highlights_title'] ) && !empty( $highlight['_killar_portfolio_highlights_value'] ) ) { ?>
				<li>
					<span class="mt-title"><?php echo wp_kses_post( $highlight['_killar_portfolio_highlights_title'] ); ?>&nbsp;:</span>
					<span class="mt-value pl-2 black-color f-700"><?php echo wp_kses_post( wp_kses_post( $highlight['_killar_portfolio_highlights_value'] ) ); ?><span>
				</li>
			<?php }
			} ?>
		</ul>
		<?php if( !empty( $show_read_more_button ) ) { ?>
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="btn btn-custom btn-theme position-relative over-hidden theme-bg tra-theme-hover theme-border2 text-uppercase mt-30 pt-2 pb-2"><?php esc_html_e( 'View Live', 'killar' ); ?></a>
		<?php } ?>
	</div>
	<?php
}
