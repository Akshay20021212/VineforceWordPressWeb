<div <?php echo killarwt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( !empty($query->have_posts() ) && !empty( $sec_heading ) && $display_type != 'widget'  ) { ?>
		<h3 class="sec-heading"><?php echo strip_tags( $sec_heading ) ; ?></h3>
	<?php } ?>
	<?php
	do_action( 'killar_before_portfolio_loop_post' );

	if( !empty( $query ) ) {
		while ( $query->have_posts() ) : $query->the_post();

			get_template_part( 'template-parts/portfolio-loop/layout', get_post_format() );

		endwhile;
		
		wp_reset_postdata();
	}
	
	do_action( 'killar_after_portfolio_loop_post' );
	?>
</div>