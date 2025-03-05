<?php
/**
*	Register layout content type
*/
function killarwt_layout_post_type() {
	
	$singular_name = get_option('layout-singular-name', 'Layout');
	$name = get_option('layout-name', 'Layouts');
	$slug = get_option('layout-slug', 'layout');
	$category_name = sprintf( __('%s Groups','killarwt-core'), $singular_name );
	$categories_name = sprintf( __('%s Groups','killarwt-core'), $singular_name );
	$category_slug = get_option('killar-layout-groups', 'layout-group');
	
	$args = array(
		'labels' 				=> killarwt_posttype_labels( $singular_name, $name ),
		'menu_icon'				=> 'dashicons-editor-kitchensink',
		'public' 				=> true,
		'has_archive' 			=> true,
		'with_front'            => true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export' 			=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'show_in_menu' 			=> true,
		'show_in_rest' 			=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'killarwt_core_layout_slug', $slug ) ),
		'supports' 				=> array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'elementor' ),
	);
	
	register_post_type( 'layout', $args );
	
	register_taxonomy( 'layout-group', 'layout', array(
		'hierarchical' 			=> true,
		'labels' 				=> killarwt_texonomy_labels( $category_name, $categories_name ),
		'exclude_from_search' 	=> true,
		'public' 				=> true,
		'show_ui' 				=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'killarwt_core_layout_group_slug', $category_slug ) ),
		'menu_icon' 			=> 'dashicons-editor-kitchensink',
		'supports' 				=> array('title', 'editor'),
		'query_var' 			=> true,
		'show_in_nav_menus' 	=> false,
		'show_admin_column'     => true,
		'show_tagcloud'         => true,
		'show_in_rest'			=> true,
	) );
}	
add_action( 'init', 'killarwt_layout_post_type' );

if ( ! function_exists( 'killarwt_layout_meta_boxes' ) ) {
	
	function killarwt_layout_meta_boxes() {
				
		$meta_boxes = array();
		
		$layouts = array( 'default' => esc_html__( 'Default', 'killarwt-core' ), 'hidden' => esc_html__( 'Hidden', 'killarwt-core' ) ) + killarwt_get_post_type_posts( array( 'post_type' => 'layout' ) );
		
		// Post format's meta box
		$meta_boxes[] = array(
			'id'      		=> KILLARWT_PREFIX.'kwt_layout_options',
			'title'    		=> esc_html__( 'Killar Options', 'killarwt-core' ),
			'tabs'      	=> array(
								'general'			=> 'General',
							),
			'tab_style' => 'left',
			'tab_wrapper' 	=> true,
			'pages'			=> array( 'layout'),
			'context'  		=> 'normal',
			'priority' 		=> 'high',
			'autosave' 		=> true,
			'fields'   		=> array(
				array(
					'type' 			=> 'heading',
					'tab'			=> 'general',
					'name' 			=> 'General Settings',
				),
				array(
					'name'    		=> esc_html__( 'Type', 'killarwt-core' ),
					'id'      		=> KILLARWT_PREFIX.'layout_page_layout',
					'type'    		=> 'select_advanced',
					'std'			=> 'default',
					'options' 		=> array(
										'custom' 		=> esc_html__( 'Custom', 'killarwt-core' ),
										'megamenu' 		=> esc_html__( 'Mega Menu', 'killarwt-core' ),
										'header_right' 	=> esc_html__( 'Header Right', 'killarwt-core' ),
										'mobile' 		=> esc_html__( 'Mobile', 'killarwt-core' ),
										'advance_navigation' 	=> esc_html__( 'Advance Navigation', 'killarwt-core' ),
										'footer' 				=> esc_html__( 'Footer', 'killarwt-core' ),
										'newsletter_popup' 		=> esc_html__( 'Newsletter Popup', 'killarwt-core' ),
									),
					'tab'			=> 'general',
				),
			),
		);

		return apply_filters( 'killar_layout_meta_boxes', $meta_boxes );
	}
	
	add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
		$killarwt_layout_meta_boxes = killarwt_layout_meta_boxes();
		if ( !empty( $killarwt_layout_meta_boxes ) ) {
			$meta_boxes = array_merge( $meta_boxes, $killarwt_layout_meta_boxes );
		}
		return $meta_boxes;
	} );
	
	add_filter( 'killar_metaboxes_post_types_scripts', function ( $post_types ) {
		$killarwt_layout_meta_boxes = killarwt_layout_meta_boxes();
		if ( !empty( $killarwt_layout_meta_boxes ) ) {
			$post_types[] = 'layout';
		}
		return $post_types;
	} );	
}


if ( ! function_exists( 'killarwt_layout_posts_columns' ) ) {
	
	// Add the custom columns to the layout post type:
	add_filter( 'manage_layout_posts_columns', 'killarwt_layout_posts_columns' );
	function killarwt_layout_posts_columns( $columns ) {
		
		unset( $columns['author'] );
		$columns['type'] = __( 'Type', 'killarwt-core' );
		$columns['shortcode'] = __( 'Shortcode', 'killarwt-core' );

		return $columns;
	}
}

if ( ! function_exists( 'killarwt_layout_posts_custom_column' ) ) {
	
	// Add the data to the custom columns for the layout post type:
	add_filter( 'manage_layout_posts_custom_column', 'killarwt_layout_posts_custom_column', 1, 2 );
	function killarwt_layout_posts_custom_column( $column, $post_id ) {
		switch ( $column ) {
			case 'type' :
				echo get_post_meta( $post_id , KILLARWT_PREFIX.'layout_page_layout' , true ); 
				break;
			case 'shortcode' :
				echo sprintf( __('<input type="text" readonly="readonly" value="[killar_layout id=&quot;%s&quot;]" style="min-width:200px;" />', 'killarwt-core'), $post_id );
				break;
		}
	}
}