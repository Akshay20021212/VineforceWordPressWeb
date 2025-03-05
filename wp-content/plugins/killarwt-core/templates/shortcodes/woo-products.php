<div <?php echo killarwt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( $display_type != 'widget' && !empty( $args['sec_heading'] )  ) { ?>
		<div class="sec-heading"><?php echo $args['sec_heading'] ; ?></div>
	<?php } ?>
	<div class="sec-content">
		<?php
		
		woocommerce_product_loop_start();

		while ( $query->have_posts() ) : $query->the_post();

			if( in_array($product_style, array( 'full-info' ) ) ) {
				killarwt_get_template('woocommerce/content-product-full-info', $args);
			} else {
				wc_get_template_part('content', 'product');
			}

		endwhile;
		
		wp_reset_postdata();
		killarwt_reset_loop();
		?>
	</div>
</div>