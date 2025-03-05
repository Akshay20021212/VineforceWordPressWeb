<?php
/**
 * Post Loop Layout
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$sections = killarwt_portfolio_loop_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}
global $items_count;
$view_type = killarwt_portfolio_loop_view_type();
$post_style = killarwt_get_loop_prop( 'killar_portfolio_loop_post_style' );
$nums_rows = killarwt_get_loop_prop( 'nums_rows' );
$read_more_style = killarwt_get_loop_prop( 'killar_portfolio_loop_post_read_more' );
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid-dark', 'grid-light', 'micro_grid' ) ) ) && $items_count % $nums_rows == 0 ) {
	echo wp_kses_post( '<div class="products">' );
}

$sub_atts = array();
$sub_atts['class'] = array( 'entry-post', 'portfolio-post' );

$content_args = array();
$content_args['class'] = array( 'entry-content-wrapper' );
if ( has_post_thumbnail() ) {
	if ( in_array( $view_type, array( 'list-light', 'list-dark' ) ) ) {
		$content_args['class'][] = 'col-xl-6 col-lg-6 col-md-12 col-sm-12 py-lg-0 py-4';
	} else if ( in_array( $view_type, array( 'modern' ) ) ) {
		$content_args['class'][] = 'col-xl-6 offset-lg-1 col-lg-6 col-md-6 col-12';	
	}
}

if ( in_array( $view_type, array( 'grid-dark', 'grid-light', 'gallery-filter-dark', 'gallery-filter-light' ) ) ) {
	$sub_atts['class'][] = 'gallery-image priocs rounded-4 bg-white p-3';
	$sub_atts['class'][] = ( in_array( $post_style, array( 'box3' ) ) ) ? '' : 'text-center';
} else {
	$sub_atts['class'][] = 'text-center gallery-image';
}

if ( in_array( $post_style, array( 'box1', 'box2' ) ) ) {

	$content_args['class'][] = 'project-over-content w-100 position-absolute left-0 ps-4 pe-4 pb-3 pt-4 z-1 text-white';
	if( in_array( $post_style, array( 'box2' ) ) ) {
		$content_args['class'][] = 'text-start';
	} else {
		$content_args['class'][] = 'text-center';
	}
} else if( in_array( $post_style, array( 'box3' ) ) ) {
	$sub_atts['class'][] = 'card border-0 rounded-3 p-2';
	$content_args['class'][] = 'crd-descr d-flex align-items-center justify-content-between p-1';
} else {
	
	if ( in_array( $view_type, array( 'list-light', 'list-dark' ) ) ) {
		$content_args['class'][] = 'text-start';
	} else {
		$content_args['class'][] = 'text-start pt-3 mt-lg-2 px-2';
	}
}
?>
<div <?php echo killarwt_portfolio_loop_post_atts(); ?>>
<?php
if( in_array( $post_style, array( 'box1' ) ) && !empty( $sections ) ) { ?>
	<div class="single-portfolio home3-single-project position-relative over-hidden">
		<div <?php echo killarwt_stringify_atts( $sub_atts ); ?>>
		<?php if ( in_array( $view_type, array( 'list-light', 'list-dark', 'modern' ) ) ) echo '<div class="row entry-post-inner d-flex align-items-center">'; ?>
		<?php echo ( in_array( 'thumbnail', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/thumbnail' ) : ''; ?>
		<div <?php echo killarwt_stringify_atts( $content_args ); ?>>
			<?php echo ( in_array( 'meta', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/meta' ) : ''; ?>
			<?php echo ( in_array( 'categories', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/categories' ) : ''; ?>
			<?php echo ( in_array( 'title', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/title' ) : ''; ?>
			<?php echo ( in_array( 'content', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/content' ) : ''; ?>
			<?php echo ( in_array( 'social-links', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/social-links' ) : ''; ?>
			<?php echo ( in_array( 'read-more', $sections ) && in_array( $read_more_style, array( 'link', 'button' ) )  ) ? get_template_part( 'template-parts/portfolio-loop/read-more' ) : ''; ?>
		</div>
		<?php echo ( in_array( 'read-more', $sections ) && !in_array( $read_more_style, array( 'link', 'button' ) )  ) ? get_template_part( 'template-parts/portfolio-loop/read-more' ) : ''; ?>
		<?php if ( in_array( $view_type, array( 'list-light', 'list-dark', 'modern' ) ) ) echo '</div>'; ?>
		</div>
	</div>
<?php } else if( in_array( $post_style, array( 'box2' ) ) && !empty( $sections ) ) { ?>
	<div class="single-portfolio home3-single-project position-relative over-hidden">
		<div <?php echo killarwt_stringify_atts( $sub_atts ); ?>>
		<?php if ( in_array( $view_type, array( 'list-light', 'list-dark', 'modern' ) ) ) echo '<div class="row entry-post-inner d-flex align-items-center">'; ?>
		<?php echo ( in_array( 'thumbnail', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/thumbnail' ) : ''; ?>
		<div <?php echo killarwt_stringify_atts( $content_args ); ?>>
			<?php echo ( in_array( 'meta', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/meta' ) : ''; ?>
			<?php echo ( in_array( 'categories', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/categories' ) : ''; ?>
			<?php echo ( in_array( 'title', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/title' ) : ''; ?>
			<?php echo ( in_array( 'content', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/content' ) : ''; ?>
			<?php echo ( in_array( 'social-links', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/social-links' ) : ''; ?>
			<?php echo ( in_array( 'read-more', $sections ) && in_array( $read_more_style, array( 'link', 'button' ) )  ) ? get_template_part( 'template-parts/portfolio-loop/read-more' ) : ''; ?>
		</div>
		<?php echo ( in_array( 'read-more', $sections ) && !in_array( $read_more_style, array( 'link', 'button' ) )  ) ? get_template_part( 'template-parts/portfolio-loop/read-more' ) : ''; ?>
		<?php if ( in_array( $view_type, array( 'list-light', 'list-dark', 'modern' ) ) ) echo '</div>'; ?>
		</div>
	</div>
<?php } else if( in_array( $post_style, array( 'box3' ) ) && !empty( $sections ) ) { ?>
	<div <?php echo killarwt_stringify_atts( $sub_atts ); ?>>
		<?php if ( in_array( $view_type, array( 'list-light', 'list-dark', 'modern' ) ) ) echo '<div class="row entry-post-inner d-flex align-items-center">'; ?>
		<?php echo ( in_array( 'thumbnail', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/thumbnail' ) : ''; ?>
		<div <?php echo killarwt_stringify_atts( $content_args ); ?>>
			<div class="crd-descr-start">
				<?php echo ( in_array( 'title', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/title' ) : ''; ?>
				<?php echo ( in_array( 'categories', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/categories' ) : ''; ?>
				<?php echo ( in_array( 'meta', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/meta' ) : ''; ?>
				<?php echo ( in_array( 'content', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/content' ) : ''; ?>
				<?php echo ( in_array( 'social-links', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/social-links' ) : ''; ?>
			</div>
			<div class="crd-descr-end">
				<?php echo ( in_array( 'read-more', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/read-more' ) : ''; ?>
			</div>
		</div>
		<?php if ( in_array( $view_type, array( 'list-light', 'list-dark', 'modern' ) ) ) echo '</div>'; ?>
	</div>
<?php } else { ?>
	
	<div <?php echo killarwt_stringify_atts( $sub_atts ); ?>>
	<?php if ( in_array( $view_type, array( 'list-light', 'modern' ) ) ) {
		echo '<div class="row justify-content-between align-items-center mb-xl-5 mb-lg-5 mb-md-4 mb-4">'; 
    } else if ( in_array( $view_type, array( 'list-dark' ) ) ) { 
		echo '<div class="row justify-content-between align-items-center mb-xl-5 mb-lg-5 mb-md-4 mb-4 bg-white mx-0 px-2 py-4 rounded-3">';
	}
	?>
	<?php		
		foreach ( $sections as $section ) :
	
				if ( $sections[0] == 'thumbnail' && $sections[1] == $section ) {
					echo '<div ' . killarwt_stringify_atts( $content_args ) . '>';
				}
				get_template_part( 'template-parts/portfolio-loop/'. $section  );
				
				if ( $sections[0] == 'thumbnail' && end( $sections ) == $section ) {
					echo '</div>';
				}
		endforeach; 
	?>
	<?php if ( in_array( $view_type, array( 'list-light', 'list-dark', 'modern' ) ) ) echo '</div>'; ?>
	</div>
<?php } ?>
</div>
<?php 
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid-dark', 'grid-light', 'micro_grid' ) ) ) && ( $items_count % $nums_rows == ( $nums_rows-1 ) || ( $items_count == ( $query->post_count - 1) ) ) ) {
	echo '</div>';
}
$items_count++;