<?php
/**
 * Displays the post entry categories
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$categories = get_the_category(get_the_ID());
if( !empty( $categories ) ) {
	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
	?>
	<div class="entry-categories post-categories cat-links post-title-tag mb-20">
	<?php foreach( $categories as $k => $category ) { ?>
		<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="btn btn-rounded btn-tra-gray btn-xs btn-htheme btn-no-shadow" rel="<?php echo esc_attr($rel);?>"><?php echo esc_html( $category->name ); ?></a>
	<?php } ?>
	</div>
<?php } ?>