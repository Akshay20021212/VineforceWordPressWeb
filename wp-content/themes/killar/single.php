 <?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package KillarWT
 * @since 1.0.0
 */

get_header(); 

do_action( 'killar_before_main_content' );

do_action( 'killar_before_single_post' );

while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/single-post/layout', get_post_type(), '', array( 'blog_type' => 'single' ) );

endwhile;

do_action( 'killar_after_single_post' );

do_action( 'killar_after_main_content' );

get_footer();