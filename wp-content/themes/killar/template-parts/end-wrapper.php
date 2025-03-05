<?php
/**
 * After Content Wrapper
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
					<?php do_action( 'killar_after_content_inner' ); ?>
				</div>
				<?php do_action( 'killar_after_content' ); ?>
			</div>
			<?php do_action( 'killar_after_primary' ); ?>
		</div>
	</div>
<?php do_action( 'killar_after_content_wrap' ); ?>