<?php
/**
 * Displays the post entry highlight
 *
 * @package KillarWT
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sections	=  killarwt_blog_post_meta();
$post_style	=  killarwt_get_loop_prop( 'killar_blog_loop_post_style' );

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}

$wrap_attr = array();
$wrap_attr['class'] = array( 'entry-meta no-list-style blog-page-content-info d-flex align-items-center' );
$wrap_attr['class'][] = ( !in_array( $post_style, array( 'box' )  ) ) ? 'text-muted' : '';
$post_style
?>
<ul <?php echo killarwt_stringify_atts( $wrap_attr ); ?>>
	
	<?php do_action( 'killarwt_before_blog_post_archive_meta' ); ?>
	
	<?php foreach ( $sections as $section ) :

		switch ( $section ) {
			case 'author': ?>
				<li class="post-author author-icon">
				<?php echo sprintf( '<span class="aname">%s</span>', ucfirst( get_the_author() ) ); ?>
				</li>
				<?php					
				break;
			case 'categories': 
				$categories_list = get_the_category_list( ', ' );
				if ( $categories_list ) {?>					
					<li class="meta-cats color-inherit"><?php echo wp_kses_post($categories_list);?> </li><?php
				}
				break;
			case 'tags':
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ) {?>					
					<li class="meta-tags"><?php echo wp_kses_post($tags_list);?> </li><?php
				}
				break;
			case 'comments':				
				if( ! post_password_required() && ( comments_open() || get_comments_number() ) ){?>
					<li class="meta-comments">
						<?php 
						$comment_tag = '%s<span class="post-meta-label"> %s</span>';			
						comments_popup_link( 
							sprintf( $comment_tag, '0', esc_html__( 'Comments', 'killar' ) ),
							sprintf( $comment_tag, '1', esc_html__( 'Comment', 'killar' ) ),
							sprintf( $comment_tag, '%', esc_html__( 'Comments', 'killar' ) )
						);?>			
					</li><?php 
				}
				break;
			case 'date':				
				echo '<li>' . get_the_date() .'</li>';
				break;
			case 'reading-time':
				echo '<li class="meta-reading-time">' . esc_attr( killarwt_reading_time() ) . '</li>';
				break;
			case 'edit':
				edit_post_link( sprintf(esc_html__( 'Edit ', 'killar' ) ), '<li class="meta-edit-link">', '</li>');
				break;
			
			default:				
		}
	endforeach; ?>		
	
	<?php do_action( 'killarwt_after_blog_post_archive_meta' ); ?>	
	
</ul>