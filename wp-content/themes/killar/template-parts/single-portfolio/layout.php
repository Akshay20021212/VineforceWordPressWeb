<?php
/**
 * Portfolio Single Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$sections = killarwt_portfolio_single_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}
$classes[] = 'item-entry';
$classes[] = 'single_portfolio';
$classes[] = 'single-portfolio-wrapper';
$classes[] = 'single-post-txt';
if( !empty( $portfolio_single_layout = killarwt_get_post_meta( 'portfolio_single_layout' ) ) ) $classes[] = 'post-layout-'. $portfolio_single_layout;
?>
<?php do_action( 'killarwt_before_single_portfolio_content' ); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div id="single-portfolio" class="entry-post">
	<?php do_action( 'killarwt_before_single_portfolio_inner_content' ); ?>
	<?php
		foreach ( $sections as $section ) :
			if ( $section == 'skills' && in_array( 'social-links', $sections ) ) {
				$skills_key = array_search( 'skills', $sections );
				if ( !empty( $skills_key ) && $sections[$skills_key+1] == 'social-links' ) {
					echo '<div class="entry-share-links post-share-links d-flex align-items-center justify-content-md-between">';
				}
			}
			
			get_template_part( 'template-parts/single-portfolio/'. $section  );
			
			if ( $section == 'social-links' && in_array( 'skills', $sections ) ) {
				$social_links_key = array_search( 'social-links', $sections );
				if ( !empty( $social_links_key ) && $sections[$social_links_key-1] == 'skills' ) {
					echo '</div>';
				}
			}
		endforeach; 
	?>		
	<?php do_action( 'killarwt_after_single_portfolio_inner_content' ); ?>
	</div>
</div>
<?php do_action( 'killarwt_after_single_portfolio_content' ); ?>