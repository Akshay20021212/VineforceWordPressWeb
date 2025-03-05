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

if ( is_singular() && get_theme_mod( 'killar_blog_single_post_related', true ) != true )  {
	return '';
}
?>
<div class="entry-related-posts mt-60">
	<?php killarwt_post_related_posts(); ?>
</div>