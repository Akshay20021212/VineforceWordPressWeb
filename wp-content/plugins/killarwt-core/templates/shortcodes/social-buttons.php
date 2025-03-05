<div <?php echo killarwt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( $display_type != 'widget' && !empty( $title ) ) { ?>
	<span class="sec-title fs-sm me-2"><?php echo $title ; ?></span>
	<?php } ?>
	<?php echo killarwt_js_remove_wpautop( $sec_content ); ?>
</div>