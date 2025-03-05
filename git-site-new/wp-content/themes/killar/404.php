<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Killar
 * @since Killar 1.0
 */

get_header();
?>
<div class="content-wrap error-area">
	<section class="section pb-0">
		<div class="container">	
			<div class="row justify-content-center">
				<div class="col-xl-8  col-lg-9  col-md-10  col-sm- col- text-center">
					<h1 class="extra-ft">4<span class="text-primary">0</span>4</h1>
					<?php if( $heading = get_theme_mod( 'killar_pages_404page_heading_text', esc_html__('Page Not Found', 'killar') ) ) { ?>
					<h1 class="display-1 font--bold mb-4"><?php echo esc_html( $heading ); ?></h1>
					<?php } ?>
					<?php if( $content = get_theme_mod( 'killar_pages_404page_content', esc_html__('The page you are looking for was moved, removed or might never existed.', 'killar') ) ) { ?>
					<p class="h5-lg mb-50 fs-5 pb-4 mb-0 mb-sm-2 mb-4"><?php echo esc_html( $content ); ?></p>
					<?php } ?>
					<div class="mb-4"><?php get_search_form(); ?></div>
					<?php if( $button = get_theme_mod( 'killar_pages_404page_button_text', esc_html__('Back to Home', 'killar') ) ) { ?>
					<a href="<?php echo esc_url( get_home_url() ); ?>" class="btn btn-lg btn-primary rounded-3 px-5"><?php echo wp_kses_post( $button ); ?></a>
					<?php } ?>
				</div>
			</div>	  
		</div>	
	</section>
</div>
<?php wp_footer(); ?>