<?php
/**
 * Displays author info
 *
 * @package KillarWT
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="entry-author-bio ">
	<div class="position-relative card border-0 w-100 d-inline-block bg-primary px-xl-5 px-lg-4 py-xl-5 py-lg-4 p-4 mt-2 mt-lg-3">
		<div class="author-avatar d-flex align-items-center justify-content-center pb-1 mb-3">
			<?php				
			$author_bio_avatar_size = apply_filters( 'killar_author_bio_avatar_size', 80 );
			echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size, '', '', array( 'class' => 'img-fluid circle' ) );
			?>
		</div>
		<div class="caption-author text-center mb-4">
			<h4 class="author-title mb-0 ">
				<a class="author-link text-light text-capitalize" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf(
					__( '%s', 'killar' ),
					esc_html( get_the_author() )
				); ?>
				</a>
			</h4>
			<p class="author-desc p-0 m-0 text-sm-muted text-light opacity-75 font--medium">
				<?php the_author_meta( 'description' ); ?>
			</p>
		</div>
		<div class="about-author text-center mb-4">
			<p class="fs-6 text-light">
				<?php the_author_meta( 'description' ); ?>
			</p>
		</div>
	</div>
</div>
