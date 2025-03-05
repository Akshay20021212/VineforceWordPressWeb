 <?php
/**
 * The template for displaying all posts and attachments
 *
 * @package KillarWT
 * @since 1.0.0
 */

get_header(); 

do_action( 'killar_before_main_content' );

do_action( 'killar_before_loop_post' );

while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/post-loop/layout', get_post_format() );

endwhile;

do_action( 'killar_after_loop_post' );

do_action( 'killar_loop_pagination' );

do_action( 'killar_after_main_content' );
	
get_footer();