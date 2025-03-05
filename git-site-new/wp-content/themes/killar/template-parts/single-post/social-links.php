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
		echo wp_kses_post( social_buttons( array(
			'display_type'	=> 'shortcode',
			'title' 		=> ( apply_filters( 'killar_social_share_links_title', get_theme_mod( 'killar_social_share_links_title', 'true' ) ) ) ? esc_attr( 'Share post :', 'killar' ) : '' ,
			'social_type' 	=> 'share',
			'social_links'	=> ctm_killar_blog_single_post_social_share_links(),
			'item_el_classes'	=> 'text-muted me-2',
			'el_classes'		=> '',
			'wrap_el_classes' => 'blog-page-social-link d-flex align-items-center mb-4'
			) 
		) );
	}
	?>
</div>
