<?php
/**
 * Page Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'killarwt_before_page_content' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'killarwt_before_page_inner_content' ); ?>
	
	<?php do_action( 'killarwt_page_content' ); ?>
	
	<?php do_action( 'killarwt_after_page_inner_content' ); ?>
</article>
<?php do_action( 'killarwt_after_page_content' ); ?>