<div <?php echo killarwt_stringify_atts($args['wrap_atts']); ?>>
	<?php if ($display_type != 'widget' && !empty($args['sec_heading'])) { ?>
		<div class="sec-heading"><?php echo $args['sec_heading']; ?></div>
	<?php } ?>
	<div class="sec-content">
		<?php if (!empty($args['product_categories'])) { ?>
			<div <?php echo killarwt_stringify_atts($args['cat_wrap_atts']); ?>>
				<?php foreach ($args['product_categories'] as $category) {
					$cate_link = get_term_link($category, 'product_cat');
				?>
					<div <?php echo killarwt_stringify_atts($args['cat_item_atts']); ?>>
						<div class="category-wrap card border-0">
							<div class="category-image card-body p-3 rounded-4 gray-simple mb-3">
								<a href="<?php echo esc_url($cate_link); ?>">
									<?php
									$thumbnail_id         = get_term_meta($category->term_id, 'thumbnail_id', true);
									$image_size = '';
									if ($args['thumbnail_size'] == 'custom' && !empty($args['thumbnail_custom_dimension']['width']) && !empty($$args['thumbnail_custom_dimension']['height'])) {
										$image_size = $args['thumbnail_custom_dimension']['width'] . 'x' . $args['thumbnail_custom_dimension']['height'];
									} else {
										$image_size = $args['thumbnail_size'];
									}

									echo (!empty($thumbnail_id)) ? killarwt_get_image_html(array('attach_id' => $thumbnail_id, 'size' => $image_size)) :  '<img src="' . wc_placeholder_img_src()  . '" title="' . $category->name . '" />'
									?>
								</a>
							</div>
							<?php  ?>
							<?php if (!empty($args['show_category_title']) || !empty($args['show_category_product_count'])) { ?>
								<h3 class="woocommerce-loop-category__title">
									<?php
									if (!empty($args['show_category_title'])) {
										echo '<a href="' . esc_url($cate_link) . '">' . esc_html($category->name) . '</a>';
									}

									if (!empty($args['show_category_product_count']) && $category->count > 0) {
										echo sprintf(
											'<span class="product-count">%1$s</span>',
											sprintf(_n('%s Product', '%s Products', $category->count, 'killarwt-core'), $category->count)
										);
									}
									?>
								</h3>
							<?php } ?>
						</div>
					</div>
			<?php
				}
			} ?>
			</div>
	</div>
</div>