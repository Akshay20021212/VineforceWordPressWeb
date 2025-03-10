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
?>
<div class="entry-meta post-data clearfix">
	<?php do_action( 'killarwt_before_blog_post_archive_meta' ); ?>
	
	<?php foreach ( $sections as $section ) :

		switch ( $section ) {
			case 'author': ?>	
				<div class="author">
					<div class="post-author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), '60' );  ?>
					</div>
					<div class="post-author">
						<?php echo sprintf( 'By %s', ucfirst( get_the_author() ) ); ?>
					</div>
				</div> <?php					
				break;
			case 'categories': 
				$categories_list = get_the_category_list( ', ' );
				if ( $categories_list ) {?>					
					<span class="meta-cats"><?php echo wp_kses_post($categories_list);?> </span><?php
				}
				break;
			case 'tags':
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ) {?>					
					<span class="meta-tags"><?php echo wp_kses_post($tags_list);?> </span><?php
				}
				break;
			case 'comments':				
				if( ! post_password_required() && ( comments_open() || get_comments_number() ) ){?>
					<span class="meta-comments">
						<?php 
						$comment_tag = '%s<span class="post-meta-label"> %s</span>';			
						comments_popup_link( 
							sprintf( $comment_tag, '0', esc_html__( 'Comments', 'killar' ) ),
							sprintf( $comment_tag, '1', esc_html__( 'Comment', 'killar' ) ),
							sprintf( $comment_tag, '%', esc_html__( 'Comments', 'killar' ) )
						);?>			
					</span><?php 
				}
				break;
			case 'date': ?>	
				<?php if( $post_style == 'fancy' ) { ?>
				<h5 class="text-uppercase grey-color"><a href="<?php echo esc_url( get_permalink() );?> "><?php echo get_the_date(); ?></a></h5>
				<?php } else { ?>
				<span class="meta-date">
					<a href="<?php echo esc_url( get_permalink() );?> "><?php echo get_the_date(); ?></a>
				</span>
				<?php }
				break;
			case 'reading-time': ?>					
				<span class="meta-reading-time">
					<?php echo esc_attr( killarwt_reading_time() ); ?>
				</span>	<?php					
				break;
			case 'edit':
				edit_post_link( sprintf(esc_html__( 'Edit ', 'killar' ) ), '<span class="meta-edit-link">', '</span>');
				break;
			
			default:				
		}
	endforeach; ?>		
	
	<?php do_action( 'killarwt_after_blog_post_archive_meta' ); ?>	
</div>