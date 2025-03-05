<?php
/**
 * The template for displaying all single posts and attachments
 * Template Name: Portfolio Archive
 * 
 * @package KillarWT
 * @since 1.0.0
 */

get_header();

do_action( 'killar_before_main_content' );

if ( have_posts() ) {
	
	do_action( 'killar_before_portfolio_loop_post' );

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/portfolio-loop/layout', get_post_format() );

	endwhile;

	do_action( 'killar_after_portfolio_loop_post' );
	
	do_action( 'killar_portfolio_loop_pagination' );

} else {
	
	get_template_part( 'template-parts/portfolio-loop/content', 'none' );

}

do_action( 'killar_after_main_content' );

get_footer();