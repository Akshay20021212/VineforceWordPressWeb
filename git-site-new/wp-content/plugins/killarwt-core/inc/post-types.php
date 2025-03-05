<?php
require_once( 'post-types/portfolio.php' );
require_once( 'post-types/layouts.php' );

/**
 *	Get content type labels
 */
function killarwt_posttype_labels( $singular_name, $name, $title = FALSE ) {
	if( !$title )
		$title = $name;
	
	return array(
		'name' 					=> $title,
		'singular_name' 		=> $singular_name,
		'add_new' 				=> __('Add New','killarwt-core'),
		'add_new_item' 			=> sprintf( __('Add New %s','killarwt-core'), $singular_name ),
		'edit_item' 			=> sprintf( __('Edit %s','killarwt-core'), $singular_name ),
		'new_item' 				=> sprintf( __('New %s','killarwt-core'), $singular_name ),
		'view_item' 			=> sprintf( __('View %s','killarwt-core'), $singular_name ),
		'search_items' 			=> sprintf( __('Search %s','killarwt-core'), $name ),
		'not_found' 			=> sprintf( __('No %s found','killarwt-core'), $name ),
		'not_found_in_trash' 	=> sprintf( __('No %s found in Trash','killarwt-core'), $name ),
		'parent_item_colon' 	=> '',
		'menu_name'            	=> $name,
		'featured_image' 		=> sprintf( __('%s Image','killarwt-core'), $singular_name ),
		'set_featured_image' 	=> sprintf( __('Set %s Image','killarwt-core'), $singular_name ),
		'remove_featured_image' => sprintf( __('Remove %s image','killarwt-core'), $singular_name ),
		'use_featured_image'	=> sprintf( __('Use as %s image','killarwt-core'), $singular_name ),
	);
}

/**
 *	Get texonomy labels
 */
function killarwt_texonomy_labels( $singular_name, $name ) {
	
	return array(
        'name'              => $name,
        'singular_name'     => $singular_name,
        'search_items'      => sprintf( __('Search %s','killarwt-core'), $name ),
        'all_items'         => sprintf( __('All %s','killarwt-core'), $name ),
        'view_item'         => sprintf( __('View %s','killarwt-core'), $singular_name ),
        'parent_item'       => sprintf( __('Parent %s','killarwt-core'), $singular_name ),
        'parent_item_colon' => sprintf( __('Parent %s','killarwt-core'), $singular_name ),
        'edit_item'         => sprintf( __('Edit %s','killarwt-core'), $singular_name ),
        'update_item'       => sprintf( __('Update %s','killarwt-core'), $singular_name ),
        'add_new_item'      => sprintf( __('Add New %s','killarwt-core'), $singular_name ),
        'new_item_name'     => sprintf( __('New %s Name','killarwt-core'), $singular_name ),
        'not_found'         => sprintf( __('No %s Found','killarwt-core'), $singular_name ),
        'back_to_items'     => sprintf( __('Back to %s','killarwt-core'), $singular_name ),
        'menu_name'         => sprintf( __('%s','killarwt-core'), $singular_name ),
    );
}