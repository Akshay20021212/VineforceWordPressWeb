<?php
/**
 * The template file for displaying the comments and comment form for the
 *
 * @package KillarWT
 * @since 1.0.0
 */
if ( post_password_required() ) {
	return;
}

if ( $comments ) {
	?>
	<div class="pt-4 mt-4" id="comments">
		<?php
		$comments_number = absint( get_comments_number() );
		?>
		<div class="comments-header section-inner small max-percentage">
			<h2 class="h2 text-dark py-lg-1">
			<?php
			if ( ! have_comments() ) {
				_e( 'Leave a comment', 'killar' );
			} elseif ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'killar' ), esc_html( get_the_title() ) );
			} else {
				echo sprintf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s comment',
						'%1$s comments',
						$comments_number,
						'comments title',
						'killar'
					),
					number_format_i18n( $comments_number ),
					esc_html( get_the_title() )
				);
			}
			?>
			</h2>
		</div>
		<div class="comments-list mt-5">
			<ol class="media-list no-list-style"><?php wp_list_comments( array( 'avatar_size' => 75, 'callback' => 'killarwt_comments', 'style' => 'ol', 'short_ping'  => true ) ); ?></ol>
			<?php
			$comment_pagination = paginate_comments_links(
				array(
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __( 'Newer Comments', 'killar' ) . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'killar' ),
				)
			);

			if ( $comment_pagination ) {
				$pagination_classes = '';

				// If we're only showing the "Next" link, add a class indicating so.
				if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) {
					$pagination_classes = ' only-next';
				}
				?>

				<nav class="comments-pagination pagination<?php echo esc_attr( $pagination_classes ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e( 'Comments', 'killar' ); ?>">
					<?php echo wp_kses_post( $comment_pagination ); ?>
				</nav>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}

if ( comments_open() || pings_open() ) {
	echo '<div class="card border-0 gray-simple pt-2 p-md-2 p-xl-3 p-xxl-4 mt-n3 mt-md-0 mb-4">';
	comment_form(
		array(
			'class_label' 		 => "form-label",
			'class_container'    => 'card-body',
			'class_form'         => 'row needs-validation g-4 comments-half-flds',
			'title_reply_before' => '<h2 id="reply-title" class="pb-2 pb-lg-3 pb-xl-4">',
			'title_reply_after'  => '</h2>',
		)
	);
	echo '</div>';

} elseif ( is_single() ) {

	if ( $comments ) {
		echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
	}
	?>
	<div class="comment-respond" id="respond">
		<p class="comments-closed"><?php _e( 'Comments are closed.', 'killar' ); ?></p>
	</div>
	<?php
}
