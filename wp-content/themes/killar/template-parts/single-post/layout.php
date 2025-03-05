<?php
/**
 * Post Single Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$blog_view_type = 'single';

$sections = killarwt_blog_single_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}
$classes[] = 'item-entry';
$classes[] = 'single-post';
$classes[] = 'single-post-wrapper';
$classes[] = 'single-post-txt';
if( !empty( $post_single_layout = killarwt_get_post_meta( 'post_single_layout' ) ) ) $classes[] = 'post-layout-'. $post_single_layout;
?>

<?php do_action( 'killarwt_before_single_post_content' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div id="single-post" class="entry-post">
	<?php do_action( 'killarwt_before_single_post_inner_content' ); ?>
	<?php
	foreach ( $sections as $section_key => $section ) :
		if ( in_array( $section, array( 'meta', 'tags' ) ) && in_array( 'social-links', $sections ) ) {
			$sectoin_key = array_search( $section, $sections );
			if ( ( !empty( $sectoin_key ) && $sections[$sectoin_key+1] == 'social-links' ) ) {
				echo wp_kses_post( '<div class="entry-tags-share-links post-share-links blog-page-footer border-bottom pt-1 pb-4 d-xl-flex align-items-center justify-content-between">' );
			}
		}
		
		get_template_part( 'template-parts/single-post/'. $section  );
		
		if ( $section == 'social-links' && ( in_array( 'meta', $sections ) || in_array( 'tags', $sections ) ) ) {
			$social_links_key = array_search( 'social-links', $sections );
			if ( !empty( $social_links_key ) && in_array( $sections[$social_links_key-1], array( 'meta', 'tags' ) ) ) {
				echo wp_kses_post( '</div>' );
			}
		}
	endforeach; 
	?>		
	<?php do_action( 'killarwt_after_single_post_inner_content' ); ?>
	</div>
</article>
<?php do_action( 'killarwt_after_single_post_content' ); ?>