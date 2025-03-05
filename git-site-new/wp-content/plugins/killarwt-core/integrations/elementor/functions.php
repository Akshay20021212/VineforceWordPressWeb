<?php
/**
 * Elementor functions file.
 *
 * @package killar
 */
use Elementor\Plugin;
use Elementor\Controls\Autocomplete;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'killarwt_get_taxonomies_title_by_id' ) ) {
	
	function killarwt_get_taxonomies_title_by_id() {
		$ids     = isset( $_POST['id'] ) ? $_POST['id'] : array(); 
		$results = array();

		$args = array(
			'include' => $ids,
		);

		$terms = get_terms( $args );

		if ( is_array( $terms ) && $terms ) {
			foreach ( $terms as $term ) {
				if ( is_object( $term ) ) {
					$results[ $term->term_id ] = $term->name . ' (' . $term->taxonomy . ')';
				}
			}
		}

		wp_send_json( $results );
	}

	add_action( 'wp_ajax_killar_get_taxonomies_title_by_id', 'killarwt_get_taxonomies_title_by_id' );
	add_action( 'wp_ajax_nopriv_killar_get_taxonomies_title_by_id', 'killarwt_get_taxonomies_title_by_id' );
}

if ( ! function_exists( 'killarwt_get_taxonomies_by_query' ) ) {

	function killarwt_get_taxonomies_by_query() {
		$search_string = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : '';
		$taxonomy      = isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : '';
		$results       = array();

		$args = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'search'     => $search_string,
		);

		$terms = get_terms( $args );

		if ( is_array( $terms ) && $terms ) {
			foreach ( $terms as $term ) {
				if ( is_object( $term ) ) {
					$results[] = array(
						'id'   => $term->term_id,
						'text' => $term->name . ' (' . $term->taxonomy . ')',
					);
				}
			}
		}

		wp_send_json( $results );
	}

	add_action( 'wp_ajax_killar_get_taxonomies_by_query', 'killarwt_get_taxonomies_by_query' );
	add_action( 'wp_ajax_nopriv_killar_get_taxonomies_by_query', 'killarwt_get_taxonomies_by_query' );
}

if (!function_exists('killarwt_get_posts_by_query')) {

	function killarwt_get_posts_by_query()
	{
		$search_string = isset($_POST['q']) ? sanitize_text_field(wp_unslash($_POST['q'])) : ''; 
		$post_type     = isset($_POST['post_type']) ? $_POST['post_type'] : 'post'; 
		$results       = array();

		$query = new WP_Query(
			array(
				's'              => $search_string,
				'post_type'      => $post_type,
				'posts_per_page' => -1,
			)
		);

		if (!isset($query->posts)) {
			return;
		}

		foreach ($query->posts as $post) {
			$results[] = array(
				'id'   => $post->ID,
				'text' => $post->post_title,
			);
		}

		wp_send_json($results);
	}

	add_action('wp_ajax_killar_get_posts_by_query', 'killarwt_get_posts_by_query');
	add_action('wp_ajax_nopriv_killar_get_posts_by_query', 'killarwt_get_posts_by_query');
}

if (!function_exists('killarwt_get_posts_title_by_id')) {

	function killarwt_get_posts_title_by_id()
	{
		$ids       = isset($_POST['id']) ? $_POST['id'] : array(); 
		$post_type = isset($_POST['post_type']) ? $_POST['post_type'] : 'post'; 
		$results   = array();

		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'post__in'       => $ids,
				'posts_per_page' => -1,
				'orderby'        => 'post__in',
			)
		);

		if (!isset($query->posts)) {
			return;
		}

		foreach ($query->posts as $post) {
			$results[$post->ID] = $post->post_title;
		}

		wp_send_json($results);
	}

	add_action('wp_ajax_killar_get_posts_title_by_id', 'killarwt_get_posts_title_by_id');
	add_action('wp_ajax_nopriv_killar_get_posts_title_by_id', 'killarwt_get_posts_title_by_id');
}

if (!function_exists('killar_get_taxonomies_by_query_autocomplete')) {
	/**
	 * Autocomplete by taxonomies.
	 *
	 * @since 1.0.0
	 */
	function killar_get_taxonomies_by_query_autocomplete()
	{
		$output = array();

		$args = array(
			'number'     => 5,
			'taxonomy'   => $_POST['value'], 
			'search'     => $_POST['params']['term'], 
			'hide_empty' => false,
		);

		$terms = get_terms($args);

		if (count($terms) > 0) { 
			foreach ($terms as $term) {
				$output[] = array(
					'id'   => $term->term_id,
					'text' => $term->name,
				);
			}
		}

		echo wp_json_encode($output);
		die();
	}

	add_action('wp_ajax_killar_get_taxonomies_by_query_autocomplete', 'killar_get_taxonomies_by_query_autocomplete');
	add_action('wp_ajax_nopriv_killar_get_taxonomies_by_query_autocomplete', 'killar_get_taxonomies_by_query_autocomplete');
}