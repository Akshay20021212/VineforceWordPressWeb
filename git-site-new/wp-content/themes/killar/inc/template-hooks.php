<?php
/**
 * hooks.
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

/**
 * Extras
 */
add_filter( 'excerpt_length', 'killarwt_excerpt_length', 10 );

/*
 * Main Wrapper
 */
add_action( 'killar_before_main_content', 'killarwt_start_wrapper', 10 );
add_action( 'killar_after_main_content', 'killarwt_end_wrapper', 10 );
add_action( 'killar_before_body_end', 'killarwt_before_body_end', 10 );

/*
 * Blog/Post
 */
add_action( 'killar_before_loop_post', 'killarwt_before_loop_post', 10 );
add_action( 'killar_after_loop_post', 'killarwt_after_loop_post', 10 );
add_action( 'killar_after_loop_post', 'killarwt_after_loop_post_reset', 999 );
add_action( 'killar_loop_pagination', 'killarwt_blog_loop_post_pagination', 10 );

add_action( 'killar_post_header', 'killarwt_post_title', 20 );
add_action( 'killar_post_header', 'killarwt_post_meta', 30 );

add_action( 'killar_single_post', 'killarwt_post_header',	10 );
add_action( 'killar_single_post', 'killarwt_post_thumbnail',	20 );
add_action( 'killar_single_post', 'killarwt_post_content',	30 );
add_action( 'killar_single_post', 'killarwt_single_post_author_info',	40 );
add_action( 'killar_single_post', 'killarwt_post_tags', 50 );
add_action( 'killar_single_post', 'killarwt_post_social_links', 60 );
add_action( 'killar_single_post', 'killarwt_single_post_next_prev_links', 70 );
add_action( 'killar_single_post', 'killarwt_single_post_comments', 80 );


/*
 * Page
 */
add_action( 'killarwt_page_content', 'killarwt_template_page_content', 10 );

