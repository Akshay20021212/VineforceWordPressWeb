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
$view_type = killarwt_get_loop_prop( 'killar_blog_loop_view_type' );
if ( in_array( $view_type, array( 'list', 'modern' ) ) ) {
	$post_tags_ar = wp_get_post_tags($post->ID);
	$terms = get_the_terms( $post->ID, 'post_tag' );
	if ( !empty( $terms[0] ) ) {
		$link = get_term_link( $terms[0], 'post_tag' );
        if ( is_wp_error( $link ) ) {
            return $link;
        }
        $link = '<a href="' . esc_url( $link ) . '" rel="tag" class="theme-color">' . esc_html__( 'In ', 'killar' ) . $terms[0]->name . '</a>';
	}
	
	$read_time = '';
	if( $read_time_status = get_theme_mod( 'killar_blog_loop_post_readtime_with_tag', true ) ) {
		if( $time = killarwt_reading_time() ) {
			$read_time = '<span class="read-time"> - ' . esc_attr( killarwt_reading_time() ) . '</span>';
		}
	}
	
	if( !empty( $link ) ) {
		echo sprintf( '<p class="post-tag text-uppercase">%s%s</p>', $link, $read_time );
	}
?>
<?php } else { ?>
<div class="entry-tags"><span class="tags-label d-none"><?php esc_html_e( 'Tags: ', 'killar' ); ?></span><span class="tags-list"><?php echo get_the_tag_list('<span>', ', ', '</span>'); ?></span></div>
<?php } ?>