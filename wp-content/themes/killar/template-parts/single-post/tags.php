<?php
/**
 * Display Single Post Tags
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tags_list = get_the_tag_list(' ');
if ( empty( $tags_list ) ) return;
?>
<div class="entry-tags modal-tags d-sm-flex align-items-center pt-3"><span class="tags-label text-uppercase mb-0 pr-15 f-700"><?php esc_html_e( 'Tags: ', 'killar' ); ?></span><span class="tags-list post-tags-list"><?php echo wp_kses_post( get_the_tag_list('', ',&nbsp;', '') ); ?></span></div>
	