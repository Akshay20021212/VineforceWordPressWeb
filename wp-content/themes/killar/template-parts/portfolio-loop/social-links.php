<?php
/**
 * Displays social buttons
 *
 * @package KillarWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="entry-social">
	<?php
	if( function_exists( 'social_buttons' ) ) {
		echo social_buttons( array(
			'display_type'	=> 'shortcode',
			'title' 		=> ( apply_filters( 'killar_social_share_links_title', get_theme_mod( 'killar_social_share_links_title', 'true' ) ) ) ? esc_attr__( 'Share :', 'killar' ) : '' ,
			'social_type' 	=> 'share',
			'social_links'	=> ctm_killar_blog_single_post_social_share_links(),
			'el_class'		=> 'mb-0' ) 
		);
	}
	?>
</div>
