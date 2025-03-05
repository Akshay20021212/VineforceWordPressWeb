<div <?php echo killarwt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( !empty( $sec_heading ) && $display_type != 'widget'  ) { ?>
		<div class="sec-heading"><?php echo $sec_heading ; ?></div>
	<?php } ?>
	<div class="sec-content">
		<?php
		do_action( 'killar_before_loop_post' );
		
		$GLOBALS['display_type'] = $display_type;
	
		if( !empty( $query ) ) {
			
			while ( $query->have_posts() ) : $query->the_post();

				get_template_part( 'template-parts/post-loop/layout', '', $args );

			endwhile;
			
			wp_reset_postdata();
		}
		
		do_action( 'killar_after_loop_post' );
		?>
	</div>
</div>