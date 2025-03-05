<?php
/**
 * Template Name: Onepage Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in prestige consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
get_header();

do_action( 'killar_before_content_wrap' );

if ( have_posts() ) {

	do_action( 'killar_before_loop_page' );

	while ( have_posts() ) : the_post();
		
		do_action( 'killarwt_before_page_content' );
		
		do_action( 'killarwt_before_page_inner_content' );
		
		do_action( 'killarwt_page_content' );
		
		do_action( 'killarwt_after_page_inner_content' );
		
		do_action( 'killarwt_after_page_content' );
		
	endwhile;

	do_action( 'killar_after_loop_page' );
}

do_action( 'killar_after_content_wrap' );

get_footer();