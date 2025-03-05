<?php
/**
 * The template for displaying all single posts
 *
 * @package KillarWT
 * @since 1.0.0
 */
get_header();

do_action( 'killar_before_main_content' );

if ( have_posts() ) {

	do_action( 'killar_before_loop_page' );

	while ( have_posts() ) : the_post();
	
	?>
	<?php do_action( 'killarwt_before_page_content' ); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php do_action( 'killarwt_before_page_inner_content' ); ?>
		
		<?php do_action( 'killarwt_page_content' ); ?>
		
		<?php do_action( 'killarwt_after_page_inner_content' ); ?>

	</article>

	<?php do_action( 'killarwt_after_page_content' ); ?>
	<?php

	endwhile;

	do_action( 'killar_after_loop_page' );

	do_action( 'killar_loop_pagination' );

}

do_action( 'killar_after_main_content' );

get_footer();